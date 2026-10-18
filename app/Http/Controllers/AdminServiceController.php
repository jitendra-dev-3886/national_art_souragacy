<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\Noctable_foreigner;
use Illuminate\Support\Facades\Crypt;
use App\Mail\SendEmailWithAttachment;
use Illuminate\Support\Facades\Mail;
use App\Models\Noc\Nocforeigner;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Contracts\Encryption\DecryptException;



class AdminServiceController extends Controller
{
    
    public function index()
    {
       
    }
   
    public function noc_page_foreigner()
    {

        $id = Session::get('userid');
        $role = session()->get('role');
        $noctable = new Noctable_foreigner();
        $getdata_noc_data = $noctable->assignee();
        $get_action_list = $noctable->action_list();
        $get_list_marked_for_approval = $noctable->get_list_marked_for_approval();
        $get_list_park_for_internal = $noctable->get_list_park_for_internal();
        $get_Park_for_external_committeit = $noctable->get_Park_for_external_committeit();
        $get_Park_for_Appex_Commity = $noctable->get_Park_for_Appex_Commity();
        $get_list_final_approval = $noctable->get_list_final_approval();
        $get_view_noc_pagelist_noc = $noctable->get_list_noc();
        

        return view('layouts.admin.noc_details_foreigner', compact('role', 'getdata_noc_data', 'get_action_list', 'get_list_marked_for_approval', 'get_list_park_for_internal', 'get_Park_for_external_committeit', 'get_Park_for_Appex_Commity', 'get_list_final_approval','get_view_noc_pagelist_noc'));
   
    }

    

    public function view_noc_page_foreigner($cry_id, $cry_level_id)
    {
        $id = Crypt::decrypt($cry_id);
      //  dd($id);
        $level_id = Crypt::decrypt($cry_level_id);

        $role = session()->get('role');
        $level_id = $level_id;
        $nocForm = DB::table('noc_form_foreigners')->where('id', $id)->first();
       // dd($nocForm);

        $medical_status = DB::table('work_flow_table')
            ->where('application_id', $id)
            ->where('level_id', $level_id)
            ->where('service_id', 6)
            ->first();

       


        $created_at = \Carbon\Carbon::parse($nocForm->created_at)->format('Y-m-d');

        $noc_enc = $id;

        $links = [
            'view_application_foreigner' => 'View Application',
            'front_attachment_foreigner' => "Applicant's Attachment",
            'back_attachment_foreigner'  => 'Back Attachment',
            'view_remarks_foreigner'     => 'Remarks',
        ];

        $linkColors = [
            'view_application' => '#105f73',
            'front_attachment_foreigner' => '#412904',
            'back_attachment_foreigner' => '#0e471c',
            'view_remarks_foreigner' => '#710d0d',
        ];

        $tabcss = 'col-xl-3';
       // dd('sdfsdf');
        return view('layouts.admin.view_form_foreigner', compact('medical_status', 'created_at', 'nocForm', 'links', 'linkColors', 'tabcss', 'noc_enc', 'role', 'level_id'));
    }

