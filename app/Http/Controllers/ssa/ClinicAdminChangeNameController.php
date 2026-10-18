<?php

namespace App\Http\Controllers\ssa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\clinic\ArtClinicModel;
use Illuminate\Support\Facades\Log;
use App\Models\Clinic\ClinicNameChangeApplication;
use App\Models\clinic\ClinicRegistrationModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\clinic\signup;
use App\Models\Admin\user;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChangeNameApproveRejectedMail;

class ClinicAdminChangeNameController extends Controller
{

    public function changeName($type)
    {

        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }

        $type = Crypt::decryptString($type); 

        
        if ($type == 'ARTCLINIC') {

            $title = 'ARTCLINIC';
        } elseif ($type == 'ARTBANK') {

            $title = 'ARTBANK';
        } elseif ($type == 'ARTSURROGACY') {

            $title = 'ARTSURROGACY';
        } else {

            abort(404);
        }

        return view(
            'layouts.admin.change_name',
            compact('type')
        );
    }

  public function searchChangeName(Request $request)
{
    $applicationNo = $request->input('application_no');
    $stateName = Session::get('state_name');
    $applications = ClinicNameChangeApplication::query()
        ->where('state', $stateName) 
         ->where('status', 1) 
        ->when($applicationNo, function ($q) use ($applicationNo) {
            $q->where('application_no', 'like', "%{$applicationNo}%");
        })
        ->get();
    
    $applications->transform(function ($item) {
        $item->encrypted_id = Crypt::encryptString($item->id);
        $item->encrypted_action_id = Crypt::encryptString($item->clinic_id);
        return $item;
    });

        return response()->json([
            'applications' => $applications
        ]);
    }

    public function clinicForm_view($id)
    {
        $clinicId = Crypt::decryptString($id);

        $clinic = DB::table('clinic_name_change_applications')
            ->where('id', $clinicId)
            ->first();

        return view(
            'layouts.clinic.clinic_form_view',
            compact('clinic')
        );
    }




    public function reg_changename_list($id)
    {
        if (!Session::has('id')) {
            return redirect()->route('admin.loginssaform');
        }

        $decryptedId = Crypt::decryptString($id);

        $application = ClinicNameChangeApplication::where('id', $decryptedId)
            ->whereIn('clinic_type', [
                'ARTCLINIC',
                'ARTBANK',
                'ARTSURROGACY'
            ])
            ->firstOrFail();


        $clinic_data = ClinicRegistrationModel::where('clinic_id', $application->clinic_id)
            ->where('status', 1)

            ->first();
    
        $click_app = DB::table('clinic_name_change_applications')
            ->where('id', $decryptedId)
            ->first();


        if (!$click_app) {
            abort(404, 'Application not found');
        }

        $clickID = $click_app->id;

        $receivedssaartformList = ClinicNameChangeApplication::where('id', $clickID)
            ->first();

        $documents = DB::table('clinic_name_change_documents')
            ->where('application_id', $clickID)
            ->get();

        return view(
            'layouts.admin.changeartclinic_ssa_form_list',
            compact(
                'receivedssaartformList',
                'documents',
                'clinic_data',
                'application'
            )
        );
    }



    public function changename_artclinic_submitForm(Request $request)
    {


        try {

            Log::info('Controller: clinic change name called.');

            DB::beginTransaction();



            $sclinicId = $request->id;


            $receivedForm = ClinicNameChangeApplication::findOrFail($sclinicId);

            $clinicType = strtoupper($receivedForm->clinic_type);
            $fileField = [
                'artsurrogacy' => 'reg_surrogacyclinic_certificate',
                'artclinic'    => 'reg_artclinic_certificate',
                'artbank'      => 'reg_artbank_certificate',
            ][strtolower($clinicType)] ?? null;
            // dd($request->all());
            $request->validate([
                'approved_rejected' => 'required',
                'rejection_no' => 'nullable|required_if:approved_rejected,Request Rejected',

                $fileField => 'required|mimes:pdf,jpg,jpeg,png|max:2048',

            ], [

                'approved_rejected.required' => 'Please select decision.',

                'rejection_no.required_if' => 'Rejection number is required.',

                "$fileField.required" => 'Registration certificate is required.',
                "$fileField.mimes" => 'Only pdf, jpg, jpeg and png files are allowed.',
                "$fileField.max" => 'File size must be less than 2MB.',
            ]);

            $dateReg = $request->date_reg;

            $allowedExtensions = ['pdf'];
            $timestamp = date('Y-m-d_His');


            $clinicType2 = strtolower($clinicType);


            $fileFieldMap = [
                'artsurrogacy' => 'reg_surrogacyclinic_certificate',
                'artclinic' => 'reg_artclinic_certificate',
                'artbank'   => 'reg_artbank_certificate',
            ];

            $targetFilePrefix = [
                'artsurrogacy' => 'target_file_reg_surrogacyclinic_certificate',
                'artclinic' => 'target_file_reg_artclinic_certificate',
                'artbank'   => 'target_file_reg_artbank_certificate',
            ];

            $rejectedFilePrefix = [
                'artsurrogacy' => 'target_file_rejected_surrogacyclinic_certificate',
                'artclinic' => 'target_file_rejected_artclinic_certificate',
                'artbank'   => 'target_file_rejected_artbank_certificate',
            ];


            $fileField = $fileFieldMap[$clinicType2] ?? 'reg_surrogacyclinic_certificate';
            $regPrefix = $targetFilePrefix[$clinicType2] ?? 'target_file_reg_surrogacyclinic_certificate';
            $rejPrefix = $rejectedFilePrefix[$clinicType2] ?? 'target_file_rejected_surrogacyclinic_certificate';

            $fileField = $fileFieldMap[$clinicType2];



            $request->validate([
                $fileField => "required|file|mimes:pdf|max:2048"
            ]);
            $file = $request->file($fileField);



            $originalExtension = strtolower($file->getClientOriginalExtension());

            if (!in_array($originalExtension, $allowedExtensions)) {
                throw new \Exception("File type not allowed. Allowed types are: " . implode(', ', $allowedExtensions));
            }


            $filename = $regPrefix . $timestamp . '_' . $receivedForm->id . '.' . $originalExtension;
            $dbpath = $filename;


            if ($request->approved_rejected === 'Request Rejected') {


                $filename = $rejPrefix . $timestamp . '_' . $receivedForm->id . '.' . $originalExtension;
                $applicationFolder = str_replace('/', '_', $receivedForm->applicationno);

                $foldername = 'application_sa';
                $baseDir = folderpath($foldername);
                $fullFolderPath = $baseDir . $applicationFolder;

                DB::table('clinic_name_change_applications')
                    ->where('id', $sclinicId)
                    ->update([
                        'appstatus' => 'Rejected',
                        'app_date_recieve' => $request->app_date_recieve,
                    ]);

                if (!File::exists($fullFolderPath)) {
                    File::makeDirectory($fullFolderPath, 0755, true);
                }



                $updateData = [


                    'approved_rejected' => $request->approved_rejected,

                    'date_of_reg' => !empty($dateReg)
                        ? date('Y-m-d', strtotime($dateReg))
                        : null,


                    'date_of_rej' => !empty($request->date_rej)
                        ? date('Y-m-d', strtotime($request->date_rej))
                        : null,

                    'rejection_no' => !empty($request->rejection_no)
                        ? $request->rejection_no
                        : null,
                     'appstatus' => 'Rejected',
                     'reason_for_rejection' => $request->reason_for_rejection,
                     'app_rejected_by_ip' => request()->ip(),
                     'app_rejected_by_id' => Session::get('id'),
                       'state_request_rejected_datetime' => now(),





                ];

                ClinicNameChangeApplication::where('id', $sclinicId)
                    ->update($updateData);
            } else {

                $this->insertChnageNameData(
                    $receivedForm,
                    $request,
                    $sclinicId,
                    $clinicType
                );
            }

            DB::commit();
            $state_user =  user::with('state')->where('id', Session::get('id'))->first();
            $application = [
                'name' => $receivedForm->name,
                'application_no' => $receivedForm->application_no,
                'registration_no' => $request->input('approved_rejected') == 'Request Accepted' ? $receivedForm->registration_no : $request->rejection_no,
                'status' => $request->input('approved_rejected') == 'Request Accepted' ? 'Approved' : 'Rejected',
                'certificate_valid_date' => $request->input('approved_rejected') == 'Request Accepted' ? '' : null,
                'reg_rej_date' => $request->input('approved_rejected') == 'Request Accepted' ? $request->app_date_recieve : $request->date_rej,
                'state_name' => $state_user->state->state_name,
                'state_email' => $state_user->email,

            ];
            Mail::to($receivedForm->email)->send(new ChangeNameApproveRejectedMail($application));
            $encryptId = Crypt::encryptString($clinicType);

            return redirect()->route('admin.change_name', [
                'type' => $encryptId
            ])->with('upd_success', 'Change Name Application has been ' . ($request->input('approved_rejected') == 'Request Accepted' ? 'Approved' : 'Rejected') . '');
        } catch (\Illuminate\Validation\ValidationException $e) {

            DB::rollBack();
            Log::error("Clinic validation failed: " . $e->getMessage());
            return back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error("Clinic {$clinicType} certificate update failed: " . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    private function insertChnageNameData($receivedForm, $request, $sclinicId, $clinicType)
    {
        $allowedExtensions = ['pdf'];
        $timestamp = date('Y-m-d_His');


        $clinicType2 = strtolower($clinicType);


        $fileFieldMap = [
            'artsurrogacy' => 'reg_surrogacyclinic_certificate',
            'artclinic' => 'reg_artclinic_certificate',
            'artbank'   => 'reg_artbank_certificate',
        ];

        $targetFilePrefix = [
            'artsurrogacy' => 'target_file_reg_surrogacyclinic_certificate',
            'artclinic' => 'target_file_reg_artclinic_certificate',
            'artbank'   => 'target_file_reg_artbank_certificate',
        ];

        $rejectedFilePrefix = [
            'artsurrogacy' => 'target_file_rejected_surrogacyclinic_certificate',
            'artclinic' => 'target_file_rejected_artclinic_certificate',
            'artbank'   => 'target_file_rejected_artbank_certificate',
        ];


        $fileField = $fileFieldMap[$clinicType2] ?? 'reg_surrogacyclinic_certificate';
        $regPrefix = $targetFilePrefix[$clinicType2] ?? 'target_file_reg_surrogacyclinic_certificate';
        $rejPrefix = $rejectedFilePrefix[$clinicType2] ?? 'target_file_rejected_surrogacyclinic_certificate';

        $fileField = $fileFieldMap[$clinicType2];



        $request->validate([
            $fileField => "required|file|mimes:pdf|max:2048"
        ]);
        $file = $request->file($fileField);



        $originalExtension = strtolower($file->getClientOriginalExtension());

        if (!in_array($originalExtension, $allowedExtensions)) {
            throw new \Exception("File type not allowed. Allowed types are: " . implode(', ', $allowedExtensions));
        }


        $filename = $regPrefix . $timestamp . '_' . $receivedForm->id . '.' . $originalExtension;
        $dbpath = $filename;



        if ($request->input('approved_rejected') == 'Request Rejected') {

            $filename = $rejPrefix . $timestamp . '_' . $receivedForm->id . '.' . $originalExtension;
            $applicationFolder = str_replace('/', '_', $receivedForm->applicationno);

            $foldername = 'application_sa';
            $baseDir = folderpath($foldername);
            $fullFolderPath = $baseDir . $applicationFolder;

            DB::table('clinic_name_change_applications')
                ->where('id', $sclinicId)
                ->update([
                    'appstatus' => 'Rejected',
                    'app_date_recieve' => $request->app_date_recieve,
                ]);

            if (!File::exists($fullFolderPath)) {
                File::makeDirectory($fullFolderPath, 0755, true);
            }

            $file->move($fullFolderPath, $filename);
        } else if ($request->input('approved_rejected') == 'Request Accepted') {
            $foldername = 'clinic_registration_certificate';
            $docMasters = DB::table('doc_masters')
                ->whereIn('doc_type', [$regPrefix])
                ->where('status', 1)
                ->first();

            $destinationPath = folderpath($foldername);

            $clinic_id_gen = $receivedForm->clinic_id;
            $fullFolderPath = $destinationPath . '' . $clinic_id_gen;

            if (!File::exists($fullFolderPath)) {
                File::makeDirectory($fullFolderPath, 0755, true);
            }

            $file->move($fullFolderPath, $filename);
            $dbpath = $filename;
            DB::table('clinic_name_change_applications')
                ->where('id', $sclinicId)
                ->where('userid', $receivedForm->userid)
                ->update([
                    'appstatus' => 'Approved',

                    'app_date_recieve' => $request->app_date_recieve,
                    'approved_rejected' => 'Request Accepted'
                ]);

            // Insert uploaded doc record
            if ($docMasters) {
                DB::table('change_name_doc_file_uploads_registration_certificate')->insert([
                    //'userid' => $receivedForm->userid,
                    'clinic_id' => $receivedForm->clinic_id,
                    'app_id' => $sclinicId,
                    'doc_id' => $docMasters->id,
                    'doc_type' => $docMasters->doc_type,
                    'doc_upload_ref' => $dbpath,
                ]);
            }



            $clinic = ClinicRegistrationModel::where('clinic_id', $receivedForm->clinic_id)
                ->where('status', 1)
                ->first();
            //dd($clinic,$receivedForm);
            if ($clinic) {
                $clinic->update([
                    'status' => 0,
                    'last_updated_by' => Session::get('id'),
                    'action_taken_ip' => $request->ip(),
                ]);
            }
            $data = [
                'level' => $receivedForm->level,
                'clinic_id' => $receivedForm->clinic_id,
                'name' => $receivedForm->proposed_clinic_name,
                'address' => $receivedForm->address,
                'state' => $receivedForm->state,
                'district' => $receivedForm->district,
                'pincode' => $receivedForm->pincode,
                'mobile' => $clinic->mobile,
                'email' => $receivedForm->email,
                'nature' => $receivedForm->nature,
                'contact_number_clinic' => $receivedForm->contact_number_clinic,
                'fax_number' => $clinic->fax_number,
                'apply_registration' => $clinic->apply_registration,
                'website' => $clinic->website,
                'date_of_establishment' => $clinic->date_of_establishment,
                'clinic_reg_mpt' => $clinic->clinic_reg_mpt,
                'clinic_reg_pcpndt' => $clinic->clinic_reg_pcpndt,
                'clinic_director' => $clinic->clinic_director,
                'iui_h_s' => $clinic->iui_h_s,
                'iui_d_s' => $clinic->iui_d_s,
                'ivf_et' => $clinic->ivf_et,
                'icsi' => $clinic->icsi,
                'pgt' => $clinic->pgt,
                'sperm_oocyte' => $clinic->sperm_oocyte,
                'any_other_procedure' => $clinic->any_other_procedure,
                'otherprocedure' => $clinic->otherprocedure,
                'contact_person_name' => $clinic->contact_person_name,
                'contact_person_email' => $clinic->contact_person_email,
                'any_other_detail' => $clinic->any_other_detail,

                // BANK
                'ejaculation' => $clinic->ejaculation,
                'electrojaculation' => $clinic->electrojaculation,
                'processing_sperm' => $clinic->processing_sperm,
                'storage_sperm' => $clinic->storage_sperm,
                'oocyte_doner' => $clinic->oocyte_doner,
                'cryopreservation_of_sperm' => $clinic->cryopreservation_of_sperm,
                'methode_of_freezing_of_sperm' => $clinic->methode_of_freezing_of_sperm,
                'sperm_vitrification' => $clinic->sperm_vitrification,
                'freezing_of_testicular_tissue' => $clinic->freezing_of_testicular_tissue,
                'application_no' => $receivedForm->application_no,
                'registration_no' => $receivedForm->registration_no,
                'certificate_path' => $dbpath,
                'status' => 1,
                'clinic_type' => $clinicType,
                'userid_applicant' => $clinic->userid_applicant,
                'rgistration_date' => $clinic->rgistration_date,
                'state_authority_id' => Session::get('id'),
                'verify_certificate' => 1,
                'created_date' => now(),
                'updated_at' => now(),
                'validitydate' => now(),
                'last_updated_by' => Session::get('id'),
                'ip_address' => getHostByName(getHostName()),
                'action_taken_by' => Session::get('id'),
                "action_taken_ssa_datetime" => now(),
                'application_type' => 8,
                "action_taken_ip"  => request()->ip(),
                "first_registration_date" => $receivedForm->first_registration_date ?? '',
            ];
            // dd($data);
            DB::table('clinic_registration')->insert($data);
        }
    }


    public function generatePdf($id)
    {
        
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $ssaId = false;
        try {
            $applicationId = Crypt::decryptString($id);
        } catch (\Exception $e) {

            throw new NotFoundHttpException('Invalid or expired link.');
        }
        if (Session::get('user_type') < 4) {
            $ses_id = Session::get('id');
            $user = Signup::where('email', session('email'))->first();
            if (!$user) {
                abort(404, 'User not found.');
            }
        } elseif (Session::get('user_type') == 5) {

            $ssaId = Session::get('id');
            $adminuser = user::where('email', session('email'))->first();
            $ses_id = ClinicNameChangeApplication::where('id', $applicationId)
                ->where('state', Session::get('state_name'))
                ->where('status', 1);

            // dd($ses_id);
            // $ses_id = Session::get('id');
            if (!$adminuser) {
                abort(404, 'User not found.');
            }
        }

        $applicationId = Crypt::decryptString($id);
        $application = ClinicNameChangeApplication::where('id', $applicationId)->where('status', 1)->first();

        if (!$application) {
            abort(404, 'Application not found.');
        }



        $pdf = Pdf::loadView(
            'layouts.clinic.change_name.application_pdf',
            compact('application')
        );

        return $pdf->stream('application_pdf.pdf');
    }
}
