<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Admin\user;
use App\Models\Noc\nocform;
use Illuminate\Http\Request;
use App\Models\Admin\Noctable;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\SendEmailQueryRaised;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailWithAttachment;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Mail\SignupUserforgetpassword;
use Illuminate\Support\Facades\File;
use App\Models\Admin\SsaPwdUpload;


class AdminController extends Controller
{
    
    public function index()
    {
       
    }
   
    public function noc_page()
    {

        
        $id = Session::get('userid');
        $role = session()->get('role');
      //  dd($role);
        $noctable = new Noctable();
        $getdata_noc_data = $noctable->assignee();
        //dd($getdata_noc_data);
        $get_action_list = $noctable->action_list();
        $get_list_marked_for_approval = $noctable->get_list_marked_for_approval();
        $get_list_park_for_internal = $noctable->get_list_park_for_internal();
        $get_Park_for_external_committeit = $noctable->get_Park_for_external_committeit();
        $get_Park_for_Appex_Commity = $noctable->get_Park_for_Appex_Commity();
        $get_list_final_approval = $noctable->get_list_final_approval();
        $get_view_noc_pagelist_noc = $noctable->get_list_noc();
        
     
        return view('layouts.admin.noc_details', compact('role', 'getdata_noc_data', 'get_action_list', 'get_list_marked_for_approval', 'get_list_park_for_internal', 'get_Park_for_external_committeit', 'get_Park_for_Appex_Commity', 'get_list_final_approval','get_view_noc_pagelist_noc'));
   
    }


    public function pendency_report_view(){
      //  dd('sdsdfsdf');
        $id = Session::get('userid');
        $role = session()->get('role');
        $noctable = new Noctable();
        $get_pendency_list = $noctable->pendency_list();

        //dd($get_pendency_list);
        return view('layouts.admin.pendency_view_report', compact('role', 'get_pendency_list'));
    }

