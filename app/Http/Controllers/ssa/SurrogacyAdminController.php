<?php

namespace App\Helpers;
namespace App\Http\Controllers\ssa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\SSALoginOtp;
use App\Models\Admin\user;
use App\Models\clinic\signup;
use App\Helpers\ClinicRegistration;
use App\Models\DocFileUpload;
use Illuminate\Support\Carbon;
use App\Models\clinic\BankModel;
use App\Models\LoginAttempt;
use App\Models\Noc\docmastertable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\clinic\ArtClinicModel;
use App\Models\DocFilereceivedUpload;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\clinic\SurrogacyClinicModel;
use App\Models\clinic\SurrogacyClinicCertificateDetails;
use App\Models\clinic\BankCertificateDetails;
use App\Models\clinic\ArtClinicCertificateDetails;
use App\Models\DocFileRegistrationCertificateUpload;
use App\Models\clinic\SurrogacyClinicCer;

class SurrogacyAdminController extends Controller
{
    /*  Recevied Fees function start*/

    public function surrogacyssaForm_list()
    {

       if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        $userId = Session::get('id');
        $stateName = Session::get('state_name'); 
        $ssasurogacyformList = signup::with('surrogacyclinics.sapp_no')->whereHas('surrogacyclinics.sapp_no')->where('state', $stateName)->where('status',1)->get();
        return view('layouts.admin.surrogacy_ssa_form_list', compact('ssasurogacyformList'));
    }

    public function surrogacysearchApplication(Request $request)
    {
        if (!Session::has('id')) {
            return response()->json(['errorMessage' => 'Unauthorized access'], 403);
        }

        $applicationNo = $request->input('application_no');  
        $stateName = Session::get('state_name');  
        if (empty($applicationNo)) {
            return response()->json(['errorMessage' => 'Please enter a application No.']);
        }
        $patient_list = signup::where('state',$stateName) // Filter by UHID in patient_artclinic table
        ->whereHas('surrogacyclinics.sapp_no', function ($query) use ($applicationNo) {
            // Apply condition for applicationno in artclinics.app_no table
            $query->where('applicationno', 'LIKE', '%' . $applicationNo . '%');
        })->get();
        if ($patient_list->isEmpty()) {
            return response()->json(['errorMessage' => 'No record found.']);
        }    
        // Encrypt the IDs before sending to frontend
        $patient_list->transform(function ($patient) {
            $patient->encrypted_id = encrypt($patient->surrogacyclinics->sapp_no->id);
            $patient->encrypted_id1 = encrypt($patient->id);
            return $patient;
        });
        return response()->json(['patient_list' => $patient_list]);
    }

    public function regsurrogacysearchApplication(Request $request)
    {
        if (!Session::has('id')) {
            return response()->json(['errorMessage' => 'Unauthorized access'], 403);
        }
    
        $applicationNo = $request->input('application_no');  
        $stateName = Session::get('state_name'); 
        if (empty($applicationNo)) {
            return response()->json(['errorMessage' => 'Please enter a application No.']);
        }
        // $patient_list = signup::where('state',$stateName) // Filter by UHID in patient_artclinic table
        // ->whereHas('surrogacyclinics.sapp_no', function ($query) use ($applicationNo) {           
        //     $query->where('applicationno', 'LIKE', '%' . $applicationNo . '%')->where('status',1);
        // })->get();
        $patient_list = signup::where('state', $stateName)
                        ->whereHas('surrogacyclinics', function ($query) use ($applicationNo) {
                            $query->whereIn('archive_status', [0, 1]) // ✅ only allow 0 and 1
                                ->whereHas('sapp_no', function ($q) use ($applicationNo) {
                                    $q->where('applicationno', 'LIKE', '%' . $applicationNo . '%');
                                });
                        })
                        ->get();
        if ($patient_list->isEmpty()) {
            return response()->json(['errorMessage' => 'No record found.']);
        }    
        // Encrypt the IDs before sending to frontend
        $patient_list->transform(function ($patient) {
            $patient->encrypted_id = encrypt($patient->surrogacyclinics->sapp_no->id ?? 0);
            $patient->encrypted_id2 = @$patient->surrogacyclinics->sapp_no->surrogacyclinic_id->id ?? 0;
            $patient->encrypted_id1 = encrypt($patient->id);
            $patient->encrypted_id3 = encrypt(@$patient->surrogacyclinics->id ?? 0);
            // $patient->date_reg = $patient->surrogacyclinics->certificate->date_reg ?? null;
            return $patient;
        });
        // dd($patient_list);
        // $regssasurrogacyformList = signup::with('surrogacyclinics.sapp_no.surrogacyclinic_id')->whereHas('surrogacyclinics.sapp_no.surrogacyclinic_id')->where('state', $stateName)->where('status',1)->get();
        $regssasurrogacyformList = signup::with('surrogacyclinics.sapp_no.surrogacyclinic_id')
                                ->whereHas('surrogacyclinics', function ($query) {
                                    $query->whereIn('archive_status', [0, 1]);
                                })
                                ->whereHas('surrogacyclinics.sapp_no.surrogacyclinic_id')
                                ->where('state', $stateName)
                                ->get();
        return response()->json(['patient_list' => $patient_list,'regssasurrogacyformList'=> $regssasurrogacyformList]);
    }

