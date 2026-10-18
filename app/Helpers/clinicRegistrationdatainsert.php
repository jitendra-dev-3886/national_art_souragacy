<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class clinicRegistrationdatainsert
{
    public static function insertArtBankData()
    {

           $results = DB::table('artbank_certificate_details')->get();

           $copypath = "C:/xampp/htdocs/art_clinic_certificate/.$results/";
            dd($copypath);

                // $lastId = DB::table('clinic_registration')->orderBy('id', 'desc')->value('id');

                // $docType = DB::table('doc_masters')->where('status', 1)->where('doc_type', 'target_file_reg_artbank_certificate')
                //      ->value('doc_type'); 

                // $docMasters = DB::table('doc_masters')->whereIn('doc_type', ['target_file_reg_artbank_certificate'])->where('status', 1)->first();
                // $fileKey = str_replace('target_file_', '', $docType);

                // $request->validate([
                //               'reg_artbank_certificate' => 'required|file|mimes:pdf|max:200',
                // ]);

                // $file        = $request->file('reg_artbank_certificate');
                // $filename    = $fileKey . '-' . time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
                // $foldername  = 'clinic_registration_certificate';
                // $foldername2 = 'art_clinic_certificate';

                // $destinationPath  = folderpath($foldername);
                // $destinationPath2 = folderpath($foldername2);

                // // First, move the file to the primary folder
                // $filePath = $file->move($destinationPath, $filename);

                // // Then, copy the moved file to the second folder
                // copy($filePath->getPathname(), $destinationPath2 . '/' . $filename);
                // $dbpath = $filename;

                // $clinicId1 = $request->input('id');

                // $receivedssabankformList_query = DB::table('signup')
                //     ->join('artbank', 'signup.id', '=', 'artbank.userid') // replace with actual FK
                //     ->where('artbank.id', $clinicId1)
                //     ->select('artbank.userid') 
                //     ->first();

                if ($receivedssabankformList_query) {
                    DB::table('doc_file_uploads_registration_certificate')->insert([
                        'userid' => $receivedssabankformList_query->userid,
                        'app_id' => $bclinicId,
                        'doc_id' => $docMasters->id,
                        'doc_type' => $docMasters->doc_type,
                        'doc_upload_ref' => $dbpath,
                    ]);
                }


                 // Step 1: Prepare FETDATA data
                  $staffdata = DB::table('artbank_otherstaff')->select('*')
                  ->where('userid', $receivedssabankformList_query->userid)
                  ->where('artbank_id', $bclinicId)
                  ->get();


                  $insertData = [];

                    // Step 2: Prepare insert data
                    foreach ($staffdata as $data) {
                        $insertData[] = [
                            'clinic_id'          => 9000+$lastId+1,
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
                  ->where('userid', $receivedssabankformList_query->userid)
                  ->where('artbank_id', $bclinicId)
                  ->get();


                  $equipdatainsertData = [];

                    // Step 202: Prepare insert data
                    foreach ($equipdata as $data) {
                        $equipdatainsertData[] = [
                            'clinic_id'          => 9000+$lastId+1,
                            'equipmentname'      => $data->equipmentname,
                            'application_no'     => $receivedssabankformList->artclinics->applicationno ?? null,
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


                    
                Log::debug('File uploaded:', ['filename' => $filename, 'filePath' => $filePath]);

                    $artdata = [
                        'name'                          => $receivedssabankformList->clinicname,
                        'address'                       => $receivedssabankformList->address,
                        'state'                         => $receivedssabankformList->state,
                        'district'                      => $receivedssabankformList->district, // Corrected key
                        'pincode'                       => $receivedssabankformList->pincode,
                        'mobile'                        => $receivedssabankformList->bankclinics->contact_person_mobile,
                        'email'                         => $receivedssabankformList->bankclinics->email,
                        'contact_number_clinic'         => $receivedssabankformList->contactno,
                        'fax_number'                    => $receivedssabankformList->fax,
                        'apply_registration'            => $receivedssabankformList->cliniclevel,
                        'website'                       => $receivedssabankformList->website,
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
                        'clinic_id'                     => 9000+$lastId+1,
                        'userid_applicant'              => $receivedssabankformList->bankclinics->userid,
                        'rgistration_date'              => $receivedssabankformList->bankclinics->applicationno_datetime_submission,
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
                    } catch (\Exception $e) {
                        Log::error('Error inserting ART Bank data: ' . $e->getMessage());
                        throw $e;  // Or handle it however you'd like
                    }
                
        }

    public static function insertclinidata($receivedssaartformList, $request, $clinicId )
    {           $lastId = DB::table('clinic_registration')->orderBy('id', 'desc')->value('id');

                $docType = DB::table('doc_masters')->where('status', 1)->where('doc_type', 'target_file_clinic_registration_certificate')
                     ->value('doc_type'); 

                $docMasters = DB::table('doc_masters')->whereIn('doc_type', ['target_file_reg_artclinic_certificate'])->where('status', 1)->first();

                $fileKey = str_replace('target_file_', '', $docType);

                $request->validate([
                              'reg_artclinic_certificate' => 'required|file|mimes:pdf|max:200',
                ]);

                $file = $request->file('reg_artclinic_certificate');
                $filename = $fileKey . '-' . time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
                $foldername = 'clinic_registration_certificate';
                $foldername2 = 'art_clinic_certificate';

                $destinationPath = folderpath($foldername);
                $destinationPath2 = folderpath($foldername2);

                // First, move the file to the primary folder
                $filePath = $file->move($destinationPath, $filename);

                // Then, copy the moved file to the second folder
                copy($filePath->getPathname(), $destinationPath2 . '/' . $filename);
                $dbpath = $filename;

                $clinicId1 = $request->input('id');

                $receivedssaartformList_query = DB::table('signup')
                    ->join('artclinic', 'signup.id', '=', 'artclinic.userid') // replace with actual FK
                    ->where('artclinic.id', $clinicId1)
                    ->select('artclinic.userid') 
                    ->first();

                if ($receivedssaartformList_query) {
                    DB::table('doc_file_uploads_registration_certificate')->insert([
                        'userid' => $receivedssaartformList_query->userid,
                        'app_id' => $clinicId,
                        'doc_id' => $docMasters->id,
                        'doc_type' => $docMasters->doc_type,
                        'doc_upload_ref' => $dbpath,
                    ]);
                }

                    // Step 1: Prepare FETDATA data
                  $staffdata = DB::table('artclinic_otherstaff')->select('*')
                  ->where('userid', $receivedssaartformList_query->userid)
                  ->where('artclinic_id', $clinicId)
                  ->get();

                    $insertData = [];

                    // Step 2: Prepare insert data
                    foreach ($staffdata as $data) {
                        $insertData[] = [
                            'clinic_id'          => 9000+$lastId+1,
                            'name'               => $data->name_otherstaff,
                            'post'               => $data->post_otherstaff,
                            'qualification'      => $data->quali_otherstaff,
                            'application_no'     => $receivedssaartformList->artclinics->applicationno,
                            'regno'              => $data->regno,
                            'status'             => 1,
                            'clinic_type'        => 'ARTCLINIC',
                            'type_emp'           => 'CLINICSTAFF',
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
                  ->where('userid', $receivedssaartformList_query->userid)
                  ->where('artclinic_id', $clinicId)
                  ->get();


                  $directinsertData = [];

                    // Step 102: Prepare insert data
                    foreach ($directordata as $data) {
                        $directinsertData[] = [
                            'clinic_id'           => 9000+$lastId+1,
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
                  ->where('userid', $receivedssaartformList_query->userid)
                  ->where('artclinic_id', $clinicId)
                  ->get();


                  $equipartclinicdataarr = [];

                    // Step 302: Prepare insert data
                 foreach ($equipartclinicdata as $dataval) {
                        $equipartclinicdataarr[] = [
                            'clinic_id'      => 9000 + $lastId + 1,
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
               
                  
                
                Log::debug('File uploaded:', ['filename' => $filename, 'filePath' => $filePath]);

                    $artdata = [
                        'level'                         => $receivedssaartformList->artclinics->cliniclevel,
                        'name'                          => $receivedssaartformList->clinicname,
                        'address'                       => $receivedssaartformList->address,
                        'state'                         => $receivedssaartformList->state,
                        'district'                      => $receivedssaartformList->district, // Corrected key
                        'pincode'                       => $receivedssaartformList->pincode,
                        'mobile'                        => $receivedssaartformList->artclinics->contact_person_mobile,
                        'email'                         => $receivedssaartformList->artclinics->email,
                        'contact_number_clinic'         => $receivedssaartformList->contactno,
                        'fax_number'                    => $receivedssaartformList->fax,
                        'apply_registration'            => $receivedssaartformList->cliniclevel,
                        'website'                       => $receivedssaartformList->website,
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
                        'clinic_id'                     => 9000+$lastId+1,
                        'userid_applicant'              => $receivedssaartformList->artclinics->userid,
                        'rgistration_date'              => $receivedssaartformList->artclinics->applicationno_datatimesubmission,
                        'state_authority_id'            => Session::get('id'),
                        'verify_certificate'            => $request->input('verify_certificate'),
                        'created_date'                  => now(),
                        'update_date'                   => now(),
                        'validitydate'                  => now(),
                        'ip_address'                    => getHostByName(getHostName())
                    ];

                    // Insert the data into the database
                    try {
                        DB::table('clinic_registration')->insert($artdata);
                    } catch (\Exception $e) {
                        Log::error('Error inserting ART clinic data: ' . $e->getMessage());
                        throw $e;  // Or handle it however you'd like
                    }
         }
        
         public static function insertsurrogacydata($receivedssasurrogacyformList, $request, $sclinicId)
        {    $lastId = DB::table('clinic_registration')->orderBy('id', 'desc')->value('id');

             $docType = DB::table('doc_masters')->where('status', 1)->where('doc_type', 'target_file_reg_surrogacyclinic_certificate')
                     ->value('doc_type'); 

             $docMasters = DB::table('doc_masters')->whereIn('doc_type', ['target_file_reg_surrogacyclinic_certificate'])->where('status', 1)->first();

                $fileKey = str_replace('target_file_', '', $docType);
                $request->validate([
                              'reg_surrogacyclinic_certificate' => 'required|file|mimes:pdf|max:200',
                ]);

                $file        = $request->file('reg_surrogacyclinic_certificate');
                $filename    = $fileKey . '-' . time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
                $foldername  = 'clinic_registration_certificate';
                $foldername2 = 'art_clinic_certificate';

                $destinationPath = folderpath($foldername);
                $destinationPath2 = folderpath($foldername2);

                // First, move the file to the primary folder
                $filePath = $file->move($destinationPath, $filename);

                // Then, copy the moved file to the second folder
                copy($filePath->getPathname(), $destinationPath2 . '/' . $filename);
                $dbpath = $filename;

                $sclinicId1 = $request->input('id');

                $receivedssasurrogacyformList_query = DB::table('signup')
                    ->join('artbank', 'signup.id', '=', 'artbank.userid') // replace with actual FK
                    ->where('artbank.id', $sclinicId1)
                    ->select('artbank.userid') 
                    ->first();

                if($receivedssasurrogacyformList_query) {
                    DB::table('doc_file_uploads_registration_certificate')->insert([
                        'userid'         => $receivedssasurrogacyformList_query->userid,
                        'app_id'         => $sclinicId,
                        'doc_id'         => $docMasters->id,
                        'doc_type'       => $docMasters->doc_type,
                        'doc_upload_ref' => $dbpath,
                    ]);
                }


                  // Step 1: Prepare FETDATA data
                  $staffdata = DB::table('surrogacyclinic_otherstaff')->select('*')
                  ->where('userid', $receivedssasurrogacyformList_query->userid)
                  ->where('surrogacyclinic_id', $sclinicId)
                  ->get();

                    $insertData = [];

                    // Step 2: Prepare insert data
                    foreach ($staffdata as $data) {
                        $insertData[] = [
                            'clinic_id'          => 9000+$lastId+1,
                            'name'               => $data->name_otherstaff,
                            'post'               => $data->post_otherstaff,
                            'qualification'      => $data->quali_otherstaff,
                            'application_no'     => $receivedssasurrogacyformList->surrogacyclinics->applicationno,
                            'reg'                => $data->regno,
                            'status'             => 1,
                            'clinic_type'        => 'ARTSURROGACY',
                            'type_emp'           => 'SURROGACYDIRECTORSTAFF',
                            'created_at'         => now(),
                            'updated_at'         => now(),
                            'validitydate'       => now()
                        ];
                    }

                    // Step 3: Insert into second table
                    DB::table('tbl_clinic_staff')->insert($insertData);
                    // Step 101: Prepare FETDATA data
                    $surrogacydirectdata = DB::table('surrogacyclinic_director')->select('*')
                      ->where('userid', $receivedssasurrogacyformList_query->userid)
                      ->where('surrogacyclinic_id', $sclinicId)
                      ->get();


                  $SurrogacyinsertData = [];

                    // Step 102: Prepare insert data
                    foreach ($surrogacydirectdata as $data) {
                        $SurrogacyinsertData[] = [
                            'clinic_id'          => 9000+$lastId+1,
                            'name_director'      => $data->name_director,
                            'post'               => 'null',
                            'quali_director'     => $data->quali_director,
                            'application_no'     => $receivedssasurrogacyformList_query->artclinics->applicationno,
                            'reg_director'       => $data->reg_director, 
                            'status'             => 1,
                            'clinic_type'        => 'ARTSURROGACY',
                            'created_at'         => now(),
                            'updated_at'         => now(),
                            'validitydate'       => now()
                        ];
                    }

                    // Step 103: Insert into second table
                    DB::table('tbl_director_staff')->insert($SurrogacyinsertData);


                      // Step 301: Prepare FETDATA data
                  $equipartsurrodata = DB::table('surrogacyclinic_equipment')->select('*')
                  ->where('userid', $receivedssasurrogacyformList_query->userid)
                  ->where('surrogacyclinic_id', $sclinicId)
                  ->get();


                  $equipartsurrogacyval = [];

                    // Step 302: Prepare insert data
                    foreach ($equipartsurrodata as $data) {
                        $equipartsurrogacyval[] = [
                            'clinic_id'          => 9000+$lastId+1,
                            'equipmentname'      => $data->equipmentname,
                            'application_no'     => $receivedssasurrogacyformList_query->artclinics->applicationno,
                            'status'             => 1,
                            'clinic_type'        => 'ARTSURROGACY',
                            'created_at'         => now(),
                            'updated_at'         => now(),
                            'validitydate'       => now(),
                        ];
                    }

                    // Step 303: Insert into second table   
                    DB::table('tbl_clinic_equipment')->insert($equipartsurrogacyval);
               
            $artdata = [
                        'level'                         => $receivedssasurrogacyformList->surrogacyclinics->cliniclevel,
                        'name'                          => $receivedssasurrogacyformList->clinicname,
                        'address'                       => $receivedssasurrogacyformList->address,
                        'state'                         => $receivedssasurrogacyformList->state,
                        'district'                      => $receivedssasurrogacyformList->district, // Corrected key
                        'pincode'                       => $receivedssasurrogacyformList->pincode,
                        'mobile'                        => $receivedssasurrogacyformList->surrogacyclinics->contact_person_mobile,
                        'email'                         => $receivedssasurrogacyformList->surrogacyclinics->email,
                        'contact_number_clinic'         => $receivedssasurrogacyformList->contactno,
                        'fax_number'                    => $receivedssasurrogacyformList->fax,
                        'apply_registration'            => $receivedssasurrogacyformList->cliniclevel,
                        'website'                       => $receivedssasurrogacyformList->website,
                        'date_of_establishment'         => $receivedssasurrogacyformList->surrogacyclinics->dateestab,
                        'clinic_reg_mpt'                => $receivedssasurrogacyformList->surrogacyclinics->mtpact,
                        'clinic_reg_pcpndt'             => $receivedssasurrogacyformList->surrogacyclinics->pcpndtact,
                        'clinic_director'               => $receivedssasurrogacyformList->surrogacyclinics->director,
                        'iui_h_s'                       => $receivedssasurrogacyformList->surrogacyclinics->iuih,
                        'iui_d_s'                       => $receivedssasurrogacyformList->surrogacyclinics->iuid,
                        'ivf_et'                        => $receivedssasurrogacyformList->surrogacyclinics->ivfet,
                        'icsi'                          => $receivedssasurrogacyformList->surrogacyclinics->icsi,
                        'pgt'                           => $receivedssasurrogacyformList->surrogacyclinics->pgt,
                        'sperm_oocyte'                  => $receivedssasurrogacyformList->surrogacyclinics->spermandoocyte,
                        'any_other_procedure'           => $receivedssasurrogacyformList->surrogacyclinics->anyotherprocedure,
                        'any_other_detail'              => $receivedssasurrogacyformList->surrogacyclinics->otherdetails,
                        'ejaculation'                   => $receivedssasurrogacyformList->surrogacyclinics->ejaculation,
                        'electrojaculation'             => $receivedssasurrogacyformList->surrogacyclinics->electroejaculation,
                        'processing_sperm'              => $receivedssasurrogacyformList->surrogacyclinics->processingsperm,
                        'storage_sperm'                 => $receivedssasurrogacyformList->surrogacyclinics->storagesperm,
                        'oocyte_doner'                  => $receivedssasurrogacyformList->surrogacyclinics->oocytedonor,
                        'cryopreservation_of_sperm'     => $receivedssasurrogacyformList->surrogacyclinics->cryopreservation,
                        'methode_of_freezing_of_sperm'  => $receivedssasurrogacyformList->surrogacyclinics->spermslow,
                        'sperm_vitrification'           => $receivedssasurrogacyformList->surrogacyclinics->spermvitrification,
                        'freezing_of_testicular_tissue' => $receivedssasurrogacyformList->surrogacyclinics->tisticulartissue,
                        'application_no'                => $receivedssasurrogacyformList->surrogacyclinics->applicationno,
                        'registration_no'               => $request->input('registration_no'),
                        'certificate_valid_date'        => $request->input('validity_upto'),
                        'certificate_path'              => $dbpath,
                        'status'                        => 1,
                        'clinic_type'                   => 'ARTSURROGACY',
                        'clinic_id'                     => 9000+$lastId+1,
                        'userid_applicant'              => $receivedssasurrogacyformList->surrogacyclinics->userid,
                        'rgistration_date'              => $receivedssasurrogacyformList->surrogacyclinics->applicationno_datetime_submission,
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
                    } catch (\Exception $e) {
                        Log::error('Error inserting ART surrogacy data: ' . $e->getMessage());
                        throw $e;  // Or handle it however you'd like
                    }

        }

       
   

        
    
}