    public function view_noc_page($cry_id, $cry_level_id)
    {
        $id = Crypt::decrypt($cry_id);
        $level_id = Crypt::decrypt($cry_level_id);
        $role = session()->get('role');
        $level_id = $level_id;
        $nocForm = DB::table('noc_form')->where('id', $id)->first();
        $application_no =  $nocForm->application_no; 
        $medical_status = DB::table('work_flow_table')
            ->where('application_id', $id)
            ->where('level_id', $level_id)
            ->first();

        $created_at = \Carbon\Carbon::parse($nocForm->created_at)->format('Y-m-d');

        $noc_enc = $id;
       
        $links = [
            'view_application' => 'View Application',
            'front_attachment' => "Applicant's Attachment",
            'back_attachment'  => 'Back Attachment',
            'view_remarks'     => 'Remarks',
        ];

        $linkColors = [
            'view_application' => '#105f73',
            'front_attachment' => '#412904',
            'back_attachment'  => '#0e471c',
            'remarks' => '#710d0d',
        ];

        $tabcss = 'col-xl-3';
        return view('layouts.admin.view_form', compact('medical_status', 'application_no', 'created_at', 'nocForm', 'links', 'linkColors', 'tabcss', 'noc_enc', 'role', 'level_id'));
    }
// 
public function add_remarks(Request $request)
{
    $uid  = session()->get('userid');
    $role = session()->get('role');

    $validated = $request->validate(
        [
            'application_id'        => 'required|integer',    
            'remarks'               => 'required',
            'notesheet'             => '',
            'medical_report'        => '',
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

    // Extract validated and session data
    $medicalReport     = $validated['medical_report'] ?? '';
    $uplodremr         = $validated['uploadremarks'] ?? [];
    $noc_user_id       = $uid;
    $doc_id            = 99;
    $doc_master_id_ref = 1000;
    $doc_type          = 'other documents';
    $files             = $request->file('uploadfile') ?? [];
    $application_id    = $validated['application_id'];
    $service_id        = 1;
    $level_action      = $validated['level_action'];
    $level_id          = $validated['level_id'];
    $remarks           = $validated['remarks'];
    $get_userid        = nextActor($level_action, $application_id, $service_id);
    $action_taken_by   = status_name($level_action, $application_id, $service_id);

    $rawFolder   = $request->applicantion_no;
    $newAppNo    = sanitizeFolderName($rawFolder);
    // $basePath    = "D:/xampp/htdocs/webprodfiles/noc_application/{$newAppNo}/";
    $foldername   = 'noc_application';
    $basePath     = folderpath($foldername) . "/{$newAppNo}/";
   // dd($basePath);
    $registryPath = $basePath . 'registry/';

    // Validate each file before starting transaction
    if (!empty($files)) {
        foreach ($files as $index => $file) {
            if (!$file || !$file->isValid()) {
                return redirect()->back()->withErrors(["File at index {$index} is not a valid upload."]);
            }

            if ($file->getMimeType() !== 'application/pdf') {
                return redirect()->back()->withErrors(["File '{$file->getClientOriginalName()}' is not a valid PDF."]);
            }

            if ($file->getSize() > 5000000) {
                return redirect()->back()->withErrors(["File '{$file->getClientOriginalName()}' exceeds the 5MB limit."]);
            }
        }
    }

    try {
        DB::beginTransaction();
       // dd($basePath);
        // Ensure base and registry directories exist
        if (!is_dir($basePath)) {
            Log::error("Base directory does not exist: {$basePath}");
            return redirect()->back()->with('error', 'Base directory does not exist.');
        }

        if (!is_dir($registryPath) && !mkdir($registryPath, 0777, true)) {
            Log::error("Failed to create registry directory: {$registryPath}");
            return redirect()->back()->with('error', 'Failed to create registry directory.');
        }

        // Only process and insert files if available
        if (!empty($files) && is_array($files)) {
            foreach ($files as $index => $file) {
                if (!$file || !$file->isValid()) 
                    continue;

                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $safeName = preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
                $uniqueFileName = strtolower($safeName) . '_' . now()->format('d-m-Y_His') . '.' . $extension;

                $file->move($registryPath, $uniqueFileName);

                DB::table('doc_file_uploads')->insert([
                    'noc_user_id'        => $noc_user_id,
                    'app_id'             => $application_id,
                    'doc_id'             => $doc_id,
                    'doc_type'           => $doc_type,
                    'doc_master_id_ref'  => $doc_master_id_ref,
                    'doc_upload_ref'     => $uniqueFileName,
                    'upload_desc'        => $uplodremr[$index] ?? '',
                    'created_at'         => now(),
                ]);
            }
        }

        // Determine previous level
        if ($level_action === 7) {
            $pre_level = $level_action - 5;
        } elseif ((string)$level_id === '6') {
            $pre_level = $level_action + 3;
        } elseif ((string)$level_action === '6') {
            $action_taken_by = 'Revise the Query';
            $pre_level = $level_action - 3;
        } else {
            $pre_level = $level_action - 1;
        }

        // $receivingdate = previoucs_date_wfd($application_id, $pre_level);

        $updateData = [
            'notesheet'       => $validated['notesheet'],
            'remarks'         => $validated['remarks'],
            'is_active'       => 'NO',
            'action_date'     => now()->format('Y-m-d H:i:s')
        ];

        if ($role == 4) {
            $updateData['query_raised_by'] = $get_userid;
        }

        DB::table('work_flow_table')
            // ->where('level_id', $pre_level)
            ->where('application_id', $application_id)
            ->where('is_active', 'YES')
            ->update($updateData);

        $is_active = 'YES';

        // Email notification & user name resolution
        if ($level_action == 4) {
            $filePath = "Please login art portal and act in the Noc application by the center authorities.";   
            $usermail = UserMailGet($get_userid);
            Mail::to($usermail)->send(new SendEmailQueryRaised($filePath));
            $username = optional(DB::table('user_request_table')->where('id', $get_userid)->first())->user_name ?? 'User';
        } elseif ($level_action >= 7 && $level_action <= 10) {
            $username = match ($level_action) {
                7 => "May Be Approved",
                8 => "Marked for approval process",
                9 => "Park for Internal committee",
                10 => "Park for external committee",
                default => "Assignee"
            };
        } else {
            $username = optional(DB::table('user_table')->where('userid', $get_userid)->first())->username ?? 'User';
        }

        // Insert new workflow entry
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
            'submission_date'   => now()
        ]);

        DB::commit();

        $successMessage = ($level_action >= 7 && $level_action <= 10) ? 'Application has been ' . $username . '!' : 'Application has been Forwarded to ' . $username . '!';
        return redirect()->route('admin.noc_details')->with('success_add', $successMessage);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Transaction failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}


// 
    public function nocgenrate(Request $request)
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
        $rawFolder   = $request->applicantion_no;
      //  dd($rawFolder);
        $newAppNo      = sanitizeFolderName($rawFolder);
        //dd($newAppNo);
        // $basePath      = "D:/xampp/htdocs/webprodfiles/noc_application/{$newAppNo}/";
        $foldername   = 'noc_application';
        $basePath     = folderpath($foldername) . "/{$newAppNo}/";
         $registryPath = $basePath . 'registry/';

        //dd($basePath);

         if (!is_dir($basePath)) {
            Log::error("Base directory does not exist: {$basePath}");
            return redirect()->back()->with('error', 'Base directory does not exist.');
        }

        if (!is_dir($registryPath) && !mkdir($registryPath, 0777, true)) {
            Log::error("Failed to create registry directory: {$registryPath}");
            return redirect()->back()->with('error', 'Failed to create registry directory.');
        }


        if (!empty($file)) {
            $fileName = $file->getClientOriginalName();
            $fileMimeType = $file->getMimeType();

            if ($fileMimeType == 'application/pdf') {
                $destinationPath = $registryPath;
                $originalName    = $fileName;
                $extension       = $file->getClientOriginalExtension();
                $safeName        = preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
                $uniqueFileName  = strtolower($safeName) . '_' . now()->format('d-m-Y_His') . '.' . $extension;

                $file->move($destinationPath, $uniqueFileName);
               // dd('move');
                $dbpath = $fileName;

                $lastInsertedId = DB::table('doc_file_uploads')->insertGetId([
                    'noc_user_id'    => $user_id,
                    'app_id'         => $app_id,
                    'doc_id'         => $doc_id,
                    'doc_type'       => $doc_type,
                    'doc_upload_ref' => $dbpath,
                    'upload_desc'    => $doc_type
                ]);


                DB::table('noc_genrate_table')->insert([
                    'internal_recommanation'   => $validated['internal_recommanation'],
                    'external_commitee'        => $validated['external_commitee'],
                    'appex_commitee'           => $validated['appex_commitee'],
                    'approval_checked'         => $validated['approval_checked'],
                    'user_id'                  => $user_id,
                    'app_id'                   => $app_id,
                    'noc_user_id'              => get_noc_user_id($app_id),
                    'doc_file_upload_id'       => $lastInsertedId,
                    'doc_type'                 => $doc_type,
                    'path'                     => $dbpath
                ]);

                DB::table('work_flow_table')
                    ->where('user_id', $user_id)
                    ->where('application_id', $app_id)
                    ->update(['is_active' => 'NO']);

                $file2 = 'noc_documents';
                $filePath = $destinationPath . '/' . $fileName;


                if (file_exists($filePath)) {
                    $sent = Mail::to('naseerkhan190187@gmail.com')->send(new SendEmailWithAttachment($filePath));

                    // You can add a conditional check to see if the email was successfully sent
                    if ($sent) {
                        return redirect()->route('admin.noc_details')->with('success', 'Mail send has been successfully!');
                    } else {
                        return redirect()->route('admin.noc_details')->with('error', 'Mail send has been successfully!');
                    }
                } 


                return redirect()->route('admin.noc_details')->with('success', 'Noc genrate and Form submit successfully!');
            } else {
                return redirect()->route('admin.noc_details')->with('error', 'Please select pdf file formate');
            }
        }
    }


