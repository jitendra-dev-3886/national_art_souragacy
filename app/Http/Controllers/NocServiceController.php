<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Mail\UserRequest;
use App\Models\Noc\UserNoc;
use Illuminate\Http\Request;


use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Noc\Nocforeigner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class NocServiceController extends Controller
{

public function myapplication_foreigner()
{
        $uid = session()->get('id');
        $data = new UserNoc();
        $userdata = $data->myapplication_query_raised($uid);
        return view('layouts.noc.myapplication_foreigner', compact('userdata'));
}


public function view_user_form_foreigner($cry_id, $cry_level_id)
{
  //  dd('sfsdf');
        $id = Crypt::decrypt($cry_id);
        $id = 346;
        $level_id = Crypt::decrypt($cry_level_id);
        $role = session()->get('role');
        $userid = session()->get('id');
        $level_id = $level_id;
        $nocForm = DB::table('noc_form_foreigners')->where('id', $id)->first();
       // dd($nocForm);
        $created_at = date("Y-m-d", strtotime($nocForm->created_at));
        $noc_enc = $id;

        $medical_status = DB::table('work_flow_table')
            ->where('application_id', $id)
            ->where('level_id', $level_id)
            ->where('service_id', 6)
            ->where('user_id', $userid)
            ->first();

        $links = [
            'view_user_application_foreigner' => 'View Application',
            'front_user_attachment_foreigner' => "My Attachment's",
            'view_user_remarks_foreigner'     => 'Remarks',
        ];

        $linkColors = [
            'view_user_application_foreigner' => '#105f73',
            'front_user_attachment_foreigner' => '#412904',
            'view_user_remarks' => '#710d0d',
        ];

        $tabcss = 'col-xl-3';
       // dd('sdfsdf');
        return view('layouts.noc.view_user_form_foreigner', compact('medical_status', 'nocForm', 'links', 'linkColors', 'tabcss', 'noc_enc', 'role', 'level_id', 'created_at'));
    }


    public function front_user_attachment_foreigner($cry_id, $cry_level_id){

        $id = Crypt::decrypt($cry_id);

        $url = url('/');
        $parsed_url = parse_url($url);
        // $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        // $trimmedPath = trim($path, '/');
        // $folderName = basename($trimmedPath);

        $newUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        $baseUrl = "$newUrl/noc_documents/";


        $id = Crypt::decrypt($cry_id);
        $uid = session()->get('id');
        $view_attachment = DB::table('noc_form')->where('id', $id)->first();
        $getdata_front_attach = DB::table('doc_file_uploads')
            ->leftJoin('noc_form', function ($join) {
                $join->on('doc_file_uploads.noc_user_id', '=', 'noc_form.noc_userid')
                    ->on('doc_file_uploads.app_id', '=', 'noc_form.id');
            })
            ->select(
                'doc_file_uploads.noc_user_id',
                'doc_file_uploads.app_id',
                'doc_file_uploads.doc_id',
                'doc_file_uploads.doc_type',
                'doc_file_uploads.doc_upload_ref',
                'doc_file_uploads.upload_desc',
                'noc_form.name_applicant',
                'noc_form.email',
                'noc_form.noc_userid',
                'doc_file_uploads.created_at as created_at',  // Alias for doc_file_uploads created_at
                'doc_file_uploads.updated_at as updated_at'  // Alias for user_table created_at
            )

            ->where('doc_file_uploads.app_id', $id)
            ->where('doc_file_uploads.doc_id', '!=', 99)
            ->get();
        //dd($getdata_front_attach);


        return view('layouts.noc.front_user_attachment_foreigner', compact('getdata_front_attach', 'view_attachment', 'baseUrl', 'cry_id', 'cry_level_id'));

    }

    public function view_user_remarks_foreigner($cry_id, $cry_level_id)
    {
        $id = Crypt::decrypt($cry_id);
        $ide = '';
        // $userid = session()->get('id');

        $view_back_attachment = DB::table('noc_form')->where('id', $id)->first();
        $view_user_remarks = DB::table('work_flow_table')
            ->leftJoin('noc_form', function ($join) {
                $join->on('work_flow_table.user_id', '=', 'noc_form.noc_userid')
                    ->on('work_flow_table.application_id', '=', 'noc_form.id');
            })
            ->leftJoin('user_table', 'user_table.userid', '=', 'work_flow_table.user_id')
            ->where('work_flow_table.application_id', $id)
            ->where('work_flow_table.query_raised_by', '!=', '')
            ->orderBy('work_flow_table.id', 'asc')
            ->get();



        //dd($view_user_remarks);

        return view('layouts.noc.view_user_remarks_foreigner', compact('view_user_remarks', 'view_back_attachment', 'id', 'cry_id', 'cry_level_id'));
    }


    public function view_user_application_foreigner($cry_id, $cry_level_id)
    {

        $id = Crypt::decrypt($cry_id);
        $application = DB::table('noc_form')->where('id', $id)->first();
        $get_docfileData = DB::table('doc_file_uploads')
            ->where('doc_file_uploads.app_id', $application->id)
            ->orderBy('doc_file_uploads.doc_master_id_ref', 'ASC')
            ->get();

        //dd($get_docfileData);

        return view('layouts.noc.view_user_application_foreigner', compact('application', 'cry_id', 'cry_level_id', 'get_docfileData'));
    }


    public function nocgenerate_foreigner_Pdf($id)
    {
        ///dd('sdfsdfsd');
        $decryptedId = Crypt::decrypt($id);
        $application = Nocforeigner::findOrFail($decryptedId);
   //  dd($application->from_name_clinic1);
        $app_id = $application->id;
        $clinicIds = [$application->from_name_clinic, $application->from_name_clinic1, $application->to_name_clinic]; // IDs to fetch
        $clinicNames = DB::table('signup')
            ->whereIn('id', $clinicIds)
            ->pluck('clinicname', 'id'); // Retrieve clinic names with IDs as keys

      // dd($clinicNames);

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
        // $get_docfileData = DB::table('doc_file_uploads')
        //     ->where('doc_file_uploads.app_id', $app_id)
        //     ->orderBy('doc_master_id_ref','ASC') 
        //     ->get();

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


    public function add_user_remarks_foreigner(Request $request)
    {

        $uid = session()->get('id');
        $validated = $request->validate([
            'application_id'       => 'required|integer',
            'remarks'              => '',
            'uploadremarks.*'      => '',
            'level_action'         => 'required|integer',
            'uploadfile.*'         => 'file|mimes:pdf|max:250',
            'uploadfileMedical.*'  => 'file|mimes:pdf|max:5120',
            'medical_report'        => '',
            'created_at'           => 'required'
        ]);

            $medicalReport = isset($validated['medical_report']) ? $validated['medical_report'] : '';

            $uplodremr = $validated['uploadremarks'];
            $arr1 = isset($validated['uploadfileMedical']) ? $validated['uploadfileMedical'] : [];

            $noc_user_id = $uid;
            $app_id = $validated['application_id'];
            $doc_id = 24;
            $doc_master_id_ref = 900;

            $doc_type = doc_type($doc_id);
            $arr2 = isset($validated['uploadfile']) ? $validated['uploadfile'] : [];

            if (!empty($arr1)) {
                $files = array_merge($arr1, $arr2);
            } else {
                $files = $request->file('uploadfile');
            }
      
        
        if (!empty($files) && is_array($files)) {
            $i = 0;
            foreach ($files as $file) {
                $fileName = $file->getClientOriginalName();
                $safeFileName = preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', $fileName);
                $uniqueFileName = strtolower($safeFileName) . '.' . time() . '_' . microtime(true);
                $fileMimeType = $file->getMimeType();

                if (isset($uplodremr[$i])) {
                    $uploadDesc = $uplodremr[$i];
                } else {
                    $uploadDesc = '';
                }

                if ($fileMimeType == 'application/pdf') {
                    $destinationPath = 'D:/xampp/htdocs/noc_documents';
                    $file->move($destinationPath, $uniqueFileName);
                    $dbpath = $uniqueFileName;

                    DB::table('doc_file_uploads_foreigner')->insert([
                        'noc_user_id' => $noc_user_id,
                        'app_id' => $app_id,
                        'doc_id' => $doc_id,
                        'doc_type' => $doc_type,
                        'doc_upload_ref' => $dbpath,
                        'doc_master_id_ref'=>$doc_master_id_ref,
                        'upload_desc' => $uploadDesc,
                        'created_at' => now()
                    ]);
                }
                $i++;
            }
        }

        $application_id = $validated['application_id'];
        $service_id = 6;
        $remarks = $validated['remarks'];
        $level_id = $validated['level_action'];
        $is_active = "YES";
        $get_userid = nextActor($level_id, $application_id, $service_id);

        $pre_level = $level_id - 1;
        $currentDate = Carbon::now()->format('Y-m-d');
        $receiving_date = previoucs_date_wfd($application_id,$pre_level);
      
        

        DB::table('work_flow_table')
            ->where('level_id', $pre_level)
            ->where('service_id', $service_id)
            ->where('application_id', $application_id)
            // ->where('is_active', 'YES')
            ->update([
                'submission_date' => $currentDate,
                'action_date' => $currentDate,
                'remarks' => $remarks,
                'noc_user' => 1,
                'query_raised_by' => $get_userid,
                'is_active' => 'NO',
                'action_date'      => Carbon::now()->format('Y-m-d H:i:s')
            ]);

        DB::table('work_flow_table')->insert([
            'application_id' => $application_id,
            'service_id' => $service_id,
            'level_id' => $level_id,
            'user_id' => $get_userid,
            'remarks' => '',
            'medical_report' => $medicalReport,
            'is_active' => $is_active,
            'action_taken_by' => 'Reply back to assignee',
            'submission_date' =>  Carbon::now()
        ]);

        return redirect()->route('noc.noc_form_list_foreigner')->with('success_user_add', 'Application has been submitted successfully!');
    }


    public function nocForm_list_foreigner()
    {

        $url = url('/');
        $parsed_url = parse_url($url);
        $newUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        $baseUrl = "$newUrl/noc_documents/";
        if (empty(Session::has('id'))) {
            return redirect()->route('noc.loginnocform');
        }

        $userId = Session::get('id');

        $data = new UserNoc();
        $nocformList = $data->myapplication($userId);
        // dd($nocformList);

        return view('layouts.noc.noc_form_list_foreigner', compact('nocformList', 'baseUrl'));
    }


}