    public function add_remarks_foreigner(Request $request)
    {

       // dd($request->all());

        $uid  = session()->get('userid');
        $role = session()->get('role');

        $validated = $request->validate(
            [
                'application_id'        => 'required|integer',    
                'remarks'               => 'required',
                'notesheet'             => '',
                'created_at'            => '',
                'level_action'          => 'required|integer',
                'level_id'              => 'required|integer',
                'uploadfile.*'          => 'file|mimes:pdf|max:2500',
                'uploadremarks.*'       => '',
            ],
            [
                'level_action.required' => 'Please select the action taken.',
                'level_action.integer'  => 'The level action must be a valid number.',
                'uploadfile.*.file'     => 'The uploaded file must be a valid file.',
                'uploadfile.*.mimes'    => 'The uploaded file must be a PDF document.',
                'uploadfile.*.max'      => 'The uploaded file cannot exceed 250 kilobytes.',
            ]
        );


        $medicalReport          = isset($validated['medical_report']) ? $validated['medical_report'] : '';
        $uplodremr              = $validated['uploadremarks'];
        $noc_user_id            = $uid;
        $app_id                 = $validated['application_id'];
        $doc_id                 = 99;
        $doc_master_id_ref      = 1000;
        $doc_type               = 'other documents';
        $files                  = $request->file('uploadfile');

        if (!empty($files) && is_array($files)) {
            $i = 0; 
        
            foreach ($files as $file) {
                $fileContent = file_get_contents($file->getRealPath());
                $fileName = $file->getClientOriginalName();
                $safeFileName = preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', $fileName);
                $uniqueFileName = strtolower($safeFileName) . '.' . time() . '_' . microtime(true);
                $fileMimeType = $file->getMimeType();
                $fileSize = $file->getSize();
        
                if ($fileMimeType == 'application/pdf') {
                    // Define the destination path
                    $destinationPath = 'D:/xampp/htdocs/noc_documents';
                    
                    // Move the file to the specified destination
                    $file->move($destinationPath, $uniqueFileName);
                    $dbpath = $uniqueFileName;
        
                    // Check if the description exists in the $uplodremr array
                    $uploadDesc = isset($uplodremr[$i]) ? $uplodremr[$i] : '';
        
                    // Insert the data for each file
                    DB::table('doc_file_uploads_foreigner')->insert([
                                    'noc_user_id' => $noc_user_id,
                                    'app_id'      => $app_id,
                                    'doc_id'      => $doc_id,
                                    'doc_type'    => $doc_type,
                                    'doc_master_id_ref'=>$doc_master_id_ref,
                                    'doc_upload_ref' => $dbpath,
                                    'upload_desc' => $uploadDesc
                    ]);
                }
        
                // Increment the counter to point to the next description
                $i++;
            }
        }
        
        

        $application_id = $validated['application_id'];
        $service_id = 6;
        $level_action = $validated['level_action'];
        $level_id = $validated['level_id'];
        $remarks = $validated['remarks'];
        $is_active = 1;
        $level_action = $validated['level_action'];
      
        $get_userid = nextActor($level_action, $application_id, $service_id);
       // dd($get_userid);
        $action_taken_by = status_name_foreigner($level_action, $application_id, $service_id);


        if ($level_action == 7) {

           $pre_level = $level_action - 5;
        } else if ($level_id == '6') {

            $pre_level = $level_action + 3;

        } else if ($level_action == '6') {

            $action_taken_by = 'Revise the Query';
            $pre_level = $level_action - 3;
        } 
        else {
            $pre_level = $level_action - 1;
        }

     //  dd($pre_level);
    
        $receivingdate = previoucs_date_wfd_foreigner($application_id,$pre_level);
      //  dd($receivingdate);
        if ($role == 4) {

            DB::table('work_flow_table')
                ->where('level_id', $pre_level)
                ->where('application_id', $application_id)
                ->where('is_active', 'YES')
                ->where('service_id', 6)
                ->update([
                    'notesheet'        => $validated['notesheet'],
                    'remarks'          => $validated['remarks'],
                    'query_raised_by'  => $get_userid,
                    'is_active'        => 'NO',
                    'action_date'      => Carbon::now()->format('Y-m-d H:i:s')
                ]);
        } else {

            DB::table('work_flow_table')
                ->where('level_id', $pre_level)
                ->where('application_id', $application_id)
                ->where('is_active', 'YES')
                ->where('service_id', 6)
                ->update([
                    'notesheet'        => $validated['notesheet'],
                    'remarks'          => $validated['remarks'],
                    'is_active'        => 'NO',
                    'action_date'      => Carbon::now()->format('Y-m-d H:i:s')
                ]);
        }

        if ($level_action == 11) {
            $is_active = 'YES';
        } else {
            $is_active = 'YES';
        }
        if($level_action == 4){
        $getdata = DB::table('user_request_table')->where('id', $get_userid)->first();
        //dd($get_userid);
         $username = $getdata->user_name;
        }else if($level_action >=7 && $level_action <=10){
           // $getdata = DB::table('user_table')->where('userid', $get_userid)->first();
            $username = 'Assignee';
        }else{
            $getdata = DB::table('user_table')->where('userid', $get_userid)->first();
            $username = $getdata->username;
        }

       //dd($level_action);
        DB::table('work_flow_table')->insert([
            'application_id'    => $application_id,
            'service_id'        => $service_id,
            'level_id'          => $level_action,
            'user_id'           => $get_userid,
            'remarks'           => '',
            'notesheet'         => '',
            'medical_report'    => $medicalReport,
            'is_active'         => $is_active,
            'action_taken_by'   => $action_taken_by,
            'submission_date'   => Carbon::now()
        ]);
        return redirect()->route('admin.noc_details_foreigner')->with('success_add', 'Application has been Forwarded to '. $username .'!');

    }