    public function view_application($cry_id)
    {
        // $url = url('/');
        // $parsed_url = parse_url($url);
        // $newUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        // $baseUrl = "$newUrl/artprojfiles/noc_application/";
        try {

            $decryptedId = Crypt::decrypt($cry_id);
            $application = nocform::findOrFail($decryptedId);
            $app_id = $application->id;
            $clinicIds = [$application->from_name_clinic, $application->to_name_clinic]; // IDs to fetch
            $clinicNames = DB::table('signup')
                ->whereIn('id', $clinicIds)
                ->pluck('clinicname', 'id');


            $fromClinicName  = $clinicNames[$application->from_name_clinic] ?? null;
            $fromClinicName1 = $clinicNames[$application->from_name_clinic1] ?? null;
            $fromClinicName2 = $clinicNames[$application->from_name_clinic2] ?? null;
            $toClinicName    = $clinicNames[$application->to_name_clinic] ?? null;
            $toClinicName1   = $clinicNames[$application->to_name_clinic1] ?? null;
            $toClinicName2   = $clinicNames[$application->to_name_clinic2] ?? null;


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

            $get_docfileData = DB::table('doc_file_uploads')
                ->where('doc_file_uploads.app_id', $app_id)
                ->orderBy('doc_file_uploads.doc_master_id_ref', 'ASC')
                ->get();
            
              return view('layouts.admin.view_application', compact('application', 'get_docfileData', 'fromClinicName', 'fromClinicName1', 'fromClinicName2', 'toClinicName',  'toClinicName1', 'toClinicName2', 'CountryName'));
           }catch(DecryptException $e){
               abort(404, 'Invalid ID');
           }
        //dd($view_data);
        // return view('layouts.admin.view_application', compact('view_data'));
    }

