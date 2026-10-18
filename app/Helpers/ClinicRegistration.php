<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use App\Events\FolderMissingEvent;
use Illuminate\Validation\ValidationException;

use App\Models\renewal\RenewalSCApplication;
use App\Models\renewal\RenewalSCDirector;
use App\Models\renewal\RenewalSCEquipment;
use App\Models\renewal\RenewalSCStaff;
use App\Models\clinic\ClinicRegistrationModel;



class ClinicRegistration
{
    public static function insertArtBankData($receivedssabankformList, $request, $bclinicId)
    {
                try {
                    $lastId = DB::table('clinic_registration')->orderBy('id', 'desc')->value('id');
                    //dd($lastId);
                    $allowedExtensions = ["pdf", "jpeg", "jpg", "gif"];
                    //$docType = DB::table('doc_masters')->where('status', 1)->where('doc_type', 'target_file_reg_artbank_certificate')->value('doc_type'); 

                    $request->validate([
                                'reg_artbank_certificate' => 'required|file|mimes:pdf,jpeg,jpg,gif|max:200',
                    ]);
                    
                    $file = $request->file('reg_artbank_certificate');
                    // Define folder names
                    
                    //$oldfolderpath = 'art_clinic_certificate';
                    $timestamp = date('Y-m-d_His');

                    $originalExtension = $file->getClientOriginalExtension();
                    //dd($receivedssabankformList);
                    //$fileKey = str_replace('target_file_', '', $docType);
                    if (in_array(strtolower($originalExtension), $allowedExtensions)){
                    $filename2 = 'target_file_reg_artbank_certificate' . $timestamp . '_' . $receivedssabankformList->id . '.' . $originalExtension;
                    $dbpath = $filename2;

                    }else {
                        // Throw a custom exception
                        throw new \Exception("File type not allowed. Allowed types are: " . implode(', ', $allowedExtensions));
                    }
                    if($request->input('approved_rejected')=='Registration Rejected') {
                        // Get full paths
                        //$foldername = 'application_sa';
                        //$destinationPath = folderpath($foldername); // Assume this returns full path like storage_path('app/public/clinic_registration_certificate')
                        //dd($destinationPath);
                        //$destinationPath2 = folderpath($oldfolderpath);
                        // Generate a unique clinic ID folder
                        //$clinic_id_gen = 3000 + $lastId + 1;
                        $filename2 = 'target_file_rejected_artbank_certificate' . $timestamp . '_' . $receivedssabankformList->id . '.' . $originalExtension;
                        $application_no_folder= str_replace('/', '_', $receivedssabankformList->bankclinics->bapp_no->applicationno);
                        $foldername = 'application_sa';
                        $baseDir = folderpath($foldername);
                        $fullFolderPath = $baseDir . $application_no_folder;
                        DB::table('artbank_certificate_details')
                            ->where('userid', $receivedssabankformList->bankclinics->userid) // 👈 your extra condition
                            ->update(['reg_no_file' => $filename2]);


                        $physicalIncomplete= [
                            'appstatus' => 'Rejected',
                            'incomplete_withdrawal_cancelled' => $request->input('incomplete_withdrawal_cancelled'),
                            'physical_application' => $request->input('physical_application'),
                            'reason_for_rejection' => $request->input('reason_for_rejection')
                        ];

                        DB::table('artbank')
                            ->where('userid', $receivedssabankformList->bankclinics->userid) // 👈 your extra condition
                            ->update($physicalIncomplete);
                        // Create the folder if it doesn't exist
                        if (!File::exists($fullFolderPath)) {
                            File::makeDirectory($fullFolderPath, 0755, true);
                        }

                        // Move file to the primary destination folder
                        $file->move($fullFolderPath, $filename2);

                    }
                    else if($request->input('approved_rejected')=='Registration Granted'){
                    $foldername = 'clinic_registration_certificate';
                    $docMasters = DB::table('doc_masters')->whereIn('doc_type', ['target_file_reg_artbank_certificate'])->where('status', 1)->first();
                    // Get full paths
                    $destinationPath = folderpath($foldername); // Assume this returns full path like storage_path('app/public/clinic_registration_certificate')
                    //$destinationPath2 = folderpath($oldfolderpath);
                    // Generate a unique clinic ID folder
                    $clinic_id_gen = $lastId + 1;
                    $fullFolderPath = $destinationPath . '/' . $clinic_id_gen;

                
                    
                    // Create the folder if it doesn't exist
                    if (!File::exists($fullFolderPath)) {
                        File::makeDirectory($fullFolderPath, 0755, true);
                    }

                    // Move file to the primary destination folder
                    $file->move($fullFolderPath, $filename2);
                    
                    // Copy file to secondary destination (after it's been moved)
                    //copy($primaryFilePath->getRealPath(), $destinationPath2 . '/' . $filename2);

                    // Save filename for DB
                    

                    if ($receivedssabankformList) {
                        DB::table('doc_file_uploads_registration_certificate')->insert([
                            'userid' => $receivedssabankformList->bankclinics->userid,
                            'clinic_id' => $lastId + 1,
                            'app_id' => $bclinicId,
                            'doc_id' => $docMasters->id,
                            'doc_type' => $docMasters->doc_type,
                            'doc_upload_ref' => $dbpath,
                        ]);
                    }
                    DB::table('artbank')
                            ->where('userid', $receivedssabankformList->bankclinics->userid) // 👈 your extra condition
                            ->update(['appstatus' => 'Approved']);
                 // Step 1: Prepare FETDATA data
              $staffdata = DB::table('artbank_otherstaff')->select('*')->where('userid', $receivedssabankformList->bankclinics->userid)->where('artbank_id', $bclinicId)->get();


                  $insertData = [];

                    // Step 2: Prepare insert data
                    foreach ($staffdata as $data) {
                        $insertData[] = [
                            'clinic_id'          => $lastId+1,
                            'name'               => $data->name_otherstaff,
                            'post'               => $data->designation_otherstaff,
                            'qualification'      => $data->quali_otherstaff,
                            'application_no'     => $receivedssabankformList->bclinicId->applicationno ?? null,
                            'status'             => 1,
                            'clinic_type'        => 'ARTBANK',
                            'type_emp'           => 'CLINICBANKSSTAFF',
                            'created_at'         => now(),
                            'updated_at'         => now(),
                            'validitydate'       => now()
                        ];
                    }

                    // Step 3: Insert into second table
                    if(!empty($insertData)){
                    DB::table('tbl_clinic_staff')->insert($insertData);
                    }

                    // Step 201: Prepare FETDATA data
                  $equipdata = DB::table('artbank_equipment')->select('*')
                  ->where('userid', $receivedssabankformList->bankclinics->userid)
                  ->where('artbank_id', $bclinicId)
                  ->get();


                  $equipdatainsertData = [];

                    // Step 202: Prepare insert data
                    foreach ($equipdata as $data) {
                        $equipdatainsertData[] = [
                            'clinic_id'          => $lastId+1,
                            'equipmentname'      => $data->equipmentname,
                            'application_no'     => $receivedssabankformList->bankclinics->applicationno ?? null,
                            'status'             => 1,
                            'clinic_type'        => 'ARTBANK',
                            'created_at'         => now(),
                            'updated_at'         => now(),
                            'validitydate'       => now()
                        ];
                    }

                    // Step 203: Insert into second table
                    if(!empty($equipdatainsertData)){
                    DB::table('tbl_clinic_equipment')->insert($equipdatainsertData);
                    }


                    
                

                    $artdata = [
                        'name'                          => $receivedssabankformList->clinicname,
                        'address'                       => $receivedssabankformList->address,
                        'state'                         => $receivedssabankformList->state,
                        'district'                      => $receivedssabankformList->district, // Corrected key
                        'pincode'                       => $receivedssabankformList->pincode,
                        'mobile'                        => $receivedssabankformList->bankclinics->contact_person_mobile,
                        'email'                         => $receivedssabankformList->bankclinics->email,
                        'nature'                        => $receivedssabankformList->nature,
                        'contact_number_clinic'         => $receivedssabankformList->contactno,
                        'fax_number'                    => $receivedssabankformList->bankclinics->fax,
                        'apply_registration'            => $receivedssabankformList->cliniclevel,
                        'website'                       => $receivedssabankformList->bankclinics->website,
                        'date_of_establishment'         => $receivedssabankformList->bankclinics->dateestab,
                        'clinic_reg_mpt'                => $receivedssabankformList->bankclinics->mtpact,
                        'clinic_reg_pcpndt'             => $receivedssabankformList->bankclinics->pcpndtact,
                        'clinic_director'               => $receivedssabankformList->bankclinics->director,
                        'iui_h_s'                       => $receivedssabankformList->bankclinics->iuih,
                        'iui_d_s'                       => $receivedssabankformList->bankclinics->iuid,
                        'ivf_et'                        => $receivedssabankformList->bankclinics->ivfet,
                        'icsi'                          => $receivedssabankformList->bankclinics->icsi,
                        'pgt'                           => $receivedssabankformList->bankclinics->pgt,
                        'sperm_oocyte'                  => $receivedssabankformList->bankclinics->spermandoocyte,
                        'any_other_procedure'           => $receivedssabankformList->bankclinics->anyotherprocedure,
                        'otherprocedure'                => $receivedssabankformList->bankclinics->otherprocedure,
                        'contact_person_name'           => $receivedssabankformList->bankclinics->contact_person_name,
                        'contact_person_email'          => $receivedssabankformList->bankclinics->contact_person_email,
                        'any_other_detail'              => $receivedssabankformList->bankclinics->otherdetails,
                        'ejaculation'                   => $receivedssabankformList->bankclinics->ejaculation,
                        'electrojaculation'             => $receivedssabankformList->bankclinics->electroejaculation,
                        'processing_sperm'              => $receivedssabankformList->bankclinics->processingsperm,
                        'storage_sperm'                 => $receivedssabankformList->bankclinics->storagesperm,
                        'oocyte_doner'                  => $receivedssabankformList->bankclinics->oocytedonor,
                        'cryopreservation_of_sperm'     => $receivedssabankformList->bankclinics->cryopreservation,
                        'methode_of_freezing_of_sperm'  => $receivedssabankformList->bankclinics->spermslow,
                        'sperm_vitrification'           => $receivedssabankformList->bankclinics->spermvitrification,
                        'freezing_of_testicular_tissue' => $receivedssabankformList->bankclinics->tisticulartissue,
                        'application_no'                => $receivedssabankformList->bankclinics->bapp_no->applicationno,
                        'registration_no'               => $request->input('registration_no'),
                        'certificate_valid_date'        => $request->input('validity_upto'),
                        'certificate_path'              => $dbpath,
                        'status'                        => 1,
                        'clinic_type'                   => 'ARTBANK',
                        'clinic_id'                     => $lastId+1,
                        'userid_applicant'              => $receivedssabankformList->bankclinics->userid,
                        'rgistration_date'              => $request->input('date_reg'),
                        'first_registration_date'       => $request->input('date_reg'),
                        'state_authority_id'            => Session::get('id'),
                        'verify_certificate'            => 1,
                        'created_date'                  => now(),
                        'update_date'                   => now(),
                        'validitydate'                  => now(),
                        'ip_address'                    => getHostByName(getHostName())
                    ];

                    // Insert the data into the database
                    try {
                        DB::table('clinic_registration')->insert($artdata);
                    } catch (\Exception $e){
                        Log::error('Error inserting ART Bank data: ' . $e->getMessage());
                        throw $e;  // Or handle it however you'd like
                        return redirect()->back()->with('error', 'Failed to insert data. Please try again.');
                    }
                    }
                Log::debug('File uploaded:', ['filename' => $filename2, 'filePath' => $fullFolderPath]);
                }
                catch (\Exception $e){
                        Log::error('Error inserting ART Bank data: ' . $e->getMessage());
                        throw $e;  // Or handle it however you'd like
                        return redirect()->back()->with('error', 'Failed to insert data. Please try again.');
                }
                
        }