    public function nocgenrate_foreigner(Request $request)
    {
        //dd($request->all());

        $uid = session()->get('userid');

        $validated = $request->validate([
            'application_id'           => '',
            'internal_recommanation'   => '',
            'external_commitee'        => '',
            'appex_commitee'           => '',
            'approval_checked'         => '',
            'remarks'                  => '',
            'uploadfile'               => ''
        ]);

        if (empty($validated['internal_recommanation']) || empty($validated['external_commitee']) || empty($validated['appex_commitee']) || empty($validated['approval_checked'])) {
            return redirect()->back()->with('error', 'Please select all checkboxes!');
        } else if (empty($validated['uploadfile'])) {
            return redirect()->back()->with('error', 'Please upload file mandatory');
        }


        $user_id = $uid;
        $app_id  = $validated['application_id'];
        $doc_id  = 24;
        $doc_type = 'Noc Genrate';

        $file = $request->file('uploadfile');
        // dd($file);

        if (!empty($file)) {
            $fileName = $file->getClientOriginalName();
            $fileMimeType = $file->getMimeType();

            if ($fileMimeType == 'application/pdf') {
                $destinationPath = 'D:/xampp/htdocs/noc_documents';
                $file->move($destinationPath, $fileName);
                $dbpath = $fileName;

                $lastInsertedId = DB::table('doc_file_uploads_foreigner')->insertGetId([
                    'noc_user_id'    => $user_id,
                    'app_id'         => $app_id,
                    'doc_id'         => $doc_id,
                    'doc_type'       => $doc_type,
                    'doc_upload_ref' => $dbpath,
                    'upload_desc'    => $doc_type
                ]);

               // dd($lastInsertedId);


                DB::table('noc_genrate_table')->insert([
                    'internal_recommanation'   => $validated['internal_recommanation'],
                    'external_commitee'        => $validated['external_commitee'],
                    'appex_commitee'           => $validated['appex_commitee'],
                    'approval_checked'         => $validated['approval_checked'],
                    'user_id'                  => $user_id,
                    'app_id'                   => $app_id,
                    'noc_type'                 => 'Foreigner',
                    'noc_user_id'              => get_noc_user_id_foreigner($app_id),
                    'doc_file_upload_id'       => $lastInsertedId,
                    'doc_type'                 => $doc_type,
                    'path'                     => $dbpath
                ]);

                DB::table('work_flow_table')
                    ->where('user_id', $user_id)
                    ->where('application_id', $app_id)
                    ->where('service_id', 6)
                    ->update(['is_active' => 'NO']);

                // $subject = 'Test Email with Attachment';
                //dd($fileName,$file);
                $file2 = 'noc_documents';
                $filePath = $destinationPath . '/' . $fileName;


                //dd($filePath);
                // $filePath = [

                //     'path' => $destinationPath.'/'.$fileName
                // ];

                // Send the email
                // Mail::to('naseerkhan190187@gmail.com')->send(new SendEmailWithAttachment($filePath));

                if (file_exists($filePath)) {
                    $sent = Mail::to('naseerkhan190187@gmail.com')->send(new SendEmailWithAttachment($filePath));

                    // You can add a conditional check to see if the email was successfully sent
                    if ($sent) {
                        return redirect()->route('admin.noc_details_foreigner')->with('success', 'Mail send has been successfully!');
                    } else {
                        return redirect()->route('admin.noc_details_foreigner')->with('error', 'Mail send has been successfully!');
                    }
                } else {

                    dd('Mail File does not exist!');
                }


                return redirect()->route('admin.noc_details_foreigner')->with('success', 'Noc genrate and Form submit successfully!');
            } else {
                return redirect()->route('admin.noc_details_foreigner')->with('error', 'Please select pdf file formate');
            }
        }
    }