    public function front_attachment($cry_id)
    {
        $id = Crypt::decrypt($cry_id);
        // $folderName = basename(base_path());
        // $string  = url('/');
        // $newUrl  = str_replace("/$folderName", "", $string);
        // $baseUrl = "$newUrl/artprojfiles/noc_application/";

        $uid = session()->get('userid');
        $view_attachment = DB::table('noc_form')->where('id', $id)->first();
        $getdata_front_attach = DB::table('noc_form')->where('id', $id)->first();
        

        // $getbackdata = DB::table('doc_file_uploads')
        //     ->leftJoin('noc_form', function ($join) use ($id) {
        //         $join->on('doc_file_uploads.noc_user_id', '=', 'noc_form.noc_userid')
        //             ->on('doc_file_uploads.app_id', '=', 'noc_form.id');
        //     })
        //     ->where('doc_file_uploads.app_id', '=', $id)
        //     ->where('doc_file_uploads.doc_id', '!=', 99)
        //     ->orderBy('doc_file_uploads.id', 'ASC')
        //     ->get();

       $getbackdata = DB::table('doc_file_uploads')
                ->leftJoin('noc_form', function ($join) use ($id) {
                    $join->on('doc_file_uploads.noc_user_id', '=', 'noc_form.noc_userid')
                        ->on('doc_file_uploads.app_id', '=', 'noc_form.id');
                })
                ->where('doc_file_uploads.app_id', '=', $id)
                ->where('doc_file_uploads.doc_id', '!=', 99)
                ->orderBy('doc_file_uploads.id', 'ASC')
                ->select([
                    'doc_file_uploads.id as doc_id',
                    'doc_file_uploads.doc_id',
                    'doc_file_uploads.app_id',
                    'doc_file_uploads.upload_desc',
                    'doc_file_uploads.noc_user_id',
                    'doc_file_uploads.doc_upload_ref',
                    'doc_file_uploads.created_at'   
                ])
    ->get();

     //dd($getbackdata);


        return view('layouts.admin.front_attachment', compact('getbackdata', 'view_attachment'));
    }
    public function back_attachment($cry_id)
    {
        $id = Crypt::decrypt($cry_id);
        //
        // $folderName = basename(base_path());
        // $string  = url('/');
        // $newUrl  = str_replace("/$folderName", "", $string);
        // $baseUrl = "$newUrl/artprojfiles/noc_application/";
        $uid = session()->get('userid');
        $view_back_attachment = DB::table('noc_form')->where('id', $id)->first();
        $getbackdata = DB::table('doc_file_uploads')
            ->Join('user_table', 'doc_file_uploads.noc_user_id', '=', 'user_table.userid')
            ->select('doc_file_uploads.created_at', 'doc_file_uploads.updated_at', 'doc_file_uploads.doc_id', 'doc_file_uploads.doc_upload_ref', 'doc_file_uploads.upload_desc', 'user_table.First_name', 'user_table.Last_name')
            ->where('doc_file_uploads.app_id', $id)
            ->where('doc_file_uploads.doc_id', 99)
            // ->where('doc_file_uploads.doc_master_id_ref', 1000)
            ->get();

        // dd($getbackdata);

        return view('layouts.admin.back_attachment', compact('getbackdata', 'view_back_attachment', 'view_back_attachment'));
    }

