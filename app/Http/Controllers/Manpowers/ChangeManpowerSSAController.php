<?php

namespace App\Http\Controllers\Manpowers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\clinic\ClinicRegistrationModel;
use Illuminate\Support\Facades\Session;
use App\Models\clinic\clinicDirectorModel;
use App\Models\clinic\clinicStaffModel;
use App\Models\clinic\ClinicEquipmentModel;
use App\Http\Requests\StoreManpowerRequest;
use App\Models\ChangeManpower\ChangeManpowerApplication;
use App\Models\ChangeManpower\ChangeManpowerStaff;
use App\Models\ChangeManpower\ChangeManpowerDirector;
use App\Models\Noc\docmastertable;
use App\Models\Renewal\DocFilereceivedUploadRenewal;


class ChangeManpowerSSAController extends Controller
{
    public function changeManpowerSSAForm($encryptedClinicId)
    {
        if (!Session::has('id')) {
            return redirect()->route('admin.loginssaform');
        }

        $userId = Session::get('id');
        $stateName = Session::get('state_name');
        $clinicType = Crypt::decryptString($encryptedClinicId);

        // Map URL keyword to database value
        $clinicTypeMap = [
            'artsurrogacy' => 'ARTSURROGACY',
            'artclinic' => 'ARTCLINIC',
            'artbank' => 'ARTBANK',
        ];
        $clinicTypeValue = $clinicTypeMap[strtolower($clinicType)] ?? null;

        if (!$clinicTypeValue) {
            abort(404, 'Invalid clinic type');
        }
        $clinicTypeValueaname = [
            'ARTSURROGACY' => 'Applications for the Surrogacy Clinic Change Manpower',
            'ARTCLINIC' => 'Applications for the ART Clinic Change Manpower',
            'ARTBANK' => 'Applications for the ART Bank Change Manpower',
        ];

        // Fetch renewal list by type
        $clinicdata = ChangeManpowerApplication::where('state', $stateName)
            ->where('status', 1)
            ->where('clinic_type', $clinicType)
            ->get();
        return view('manpowers.clinic_ssa_list', compact('clinicdata', 'clinicTypeValue', 'clinicTypeValueaname'));
    }

    public function ssaChangeManpowerView($encryptedClinicId)
    {

        $clinicId = Crypt::decryptString($encryptedClinicId);
        $existPendingApplicationCheck = ChangeManpowerApplication::where('id', $clinicId)->where('status', 1)->first();

        $clinicStaff_cm = ChangeManpowerStaff::where('cm_id', $existPendingApplicationCheck->id)->where('status', 1)->get();
        $directors_cm = ChangeManpowerDirector::where('cm_id', $existPendingApplicationCheck->id)->where('status', 1)->get();

        $view = match (strtoupper($existPendingApplicationCheck->clinic_type)) {
            'ARTCLINIC' => 'manpowers.clinic_ssa_change_manpower_form_view',
            'ARTBANK' => 'manpowers.bank_ssa_change_manpower_form_view',
            'ARTSURROGACY' => 'manpowers.surrogacy_ssa_change_manpower_form_view',
        };
        return view('manpowers.clinic_ssa_change_manpower_form_view', compact('existPendingApplicationCheck', 'clinicStaff_cm', 'directors_cm'));
    }

    public function changeManpowerSearchApplication(Request $request, $clinicType)
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

        $results = ChangeManpowerApplication::where('application_no', 'LIKE', "%{$applicationNo}%")
            ->where('state', $stateName)
            ->where('status', 1)
            ->where('clinic_type', $clinicTypeValue)
            ->get()
            ->map(function ($item) {
                $item->encrypted_id = Crypt::encryptString($item->id);
                $item->encrypted_clinic_id = Crypt::encryptString($item->clinic_id);
                return $item;
            });