    public static function insertclinicdata($receivedssaartformList, $request, $clinicId )
    {         
        $lastId = DB::table('clinic_registration')->orderBy('id', 'desc')->value('id');
            $allowedExtensions = ["pdf", "jpeg", "jpg", "gif"];
            //$oldfolderpath = 'art_clinic_certificate';
                    $timestamp = date('Y-m-d_His');
                    $request->validate([
                        'reg_artclinic_certificate' => 'required|file|mimes:pdf,jpeg,jpg,gif|max:200',
                     ]);
                    
                    $file = $request->file('reg_artclinic_certificate');
                    $originalExtension = $file->getClientOriginalExtension();
                    //$fileKey = str_replace('target_file_', '', $docType);
                    // dd($originalExtension);
                    //dd($receivedssaartformList);
                    if (in_array(strtolower($originalExtension), $allowedExtensions)){
                    $filename2 = 'target_file_reg_artclinic_certificate' . $timestamp . '_' . $receivedssaartformList->id . '.' . $originalExtension;
                    $dbpath = $filename2;
                    // dd($filename2);

                    }else {
                        // Throw a custom exception
                        throw new \Exception("File type not allowed. Allowed types are: " . implode(', ', $allowedExtensions));
                    }
                    if($request->input('approved_rejected')=='Registration Rejected') {
                        // Get full paths
                        //$foldername = 'application_sa';
                        //$destinationPath = folderpath($foldername); // Assume this returns full path like storage_path('app/public/clinic_registration_certificate')
                        //dd($destinationPath);
                        //$destinationPath2 = folderpath($oldfolderpath);
                        // Generate a unique clinic ID folder
                        //$clinic_id_gen = 3000 + $lastId + 1;
                        $filename2 = 'target_file_rejected_artclinic_certificate' . $timestamp . '_' . $receivedssaartformList->id . '.' . $originalExtension;
                        $application_no_folder= str_replace('/', '_', $receivedssaartformList->artclinics->app_no->applicationno);
                        $foldername = 'application_sa';
                        $baseDir = folderpath($foldername);
                        $fullFolderPath = $baseDir . $application_no_folder;
                        DB::table('artclinic_certificate_details')
                            ->where('userid', $receivedssaartformList->artclinics->userid) 
                            ->update(['reg_no_file' => $filename2]);

                        $physicalIncomplete= [
                            'appstatus' => 'Rejected',
                            'incomplete_withdrawal_cancelled' => $request->input('incomplete_withdrawal_cancelled'),
                            'physical_application' => $request->input('physical_application'),
                            'reason_for_rejection' => $request->input('reason_for_rejection')
                        ];

                        
                        DB::table('artclinic')
                            ->where('userid', $receivedssaartformList->artclinics->userid) 
                            ->update($physicalIncomplete);
                        // Create the folder if it doesn't exist
                        if (!File::exists($fullFolderPath)) {
                            File::makeDirectory($fullFolderPath, 0755, true);
                        }

                        // Move file to the primary destination folder
                        $file->move($fullFolderPath, $filename2);

                    }
                    else if($request->input('approved_rejected')=='Registration Granted'){    
                    $foldername = 'clinic_registration_certificate';
                    // Get full paths
                    $docMasters = DB::table('doc_masters')->whereIn('doc_type', ['target_file_reg_artclinic_certificate'])->where('status', 1)->first();
                    $destinationPath = folderpath($foldername); // Assume this returns full path like storage_path('app/public/clinic_registration_certificate')
                    $clinic_id_gen = $lastId + 1;
                    $fullFolderPath = $destinationPath . '/' . $clinic_id_gen;
                    // Create the folder if it doesn't exist
                    if (!File::exists($fullFolderPath)) {
                        File::makeDirectory($fullFolderPath, 0777, true);
                    }
                    // Move file to the primary destination folder
                    $file->move($fullFolderPath, $filename2);
                    

                // Save filename for DB
                $dbpath = $filename2;
                DB::table('artclinic')
                            ->where('userid', $receivedssaartformList->artclinics->userid) // 👈 your extra condition
                            ->update(['appstatus' => 'Approved']);
                $cert_data = [
                        'userid' => $receivedssaartformList->artclinics->userid,
                        'clinic_id' => $lastId + 1,
                        'app_id' => $clinicId,
                        'doc_id' => $docMasters->id,
                        'doc_type' => $docMasters->doc_type,
                        'doc_upload_ref' => $dbpath,
                ];
                // dd($cert_data);
                if ($receivedssaartformList) {
                    DB::table('doc_file_uploads_registration_certificate')->insert($cert_data);
                }                

                    // Step 1: Prepare FETDATA data
                  $staffdata = DB::table('artclinic_otherstaff')->select('*')
                  ->where('userid', $receivedssaartformList->artclinics->userid)
                  ->where('artclinic_id', $clinicId)
                  ->get();

                    $insertData = [];

                    // Step 2: Prepare insert data
                    foreach ($staffdata as $data) {
                        $insertData[] = [
                            'clinic_id'          => $lastId+1,
                            'name'               => $data->name_otherstaff,
                            'post'               => $data->post_otherstaff,
                            'qualification'      => $data->quali_otherstaff,
                            'application_no'     => $receivedssaartformList->artclinics->applicationno,
                            'regno'              => $data->regno,
                            'status'             => 1,
                            'clinic_type'        => 'ARTCLINIC',
                            'type_emp'           => 'ARTCLINICSTAFF',
                            'created_at'         => now(),
                            'updated_at'         => now(),
                            'validitydate'       => now()
                        ];
                    }

                    // Step 3: Insert into second table
                    if(!empty($insertData)){
                    DB::table('tbl_clinic_staff')->insert($insertData);
                    }


                    // Step 101: Prepare FETDATA data
                    $directordata = DB::table('artclinic_director')->select('*')
                  ->where('userid', $receivedssaartformList->artclinics->userid)
                  ->where('artclinic_id', $clinicId)
                  ->get();


                  $directinsertData = [];

                    // Step 102: Prepare insert data
                    foreach ($directordata as $data) {
                        $directinsertData[] = [
                            'clinic_id'           => $lastId+1,
                            'name_director'       => $data->name_director,
                            'quali_director'      => $data->quali_director,
                            'reg_director'        => $data->reg_director,
                            'application_no'      =>  $receivedssaartformList->artclinics->applicationno,
                            'status'              => 1,
                            'clinic_type'         => 'ARTCLINIC',
                            'created_at'          => now(),
                            'updated_at'          => now(),
                            'validitydate'        => now()
                        ];
                    }

                    // Step 103: Insert into second table
                    if(!empty($directinsertData)){
                        DB::table('tbl_director_staff')->insert($directinsertData);
                    }


                      // Step 301: Prepare FETDATA data
                  $equipartclinicdata = DB::table('artclinic_equipment')->select('*')
                  ->where('userid', $receivedssaartformList->artclinics->userid)
                  ->where('artclinic_id', $clinicId)
                  ->get();


                  $equipartclinicdataarr = [];

                    // Step 302: Prepare insert data
                 foreach ($equipartclinicdata as $dataval) {
                        $equipartclinicdataarr[] = [
                            'clinic_id'      => $lastId + 1,
                            'equipmentname'  => "$dataval->equipmentname",
                            'application_no' => $receivedssaartformList->artclinics->applicationno,
                            'status'         => 1,
                            'clinic_type'    => 'ARTCLINIC',
                            'created_at'     => now(),
                            'updated_at'     => now(),
                            'validitydate'   => now()
                        ];
                    }

                    // Insert only if the array is not empty
                    if (!empty($equipartclinicdataarr)) {
                        DB::table('tbl_clinic_equipment')->insert($equipartclinicdataarr);
                    }              
                  
                
                Log::debug('File uploaded:', ['filename' => $filename2, 'filePath' => $fullFolderPath]);

                    $artdata = [
                        'level'                         => $receivedssaartformList->artclinics->cliniclevel,
                        'name'                          => $receivedssaartformList->clinicname,
                        'address'                       => $receivedssaartformList->address,
                        'state'                         => $receivedssaartformList->state,
                        'district'                      => $receivedssaartformList->district, // Corrected key
                        'pincode'                       => $receivedssaartformList->pincode,
                        'mobile'                        => $receivedssaartformList->artclinics->contact_person_mobile,
                        'email'                         => $receivedssaartformList->artclinics->email,
                        'nature'                        => $receivedssaartformList->nature,
                        'contact_number_clinic'         => $receivedssaartformList->contactno,
                        'fax_number'                    => $receivedssaartformList->artclinics->fax,
                        'apply_registration'            => $receivedssaartformList->cliniclevel,
                        'website'                       => $receivedssaartformList->artclinics->website,
                        'date_of_establishment'         => $receivedssaartformList->artclinics->dateestab,
                        'clinic_reg_mpt'                => $receivedssaartformList->artclinics->mtpact,
                        'clinic_reg_pcpndt'             => $receivedssaartformList->artclinics->pcpndtact,
                        'clinic_director'               => $receivedssaartformList->artclinics->director,
                        'iui_h_s'                       => $receivedssaartformList->artclinics->iuih,
                        'iui_d_s'                       => $receivedssaartformList->artclinics->iuid,
                        'ivf_et'                        => $receivedssaartformList->artclinics->ivfet,
                        'icsi'                          => $receivedssaartformList->artclinics->icsi,
                        'pgt'                           => $receivedssaartformList->artclinics->pgt,
                        'sperm_oocyte'                  => $receivedssaartformList->artclinics->spermandoocyte,
                        'any_other_procedure'           => $receivedssaartformList->artclinics->anyotherprocedure,
                        'otherprocedure'                => $receivedssaartformList->artclinics->otherprocedure,
                        'contact_person_name'           => $receivedssaartformList->artclinics->contact_person_name,
                        'contact_person_email'          => $receivedssaartformList->artclinics->contact_person_email,
                        'any_other_detail'              => $receivedssaartformList->artclinics->otherdetails,
                        'ejaculation'                   => $receivedssaartformList->artclinics->ejaculation,
                        'electrojaculation'             => $receivedssaartformList->artclinics->electroejaculation,
                        'processing_sperm'              => $receivedssaartformList->artclinics->processingsperm,
                        'storage_sperm'                 => $receivedssaartformList->artclinics->storagesperm,
                        'oocyte_doner'                  => $receivedssaartformList->artclinics->oocytedonor,
                        'cryopreservation_of_sperm'     => $receivedssaartformList->artclinics->cryopreservation,
                        'methode_of_freezing_of_sperm'  => $receivedssaartformList->artclinics->spermslow,
                        'sperm_vitrification'           => $receivedssaartformList->artclinics->spermvitrification,
                        'freezing_of_testicular_tissue' => $receivedssaartformList->artclinics->tisticulartissue,
                        'application_no'                => $receivedssaartformList->artclinics->applicationno,
                        'registration_no'               => $request->input('registration_no'),
                        'certificate_valid_date'        => $request->input('validity_upto'),
                        'certificate_path'              => $dbpath,
                        'status'                        => 1,
                        'clinic_type'                   => 'ARTCLINIC',
                        'clinic_id'                     => $lastId+1,
                        'userid_applicant'              => $receivedssaartformList->artclinics->userid,
                        'rgistration_date'              => $request->input('date_reg'),
                        'first_registration_date'       => $request->input('date_reg'),
                        'state_authority_id'            => Session::get('id'),
                        'verify_certificate'            => 1,
                        'created_date'                  => now(),
                        'update_date'                   => now(),
                        'validitydate'                  => now(),
                        'ip_address'                    => getHostByName(getHostName())
                    ];

                //    dd($artdata);
                    // Insert the data into the database
                    try {
                        //DB::enableQueryLog();
                        DB::table('clinic_registration')->insert($artdata);
                     //   dd($artdata);
                
               // dd(DB::getQueryLog());
                    } catch (\Exception $e) {
                        Log::error('Error inserting ART clinic data: ' . $e->getMessage());
                        throw $e;  // Or handle it however you'd like
                        return redirect()->back()->with('error', 'Failed to insert data. Please try again.');
                    }
                }
         }

