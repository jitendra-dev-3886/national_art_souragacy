<?php

namespace App\Http\Controllers\Manpowers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreManpowerRequest;
use App\Models\ChangeManpower\ChangeManpowerApplication;
use App\Models\ChangeManpower\ChangeManpowerDirector;
use App\Models\ChangeManpower\ChangeManpowerStaff;
use App\Models\clinic\ArtClinicModel;
use App\Models\clinic\ArtClinicOtherStaffModel;
use App\Models\clinic\BankModel;
use App\Models\clinic\BankOtherStaffModel;
use App\Models\clinic\clinicDirectorModel;
use App\Models\clinic\ClinicEquipmentModel;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\clinic\clinicStaffModel;
use App\Models\clinic\SurrogacyClinicModel;
use App\Models\clinic\SurrogacyClinicOtherStaffModel;
use App\Models\Noc\docmastertable;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ChangeManpowerController extends Controller
{
    public function changeManpowerForm($encryptedClinicId)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        $clinicId = Crypt::decryptString($encryptedClinicId);
        

        $clinic = ClinicRegistrationModel::where('clinic_id', $clinicId)
            ->where('userid_applicant', $userId)
            ->where('status', 1)
            ->first();
        $title = 'ART '.ucwords(strtolower(str_replace('ART', '', $clinic->clinic_type))).' Application form for Change Manpower';
        $clinicDirector = clinicDirectorModel::where('clinic_id', $clinicId)->where('status', 1)->get();
        $clinic_type_abbr = $clinic->clinic_type == 'ARTSURROGACY' ? SurrogacyClinicModel::class : ($clinic->clinic_type == 'ARTBANK' ? BankModel::class : ArtClinicModel::class);
        $is_manpower_changed = ChangeManpowerApplication::where('clinic_id', $clinicId)->where('clinic_type', $clinic->clinic_type)->where('status', 1)->first();
        $is_it_old_clinic = $clinic_type_abbr::where('status', 1)->where('applicationno', $clinic->application_no)->first();
        // dd($is_it_old_clinic);
        // $clinicStaff = clinicStaffModel::where('clinic_id', $clinicId)->where('status', 1)->where('clinic_type', $clinic->clinic_type)->get();
        // dd($clinicStaff);
        if (!$is_manpower_changed && $is_it_old_clinic) {
            $clinic_type_abbr2 = $clinic->clinic_type == 'ARTSURROGACY' ? SurrogacyClinicOtherStaffModel::class : ($clinic->clinic_type == 'ARTBANK' ? BankOtherStaffModel::class : ArtClinicOtherStaffModel::class);
            $application_id = $clinic->clinic_type == 'ARTSURROGACY' ? "surrogacyclinic_id" : ($clinic->clinic_type == 'ARTBANK' ? "artbank_id" : "artclinic_id");
            $clinicStaff = $clinic_type_abbr2::where($application_id, $is_it_old_clinic->id)->get();
            foreach ($clinicStaff as $staff) {
                $staff->name = $staff->name_otherstaff;
                $staff->qualification = $staff->quali_otherstaff;
                if ($clinic->clinic_type == 'ARTCLINIC') {
                    $staff->post = $staff->post_otherstaff;
                } elseif ($clinic->clinic_type == 'ARTBANK') {
                    $staff->post = $staff->designation_otherstaff;
                } else {
                    $staff->post = $staff->post_otherstaff;
                }
            }
        } else {
            $clinicStaff = clinicStaffModel::where('clinic_id', $clinicId)->where('status', 1)->get();
        }
        $equipmentsData = ClinicEquipmentModel::where('clinic_id', $clinicId)->where('status', 1)->where('clinic_type', $clinic->clinic_type)->get();

        $drftApplicationCheck = ChangeManpowerApplication::where('clinic_id', $clinicId)->where('clinic_type', $clinic->clinic_type)->where('status', 0)->first();
        // $existPendingApplicationCheck = ChangeManpowerApplication::where('clinic_id', $clinicId)->where('clinic_type', $clinic->clinic_type)->where('status', 1)->where('app_status', 'Pending')->first();

        $clinicStaff_cm = [];
        $directors_cm = [];
        // Draft Cases Start
        if (!empty($drftApplicationCheck)) {

            $clinicStaff_cm = ChangeManpowerStaff::where('cm_id', $drftApplicationCheck->id)->where('status', 0)->get();
            $directors_cm = ChangeManpowerDirector::where('cm_id', $drftApplicationCheck->id)->where('status', 0)->get();

            $view = 'manpowers.clinic_change_manpower_form';
            $compact = compact('clinicId', 'title', 'drftApplicationCheck', 'clinicDirector', 'clinicStaff', 'equipmentsData', 'clinicStaff_cm', 'directors_cm');
        } else {
           $view = 'manpowers.clinic_change_manpower_form';

            $compact = compact('clinicId', 'title', 'clinic', 'clinicDirector', 'clinicStaff', 'equipmentsData', 'clinicStaff_cm', 'directors_cm');
        }
        return view($view, $compact);
    }
    public function submitChangeManpowerApplication(StoreManpowerRequest $request)
    {
        // dd($request->all());
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');

        $clinic = ClinicRegistrationModel::where('clinic_id', $request->input('clinic_id'))
            ->where('userid_applicant', $userId)
            ->where('status', 1)
            ->first();

        if (
            trim($clinic->clinic_id) == trim($request->input('clinic_id')) &&
            trim($clinic->clinic_type) == trim($request->input('clinic_type')) &&
            trim($clinic->registration_no) == trim($request->input('registration_no')) &&
            trim($clinic->name) == trim($request->input('clinicname')) &&
            trim($clinic->email) == trim($request->input('email')) &&
            trim($clinic->mobile) == trim($request->input('mobile')) &&
            trim($clinic->address) == trim($request->input('address')) &&
            trim($clinic->pincode) == trim($request->input('pincode')) &&
            trim($clinic->state) == trim($request->input('state')) &&
            trim($clinic->district) == trim($request->input('district')) &&
            trim($clinic->nature) == trim($request->input('nature')) &&
            trim($clinic->userid_applicant) == trim($request->input('userid_applicant'))
        ) {
            DB::beginTransaction();

            try {

                if ($request->submit_type == 'final') {

                    $lastApplication = ChangeManpowerApplication::whereNotNull('application_no')->latest()->first();
                    // dd($lastApplication);

                    $su_id = DB::table('state')
                        ->where('state_name', $clinic->state)
                        ->orderBy('state_name')
                        ->value('state_abb');
                    $year = Carbon::now()->year;
                    $clinic_type_abbr = $request->input('clinic_type') == 'ARTSURROGACY' ? 'SC' : ($request->input('clinic_type') == 'ARTBANK' ? 'AB' : 'AC');
                    if ($lastApplication) {
                        $ano = $lastApplication->application_no;
                        $ano_sub = substr($ano, -5);
                        $getnumbers = str_replace("/", "", $ano_sub);
                        $no_increase = $getnumbers + 1;
                        $get_string = str_pad($no_increase, 5, '0', STR_PAD_LEFT);
                        $applicaton_no = $su_id . '/' . $clinic_type_abbr . '/CM/' . $year . '/' . $get_string;
                    } else {
                        $applicaton_no = $su_id . '/' . $clinic_type_abbr . '/CM/' . $year . '/10001';
                    }



                    // $applicaton_no = $enumber . '/CM';
                    $status = 1; // Final submission status
                    $message = 'Change manpower application submitted successfully. '.$applicaton_no;
                    $app_status = 'Pending';
                    $manpower_url = 'clinic.clinicForm_list';
                } else {
                    $applicaton_no = NULL;
                    $status = 0; // Draft status
                    $message = 'Change manpower application saved as draft.';
                    $app_status = '';
                    $manpower_url = 'manpower.change_manpower_form';
                }

                $applicationCM = [
                    'clinic_id' => $request->input('clinic_id'),
                    'clinic_type' => $request->input('clinic_type'),
                    'registration_no' => $request->input('registration_no'),
                    'application_no' => $applicaton_no,
                    'clinicname' => $request->input('clinicname'),
                    'current_registration_date' => $request->input('current_registration_date'),
                    'email' => $request->input('email'),
                    'mobile' => $request->input('mobile'),
                    'address' => $request->input('address'),
                    'pincode' => $request->input('pincode'),
                    'clinic_director' => $request->input('director'),
                    'state' => $request->input('state'),
                    'district' => $request->input('district'),
                    'nature' =>  $request->input('nature'),
                    'level' =>  $request->input('level'),
                    'userid_applicant' => $request->input('userid_applicant'),
                    'name_signatory' => $request->input('name_signatory'),
                    'declaration_designation' => $request->input('declaration_designation'),
                    'declaration_contact' => $request->input('declaration_contact'),
                    'declaration_date' => now(),
                    'status' => $status,
                    'app_status' => $app_status,
                    'date_of_submisstion' => now(),
                    'director_checked' => $request->input('director_checked') ?? '',
                ];

                $checkChangePower = ChangeManpowerApplication::where('id', $request->input('id'))->where('clinic_id', $request->input('clinic_id'))->where('clinic_type', $request->input('clinic_type'))->where('status', 0)->first();


                if (!empty($checkChangePower)) {
                    $cmApplication = ChangeManpowerApplication::where('id', $checkChangePower->id)->update($applicationCM);
                    $lastInsertId = $checkChangePower->id;

                    ChangeManpowerStaff::where('cm_id', $lastInsertId)->where('status', 0)->delete();
                    ChangeManpowerDirector::where('cm_id', $lastInsertId)->where('status', 0)->delete();
                } else {
                    // dd($applicationCM);
                    $cmApplication = ChangeManpowerApplication::create($applicationCM);
                    $lastInsertId = $cmApplication->id;
                }

                if ($request->clinic_type != 'ARTBANK') {
                    $directors = [];
                    // Exiting Directors start
                    foreach ($request->input('name_director_existing') as $index => $name) {
                        $directors[] = [
                            'clinic_id' => $request->input('clinic_id'),
                            'cm_id' => $lastInsertId,
                            'application_no' => $applicaton_no,
                            'name_director' => $name ?? null,
                            'quali_director' => $request->input('quali_director_existing')[$index] ?? null,
                            'reg_director' => $request->input('reg_director_existing')[$index] ?? null,
                            'expiry_date' => $request->input('expiry_director')[$index] ?? null,
                            'status' => $status, // Draft status
                            'clinic_type' => $request->input('clinic_type'),
                            'type' => 'existing',
                        ];
                    }
                    // Exiting Directors End

                    // New Directors Start
                    foreach ($request->input('name_director') as $index => $name) {
                        $directors[] = [
                            'clinic_id' => $request->input('clinic_id'),
                            'cm_id' => $lastInsertId,
                            'application_no' => $applicaton_no,
                            'name_director' => $name ?? null,
                            'quali_director' => $request->input('quali_director')[$index] ?? null,
                            'reg_director' => $request->input('reg_director')[$index] ?? null,
                            'expiry_date' =>  null,
                            'status' => $status, // Draft status
                            'clinic_type' => $request->input('clinic_type'),
                            'type' => 'new',
                        ];
                        // New Directors End
                    }
                    // insert value
                    ChangeManpowerDirector::insert($directors);

                    Log::info('mainpoower director insert');
                }
                $staffs = [];
                // Exiting staff start
                foreach ($request->input('post_existing') as $index => $name) {
                    $staffs[] = [
                        'clinic_id' => $request->input('clinic_id'),
                        'cm_id' => $lastInsertId,
                        'application_no' => $applicaton_no,
                        'post' => $request->input('post_existing')[$index] ?? null,
                        'anyotherpost' => $request->input('anyotherpost_existing')[$index] ?? null,
                        'name' => $request->input('name_otherstaff_existing')[$index] ?? null,
                        'qualification' => $request->input('quali_otherstaff_existing')[$index] ?? null,
                        'anyotherdegree' => $request->input('anyotherdegree_existing')[$index] ?? null,
                        'regno' => $request->input('regno_staff_existing')[$index] ?? null,
                        'expiry_date' => $request->input('expirydate_staff_existing')[$index] ?? null,
                        'status' => $status, // Draft status
                        'clinic_type' => $request->input('clinic_type'),
                        'type' => 'existing',
                    ];
                }
                // New Staff start
                foreach ($request->input('post') as $index => $name) {
                    $staffs[] = [
                        'clinic_id' => $request->input('clinic_id'),
                        'cm_id' => $lastInsertId,
                        'application_no' => $applicaton_no,
                        'post' => $request->input('post')[$index] ?? null,
                        'anyotherpost' => $request->input('anyotherpost')[$index] ?? null,
                        'name' => $request->input('name_otherstaff')[$index] ?? null,
                        'qualification' => $request->input('qualification')[$index] ?? null,
                        'anyotherdegree' => $request->input('anyotherdegree')[$index] ?? null,
                        'regno' => $request->input('regno')[$index] ?? null,
                        'expiry_date' =>  null,
                        'status' => $status, // Draft status
                        'clinic_type' => $request->input('clinic_type'),
                        'type' => 'new',
                    ];
                }
                ChangeManpowerStaff::insert($staffs);
                Log::info('mainpoower staff insert');

                DB::commit();
                // return redirect()->route('manpower.change_manpower_form', ['encryptedClinicId' => Crypt::encryptString($request->input('clinic_id'))])->with('success', $message);
                return redirect()->route($manpower_url, ['encryptedClinicId' => Crypt::encryptString($request->input('clinic_id'))])->with('success', $message);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Clinic change Manpower exception : " . $e);
                return redirect()->route('manpower.change_manpower_form', ['encryptedClinicId' => Crypt::encryptString($request->input('clinic_id'))])->with('error', 'An error occurred while submitting the application. Please try again.');
            }
        } else {
            Log::error("Clinic change Manpower : " . $request->input('email'));
            return redirect()->route('manpower.change_manpower_form', ['encryptedClinicId' => Crypt::encryptString($request->input('clinic_id'))])->with('error', 'server side validation failed in if condition. Please try again.');
        }
    }

    public function pdfview($encryptedClinicId)
    {
        $change_manpower = Crypt::decryptString($encryptedClinicId);
        $existPendingApplicationCheck = ChangeManpowerApplication::where('id', $change_manpower)->where('status', 1)->first();
        $clinicStaff_cm = ChangeManpowerStaff::where('cm_id', $existPendingApplicationCheck->id)->where('status', 1)->get();
        $directors_cm = ChangeManpowerDirector::where('cm_id', $existPendingApplicationCheck->id)->where('status', 1)->get();

        // $view = match (strtoupper($existPendingApplicationCheck->clinic_type)) {
        //     'ARTCLINIC' => 'manpowers.clinic_change_manpower_form_pdf',
        //     'ARTBANK' => 'manpowers.bank_change_manpower_form_pdf',
        //     'ARTSURROGACY' => 'manpowers.surrogacy_change_manpower_form_pdf',
        // };
        $pdf = Pdf::loadView('manpowers.clinic_change_manpower_form_pdf', compact('existPendingApplicationCheck', 'clinicStaff_cm', 'directors_cm'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('change_manpower_application.pdf');
        // return $pdf->download('change_manpower_application.pdf'); 
    }
}