    public function view_application_foreigner($cry_id)
    {
        
        try {

            $decryptedId = Crypt::decrypt($cry_id);
            // dd($decryptedId);
            $application = Nocforeigner::findOrFail($decryptedId);
            //dd($application);
            $app_id = $application->id;

            // Fetch the clinic names from the signup table
            $clinicIds = [$application->from_name_clinic, $application->from_name_clinic1, $application->to_name_clinic2];
            $clinicNames = DB::table('signup')
                ->whereIn('id', $clinicIds)
                ->pluck('clinicname', 'id');
                
            $fromClinicName  = $clinicNames[$application->from_name_clinic] ?? null;
            $fromClinicName1 = $clinicNames[$application->from_name_clinic1] ?? null;
            $fromClinicName2 = $application->from_name_clinic2 ?? null;
            $toClinicName    = $clinicNames[$application->to_name_clinic]   ?? null;
            $toClinicName1   = $clinicNames[$application->to_name_clinic1]  ?? null;
            $toClinicName2   = $application->to_name_clinic2  ?? null;




            // Fetch the clinic names from the signup table
            $countryIds = [$application->country]; // IDs to fetch
            $countryNames = DB::table('apps_countries')
                ->where('id', $countryIds)
                ->pluck('country_name', 'id'); // Retrieve clinic names with IDs as keys

            $CountryName = $countryNames[$application->country] ?? null;

            $dataDocMaster = DB::table('doc_masters')
                ->select('doc_masters.*')
                ->whereIn('doc_type', [
                    'upload_comp_institute_denied_export',
                    'sending_bg_comp_inst',
                    'receiving_bg_comp_inst',
                    'details_planned_analysis',
                    'biomaterial_micro_organisms_approval_file',
                    'ibsc_rcgm_approval_applicable_file',
                    'certified_copy_proforma',
                    'declaration_letter'
                ])
                ->where('status', 1)
                ->get();
            if ($dataDocMaster->isNotEmpty()) {
                foreach ($dataDocMaster as $doc) {
                    $doc_type = $doc->doc_type;
                    $doc_id = $doc->id;
                }
            }

            $get_docfileData = DB::table('doc_file_uploads_foreigner')
                ->where('doc_file_uploads_foreigner.app_id', $app_id)
                ->orderBy('doc_file_uploads_foreigner.doc_master_id_ref', 'ASC')
                ->get();
            
              return view('layouts.admin.view_application_foreigner', compact('application', 'get_docfileData', 'fromClinicName', 'fromClinicName1', 'fromClinicName2', 'toClinicName',  'toClinicName1', 'toClinicName2', 'CountryName'));
           }catch(DecryptException $e){
               abort(404, 'Invalid ID');
           }
        //dd($view_data);
        // return view('layouts.admin.view_application', compact('view_data'));
    }

    public function front_attachment_foreigner($cry_id)
    {
        $id = Crypt::decrypt($cry_id);
   
        $folderName = basename(base_path());
        $string  = url('/');
        $newUrl  = str_replace("/$folderName", "", $string);
        $baseUrl = "$newUrl/noc_documents/";

        $uid = session()->get('userid');
        $view_attachment = DB::table('noc_form_foreigners')->where('id', $id)->first();
        $getdata_front_attach = DB::table('noc_form_foreigners')->where('id', $id)->first();

        $getbackdata = DB::table('doc_file_uploads_foreigner')
            ->leftJoin('noc_form_foreigners', function ($join) use ($id) {
                $join->on('doc_file_uploads_foreigner.noc_user_id', '=', 'noc_form_foreigners.noc_userid')
                    ->on('doc_file_uploads_foreigner.app_id', '=', 'noc_form_foreigners.id');
            })
            ->where('doc_file_uploads_foreigner.app_id', '=', $id)
            ->where('doc_file_uploads_foreigner.doc_id', '!=', 25)
            ->orderBy('doc_file_uploads_foreigner.doc_master_id_ref', 'ASC')
            ->get();

       // dd($getbackdata);


        return view('layouts.admin.front_attachment_foreigner', compact('getbackdata', 'view_attachment', 'baseUrl'));
    }
    public function back_attachment_foreigner($cry_id)
    {
        $id = Crypt::decrypt($cry_id);
        //
        $folderName = basename(base_path());
        $string  = url('/');
        $newUrl  = str_replace("/$folderName", "", $string);
        $baseUrl = "$newUrl/noc_documents/";
        $uid = session()->get('userid');
        $view_back_attachment = DB::table('noc_form_foreigners')->where('id', $id)->first();
        $getbackdata = DB::table('doc_file_uploads_foreigner')
            ->Join('user_table', 'doc_file_uploads_foreigner.noc_user_id', '=', 'user_table.userid')
            ->select('doc_file_uploads_foreigner.created_at', 'doc_file_uploads_foreigner.updated_at', 'doc_file_uploads_foreigner.doc_id', 'doc_file_uploads_foreigner.doc_upload_ref', 'doc_file_uploads_foreigner.upload_desc', 'user_table.First_name', 'user_table.Last_name')
            ->where('doc_file_uploads_foreigner.app_id', $id)
            ->where('doc_file_uploads_foreigner.doc_id', 99)
            ->get();

        // dd($getbackdata);

        return view('layouts.admin.back_attachment_foreigner', compact('getbackdata', 'view_back_attachment', 'view_back_attachment', 'baseUrl'));
    }

