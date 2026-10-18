<?php

namespace App\Http\Controllers\renewal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\clinic\signup;
use App\Models\clinic\SurrogacyClinicModel;
use App\Models\clinic\SurrogacyClinicApplicationNo;
use App\Models\clinic\SurrogacyClinicDirectorModel;
use App\Models\clinic\SurrogacyClinicEquipmentModel;
use App\Models\clinic\SurrogacyClinicOtherStaffModel;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\clinic\clinicStaffModel;
use App\Models\clinic\clinicDirectorModel;
use App\Models\clinic\clinicEquipmentModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\renewal\RenewalSCApplication;
use App\Models\renewal\RenewalSCDirector;
use App\Models\renewal\RenewalSCEquipment;
use App\Helpers\ClinicRegistration;
use App\Models\renewal\RenewalSCStaff;
use App\Models\renewal\workflowlog;
use App\Models\Admin\WorkFlowTable;
use App\Models\renewal\DocFilereceivedUploadRenewal;
use App\Models\renewal\RenewalFee;
use App\Models\Noc\docmastertable;
use App\Helpers\dashboardHelper;
use App\Models\Admin\user;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Mail;
use App\Mail\RenewalApproveRejectedMail;


class renewalssaController extends Controller
{


    // view from dashboard
    public function clinicssarenewal_list($clinicType)
    {
        // dd($clinicType);

        if (!Session::has('id')) {
            return redirect()->route('admin.loginssaform');
        }

        $userId = Session::get('id');
        $stateName = Session::get('state_name');

        // Map URL keyword to database value
        $clinicTypeMap = [
            'artsurrogacy' => 'ARTSURROGACY',
            'artclinic' => 'ARTCLINIC',
            'artbank' => 'ARTBANK',
        ];

        // Validate and get mapped type
        $clinicTypeValue = $clinicTypeMap[strtolower($clinicType)] ?? null;
        //  DD($clinicTypeValue);
        if (!$clinicTypeValue) {
            abort(404, 'Invalid clinic type');
        }

        // Fetch renewal list by type
        $clinicdata = RenewalSCApplication::where('state', $stateName)
            ->where('status', 1)
            ->where('clinic_type', $clinicTypeValue)
            ->get();

        return view('renewal.clinic_ssa_list_rec', compact('clinicdata', 'clinicTypeValue'));
        // return view('admin.renewal.clinic_list', compact('data', 'clinicType'));
    }



    public function renewalsearchApplication(Request $request, $clinicType)
    {
        if (!Session::has('id')) {
            return response()->json(['errorMessage' => 'Unauthorized access'], 403);
        }

        $applicationNo = $request->input('application_no');
        $stateName = Session::get('state_name');

        if (empty($applicationNo)) {
            return response()->json(['errorMessage' => 'Please enter a application No.']);
        }

        // Map friendly URL clinicType to DB value
        $clinicTypeMap = [
            'artsurrogacy' => 'ARTSURROGACY',
            'artclinic' => 'ARTClINIC',
            'artbank' => 'ARTBANK',
        ];

        $clinicTypeValue = $clinicTypeMap[strtolower($clinicType)] ?? null;
        // dd($clinicTypeValue);
        if (!$clinicTypeValue) {
            return response()->json(['errorMessage' => 'Invalid clinic type']);
        }

        $results = RenewalSCApplication::where('applicationno', 'LIKE', "%{$applicationNo}%")
            ->where('state', $stateName)
            ->where('status', 1)
            ->where('clinic_type', $clinicTypeValue)
            ->get()
            ->map(function ($item) {
                $item->encrypted_id = Crypt::encryptString($item->id);
                $item->encrypted_clinic_id = Crypt::encryptString($item->clinic_id);
                return $item;
            });

        return response()->json($results);
    }


    public function renewalApplicationRec($clinicSlug, $id)
    {
        // dd('text');
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        $userId = Session::get('id');
        $stateName = Session::get('state_name');

        // $id = Crypt::decryptString($encryptedId);
        // $receivedssasurrogacyformList = RenewalSCApplication::findOrFail($id);

        //     $clinicMap = [
        //     'surrogacy' => 'ARTSURROGACY',
        //     'artclinic' => 'ARTCLINIC',
        //     'iui' => 'IUI',
        // ];

        // $clinicType = $clinicMap[$clinicSlug] ?? null;
        // DD($clinicType);
        // if (!$clinicType) {
        //     abort(404);
        // }

        $applicationId = Crypt::decryptString($id);
        $application = RenewalSCApplication::where('id', $applicationId)
            ->where('clinic_type', $clinicSlug)
            ->where('state', $stateName)
            ->firstOrFail();
        // dd($application);
        if (!empty($application->cliniclevel)) {
            $feeAmount = RenewalFee::where('clinic_type', $application->clinic_type)->where('level', $application->cliniclevel)->where('status', 1)->first();
        } else {
            // dd(RenewalFee::all());
            $feeAmount = RenewalFee::where('clinic_type', $application->clinic_type)->where('status', 1)->first();
            // dd($feeAmount);
        }
        // dd($feeAmount);
        return view('renewal.viewclinic_rec', compact('application', 'feeAmount'));
    }
    //     // 