    public function receivedsurrogacyssaForm_list($id)
    {     
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        $userId = Session::get('id');
        $stateName = Session::get('state_name');  
          
        $decryptedId = Crypt::decrypt($id);
        $click_app = SurrogacyClinicModel::where('userid', $decryptedId)->first();   
        $clickID = $click_app->userid;

       $receivedssasurrogacyformList = signup::with('surrogacyclinics.sapp_no')->whereHas('surrogacyclinics', function ($query) use ($clickID) {
         $query->where('userid', $clickID); // Ensure correct column name
         })->first();
         
        
    //  dd($receivedssasurrogacyformList);

        return view('layouts.admin.received_surrogacy_ssa_clinic_form_list', compact('receivedssasurrogacyformList'));
    }

    public function receive_surrogacy_clinic_submitForm(Request $request)
    {
        Log::info('Controller: receive_surrogacy_clinic_submitForm called.');
        DB::beginTransaction(); // Start manual transaction

        try {
            $sclinicId = $request->input('id');
            $nature = $request->input('nature');
            $user_id = encrypt($request->input('user_id'));
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

            // Handle file uploads (e.g. insert into files table) — inside transaction
            if ($nature === 'Private') {
                $this->handleFileUploads_surrogacy($request, $sclinicId);
            }

            $dataUpdt['app_received'] = 'received';

            // Update main record
            DB::table('surrogacyclinic')->where('id', $sclinicId)->update($dataUpdt);

            // If all DB operations are successful
            DB::commit(); // Commit transaction

            return redirect()
                ->route('admin.surrogacy_ssaForm_list')
                ->with('upd_success', 'Updated Successfully');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack(); // Rollback on validation failure
            return redirect()->route('admin.receivedsurrogacyssaForm_list', ['id' => $user_id])
                ->with('upd_error', 'An error occurred at server side. Please try again.')
                ->withInput();

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on other errors
            Log::error('Error updating surrogacy record: ' . $e->getMessage());

            return redirect()->route('admin.receivedsurrogacyssaForm_list', ['id' => $user_id])
                ->with('upd_error', 'An error occurred while updating. Please try again.')
                ->withInput();
        }
    }
    /*  Recevied Fees function End*/




    /*  Generate certificate function start */
    public function reg_surrogacy_ssaForm_list()
    {        
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        //$userId = Session::get('id');

        //$stateName = Session::get('state_name'); 
        //$ssasurrogacyformList = signup::with('surrogacyclinics.sapp_no')->whereHas('surrogacyclinics.sapp_no')->where('state', $stateName)->get();
        //$regssasurrogacyformList = signup::with('surrogacyclinics.sapp_no.surrogacyclinic_id')->whereHas('surrogacyclinics.sapp_no.surrogacyclinic_id')->where('state', $stateName)->where('status',1)->get();
        // dd($regssasurrogacyformList);
        return view('layouts.admin.reg_surrogacy_ssa_form_list');
    }

