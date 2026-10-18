<?php

namespace App\Http\Controllers;

use Archive_model;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Admin\Archive;
use App\Models\Admin\NocAjax;
use App\Models\clinic\signup;
use App\Models\Admin\Noctable;
use App\Models\Admin\user;
use App\Models\clinic\ArtClinicDirectorModel;
use App\Models\clinic\ArtClinicEquipmentModel;
use App\Models\clinic\ArtClinicOtherStaffModel;
use App\Models\clinic\BankEquipmentModel;
use App\Models\clinic\BankOtherStaffModel;
use App\Models\clinic\SurrogacyClinicDirectorModel;
use App\Models\clinic\SurrogacyClinicEquipmentModel;
use App\Models\clinic\SurrogacyClinicOtherStaffModel;
use App\Models\clinic\BankModel;
use App\Models\Admin\ArchiveTable;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Admin\WorkFlowTable;
use App\Models\clinic\ArtClinicModel;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\DocFilereceivedUpload;
use App\Models\DocFileRegistrationCertificateUpload;
use Illuminate\Support\Facades\Session;
use App\Models\clinic\SurrogacyClinicModel;
use App\Models\Admin\ClinicRegistrationTempModel;
use App\Models\Admin\ClinicEstbTempModel;
use Illuminate\Support\Facades\Log;
use App\Models\renewal\RenewalSCApplication;
use App\Models\clinic\Statetable;
use Exception;

class DataTableController extends Controller
{
      public function viewApplications()
    {

        return view('layouts.admin.archive_search_application');
    }

    // Show single application details
    // handle the form submit, search selected table and return same view with result (POST)
    public function showApplication(Request $request, $download = false)
    {
        $data = $request->validate([
            'clinic_type'    => 'required|in:art_bank,art_clinic,art_surrogacy',
            'application_no' => 'required|string',
        ]);
       

        $clinicType    = $data['clinic_type'];
        $applicationNo = trim($data['application_no']);
        // dd($applicationNo);
        // Initialize variables so compact() works
        $app = null;
        $directors = collect();
        $equipments = collect();
        $staff = collect();
        $status = null;
        switch ($clinicType) {
            case 'art_clinic':
                $app = ArtClinicModel::where('applicationno', 'like', "%{$applicationNo}%")
                        ->where('status',1)
                        ->when(session('user_type') == 5, function ($query) {
                                $query->where('state', Session::get('state_name'));
                            })
                        ->orderBy('id', 'desc')
                        ->first();
                
                

                if ($app) {
                    $directors  = ArtClinicDirectorModel::where('userid', $app->userid)->get();
                    $equipments = ArtClinicEquipmentModel::where('userid', $app->userid)->get();
                    $staff      = ArtClinicOtherStaffModel::where('userid', $app->userid)->get();
                    $docfilecertificate = DocFileRegistrationCertificateUpload::where('userid',$app->userid)->where('app_id',$app->id)->get();
                    $DocFilereceivedUpload = DocFilereceivedUpload::where('userid',$app->userid)->where('app_id',$app->id)->get();
                    $clinic_id= ClinicRegistrationModel:: where('userid_applicant',$app->userid)
                            ->where('clinic_type','ARTCLINIC')
                            ->when(session('user_type') == 5, function ($query) {
                                        $query->where('state', Session::get('state_name'));
                                    })
                    ->pluck('clinic_id');

                //     dd([
                //     'docfilecertificate'    => $docfilecertificate,
                //     'DocFilereceivedUpload' => $DocFilereceivedUpload,
                //     'clinicID' =>$clinic_id,
                // ]);
                }
                break;

            case 'art_bank':
                $app = BankModel::where('applicationno', 'like', "%{$applicationNo}%")
                        ->where('status',1)
                        ->when(session('user_type') == 5, function ($query) {
                                $query->where('state', Session::get('state_name'));
                            })
                        ->orderBy('id', 'desc')
                        ->first();

                if ($app) {
                
                    $equipments = BankEquipmentModel::where('userid', $app->userid)->get();
                    $staff      = BankOtherStaffModel::where('userid', $app->userid)->get();
                    $docfilefee = DocFilereceivedUpload::where('userid',$app->userid)->where('app_id',$app->id)->get();
                    $docfilecertificate = DocFileRegistrationCertificateUpload::where('userid',$app->userid)->where('app_id',$app->id)->get();
                    $DocFilereceivedUpload = DocFilereceivedUpload::where('userid',$app->userid)->where('app_id',$app->id)->get();
                    $clinic_id= ClinicRegistrationModel:: where('userid_applicant',$app->userid)
                            ->where('clinic_type','ARTBANK')
                            ->when(session('user_type') == 5, function ($query) {
                                        $query->where('state', Session::get('state_name'));
                                    })
                            ->pluck('clinic_id');
                //        dd([
                //     'docfile  certificate'    => $docfilecertificate,
                //     'DocFilereceivedUpload' => $DocFilereceivedUpload,
                //     'clinicID' =>$clinic_id,
                // ]);
                }
                break;

            case 'art_surrogacy':
                $app = SurrogacyClinicModel::where('applicationno', 'like', "%{$applicationNo}%")
                        ->where('status',1)
                        ->when(session('user_type') == 5, function ($query) {
                                $query->where('state', Session::get('state_name'));
                            })
                        ->orderBy('id', 'desc')
                        ->first();

                if ($app) {
                    $directors  = SurrogacyClinicDirectorModel::where('userid', $app->userid)->get();
                    $equipments = SurrogacyClinicEquipmentModel::where('userid', $app->userid)->get();
                    $staff      = SurrogacyClinicOtherStaffModel::where('userid', $app->userid)->get();
                    $docfilecertificate = DocFileRegistrationCertificateUpload::where('userid',$app->userid)->where('app_id',$app->id)->get();
                    $DocFilereceivedUpload = DocFilereceivedUpload::where('userid',$app->userid)->where('app_id',$app->id)->get();
                    $clinic_id= ClinicRegistrationModel:: where('userid_applicant',$app->userid)
                            ->where('clinic_type','ARTSURROGACY')
                            ->when(session('user_type') == 5, function ($query) {
                                        $query->where('state', Session::get('state_name'));
                                    })
                            ->pluck('clinic_id');
                        // dd([
                //     'docfile  certificate'    => $docfilecertificate,
                //     'DocFilereceivedUpload' => $DocFilereceivedUpload,
                //     'clinicID' =>$clinic_id,
                // ]);
                }
                break;

            default:
                return redirect()->route('admin.view_applications')->with('error', 'Invalid clinic type selected.');
        }

        if (!$app) {
            return redirect()->route('admin.view_applications')->with('error', "No results found for Clinic type '{$clinicType}' and application number '{$applicationNo}'.");
        }


        // dd([
        //     'application' => $app,
        //     'directors'   => $directors ?? [],
        //     'equipments'  => $equipments ?? [],
        //     'staff'       => $staff ?? [],
        //     'status'      => $status,
        // ]);


        // Prepare application folder relative to public
        // $applicationFolderFeerecipt = 'webprodfiles/application_sa/' . str_replace('/', '_', $app->applicationno);


        $application_no_folder= str_replace('/', '_', $app->applicationno);
        $foldername = 'application_sa';
        $baseDir = folderpath($foldername);
        $fullFolderPath = $baseDir . $application_no_folder;

        $clinicIdFolder = $clinic_id->first(); // 11
        // dd($clinicIdFolder);
        // $applicationFolderCertificate = 'webprodfiles/clinic_registration_certificate/' . $clinicIdFolder;
        $FolderCertificate = 'clinic_registration_certificate';
        $certificateDir = folderpath($FolderCertificate);
        $fullCertificatePath = $certificateDir . '/' . $clinicIdFolder;
        

        if (!empty($DocFilereceivedUpload) && $DocFilereceivedUpload->isNotEmpty()) {
            $DocFilereceivedUpload = $DocFilereceivedUpload->map(function ($item) use ($fullFolderPath) {
                // Use basename in case the DB has full paths
                $item->file_url = !empty($item->doc_upload_ref) ? asset($fullFolderPath . '/' . basename($item->doc_upload_ref)) : null;
                return $item;
            });
        } else {
            // Handle the case when no files exist in the DB
            $DocFilereceivedUpload = collect(); // Return an empty collection to avoid errors in views
        }


        // // for certificate

        // Map certificate files
        if (!empty($docfilecertificate)) {
            $docfilecertificate = $docfilecertificate->map(function($item) use ($fullCertificatePath) {
                $item->file_url = !empty($item->doc_upload_ref)
                    ? asset($fullCertificatePath . '/' . basename($item->doc_upload_ref))
                    : null;
                return $item;
            });
        }



        $data = compact('app', 'directors', 'staff', 'equipments', 'status', 'clinicType', 'applicationNo','docfilecertificate','DocFilereceivedUpload','clinic_id');

        //If "download" flag true → return PDF
        // ---- PDF Download ----
        if ($download) {
            // Render full HTML from the Blade
            $html = view('layouts.admin.archive_view_application', $data)->render();

            // Extract all tables
            preg_match_all('/<table.*?>.*?<\/table>/is', $html, $matches);

            // Combine tables
            $tableContent = implode('<div style="page-break-after:always;"></div>', $matches[0] ?? []);

            // Add CSS + structure
            $styledHtml = "
                <html>
                <head>
                    <style>
                body { font-family: DejaVu Sans, sans-serif; font-size: 11px; line-height: 1.4; }
                h2 { text-align: center; margin-bottom: 20px; }
                table {
                    width: 100%;
                    border: 2px solid black; /* Outer table border */
                    border-collapse: collapse; /* Merge borders */
                    border-spacing: 0; /* Ensure no gaps */
                    margin-bottom: 25px;
                }
                th, td {
                    border: 1px solid black; /* All sides visible */
                    padding: 5px;
                    text-align: left;
                }
                th[colspan], td[colspan] {
                    border: 1px solid black; /* Ensure colspan cells have borders */
                }
                th { background-color: #eaeaea; }
                .page-break { page-break-after: always; }
            </style>
                </head>
                <body>
                    <h2>Application Report – {$clinicType}</h2>
                    <p><strong>Application No:</strong> {$applicationNo}</p>
                    <br>
                    {$tableContent}
                </body>
                </html>
            ";
            
            $applicationNoSafe = str_replace(['/', '\\'], '_', $applicationNo);
            $filename = "application_{$clinicType}_{$applicationNoSafe}.pdf";

            $pdf = Pdf::loadHTML($styledHtml)->setPaper('a4', 'landscape');

            // Force download
            return $pdf->stream($filename);
        }

        // Normal return (view in browser)
        return view('layouts.admin.archive_view_application', $data);
    }

    public function index()
    {
        return view('layouts.admin.surrogacy_details');
    }


    public function surrogacy_request(Request $request)
    {
    $userId = Session::get('userid');
    $service_id = 5;
    $Level_id = 1;
    // dd($userId);
    if ($userId) {
        $surrogacy_detail_data = DB::table('archive_table')
            ->leftJoin('work_flow_table', 'work_flow_table.application_id', '=', 'archive_table.archive_id')
            ->select(
                'archive_table.*','work_flow_table.*'
            )
            ->where('work_flow_table.service_id', $service_id)
            // ->where('work_flow_table.level_id', '=',$Level_id)
            ->where('work_flow_table.user_id', '=',$userId)
            ->where('archive_table.archive_status', '=',1)
            ->where('work_flow_table.is_active', 'YES')
            ->where('archive_table.type_of_clinic', '=','art_surrogacy')
            ->get();
            $art_detail_data = DB::table('archive_table')
            ->leftJoin('work_flow_table', 'work_flow_table.application_id', '=', 'archive_table.archive_id')
            ->select(
                'archive_table.*','work_flow_table.*'
            )
            ->where('work_flow_table.service_id', $service_id)
            ->where('work_flow_table.user_id', '=',$userId)
            ->where('archive_table.archive_status', '=',1)
            ->where('work_flow_table.is_active', 'YES')
            ->where('archive_table.type_of_clinic', '=','art_clinic')
            ->get();

            // dd($art_detail_data);
            $bank_detail_data = DB::table('archive_table')
            ->leftJoin('work_flow_table', 'work_flow_table.application_id', '=', 'archive_table.archive_id')
            ->select(
                'archive_table.*','work_flow_table.*'
            )
            ->where('work_flow_table.service_id', $service_id)
            ->where('work_flow_table.user_id', '=',$userId)
            ->where('archive_table.archive_status', '=',1)
            ->where('work_flow_table.is_active', 'YES')
            ->where('archive_table.type_of_clinic', '=','art_bank')
            ->get();

    //dd($surrogacy_detail_data); // Debugging output
    } 
        return view('layouts.admin.surrogacy_request', compact('surrogacy_detail_data','art_detail_data','bank_detail_data'));

        return view('layouts.admin.surrogacy_request', compact('surrogacy_detail_data'));
    }
    public function unsurrogacy_request(Request $request)
    {
    $userId = Session::get('userid');
    $service_id=5;
    $Level_id = 3;
     // dd($userId);
    if (!empty($userId)) {
        
        $surrogacy_detail_data = DB::table('archive_table')
        ->leftJoin('work_flow_table', 'work_flow_table.application_id', '=', 'archive_table.archive_id')
        ->select(
            'archive_table.*','work_flow_table.*'
        )
        ->where('work_flow_table.service_id', $service_id)
        ->where('work_flow_table.level_id', '=',$Level_id)
        ->where('archive_table.archive_status', '=',3)
        ->where('work_flow_table.is_active', 'YES')
        ->where('archive_table.type_of_clinic', '=','art_surrogacy')
        ->get();

        $art_detail_data = DB::table('archive_table')
        ->leftJoin('work_flow_table', 'work_flow_table.application_id', '=', 'archive_table.archive_id')
        ->select(
            'archive_table.*','work_flow_table.*'
        )
        ->where('work_flow_table.service_id', $service_id)
        ->where('work_flow_table.level_id', '=',$Level_id)
        ->where('archive_table.archive_status', '=',3)
        ->where('work_flow_table.is_active', 'YES')
        ->where('archive_table.type_of_clinic', '=','art_clinic')
        ->get();


        $bank_detail_data = DB::table('archive_table')
        ->leftJoin('work_flow_table', 'work_flow_table.application_id', '=', 'archive_table.archive_id')
        ->select(
            'archive_table.*','work_flow_table.*'
        )
        ->where('work_flow_table.service_id', $service_id)
        ->where('work_flow_table.level_id', '=',$Level_id)
        ->where('archive_table.archive_status', '=',3)
        ->where('work_flow_table.is_active', 'YES')
        ->where('archive_table.type_of_clinic', '=','art_bank')
        ->get();

    } 
        return view('layouts.admin.unsurrogacy_request', compact('surrogacy_detail_data','art_detail_data','bank_detail_data'));
    }

public function list_archive(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $clinicType = $request->input('clinic_type');

    // Current date to compare against future dates
    $today = now()->format('Y-m-d');

    // Validation for future dates
    if (($startDate && $startDate > $today) || ($endDate && $endDate > $today)) {
        return response()->json(['error' => 'Date range cannot include future dates.'], 400);
    }

    // Validation for date range exceeding 6 months
    if ($startDate && $endDate) {
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);

        if ($start->diffInMonths($end) > 6) {
            return response()->json(['error' => 'Date range should not exceed 6 months.'], 400);
        }
    }

    $combinedList = DB::table('archive_table as a')
        ->join(
        DB::raw('(SELECT application_no, MAX(id) as max_id 
                  FROM archive_table 
                  GROUP BY application_no) as latest'),
        function ($join) {
            $join->on('a.application_no', '=', 'latest.application_no')
                 ->on('a.id', '=', 'latest.max_id');
        }
        )
        ->when(!empty($clinicType), function ($query) use ($clinicType) {
            return $query->where('type_of_clinic', $clinicType);
        })
        ->whereIn('archive_status', [2, 3])       
        ->when($startDate && !$endDate, function ($query) use ($startDate) {
            return $query->whereDate('created_at', '>=', $startDate);
        })
        ->when(!$startDate && $endDate, function ($query) use ($endDate) {
            return $query->whereDate('created_at', '<=', $endDate);
        })
        ->select('a.*')
        ->get();
  //  dd($combinedList);
    if (!empty($clinicType)) {
        return response()->json($combinedList);
    }

    return view('layouts.admin.list_archive');
}
public function ssa_archived_apps_list(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $clinicType = $request->input('clinic_type');

    // Current date to compare against future dates
    $today = now()->format('Y-m-d');

    // Validation for future dates
    if (($startDate && $startDate > $today) || ($endDate && $endDate > $today)) {
        return response()->json(['error' => 'Date range cannot include future dates.'], 400);
    }

    // Validation for date range exceeding 6 months
    if ($startDate && $endDate) {
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);

        if ($start->diffInMonths($end) > 6) {
            return response()->json(['error' => 'Date range should not exceed 6 months.'], 400);
        }
    }
    // dd(Session::all());
    $stateName = User::find(Session::get('id'))->state->state_name;
    // dd($stateName);
    $combinedList = DB::table('archive_table as a')
        ->join(
        DB::raw('(SELECT application_no, MAX(id) as max_id 
                  FROM archive_table 
                  GROUP BY application_no) as latest'),
        function ($join) {
            $join->on('a.application_no', '=', 'latest.application_no')
                 ->on('a.id', '=', 'latest.max_id');
        }
        )
        ->when(!empty($clinicType), function ($query) use ($clinicType) {
            return $query->where('type_of_clinic', $clinicType);
        })
        ->whereIn('archive_status', [2, 3])       
        ->when($startDate && !$endDate, function ($query) use ($startDate) {
            return $query->whereDate('created_at', '>=', $startDate);
        })
        ->when(!$startDate && $endDate, function ($query) use ($endDate) {
            return $query->whereDate('created_at', '<=', $endDate);
        })
        ->when(!empty($stateName), function ($query) use ($stateName) {
        return $query->where('a.state', $stateName);
        })
        ->select('a.*')
        ->get();
  //  dd($combinedList);
    if (!empty($clinicType)) {
        return response()->json($combinedList);
    }