    public function view_remarks($cry_id)
    {
        $userid = Session::get('userid');
        $id = Crypt::decrypt($cry_id);
        //dd($id);
        $view_back_attachment = DB::table('noc_form')->where('id', $id)->first();


      if($userid != 3 || $userid != 4){
    
            $view_remarks =  DB::table('work_flow_table')
            ->leftJoin('user_table', 'user_table.userid', '=', 'work_flow_table.user_id')
            ->leftJoin('noc_form', function ($join) {
                $join->on('work_flow_table.user_id', '=', 'noc_form.noc_userid')
                    ->on('work_flow_table.application_id', '=', 'noc_form.id');
            })
            ->where('work_flow_table.application_id', $id)
            ->where('work_flow_table.is_active', 'NO')
            ->orderBy('work_flow_table.action_date', 'asc')
            ->get();

        }else{
                $view_remarks =  DB::table('work_flow_table')
                    ->leftJoin('user_table', 'user_table.userid', '=', 'work_flow_table.user_id')
                    ->leftJoin('noc_form', function ($join) {
                        $join->on('work_flow_table.user_id', '=', 'noc_form.noc_userid')
                            ->on('work_flow_table.application_id', '=', 'noc_form.id');
                    })
                    ->where('work_flow_table.application_id', $id)

                    ->where('work_flow_table.user_id', $userid)
                    ->where('work_flow_table.is_active', 'NO')
                    ->orderBy('work_flow_table.action_date', 'asc')
                    ->get();
        }

       // dd($view_remarks);
        

        return view('layouts.admin.view_remarks', compact('view_remarks', 'view_back_attachment'));
    }

    public function back_attach(Request $request)
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