    public static function insertsurrogacydata($receivedssasurrogacyformList, $request, $sclinicId)
    {
        // Begin a database transaction
        try {
            // Fetch last clinic ID
            $lastId = DB::table('clinic_registration')->orderBy('id', 'desc')->value('id');
            $allowedExtensions = ["pdf", "jpeg", "jpg", "gif"];
            $timestamp = date('Y-m-d_His');
            $request->validate([
                'reg_surrogacyclinic_certificate' => 'required|file|mimes:pdf,jpeg,jpg,gif|max:200',
            ]);
                    
            $file = $request->file('reg_surrogacyclinic_certificate');

            $originalExtension = $file->getClientOriginalExtension();
            if (in_array(strtolower($originalExtension), $allowedExtensions)){
                    $filename2 = 'target_file_reg_surrogacyclinic_certificate' . $timestamp . '_' . $receivedssasurrogacyformList->id . '.' . $originalExtension;
                    $dbpath = $filename2;

                    }else {
                        // Throw a custom exception
                        throw new \Exception("File type not allowed. Allowed types are: " . implode(', ', $allowedExtensions));
                    }
                if($request->input('approved_rejected')=='Registration Rejected') {
                        // Get full paths
                        //$foldername = 'application_sa';
                        //$destinationPath = folderpath($foldername); // Assume this returns full path like storage_path('app/public/clinic_registration_certificate')
                        //dd($destinationPath);
                        //$destinationPath2 = folderpath($oldfolderpath);
                        // Generate a unique clinic ID folder
                        //$clinic_id_gen = 3000 + $lastId + 1;
                        $filename2 = 'target_file_rejected_surrogacyclinic_certificate' . $timestamp . '_' . $receivedssasurrogacyformList->id . '.' . $originalExtension;
                        $application_no_folder= str_replace('/', '_', $receivedssasurrogacyformList->surrogacyclinics->sapp_no->applicationno);
                        $foldername = 'application_sa';
                        $baseDir = folderpath($foldername);
                        $fullFolderPath = $baseDir . $application_no_folder;
                        DB::table('surrogacy_certificate_details')
                            ->where('userid', $receivedssasurrogacyformList->surrogacyclinics->userid) // 👈 your extra condition
                            ->update(['reg_no_file' => $filename2]);

                        $physicalIncomplete= [
                            'appstatus' => 'Rejected',
                            'incomplete_withdrawal_cancelled' => $request->input('incomplete_withdrawal_cancelled'),
                            'physical_application' => $request->input('physical_application'),
                            'reason_for_rejection' => $request->input('reason_for_rejection')
                        ];

                        DB::table('surrogacyclinic')
                            ->where('userid', $receivedssasurrogacyformList->surrogacyclinics->userid) // 👈 your extra condition
                            ->update($physicalIncomplete);
                        // Create the folder if it doesn't exist
                        if (!File::exists($fullFolderPath)) {
                            File::makeDirectory($fullFolderPath, 0755, true);
                        }

                        // Move file to the primary destination folder
                        $file->move($fullFolderPath, $filename2);
                } 
                else if($request->input('approved_rejected')=='Registration Granted'){
                    
                    $foldername = 'clinic_registration_certificate';
                    // Get full paths
                    $docMasters = DB::table('doc_masters')->whereIn('doc_type', ['target_file_reg_surrogacyclinic_certificate'])->where('status', 1)->first();
                    $destinationPath = folderpath($foldername); // Assume this returns full path like storage_path('app/public/clinic_registration_certificate')
                    $clinic_id_gen = $lastId + 1;
                    $fullFolderPath = $destinationPath . '/' . $clinic_id_gen;
                    // Create the folder if it doesn't exist
                    if (!File::exists($fullFolderPath)) {
                        File::makeDirectory($fullFolderPath, 0755, true);
                    }
                    
                    // Move file to the primary destination folder
                    $file->move($fullFolderPath, $filename2);

                    // Save filename for DB
                    $dbpath = $filename2;
                    DB::table('surrogacyclinic')
                                ->where('userid', $receivedssasurrogacyformList->surrogacyclinics->userid) 
                                ->update(['appstatus' => 'Approved']);
                    if ($receivedssasurrogacyformList) {
                        // Insert doc file upload
                        DB::table('doc_file_uploads_registration_certificate')->insert([
                            'userid' => $receivedssasurrogacyformList->surrogacyclinics->userid,
                            'clinic_id' => $lastId + 1,
                            'app_id' => $sclinicId,
                            'doc_id' => $docMasters->id,
                            'doc_type' => $docMasters->doc_type,
                            'doc_upload_ref' => $dbpath,
                        ]);
                    }

                    $staffdata = DB::table('surrogacyclinic_otherstaff')->where('userid', $receivedssasurrogacyformList->surrogacyclinics->userid)
                        ->where('surrogacyclinic_id', $sclinicId)->get();

                    $insertData = [];
                    foreach ($staffdata as $data) {
                        $insertData[] = [
                            'clinic_id' => $lastId + 1,
                            'name' => $data->name_otherstaff,
                            'post' => $data->post_otherstaff,
                            'qualification' => $data->quali_otherstaff,
                            'application_no' => $receivedssasurrogacyformList->surrogacyclinics->applicationno,
                            'regno' => $data->regno,
                            'status' => 1,
                            'clinic_type' => 'ARTSURROGACY',
                            'type_emp' => 'SURROGACYCLINICSTAFF',
                            'created_at' => now(),
                            'updated_at' => now(),
                            'validitydate' => now()
                        ];
                    }
                    DB::table('tbl_clinic_staff')->insert($insertData);

                    // Insert director staff data
                    $surrogacydirectdata = DB::table('surrogacyclinic_director')->where('userid', $receivedssasurrogacyformList->surrogacyclinics->userid)
                        ->where('surrogacyclinic_id', $sclinicId)->get();

                    $SurrogacyinsertData = [];
                    foreach ($surrogacydirectdata as $data) {
                        $SurrogacyinsertData[] = [
                            'clinic_id' => $lastId + 1,
                            'name_director' => $data->name_director,
                            'quali_director' => $data->quali_director,
                            'application_no' => $receivedssasurrogacyformList->surrogacyclinics->applicationno,
                            'reg_director' => $data->reg_director,
                            'status' => 1,
                            'clinic_type' => 'ARTSURROGACY',
                            'created_at' => now(),
                            'updated_at' => now(),
                            'validitydate' => now()
                        ];
                    }
                    DB::table('tbl_director_staff')->insert($SurrogacyinsertData);
                    // Insert equipment data
                    $equipartsurrodata = DB::table('surrogacyclinic_equipment')->where('userid', $receivedssasurrogacyformList->surrogacyclinics->userid)
                        ->where('surrogacyclinic_id', $sclinicId)->get();

                    $equipartsurrogacyval = [];
                    foreach ($equipartsurrodata as $data) {
                        $equipartsurrogacyval[] = [
                            'clinic_id' => $lastId + 1,
                            'equipmentname' => $data->equipmentname,
                            'application_no' => $receivedssasurrogacyformList->surrogacyclinics->applicationno,
                            'status' => 1,
                            'clinic_type' => 'ARTSURROGACY',
                            'created_at' => now(),
                            'updated_at' => now(),
                            'validitydate' => now(),
                        ];
                    }
                    DB::table('tbl_clinic_equipment')->insert($equipartsurrogacyval);

                    // Prepare clinic registration data
                    $artdata = [
                        'level' => $receivedssasurrogacyformList->surrogacyclinics->cliniclevel,
                        'name' => $receivedssasurrogacyformList->clinicname,
                        'address' => $receivedssasurrogacyformList->address,
                        'state' => $receivedssasurrogacyformList->state,
                        'district' => $receivedssasurrogacyformList->district,
                        'pincode' => $receivedssasurrogacyformList->pincode,
                        'mobile' => $receivedssasurrogacyformList->surrogacyclinics->contact_person_mobile,
                        'email' => $receivedssasurrogacyformList->surrogacyclinics->email,
                        'nature' => $receivedssasurrogacyformList->nature,
                        'contact_number_clinic' => $receivedssasurrogacyformList->contactno,
                        'fax_number' => $receivedssasurrogacyformList->surrogacyclinics->fax,
                        'apply_registration' => $receivedssasurrogacyformList->cliniclevel,
                        'website' => $receivedssasurrogacyformList->surrogacyclinics->website,
                        'date_of_establishment' => $receivedssasurrogacyformList->surrogacyclinics->dateestab,
                        'clinic_reg_mpt' => $receivedssasurrogacyformList->surrogacyclinics->mtpact,
                        'clinic_reg_pcpndt' => $receivedssasurrogacyformList->surrogacyclinics->pcpndtact,
                        'clinic_director' => $receivedssasurrogacyformList->surrogacyclinics->director,
                        'iui_h_s' => $receivedssasurrogacyformList->surrogacyclinics->iuih,
                        'iui_d_s' => $receivedssasurrogacyformList->surrogacyclinics->iuid,
                        'ivf_et' => $receivedssasurrogacyformList->surrogacyclinics->ivfet,
                        'icsi' => $receivedssasurrogacyformList->surrogacyclinics->icsi,
                        'pgt' => $receivedssasurrogacyformList->surrogacyclinics->pgt,
                        'sperm_oocyte' => $receivedssasurrogacyformList->surrogacyclinics->spermandoocyte,
                        'any_other_procedure' => $receivedssasurrogacyformList->surrogacyclinics->anyotherprocedure,
                        'otherprocedure' =>$receivedssasurrogacyformList->surrogacyclinics->otherprocedure,
                        'contact_person_name'=>$receivedssasurrogacyformList->surrogacyclinics->contact_person_name,
                        'contact_person_email'=>$receivedssasurrogacyformList->surrogacyclinics->contact_person_email,
                        'any_other_detail' => $receivedssasurrogacyformList->surrogacyclinics->otherdetails,
                        'ejaculation' => $receivedssasurrogacyformList->surrogacyclinics->ejaculation,
                        'electrojaculation' => $receivedssasurrogacyformList->surrogacyclinics->electroejaculation,
                        'processing_sperm' => $receivedssasurrogacyformList->surrogacyclinics->processingsperm,
                        'storage_sperm' => $receivedssasurrogacyformList->surrogacyclinics->storagesperm,
                        'oocyte_doner' => $receivedssasurrogacyformList->surrogacyclinics->oocytedonor,
                        'cryopreservation_of_sperm' => $receivedssasurrogacyformList->surrogacyclinics->cryopreservation,
                        'methode_of_freezing_of_sperm' => $receivedssasurrogacyformList->surrogacyclinics->spermslow,
                        'sperm_vitrification' => $receivedssasurrogacyformList->surrogacyclinics->spermvitrification,
                        'freezing_of_testicular_tissue' => $receivedssasurrogacyformList->surrogacyclinics->tisticulartissue,
                        'application_no' => $receivedssasurrogacyformList->surrogacyclinics->applicationno,
                        'registration_no' => $request->input('registration_no'),
                        'certificate_valid_date' => $request->input('validity_upto'),
                        'certificate_path' => $dbpath,
                        'status' => 1,
                        'clinic_type' => 'ARTSURROGACY',
                        'clinic_id' => $lastId + 1,
                        'userid_applicant' => $receivedssasurrogacyformList->surrogacyclinics->userid,
                        'rgistration_date' => $request->input('date_reg'),
                        'first_registration_date'       => $request->input('date_reg'),
                        'state_authority_id' => Session::get('id'),
                        'verify_certificate' => 1,
                        'created_date' => now(),
                        'update_date' => now(),
                        'validitydate' => now(),
                        'ip_address' => getHostByName(getHostName())
                    ];
                    // Insert clinic registration data
                    DB::table('clinic_registration')->insert($artdata);

            // Commit the transaction
            
        }

        } catch (\Exception $e) {
            // Rollback transaction if any error occurs
            
            Log::error('Error inserting ART surrogacy data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to insert data. Please try again.');
        }
    }


