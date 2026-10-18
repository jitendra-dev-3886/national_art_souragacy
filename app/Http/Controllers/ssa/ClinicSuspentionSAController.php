<?php

namespace App\Http\Controllers\ssa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\clinic\ClinicSuspention;
use App\Models\clinic\ClinicRegistrationModel;



class ClinicSuspentionSAController extends Controller
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

        $pageTitle = [
            'ARTCLINIC'    => 'ART Clinic Suspension Applications',
            'ARTBANK'      => 'ART Bank Suspension Applications',
            'ARTSURROGACY' => 'Surrogacy Clinic Suspension Applications',
        ][$clinicTypeValue] ?? 'Clinic Suspension Applications';

        $stateName = Session::get('state_name');

        $clinicForms = ClinicRegistrationModel::where([
                'clinic_type' => $clinicTypeValue,
                'state'       => $stateName,
                'status'      => 1,
            ])
            ->orderBy('id', 'desc')
            ->get();

        return view('clinic_suspention.clinic_list', compact(
            'clinicForms',
            'clinicTypeValue',
            'pageTitle'
        ));
    }

    public function suspentionForm($encryptedClinicId)
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

        $application = ClinicRegistrationModel::where('clinic_id', $clinicId)
            ->where('state', $stateName)
            ->where('status', 1)
            ->first();

        // dd($application);

        if (!$application) {
            return redirect()->route('ssa.dashboard')
                ->with('error', 'Clinic record not found.');
        }

        $clinicTypeValue = $application->clinic_type;

        return view('clinic_suspention.suspention_form', compact(
            'application',
            'clinicTypeValue',
            'encryptedClinicId'
        ));
    }

    public function submitSuspention(Request $request, $encryptedClinicId)
    {
        try {

            $clinicId = Crypt::decryptString($encryptedClinicId);
            $userId = Session::get('id');

            if (!$userId) {
                return redirect()->route('clinic.loginclinicform');
            }

            $clinicData = ClinicRegistrationModel::where([
                'clinic_id' => $clinicId,
                'userid_applicant' => $userId,
                'status' => 1
            ])->first();

            if (!$clinicData) {
                return back()->with('error', 'Clinic not found.');
            }

            // Validation
            $rules = [
                'reason' => 'required|string|max:255',
                'reason_details' => 'required|string|max:1000',
                'clinic_type' => 'required|string|max:50',
                'clinic_level' => 'nullable|string|max:255',
                'action_type' => 'required|in:suspension,cancellation',
                'from_date' => 'required|date',
                'to_date' => 'nullable|date|after_or_equal:from_date',
                'authorized_name' => 'required|string|max:255',
                'authorized_designation' => 'required|string|max:255',
                'signature' => 'required|string|max:255',
                'auth_date' => 'required|date',
            ];

            if (strtoupper($request->input('clinic_type', '')) === 'ARTCLINIC') {
                $rules['clinic_level'] = 'required|string|max:255';
            }

            if ($request->input('action_type') === 'suspension') {
                $rules['to_date'] = 'required|date|after_or_equal:from_date';
            }

            $request->validate($rules);

            DB::beginTransaction();

            ClinicSuspention::create([

                'clinic_id'               => $clinicData->clinic_id,
                'registration_no'         => $clinicData->registration_no,
                'applicationno'           => $clinicData->application_no.'/SP',
                'clinic_name'             => $clinicData->name,
                'clinic_type'             => $clinicData->clinic_type,
                'address'                 => $clinicData->address,
                'pincode'                 => $clinicData->pincode,
                'state'                   => $clinicData->state,
                'district'                => $clinicData->district,
                'userid'                  => $userId,

                'application_date'        => $request->application_date,
                'suspention_date'         => $request->suspention_date,
                'suspention_reason'       => $request->suspention_reason,
                'suspention_description'  => $request->suspention_description,
                'authorized_signatory'    => $request->authorized_signatory,

                'status'                  => 1,
                'appstatus'               => 'Pending',

                'created_by'              => $userId,
                'updated_by'              => $userId,
            ]);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Suspension application submitted successfully.');

        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Suspension Error', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);

            return back()->with('error', 'Something went wrong.');
        }
    }
}