        return response()->json($results);
    }

    public function changeManpowerApplicationReg($encryptedClinicType, $encryptedId)
    {
        $userId = Session::get('id');
        $stateName = Session::get('state_name');

        // Decrypt clinic type and application ID
        $clinicType = Crypt::decryptString($encryptedClinicType);
        $id = Crypt::decryptString($encryptedId);

        // Fetch the application based on clinic type
        $application = ChangeManpowerApplication::where('id', $id)
            ->where('clinic_type', $clinicType)
            ->firstOrFail();

        $ChangeManpowerDirector = ChangeManpowerDirector::where('cm_id', $application->id)->where('clinic_type', $application->clinic_type)->where('status', 1)->get();
        $ChangeManpowerStaff = ChangeManpowerStaff::where('cm_id', $application->id)->where('clinic_type', $application->clinic_type)->where('status', 1)->get();


        $clinic_data = ClinicRegistrationModel::where('clinic_id', $application->clinic_id)
            ->where('status', 1)
            ->first();

        //   upload file show       
        $application_reject  = ChangeManpowerApplication::where('clinic_type', $clinicType)
            ->where('application_no', $application->fees_via_application_no)
            ->where('status', 1)
            ->where('app_status', 'Rejected')
            ->orderBy('id', 'ASC')
            ->first();

        if (!empty($application_reject) && $application_reject->applicationno == $application->fees_via_application_no) {
            $get_docfileData = DB::table('renewal_doc_file_uploads_receiving_application')
                ->where('app_id', $application_reject->id)
                ->where('application_type', $application_reject->application_type)
                ->get();
            $application_no_folder = str_replace('/', '_', $application->fees_via_application_no);
        } else {
            $get_docfileData = DB::table('renewal_doc_file_uploads_receiving_application')
                ->where('app_id', $application->id)
                ->where('application_type', $application->application_type)
                ->get();
            $application_no_folder = str_replace('/', '_', $application->applicationno);
        }
        return view('manpowers.ssa_clinic_change_manpower', compact(
            'application',
            'get_docfileData',
            'application_no_folder',
            'clinic_data',
            'clinicType',
            'ChangeManpowerDirector',
            'ChangeManpowerStaff',
        ));
    }

    public function applicationChangeManpowerSubmit(Request $request)
    {
        try {

            DB::beginTransaction();
            $request->validate([
                'approved_rejected' => 'required|in:Registration Granted,Registration Rejected',
                'app_date_recieve' => 'required|date',
            ]);
            $application_status = $request->approved_rejected == 'Registration Granted' ? 'Approved' : 'Rejected';
            $changeManpowerUpdate = [
                'app_status' => $application_status,
                'date_app_received_ssa' => $request->app_date_recieve,
                'remark' => $request->remark ?? NULL,
                'reject_order_no' => $request->rejection_no,
            ];

            $cmApplication = ChangeManpowerApplication::where('id', $request->id)->where('clinic_id', $request->clinic_id)->first();

            //update
            ChangeManpowerApplication::where('id', $request->id)->where('clinic_id', $request->clinic_id)->update($changeManpowerUpdate);
            clinicDirectorModel::where('clinic_id', $request->clinic_id)->update(['status' => 0]);
            clinicStaffModel::where('clinic_id', $request->clinic_id)->update(['status' => 0]);


            $ChangeManpowerDirector = ChangeManpowerDirector::where('cm_id', $cmApplication->id)->where('clinic_id', $cmApplication->clinic_id)->where('clinic_type', $cmApplication->clinic_type)->where('status', 1)->get();

            $ChangeManpowerStaff = ChangeManpowerStaff::where('cm_id', $cmApplication->id)->where('clinic_id', $cmApplication->clinic_id)->where('clinic_type', $cmApplication->clinic_type)->where('status', 1)->get();

            $director = [];
            $staffs = [];
            foreach ($ChangeManpowerDirector as $cmd) {
                $director[] = [
                    'clinic_id'      => $cmd->clinic_id ?? null,
                    'name_director'  => $cmd->name_director ?? null,
                    'quali_director' => $cmd->quali_director ?? null,
                    'reg_director'   => $cmd->reg_director ?? null,
                    'status'         => !empty($cmd->expiry_date) ? 0 : 1,
                    'clinic_type'    => $cmd->clinic_type ?? null,
                    'application_no' => $cmd->application_no ?? null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                    'validitydate'   => $cmd->expiry_date ?? null,
                    'relieving_date' => $cmd->expiry_date ?? null,
                ];
            }
            if (!empty($director)) {
                clinicDirectorModel::insert($director);
            }
            foreach ($ChangeManpowerStaff as $cms) {
                $staffs[] = [
                    "clinic_id" => $cms->clinic_id,
                    "name" => $cms->name ?? null,
                    "post" => $cms->post ?? null,
                    "qualification" => $cms->qualification ?? null,
                    "application_no" => $cms->application_no ?? null,
                    "regno" => $cms->regno ?? null,
                    "status" => !empty($cms->expiry_date) ? 0 : 1,
                    "clinic_type" => $cms->clinic_type ?? null,
                    "type_emp" => "ARTCLINICSTAFF",
                    "created_at" => now(),
                    "updated_at" => now(),
                    "validitydate" => $cms->expiry_date ?? null,
                    "relieving_date" => $cms->expiry_date ?? null,
                ];
            }
            if (!empty($staffs)) {
                clinicStaffModel::insert($staffs);
            }

            $this->fileUpload($request);
            DB::commit();
            return redirect()->route('change_manpower.clinic_list', ['clinicType' => Crypt::encryptString($cmApplication->clinic_type)])->with('upd_success', 'Change manpower Application has been ' . $application_status . '.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while submitting the application. Please try again.');
        }
    }

    private function fileUpload(Request $request)
    {
        $cmApplication = ChangeManpowerApplication::where('id', $request->id)->where('clinic_id', $request->clinic_id)->first();
   
            $fileInputMap = [
            'ARTSURROGACY' => 'target_file_reg_surrogacyclinic_certificate',
            'ARTCLINIC'    => 'target_file_reg_artclinic_certificate',
            'ARTBANK'      => 'target_file_reg_artbank_certificate',
        ];
        $fileKey = $fileInputMap[$cmApplication->clinic_type] ?? null;

        if (!$fileKey) {
            Log::warning(" No file input configured for clinic type: {$cmApplication->clinic_type}");
            return;
        }

        $docMasters = docmastertable::where('doc_type', $fileKey)
            ->where('status', 1)
            ->get();

        if ($docMasters->isEmpty()) {
            Log::warning(" No docmaster records found for: {$fileKey}");
            return;
        }
        $allowedExtensions = ['pdf'];
        foreach ($docMasters as $docMaster) {
            $inputName = str_replace('target_file_', '', $docMaster->doc_type);
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $extension = strtolower($file->getClientOriginalExtension());

                if (!in_array($extension, $allowedExtensions)) {
                    Log::warning(" Invalid file extension for {$inputName}: {$extension}");
                    continue;
                }

                // Build folder path and file name
                $filename = $docMaster->doc_type . '-' . now()->timestamp . '_' . $cmApplication->userid_applicant . '.' . $extension;
                $foldername = 'application_sa';
                $baseDir = folderpath($foldername);
                $application_no_folder = str_replace('/', '_', $cmApplication->application_no);
                $fullFolderPath = $baseDir . $application_no_folder;

                if (!file_exists($fullFolderPath)) {
                    mkdir($fullFolderPath, 0777, true);
                }

                $file->move($fullFolderPath, $filename);

                // Save upload info in DB
                DocFilereceivedUploadRenewal::updateOrCreate(
                    [
                        'userid'    => $cmApplication->userid_applicant,
                        'clinic_id' => $cmApplication->clinic_id,
                        'doc_id'    => $docMaster->id,
                    ],
                    [
                        'app_id'            => $cmApplication->id,
                        'application_type'  =>  NULL,
                        'clinic_type'       => $cmApplication->clinic_type,
                        'doc_type'          => $docMaster->doc_type,
                        'doc_upload_ref'    => $filename,
                    ]
                );


                Log::info("File uploaded successfully for {$inputName}: {$filename}");
            } else {
                Log::info("No file uploaded for: {$inputName}");
            }
        }
    }
}