        DB::table('doc_file_uploads')->insert([
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

    public function art_clinic()
    {

        return view('layouts.admin.art_clinic');
    }

    public function art_clinic_detail()
    {
      return view('layouts.admin.art_clinic'); 
    }


    public function nocgeneratePdf($id)
    {
    
        // $url = url('/');
        // $parsed_url = parse_url($url);
        // $newUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        // $baseUrl = "$newUrl/artprojfiles/noc_application/";

        $decryptedId = Crypt::decrypt($id);
        $application = nocform::findOrFail($decryptedId);
      //  dd($application);
        $app_id = $application->id;
        $clinicIds = [$application->from_name_clinic, $application->to_name_clinic]; // IDs to fetch
        $clinicNames = DB::table('signup')
            ->whereIn('id', $clinicIds)
            ->pluck('clinicname', 'id'); // Retrieve clinic names with IDs as keys

        // Map the fetched clinic names to their respective variables
        $fromClinicName = $clinicNames[$application->from_name_clinic] ?? null;
        $toClinicName = $clinicNames[$application->to_name_clinic] ?? null;
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
      $get_docfileData = DB::table('doc_file_uploads')
            ->where('doc_file_uploads.app_id', $app_id)
            ->orderBy('doc_master_id_ref','ASC') 
            ->get();
        //dd($get_docfileData);
        // Load the view and pass data
        $pdf = Pdf::loadView('layouts.admin.application_pdf', compact('application', 'get_docfileData', 'fromClinicName', 'toClinicName', 'CountryName'));
        //dd($pdf);
        // Optionally, stream or download the PDF
        return $pdf->stream('application_pdf.pdf');
        // For download: return $pdf->download('application_details.pdf');
    }


    public function nocPdf($id)
    {

      // 

        // Fetch the clinic names from the signup table
        // $decryptedId = Crypt::decrypt($id); 
        $application = nocform::findOrFail($id);
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
        
        $pdf = Pdf::loadView('layouts.noc.noc_pdf', compact('application', 'qrcode', 'currentDate', 'fromClinicName', 'toClinicName', 'CountryName'))
            ->setOptions([
                'isRemoteEnabled' => true, 
            ]);

     
        return $pdf->download('noc_pdf.pdf');
        
    }
    public function ssaresetpwd()
    {
        // $users = user::with('state')->distinct()->get();
        $users = user::select('stateid')->distinct()->with('state')->get();
        //dd($users);
        return view('layouts.admin.reset_password', compact('users'));
    }
    public function getEmailsByState(Request $request)
    {
        $stateId = $request->state_id;
        $search  = $request->search;

        if (!$stateId) {
            return response()->json([]);
        }

        $query = user::where('stateid', $stateId)->where('isAdmin',1)
            ->when($search, function ($q) use ($search) {
                $q->where('email', 'LIKE', "%{$search}%");
            })
            ->limit(20)
            ->get();

        $results = [];

        foreach ($query as $user) {
            $results[] = [
                'id' => $user->email,    // value returned to form
                'text' => $user->email,  // text displayed in dropdown
            ];
        }

        return response()->json($results);
    }

     public function ssaresetpwdsubmit(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'email' => 'required|email|exists:user,email',
            'stateid' => 'required|exists:state,state_id',
            'resetfile' => 'required|mimes:pdf|max:1024',
        ], [
            'resetfile.required' => 'Please upload a PDF file.',
            'resetfile.mimes' => 'Only PDF files are allowed.',
            'resetfile.max' => 'The file size must not exceed 1 MB.',
        ]);
        $email = $request->input('email');
        $stateId = $request->input('stateid');
        // Check if user exists with the selected state
        $user = user::where([
                'email' => $email,
                'stateid' => $stateId,
                'isAdmin' => 1,
                // 'isresetrequest' => 0,
            ])
            ->first();
        if (!$user) {
            return redirect()->route('admin.resetpassword')->with('error', 'Email does not exist for the selected state or already request is sent.');
        }
        
        // Update request and ministry_approved fields
        // Increment the isresetrequest field and update ministry_approved
        try{
            if ($request->hasFile('resetfile')) {
                $file = $request->file('resetfile');
                $timestamp = time();
                $filename = "resetpassword_{$stateId}_{$timestamp}.pdf";
                $folder = folderpath('ssaresetpassword');
                if (!File::exists($folder)) {
                    File::makeDirectory($folder, 0755, true);
                }
                $file->move($folder, $filename);
            }
            DB::beginTransaction();
            $token = Str::random(60);
            // Encrypt the email
            $encryptedEmail = Crypt::encryptString($email);
            // Construct the custom link
            $link = url("signup-reset-password_ssa?email={$encryptedEmail}&token={$token}");
            $signuppasswordrequest = [
            'link' => $link,
            ];
            Mail::to($request->email)->send(new SignupUserforgetpassword($signuppasswordrequest));
            // Get admin info (adjust according to your auth/session structure)
            $adminId = session('userid');
            $adminIp = $request->ip();
                // Save record in ssa_pwd_upload table
                SsaPwdUpload::create([
                    'admin_id' => $adminId,
                    'admin_ip' => $adminIp,
                    'file_partial_path' => $filename,
                    'remark' => 'Password reset file uploaded',
                    'state_id' => $stateId,
                    'ssa_id' => $user->id,
                ]);
            $user->increment('isresetrequest');
            DB::table('user')->updateOrInsert(
                    ['email' => $request->email],
                    [
                        'token' => Hash::make($token),
                        'ministry_approved' => 1,
                        'updated_at' => now(),
                    ]
                );
            DB::commit();
            return redirect()->route('admin.resetpassword')->with('success', 'Reset link sent successfully.');
        }
        catch (\Exception $e) {
        DB::rollBack();
        Log::error('Password not updated: ' . $e->getMessage());
        return redirect()->route('admin.resetpassword')->with('error', 'An error occurred while ssa password change.');
        }
        
    }

}
