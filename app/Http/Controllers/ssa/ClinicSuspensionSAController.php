<?php

namespace App\Http\Controllers\ssa;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\Admin\user;

use App\Models\clinic\ClinicSuspension;
use App\Models\clinic\ClinicRegistrationModel;
use Illuminate\Validation\ValidationException;



class ClinicSuspensionSAController extends Controller
{        
    public function clinicList($encryptedClinicType)
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
        //     'ARTCLINIC'    => 'ART Clinic Suspension Applications',
        //     'ARTBANK'      => 'ART Bank Suspension Applications',
        //     'ARTSURROGACY' => 'Surrogacy Clinic Suspension Applications',
        // ][$clinicTypeValue] ?? 'Clinic Suspension Applications';

        $stateName = Session::get('state_name');

        $clinicForms = ClinicRegistrationModel::where('state', $stateName)
            // ->where('clinic_type', $clinicTypeValue)
            ->where('status', 1)
            ->get();

        return view('clinic_suspension.clinic_list', compact(
            'clinicForms',
            'clinicTypeValue'
            // 'pageTitle'
        ));
    }

    public function suspensionForm($encryptedClinicId)
    {
        if (!Session::has('id')) {
            return redirect()->route('admin.loginssaform');
        }

        $login_details = User::find(Session::get('id'));

        try {
            $clinicId = Crypt::decryptString($encryptedClinicId);
        } catch (\Exception $e) {
            abort(404, 'Invalid Clinic ID');
        }
        $stateName = Session::get('state_name');
        $todayDate = Carbon::today()->toDateString();
        $application = ClinicRegistrationModel::where('clinic_id', $clinicId)
            ->where('state', $stateName)
            ->where('status', 1)
            ->first();

        if (!$application) {
            return redirect()->route('ssa.dashboard')
                ->with('error', 'Clinic record not found.');
        } 
        $clinicTypeValue = $application->clinic_type;

        return view('clinic_suspension.suspension_form', compact(
            'application',
            'clinicTypeValue',
            'encryptedClinicId',
            'todayDate',
            'login_details'
        ));
    }

    public function submitSuspension(Request $request, $encryptedClinicId)
    {
        // dd($request->all(), $encryptedClinicId);
        try {

            DB::beginTransaction();

            $clinicId = Crypt::decryptString($encryptedClinicId);

            $userId = Session::get('id');

            if (!$userId) {
                return redirect()->route('clinic.loginclinicform');
            }

            $clinicData = ClinicRegistrationModel::where([
                'clinic_id' => $clinicId,
                'clinic_type' => $request->clinic_type,
                'status' => 1
            ])->first();

            if (!$clinicData) {
                return redirect()->back()->with('error', 'Clinic record not found.');
            }

            $validated = $request->validate([
                'reason'                    => 'required|string|max:255',
                'reason_details'            => 'required|string|max:1000',
                'action_type'               => 'required|in:Suspension,Cancellation',
                'suspension_from_date'      => 'required|date',
                'suspension_to_date' => 'required_if:action_type,Suspension|nullable|date|after_or_equal:suspension_from_date',
                'authorized_name'           => 'required|string|max:255',
                'authorized_designation'    => 'required|string|max:255',
                'email'                       => 'required|email|max:255',
                'auth_date'                 => 'required|date',
                'suspension_order_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            if ($validated['action_type'] === 'Cancellation') {
                $validated['suspension_to_date'] = null;
            }

            $lastApplication = ClinicSuspension::where('status', 1)
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
                '%s/%s/SP/%s/%05d',
                $stateCode,
                $clinicTypeCode,
                $year,
                $nextNumber
            );

            $documentPath = $this->handleFileUploads($request, $applicationNo);

            $suspension = ClinicSuspension::create([

                'clinic_id'                 => $clinicData->clinic_id,
                'registration_no'           => $clinicData->registration_no,
                'applicationno'             => $applicationNo,
                'userid'                    => $userId,

                'clinic_name'               => $clinicData->name,
                'clinic_type'               => $clinicData->clinic_type,
                'address'                   => $clinicData->address,
                'district'                  => $clinicData->district,
                'state'                     => $clinicData->state,
                'pincode'                   => $clinicData->pincode,

                'application_date'          => now(),
                'suspension_date'           => now(),

                'suspension_reason'         => $validated['reason'],
                'suspension_description'    => $validated['reason_details'],

                'authorized_signatory'      => $validated['authorized_name'].' ('.$validated['authorized_designation'].')',

                'suspension_from_date'      => $validated['suspension_from_date'],
                'suspension_to_date' => $validated['suspension_to_date'] ?? null,                
                'suspension_order_document' => $documentPath,

                'appstatus'                 => 'Suspended',
                'status'                    => 1,
                'suspension_cancellation'   => $validated['action_type'],

                'created_by'                => $userId,
            ]);

            $this->insertSuspensionData($clinicData, $applicationNo, $validated['action_type']);

            DB::commit();

           return redirect()->route(
                'suspension.sa.clinic_list',
                ['encryptedClinicId' => Crypt::encryptString($clinicData->clinic_type)]
                    )->with('success',$validated['action_type'] == 'Cancellation'
                    ? 'Cancellation order issued successfully'
                    : 'Suspension order issued successfully'
            );
        } catch (ValidationException $e) {

            DB::rollBack();

            throw $e;   // Let Laravel handle validation errors
        } catch (\Throwable $e) {

                DB::rollBack();

                Log::error('Clinic Suspension Error', [
                    'user_id'        => Session::get('id'),
                    'clinic_id'      => $clinicId ?? null,
                    'application_no' => $applicationNo ?? null,
                    'message'        => $e->getMessage(),
                    'file'           => $e->getFile(),
                    'line'           => $e->getLine(),
                    'trace'          => $e->getTraceAsString(),
                ]);

                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Unable to process your request. Please try again later.');
            }
    }

    private function handleFileUploads(Request $request, $applicationNo)
    {
        if (!$request->hasFile('suspension_order_document')) {
            return null;
        }

        $file = $request->file('suspension_order_document');

        if (!$file->isValid()) {
            throw new \Exception('Uploaded suspension order document is invalid.');
        }

        // Create application folder
        $folder = folderpath('application_sa') . str_replace('/', '_', $applicationNo);

        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        // Generate unique filename
        $extension = strtolower($file->getClientOriginalExtension());

        $fileName = sprintf(
            'suspension_order_%s_%s.%s',
            now()->format('YmdHis'),
            uniqid(),
            $extension
        );

        $file->move($folder, $fileName);

        return $fileName;
    }

    private function insertSuspensionData(ClinicRegistrationModel $clinic, $applicationNo, $suspension_cancelation) 
    {
        try {

            $clinic = ClinicRegistrationModel::where('clinic_id', $clinic->clinic_id)
                ->where('clinic_type', $clinic->clinic_type)
                ->where('status', 1)
                ->firstOrFail();

            $userIdSA = Session::get('id');

            $clinic->update([
                'status'          => 0,
                'last_updated_by' => $userIdSA,
            ]);

            // Replicate existing record
            $newClinic = $clinic->replicate();


            $newClinic->application_no  = $applicationNo;
            $newClinic->status = $suspension_cancelation == 'Suspension' ? 3 : 4;
            $newClinic->application_type = 6;

            $newClinic->timestamps = false;

            $newClinic->saveOrFail();

            return $newClinic;

        } catch (\Throwable $e) {

            Log::error('Error while inserting suspension data.', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'application_no' => $applicationNo,
                'clinic_id' => $clinic->clinic_id ?? null,
                'user_id' => Session::get('id'),
                'exception' => $e,
            ]);

             return redirect()->back()->withInput()
                    ->with('error', 'Something went wrong while processing your request. Please try again. If the problem persists, contact the system administrator.');        }
    }
}