    public static function insertRenewalData($receivedForm, $request, $sclinicId, $calculatedValidity, $clinicType)
    {
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
                'artsurrogacy' => 'target_renewal_file_reg_surrogacyclinic_certificate',
                'artclinic' => 'target_renewal_file_reg_artclinic_certificate',
                'artbank'   => 'target_renewal_file_reg_artbank_certificate',
            ];

            $rejectedFilePrefix = [
                'artsurrogacy' => 'target_renewal_file_rejected_surrogacyclinic_certificate',
                'artclinic' => 'target_renewal_file_rejected_artclinic_certificate',
                'artbank'   => 'target_renewal_file_rejected_artbank_certificate',
            ];

            // 🔹 Get current clinic file field and name prefix
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

            // 🔹 Default filename
            


            // =========================
            // 🔹 REGISTRATION REJECTED
            // =========================
            if ($request->input('approved_rejected') == 'Registration Rejected') {
                $filename = $rejPrefix . $timestamp . '_' . $receivedForm->id . '.' . $originalExtension;
                $applicationFolder = str_replace('/', '_', $receivedForm->applicationno);
            //    dd($applicationFolder);
                $foldername = 'application_sa';
                $baseDir = folderpath($foldername);
                $fullFolderPath = $baseDir . $applicationFolder;
        // dd($fullFolderPath);
                DB::table('renewal_sc_application')
                    ->where('id',$sclinicId)
                    ->where('userid', $receivedForm->userid)
                    ->update(['appstatus' => 'Rejected']);

                if (!File::exists($fullFolderPath)) {
                    File::makeDirectory($fullFolderPath, 0755, true);
                }

                $file->move($fullFolderPath, $filename);
                $dbpath = $filename;

                $docMasters = DB::table('doc_masters')
                    ->whereIn('doc_type', [$rejPrefix])
                    ->where('status', 1)
                    ->first();

                if ($docMasters) {
                    DB::table('renewal_doc_file_uploads_registration_certificate')->insert([
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
            // 🔹 REGISTRATION GRANTED
            // =========================
            else if ($request->input('approved_rejected') == 'Registration Granted') {
                $filename = $regPrefix . $timestamp . '_' . $receivedForm->id . '.' . $originalExtension;
                $dbpath = $filename;

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

                DB::table('renewal_sc_application')
                    ->where('id',$sclinicId)
                    ->where('userid', $receivedForm->userid)
                    ->update(['appstatus' => 'Approved']);

                // Insert uploaded doc record
                if ($docMasters) {
                    DB::table('renewal_doc_file_uploads_registration_certificate')->insert([
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
                $staffdata = RenewalSCStaff::where('userid', $receivedForm->userid)
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

                $directorData = RenewalSCDirector::where('userid', $receivedForm->userid)
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

                $equipmentData = RenewalSCEquipment::where('userid', $receivedForm->userid)
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
        // 
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

                // $subject = $request->input('approved_rejected') == 'Registration Granted' ? 'Renewal Application Approved' : 'Renewal Application Rejected';
                // $message = $request->input('approved_rejected') == 'Registration Granted' ? 'Your renewal application has been approved. Your clinic registration is now valid until ' . $calculatedValidity->format('Y-m-d') . '.' : 'Your renewal application has been rejected. Please review the reason for rejection and resubmit your application.';
                  

        } catch (\Exception $e) {
            Log::error('Error inserting ART clinic data (' . $clinicType . '): ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to insert data. Please try again.');
        }

    }

}
