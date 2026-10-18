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

class BankAdminController extends Controller
{
    /*  Recevied Fees function starting start*/

    public function bankssaForm_list()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        $userId = Session::get('id');
        $stateName = Session::get('state_name');    
        $ssabankformList = signup::with('bankclinics.bapp_no')->whereHas('bankclinics.bapp_no')->where('state', $stateName)->where('status',1)->get();
        return view('layouts.admin.bank_ssa_form_list', compact('ssabankformList'));
    }

    public function banksearchApplication(Request $request)
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
        ->whereHas('bankclinics.bapp_no', function ($query) use ($applicationNo) {
            // Apply condition for applicationno in artclinics.app_no table
            $query->where('applicationno', 'LIKE', '%' . $applicationNo . '%')->where('status',1);
        })->get();
        if ($patient_list->isEmpty()) {
            return response()->json(['errorMessage' => 'No record found.']);
        }    
        // Encrypt the IDs before sending to frontend
        $patient_list->transform(function ($patient) {
            $patient->encrypted_id = encrypt($patient->bankclinics->bapp_no->id);
            $patient->encrypted_id1 = encrypt($patient->id);
            return $patient;
        });    
        return response()->json(['patient_list' => $patient_list]);
    }

    public function receivedbankssaForm_list($id)
    {

        // $url = url('/');
        // $parsed_url = parse_url($url);
        // $newUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        // $baseUrl = "$newUrl/noc_documents/";
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }

        $userId = Session::get('id');

        $stateName = Session::get('state_name');
        
        
        $decryptedId = Crypt::decrypt($id);

        $click_app = BankModel::where('userid', $decryptedId)->first();

        $clickID = $click_app->userid; 

        $receivedssabankformList = signup::with('bankclinics.bapp_no')->whereHas('bankclinics', function ($query) use ($clickID) {
            $query->where('userid', $clickID)->where('status',1); // Ensure correct column name
            })->first();

        return view('layouts.admin.received_ssa_bank_form_list', compact('receivedssabankformList'));
    }

    public function receive_bank_submitForm(Request $request)
    {  
        

        try {
            DB::beginTransaction(); // Start the transaction
            $bclinicId = $request->input('id');
            $user_id = encrypt($request->input('user_id'));
            $nature = $request->input('nature'); // Get nature from the request
            // Define validation rules based on nature
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
                $this->handleFileUploads_bank($request, $bclinicId); 
            }

            // Run validation
            $dataUpdt = $request->validate($rules);
            $dataUpdt['app_received'] = 'received';
            DB::table('artbank')->where('id', $bclinicId)->update($dataUpdt);
            DB::commit(); // Commit only if all operations succeeded
            return redirect()->route('admin.bank_ssaForm_list')->with('upd_success', 'Updated Successfully');
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack(); // Rollback transaction on validation failure
            return redirect()->route('admin.receivedbankssaForm_list', ['id' => $user_id])
                ->with('upd_error', 'An error occurred at server. Please try again.')
                ->withInput();

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on any other error
            Log::error('Error updating artbank record: ' . $e->getMessage());
            return redirect()->route('admin.receivedbankssaForm_list', ['id' => $user_id])
                ->with('upd_error', 'An error occurred while updating. Please try again.')
                ->withInput();
        }
    }

    public function reg_bank_ssaForm_list()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }

        //$userId = Session::get('id');

        //$stateName = Session::get('state_name'); 
        //$ssabankformList = signup::with('bankclinics.bapp_no')->whereHas('bankclinics.bapp_no')->where('state', $stateName)->get(); 
        //$regssabankformList = signup::with('bankclinics.bapp_no.artbank_id')->whereHas('bankclinics.bapp_no.artbank_id')->where('state', $stateName)->where('status',1)->get();
        return view('layouts.admin.reg_bank_ssa_form_list');
    }

    public function regbanksearchApplication(Request $request)
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
        // ->whereHas('bankclinics.bapp_no', function ($query) use ($applicationNo) {
        //     // Apply condition for applicationno in artclinics.app_no table
        //     $query->where('applicationno', 'LIKE', '%' . $applicationNo . '%')->where('status',1);
        // })->get();
        $patient_list = signup::where('state', $stateName)
                        ->whereHas('bankclinics', function ($query) use ($applicationNo) {
                            $query->whereIn('archive_status', [0, 1]) // ✅ only allow 0 and 1
                                ->whereHas('bapp_no', function ($q) use ($applicationNo) {
                                    $q->where('applicationno', 'LIKE', '%' . $applicationNo . '%');
                                });
                        })
                        ->get();

        if ($patient_list->isEmpty()) {
            return response()->json(['errorMessage' => 'No record found.']);
        }    
        // Encrypt the IDs before sending to frontend
        $patient_list->transform(function ($patient) {
            $patient->encrypted_id = encrypt($patient->bankclinics->bapp_no->id ?? 0);
            $patient->encrypted_id2 = @$patient->bankclinics->bapp_no->artbank_id->id ?? 0;
            $patient->encrypted_id1 = encrypt($patient->id);
            $patient->encrypted_id3 = encrypt(@$patient->bankclinics->id ?? 0);
            // $patient->date_reg = $patient->surrogacyclinics->certificate->date_reg ?? null;
            return $patient;
        });
        // $regssabankformList = signup::with('bankclinics.bapp_no.artbank_id')->whereHas('bankclinics.bapp_no.artbank_id')->where('state', $stateName)->get();    
        $regssabankformList = signup::with('bankclinics.bapp_no.artbank_id')
                                ->whereHas('bankclinics', function ($query) {
                                    $query->whereIn('archive_status', [0, 1]);
                                })
                                ->whereHas('bankclinics.bapp_no.artbank_id')
                                ->where('state', $stateName)
                                ->get();
        return response()->json(['patient_list' => $patient_list,'regssabankformList'=> $regssabankformList]);
    }

    public function reg_receivedbankssaForm_list($id)
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }

        $userId = Session::get('id');

        $stateName = Session::get('state_name');   
        $decryptedId = Crypt::decrypt($id);
        $click_app = signup::find($decryptedId);
        $clickID = $click_app->id;
        $receivedssabankformList = signup::with('bankclinics.bapp_no')->whereHas('bankclinics', function ($query) use ($clickID) {
         $query->where('userid', $clickID)->where('status',1); // Ensure correct column name
         })->first();
         $dataDocMaster = DB::table('doc_masters')
         ->select('doc_masters.*')
         ->whereIn('doc_type', [
             'target_file_receiving_artbank_docs',             
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
            ->where('app_id', $receivedssabankformList->bankclinics->id)
            ->get();  
        $application_no_folder= str_replace('/', '_', $receivedssabankformList->bankclinics->bapp_no->applicationno);      
        $regssabankformList = signup::with('bankclinics.bapp_no.artbank_id')
                ->whereHas('bankclinics', function ($query) {
                    $query->where('status', 1) // ensure only active bankclinics
                        ->whereHas('bapp_no.artbank_id'); // ensure nested relation exists
                })
                ->where('state', $stateName)
                ->first();
        return view('layouts.admin.reg_received_ssa_bank_form_list', compact('receivedssabankformList','regssabankformList','get_docfileData','application_no_folder'));
    }

    public function reg_receive_bank_submitForm(Request $request)
    {
        Log::info('Controller: reg_receive_bank_submitForm called.');
        
         // Start transaction

        try {
            $userid = $request->input('userid');
            $encryptId = Crypt::encrypt($userid);
            DB::beginTransaction();
            $bclinicId = $request->input('id');       
            $receivedssabankformList = signup::with('bankclinics.bapp_no')->whereHas('bankclinics', function ($query) use ($bclinicId) {
                $query->where('id', $bclinicId)->where('status', 1);
            })->first(); 

            if (!$receivedssabankformList || !$receivedssabankformList->bankclinics) {
                throw new \Exception('Related bank clinic record not found.');
            }
            $certificate_details = new BankCertificateDetails();
            $certificate_details->application_no = $receivedssabankformList->bankclinics->bapp_no->applicationno;
            $certificate_details->approved_rejected = $request->input('approved_rejected');
            $certificate_details->date_reg = $request->input('date_reg');
            $certificate_details->validity_upto = $request->input('validity_upto');
            $certificate_details->registration_no = $request->input('registration_no');
            $certificate_details->date_rej = $request->input('date_rej');
            $certificate_details->rejection_no = $request->input('rejection_no');
            $certificate_details->userid = $receivedssabankformList->bankclinics->userid;
            // Insert Art Bank Data
            ClinicRegistration::insertArtBankData($receivedssabankformList, $request, $bclinicId);

            // Save certificate details
            $certificate_details->save();

            // Update existing or set new values
            $dataUpdt = BankModel::find($bclinicId);

            if (!empty($receivedssabankformList->bankclinics->app_received)) {
                $dataUpdt->app_received = $receivedssabankformList->bankclinics->app_received;       
            }
            if (!empty($receivedssabankformList->bankclinics->fee_amount)) {
                $dataUpdt->fee_amount = $receivedssabankformList->bankclinics->fee_amount;
            }
            if (!empty($receivedssabankformList->bankclinics->mode_payment)) {
                $dataUpdt->mode_payment = $receivedssabankformList->bankclinics->mode_payment;
            }
            if (!empty($receivedssabankformList->bankclinics->app_date_payment)) {
                $dataUpdt->app_date_payment = $receivedssabankformList->bankclinics->app_date_payment;
            }
            if (!empty($receivedssabankformList->bankclinics->transaction_id)) {
                $dataUpdt->transaction_id = $receivedssabankformList->bankclinics->transaction_id;
            }
            if (!empty($receivedssabankformList->bankclinics->app_date_recieve)) {
                $dataUpdt->app_date_recieve = $receivedssabankformList->bankclinics->app_date_recieve;
            } else {
                // fallback assignments
                $dataUpdt->app_received = 'received';
                $dataUpdt->fee_amount = $request->input('fee_amount', $dataUpdt->fee_amount);
                $dataUpdt->mode_payment = $request->input('mode_payment', $dataUpdt->mode_payment);
                $dataUpdt->app_date_payment = $request->input('app_date_payment', $dataUpdt->app_date_payment);
                $dataUpdt->transaction_id = $request->input('transaction_id', $dataUpdt->transaction_id);
                $dataUpdt->app_date_recieve = $request->input('app_date_recieve') ?? $receivedssabankformList->bankclinics->app_date_recieve ?? $dataUpdt->app_date_recieve;
                $this->handleFileUploads_bank($request, $bclinicId);
                $dataUpdt->save();
            }

            // Update only if dirty
            if ($dataUpdt->isDirty()) {
                $dataUpdt->update();

                // Handle file uploads after successful update
                $this->handleFileUploads_bank($request, $bclinicId);
            }

            DB::commit(); // ✅ Commit only after all succeed

            return redirect()->route('admin.bank_reg_ssaForm_list')->with('upd_success', 'Updated Successfully');
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack(); // ❌ rollback on validation error
            Log::error('validation failed: ' . $e->getMessage());
            return redirect()->route('admin.reg_receivedbankssaForm_list', $encryptId)->withErrors($e->validator)->withInput();

        } catch (\Exception $e) {
            DB::rollBack(); // ❌ rollback on general exception
            Log::error('Error in reg_receive_bank_submitForm: ' . $e->getMessage());
            return redirect()->route('admin.reg_receivedbankssaForm_list', $encryptId)->with('upd_error', 'An error occurred while ART Bank registration.');
        }   
    }

    /*  Recevied Fees function End*/


    /*  File Upload function start*/
    private function handleFileUploads_bank(Request $request, $bclinicId)
    {
        $allowedExtensions = ['pdf'];
        $docMasters = docmastertable::whereIn('doc_type', ['target_file_receiving_artbank_docs'])->where('status', 1)->get();
           
        foreach ($docMasters as $docMaster) {
            $fileKey = str_replace('target_file_', '', $docMaster->doc_type);
           
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
             //   dd($file);
                $extension = $file->getClientOriginalExtension();
                // Validate the file extension
                //dd($extension);
                if (in_array(strtolower($extension), $allowedExtensions)) {
                    $dataUpdt = BankModel::find($bclinicId);
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
                        // 'clinic_id' => $bclinicId,
                        'app_id' => $dataUpdt->id,
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

    /*  File Upload function end*/
}
