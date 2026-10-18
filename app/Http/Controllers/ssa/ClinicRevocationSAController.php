<?php

namespace App\Http\Controllers\ssa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\clinic\ClinicRevocation;
use App\Models\clinic\ClinicSuspension;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\Admin\user;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;



class ClinicRevocationSAController extends Controller
{
    
    public function revocationClinicList($encryptedClinicType)
    {
        if (!Session::has('id')) {
                return redirect()->route('admin.loginssaform');
            }

        try {
            $clinicTypeValue = Crypt::decryptString($encryptedClinicType);
        } catch (\Exception $e) {
            abort(404, 'Invalid clinic type');
        }

        // $pageTitle = [
        //     'ARTCLINIC'    => 'ART Clinic Revocation Applications',
        //     'ARTBANK'      => 'ART Bank Revocation Applications',
        //     'ARTSURROGACY' => 'Surrogacy Clinic Revocation Applications',
        // ][$clinicTypeValue] ?? 'Clinic Revocation Applications';

        $stateName = Session::get('state_name');

        $clinicForms = ClinicRegistrationModel::from('clinic_registration as cr')
            ->whereIn('cr.id', function ($query) use ($stateName, $clinicTypeValue) {
                $query->from('clinic_registration')
                    ->selectRaw('MAX(id)')
                    ->where('state', $stateName)
                    ->where('status', 3)
                    ->where('application_type', 6)
                    ->groupBy('clinic_id');
            })
            ->whereExists(function ($query) {
                $query->selectRaw(1)
                    ->from('clinic_suspension_applications as csa')
                    ->whereColumn('csa.clinic_id', 'cr.clinic_id')
                    ->whereColumn('csa.clinic_type', 'cr.clinic_type')
                    ->where('csa.appstatus', 'Suspended')
                    ->where('csa.status', 1);
            })->orderByDesc('cr.id')->get();

        return view('clinic_revocation.clinic_list', compact(
            'clinicForms',
            'clinicTypeValue'
            // 'pageTitle'
        ));
    }

    public function revocationForm($encryptedClinicId)
    {

        if (!Session::has('id')) {
            return redirect()->route('admin.loginssaform');
        }

        try {
            $clinicId = Crypt::decryptString($encryptedClinicId);
        } catch (\Exception $e) {
            abort(404, 'Invalid Clinic ID');
        }
        $stateName = Session::get('state_name');
        $todayDate = Carbon::today()->toDateString();
        $application = ClinicRegistrationModel::with('suspension_application')
            ->where('clinic_id', $clinicId)
            ->where('state', $stateName)
            ->where('status', 0)
            ->latest('id')
            ->first();

        $clinicTypeValue = $application->clinic_type;

        $login_details = User::find(Session::get('id'));


        $clinicTypeValueaname = [
            'ARTSURROGACY' => 'Surrogacy Clinic Suspension Applications',
            'ARTCLINIC'    => 'ART Clinic Suspension Applications',
            'ARTBANK'      => 'ART Bank Suspension Applications',
        ];

        $pageTitle = $clinicTypeValueaname[$clinicTypeValue] ?? 'Clinic Suspension Applications';

        return view('clinic_revocation.revocation_form', compact(
            'application',
            'clinicTypeValue',
            'encryptedClinicId',
            'pageTitle',
            'todayDate',
            'login_details'
        ));
    }

