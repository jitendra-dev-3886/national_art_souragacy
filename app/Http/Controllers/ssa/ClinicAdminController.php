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
use App\Models\clinic\BankCertificateDetails;
use App\Models\clinic\ArtClinicCertificateDetails;
use App\Models\DocFileRegistrationCertificateUpload;
use App\Models\clinic\SurrogacyClinicCer;

class ClinicAdminController extends Controller
{
    /*  Recevied Fees function starting start*/
    public function ssaForm_list()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        $userId = Session::get('id');
        $stateName = Session::get('state_name'); 
        $ssaartformList = signup::with('artclinics.app_no')->whereHas('artclinics.app_no')->where('state', $stateName)->where('status',1)->get();      

        return view('layouts.admin.ssa_form_list', compact('ssaartformList'));
    }  

    public function searchApplication(Request $request)
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
        ->whereHas('artclinics.app_no', function ($query) use ($applicationNo) {
            // Apply condition for applicationno in artclinics.app_no table
            $query->where('applicationno', 'LIKE', '%' . $applicationNo . '%');
        })->where('status',1)->get();    
        if ($patient_list->isEmpty()) {
            return response()->json(['errorMessage' => 'No record found.']);
        }    
        // Encrypt the IDs before sending to frontend
        $patient_list->transform(function ($patient) {
            $patient->encrypted_id = encrypt($patient->artclinics->app_no->id);
            $patient->encrypted_id1 = encrypt($patient->id);
            return $patient;
        });    
        return response()->json(['patient_list' => $patient_list]);
    }
    public function receivedssaForm_list($id)
    {     
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        $userId = Session::get('id');
        $stateName = Session::get('state_name');    
        $decryptedId = Crypt::decrypt($id);
        $click_app = ArtClinicModel::where('userid', $decryptedId)->first();   
        $clickID = $click_app->userid;
       $receivedssaartformList = signup::with('artclinics.app_no')->whereHas('artclinics', function ($query) use ($clickID) {
        $query->where('userid', $clickID); // Ensure correct column name
     
        })->first();  
        return view('layouts.admin.received_ssa_clinic_form_list', compact('receivedssaartformList'));
    }

    public function receive_clinic_submitForm(Request $request)
    {
        $clinicId = $request->input('id');  
        $nature = $request->input('nature'); // Get nature from the request
        $user_id = encrypt($request->input('user_id'));
         // Start the transaction
        try{
            DB::beginTransaction();
            $clinicId = $request->input('id'); 
            $nature = $request->input('nature'); // Get nature from the request
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
                $this->handleFileUploads($request, $clinicId);
            }
            
            $dataUpdt = $request->validate($rules);
            // Update the 'app_received' field directly
            $dataUpdt['app_received'] = 'received';  
            // dd($dataUpdt);
            DB::table('artclinic')->where('id', $clinicId)->update($dataUpdt);

            DB::commit(); // Commit only if all operations succeeded
            
    
        return redirect()->route('admin.ssaForm_list')->with('upd_success', 'Updated Successfully');
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack(); // Rollback transaction on validation failure
            Log::error('Error updating artbank record: ' . $e->getMessage());
            return redirect()->route('admin.receivedssaForm_list', ['id' => $user_id])
                ->with('upd_error', 'An error occurred at server. Please try again.')
                ->withInput();

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on any other error
            Log::error('Error updating artbank record: ' . $e->getMessage());

            return redirect()->route('admin.receivedssaForm_list', ['id' => $user_id])
                ->with('upd_error', 'An error occurred while updating. Please try again.')
                ->withInput();
        }  
    }

    /*  Recevied Fees function End*/




    /*  Generate certificate function  start*/
    public function reg_ssaForm_list()
    {   
        // Log::info('SSA page accessed', [
        // 'session_id' => session()->getId(),
        // 'has_id' => session()->has('id'),
        // 'id' => session('id'),
        // 'cookie' => request()->cookie(config('session.cookie')),
        // 'ip' => request()->ip(),
        // 'user_agent' => request()->userAgent(),
        // 'headers' => request()->headers->all(),
        // ]);
        if (empty(Session::has('id'))) {
            Log::info('Redirecting because session id missing');
            return redirect()->route('admin.loginssaform');
        }
        // $userId = Session::get('id');
        // $stateName = Session::get('state_name'); 
        // $ssaartformList = signup::with('artclinics.app_no')->whereHas('artclinics.app_no')->where('state', $stateName)->get();   
        // $regssaartformList = signup::with('artclinics.app_no.artclinic_id')->whereHas('artclinics.app_no.artclinic_id')->where('state', $stateName)->where('status',1)->get();
        Log::info('Redirecting to working page');
        return view('layouts.admin.reg_ssa_form_list');
    }

    public function regsearchApplication(Request $request)
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
        // ->whereHas('artclinics.app_no', function ($query) use ($applicationNo) {
        //     $query->where('applicationno', 'LIKE', '%' . $applicationNo . '%');
        // })->get();
        $patient_list = signup::where('state', $stateName)
                        ->whereHas('artclinics', function ($query) use ($applicationNo) {
                            $query->whereIn('archive_status', [0, 1]) // ✅ only allow 0 and 1
                                ->whereHas('app_no', function ($q) use ($applicationNo) {
                                    $q->where('applicationno', 'LIKE', '%' . $applicationNo . '%');
                                });
                        })
                        ->get();
        // dd($patient_list);
        if ($patient_list->isEmpty()) {
            return response()->json(['errorMessage' => 'No record found.']);
        }    
        // Encrypt the IDs before sending to frontend
        $patient_list->transform(function ($patient) {
            $patient->encrypted_id = encrypt($patient->artclinics->app_no->id ?? 0);
            $patient->encrypted_id2 = @$patient->artclinics->app_no->artclinic_id->id ?? 0;
            $patient->encrypted_id1 = encrypt($patient->id);
            $patient->encrypted_id3 = encrypt(@$patient->artclinics->id ?? 0);
            $patient->date_reg = $patient->artclinics->certificate->date_reg ?? null;
            return $patient;
        });
        // dd($patient_list);
        // $regssaartformList = signup::with('artclinics.app_no.artclinic_id')->whereHas('artclinics.app_no.artclinic_id')->where('state', $stateName)->where('status',1)->get();    
        $regssaartformList = signup::with('artclinics.app_no.artclinic_id')
                                ->whereHas('artclinics', function ($query) {
                                    $query->whereIn('archive_status', [0, 1]);
                                })
                                ->whereHas('artclinics.app_no.artclinic_id')
                                ->where('state', $stateName)
                                ->get();
        return response()->json(['patient_list' => $patient_list,'regssaartformList'=> $regssaartformList]);
    }

    public function reg_receivedssaForm_list($id)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }

        $userId = Session::get('id');
        $stateName = Session::get('state_name');  
        $decryptedId = Crypt::decrypt($id);
        $click_app = signup::find($decryptedId);
        $clickID = $click_app->id;      
        $receivedssaartformList = signup::with('artclinics.app_no')->whereHas('artclinics', function ($query) use ($clickID) {
         $query->where('userid', $clickID); // Ensure correct column name
         })->first();

         $receivedssaartformList->artclinics->id;
         $dataDocMaster = DB::table('doc_masters')
         ->select('doc_masters.*')
         ->whereIn('doc_type', [
             'target_file_receiving_artclinic_docs',             
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
            ->where('app_id', $receivedssaartformList->artclinics->id)
            ->get();
        $application_no_folder= str_replace('/', '_', $receivedssaartformList->artclinics->app_no->applicationno);
        $regssaartformList = signup::with('artclinics.app_no.artclinic_id')->whereHas('artclinics.app_no.artclinic_id')->where('state', $stateName)->first();
        return view('layouts.admin.reg_received_ssa_clinic_form_list', compact('receivedssaartformList','regssaartformList','get_docfileData','application_no_folder'));
    }
    
    public function reg_receive_clinic_submitForm(Request $request)
    {
        // dd($request->all());
        try{
            $userid = $request->input('userid');
            $encryptId = Crypt::encrypt($userid);
            Log::info('Controller: reg_receive_clinic_submitForm called.');
            DB::beginTransaction();
            $clinicId = $request->input('id'); 
            $receivedssaartformList = signup::with('artclinics.app_no')->whereHas('artclinics', function ($query) use ($clinicId) {
                $query->where('id', $clinicId); // Ensure correct column name
                })->first();
                // dd($receivedssaartformList);
            $certificate_details = new ArtClinicCertificateDetails();
            $certificate_details->application_no = $receivedssaartformList->artclinics->app_no->applicationno;
            $certificate_details->approved_rejected = $request->input('approved_rejected');
            $certificate_details->date_reg = $request->input('date_reg');
            $certificate_details->validity_upto = $request->input('validity_upto');
            $certificate_details->registration_no = $request->input('registration_no');        
            $certificate_details->date_rej = $request->input('date_rej');
            $certificate_details->rejection_no = $request->input('rejection_no');
            $certificate_details->userid = $receivedssaartformList->artclinics->userid;
            //dd($receivedssaartformList) ;
            
            
                // dd($clinicId);
            
            ClinicRegistration::insertclinicdata($receivedssaartformList, $request, $clinicId);
            $certificate_details->save();
        
            // $this->reg_handleFileUploads($request, $clinicId);   
            // dd($receivedssaartformList->artclinics->app_date_payment);
            $dataUpdt = ArtClinicModel::find($clinicId);       
            // Update only if fields are not empty`
            if (!empty($receivedssaartformList->artclinics->app_received)) {
                $dataUpdt->app_received = $receivedssaartformList->artclinics->app_received;
            //  dd('yddfuu');
            }
            if (!empty($receivedssaartformList->artclinics->fee_amount)) {
                $dataUpdt->fee_amount = $receivedssaartformList->artclinics->fee_amount;
            }
            if (!empty($receivedssaartformList->artclinics->mode_payment)) {
                $dataUpdt->mode_payment = $receivedssaartformList->artclinics->mode_payment;
            }
            if (!empty($receivedssaartformList->artclinics->app_date_payment)) {
                $dataUpdt->app_date_payment = $receivedssaartformList->artclinics->app_date_payment;
            }
            if (!empty($receivedssaartformList->artclinics->transaction_id)) {
                $dataUpdt->transaction_id = $receivedssaartformList->artclinics->transaction_id;
            }
            if (!empty($receivedssaartformList->artclinics->app_date_recieve)) {
                $dataUpdt->app_date_recieve = $receivedssaartformList->artclinics->app_date_recieve;
            }    
    // } 
        else {
            $dataUpdt = ArtClinicModel::find($clinicId); // Create new record if not found      
            $dataUpdt->app_received = 'received';
            $dataUpdt->fee_amount = $request->input('fee_amount', $dataUpdt->fee_amount);
            $dataUpdt->mode_payment = $request->input('mode_payment', $dataUpdt->mode_payment);
            $dataUpdt->app_date_payment = $request->input('app_date_payment', $dataUpdt->app_date_payment);
            $dataUpdt->transaction_id = $request->input('transaction_id', $dataUpdt->transaction_id);
            $dataUpdt->app_date_recieve = $request->input('app_date_recieve', $dataUpdt->app_date_recieve);
            $this->handleFileUploads($request, $clinicId);
            $dataUpdt->save();
            
        //  dd('ydd');

        }
    
        // Save only if fields were modified
        if ($dataUpdt->isDirty()) {
            $dataUpdt->update();
            $this->handleFileUploads($request, $clinicId);
        }
        DB::commit();   
        return redirect()->route('admin.reg_ssaForm_list')->with('upd_success', 'Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Art Clinic certificate issue failed: ' . $e->getMessage());
            return redirect()->route('admin.reg_receivedssaForm_list', $encryptId)->with('error', 'An error occurred while ART clinic registration.');

        }   
    }


    /*  Generate certificate function end */





    /*  Upload file function  start*/
    private function handleFileUploads(Request $request, $clinicId)
    {
        //$allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
        $allowedExtensions = ['pdf'];
        $docMasters = docmastertable::whereIn('doc_type', [
            'target_file_receiving_artclinic_docs'    
            // Add more document types here
        ])->where('status', 1)->get();
        // dd($docMasters);
            
        foreach ($docMasters as $docMaster) {
            $fileKey = str_replace('target_file_', '', $docMaster->doc_type);
            // dd($fileKey);
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                // dd($file);
                $extension = $file->getClientOriginalExtension();
                if (in_array(strtolower($extension), $allowedExtensions)) {
                    $dataUpdt = ArtClinicModel::find($clinicId);
                    $filename = $docMaster->doc_type . '-' . Carbon::now()->timestamp . '_' . $dataUpdt->userid . '.' . $extension;
                    $foldername = 'application_sa';
                    $baseDir = folderpath($foldername);
                    $application_no_folder= str_replace('/', '_', $dataUpdt->applicationno);
                    $fullFolderPath = $baseDir . $application_no_folder;
                    
                    // dd($fullFolderPath);
                    // Store the file in the 'noc_documents' directory in the public disk
                    if (!file_exists($fullFolderPath)) {
                            mkdir($fullFolderPath, 0777, true);
                        }
                    $filePath = $file->move($fullFolderPath, $filename);         
                    $dbpath = $filename;    
                    // Save the file information into the database
                    
                    
                    DocFilereceivedUpload::create([
                        'userid' => $dataUpdt->userid,
                        // 'clinic_id' => $clinicId,
                        'app_id' => $dataUpdt->id,
                        'doc_id' => $docMaster->id,
                        'doc_type' => $docMaster->doc_type,
                        'doc_upload_ref' => $dbpath,
                    ]);

                    // dd($dataUpdt);
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
}
