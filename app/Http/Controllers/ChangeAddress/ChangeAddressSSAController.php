<?php

namespace App\Http\Controllers\ChangeAddress;

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
use App\Models\clinic\ClinicEquipmentModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\ChangeAddress\ChangeAddressDirector;
use App\Models\ChangeAddress\ChangeAddressEquipment;

use App\Models\ChangeAddress\ChangeAddressApplication;
use App\Helpers\ClinicRegistration;
use App\Models\ChangeAddress\ChangeAddressStaff;
use App\Models\ChangeAddress\DocFilereceivedUploadChangeAddress;
use App\Models\ChangeAddress\ChangeAddressFee;
use App\Models\Noc\docmastertable;
use App\Helpers\dashboardHelper;
use App\Models\Admin\user;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Support\Facades\Mail;
use App\Mail\ChangeAdressApproveRejectMail;


class ChangeAddressSSAController extends Controller
{
    // view from dashboard
    public function ChangeAddressClinicList($clinicType)
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

        $clinicdata = ChangeAddressApplication::where('state', $stateName)
            ->where('status', 1)
            // ->where('clinic_type', $clinicTypeValue)
            ->get();

        return view('change_address.clinic_ssa_list_rec', compact('clinicdata', 'clinicTypeValue'));
    }

    public function changeAddressSearch(Request $request, $clinicType)
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

        $results = ChangeAddressApplication::where('applicationno', 'LIKE', "%{$applicationNo}%")
            ->where('state', $stateName)
            ->where('status', 1)
            // ->where('clinic_type', $clinicTypeValue)
            ->get()
            ->map(function ($item) {
                $item->encrypted_id = Crypt::encryptString($item->id);
                $item->encrypted_clinic_id = Crypt::encryptString($item->clinic_id);
                return $item;
            });

            

        return response()->json($results);
    }

    public function changeAddressRec($clinicSlug, $id)
    {
       
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        
        $userId = Session::get('id');
        $stateName = Session::get('state_name');

        

        $applicationId = Crypt::decryptString($id);

        $application = ChangeAddressApplication::with('clinic')->where('id', $applicationId)
            // ->where('clinic_type', $clinicSlug)
            ->where('state', $stateName)
            ->firstOrFail();

        // Changes for the rejected case do not need to be upload. @start(27-05-2026)
          $docTypeMap = [
            'ARTSURROGACY' => ['target_file_receiving_surrogacyclinic_docs'],
            'ARTCLINIC'    => ['target_file_receiving_artclinic_docs'],
            'ARTBANK'      => ['target_file_receiving_artbank_docs'],
        ];
        $docTypes = $docTypeMap[$application->clinic_type] ?? [];
        $dataDocMaster = DB::table('doc_masters')
            ->whereIn('doc_type', $docTypes)
            ->where('status', 1)
            ->get();
        $isRejectedBefore = $application->fees_via_application_no && ChangeAddressApplication::
                            where('fees_via_application_no', $application->fees_via_application_no)
                        ->oldest()
                        ->value('appstatus') === 'Rejected';
        $get_docfileData = collect();
        
        if ($isRejectedBefore) {
            $get_docfileData = DocFilereceivedUploadChangeAddress::where([
                'clinic_id'   => $application->clinic_id,
                'userid'      => $application->userid,
                'clinic_type' => $application->clinic_type,
            ])->get();
        }
        $application_no_folder = str_replace('/', '_', $application->fees_via_application_no);
        // Changes for the rejected case do not need to be upload. @end(27-05-2026)

        $feeAmount = dashboardHelper::getAmountdetailsCA($application->id, $application->userid, $application->clinic_type);  
        return view('change_address.viewclinic_rec', compact('application', 'feeAmount', 'isRejectedBefore', 'get_docfileData', 'application_no_folder'));
    }

    public function receiveClinicSubmit(Request $request, $encryptedClinicType)
    {
        $fileMap = [
            'artsurrogacy' => 'receiving_surrogacyclinic_docs',
            'artclinic' => 'receiving_artclinic_docs',
            'artbank' => 'receiving_artbank_docs',
        ];

        $fileField = $fileMap[strtolower($request->clinic_type)] ?? null;

        if (!$fileField) {
            return back()->withErrors([
                'clinic_type' => 'Invalid clinic type.'
            ]);
        }

        $request->validate([
            'mode_payment' => 'required',
            'transaction_id' => 'required',
            'app_date_payment' => 'required',
            'app_date_recieve' => 'required',
            $fileField => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'mode_payment.required' => 'Please select payment mode.',
            'transaction_id.required' => 'Please enter Transaction ID/DD No./Ref.no/Receipt No.',
            'app_date_payment.required' => 'Please choose Date of Payment Fees',
            'app_date_recieve.required' => 'This is require',
            "$fileField.required" => 'Receipt file is required.',
            "$fileField.mimes"    => 'Only PDF, JPG, JPEG and PNG files are allowed.',
            "$fileField.max"      => 'File size must be less than 2MB.',
        ]);

        Log::info("receiveClinicSubmit called for $encryptedClinicType");

        try {
            $clinicType = Crypt::decryptString($encryptedClinicType);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404, 'Invalid clinic type');
        }

        $allowedClinicTypes = ['ARTSURROGACY', 'ARTCLINIC', 'ARTBANK'];
        if (!in_array($clinicType, $allowedClinicTypes)) {
            abort(403, 'Invalid clinic type');
        }

        DB::beginTransaction();

        try {
            $rules = [
                'id' => 'required|exists:change_address_applications,id',
                'app_date_recieve' => 'required',
            ];

            if ($request->nature === 'Private') {
                $rules += [
                    'app_date_payment' => 'required',
                    'mode_payment'     => 'required',
                    'transaction_id'   => 'required',
                    'fee_amount'       => 'required',
                ];
            }

            $dataUpdt = $request->validate($rules);

            $record = ChangeAddressApplication::find($request->id);

            if (!$record) {
                throw new \Exception("Record not found");
            }

            // Extra fields
            $dataUpdt += [
                'app_received' => 'received',
                'fee_recieved_by' => Session::get('id'),
                'fee_recieved_datetime' => now(),
                'appstatus' => 'Received',
            ];
            // Calculate amount safely
            if (!empty($request->app_date_recieve)) {
                if ($request->fee_amount !== null) {
                    $dataUpdt['fee_amount'] = $request->fee_amount;
                }
            }
             
            $record->update($dataUpdt);

            if ($request->nature === 'Private') {
                $this->handleFileUploadsChangeAdd($request, $request->id, $clinicType);
            }

            DB::commit();

            return redirect()
                ->route('change_address.clinic_list', ['clinicType' => strtolower($clinicType)])
                ->with('upd_success', 'Application has been received successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->validator)->withInput();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating clinic record: ' . $e->getMessage());

            return back()->with('upd_error', 'An error occurred.')->withInput();
        }
    }

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
            'ARTSURROGACY' => 'Applications for the Surrogacy Clinic Change of Address',
            'ARTCLINIC' => 'Applications for the ART Clinic Change of Address',
            'ARTBANK' => 'Applications for the ART Bank Change of Address',
        ];
        $userId = Session::get('id');
        $stateName = Session::get('state_name');
        // $surrogacy_data = ChangeAddressApplication::where('state', $stateName)->where('status', 1)->get();
        $applications = ChangeAddressApplication::where('clinic_type', $clinicTypeValue)->where('state', $stateName)->where('status', 1)->get();

        return view('change_address.clinic_ssa_list_reg', compact('applications', 'clinicTypeValue','clinicTypeValueaname'));
    }

    public function changeAddressReg($encryptedClinicType, $encryptedId)
    {
        $userId = Session::get('id');
        $stateName = Session::get('state_name');

        $clinicType = Crypt::decryptString($encryptedClinicType);
        $id = Crypt::decryptString($encryptedId);


        // Fetch the application based on clinic type
        // $application = ChangeAddressApplication::where('id', $id)
        //     ->where('clinic_type', $clinicType)
        //     ->firstOrFail();
        $application = ChangeAddressApplication::find($id);

        // dd($application);

        // Fetch related clinic registration data
        $clinic_data = ClinicRegistrationModel::where('userid_applicant', $application->userid)
            ->where('clinic_id', $application->clinic_id)
            ->where('status', 1)
            ->first();

        $registrationDate = null;
        $today = Carbon::today();
        $newValidDate = '';


        if (!empty($clinic_data->certificate_valid_date)) {

            $certDate = Carbon::parse($clinic_data->certificate_valid_date);
            $registrationDate = $certDate->copy()->addDay()->format('Y-m-d');


            $newValidDate = $certDate;
            // dd($clinic_data->clinic_type);
            // if ($clinic_data->clinic_type === 'ARTSURROGACY') {
            //     $newValidDate = $certDate->copy()->addYears(3)->format('Y-m-d');
            // } else {
            //     $newValidDate = $certDate->copy()->addYears(5)->format('Y-m-d');
            // }
        }
       $feeAmount = dashboardHelper::getAmountdetailsCA($application->id, $application->userid, $application->clinic_type);
         // dd($application->id, $application->userid, $application->clinic_type, $feeAmount);

        $docTypeMap = [
            'ARTSURROGACY' => ['target_file_receiving_surrogacyclinic_docs'],
            'ARTCLINIC'    => ['target_file_receiving_artclinic_docs'],
            'ARTBANK'      => ['target_file_receiving_artbank_docs'],
        ];

        $docTypes = $docTypeMap[$clinicType] ?? [];

        $dataDocMaster = DB::table('doc_masters')
            ->whereIn('doc_type', $docTypes)
            ->where('status', 1)
            ->get();
        $get_docfileData = DocFilereceivedUploadChangeAddress::where('app_id', $application->id)
            ->where('application_type', $application->application_type)
            ->get();


        $application_no_folder = str_replace('/', '_', $application->applicationno);
        return view('change_address.viewclinic_reg', compact(
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
     
    public function submitChangeAddressReg(Request $request)
    {
        $fileField = [
            'artsurrogacy' => 'reg_surrogacyclinic_certificate',
            'artclinic' => 'reg_artclinic_certificate',
            'artbank' => 'reg_artbank_certificate',
        ][strtolower($request->clinic_type)];

        $request->validate([
            'approved_rejected' => 'required',
            'date_reg' => 'nullable|required_if:approved_rejected,Registration Granted|date',
            'validity_upto' => 'nullable|required_if:approved_rejected,Registration Granted|date',
            'registration_no' => 'nullable|required_if:approved_rejected,Registration Granted',
            'date_rej' => 'nullable|required_if:approved_rejected,Registration Rejected|date',
            'rejection_no' => 'nullable|required_if:approved_rejected,Registration Rejected',
            $fileField => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'approved_rejected.required' => 'Please select decision.',
            'date_reg.required_if' => 'Registration date is required.',
            'date_reg.date' => 'Please enter valid registration date.',
            'validity_upto.required_if' => 'Validity date is required.',
            'validity_upto.date' => 'Please enter valid validity date.',
            'registration_no.required_if' => 'Registration number is required.',
            'date_rej.required_if' => 'Rejection date is required.',
            'date_rej.date' => 'Please enter valid rejection date.',
            'rejection_no.required_if' => 'Rejection number is required.',
            "$fileField.required" => 'Registration certificate is required.',
            "$fileField.mimes" => 'Only pdf, jpg, jpeg and png files are allowed.',
            "$fileField.max" => 'File size must be less than 2MB.',
        ]);

        try {
            Log::info('Controller: clinic change of address called.');
            DB::beginTransaction();

            $sclinicId = $request->input('id');        

            $receivedForm = ChangeAddressApplication::findOrFail($sclinicId);
            $dateReg = $request->input('date_reg');
            $inputValidity = $request->input('validity_upto');

            $clinicType = strtoupper($receivedForm->clinic_type); // ARTBANK, ARTCLINIC, ARTSURROGACY


            switch ($clinicType) {
                case 'ARTBANK':
                    $calculatedValidity = $dateReg;
                    break;
                case 'ARTCLINIC':
                    $calculatedValidity = $dateReg;
                    break;
                case 'ARTSURROGACY':
                    $calculatedValidity = $dateReg;
                    break;
                default:
                    $calculatedValidity = $dateReg;
            }
            //  Validate calculated validity if registration granted
            // if ($request->approved_rejected === 'Registration Granted') {
            //     if ($calculatedValidity !== $inputValidity) {
            //         return back()->withErrors([
            //             'validity_upto' => 'Validity date is not correct. Expected: ' . $calculatedValidity,
            //         ])->withInput();
            //     }
            // }
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
            if (!empty($recived_date)) {

                $updateData['fee_amount'] = $receivedForm->fee_amount;
            }
            ChangeAddressApplication::where('id', $sclinicId)->update($updateData);


            $this->insertChangeAddresslData($receivedForm, $request, $sclinicId, $calculatedValidity, $clinicType);

            //dd($dataUpdt);
            $dataUpdt = ChangeAddressApplication::find($sclinicId);
          
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
                // $dataUpdt->fee_recieved_datetime = '2028-12-04';
            }

            $this->handleFileUploadsChangeAdd($request, $sclinicId);

            if ($dataUpdt->isDirty()) {
                $dataUpdt->save();
            }

            DB::commit();
            $encryptedClinicType = Crypt::encryptString($clinicType); // e.g., 'ARTCLINIC', 'ARTBANK', etc.
            // return redirect()->route('registration.clinic-list', ['encryptedClinicType' => $encryptedClinicType]);
            // Redirect to a single route for all clinics
            return redirect()->route('change_address.registration.clinic_list', ['clinicType' => $encryptedClinicType])->with('upd_success', 'Change Address Application has been Completed.');
        }  catch (\Illuminate\Validation\ValidationException $e) {

            DB::rollBack();

            return back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Throwable $e) {

            DB::rollBack();
            Log::error('Change Address Registration Failed', [
                'application_id' => $request->input('id'),
                'clinic_type'    => $request->input('clinic_type'),
                'user_id'        => Session::get('id'),
                'message'        => $e->getMessage(),
                'file'           => $e->getFile(),
                'line'           => $e->getLine(),
                'trace'          => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'An unexpected error occurred while processing the application. Please try again or contact the administrator.');
        }
    }

    private function handleFileUploadsChangeAdd(Request $request, $sclinicId)
    {
        $allowedExtensions = ['pdf'];

        $application = ChangeAddressApplication::findOrFail($sclinicId);

        $fileInputMap = [
            'ARTSURROGACY' => 'target_file_receiving_surrogacyclinic_docs',
            'ARTCLINIC'    => 'target_file_receiving_artclinic_docs',
            'ARTBANK'      => 'target_file_receiving_artbank_docs',
        ];

        $fileKey = $fileInputMap[$application->clinic_type] ?? null;

        if (!$fileKey) {
            Log::warning("No file input for clinic type: {$application->clinic_type}");
            return;
        }

        $docMasters = docmastertable::where('doc_type', $fileKey)
            ->where('status', 1)
            ->get();

        foreach ($docMasters as $docMaster) {

            $inputName = str_replace('target_file_', '', $docMaster->doc_type);

            if (!$request->hasFile($inputName)) {
                Log::info("No file uploaded for: {$inputName}");
                continue;
            }

            $file = $request->file($inputName);

            if (!$file->isValid()) {
                Log::error("Invalid file: {$inputName}", [
                    'error' => $file->getError()
                ]);
                continue;
            }

            $extension = strtolower($file->getClientOriginalExtension());

            if (!in_array($extension, $allowedExtensions)) {
                Log::warning("Invalid extension for {$inputName}: {$extension}");
                continue;
            }

            $filename = $docMaster->doc_type . '-' . time() . '_' . $application->userid . '.' . $extension;

            $foldername = 'application_sa';
            $baseDir = folderpath($foldername);

            $applicationFolder = str_replace('/', '_', $application->applicationno);
            $fullPath = $baseDir . $applicationFolder;

            if (!is_dir($fullPath)) {
                mkdir($fullPath, 0777, true);
            }

            $file->move($fullPath, $filename);

            Log::info("File uploaded: {$filename}");

            try {
                DocFilereceivedUploadChangeAddress::updateOrCreate(
                    [
                        'userid'    => $application->userid,
                        'clinic_id' => $application->clinic_id,
                        'doc_id'    => $docMaster->id,
                    ],
                    [
                        'app_id'           => $application->id,
                        'application_type' => $application->application_type,
                        'clinic_type'      => $application->clinic_type,
                        'doc_type'         => $docMaster->doc_type,
                        'doc_upload_ref'   => $filename,
                    ]
                );

                Log::info("DB saved for {$inputName}");

            } catch (\Exception $e) {
                Log::error("DB save failed for {$inputName}", [
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function getAmountdetails(Request $request)
    {
        $id = Crypt::decryptString($request->get_id);
        $recived_date =  $request->recived_date;

        $amount = dashboardHelper::getAmountdetailsCA($id, $recived_date);
        return response()->json($amount);
    }

    public function generatePdf($id)
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
            $ses_id = ChangeAddressApplication::where('id', $applicationId)
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
        $application = ChangeAddressApplication::where('id', $applicationId)->where('status', 1)->first();

        if (!$application) {
            abort(404, 'Application not found.');
        }

        $directors = ChangeAddressDirector::where('application_id', $application->id)->get();
        $staff = ChangeAddressStaff::where('application_id', $application->id)->get();
        $equipment = ChangeAddressEquipment::where('application_id', $application->id)->get();
        
        if ($application->clinic_type === 'ARTBANK') {
            $pdf = Pdf::loadView('change_address.bank_application_pdf', compact('application', 'directors', 'staff', 'equipment'));
        } else{

            $pdf = Pdf::loadView('change_address.application_pdf', compact('application', 'directors', 'staff', 'equipment'));
        }

        return $pdf->stream('application_pdf.pdf');

        // Step 2: Decrypt the application ID
        try {
            $applicationId = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {

            abort(404, 'Invalid or expired link.');
        }
        // $adminUser = signup::find($ses_id);

        // Step 3: Fetch the change address application for this user
        $application = ChangeAddressApplication::where('id', $applicationId)
            ->where('userid', $ses_id)
            ->where('status', 1)
            ->first();
        // dd('sfadf',$applicationId,$ses_id,$application);
        if (!$application) {
            abort(404, 'Application not found.');
        }

        // Step 4: Fetch related sub-tables
        $directors = ChangeAddressDirector::where('clinic_id', $application->clinic_id)
            ->where('application_id', $applicationId)
            ->get();

        $staff = ChangeAddressStaff::where('clinic_id', $application->clinic_id)
            ->where('application_id', $applicationId)
            ->get();

        $equipment = ChangeAddressEquipment::where('clinic_id', $application->clinic_id)
            ->where('application_id', $applicationId)
            ->get();

        if ($ssaId) {
            // Step 6: Choose the correct blade view based on clinic type
            $bladeView = match (strtoupper($application->clinic_type)) {
                'ARTSURROGACY' => 'change_address.surrogacy_application_view_ssa',
                'ARTBANK'      => 'change_address.artbank_application_view_ssa',
                'ARTCLINIC'    => 'change_address.artclinic_application_view_ssa',
            };
        } else {
            // Step 6: Choose the correct blade view based on clinic type
            $bladeView = match (strtoupper($application->clinic_type)) {
                'ARTSURROGACY' => 'change_address.surrogacy_application_view',
                'ARTBANK'      => 'change_address.artbank_application_view',
                'ARTCLINIC'    => 'change_address.artclinic_application_view',
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

    private function insertChangeAddresslData($receivedForm, $request, $sclinicId, $calculatedValidity, $clinicType)
    {
        // dd($receivedForm, $request, $sclinicId, $calculatedValidity, $clinicType);
        try {
            $allowedExtensions = ['pdf'];
            $timestamp = date('Y-m-d_His');

            // 🔹 Dynamic file field and naming based on clinic type
            $clinicType2 = strtolower($clinicType);
            // dd($clinicType);

            $fileFieldMap = [
                'artsurrogacy' => 'reg_surrogacyclinic_certificate',
                'artclinic' => 'reg_artclinic_certificate',
                'artbank'   => 'reg_artbank_certificate',
            ];

            $targetFilePrefix = [
                'artsurrogacy' => 'target_file_ca_surrogacyclinic_certificate',
                'artclinic' => 'target_file_ca_artclinic_certificate',
                'artbank'   => 'target_file_ca_artbank_certificate',
            ];

            $rejectedFilePrefix = [
                'artsurrogacy' => 'target_file_rejected_surrogacyclinic_certificate',
                'artclinic' => 'target_file_rejected_artclinic_certificate',
                'artbank'   => 'target_file_rejected_artbank_certificate',
            ];

            // Get current clinic file field and name prefix
            $fileField = $fileFieldMap[$clinicType2] ?? 'reg_surrogacyclinic_certificate';
            $regPrefix = $targetFilePrefix[$clinicType2] ?? 'target_file_reg_surrogacyclinic_certificate';
            $rejPrefix = $rejectedFilePrefix[$clinicType2] ?? 'target_file_rejected_surrogacyclinic_certificate';

            $fileField = $fileFieldMap[$clinicType2];
            // dd($fileField);
            

            $request->validate([
                $fileField => "required|file|mimes:pdf|max:2048"
            ]);
            $file = $request->file($fileField);

            
            // dd($request->all(), $file);
            $originalExtension = strtolower($file->getClientOriginalExtension());

            if (!in_array($originalExtension, $allowedExtensions)) {
                throw new \Exception("File type not allowed. Allowed types are: " . implode(', ', $allowedExtensions));
            }

            // Default filename
            $filename = $regPrefix . $timestamp . '_' . $receivedForm->id . '.' . $originalExtension;
            $dbpath = $filename;


            // =========================
            // REGISTRATION REJECTED
            // =========================
            if ($request->input('approved_rejected') == 'Registration Rejected') {
                $filename = $rejPrefix . $timestamp . '_' . $receivedForm->id . '.' . $originalExtension;
                $applicationFolder = str_replace('/', '_', $receivedForm->applicationno);
                //dd($applicationFolder);
                $foldername = 'application_sa';

                $docMasters = DB::table('doc_masters')
                    ->whereIn('doc_type', [$regPrefix])
                    ->where('status', 1)
                    ->first();
                $baseDir = folderpath($foldername);
                $fullFolderPath = $baseDir . $applicationFolder;
                // dd($fullFolderPath);
                DB::table('change_address_applications')
                    ->where('id',$sclinicId)
                    ->where('userid', $receivedForm->userid)
                    ->update(['appstatus' => 'Rejected']);

                if (!File::exists($fullFolderPath)) {
                    File::makeDirectory($fullFolderPath, 0755, true);
                }

                $file->move($fullFolderPath, $filename);
              
                $dbpath = $filename;
           
                // Insert uploaded doc record
                if ($docMasters) {
                    DB::table('change_address_doc_file_uploads_registration_certificate')->insert([
                        'userid' => $receivedForm->userid,
                        'clinic_id' => $receivedForm->clinic_id,
                        'app_id' => $sclinicId,
                        'doc_id' => $docMasters->id,
                        'doc_type' => $docMasters->doc_type,
                        'doc_upload_ref' => $dbpath,
                    ]);
                }
            }

            // =========================
            // REGISTRATION GRANTED
            // =========================
            else if ($request->input('approved_rejected') == 'Registration Granted') {
                $foldername = 'clinic_registration_certificate';
                $docMasters = DB::table('doc_masters')
                    ->whereIn('doc_type', [$regPrefix])
                    ->where('status', 1)
                    ->first();
                //  dd($docMasters);
                $destinationPath = folderpath($foldername);
                $clinic_id_gen = $receivedForm->clinic_id;
                $fullFolderPath = $destinationPath . '/' . $clinic_id_gen;
                //  dd($fullFolderPath);
                if (!File::exists($fullFolderPath)) {
                    File::makeDirectory($fullFolderPath, 0755, true);
                }

                $file->move($fullFolderPath, $filename);
                $dbpath = $filename;
                DB::table('change_address_applications')
                    ->where('id',$sclinicId)
                    ->where('userid', $receivedForm->userid)
                    ->update(['appstatus' => 'Approved']);

                // Insert uploaded doc record
                if ($docMasters) {
                    DB::table('change_address_doc_file_uploads_registration_certificate')->insert([
                        'userid' => $receivedForm->userid,
                        'clinic_id' => $receivedForm->clinic_id,
                        'app_id' => $sclinicId,
                        'doc_id' => $docMasters->id,
                        'doc_type' => $docMasters->doc_type,
                        'doc_upload_ref' => $dbpath,
                    ]);
                }

                // ======================
                // STAFF / DIRECTOR / EQUIPMENT INSERT
                // ======================
                $staffdata = ChangeAddressStaff::where('userid', $receivedForm->userid)
                    ->where('application_id', $sclinicId)->get();

                $insertStaff = $staffdata->map(function ($data) use ($receivedForm) {
                    return [
                        'clinic_id' => $receivedForm->clinic_id,
                        'name' => $data->name,
                        'post' => $data->post,
                        'qualification' => $data->qualification,
                        'application_no' => $receivedForm->applicationno,
                        'regno' => $data->regno,
                        'status' => 1,
                        'clinic_type' => $data->clinic_type,
                        // 'type_emp' => 'SURROGACYCLINICSTAFF',
                        'created_at' => now(),
                        'updated_at' => now(),
                        'validitydate' => now()
                    ];
                })->toArray();
                DB::table('tbl_clinic_staff')->where('clinic_id',$receivedForm->clinic_id)->update(['status'=> 0]);
                DB::table('tbl_clinic_staff')->insert($insertStaff);

                $directorData = ChangeAddressDirector::where('userid', $receivedForm->userid)
                    ->where('application_id', $sclinicId)->get();

                $insertDirector = $directorData->map(function ($data) use ($receivedForm) {
                    return [
                        'clinic_id' => $receivedForm->clinic_id,
                        'name_director' => $data->name_director,
                        'quali_director' => $data->quali_director,
                        'application_no' => $receivedForm->applicationno,
                        'reg_director' => $data->reg_director,
                        'status' => 1,
                        'clinic_type' => $data->clinic_type,
                        'created_at' => now(),
                        'updated_at' => now(),
                        'validitydate' => now()
                    ];
                })->toArray();
                DB::table('tbl_director_staff')->where('clinic_id',$receivedForm->clinic_id)->update(['status'=> 0]);
                DB::table('tbl_director_staff')->insert($insertDirector);

                $equipmentData = ChangeAddressEquipment::where('userid', $receivedForm->userid)
                    ->where('application_id', $sclinicId)->get();

                $insertEquipment = $equipmentData->map(function ($data) use ($receivedForm) {
                    return [
                        'clinic_id' => $receivedForm->clinic_id,
                        'equipmentname' => $data->equipmentname,
                        'application_no' => $receivedForm->applicationno,
                        'status' => 1,
                        'clinic_type' => $data->clinic_type,
                        'created_at' => now(),
                        'updated_at' => now(),
                        'validitydate' => now(),
                    ];
                })->toArray();
                DB::table('tbl_clinic_equipment')->where('clinic_id',$receivedForm->clinic_id)->update(['status'=> 0]);
                DB::table('tbl_clinic_equipment')->insert($insertEquipment);

                // ======================
                // UPDATE PREVIOUS ENTRY + INSERT NEW REGISTRATION
                // ======================
                ClinicRegistrationModel::where('userid_applicant', $receivedForm->userid)
                    ->where('clinic_id', $receivedForm->clinic_id)
                    ->latest('id')
                    ->take(1)
                    ->update([
                        'status' => 0,
                        'application_type'=>0,
                        'last_updated_by' => Session::get('id'),
                    ]);

                $data = [
                        'level' => $receivedForm->cliniclevel,
                        'clinic_id' => $receivedForm->clinic_id,
                        'name' => $receivedForm->clinicname,
                        'address' => $receivedForm->address,
                        'state' => $receivedForm->state,
                        'district' => $receivedForm->district,
                        'pincode' => $receivedForm->pincode,
                        'mobile' => $receivedForm->contact_person_mobile,
                        'email' => $receivedForm->email,
                        'nature' => $receivedForm->nature,
                        'contact_number_clinic' => $receivedForm->contactno,
                        'fax_number' => $receivedForm->fax,
                        'apply_registration' => $receivedForm->cliniclevel,
                        'website' => $receivedForm->website,
                        'date_of_establishment' => $receivedForm->dateestab ? date('Y-m-d', strtotime($receivedForm->dateestab)) : null,
                        'clinic_reg_mpt' => $receivedForm->mtpact,
                        'clinic_reg_pcpndt' => $receivedForm->pcpndtact,
                        'clinic_director' => $receivedForm->director,
                        'iui_h_s' => $receivedForm->iuih,
                        'iui_d_s' => $receivedForm->iuid,
                        'ivf_et' => $receivedForm->ivfet,
                        'icsi' => $receivedForm->icsi, 
                        'pgt' => $receivedForm->pgt,
                        'sperm_oocyte' => $receivedForm->spermandoocyte,
                        'any_other_procedure' => $receivedForm->anyotherprocedure,
                        'otherprocedure' => $receivedForm->otherprocedure,

                        'contact_person_name' => $receivedForm->contact_person_name,
                        'contact_person_email' => $receivedForm->contact_person_email,
                        'any_other_detail' => $receivedForm->otherdetails,

                        // BANK
                        'ejaculation' => $receivedForm->ejaculation,
                        'electrojaculation' => $receivedForm->electrojaculation,
                        'processing_sperm' => $receivedForm->processing_sperm,
                        'storage_sperm' => $receivedForm->storage_sperm,
                        'oocyte_doner' => $receivedForm->oocyte_doner,
                        'cryopreservation_of_sperm' => $receivedForm->cryopreservation_of_sperm,
                        'methode_of_freezing_of_sperm' => $receivedForm->methode_of_freezing_of_sperm,
                        'sperm_vitrification' => $receivedForm->sperm_vitrification,
                        'freezing_of_testicular_tissue' => $receivedForm->freezing_of_testicular_tissue,
                        'application_no' => $receivedForm->applicationno,
                        'registration_no' => $request->input('registration_no'),
                        'certificate_valid_date' => $calculatedValidity,
                        'certificate_path' => $dbpath,
                        'status' => 1,
                        'clinic_type' => $clinicType,
                        'userid_applicant' => $receivedForm->userid,
                        'rgistration_date' => $request->input('date_reg'),
                        'state_authority_id' => Session::get('id'),
                        'verify_certificate' => 1,
                        'created_date' => now(),
                        'update_date' => now(),
                        'validitydate' => now(),
                        'last_updated_by'=> Session::get('id'),
                        'ip_address' => getHostByName(getHostName()),
                        'action_taken_by' => Session::get('id'),
                        "action_taken_ssa_datetime" => now(),
                        'application_type' => $receivedForm->application_type,
                        "action_taken_ip"  => request()->ip(),
                        "first_registration_date" => $receivedForm->first_registration_date ?? '',
                    ];
                // dd($data);
                DB::table('clinic_registration')->insert($data);
            }

            $state_user =  user::with('state')->where('id', Session::get('id'))->first();
                  
                  

            $application = [
                    'clinic_name' => $receivedForm->clinicname,
                    'applicationNo' => $receivedForm->applicationno,
                    'reg_rej_no' => $request->input('approved_rejected') == 'Registration Granted' ? $request->input('registration_no') : $request->input('rejection_no'),
                    'status' => $request->input('approved_rejected') == 'Registration Granted' ? 'Approved' : 'Rejected',
                    'certificate_valid_date' => $request->input('approved_rejected') == 'Registration Granted' ? $calculatedValidity : null,
                    'reg_rej_date' => $request->input('approved_rejected') == 'Registration Granted' ? $request->input('date_reg') : $request->input('date_rej'),
                    'state_name' => $state_user->state->name,
                    'state_email' => $state_user->email,

                ];
            Mail::to($receivedForm->email)->send(new ChangeAdressApproveRejectMail($application));
        } catch (\Exception $e) {
            Log::error('Error inserting ART clinic data (' . $clinicType . '): ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to insert data. Please try again.');
        }
    }
}