    public function submitRevocation(Request $request, $encryptedClinicId)
    {

        try {

            $clinicId = Crypt::decryptString($encryptedClinicId);
            $userId   = Session::get('id');
            $state    = Session::get('state_name');

            if (!$userId) {
                return redirect()->route('clinic.loginclinicform');
            }

            // Validation
            $validator = Validator::make($request->all(), [
                'reason'                      => 'required|string|max:255',
                'reason_details'              => 'required|string|max:2000',
                'authorized_name'             => 'required|string|max:255',
                'authorized_designation'      => 'required|string|max:255',
                'email'                       => 'required|email|max:255',
                'auth_date'                   => 'required|date',
                'revocation_order_document'   => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // dd($clinicId, $request->clinic_type, $state);

            // $clinicData = ClinicRegistrationModel::where([
            //         'clinic_id' => $clinicId,
            //         'clinic_type' => $request->clinic_type,
            //         'state'     => $state,
            //         'status'    => 0,
            //     ])
            //     ->whereExists(function ($query) {
            //         $query->selectRaw(1)
            //             ->from('clinic_suspension_applications as csa')
            //             ->whereColumn('csa.clinic_id', 'clinic_registration.clinic_id')
            //             ->whereColumn('csa.clinic_type', 'clinic_registration.clinic_type')
            //             ->where('csa.appstatus', 'Suspended')
            //             ->where('csa.status', 1);
            //     })
            //     ->latest('id')
            //     ->first();

            $clinicData = ClinicRegistrationModel::select(
                'clinic_registration.*',
                'csa.applicationno as suspension_application_no'
            )
            ->join('clinic_suspension_applications as csa', function ($join) {
                $join->on('csa.clinic_id', '=', 'clinic_registration.clinic_id')
                     ->on('csa.clinic_type', '=', 'clinic_registration.clinic_type');
            })
            ->where([
                'clinic_registration.clinic_id' => $clinicId,
                'clinic_registration.status' => 3, //Suspended
                'clinic_registration.application_type' => 6, //Suspended
                'clinic_registration.clinic_type' => $request->clinic_type,
                'clinic_registration.state' => $state,
                'csa.appstatus' => 'Suspended',
                'csa.status' => 1,
            ])
            ->latest('clinic_registration.id')
            ->first();
            if (!$clinicData) {
                return back()->with('error', 'Clinic not found or not under suspension.');
            }

            DB::beginTransaction();

            // Generate Application No
            $lastApplication = ClinicRevocation::where('status', 1)
                ->latest()
                ->first();

            $stateCode = DB::table('state')
                ->where('state_name', $clinicData->state)
                ->value('state_abb');

            $clinicTypeCode = match ($clinicData->clinic_type) {
                'ARTSURROGACY' => 'SC',
                'ARTBANK'      => 'AB',
                default        => 'AC',
            };

            $year = now()->year;

            $nextNumber = 10001;

            if ($lastApplication && !empty($lastApplication->applicationno)) {
                $nextNumber = ((int) substr($lastApplication->applicationno, -5)) + 1;
            }

            $applicationNo = sprintf(
                '%s/%s/RV/%s/%05d',
                $stateCode,
                $clinicTypeCode,
                $year,
                $nextNumber
            );            // Upload document
            $fileName = $this->handleFileUpload(
                $request,
                'revocation_order_document',
                'revocation_order',
                $applicationNo
            );

            // Save revocation
            $revocation = ClinicRevocation::create([
                'clinic_id'                => $clinicData->clinic_id,
                'registration_no'          => $clinicData->registration_no,
                'applicationno'            => $applicationNo,
                'clinic_name'              => $clinicData->name,
                'clinic_type'              => $clinicData->clinic_type,
                'address'                  => $clinicData->address,
                'pincode'                  => $clinicData->pincode,
                'state'                    => $clinicData->state,
                'district'                 => $clinicData->district,
                'userid'                   => $userId,

                'revocation_date'          => now(),
                'revocation_reason'        => $request->reason,
                'revocation_description'   => $request->reason_details,

                'authorized_signatory'     => $request->authorized_name,
                'designation'              => $request->authorized_designation,
                'email'                    => $request->email,
                'auth_date'                => $request->auth_date,

                'revocation_order_document'=> $fileName,
                'sus_application_id'=> $request->sus_application_id,

                'appstatus'                => 'Revocation',
                'status'                   => 1,

                'created_by'               => $userId,
                'updated_by'               => $userId,
            ]);

            $latestRecord = ClinicRegistrationModel::where([
                'clinic_id'        => $clinicId,
                'state'            => $state,
                'clinic_type'      => $request->clinic_type,
                'status'           => 3,
                'application_type' => 6,
            ])
            ->latest('id')
            ->first();

            if ($latestRecord) {
                $newRegistration = $latestRecord->replicate();

                $newRegistration->state_authority_id = $userId;
                $newRegistration->last_updated_by = $userId;
                $newRegistration->action_taken_ssa_datetime = now();
                $newRegistration->status = 1;
                $newRegistration->application_type = 7;
                $newRegistration->application_no = $applicationNo;
                $newRegistration->ip_address = $request->ip();
                $newRegistration->timestamps = false;

                $newRegistration->save();

                $latestRecord->update([
                    'status' => 0,
                ]);
            }

            DB::commit();

            return redirect()->route(
                'revocation.sa.clinic_list',
                [
                    'encryptedClinicId' => Crypt::encryptString($clinicData->clinic_type)
                ]
            )->with('success', 'Revocation submitted successfully.');

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Revocation Error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return back()->with('error', 'Something went wrong.');
        }
    }

    private function handleFileUpload(Request $request, $fieldName, $prefix, $applicationNo)
    {
        if (!$request->hasFile($fieldName)) {
            return null;
        }

        $file = $request->file($fieldName);

        if (!$file->isValid()) {
            throw new \Exception("Uploaded {$fieldName} is invalid.");
        }

        $folder = folderpath('application_sa') . str_replace('/', '_', $applicationNo);

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension());

        $fileName = sprintf(
            '%s_%s_%s.%s',
            $prefix,
            now()->format('YmdHis'),
            uniqid(),
            $extension
        );

        $file->move($folder, $fileName);

        return $fileName;
    }

}