    public function view_remarks_foreigner($cry_id)
    {
        $userid = Session::get('userid');
        $id = Crypt::decrypt($cry_id);
        //dd($id);
        $view_back_attachment = DB::table('noc_form_foreigners')->where('id', $id)->first();


      if($userid != 3 || $userid != 4){
    
            $view_remarks =  DB::table('work_flow_table')
            ->leftJoin('user_table', 'user_table.userid', '=', 'work_flow_table.user_id')
            ->leftJoin('noc_form_foreigners', function ($join) {
                $join->on('work_flow_table.user_id', '=', 'noc_form_foreigners.noc_userid')
                    ->on('work_flow_table.application_id', '=', 'noc_form_foreigners.id');
            })
            ->where('work_flow_table.application_id', $id)
            ->where('work_flow_table.service_id', 6)
            ->where('work_flow_table.is_active', 'NO')
            ->orderBy('work_flow_table.action_date', 'asc')
            ->get();

          
        }else{
        $view_remarks =  DB::table('work_flow_table')
            ->leftJoin('user_table', 'user_table.userid', '=', 'work_flow_table.user_id')
            ->leftJoin('noc_form_foreigners', function ($join) {
                $join->on('work_flow_table.user_id', '=', 'noc_form_foreigners.noc_userid')
                    ->on('work_flow_table.application_id', '=', 'noc_form_foreigners.id');
            })
            ->where('work_flow_table.application_id', $id)
            ->where('work_flow_table.service_id', 6)
            ->where('work_flow_table.user_id', $userid)
            ->where('work_flow_table.is_active', 'NO')
            ->orderBy('work_flow_table.action_date', 'asc')
            ->get();
        }
        

        return view('layouts.admin.view_remarks_foreigner', compact('view_remarks', 'view_back_attachment'));
    }

    public function back_attach_foreigner(Request $request)
    {
        $validated =  $request->validate([
            'description' => 'required',
            'file'        => 'required|mimes:pdf|max:2048'

        ]);

        $noc_user_id = 2;
        $app_id  = 20;
        $doc_id  = 22;
        $doc_type = 'Back attachment';

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();


        $destinationPath = 'D:/xampp/htdocs/noc_documents';
        // Store the file in the 'noc_documents' directory in the public disk

        $file->move($destinationPath, $filename);

        $dbpath = 'noc_documents/' . $filename;

        DB::table('doc_file_uploads_foreigner')->insert([
            'noc_user_id' => $noc_user_id,
            'app_id'   => $app_id,
            'doc_id'     => $doc_id,
            'doc_type'      => $doc_type,
            'doc_upload_ref' => $dbpath,
            'upload_date'  => now()
        ]);
        return back()->with('success', 'File uploaded successfully!');
    }



    //07-01-2025

    // public function art_clinic()
    // {

    //     return view('layouts.admin.art_clinic');
    // }

    // public function art_clinic_detail()
    // {
    //   return view('layouts.admin.art_clinic'); 
    // }