    public function receive_surrogacy_clinic_submitFormTEST(Request $request)
    {
        Log::info('Controller: receive_surrogacy_clinic_submitForm called.');
        DB::beginTransaction(); // Start manual transaction
        //  dd('receive_surrogacy_clinic_submitForm called');
        try {
            $sclinicId = $request->input('id');
            $nature = $request->input('nature');

            $rules = [
                'app_date_recieve' => 'required',
            ];

            if ($nature === 'Private') {
                $rules = array_merge($rules, [
                    'app_date_payment' => 'required',
                    'mode_payment'     => 'required',
                    'transaction_id'   => 'required',
                    'fee_amount'       => 'required',
                ]);
            }

            // Validate request
            $dataUpdt = $request->validate($rules);
            //  Add common columns for both Private & Government
            $dataUpdt['app_received'] = 'received';
            $dataUpdt['fee_recieved_by'] = Session::get('id'); // assuming session stores user id as 'id'
            $dataUpdt['fee_recieved_datetime'] = now();
            // dd($dataUpdt);
            // Handle file uploads (e.g. insert into files table) — inside transaction
            if ($nature === 'Private') {
                $this->handleFileUploads_renewal($request, $sclinicId);
            }

            // $dataUpdt['app_received'] = 'received';
            RenewalSCApplication::where('id', $sclinicId)->update($dataUpdt);
            // dd($test);
            // If all DB operations are successful
            DB::commit(); // Commit transaction

            return redirect()
                ->route('renewal.clinic_ssa_list_rec')
                ->with('upd_success', 'Updated Successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack(); // Rollback on validation failure
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on other errors
            Log::error('Error updating surrogacy record: ' . $e->getMessage());

            return redirect()->back()
                ->with('upd_error', 'An error occurred while updating. Please try again.')
                ->withInput();
        }
    }



    public function receiveClinicSubmit(Request $request, $encryptedClinicType)
    {
        Log::info("receiveClinicSubmit called for $encryptedClinicType");
        try {
            $clinicType = Crypt::decryptString($encryptedClinicType);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404, 'Invalid clinic type');
        }
        DB::beginTransaction();
        try {
            $sclinicId = $request->input('id');
            $nature = $request->input('nature');
            // Validate common fields
            $rules = ['app_date_recieve' => 'required'];
            if ($nature === 'Private') {
                $rules = array_merge($rules, [
                    'app_date_payment' => 'required',
                    'mode_payment'     => 'required',
                    'transaction_id'   => 'required',
                    'fee_amount'       => 'required',
                ]);
            }

            $dataUpdt = $request->validate($rules);
            $receivedForm = RenewalSCApplication::where('id', $sclinicId)->first();
            if(strtotime($request->app_date_recieve) >= strtotime(date('Y-m-d',strtotime($receivedForm->application_datetime_submission)))){
            // Add common columns
            $dataUpdt['app_received'] = 'received';
            $dataUpdt['fee_recieved_by'] = Session::get('id');
            $dataUpdt['fee_recieved_datetime'] = now();
            $dataUpdt['appstatus'] = 'Received';

            // Whitelist clinicType to prevent invalid access
            $allowedClinicTypes = ['ARTSURROGACY', 'ARTCLINIC', 'ARTBANK'];
            if (!in_array($clinicType, $allowedClinicTypes)) {
                throw new \Exception('Invalid clinic type');
            }

            // Handle file uploads dynamically
            if ($nature === 'Private') {
                $this->handleFileUploads_renewal($request, $sclinicId, $clinicType);
            }
            // Update the record
            $recived_date = $request->app_date_recieve ?? '';
            $id = $sclinicId;
            if (!empty($recived_date)) {
                $amount = dashboardHelper::getAmountdate($id, $recived_date);
                $dataUpdt['fee_amount'] = $amount[0];
            }
            RenewalSCApplication::where('id', $sclinicId)->update($dataUpdt);

            DB::commit();

            return redirect()
                ->route('renewal.clinic_ssarenewal_list', ['clinicType' => strtolower($clinicType)])
                ->with('upd_success', 'Application has been recieved Successfully');
            }
            else{
                Log::error('Renewal form approval failed client side tempring: ' . session('email'));
                return redirect()->back()->with('error', 'The renewal application could not be approved due to a validation error. Kindly refresh the page, verify the read only details, and try again. If the issue persists, contact support team.');
                }
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating clinic record: ' . $e->getMessage());
            return redirect()->back()->with('upd_error', 'An error occurred.')->withInput();
        }
    }