    public function reg_receivedsurrogacyssaForm_list($id)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        $userId = Session::get('id');
        $stateName = Session::get('state_name');  
        $decryptedId = Crypt::decrypt($id);
        $click_app = signup::find($decryptedId);
        $clickID = $click_app->id;      
        $receivedssasurrogacyformList = signup::with('surrogacyclinics.sapp_no')->whereHas('surrogacyclinics', function ($query) use ($clickID) {
         $query->where('userid', $clickID); // Ensure correct column name
         })->first();

         $receivedssasurrogacyformList->surrogacyclinics->id;       
         $dataDocMaster = DB::table('doc_masters')
         ->select('doc_masters.*')
         ->whereIn('doc_type', [
             'target_file_receiving_surrogacyclinic_docs',             
         ])
         ->where('status', 1)
         ->get();      
        if ($dataDocMaster->isNotEmpty()) {
            foreach ($dataDocMaster as $doc) {
                $doc_type = $doc->doc_type;
                $doc_id = $doc->id;
            }
        }
        $get_docfileData = DB::table('doc_file_uploads_receiving_application')
            ->where('app_id', $receivedssasurrogacyformList->surrogacyclinics->id)
            ->get();   
        $application_no_folder= str_replace('/', '_', $receivedssasurrogacyformList->surrogacyclinics->sapp_no->applicationno);
        $regssasurrogacyformList = signup::with('surrogacyclinics.sapp_no.surrogacyclinic_id')->whereHas('surrogacyclinics.sapp_no.surrogacyclinic_id')->where('state', $stateName)->first();
        return view('layouts.admin.reg_received_ssa_surrogacy_form_list', compact('receivedssasurrogacyformList','regssasurrogacyformList','get_docfileData','application_no_folder'));
    }

    public function reg_receive_surrogacy_submitForm(Request $request)
    {
        try{
        $userid = $request->input('userid');
        $encryptId = Crypt::encrypt($userid);
        Log::info('Controller: reg_receive_surrogacy_submitForm called.');
        DB::beginTransaction();
        $sclinicId = $request->input('id');   
            
        $receivedssasurrogacyformList = signup::with('surrogacyclinics.sapp_no')->whereHas('surrogacyclinics', function ($query) use ($sclinicId) {
            $query->where('id', $sclinicId); // Ensure correct column name
            })->first();      
        $certificate_details = new SurrogacyClinicCertificateDetails();
        $certificate_details->application_no = $receivedssasurrogacyformList->surrogacyclinics->sapp_no->applicationno;
        $certificate_details->approved_rejected = $request->input('approved_rejected');
        $certificate_details->date_reg = $request->input('date_reg');
        $certificate_details->validity_upto = $request->input('validity_upto');
        $certificate_details->registration_no = $request->input('registration_no');
         $certificate_details->date_rej = $request->input('date_rej');
        $certificate_details->rejection_no = $request->input('rejection_no');
        $certificate_details->userid = $receivedssasurrogacyformList->surrogacyclinics->userid;  
        // dd($certificate_details);   
        
        
       

        ClinicRegistration::insertsurrogacydata($receivedssasurrogacyformList, $request, $sclinicId);
        $certificate_details->save();
        // $this->reg_surrogacyhandleFileUploads($request, $sclinicId); 
        $dataUpdt = SurrogacyClinicModel::find($sclinicId);      
        // Update only if fields are not empty
        
        // dd($receivedssasurrogacyformList);

        if (!empty($receivedssasurrogacyformList->surrogacyclinics->app_received)) {
            $dataUpdt->app_received = $receivedssasurrogacyformList->surrogacyclinics->app_received;       
        }
        if (!empty($receivedssasurrogacyformList->surrogacyclinics->fee_amount)) {
            $dataUpdt->fee_amount = $receivedssasurrogacyformList->surrogacyclinics->fee_amount;
        }
        if (!empty($receivedssasurrogacyformList->surrogacyclinics->mode_payment)) {
            $dataUpdt->mode_payment = $receivedssasurrogacyformList->surrogacyclinics->mode_payment;
        }
        if (!empty($receivedssasurrogacyformList->surrogacyclinics->app_date_payment)) {
            $dataUpdt->app_date_payment = $receivedssasurrogacyformList->surrogacyclinics->app_date_payment;
        }
        if (!empty($receivedssasurrogacyformList->surrogacyclinics->transaction_id)) {
            $dataUpdt->transaction_id = $receivedssasurrogacyformList->surrogacyclinics->transaction_id;
        }
        if (!empty($receivedssasurrogacyformList->surrogacyclinics->app_date_recieve)) {
            $dataUpdt->app_date_recieve = $receivedssasurrogacyformList->surrogacyclinics->app_date_recieve;
        }  
        else {      
            $dataUpdt = SurrogacyClinicModel::find($sclinicId); // Create new record if not found        
            $dataUpdt->app_received = 'received';
            $dataUpdt->fee_amount = $request->input('fee_amount', $dataUpdt->fee_amount);
            $dataUpdt->mode_payment = $request->input('mode_payment', $dataUpdt->mode_payment);
            $dataUpdt->app_date_payment = $request->input('app_date_payment', $dataUpdt->app_date_payment);
            $dataUpdt->transaction_id = $request->input('transaction_id', $dataUpdt->transaction_id);
            $dataUpdt->app_date_recieve = $request->input('app_date_recieve', $dataUpdt->app_date_recieve);
            $this->handleFileUploads_surrogacy($request, $sclinicId);
            $dataUpdt->save();
        }
        // Save only if fields were modified
        if ($dataUpdt->isDirty()) {
            $dataUpdt->update();
            $this->handleFileUploads_surrogacy($request, $sclinicId);
        }
        DB::commit();
        return redirect()->route('admin.surrogacy_reg_ssaForm_list')->with('upd_success', 'Updated Successfully');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Art Clinic certificate issue failed: ' . $e->getMessage());
        return redirect()->route('admin.reg_receivedsurrogacyssaForm_list', $encryptId)->with('error', 'An error occurred while Surrogacy clinic registration.');
    }     
    }

    /*  Generate certificate function end */



    /*  Upload file function  start*/
    private function handleFileUploads_surrogacy(Request $request, $sclinicId)
    {
        $allowedExtensions = ['pdf'];
        $docMasters = docmastertable::whereIn('doc_type', [
            'target_file_receiving_surrogacyclinic_docs'    
            // Add more document types here
        ])->where('status', 1)->get();  

        foreach ($docMasters as $docMaster) {
            $fileKey = str_replace('target_file_', '', $docMaster->doc_type);
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $extension = $file->getClientOriginalExtension();
                if (in_array(strtolower($extension), $allowedExtensions)) {
                    $dataUpdt = SurrogacyClinicModel::find($sclinicId);
                    $filename = $docMaster->doc_type . '-' . Carbon::now()->timestamp . '_' . $dataUpdt->userid . '.' . $extension;
                    $foldername = 'application_sa';
                    $baseDir = folderpath($foldername);
                    $application_no_folder= str_replace('/', '_', $dataUpdt->applicationno);
                    $fullFolderPath = $baseDir . $application_no_folder;
                    // Store the file in the 'noc_documents' directory in the public disk
                    if (!file_exists($fullFolderPath)) {
                        mkdir($fullFolderPath, 0777, true);
                    }
                    $filePath = $file->move($fullFolderPath, $filename);           
                    $dbpath = $filename;  
                    // Save the file information into the database
                    DocFilereceivedUpload::create([
                        'userid' => $dataUpdt->userid,
                        'app_id' => $dataUpdt->id,
                        // 'clinic_id' => $sclinicId,
                        'doc_id' => $docMaster->id,
                        'doc_type' => $docMaster->doc_type,
                        'doc_upload_ref' => $dbpath,
                    ]);
                    // Optionally, log or display the uploaded file details
                    Log::debug('File uploaded:', ['filename' => $filename, 'filePath' => $filePath]);
                } else {
                    // Log or display an error if the extension is not allowed
                    Log::warning('Invalid file extension for doc type:', ['docType' => $docMaster->doc_type, 'extension' => $extension]);
                }
            } else {
                // Log or display if no file was uploaded for the doc type
                Log::warning('No file uploaded for doc type:', ['docType' => $docMaster->doc_type]);
            }
        }
    }
    /*  Upload file function  end*/
}