    public function nocgenerateforeignerPdf($id)
    {
        //dd('sfsfs');
        // Fetch the application data (adjust as needed)
        // $application = nocform::findOrFail($id);
        // Fetch the clinic names from the signup table
        $decryptedId = Crypt::decrypt($id);
        $application = Nocforeigner::findOrFail($decryptedId);
      //  dd($application);
        $app_id = $application->id;
        $clinicIds = [$application->from_name_clinic, $application->from_name_clinic1, $application->to_name_clinic2];
            $clinicNames = DB::table('signup')
                ->whereIn('id', $clinicIds)
                ->pluck('clinicname', 'id');
                
            $fromClinicName  = $clinicNames[$application->from_name_clinic] ?? null;
            $fromClinicName1 = $clinicNames[$application->from_name_clinic1] ?? null;
            $fromClinicName2 = $application->from_name_clinic2 ?? null;
            $toClinicName    = $clinicNames[$application->to_name_clinic]   ?? null;
            $toClinicName1   = $clinicNames[$application->to_name_clinic1]  ?? null;
            $toClinicName2   = $application->to_name_clinic2  ?? null;
        // Fetch the clinic names from the signup table
        $countryIds = [$application->country]; // IDs to fetch
        $countryNames = DB::table('apps_countries')
            ->where('id', $countryIds)
            ->pluck('country_name', 'id'); // Retrieve clinic names with IDs as keys

        $CountryName = $countryNames[$application->country] ?? null;
        $dataDocMaster = DB::table('doc_masters')
            ->select('doc_masters.*')
            ->whereIn('doc_type', [
                'upload_comp_institute_denied_export',
                'sending_bg_comp_inst',
                'receiving_bg_comp_inst',
                'details_planned_analysis',
                'biomaterial_micro_organisms_approval_file',
                'ibsc_rcgm_approval_applicable_file',
                'certified_copy_proforma',
                'declaration_letter'
            ])
            ->where('status', 1)
            ->get();
        if ($dataDocMaster->isNotEmpty()) {
            foreach ($dataDocMaster as $doc) {
                $doc_type = $doc->doc_type;
                $doc_id = $doc->id;
            }
        }
        $get_docfileData = DB::table('doc_file_uploads_foreigner')
            ->where('doc_file_uploads_foreigner.app_id', $app_id)
            ->orderBy('doc_master_id_ref','ASC') 
            ->get();
        //dd($get_docfileData);
        // Load the view and pass data
        $pdf = Pdf::loadView('layouts.noc.application_foreigner_pdf', compact('application', 'get_docfileData', 'fromClinicName', 'fromClinicName1', 'fromClinicName2', 'toClinicName', 'toClinicName1', 'toClinicName2', 'CountryName'));
        //dd($pdf);
        // Optionally, stream or download the PDF
        return $pdf->stream('application_foreigner_pdf.pdf');
        // For download: return $pdf->download('application_details.pdf');
    }


    public function nocforeignerPdf($id)
    {

        // Fetch the clinic names from the signup table
        // $decryptedId = Crypt::decrypt($id); 
        $application = Nocforeigner::findOrFail($id);
        //dd($application)   ;        
        $app_id = $application->id;
        $clinicIds = [$application->from_name_clinic, $application->to_name_clinic]; // IDs to fetch
        $clinicNames = DB::table('signup')
            ->whereIn('id', $clinicIds)
            ->pluck('clinicname', 'id');

        // Map the fetched clinic names to their respective variables
        $fromClinicName = $clinicNames[$application->from_name_clinic] ?? null;
        $toClinicName = $clinicNames[$application->to_name_clinic] ?? null;


        // Fetch the clinic names from the signup table
        $countryIds = [$application->country]; // IDs to fetch
        $countryNames = DB::table('apps_countries')
            ->where('id', $countryIds)
            ->pluck('country_name', 'id'); // Retrieve clinic names with IDs as keys

        $CountryName = $countryNames[$application->country] ?? null;

        $currentDate = Carbon::now()->format('jS F, Y'); // Example: "18th December, 2024"
        $app_no = $application->application_no;
        $qr_data = "Application Number =" . $app_no;
       
        $qrcode = QrCode::size(400)->generate($qr_data);

        $pdf = Pdf::loadView('layouts.noc.noc_foreigner_pdf', compact('application', 'qrcode', 'currentDate', 'fromClinicName', 'toClinicName', 'CountryName'))
            ->setOptions([
                'isRemoteEnabled' => true, 
            ]);

     
        return $pdf->download('noc_foreigner_pdf.pdf');
        
    }

   
}