    return view('layouts.admin.archived_apps');
}

    public function surrogacy_remark(Request $request)
    {
      $userId = session('userid');        
      $remarksArray = $request->post('remarks');
      $surrogacy = $request->input('surrogacy');
      $level_action=2;
      $service_id=5;
       //  dd($surrogacy);  
        if($surrogacy == "art_surrogacy"){
          //  dd('s');
            $workflow_input = $request->input('work_flows'); // this will be an array of selected IDs
            $workflow_data = WorkFlowTable::whereIn('id', $workflow_input)->get(); 
            // Check if "Reject" button is clicked
            $isReject = $request->has('Reject');   
          //  dd($isReject);
          if ($workflow_data->isNotEmpty()) {   
          foreach ($workflow_data as $value) {
              $applicationId = $value->id;
              $remark = $remarksArray[$applicationId] ?? 'No Remark';
              if ($isReject) {
                  // Insert a reject record in workflow table
                  $rejectWorkflow = new WorkFlowTable();
                  $rejectWorkflow->application_id = $value->application_id;
                  $rejectWorkflow->service_id = $value->service_id;
                  $rejectWorkflow->level_id = 3;
                  $rejectWorkflow->user_id = $userId;
                  $rejectWorkflow->remarks = $remark;
                  $rejectWorkflow->is_active = 'NO'; // mark as inactive if rejected
                  $rejectWorkflow->action_taken_by = "Archive Rejected";
                  $rejectWorkflow->submission_date = Carbon::now()->format('Y-m-d H:i:s');

                  DB::table('work_flow_table')
                  ->where('application_id', $value->application_id)
                  ->update(['is_active' => 'NO']);



                  $rejectWorkflow->save();
      
                  // Update archive_table with archive_status = 0
                  DB::table('archive_table')
                    ->where('archive_id', $value->application_id)
                    ->orderByDesc('id')
                    ->limit(1)
                    ->update(['archive_status' => 0]);
      
      
                  // Check in surrogacyclinic
                  if (DB::table('surrogacyclinic')->where('id', $value->application_id)->exists()) {
                      DB::table('surrogacyclinic')
                          ->where('id', $value->application_id)
                          ->update(['archive_status' => 0]);
                  }
              } else {
      
      
              $addWorkflow = new WorkFlowTable();
              $addWorkflow->application_id = $value->application_id;
              $addWorkflow->service_id = $value->service_id;
              $addWorkflow->level_id = 2;
              // $addWorkflow->level_id = $value->level_id;
              $addWorkflow->user_id = nextActor($level_action,$userId,$service_id);
             // $addWorkflow->remarks = $singleRemark; // save one remark at a time
              $addWorkflow->remarks = $remark;
              $addWorkflow->is_active = 'NO';
              $addWorkflow->action_taken_by = "Archive Approved"; // what action taken it is not action_taken_by i.e. name is misleading
              $addWorkflow->submission_date = Carbon::now()->format('Y-m-d H:i:s');   
              
              DB::table('work_flow_table')
                  ->where('application_id', $value->application_id)
                  ->update(['is_active' => 'NO']);
      
      
              $addWorkflow->save();
                DB::table('archive_table')
                    ->where('archive_id', $value->application_id)
                    ->orderByDesc('id')
                    ->limit(1)
                    ->update(['archive_status' => 2]);
      
      
              $type=$addWorkflow->application_id;
              if ($type) {
                  DB::table('surrogacyclinic')
                      ->where('id', $value->application_id)
                      ->update(['archive_status' => 2]);
                  }
          }
          
          }    
        }       $message = $isReject ? 'Archive request rejected' : 'Archive request approved';
              return back()->with('success', $message);
        }

        if($surrogacy == "art_clinic"){
            //dd('clinic');
            $workflow_input = $request->input('work_flows'); // this will be an array of selected IDs
            $workflow_data = WorkFlowTable::whereIn('id', $workflow_input)->get(); 
            // Check if "Reject" button is clicked
            $isReject = $request->has('Reject');   
          //  dd($isReject);
          if ($workflow_data->isNotEmpty()) {   
          foreach ($workflow_data as $value) {
              $applicationId = $value->id;
              $remark = $remarksArray[$applicationId] ?? 'No Remark';
      
              if ($isReject) {
      
                  // Insert a reject record in workflow table
                  $rejectWorkflow = new WorkFlowTable();
                  $rejectWorkflow->application_id = $value->application_id;
                  $rejectWorkflow->service_id = $value->service_id;
                  $rejectWorkflow->level_id = 3;
                  $rejectWorkflow->user_id = $userId;
                  $rejectWorkflow->remarks = $remark;
                  $rejectWorkflow->is_active = 'NO'; // mark as inactive if rejected
                  $rejectWorkflow->action_taken_by = "Archive Rejected";
                  $rejectWorkflow->submission_date = Carbon::now()->format('Y-m-d H:i:s');

                  DB::table('work_flow_table')
                  ->where('application_id', $value->application_id)
                  ->update(['is_active' => 'NO']);


                  $rejectWorkflow->save();
      
                  // Update archive_table with archive_status = 0
                  DB::table('archive_table')
                    ->where('archive_id', $value->application_id)
                    ->orderByDesc('id')
                    ->limit(1)
                    ->update(['archive_status' => 0]);

                  // Check in artclinic
                  if (DB::table('artclinic')->where('id', $value->application_id)->exists()) {
                      DB::table('artclinic')
                          ->where('id', $value->application_id)
                          ->update(['archive_status' => 0]);
                  }
              } else {
      
      
              $addWorkflow = new WorkFlowTable();
              $addWorkflow->application_id = $value->application_id;
              $addWorkflow->service_id = $value->service_id;
              $addWorkflow->level_id = 2;
              // $addWorkflow->level_id = $value->level_id;
              $addWorkflow->user_id = nextActor($level_action,$userId,$service_id);
             // $addWorkflow->remarks = $singleRemark; // save one remark at a time
              $addWorkflow->remarks = $remark;
              $addWorkflow->is_active = 'NO';
              $addWorkflow->action_taken_by = "Archive Approved";
              $addWorkflow->submission_date = Carbon::now()->format('Y-m-d H:i:s');   
              
              DB::table('work_flow_table')
                  ->where('application_id', $value->application_id)
                  ->update(['is_active' => 'NO']);
      
      
              $addWorkflow->save();
            DB::table('archive_table')
                ->where('archive_id', $value->application_id)
                ->orderByDesc('id')
                ->limit(1)
                ->update(['archive_status' => 2]);
      
      
              $type=$addWorkflow->application_id;
                  if ($type) {
                  DB::table('artclinic')
                      ->where('id', $value->application_id)
                      ->update(['archive_status' => 2]);
                  }
          }
          
          }    
      }       $message = $isReject ? 'Archive request rejected' : 'Archive request approved';
              return back()->with('success', $message);
        }
        if($surrogacy == "art_bank"){
            $workflow_input = $request->input('work_flows'); // this will be an array of selected IDs
            $workflow_data = WorkFlowTable::whereIn('id', $workflow_input)->get(); 
            // Check if "Reject" button is clicked
            $isReject = $request->has('Reject');   
          //  dd($isReject);
          if ($workflow_data->isNotEmpty()) {   
          foreach ($workflow_data as $value) {
              $applicationId = $value->id;
              $remark = $remarksArray[$applicationId] ?? 'No Remark';
      
              if ($isReject) {
      
                  // Insert a reject record in workflow table
                  $rejectWorkflow = new WorkFlowTable();
                  $rejectWorkflow->application_id = $value->application_id;
                  $rejectWorkflow->service_id = $value->service_id;
                  $rejectWorkflow->level_id = 3;
                  $rejectWorkflow->user_id = $userId;
                  $rejectWorkflow->remarks = $remark;
                  $rejectWorkflow->is_active = 'NO'; // mark as inactive if rejected
                  $rejectWorkflow->action_taken_by = "Archive Rejected";
                  $rejectWorkflow->submission_date = Carbon::now()->format('Y-m-d H:i:s');
                  DB::table('work_flow_table')
                  ->where('application_id', $value->application_id)
                  ->update(['is_active' => 'NO']);
                  $rejectWorkflow->save();
      
                  // Update archive_table with archive_status = 0
                  DB::table('archive_table')
                    ->where('archive_id', $value->application_id)
                    ->orderByDesc('id')
                    ->limit(1)
                    ->update(['archive_status' => 0]);
                  // Check in artbank
                  if (DB::table('artbank')->where('id', $value->application_id)->exists()) {
                      DB::table('artbank')
                          ->where('id', $value->application_id)
                          ->update(['archive_status' => 0]);
                  }
              } else {
              $addWorkflow = new WorkFlowTable();
              $addWorkflow->application_id = $value->application_id;
              $addWorkflow->service_id = $value->service_id;
              $addWorkflow->level_id = 2;
              // $addWorkflow->level_id = $value->level_id;
              $addWorkflow->user_id = nextActor($level_action,$userId,$service_id);
             // $addWorkflow->remarks = $singleRemark; // save one remark at a time
              $addWorkflow->remarks = $remark;
              $addWorkflow->is_active = 'NO';
              $addWorkflow->action_taken_by = "Archive Approved";
              $addWorkflow->submission_date = Carbon::now()->format('Y-m-d H:i:s');   
              
              DB::table('work_flow_table')
                  ->where('application_id', $value->application_id)
                  ->update(['is_active' => 'NO']);
      
      
              $addWorkflow->save();
                DB::table('archive_table')
                    ->where('archive_id', $value->application_id)
                    ->orderByDesc('id')
                    ->limit(1)
                    ->update(['archive_status' => 2]);
      
      
              $type=$addWorkflow->application_id;
                  if ($type) {
                      DB::table('artbank')
                          ->where('id', $value->application_id)
                          ->update(['archive_status' => 2]);
                      }
          }
          
          }    
      }       $message = $isReject ? 'Archive request rejected' : 'Archive request approved';
              return back()->with('success', $message);
        }
    }

    public function unsurrogacy_remark(Request $request)
    {
        $userId = session('userid');        
      $remarksArray = $request->post('remarks');
      $surrogacy = $request->input('surrogacy');
      $level_action = 4;
      $service_id = 5;
       //  dd($surrogacy);
        if($surrogacy == "art_surrogacy"){
          //  dd('s');
           
            $workflow_input = $request->input('work_flows'); // this will be an array of selected IDs
            $workflow_data = WorkFlowTable::whereIn('id', $workflow_input)->get(); 
            // Check if "Reject" button is clicked
            $isReject = $request->has('Reject');   
          //  dd($isReject);
          if ($workflow_data->isNotEmpty()) {   
          foreach ($workflow_data as $value) {
              $applicationId = $value->id;
              $remark = $remarksArray[$applicationId] ?? 'No Remark';
      
              if ($isReject) {
      
                  // Insert a reject record in workflow table
                  $rejectWorkflow = new WorkFlowTable();
                  $rejectWorkflow->application_id = $value->application_id;
                  $rejectWorkflow->service_id = $value->service_id;
                  $rejectWorkflow->level_id = 4;
                  $rejectWorkflow->user_id = $userId;
                  $rejectWorkflow->remarks = $remark;
                  $rejectWorkflow->is_active = 'NO'; // mark as inactive if rejected
                  $rejectWorkflow->action_taken_by = "UnArchive Rejected";
                  $rejectWorkflow->submission_date = Carbon::now()->format('Y-m-d H:i:s');

                  DB::table('work_flow_table')
                  ->where('application_id', $value->application_id)
                  ->update(['is_active' => 'NO']);



                  $rejectWorkflow->save();
      
                  // Update archive_table with archive_status = 0
                  DB::table('archive_table')
                    ->where('archive_id', $value->application_id)
                    ->orderByDesc('id')
                    ->limit(1)
                    ->update(['archive_status' => 2]);
      
      
                  // Check in surrogacyclinic
                  if (DB::table('surrogacyclinic')->where('id', $value->application_id)->exists()) {
                      DB::table('surrogacyclinic')
                          ->where('id', $value->application_id)
                          ->update(['archive_status' => 2]);
                  }
              } else {
      
      
              $addWorkflow = new WorkFlowTable();
              $addWorkflow->application_id = $value->application_id;
              $addWorkflow->service_id = $value->service_id;
              $addWorkflow->level_id = 4;
              // $addWorkflow->level_id = $value->level_id;
              $addWorkflow->user_id = nextActor($level_action,$userId,$service_id);
             // $addWorkflow->remarks = $singleRemark; // save one remark at a time
              $addWorkflow->remarks = $remark;
              $addWorkflow->is_active = 'NO';
              $addWorkflow->action_taken_by = "UnArchive Approved";
              $addWorkflow->submission_date = Carbon::now()->format('Y-m-d H:i:s');   
              
              DB::table('work_flow_table')
                  ->where('application_id', $value->application_id)
                  ->update(['is_active' => 'NO']);
      
      
              $addWorkflow->save();
            DB::table('archive_table')
            ->where('archive_id', $value->application_id)
            ->orderByDesc('id')
            ->limit(1)
            ->update(['archive_status' => 0]);
      
      
              $type=$addWorkflow->application_id;
      
      
              if ($type) {
                  DB::table('surrogacyclinic')
                      ->where('id', $value->application_id)
                      ->update(['archive_status' => 0]);
                  }
          }
          
          }    
      }       $message = $isReject ? 'Unarchive request rejected' : 'Unarchive request approved';
              return back()->with('success', $message);
        }

        if($surrogacy == "art_clinic"){
            //dd('clinic');
            $workflow_input = $request->input('work_flows'); // this will be an array of selected IDs
            $workflow_data = WorkFlowTable::whereIn('id', $workflow_input)->get(); 
            // Check if "Reject" button is clicked
            $isReject = $request->has('Reject');   
          //  dd($isReject);
          if ($workflow_data->isNotEmpty()) {   
          foreach ($workflow_data as $value) {
              $applicationId = $value->id;
              $remark = $remarksArray[$applicationId] ?? 'No Remark';
      
              if ($isReject) {
      
                  // Insert a reject record in workflow table
                  $rejectWorkflow = new WorkFlowTable();
                  $rejectWorkflow->application_id = $value->application_id;
                  $rejectWorkflow->service_id = $value->service_id;
                  $rejectWorkflow->level_id = 4;
                  $rejectWorkflow->user_id = $userId;
                  $rejectWorkflow->remarks = $remark;
                  $rejectWorkflow->is_active = 'NO'; // mark as inactive if rejected
                  $rejectWorkflow->action_taken_by = "UnArchive Rejected";
                  $rejectWorkflow->submission_date = Carbon::now()->format('Y-m-d H:i:s');

                  DB::table('work_flow_table')
                  ->where('application_id', $value->application_id)
                  ->update(['is_active' => 'NO']);


                  $rejectWorkflow->save();
      
                  // Update archive_table with archive_status = 0
                  DB::table('archive_table')
                    ->where('archive_id', $value->application_id)
                    ->orderByDesc('id')
                    ->limit(1)
                    ->update(['archive_status' => 2]);

                  // Check in artclinic
                  if (DB::table('artclinic')->where('id', $value->application_id)->exists()) {
                      DB::table('artclinic')
                          ->where('id', $value->application_id)
                          ->update(['archive_status' => 2]);
                  }
      

              } else {
      
      
              $addWorkflow = new WorkFlowTable();
              $addWorkflow->application_id = $value->application_id;
              $addWorkflow->service_id = $value->service_id;
              $addWorkflow->level_id = 4;
              // $addWorkflow->level_id = $value->level_id;
              $addWorkflow->user_id = nextActor($level_action,$userId,$service_id);
             // $addWorkflow->remarks = $singleRemark; // save one remark at a time
              $addWorkflow->remarks = $remark;
              $addWorkflow->is_active = 'NO';
              $addWorkflow->action_taken_by = "UnArchive Approved";
              $addWorkflow->submission_date = Carbon::now()->format('Y-m-d H:i:s');   
              
              DB::table('work_flow_table')
                  ->where('application_id', $value->application_id)
                  ->update(['is_active' => 'NO']);
      
      
              DB::table('archive_table')
                ->where('archive_id', $value->application_id)
                ->orderByDesc('id')
                ->limit(1)
                ->update(['archive_status' => 0]);
      
      
              $type=$addWorkflow->application_id;

                  if ($type) {
                  DB::table('artclinic')
                      ->where('id', $value->application_id)
                      ->update(['archive_status' => 0]);
                  }

          }
          
          }    
      }       $message = $isReject ? 'Unarchive request rejected' : 'Unarchive request approved';
              return back()->with('success', $message);
        }
        if($surrogacy == "art_bank"){
            $workflow_input = $request->input('work_flows'); // this will be an array of selected IDs
            $workflow_data = WorkFlowTable::whereIn('id', $workflow_input)->get(); 
            // Check if "Reject" button is clicked
            $isReject = $request->has('Reject');   
          //  dd($isReject);
          if ($workflow_data->isNotEmpty()) {   
          foreach ($workflow_data as $value) {
              $applicationId = $value->id;
              $remark = $remarksArray[$applicationId] ?? 'No Remark';
      
              if ($isReject) {
      
                  // Insert a reject record in workflow table
                  $rejectWorkflow = new WorkFlowTable();
                  $rejectWorkflow->application_id = $value->application_id;
                  $rejectWorkflow->service_id = $value->service_id;
                  $rejectWorkflow->level_id = 4;
                  $rejectWorkflow->user_id = $userId;
                  $rejectWorkflow->remarks = $remark;
                  $rejectWorkflow->is_active = 'NO'; // mark as inactive if rejected
                  $rejectWorkflow->action_taken_by = "UnArchive Rejected";
                  $rejectWorkflow->submission_date = Carbon::now()->format('Y-m-d H:i:s');
                  DB::table('work_flow_table')
                  ->where('application_id', $value->application_id)
                  ->update(['is_active' => 'NO']);
                  $rejectWorkflow->save();
      
                  // Update archive_table with archive_status = 0
                  DB::table('archive_table')
                    ->where('archive_id', $value->application_id)
                    ->orderByDesc('id')
                    ->limit(1)
                    ->update(['archive_status' => 2]);
      

                  // Check in artbank
                  if (DB::table('artbank')->where('id', $value->application_id)->exists()) {
                      DB::table('artbank')
                          ->where('id', $value->application_id)
                          ->update(['archive_status' => 2]);
                  }
              } else {
      
      
              $addWorkflow = new WorkFlowTable();
              $addWorkflow->application_id = $value->application_id;
              $addWorkflow->service_id = $value->service_id;
              $addWorkflow->level_id = 4;
              // $addWorkflow->level_id = $value->level_id;
              $addWorkflow->user_id = nextActor($level_action,$userId,$service_id);
             // $addWorkflow->remarks = $singleRemark; // save one remark at a time
              $addWorkflow->remarks = $remark;
              $addWorkflow->is_active = 'NO';
              $addWorkflow->action_taken_by = "UnArchive Approved";
              $addWorkflow->submission_date = Carbon::now()->format('Y-m-d H:i:s');   
              
              DB::table('work_flow_table')
                  ->where('application_id', $value->application_id)
                  ->update(['is_active' => 'NO']);
      
      
              DB::table('archive_table')
                ->where('archive_id', $value->application_id)
                ->orderByDesc('id')
                ->limit(1)
                ->update(['archive_status' => 0]);
      
      
              $type=$addWorkflow->application_id;
      
                  if ($type) {
                      DB::table('artbank')
                          ->where('id', $value->application_id)
                          ->update(['archive_status' => 0]);
                      }
          }
          
          }    
      }       $message = $isReject ? 'Unarchive request rejected' : 'Unarchive request approved';
              return back()->with('success', $message);
        }
    }

    public function fetchApplications(Request $request)
    
    {
        
        // Debug: Show received request data
        $requestData = $request->all();
       
        if (empty($requestData)) {
            return response()->json(['error' => 'No data received'], 400);
        }    
        $query = $request->input('q');
        $selected_type = $request->input('selected_type');     
        if (!$query) {
            return response()->json(['error' => 'Missing application type'], 400);
        }
        if (!empty($query)) {
            $applications = collect(); // Initialize as an empty collection to avoid undefined errors
        
            if ($selected_type == 'art_clinic') {
                $applications = DB::table('clinic_applicationno')
                ->join('artclinic', function($join) {
                    $join->on('clinic_applicationno.clinic_id', '=', 'artclinic.id')
                        ->where('artclinic.status', 1)
                        ->where('artclinic.appstatus','Pending');
                })             
                ->join('signup', 'artclinic.userid', '=', 'signup.id') // Join with signup
                ->where('clinic_applicationno.applicationno', 'LIKE', "%{$query}%")
                ->orWhere('signup.clinicname', 'LIKE', "%{$query}%")
                ->select('clinic_applicationno.id', 'clinic_applicationno.applicationno', 'signup.clinicname')
                ->get();
               

                 //   ->where('applicationno', 'LIKE', "%{$query}%")
             //       ->get();
                  //  dd($applications);
            } elseif ($selected_type == 'art_bank') {
                $applications = DB::table('bank_applicationno')
                ->join('artbank', function($join) {
                    $join->on('bank_applicationno.bank_id', '=', 'artbank.id')
                        ->where('artbank.status', 1)
                        ->where('artbank.appstatus','Pending');
                }) 
                ->join('signup', 'artbank.userid', '=', 'signup.id') // Join with signup
                ->where('bank_applicationno.applicationno', 'LIKE', "%{$query}%")
                ->orWhere('signup.clinicname', 'LIKE', "%{$query}%")
                ->select('bank_applicationno.id', 'bank_applicationno.applicationno', 'signup.clinicname')
                ->get();
                 //     ->where('applicationno', 'LIKE', "%{$query}%")
                   // ->get();
            } elseif ($selected_type == 'art_surrogacy') { // Fixed this condition
                $applications = DB::table('s_applicationno')
                ->join('surrogacyclinic', function($join) {
                    $join->on('s_applicationno.surrogacy_id', '=', 'surrogacyclinic.id')
                        ->where('surrogacyclinic.status', 1)
                        ->where('surrogacyclinic.appstatus','Pending');
                })
                ->join('signup', 'surrogacyclinic.userid', '=', 'signup.id') // Join with signup
                ->where('s_applicationno.applicationno', 'LIKE', "%{$query}%")
                ->orWhere('signup.clinicname', 'LIKE', "%{$query}%")
                ->select('s_applicationno.id', 's_applicationno.applicationno', 'signup.clinicname')
                ->get();
               //   ->where('applicationno', 'LIKE', "%{$query}%")
                 //   ->get();
            }
        }
        
        return response()->json([
            'items' => $applications->map(function ($item) {
                return [
                    'id' => $item->id,
                    'applicationno' => $item->applicationno, // Adjust according to your database structure
                    'clinicname' => $item->clinicname // Include clinic name
                ];
            })
        ]);       
    }

    public function unfetchApplications(Request $request)
    {
        // Debug: Show received request data
        $requestData = $request->all();
        if (empty($requestData)) {
            return response()->json(['error' => 'No data received'], 400);
        }    
        $query = $request->input('q');
        $selected_type = $request->input('selected_type');     
        if (!$query) {
            return response()->json(['error' => 'Missing application type'], 400);
        }
        if (!empty($query)) {
            $applications = collect(); // Initialize as an empty collection to avoid undefined errors
        
            if ($selected_type == 'art_clinic') {
                $applications = DB::table('clinic_applicationno')
                ->join('artclinic', 'clinic_applicationno.clinic_id', '=', 'artclinic.id') // Correct join
                ->where('clinic_applicationno.applicationno', 'LIKE', "%{$query}%") // Search condition
                ->where('artclinic.archive_status', '=', 2) // Filter condition
                ->get();
                // $applications = DB::table('clinic_applicationno')
                //     ->where('applicationno', 'LIKE', "%{$query}%")
                //     ->where('applicationno', 'LIKE', "%{$query}%")
                //     ->get();
            } elseif ($selected_type == 'art_bank') {
                $applications = DB::table('bank_applicationno')
                ->join('artbank', 'bank_applicationno.bank_id', '=', 'artbank.id') // Correct join
                ->where('bank_applicationno.applicationno', 'LIKE', "%{$query}%") // Search condition
                ->where('artbank.archive_status', '=', 2) // Filter condition
                ->get();
                // $applications = DB::table('bank_applicationno')
                //     ->where('applicationno', 'LIKE', "%{$query}%")
                //     ->get();
            } elseif ($selected_type == 'art_surrogacy') { // Fixed this condition

                $applications = DB::table('s_applicationno')
                ->join('surrogacyclinic', 's_applicationno.surrogacy_id', '=', 'surrogacyclinic.id') // Correct join
                ->where('s_applicationno.applicationno', 'LIKE', "%{$query}%") // Search condition
                ->where('surrogacyclinic.archive_status', '=', 2) // Filter condition
                ->get();
                // $applications = DB::table('s_applicationno')
                //     ->where('applicationno', 'LIKE', "%{$query}%")
                //     ->get();
            }
        }
        
        return response()->json([
            'items' => $applications->map(function ($item) {
                return [
                    'id' => $item->id,
                    'applicationno' => $item->applicationno, // Adjust according to your database structure
                ];
            })
        ]);       
    }

    public function art_clinic()
    {

        return view('layouts.admin.art_clinic');
    }

    public function art_bank()
    {

        return view('layouts.admin.art_bank');
    }

    // public function archive_work($id)
    // {
    //     $results = DB::table('surrogacyclinic')
    //     ->select('archive_status','id')
    //     ->where('id', '=', $id)
    //     ->get();

    //    return view('layouts.admin.archive_workspace', ['data' => $results]);

    // }


    public function archive_work()
    {   $userId = Session::get('userid');
        $user = DB::table('user_table')->where('userid', $userId)->first();
         
        return view('layouts.admin.archive_workspace', compact('user'));
    }
    public function unarchive_work()
    {   $userId = Session::get('userid');
        $user = DB::table('user_table')->where('userid', $userId)->first();
         
        return view('layouts.admin.unarchive_workspace', compact('user'));
    }


    public function fetchArchive(Request $request)
    {
        //dd('dydy');
        
        $clinic_type = $request->input('radioButton');
        $searchApp = $request->input('searchApp');
        $Archive = new Archive(); 
        if ($clinic_type == 'art_clinic') {

            $fetch_data_archive_art_clinic = $Archive->fetch_data_archive_art_clinic($searchApp);
            return response()->json($fetch_data_archive_art_clinic);


        }elseif($clinic_type == 'art_bank') {
              //dd('dfsdfsd');
            $fetch_data_archive_art_bank = $Archive->fetch_data_archive_art_bank($searchApp);
            return response()->json($fetch_data_archive_art_bank);

        } else {

           // dd('hdh');
            $fetch_data_archive = $Archive->fetch_data_archive($searchApp);
           return response()->json($fetch_data_archive);
    
           
        }
    }
    public function unfetchArchive(Request $request)
    {
        
        $clinic_type = $request->input('radioButton');
        $searchApp = $request->input('searchApp');  
        
       // dd($request);
        $Archive = new Archive(); 

        if ($clinic_type == 'art_clinic') {

            $fetch_data_archive_art_clinic = $Archive->fetch_data_unarchive_art_clinic($searchApp);
            return response()->json($fetch_data_archive_art_clinic);


        }elseif($clinic_type == 'art_bank') {
              //dd('dfsdfsd');
            $fetch_data_archive_art_bank = $Archive->fetch_data_unarchive_art_bank($searchApp);
            return response()->json($fetch_data_archive_art_bank);

        } else {
           // dd('shsh');
            $fetch_data_unarchive = $Archive->fetch_data_unarchive($searchApp);
           return response()->json($fetch_data_unarchive);
    
           
        }
    }


    public function archive_work_request($id)
    {
        $results = DB::table('surrogacyarchive')
            ->select('archive_status', 'id')
            ->where('id', '=', $id)
            ->get();

        return view('layouts.admin.archive_workspace_request', ['data' => $results]);
    }
    public function add_archive(Request $request)
    {      
       // dd($request->all());  
        $request->validate([
                        'remarks'  => 'required',
                     //   'remarks_other' => 'nullable|required_if:remarks,Any Other'
            ]);
            
            $action_taken_by = 'Archive Request';
            $noctable        =  new Noctable();
            $service_id = 5;
            $level_action = 1;
            $userid = $request->userid;
            $username = $request->username;
           // dd($username);
            $archive_id = $request->archive_id;
            $is_active = "YES";
            $get_userid = nextActor($level_action, $userid, $service_id);
            try {
                DB::beginTransaction();  
                $archive_table = new ArchiveTable();
                $archive_table->application_no  = $request->application_no;
                $archive_table->archive_id  = $archive_id;
                $archive_table->userid  = $request->userid;
                $archive_table->clinicname  = $request->clinic_name;
                $archive_table->cliniclevel  = $request->clinic_level;
                $archive_table->address  = $request->address;
                $archive_table->pincode  = $request->pincode;
                $archive_table->state  = $request->state;
                $archive_table->district  = $request->district;
                $archive_table->email  = $request->email;               
                $archive_table->mobile  = $request->mobile_no;
                $archive_table->action_taken_by  = $request->action_taken_by;
                $archive_table->action_taken_id  = $request->action_taken_id;
                $archive_table->type_of_clinic  = $request->type_of_clinic;
                $archive_table->archive_id  = $request->archive_id;
                $arc_starus = $archive_table->archive_status  = 1;            
                $archive_table->save();    
                $type=$archive_table->type_of_clinic;
               if ($type == 'art_surrogacy') {
                DB::table('surrogacyclinic')
                ->where('userid', $userid)
                ->where('status',1)
                ->where('appstatus',"Pending")
                ->update([
                    'archive_status'   => $arc_starus,
                    'action_taken_by'  => $request->action_taken_by,
                    'action_taken_id'  => $request->action_taken_id,
                    'type_of_clinic'   => $request->type_of_clinic,
                ]);


            //    DB::table('surrogacyclinic')
            //         ->where('userid', $userid)
            //         ->update(['archive_status' => $arc_starus]);
               }
               if ($type == 'art_clinic') {
                DB::table('artclinic')
                ->where('userid', $userid)
                ->where('status',1)
                ->where('appstatus',"Pending")
                ->update([
                    'archive_status'   => $arc_starus,
                    'action_taken_by'  => $request->action_taken_by,
                    'action_taken_id'  => $request->action_taken_id,
                    'type_of_clinic'   => $request->type_of_clinic,
                ]);




                    //  ->where('userid', $userid)
                    //  ->update(['archive_status' => $arc_starus]);
                }
                if ($type == 'art_bank') {
                    DB::table('artbank')
                    ->where('userid', $userid)
                    ->where('status',1)
                    ->where('appstatus',"Pending")
                    ->update([
                        'archive_status'   => $arc_starus,
                        'action_taken_by'  => $request->action_taken_by,
                        'action_taken_id'  => $request->action_taken_id,
                        'type_of_clinic'   => $request->type_of_clinic,
                    ]);


                        //  ->where('userid', $userid)
                        //  ->update(['archive_status' => $arc_starus]);
                    }

//dd($check);

            //    $remarks_other = ($request->remarks === 'Any Other') ? $request->remarks_other : null;

                // Insert into 'work_flow_table'
                DB::table('work_flow_table')->insert([
                    'application_id'    => $request->archive_id,
                    'service_id'        => $service_id,
                    'level_id'          => $level_action,
                    'user_id'           => $get_userid,
                    'remarks'           => $request->remarks,
                 //   'remarks_other'     => $remarks_other,
                    'notesheet'         => 'Null',
                    'medical_report'    => 'Null',
                    'is_active'         => $is_active,
                    'action_taken_by'   => $action_taken_by,
                    'submission_date'   => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                DB::commit();

                return redirect()->route('admin.archive_work')->with('success', 'Archive request sent successfully!');
            } catch (\Exception $e) {
                DB::rollBack();  // Roll back the transaction if any operation fails
                // Log the exception or handle it as needed
                return response()->json(['error' => 'Transaction failed', 'message' => $e->getMessage()]);
            }
        } 

        public function add_unarchive(Request $request)
        {
                
           // dd($request->all());
            
            $request->validate([
                            'remarks'  => 'required'
                ]);
                
                $action_taken_by = 'Un Archive Request';
                $noctable        =  new Noctable();
                $service_id = 5;
                $level_action = 3;
                $userid = $request->userid;
              //  $username = $request->username;
               // dd($username);
                $archive_id = $request->archive_id;
    
                $is_active = "YES";
                $get_userid = nextActor($level_action, $userid, $service_id);   
    
                try {
                    DB::beginTransaction();  
                    $archive_table = new ArchiveTable();
                    $archive_table->application_no  = $request->application_no;
                    $archive_table->archive_id  = $archive_id;
                    $archive_table->userid  = $request->userid;
                    $archive_table->clinicname  = $request->clinic_name;
                    $archive_table->cliniclevel  = $request->clinic_level;
                    $archive_table->address  = $request->address;
                    $archive_table->pincode  = $request->pincode;
                    $archive_table->state  = $request->state;
                    $archive_table->district  = $request->district;
                    $archive_table->email  = $request->email;               
                    $archive_table->mobile  = $request->mobile_no;
                    $archive_table->action_taken_by  = $request->action_taken_by;
                    $archive_table->action_taken_id  = $request->action_taken_id;
                    $archive_table->type_of_clinic  = $request->type_of_clinic;
                    $archive_table->archive_id  = $request->archive_id;
                    $arc_starus = $archive_table->archive_status  = 3; 
                    

                  //  dd($request->application_no);
                    DB::table('archive_table')
                   ->where('application_no', $request->application_no)
                   ->update(['archive_status' => 2]);





                    $archive_table->save();  
                    $type=$archive_table->type_of_clinic;
                   if ($type == 'art_surrogacy') {
                   DB::table('surrogacyclinic')                  
                   ->where('userid', $userid)
                   ->update([
                       'archive_status'   => $arc_starus,
                       'action_taken_by'  => $request->action_taken_by,
                       'action_taken_id'  => $request->action_taken_id,
                       'type_of_clinic'   => $request->type_of_clinic,
                   ]);
                        // ->where('userid', $userid)
                        // ->update(['archive_status' => $arc_starus]);
                        
                   }
                   if ($type == 'art_clinic') {
                    DB::table('artclinic')                   
                    ->where('userid', $userid)
                    ->update([
                        'archive_status'   => $arc_starus,
                        'action_taken_by'  => $request->action_taken_by,
                        'action_taken_id'  => $request->action_taken_id,
                        'type_of_clinic'   => $request->type_of_clinic,
                    ]);
                        //  ->where('userid', $userid)
                        //  ->update(['archive_status' => $arc_starus]);
                    }
                    if ($type == 'art_bank') {
                        DB::table('artbank')
                       
                        ->where('userid', $userid)
                        ->update([
                            'archive_status'   => $arc_starus,
                            'action_taken_by'  => $request->action_taken_by,
                            'action_taken_id'  => $request->action_taken_id,
                            'type_of_clinic'   => $request->type_of_clinic,
                        ]);
                            //  ->where('userid', $userid)
                            //  ->update(['archive_status' => $arc_starus]);
                        }
        
                    // Insert into 'work_flow_table'
                    DB::table('work_flow_table')->insert([
                        'application_id'    => $request->archive_id,
                        'service_id'        => $service_id,
                        'level_id'          => $level_action,
                        'user_id'           => $get_userid,
                        'remarks'           => $request->remarks,
                        'notesheet'         => 'Null',
                        'medical_report'    => 'Null',
                        'is_active'         => $is_active,
                        'action_taken_by'   => $action_taken_by,
                        'submission_date'   => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
    
                    DB::commit();
    
                    return redirect()->route('admin.unarchive_work')->with('success', 'Uarchive request Sent successfully!');
                } catch (\Exception $e) {
                    DB::rollBack();  // Roll back the transaction if any operation fails
                    // Log the exception or handle it as needed
                    return response()->json(['error' => 'Transaction failed', 'message' => $e->getMessage()]);
                }
            } 

    public function add_archive_approve(Request $request)
    {

        if ($request->archive_status == 1) {
            $action_taken_by = 'Archive Approved';
            $get_id         = $request->id;
            // dd($get_id);

            $service_id = 5;
            $level_action = 2;


            $is_active = 'NO';
            $get_userid = nextActor($level_action, $get_id, $service_id);
            // dd($get_userid);



            try {
                DB::beginTransaction();  // Start the transaction

                // Insert data into the 'surrogacyarchive' table

                $surrogacyid = DB::table('surrogacyarchive')
                    ->where('id', $get_id)
                    ->value('surrogacyclinic_id');

                DB::table('surrogacyarchive')
                    ->where('id', $get_id)
                    ->update(['archive_status' => 2]);

                DB::table('surrogacyclinic')
                    ->where('id', $surrogacyid)
                    ->update(['archive_status' => 2]);


                DB::table('work_flow_table')
                    ->where('application_id', $surrogacyid)
                    ->where('service_id', 5)
                    ->where('is_active', 'YES')
                    ->update(['is_active' => 'NO']);



                // Update 'surrogacyclinic' table to set 'archive_status' to 1


                // Insert into 'work_flow_table'
                DB::table('work_flow_table')->insert([
                    'application_id'    => $surrogacyid,
                    'service_id'        => $service_id,
                    'level_id'          => $level_action,
                    'user_id'           => $get_userid,
                    'remarks'           => !empty($request->remarks) ? $request->remarks : 'Not Remarks',
                    'notesheet'         => '',
                    'medical_report'    => '',
                    'is_active'         => $is_active,
                    'action_taken_by'   => $action_taken_by,
                    'submission_date'   => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                DB::commit();

                return redirect()->route('admin.surrogacy_request')->with('success', 'Archive Approved has been Update successfully!');
            } catch (\Exception $e) {
                DB::rollBack();  // Roll back the transaction if any operation fails
                // Log the exception or handle it as needed
                return response()->json(['error' => 'Transaction failed', 'message' => $e->getMessage()]);
            }
        } else if ($request->archive_status == 3) {

            $action_taken_by = 'Un Archive Approved';
            $get_id         = $request->id;
            // dd($get_id);

            $service_id = 5;
            $level_action = 4;


            $is_active = 'NO';
            $get_userid = nextActor($level_action, $get_id, $service_id);
            //dd($get_userid);



            try {
                DB::beginTransaction();  // Start the transaction

                // Insert data into the 'surrogacyarchive' table

                $surrogacyid = DB::table('surrogacyarchive')
                    ->where('id', $get_id)
                    ->value('surrogacyclinic_id');

                DB::table('surrogacyarchive')
                    ->where('id', $get_id)
                    ->update(['archive_status' => 4]);

                DB::table('surrogacyclinic')
                    ->where('id', $surrogacyid)
                    ->update(['archive_status' => 4]);


                DB::table('work_flow_table')
                    ->where('application_id', $surrogacyid)
                    ->where('service_id', 5)
                    ->where('level_id', 3)
                    ->update(['is_active' => 'NO']);



                // Update 'surrogacyclinic' table to set 'archive_status' to 1


                // Insert into 'work_flow_table'
                DB::table('work_flow_table')->insert([
                    'application_id'    => $surrogacyid,
                    'service_id'        => $service_id,
                    'level_id'          => $level_action,
                    'user_id'           => $get_userid,
                    'remarks'           => !empty($request->remarks) ? $request->remarks : 'Not Remarks',
                    'notesheet'         => '',
                    'medical_report'    => '',
                    'is_active'         => $is_active,
                    'action_taken_by'   => $action_taken_by,
                    'submission_date'   => Carbon::now()->format('Y-m-d H:i:s')
                ]);

                DB::commit();

                return redirect()->route('admin.surrogacy_request')->with('success', 'Archive Approved has been Update successfully!');
            } catch (\Exception $e) {
                DB::rollBack();  // Roll back the transaction if any operation fails
                // Log the exception or handle it as needed
                return response()->json(['error' => 'Transaction failed', 'message' => $e->getMessage()]);
            }
        }
    }

    public function surrogacy_details_ajax(Request $request)
    {

        $search = $request->input('search');
        $start = $request->input('start', 0);  // Default to 0 if not set
        $length = $request->input('length', 10);


        $noctable = new Noctable();
        $surrsurrogacy_data = $noctable->view_surrsurrogacy($start, $length, $search);

        // $totalRecords =  $surrsurrogacy_data['total_records']; 

        $recordsTotal =  $surrsurrogacy_data['recordsTotal'];
        $recordsFiltered =  $surrsurrogacy_data['recordsFiltered'];
        //  dd($totalRecords);
        $result =  $surrsurrogacy_data['data'];

        //dd($result);

        return response()->json([
            'draw' => $request->input('draw'), // Draw counter
            'recordsTotal' => $recordsTotal, // Total records count
            'recordsFiltered' => $recordsTotal, // Total records count// Filtered records count
            'data' => $result, // Data for the table
        ]);
    }


    public function surrogacy_request_ajax(Request $request)
    {
        $search = $request->input('search');
        $start  = $request->input('start', 0);  
        $length = $request->input('length', 10);

        
        $noctable = new Noctable();
        $surrsurrogacy_data = $noctable->view_surrsurrogacy_request($start, $length, $search);
        $recordsTotal =  $surrsurrogacy_data['recordsTotal'];
        $recordsFiltered =  $surrsurrogacy_data['recordsFiltered'];
        $result =  $surrsurrogacy_data['data'];

  

        return response()->json([
            'draw' => $request->input('draw'), 
            'recordsTotal' => $recordsTotal, // Total records count
            'recordsFiltered' => $recordsTotal, // Total records count// Filtered records count
            'data' => $result, // Data for the table
        ]);
    }

    public function art_clinic_ajax(Request $request)
    {
        //dd('sdfsdfsdfsd');
        $search          =  $request->input('search');
        $start           =  $request->input('start', 0);  // Default to 0 if not set
        $length          =  $request->input('length', 10);
        $noctable        =  new Noctable();
        // dd('sfsdfsdf');
        $art_data        =  $noctable->view_art_clinic_ajax($start, $length, $search);

        $recordsTotal    =  $art_data['recordsTotal'];
        $result          =  $art_data['data'];

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $result,
        ]);
    }

    public function art_bank_ajax(Request $request)
    {
        //dd('===================');die();
        $search          =  $request->input('search');
        $start           =  $request->input('start', 0);  // Default to 0 if not set
        $length          =  $request->input('length', 10);
        $noctable        =  new Noctable();

        $art_data        =  $noctable->view_art_bank_ajax($start, $length, $search);
        $recordsTotal    =  $art_data['recordsTotal'];
        $result          =  $art_data['data'];

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => $result,
        ]);
    }

    public function get_submit_application_ajax(Request $request)
    {
        // dd('sdfsdfs');
        $search = $request->input('search');
        $start  = $request->input('start', 0);  // Default to 0 if not set
        $length = $request->input('length', 10);


        $NocAjax = new NocAjax();
        $surrsurrogacy_data = $NocAjax->submit_application_ajax($start, $length, $search);

        //dd($surrsurrogacy_data);

        // $totalRecords =  $surrsurrogacy_data['total_records']; 

        $recordsTotal =  $surrsurrogacy_data['recordsTotal'];
        $recordsFiltered =  $surrsurrogacy_data['recordsFiltered'];
        //  dd($totalRecords);
        $result =  $surrsurrogacy_data['data'];

        return response()->json([
            'draw' => $request->input('draw'), // Draw counter
            'recordsTotal' => $recordsTotal, // Total records count
            'recordsFiltered' => $recordsTotal, // Total records count// Filtered records count
            'data' => $result, // Data for the table
        ]);
    }


    public function get_total_query_raised(Request $request)
    {
        $search = $request->input('search');
        $start = $request->input('start', 0);  // Default to 0 if not set
        $length = $request->input('length', 10);


        $NocAjax = new NocAjax();
        $query_raised_data = $NocAjax->get_total_query_raised_ajax($start, $length, $search);

        // $totalRecords =  $surrsurrogacy_data['total_records']; 

        $recordsTotal =  $query_raised_data['recordsTotal'];
        $recordsFiltered =  $query_raised_data['recordsFiltered'];
        //  dd($totalRecords);
        $result =  $query_raised_data['data'];

        return response()->json([
            'draw' => $request->input('draw'), // Draw counter
            'recordsTotal' => $recordsTotal, // Total records count
            'recordsFiltered' => $recordsTotal, // Total records count// Filtered records count
            'data' => $result, // Data for the table
        ]);
    }


    public function get_noc_issue_ajax(Request $request)
    {
        $search = $request->input('search');
        $start = $request->input('start', 0);  // Default to 0 if not set
        $length = $request->input('length', 10);


        $NocAjax = new NocAjax();
        $query_raised_data = $NocAjax->noc_issue_ajax($start, $length, $search);

        // $totalRecords =  $surrsurrogacy_data['total_records']; 

        $recordsTotal =  $query_raised_data['recordsTotal'];
        $recordsFiltered =  $query_raised_data['recordsFiltered'];
        //  dd($totalRecords);
        $result =  $query_raised_data['data'];

        return response()->json([
            'draw' => $request->input('draw'), // Draw counter
            'recordsTotal' => $recordsTotal, // Total records count
            'recordsFiltered' => $recordsTotal, // Total records count// Filtered records count
            'data' => $result, // Data for the table
        ]);
    }


    public function get_Query_Responce_ajax(Request $request)
    {
        $search = $request->input('search');
        $start = $request->input('start', 0);  // Default to 0 if not set
        $length = $request->input('length', 10);


        $NocAjax = new NocAjax();
        $query_raised_data = $NocAjax->Query_Responce_ajax($start, $length, $search);

        // $totalRecords =  $surrsurrogacy_data['total_records']; 

        $recordsTotal =  $query_raised_data['recordsTotal'];
        $recordsFiltered =  $query_raised_data['recordsFiltered'];
        //  dd($totalRecords);
        $result =  $query_raised_data['data'];

        return response()->json([
            'draw' => $request->input('draw'), // Draw counter
            'recordsTotal' => $recordsTotal, // Total records count
            'recordsFiltered' => $recordsTotal, // Total records count// Filtered records count
            'data' => $result, // Data for the table
        ]);
    }

    public function surrogacy_list(Request $request)
    {
        $noctable = new Noctable();
        $surrsurrogacy_data = $noctable->view_surrsurrogacy_list();
        // dd($surrsurrogacy_data);

        return view('layouts.admin.surrogacy_list', compact('surrsurrogacy_data'));
    }
    public function monthlyReportList(Request $request){
    $state     = $request->query('state');       // MAHARASHTRA
    $startDate = $request->query('startdate'); // 2005-01-03
    $endDate   = $request->query('endDate');

    return view('layouts.admin.clinic_detail_state_wise', compact('clinic_data'));
}


public function monthly_report()
{
    try{
    $states = DB::table('state')->select('state_id', 'state_name')->get();
    // dd($states);
      return view('layouts.admin.list_monthly_report',compact('states'));
    }catch(Exception $e){
        Log::error('monthly_report access failed: ' . $e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine());
        return redirect('/');

    }
}


public function monthly_report_list(Request $request)
{
   
    $startdate = $request->input('start_date');
    $endDate = $request->input('end_date');
    if(Session::get('user_type') == 5){
        $state = session('state_name');
    }else{
        $state = $request->input('state');
    }
    $app_type = $request->input('app_type');
    if($app_type=="registration")
    {
        $app_status = 1;
        $reg_status = 1;
        $artclinicR = DB::table('artclinic as art')
                        ->select('art.state',DB::raw('COUNT(*) as artclinic_active_count'))
                        ->where('art.status',$app_status)
                        ->when(!empty($state), function ($q) use ($state) {
                            $q->where('art.state', $state);
                        })
                        ->whereIn('art.archive_status',[0,1])
                        ->when(!empty($startdate), function ($q) use ($startdate) {
                        $q->whereDate('art.applicationno_datetime_submission', '>=', $startdate);
                        })
                        ->when(!empty($endDate), function ($q) use ($endDate) {
                        $q->whereDate('art.applicationno_datetime_submission', '<=', $endDate);
                        })
                        // ->whereDate('art.applicationno_datetime_submission', '>=', $startdate)
                        // ->whereDate('art.applicationno_datetime_submission', '<=', $endDate)
                        ->where('art.state', '!=','')
                        ->groupBy('art.state')
                        ->orderBy('art.state')
                        ->get();
        $artclinicR_Data = $artclinicR->keyBy('state')->toArray();
        $artclinicA = DB::table('clinic_registration as cr')
                        ->select('cr.state',DB::raw('COUNT(*) as artclinic_reg_count'))
                        ->where('cr.status',$reg_status)
                        ->when(!empty($state), function ($q) use ($state) {
                            $q->where('cr.state', $state);
                        })
                        ->where('cr.clinic_type','ARTCLINIC')
                        ->when(!empty($startdate), function ($q) use ($startdate) {
                        $q->whereDate('cr.rgistration_date', '>=', $startdate);
                        })
                        ->when(!empty($endDate), function ($q) use ($endDate) {
                        $q->whereDate('cr.rgistration_date', '<=', $endDate);
                        })
                        ->when(!empty($state), function ($q) use ($state) {
                        $q->where('cr.state', $state);
                        })
                        // ->where('cr.state', '!=','')
                        ->groupBy('cr.state')
                        ->orderBy('cr.state')
                        ->get();
        $artclinicA_Data = $artclinicA->keyBy('state')->toArray();
        $artclinicC = DB::table('artclinic as art')
                        ->rightJoin('artclinic_certificate_details as acd', function($join) {
                            $join->on(DB::raw('art.applicationno'), '=', DB::raw('acd.application_no'));
                        })
                        ->select('art.state',DB::raw('COUNT(*) as artclinic_rej_count'))
                        ->where('art.status',$app_status)
                        ->when(!empty($state), function ($q) use ($state) {
                            $q->where('art.state', $state);
                        })
                        ->whereIn('art.archive_status',[0,1])
                        ->where('acd.approved_rejected','Registration Rejected')
                        ->when(!empty($startdate), function ($q) use ($startdate) {
                        $q->whereDate('art.applicationno_datetime_submission', '>=', $startdate);
                        })
                        ->when(!empty($endDate), function ($q) use ($endDate) {
                        $q->whereDate('art.applicationno_datetime_submission', '<=', $endDate);
                        })
                        ->when(!empty($state), function ($q) use ($state) {
                        $q->where('art.state', $state);
                        })
                        ->where('art.state', '!=','')
                        ->groupBy('art.state')
                        ->orderBy('art.state')
                        ->get();
        $artclinicC_Data = $artclinicC->keyBy('state')->toArray();
        $surrogacyclinicR = DB::table('surrogacyclinic as sc')
                        ->select('sc.state',DB::raw('COUNT(*) as surrogacyclinic_active_count'))
                        ->where('sc.status',1)
                        ->when(!empty($state), function ($q) use ($state) {
                            $q->where('sc.state', $state);
                        })
                        ->whereIn('sc.archive_status',[0,1])
                        ->when(!empty($startdate), function ($q) use ($startdate) {
                        $q->whereDate('sc.applicationno_datetime_submission', '>=', $startdate);
                        })
                        ->when(!empty($endDate), function ($q) use ($endDate) {
                        $q->whereDate('sc.applicationno_datetime_submission', '<=', $endDate);
                        })
                        ->when(!empty($state), function ($q) use ($state) {
                        $q->where('sc.state', $state);
                        })
                        ->where('sc.state', '!=','')
                        ->groupBy('sc.state')
                        ->orderBy('sc.state')
                        ->get();
        
        $surrogacyclinicR_Data = $surrogacyclinicR->keyBy('state')->toArray();
        $surrogacyclinicA = DB::table('clinic_registration as cr')
                        ->select('cr.state',DB::raw('COUNT(*) as surrogacy_reg_count'))
                        ->where('cr.status',$reg_status)
                        ->when(!empty($state), function ($q) use ($state) {
                            $q->where('cr.state', $state);
                        })
                        ->where('cr.clinic_type','ARTSURROGACY')
                        ->when(!empty($startdate), function ($q) use ($startdate) {
                        $q->whereDate('cr.rgistration_date', '>=', $startdate);
                        })
                        ->when(!empty($endDate), function ($q) use ($endDate) {
                        $q->whereDate('cr.rgistration_date', '<=', $endDate);
                        })
                        ->when(!empty($state), function ($q) use ($state) {
                        $q->where('cr.state', $state);
                        })
                        ->where('cr.state', '!=','')
                        ->groupBy('cr.state')
                        ->orderBy('cr.state')
                        ->get();
        
        $surrogacyclinicA_Data = $surrogacyclinicA->keyBy('state')->toArray();
        $surrogacyclinicC = DB::table('surrogacyclinic as sc')
                        ->rightJoin('surrogacy_certificate_details as scd', function($join) {
                            $join->on(DB::raw('sc.applicationno'), '=', DB::raw('scd.application_no'));
                        })
                        ->select('sc.state',DB::raw('COUNT(*) as surrogacy_rej_count'))
                        ->where('sc.status',$app_status)
                        ->when(!empty($state), function ($q) use ($state) {
                            $q->where('sc.state', $state);
                        })
                        ->whereIn('sc.archive_status',[0,1])
                        ->where('scd.approved_rejected','Registration Rejected')
                        ->when(!empty($startdate), function ($q) use ($startdate) {
                        $q->whereDate('sc.applicationno_datetime_submission', '>=', $startdate);
                        })
                        ->when(!empty($endDate), function ($q) use ($endDate) {
                        $q->whereDate('sc.applicationno_datetime_submission', '<=', $endDate);
                        })
                        ->when(!empty($state), function ($q) use ($state) {
                        $q->where('sc.state', $state);
                        })
                        ->where('sc.state', '!=','')
                        ->groupBy('sc.state')
                        ->orderBy('sc.state')
                        ->get();
        $surrogacyclinicC_Data = $surrogacyclinicC->keyBy('state')->toArray();
        $artbankR = DB::table('artbank as ab')
                        ->select('ab.state',DB::raw('COUNT(*) as artbank_active_count'))
                        ->where('ab.status',1)
                        ->when(!empty($state), function ($q) use ($state) {
                            $q->where('ab.state', $state);
                        })
                        ->whereIn('ab.archive_status',[0,1])
                        ->when(!empty($startdate), function ($q) use ($startdate) {
                        $q->whereDate('ab.applicationno_datetime_submission', '>=', $startdate);
                        })
                        ->when(!empty($endDate), function ($q) use ($endDate) {
                        $q->whereDate('ab.applicationno_datetime_submission', '<=', $endDate);
                        })
                        ->when(!empty($state), function ($q) use ($state) {
                        $q->where('ab.state', $state);
                        })
                        ->where('ab.state', '!=','')
                        ->groupBy('ab.state')
                        ->orderBy('ab.state')
                        ->get();
        
        $artbankR_Data = $artbankR->keyBy('state')->toArray();
        $artbankA = DB::table('clinic_registration as cr')
                        ->select('cr.state',DB::raw('COUNT(*) as artbank_reg_count'))
                        ->where('cr.status',$reg_status)
                        ->when(!empty($state), function ($q) use ($state) {
                            $q->where('cr.state', $state);
                        })
                        ->where('cr.clinic_type','ARTBANK')
                        ->when(!empty($startdate), function ($q) use ($startdate) {
                        $q->whereDate('cr.rgistration_date', '>=', $startdate);
                        })
                        ->when(!empty($endDate), function ($q) use ($endDate) {
                        $q->whereDate('cr.rgistration_date', '<=', $endDate);
                        })
                        ->when(!empty($state), function ($q) use ($state) {
                        $q->where('cr.state', $state);
                        })
                        ->where('cr.state', '!=','')
                        ->groupBy('cr.state')
                        ->orderBy('cr.state')
                        ->get();
        $artbankA_Data = $artbankA->keyBy('state')->toArray();
        $artbankC = DB::table('artbank as ab')
                        ->rightJoin('artbank_certificate_details as bcd', function($join) {
                            $join->on(DB::raw('ab.applicationno'), '=', DB::raw('bcd.application_no'));
                        })
                        ->select('ab.state',DB::raw('COUNT(*) as artbank_rej_count'))
                        ->where('ab.status',$app_status)
                        ->when(!empty($state), function ($q) use ($state) {
                            $q->where('ab.state', $state);
                        })
                        ->whereIn('ab.archive_status',[0,1])
                        ->where('bcd.approved_rejected','Registration Rejected')
                        ->when(!empty($startdate), function ($q) use ($startdate) {
                        $q->whereDate('ab.applicationno_datetime_submission', '>=', $startdate);
                        })
                        ->when(!empty($endDate), function ($q) use ($endDate) {
                        $q->whereDate('ab.applicationno_datetime_submission', '<=', $endDate);
                        })
                        ->when(!empty($state), function ($q) use ($state) {
                        $q->where('ab.state', $state);
                        })
                        ->where('ab.state', '!=','')
                        ->groupBy('ab.state')
                        ->orderBy('ab.state')
                        ->get();
        $artbankC_Data = $artbankC->keyBy('state')->toArray();
        // Merge by state
        // dd($artsurrogacyData);
        $states = array_unique(array_merge(
                    array_keys($artclinicR_Data),
                    array_keys($artclinicA_Data),
                    array_keys($artclinicC_Data),

                  ));
        $data = [];
        sort($states);
        
        foreach ($states as $state) {
            $data[] = [

                'startdate'  => $startdate,
                'endDate'    => $endDate,
                'state'                                 => $state ?? 0,
                'artclinic_recieve_count'               => $artclinicR_Data[$state]->artclinic_active_count ?? 0,
                'artclinic_registerd_count'             => $artclinicA_Data[$state]->artclinic_reg_count ?? 0,
                'artclinic_rejected_count'              => $artclinicC_Data[$state]->artclinic_rej_count ?? 0,

                'artbank_recieve_count'                 => $artbankR_Data[$state]->artbank_active_count ?? 0,
                'artbank_registerd_count'               => $artbankA_Data[$state]->artbank_reg_count ?? 0,
                'artbank_rejected_count'                => $artbankC_Data[$state]->artbank_rej_count ?? 0,

                'surrogacyclinic_recieve_count'         => $surrogacyclinicR_Data[$state]->surrogacyclinic_active_count ?? 0,
                'surrogacyclinic_registerd_count'       => $surrogacyclinicA_Data[$state]->surrogacy_reg_count ?? 0,
                'surrogacyclinic_rejected_count'        => $surrogacyclinicC_Data[$state]->surrogacy_rej_count ?? 0,
                'total_1'                               => ($artbankR_Data[$state]->artbank_active_count ?? 0) + ($artclinicR_Data[$state]->artclinic_active_count ?? 0)
                                                        + ($surrogacyclinicR_Data[$state]->surrogacyclinic_active_count ?? 0),
                
                'total_2'                               => ($artclinicA_Data[$state]->artclinic_reg_count ?? 0) + ($artbankA_Data[$state]->artbank_reg_count ?? 0)
                                                        + ($surrogacyclinicA_Data[$state]->surrogacy_reg_count ?? 0),

                'total_3'                               => ($artclinicC_Data[$state]->artclinic_rej_count ?? 0) + ($artbankC_Data[$state]->artbank_rej_count ?? 0)
                                                        + ($surrogacyclinicC_Data[$state]->surrogacy_rej_count ?? 0),
            ];
        }
    }elseif($app_type=="renewal"){
        // RenewalSCApplication::selectRow(

        // )
        $data = Statetable::query()
                ->leftJoin(
                    'renewal_sc_application as ra',
                    'ra.state',
                    '=',
                    'state.state_name'
                )
                ->when($request->state, function ($query, $state) {
                    $query->where('state.state_name', $state);
                })
                ->when($request->start_date, function ($query, $startDate) {
                    $query->whereDate('ra.application_datetime_submission', '>=', $startDate);
                })
                ->when($request->end_date, function ($query, $endDate) {
                    $query->whereDate('ra.application_datetime_submission', '<=', $endDate);
                })
                ->selectRaw("
                    state.state_name as state,
                    
                        SUM(CASE WHEN ra.clinic_type='ARTSURROGACY'
                            AND ra.status=1 THEN 1 ELSE 0 END) as surrogacyclinic_recieve_count,
                        SUM(CASE WHEN ra.clinic_type='ARTSURROGACY'
                            AND ra.appstatus='Approved' AND ra.status=1 THEN 1 ELSE 0 END) as surrogacyclinic_registerd_count,
                        SUM(CASE WHEN ra.clinic_type='ARTSURROGACY'
                            AND ra.appstatus='Rejected' AND ra.status=1 THEN 1 ELSE 0 END) as surrogacyclinic_rejected_count,
                        SUM(CASE WHEN ra.clinic_type = 'ARTSURROGACY'
                            AND ra.appstatus IN ('Pending','Approved','Rejected') AND ra.status=1 THEN 1 ELSE 0 END ) 
                            as surrogacy_total,

                        SUM(CASE WHEN ra.clinic_type='ARTSURROGACY'
                            AND ra.appstatus='Pending' AND ra.status=1 THEN 1 ELSE 0 END) as surrogacyclinic_pending_count,

                        SUM(CASE WHEN ra.appstatus = 'Pending' AND ra.status=1 THEN 1 ELSE 0 END ) as total_1,

                        
                        SUM(CASE WHEN ra.clinic_type='ARTCLINIC'
                            AND ra.status=1 THEN 1 ELSE 0 END) as artclinic_recieve_count,

                        
                        SUM(CASE WHEN ra.clinic_type='ARTCLINIC'
                            AND ra.appstatus='Approved' AND ra.status=1 THEN 1 ELSE 0 END) as artclinic_registerd_count,
                        SUM(CASE WHEN ra.clinic_type='ARTCLINIC'
                            AND ra.appstatus='Rejected' AND ra.status=1 THEN 1 ELSE 0 END) as artclinic_rejected_count,
                        SUM(CASE WHEN ra.clinic_type = 'ARTCLINIC'
                            AND ra.appstatus IN ('Pending','Approved','Rejected') AND ra.status=1 THEN 1 ELSE 0 END ) 
                            as artclinic_total,
                        
                        SUM(CASE WHEN ra.clinic_type='ARTCLINIC'
                            AND ra.appstatus='Pending' AND ra.status=1 THEN 1 ELSE 0 END) as artclinic_pending_count,

                        SUM(CASE WHEN ra.appstatus = 'Approved' AND ra.status=1 THEN 1 ELSE 0 END ) as total_2,

                        SUM(CASE WHEN ra.clinic_type='ARTBANK'
                            AND ra.status=1 THEN 1 ELSE 0 END) as artbank_recieve_count,
                        SUM(CASE WHEN ra.clinic_type='ARTBANK'
                            AND ra.appstatus='Approved' AND ra.status=1 THEN 1 ELSE 0 END) as artbank_registerd_count,
                        SUM(CASE WHEN ra.clinic_type='ARTBANK'
                            AND ra.appstatus='Rejected' AND ra.status=1 THEN 1 ELSE 0 END) as artbank_rejected_count,

                        SUM(CASE WHEN ra.clinic_type = 'ARTBANK'
                            AND ra.appstatus IN ('Pending','Approved','Rejected') AND ra.status=1 THEN 1 ELSE 0 END ) 
                            as artbank_total,

                        SUM(CASE WHEN ra.clinic_type='ARTBANK'
                            AND ra.appstatus='Pending' AND ra.status=1 THEN 1 ELSE 0 END) as artbank_pending_count,

                        SUM(CASE WHEN ra.appstatus = 'Rejected' AND ra.status=1 THEN 1 ELSE 0 END ) as total_3

                    
                ")
                ->groupBy(
                    'state.state_name'
                )
                ->get();

                // dd($data[0]['surrogacyclinic_recieve_count'] == $data[0]['surrogacyclinic_registerd_count'] + $data[0]['surrogacyclinic_rejected_count'] + $data[0]['surrogacyclinic_pending_count']);
    }


    // else if($app_type=="renewal"){
    //     $app_status = 1;
    //     $reg_status = 1;
    //     SELECT
    //         rsa.state,

    //         /* ART CLINIC */
    //         SUM(CASE
    //                 WHEN rsa.status = 1
    //                 AND rsa.clinic_type = 'ARTCLINIC'
    //                 THEN 1 ELSE 0
    //             END) AS art_received,

    //         SUM(CASE
    //                 WHEN cr.status = 1
    //                 AND rsa.clinic_type = 'ARTCLINIC'
    //                 THEN 1 ELSE 0
    //             END) AS art_registered,

    //         SUM(CASE
    //                 WHEN rsa.appstatus = 'Rejected'
    //                 AND rsa.clinic_type = 'ARTCLINIC'
    //                 THEN 1 ELSE 0
    //             END) AS art_rejected,



    //         /* SURROGACY */
    //         SUM(CASE
    //                 WHEN rsa.status = 1
    //                 AND rsa.clinic_type = 'ARTSURROGACY'
    //                 THEN 1 ELSE 0
    //             END) AS surrogacy_received,

    //         SUM(CASE
    //                 WHEN cr.status = 1
    //                 AND rsa.clinic_type = 'ARTSURROGACY'
    //                 THEN 1 ELSE 0
    //             END) AS surrogacy_registered,

    //         SUM(CASE
    //                 WHEN rsa.appstatus = 'Rejected'
    //                 AND rsa.clinic_type = 'ARTSURROGACY'
    //                 THEN 1 ELSE 0
    //             END) AS surrogacy_rejected,



    //         /* ART BANK */
    //         SUM(CASE
    //                 WHEN rsa.status = 1
    //                 AND rsa.clinic_type = 'ARTBANK'
    //                 THEN 1 ELSE 0
    //             END) AS bank_received,

    //         SUM(CASE
    //                 WHEN cr.status = 1
    //                 AND rsa.clinic_type = 'ARTBANK'
    //                 THEN 1 ELSE 0
    //             END) AS bank_registered,

    //         SUM(CASE
    //                 WHEN rsa.appstatus = 'Rejected'
    //                 AND rsa.clinic_type = 'ARTBANK'
    //                 THEN 1 ELSE 0
    //             END) AS bank_rejected,



    //         /* TOTAL */
    //         SUM(CASE WHEN rsa.status = 1 THEN 1 ELSE 0 END) AS total_received,

    //         SUM(CASE WHEN cr.status = 1 THEN 1 ELSE 0 END) AS total_registered,

    //         SUM(CASE WHEN rsa.appstatus = 'Rejected' THEN 1 ELSE 0 END) AS total_rejected

    //     FROM renewal_sc_application rsa

    //     LEFT JOIN clinic_registration cr
    //         ON cr.application_no = rsa.applicationno

    //     WHERE rsa.application_datetime_submission
    //         BETWEEN '2024-01-01 00:00:00'
    //             AND '2024-12-31 23:59:59'

    //     GROUP BY rsa.state

    //     ORDER BY rsa.state;
    //     $applicationR = DB::table('renewal_sc_application as renewapp')
    //                     ->select('renewapp.state',DB::raw('COUNT(*) as artclinic_active_count'))
    //                     ->where('renewapp.status',$app_status)
    //                     ->when(!empty($startdate), function ($q) use ($startdate) {
    //                     $q->whereDate('renewapp.application_datetime_submission', '>=', $startdate);
    //                     })
    //                     ->when(!empty($endDate), function ($q) use ($endDate) {
    //                     $q->whereDate('renewapp.application_datetime_submission', '<=', $endDate);
    //                     })
    //                     // ->whereDate('art.applicationno_datetime_submission', '>=', $startdate)
    //                     // ->whereDate('art.applicationno_datetime_submission', '<=', $endDate)
    //                     ->where('renewapp.state', '!=','')
    //                     ->groupBy('renewapp.state')
    //                     ->orderBy('renewapp.state')
    //                     ->get();
    //     $applicationR_Data = $applicationR->keyBy('state')->toArray();
    //     $applicationA = DB::table('clinic_registration as cr')
    //                     ->select('cr.state',DB::raw('COUNT(*) as artclinic_reg_count'))
    //                     ->where('cr.status',$reg_status)
    //                     ->where('cr.clinic_type','ARTCLINIC')
    //                     ->when(!empty($startdate), function ($q) use ($startdate) {
    //                     $q->whereDate('cr.rgistration_date', '>=', $startdate);
    //                     })
    //                     ->when(!empty($endDate), function ($q) use ($endDate) {
    //                     $q->whereDate('cr.rgistration_date', '<=', $endDate);
    //                     })
    //                     ->when(!empty($state), function ($q) use ($state) {
    //                     $q->where('cr.state', $state);
    //                     })
    //                     // ->where('cr.state', '!=','')
    //                     ->groupBy('cr.state')
    //                     ->orderBy('cr.state')
    //                     ->get();
    //     $applicationA_Data = $applicationA->keyBy('state')->toArray();
    //     $applicationC = DB::table('renewal_sc_application as renewapp')
    //                     ->rightJoin('artclinic_certificate_details as acd', function($join) {
    //                         $join->on(DB::raw('art.applicationno'), '=', DB::raw('acd.application_no'));
    //                     })
    //                     ->select('renewapp.state',DB::raw('COUNT(*) as artclinic_rej_count'))
    //                     ->where('renewapp.status',$app_status)
    //                     ->where('renewapp.appstatus','Rejected')
    //                     ->when(!empty($startdate), function ($q) use ($startdate) {
    //                     $q->whereDate('renewapp.application_datetime_submission', '>=', $startdate);
    //                     })
    //                     ->when(!empty($endDate), function ($q) use ($endDate) {
    //                     $q->whereDate('renewapp.application_datetime_submission', '<=', $endDate);
    //                     })
    //                     ->when(!empty($state), function ($q) use ($state) {
    //                     $q->where('renewapp.state', $state);
    //                     })
    //                     ->where('renewapp.state', '!=','')
    //                     ->groupBy('renewapp.state')
    //                     ->orderBy('renewapp.state')
    //                     ->get();
    //     $applicationC_Data = $applicationC->keyBy('state')->toArray();
    //     $states = array_unique(array_merge(
    //                 array_keys($applicationR_Data),
    //                 array_keys($applicationA_Data),
    //                 array_keys($applicationC_Data),

    //               ));
    //     $data = [];
    //     sort($states);

    //     foreach ($states as $state) {
    //         $data[] = [

    //             'startdate'  => $startdate,
    //             'endDate'    => $endDate,
    //             'state'                                 => $state ?? 0,
    //             'artclinic_recieve_count'               => $artclinicR_Data[$state]->artclinic_active_count ?? 0,
    //             'artclinic_registerd_count'             => $artclinicA_Data[$state]->artclinic_reg_count ?? 0,
    //             'artclinic_rejected_count'              => $artclinicC_Data[$state]->artclinic_rej_count ?? 0,

    //             'artbank_recieve_count'                 => $artbankR_Data[$state]->artbank_active_count ?? 0,
    //             'artbank_registerd_count'               => $artbankA_Data[$state]->artbank_reg_count ?? 0,
    //             'artbank_rejected_count'                => $artbankC_Data[$state]->artbank_rej_count ?? 0,

    //             'surrogacyclinic_recieve_count'         => $surrogacyclinicR_Data[$state]->surrogacyclinic_active_count ?? 0,
    //             'surrogacyclinic_registerd_count'       => $surrogacyclinicA_Data[$state]->surrogacy_reg_count ?? 0,
    //             'surrogacyclinic_rejected_count'        => $surrogacyclinicC_Data[$state]->surrogacy_rej_count ?? 0,
    //             'total_1'                               => ($artbankR_Data[$state]->artbank_active_count ?? 0) + ($artclinicR_Data[$state]->artclinic_active_count ?? 0)
    //                                                     + ($surrogacyclinicR_Data[$state]->surrogacyclinic_active_count ?? 0),
                
    //             'total_2'                               => ($artclinicA_Data[$state]->artclinic_reg_count ?? 0) + ($artbankA_Data[$state]->artbank_reg_count ?? 0)
    //                                                     + ($surrogacyclinicA_Data[$state]->surrogacy_reg_count ?? 0),

    //             'total_3'                               => ($artclinicC_Data[$state]->artclinic_rej_count ?? 0) + ($artbankC_Data[$state]->artbank_rej_count ?? 0)
    //                                                     + ($surrogacyclinicC_Data[$state]->surrogacy_rej_count ?? 0),
    //         ];
    //     }
    // }
    else{
        $data = [];
    }
    // dd($data);
    // return response()->json(['data' => $data]);
    // if($data[35]['surrogacyclinic_recieve_count'] == $data[35]['surrogacyclinic_registerd_count'] + $data[35]['surrogacyclinic_rejected_count'] + $data[35]['surrogacyclinic_pending_count']){
        return response()->json($data);
    // }
    
}
public function state_wise_report()
{
    $states = DB::table('state')->select('state_id', 'state_name')->get();
    // dd($states);
      return view('layouts.admin.state_wise_report',compact('states'));
}
public function state_clinic_report_list(Request $request)
{
//   dd('=======');
     $startdate = $request->input('start_date');
    //  if(empty($startdate)){
    //     $startdate = '1950-01-01';
    //  }
     $endDate = $request->input('end_date');
     if(Session::get('user_type') == '5'){
        $state = session('state_name');
     }else{
     $state = $request->input('state');
     }
     $typeofclinic = $request->input('typeofclinic');
     $app_type = $request->input('app_type');
    
     if($app_type == 'registration'){
    if($typeofclinic == 'Art clinic'){

    $data = DB::table('artclinic')
                ->leftJoin('clinic_registration', function($join) {
                            $join->on(DB::raw('artclinic.applicationno COLLATE utf8mb4_general_ci'), '=', DB::raw('clinic_registration.application_no COLLATE utf8mb4_general_ci'))
                            ->where('clinic_registration.status', 1)
                            ->where('clinic_registration.clinic_type','ARTCLINIC');
                        })
                ->when(!empty($state), function ($query) use ($state) {
                    return $query->where('artclinic.state', $state);
                })
                ->where('artclinic.status', 1)
                ->whereIn('artclinic.archive_status', [0,1])
                ->when(!empty($startdate) && !empty($endDate), function ($query) use ($startdate, $endDate) {
                    return $query->whereBetween('artclinic.applicationno_datetime_submission', [$startdate, $endDate]);
                })
                ->select(
                    'artclinic.*',
                    'clinic_registration.registration_no',
                    'clinic_registration.rgistration_date'
                )
                ->get()->map(function ($item) use ($typeofclinic) {
        $item->typeofclinic = $typeofclinic;
        return $item;
    });
    // dd($data);

    }else if($typeofclinic == 'Art Bank'){

    $data = DB::table('artbank')
                ->leftJoin('clinic_registration', function($join) {
                            $join->on(DB::raw('artbank.applicationno COLLATE utf8mb4_general_ci'), '=', DB::raw('clinic_registration.application_no COLLATE utf8mb4_general_ci'))
                            ->where('clinic_registration.status', 1)
                            ->where('clinic_registration.clinic_type','ARTBANK');
                        })
                ->when(!empty($state), function ($query) use ($state) {
                        return $query->where('artbank.state', $state);
                    })
                ->where('artbank.status', 1)
                ->whereIn('artbank.archive_status', [0,1])
                ->when(!empty($startdate) && !empty($endDate), function ($query) use ($startdate, $endDate) {
                    return $query->whereBetween('artbank.applicationno_datetime_submission', [$startdate, $endDate]);
                })
                ->select(
                    'artbank.*',
                    'clinic_registration.registration_no',
                    'clinic_registration.rgistration_date'
                )
                ->get()->map(function ($item) use ($typeofclinic) {
                    $item->rgistration_date = $item->rgistration_date 
                    ? \Carbon\Carbon::parse($item->rgistration_date)->toDateString() 
                    : null;
                    $item->applicationno_datetime_submission = $item->applicationno_datetime_submission 
                    ? \Carbon\Carbon::parse($item->applicationno_datetime_submission)->toDateString() 
                    : null;
                    $item->typeofclinic = $typeofclinic;
                    return $item;
            });

    }else if($typeofclinic == 'Surrogacy Clinic'){

    $data = DB::table('surrogacyclinic')
                ->leftJoin('clinic_registration', function($join) {
                            $join->on(DB::raw('surrogacyclinic.applicationno COLLATE utf8mb4_general_ci'), '=', DB::raw('clinic_registration.application_no COLLATE utf8mb4_general_ci'))
                            ->where('clinic_registration.status', 1)
                            ->where('clinic_registration.clinic_type','ARTSURROGACY');
                        })
                ->when(!empty($state), function ($query) use ($state) {
                        return $query->where('surrogacyclinic.state', $state);
                    })
                ->where('surrogacyclinic.status', 1)
                ->whereIn('surrogacyclinic.archive_status', [0,1])
                ->when(!empty($startdate) && !empty($endDate), function ($query) use ($startdate, $endDate) {
                    return $query->whereBetween('surrogacyclinic.applicationno_datetime_submission', [$startdate, $endDate]);
                })
                ->select(
                    'surrogacyclinic.*',
                    'clinic_registration.registration_no',
                    'clinic_registration.rgistration_date'
                )
                ->get()->map(function ($item) use ($typeofclinic) {
                    $item->typeofclinic = $typeofclinic;
                    return $item;
           });
    }
}
elseif($app_type == 'renewal'){

    //  $startdate = $request->input('start_date');
    //  $endDate = $request->input('end_date');
    //  $state = $request->input('state');
    //  $typeofclinic = $request->input('typeofclinic');
        $clinic_type = [
            'Art clinic' => 'ARTCLINIC',
            'Art Bank' =>'ARTBANK',
            'Surrogacy Clinic'=>'ARTSURROGACY',
            ];
    $data = RenewalSCApplication::select('*','application_datetime_submission as applicationno_datetime_submission')->where('clinic_type',$clinic_type[$typeofclinic])
            ->when(!empty($state),function($query) use($state){
            return $query->where('state',$state);
        })
        ->when(!empty($startdate) && !empty($endDate), function ($query) use ($startdate, $endDate) {
                    return $query->whereBetween('application_datetime_submission', [$startdate, $endDate]);
        })
        ->get();
}else{
    $data = [];
}
   

    return response()->json($data);
   
}

public function doe_correction(){
        $data = ClinicRegistrationTempModel::where('status',1)->get();
        // dd($data);
        
        return view('layouts.admin.doe-correction',compact('data'));
    }

    public function updateDates(Request $request)
    {
        try {
            // dd($request->data);
            $updatedCount = 0;
            foreach ($request->data as $item) {
                // dd($item['registration_date']);
                if (empty($item['registration_date'])) {
                continue;
                }
                // ClinicRegistrationTempModel::where('clinic_id', $item['clinic_id'])->update(['rgistration_date' => $item['registration_date']]);
                // update only if the field is currently null / empty
                $updated = ClinicRegistrationTempModel::where('clinic_id', $item['clinic_id'])
                    ->whereNull('rgistration_date') // only update if not already set
                    ->update(['rgistration_date' => $item['registration_date']]);

                $updatedCount += $updated;
            }
            if ($updatedCount === 0) {
            return response()->json(['status' => 'warning', 'message' => 'No new dates were updated.']);
            }
            return response()->json([
            'status' => 'success',
            'message' => "$updatedCount registration date(s) updated successfully."
            ]);
            // return response()->json(['status' => 'success', 'message' => 'Registeration Dates updated successfully']);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error Occured. Please try again: ' . $e->getMessage()
            ], 500);
        }
    }
    public function doe_estb(){
        // $data = DB::table('clinic_registration as cr')
        //     ->rightJoin('temp_table_for_date_establishment as ncr', function($join) {
        //         $join->on(DB::raw('cr.clinic_id'), '=', DB::raw('ncr.clinic_id'));
        //     })
        //     ->select(
        //         'cr.id',
        //         'cr.clinic_id',
        //         'cr.registration_no',
        //         'cr.level',
        //         'cr.state',
        //         'cr.name',
        //         'cr.email',
        //         'cr.contact_number_clinic',
        //         'cr.date_of_establishment as old_establishment_date',
        //         'ncr.new_date_of_establishment as new_establishment_date'
        //     )
        //     ->where('cr.status','1')
        //     ->get();
        
        $data = DB::table('temp_table_for_date_establishment2 as cr')
                    ->leftJoin('temp_table_for_date_establishment as ncr', function($join) {
                        $join->on(DB::raw('cr.clinic_id COLLATE utf8mb4_general_ci'), '=', DB::raw('ncr.clinic_id COLLATE utf8mb4_general_ci'));
                    })
                    ->where('cr.status','1')
                    ->select(
                        'cr.id',
                        'cr.clinic_id',
                        'cr.registration_no',
                        'cr.level',
                        'cr.clinic_type',
                        'cr.state',
                        'cr.name',
                        'cr.email',
                        'cr.contact_number_clinic',
                        'cr.date_of_establishment as old_establishment_date',
                        'ncr.new_date_of_establishment as new_establishment_date',
                        DB::raw("
                            CASE 
                                WHEN BINARY cr.date_of_establishment = BINARY ncr.new_date_of_establishment 
                                THEN 1 
                                ELSE 0 
                            END as is_same_establishment_date
                        ")
                    )
                    ->get();
        // dd($data);
        return view('layouts.admin.doe',compact('data'));
    }
    public function updateEstbDates(Request $request)
    {
        $userID = Session::get('userid');
        try {
            foreach ($request->data as $item) {
                $update_data = [
                    'new_date_of_establishment' => $item['new_date_of_establishment'],
                    'userid' => $userID
                ];
                // $testdata = ClinicEstbTempModel::where('clinic_id', $item['clinic_id'])->get();
                // dd($testdata);
                ClinicEstbTempModel::where('clinic_id', $item['clinic_id'])
                        ->update($update_data);
                
            }
            return response()->json([
                'status' => true,
                'message' => 'Registration Dates updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error Occured. Please try again: ' . $e->getMessage()
            ], 500);
        }
    }

 }