    //     /*  Recevied Fees function End*/




    // form sidebar
    public function showClinicList($encryptedClinicType)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        try {
            $clinicTypeValue = Crypt::decryptString($encryptedClinicType);
        } catch (\Exception $e) {
            abort(404, 'Invalid clinic type');
        }
        $clinicTypeValueaname =[
            'ARTSURROGACY' => 'Applications for the Surrogacy Clinic Renewal',
            'ARTCLINIC' => 'Applications for the ART Clinic Renewal',
            'ARTBANK' => 'Applications for the ART Bank Renewal',
        ];
        $userId = Session::get('id');
        $stateName = Session::get('state_name');
        // $surrogacy_data = RenewalSCApplication::where('state', $stateName)->where('status', 1)->get();
        $applications = RenewalSCApplication::where('clinic_type', $clinicTypeValue)->where('state', $stateName)->where('status', 1)->get();
        //  dd($applications);

        return view('renewal.clinic_ssa_list_reg', compact('applications', 'clinicTypeValue','clinicTypeValueaname'));
    }

    public function renewalApplicationReg($encryptedClinicType, $encryptedId)
    {
        $userId = Session::get('id');
        $stateName = Session::get('state_name');

        // Decrypt clinic type and application ID
        $clinicType = Crypt::decryptString($encryptedClinicType);
        $id = Crypt::decryptString($encryptedId);

        // Fetch the application based on clinic type
        $application = RenewalSCApplication::where('id', $id)
            ->where('clinic_type', $clinicType)
            ->firstOrFail();

        // Fetch related clinic registration data
        $clinic_data = ClinicRegistrationModel::where('userid_applicant', $application->userid)
            ->where('clinic_id', $application->clinic_id)
            ->where('status', 1)
            ->first();


        // dd($clinic_data);

        // Initialize variables
        $registrationDate = null;
        // $feeAmount1 = 0;

        // Calculate next valid date and fee
        if (!empty($clinic_data->certificate_valid_date)) {

            $certDate = Carbon::parse($clinic_data->certificate_valid_date);
            $registrationDate = $certDate->copy()->addDay()->format('Y-m-d');
            $today = Carbon::today();
            // dd($clinic_data->clinic_type);
            if ($clinic_data->clinic_type === 'ARTSURROGACY') {
                $newValidDate = $certDate->copy()->addYears(3)->format('Y-m-d');
            } else {
                $newValidDate = $certDate->copy()->addYears(5)->format('Y-m-d');
            }
            // dd($certDate.' / '.$newValidDate.' / '.$registrationDate.' / '.$today );
            // $renewalFee = RenewalFee::where('clinic_type', $clinicType)->first();
            // dd($clinic_data,$certDate);
            // $feeAmount1 = $today->gt($certDate) ? $renewalFee->fee * 2 : $renewalFee->fee;
        }
        if (!empty($application->cliniclevel)) {
            $feeAmount = RenewalFee::where('clinic_type', $application->clinic_type)->where('level', $application->cliniclevel)->where('status', 1)->first();
        } else {
            $feeAmount = RenewalFee::where('clinic_type', $application->clinic_type)->where('status', 1)->first();
        }

        // Determine document types dynamically based on clinic type
        $docTypeMap = [
            'ARTSURROGACY' => ['target_file_receiving_surrogacyclinic_docs'],
            'ARTCLINIC'    => ['target_file_receiving_artclinic_docs'],
            'ARTBANK'      => ['target_file_receiving_artbank_docs'],
        ];

        $docTypes = $docTypeMap[$clinicType] ?? [];

        // Fetch document master list
        $dataDocMaster = DB::table('doc_masters')
            ->whereIn('doc_type', $docTypes)
            ->where('status', 1)
            ->get();

    //   upload file show       
    $application_reject  = RenewalSCApplication::where('clinic_type', $clinicType)
                        ->where('applicationno',$application->fees_via_application_no)
                        ->where('status', 1)
                        ->where('appstatus', 'Rejected')
                        ->orderBy('id', 'ASC')
                        ->first();
    // dd($application_reject);
        if(!empty($application_reject) && $application_reject->applicationno == $application->fees_via_application_no){
            $get_docfileData = DB::table('renewal_doc_file_uploads_receiving_application')
                ->where('app_id', $application_reject->id)
                ->where('application_type', $application_reject->application_type)
                ->get();
                $application_no_folder = str_replace('/', '_', $application->fees_via_application_no);
        }else{
            $get_docfileData = DB::table('renewal_doc_file_uploads_receiving_application')
                ->where('app_id', $application->id)
                ->where('application_type', $application->application_type)
                ->get();
                $application_no_folder = str_replace('/', '_', $application->applicationno);
        }
        // dd($get_docfileData);
        // Fetch uploaded documents for this application
        // $get_docfileData = DB::table('renewal_doc_file_uploads_receiving_application')
        //     ->where('app_id', $application->id)
        //     ->where('application_type', $application->application_type)
        //     ->get();

        // Format folder name
        // $application_no_folder = str_replace('/', '_', $application->applicationno);
        
        // Return single Blade view for all clinics
        // dd($application);
        return view('renewal.viewclinic_reg', compact(
            'application',
            'get_docfileData',
            'application_no_folder',
            'clinic_data',
            'registrationDate',
            'newValidDate',
            'feeAmount',
            'clinicType',
            'dataDocMaster'
        ));
    }

    //     
    public function reg_receive_clinic_submit(Request $request)
    {
        // dd($request->all());
        try {
            
            DB::beginTransaction();

            $sclinicId = $request->input('id');
            $receivedForm = RenewalSCApplication::findOrFail($sclinicId);
            if( 
            trim($request->input('application_no'))==trim($receivedForm->applicationno) 
            && strtotime($request->app_date_recieve) >= strtotime(date('Y-m-d',strtotime($receivedForm->application_datetime_submission)))
            // && 
            // trim($request->input('clinicname'))==trim($receivedForm->clinicname) && 
            // trim($request->input('nature'))==trim($receivedForm->nature) &&
            // trim($request->input('address'))==trim($receivedForm->address) &&
            // trim($request->input('pincode'))==trim($receivedForm->pincode) &&
            // trim($request->input('state'))==trim($receivedForm->state) &&
            // trim($request->input('district'))==trim($receivedForm->district) &&
            // trim($request->input('registration_no'))==trim($receivedForm->registration_no)
            )
            {

            // dd($sclinicId);

            $dateReg = $request->input('date_reg');
            $inputValidity = $request->input('validity_upto');
            
            //  Determine clinic type dynamically
            $clinicType = strtoupper($receivedForm->clinic_type); // ARTBANK, ARTCLINIC, ARTSURROGACY


            //  Calculate validity based on clinic type
            switch ($clinicType) {
                case 'ARTBANK':
                    // $fetchedregistrationdate = 
                    $calculatedValidity = Carbon::parse($dateReg)->addYears(5)->subDay()->format('Y-m-d');
                    break;

                case 'ARTCLINIC':
                    $calculatedValidity = Carbon::parse($dateReg)->addYears(5)->subDay()->format('Y-m-d');
                    break;

                // case 'SURROGACY':
                case 'ARTSURROGACY':
                    $calculatedValidity = Carbon::parse($dateReg)->addYears(3)->subDay()->format('Y-m-d');
                    break;

                default:
                    $calculatedValidity = Carbon::parse($dateReg)->addYears(3)->subDay()->format('Y-m-d');
            }
            //  dd($calculatedValidity);
            //  Validate calculated validity if registration granted
            if ($request->approved_rejected === 'Registration Granted') {
                if ($calculatedValidity !== $inputValidity) {
                    return back()->withErrors([
                        'validity_upto' => 'Validity date is not correct. Expected: ' . $calculatedValidity,
                    ])->withInput();
                }
                // dd('validity matched');
            }
            $updateData = [
                'approved_rejected'        => $request->input('approved_rejected'),
                'fee_amount'               => !empty((int)$request->input('fee_amount')) ? (int)$request->input('fee_amount') : 0,
                'date_of_reg'              => $dateReg,
                'reg_valid_upto'           => $calculatedValidity,
                'registration_no'          => !empty($request->input('registration_no')) ? $request->input('registration_no') : NULL,
                'date_of_rej'              => !empty($request->input('date_rej')) ? $request->input('date_rej') : NULL,
                'rejection_no'             => !empty($request->input('rejection_no')) ? $request->input('rejection_no') : NULL,
                'final_action_taken_by'    => Session::get('id'),
                'final_action_takan_datetime' => now(),
            ];
            $recived_date = $request->app_date_recieve ?? '';
            $id = $sclinicId;
            if (!empty($recived_date)) {
                $amount = dashboardHelper::getAmountdate($id, $recived_date);
                $updateData['fee_amount'] = $amount[0];
            }
            // dd(str_replace(',', '', $request->input('fee_amount')));
            RenewalSCApplication::where('id', $sclinicId)->update($updateData);


            // 🔹 Update main certificate fields
            // $receivedForm->update([
            //     'aproved_rejected' => $request->input('approved_rejected'),
            //     'date_of_reg' => $dateReg,
            //     'reg_valid_upto' => $calculatedValidity,
            //     'registration_no' => $request->input('registration_no'),
            //     'date_of_rej' => $request->input('date_rej'),
            //     'rejection_no' => $request->input('rejection_no'),
            //     'final_action_taken_by' => Session::get('id'),
            //     'final_action_takan_datetime' => 2028-12-04,
            // ]);

            // dd($request->all(),$sclinicId,$receivedForm,$updateData);

            // 🔹 Insert renewal data dynamically for any clinic
            ClinicRegistration::insertRenewalData($receivedForm, $request, $sclinicId, $calculatedValidity, $clinicType);

            //    dd($dataUpdt);
            // 🔹 Update payment/application info
            $dataUpdt = RenewalSCApplication::find($sclinicId);
            // dd(
            //     $receivedForm->app_received,
            //     str_replace(',', '', $receivedForm->fee_amount),
            //     $request->input('mode_payment', $dataUpdt->mode_payment),
            //     $request->input('app_date_payment', $dataUpdt->app_date_payment),
            //     $request->input('transaction_id', $dataUpdt->transaction_id),
            //     $request->input('app_date_recieve', $dataUpdt->app_date_recieve),
            //     Session::get('id'),
            // );
            // Conditional non-empty updates
            if (!empty($receivedForm->app_received)) {
                $dataUpdt->app_received = $receivedForm->app_received;
            }
            if (!empty($receivedForm->fee_amount)) {
                $dataUpdt->fee_amount = str_replace(',', '', $receivedForm->fee_amount);
            }
            if (!empty($receivedForm->mode_payment)) {
                $dataUpdt->mode_payment = $receivedForm->mode_payment;
            }
            if (!empty($receivedForm->app_date_payment)) {
                $dataUpdt->app_date_payment = $receivedForm->app_date_payment;
            }
            if (!empty($receivedForm->transaction_id)) {
                $dataUpdt->transaction_id = $receivedForm->transaction_id;
            }
            if (!empty($receivedForm->app_date_recieve)) {
                $dataUpdt->app_date_recieve = $receivedForm->app_date_recieve;
            } else {

                // Default/fallback if not set
                $dataUpdt->app_received = 'received';
                $dataUpdt->fee_amount =  $request->input('fee_amount', $receivedForm->fee_amount);
                $dataUpdt->mode_payment = $request->input('mode_payment', $dataUpdt->mode_payment);
                $dataUpdt->app_date_payment = $request->input('app_date_payment', $dataUpdt->app_date_payment);
                $dataUpdt->transaction_id = $request->input('transaction_id', $dataUpdt->transaction_id);
                $dataUpdt->app_date_recieve = $request->input('app_date_recieve', $dataUpdt->app_date_recieve);
                $dataUpdt->fee_recieved_by = Session::get('id');
                $dataUpdt->fee_recieved_datetime = '2028-12-04';
            }

            // 🔹 Handle file uploads dynamically
            $this->handleFileUploads_renewal($request, $sclinicId);


            if ($dataUpdt->isDirty()) {
                $dataUpdt->save();
            }
            }
            else{
                Log::error('Renewal form approval failed client side tempring: ' . session('email'));

                return redirect()->back()->with('error', 'The renewal application could not be approved due to a validation error. Kindly refresh the page, verify the read only details, and try again. If the issue persists, contact support team.');
            }
            DB::commit();
            $state_user =  user::with('state')->where('id', Session::get('id'))->first();

            //masking of application no
            $applicationNo = $receivedForm->applicationno;
            $parts = explode('/', $applicationNo);
            $lastNumber = end($parts);
            $parts[count($parts) - 1] = str_repeat('*', strlen($lastNumber) - 1) . substr($lastNumber, -1);
            $maskedApplicationNo = implode('/', $parts);

                $application = [
                        'clinic_name' => $receivedForm->clinicname,
                        'applicationNo' => $maskedApplicationNo,
                        'reg_rej_no' => $request->input('approved_rejected') == 'Registration Granted' ? $request->input('registration_no') : $request->input('rejection_no'),
                        'status' => $request->input('approved_rejected') == 'Registration Granted' ? 'Approved' : 'Rejected',
                        'certificate_valid_date' => $request->input('approved_rejected') == 'Registration Granted' ? $calculatedValidity : null,
                        'reg_rej_date' => $request->input('approved_rejected') == 'Registration Granted' ? $request->input('date_reg') : $request->input('date_rej'),
                        'state_name' => $state_user->state->state_name,
                        'state_email' => $state_user->email,

                    ];
            Mail::to($receivedForm->email)->send(new RenewalApproveRejectedMail($application));

            
            $encryptedClinicType = Crypt::encryptString($clinicType); // e.g., 'ARTCLINIC', 'ARTBANK', etc.
            // return redirect()->route('registration.clinic-list', ['encryptedClinicType' => $encryptedClinicType]);
            // 🔹 Redirect to a single route for all clinics
            if ($request->input('approved_rejected') == 'Registration Granted'){
                return redirect()->route('registration.clinic-list', ['encryptedClinicType' => $encryptedClinicType])->with('upd_success', 'Renewal Application has been Approved.');
            }
            else {
                return redirect()->route('registration.clinic-list', ['encryptedClinicType' => $encryptedClinicType])->with('upd_success', 'Renewal Application has been Rejected.');
            }
        } catch (\Exception $e) {
            // dd($e->getMessage(),$e->getTrace());   
            DB::rollBack();
            Log::error("Clinic {$clinicType} certificate update failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating data.');
        }
    }




    //     /*  Upload file function  start*/
    private function handleFileUploads_renewal(Request $request, $sclinicId)
    {
        $allowedExtensions = ['pdf'];
        // dd($request->allFiles());
        // Get the application record
        $application = RenewalSCApplication::findOrFail($sclinicId);
        // dd($application->clinic_type);
        // Map each clinic type to its expected document key pattern
        $fileInputMap = [
            'ARTSURROGACY' => 'target_file_receiving_surrogacyclinic_docs',
            'ARTCLINIC'    => 'target_file_receiving_artclinic_docs',
            'ARTBANK'      => 'target_file_receiving_artbank_docs',
        ];

        // Detect the proper file input key
        $fileKey = $fileInputMap[$application->clinic_type] ?? null;

        if (!$fileKey) {
            Log::warning(" No file input configured for clinic type: {$application->clinic_type}");
            return;
        }

        // Get matching docmaster records dynamically
        $docMasters = docmastertable::where('doc_type', $fileKey)
            ->where('status', 1)
            ->get();

        if ($docMasters->isEmpty()) {
            Log::warning(" No docmaster records found for: {$fileKey}");
            return;
        }

        foreach ($docMasters as $docMaster) {
            $inputName = str_replace('target_file_', '', $docMaster->doc_type);
            // dd($inputName);
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $extension = strtolower($file->getClientOriginalExtension());

                if (!in_array($extension, $allowedExtensions)) {
                    Log::warning(" Invalid file extension for {$inputName}: {$extension}");
                    continue;
                }

                // Build folder path and file name
                $filename = $docMaster->doc_type . '-' . now()->timestamp . '_' . $application->userid . '.' . $extension;
                $foldername = 'application_sa';
                $baseDir = folderpath($foldername);
                $application_no_folder = str_replace('/', '_', $application->applicationno);
                $fullFolderPath = $baseDir . $application_no_folder;

                // dd($fullFolderPath, $filename);

                if (!file_exists($fullFolderPath)) {
                    mkdir($fullFolderPath, 0777, true);
                }

                $file->move($fullFolderPath, $filename);

                // Save upload info in DB
                DocFilereceivedUploadRenewal::updateOrCreate(
                    [
                        'userid'    => $application->userid,
                        'clinic_id' => $application->clinic_id,
                        'doc_id'    => $docMaster->id,
                    ],
                    [
                        'app_id'            => $application->id,
                        'application_type'  => $application->application_type,
                        'clinic_type'       => $application->clinic_type,
                        'doc_type'          => $docMaster->doc_type,
                        'doc_upload_ref'    => $filename,
                    ]
                );


                Log::info("File uploaded successfully for {$inputName}: {$filename}");
            } else {
                Log::info("No file uploaded for: {$inputName}");
            }
        }
    }

    public function getAmountDate(Request $request)
    {
        $id = Crypt::decryptString($request->get_id);
        $recived_date =  $request->recived_date;

        [$amount,$expiry_date] = dashboardHelper::getAmountdate($id, $recived_date);
        return response()->json([
                            'amount' => $amount,
                            'expiry_date' => $expiry_date->format('Y-m-d'),
                        ]);
    }
    //     /*  Upload file function  end*/
    public function renewalclinicgeneratePdf($id)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $ssaId = false;
        try {
            $applicationId = Crypt::decrypt($id);
        } catch (\Exception $e) {

            throw new NotFoundHttpException('Invalid or expired link.');
        }
        if (Session::get('user_type') < 4) {
            $ses_id = Session::get('id');
            $user = Signup::where('email', session('email'))->first();
            if (!$user) {
            abort(404, 'User not found.');
            }
        } elseif (Session::get('user_type') == 5) {

            $ssaId = Session::get('id');
            $adminuser = user::where('email',session('email'))->first();
            $ses_id = RenewalSCApplication::where('id', $applicationId)
                ->where('state', Session::get('state_name'))
                ->where('status', 1)
                ->value('userid');
            // dd($ses_id);
            // $ses_id = Session::get('id');
            if (!$adminuser) {
            abort(404, 'User not found.');
            }
        }
        $applicationId = Crypt::decrypt($id);
        // $application = RenewalSCApplication::where('id', $applicationId)->where('status', 1)->get();
        $application = RenewalSCApplication::where('id', $applicationId)->where('status', 1)->first();
        
        if (!$application) {
            abort(404, 'Application not found.');
        }
        // $directors = RenewalSCDirector::where('application_id', $application->first()->id)->where('status', 1)->get();
        $directors = RenewalSCDirector::where('application_id', $application->id)->get();
        // $staff = RenewalSCStaff::where('application_id', $application->first()->id)->where('status', 1)->get();
        $staff = RenewalSCStaff::where('application_id', $application->id)->get();
        // $equipment = RenewalSCEquipment::where('application_id', $application->first()->id)->where('status', 1)->get();
        $equipment = RenewalSCEquipment::where('application_id', $application->id)->get();
        // dd($equipment);
        // 60 days after submission date
        // $expectedSubmissionD = Carbon::parse($application->application_datetime_submission)->addDays(60);
        // $expectedSubmissionDate = $expectedSubmissionD->format('d-m-Y');
        // $renewalFee = RenewalFee::where('clinic_type', $application->clinic_type)->where('status', 1)->first();
        // dd($application);
        if (!empty($application->cliniclevel)) {
            $renewalFee = RenewalFee::where('clinic_type', $application->clinic_type)->where('level', $application->cliniclevel)->where('status', 1)->first();
        } else {
            $renewalFee = RenewalFee::where('clinic_type', $application->clinic_type)->where('status', 1)->first();
        }

        
        
        $notification_date = Carbon::parse(dashboardHelper::notificationDate());
        $notification_plus60 = $notification_date->addDays(60);
        // $years = in_array($application->clinic_type, ['ARTSURROGACY']) ? 3 : 5;
        // $actualExpiryDate = \Carbon\Carbon::parse($application->current_registration_date)->addYears($years);
        $actualExpiryDate = $application->current_certificate_valid_date;
        $expiry_date = $notification_plus60>$actualExpiryDate ? $notification_plus60 : $actualExpiryDate;

        // $registration_date = Carbon::parse($application->current_registration_date);
        // $reciving_date = Carbon::parse($application->app_date_recieve);

        // dd($reciving_date->gt($registration_date));
        if($application->is_resubmission == 1){
            $note ='';
            $renewal_fee = 'Fee Already Paid Rs.'.$application->fee_amount .' (via Application No.: ' .$application->fees_via_application_no .')';

            
         }
        //else if($expiry_date<$current_date ){
        //     $symbol = "<span style='font-family: DejaVu Sans, sans-serif;'>₹</span>";
        //     $note = "Note: The duly completed application form is required to be submitted physically to the
        // concerned State Appropriate Authority along with fee. The applicable fee shall be {$symbol} " . $renewalFee->fees_before_expiry . "  for submission to SAA till ".date('d-m-Y',strtotime($expiry_date))." and {$symbol} " . $renewalFee->fees_after_expiry . "  for submissions beyond that.";
        //     $renewal_fee = '';
        //     // $symbol = "<span style='font-family: DejaVu Sans, sans-serif;'>₹</span>";
        //     // $note = "Note: The duly completed application form is required to be submitted physically to the concerned State Appropriate Authority. The applicable fee shall be {$symbol}{$renewalFee->fees_after_expiry}.";
        // }
        else{
            $symbol = "<span style='font-family: DejaVu Sans, sans-serif;'>₹</span>";
           $note = "Note: The duly completed application form is required to be submitted physically to the
        concerned State Appropriate Authority along with fee. The applicable fee shall be {$symbol} " . $renewalFee->fees_before_expiry . "  for submission to SAA till ".date('d-m-Y',strtotime($expiry_date))." and {$symbol} " . $renewalFee->fees_after_expiry . "  for submissions beyond that.";
        $renewal_fee = '';
        }
            


        if($application->clinic_type =='ARTBANK'){
            $pdf = Pdf::loadView('renewal.bank_application_pdf', compact('application', 'directors', 'staff', 'equipment', 'note', 'renewal_fee'));
        } elseif($application->clinic_type =='ARTCLINIC'){
            $pdf = Pdf::loadView('renewal.application_pdf', compact('application', 'directors', 'staff', 'equipment', 'note', 'renewal_fee'));
        }else{
           
            $pdf = Pdf::loadView('renewal.surrogacy_application_pdf', compact('application', 'directors', 'staff', 'equipment', 'note' , 'renewal_fee'));
        }
        
        //dd($pdf);
        // Optionally, stream or download the PDF
        return $pdf->stream('application_pdf.pdf');
        // For download: return $pdf->download('application_details.pdf');

        // dd(Session::all(),Crypt::decryptString($encryptedId));
        

        // Step 2: Decrypt the application ID
        try {
            $applicationId = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {

            abort(404, 'Invalid or expired link.');
        }
        // $adminUser = signup::find($ses_id);

        // Step 3: Fetch the renewal application for this user
        $application = RenewalSCApplication::where('id', $applicationId)
            ->where('userid', $ses_id)
            ->where('status', 1)
            ->first();
        // dd('sfadf',$applicationId,$ses_id,$application);
        if (!$application) {
            abort(404, 'Application not found.');
        }

        // Step 4: Fetch related sub-tables
        $directors = RenewalSCDirector::where('clinic_id', $application->clinic_id)
            ->where('application_id', $applicationId)
            ->get();

        $staff = RenewalSCStaff::where('clinic_id', $application->clinic_id)
            ->where('application_id', $applicationId)
            ->get();

        $equipment = RenewalSCEquipment::where('clinic_id', $application->clinic_id)
            ->where('application_id', $applicationId)
            ->get();

        if ($ssaId) {
            // Step 6: Choose the correct blade view based on clinic type
            $bladeView = match (strtoupper($application->clinic_type)) {
                'ARTSURROGACY' => 'renewal.surrogacy_application_view_ssa',
                'ARTBANK'      => 'renewal.artbank_application_view_ssa',
                'ARTCLINIC'    => 'renewal.artclinic_application_view_ssa',
                // default        => 'renewal.surrogacy_application_view', // fallback
            };
        } else {
            // dd($application->clinic_type);
            // Step 6: Choose the correct blade view based on clinic type
            $bladeView = match (strtoupper($application->clinic_type)) {
                'ARTSURROGACY' => 'renewal.surrogacy_application_view',
                'ARTBANK'      => 'renewal.artbank_application_view',
                'ARTCLINIC'    => 'renewal.artclinic_application_view',
                // default        => 'renewal.surrogacy_application_view', // fallback
            };
        }
        // Step 7: Return the selected view
        return view($bladeView, compact(
            'application',
            'directors',
            'staff',
            'equipment'
        ));

        
    }
}

// $registrationDate = null;
// $feeAmount = 0;

// if (!empty($clinic_data->certificate_valid_date)) {
//     $certDate = Carbon::parse($clinic_data->certificate_valid_date);
//     $today = Carbon::today();

//     switch ($clinicType) {
//         case 'ARTSURROGACY':
//             $registrationDate = $certDate->copy()->addDay()->format('Y-m-d');
//             $feeAmount = $today->gt($certDate) ? 200000 : 100000;
//             break;

//         case 'ARTCLINIC':
//             $registrationDate = $certDate->copy()->addDays(7)->format('Y-m-d'); // example: +7 days
//             $feeAmount = $today->gt($certDate) ? 150000 : 80000;
//             break;

//         case 'ARTBANK':
//             $registrationDate = $certDate->copy()->addMonth()->format('Y-m-d'); // example: +1 month
//             $feeAmount = $today->gt($certDate) ? 250000 : 120000;
//             break;

//         default:
//             $registrationDate = $certDate->copy()->addDay()->format('Y-m-d');
//             $feeAmount = 100000;
//             break;
//     }
// }
