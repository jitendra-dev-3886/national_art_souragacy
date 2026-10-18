<?php
namespace App\Http\Controllers\Clinic;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Admin\user;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\clinic\signup;
use App\Models\clinic\SurrogacyClinicModel;
use App\Models\clinic\SurrogacyClinicApplicationNo;
use App\Models\clinic\SurrogacyClinicDirectorModel;
use App\Models\clinic\SurrogacyClinicEquipmentModel;
use App\Models\clinic\SurrogacyClinicOtherStaffModel;
use App\Http\Requests\SurrogacyClinicRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class SurrogacyClinicController extends Controller
{
    public function surrogacyapplicationform(Request $request)
    {
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }

        $email = $request->session()->get('email');
        $user = signup::where('email', $email)->first();
        $userId = Session::get('id');

        // Load user profile with surrogacy clinic relation
    
        // $user_profile = signup::with('surrogacyclinics.sapp_no')->where('id', $userId)->first();
        $user_profile = SurrogacyClinicModel::where('userid', $userId)->first();
        // dd($user_profile);
        // Get clinic data (either draft or submitted)
        $clinicForm = SurrogacyClinicModel::where('userid', $userId)
            ->orderByDesc('id')
            ->first();
        // dd($clinicForm);
        if ($clinicForm) {
            if ($clinicForm->status == 1) {
                // Already submitted — show view-only
                $cryId = Crypt::encrypt($clinicForm->id);
                $isFormFilled = $this->sclinicForm_view($cryId);
                // dd("test0");
                $signup_data = $isFormFilled['signup_data'];
                $application = $isFormFilled['application'];
                $directors = $isFormFilled['directors'];
                $staff = $isFormFilled['staff'];
                $equipment = $isFormFilled['equipment'];

                return view('layouts.clinic.surrogacy_clinic_form_view', compact(
                    'signup_data',
                    'application',
                    'directors',
                    'staff',
                    'equipment'
                ));
            } else {
                // Draft exists — load data into form
                $directors = SurrogacyClinicDirectorModel::where('surrogacyclinic_id', $clinicForm->id)->get();
                // dd($directors);
                $staff = SurrogacyClinicOtherStaffModel::where('surrogacyclinic_id', $clinicForm->id)->get()->toArray();
            //   dd($staff);
                $equipment = SurrogacyClinicEquipmentModel::where('surrogacyclinic_id', $clinicForm->id)->get();
                $clinicForm->address = htmlspecialchars_decode($clinicForm->address);
            // dd($equipment);
                return view('layouts.clinic.add_surrogacy_application_form', [
                    'tab' => $request->input('tab', 1),
                    'signup' => $user,
                    'user_profile' => $user_profile,
                    'draft' => $clinicForm,
                    'directors' => $directors,
                    'staff' => $staff,
                    'equipment' => $equipment,
                ]);
            }
            }

            // No draft or submission — fresh form
            // return view('layouts.clinic.add_surrogacy_application_form', [
            //     'tab' => $request->input('tab', 1),
            //     'signup' => $user,
            //     'user_profile' => $user_profile
            // ]);

            return view('layouts.clinic.add_surrogacy_application_form', [
                'tab'         => $request->input('tab', 1),
                'signup'      => $user,
                'user_profile'=> $user_profile,
                'draft'       => null,         // null instead of undefined
                'directors'   => collect(),    // empty collection (safe for foreach)
                'staff'       => collect(),    // empty collection
                'equipment'   => collect(),    // empty collection
            ]);
    }

    public function surrogacyrenewalapplicationform(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }

        // $countries = countrytable::all();
        // Fetch records from requesttable for the logged-in user

        $email = $request->session()->get('email');
        $user = signup::where('email', $email)->first();

        $get_id = Session::get('id');
        // Fetch the user profile based on the user ID
        $user_profile = signup::with('surrogacyclinics.sapp_no')->where('id', $get_id)->first();
        $certificate_expiry_date = Carbon::parse(@$user_profile->surrogacyclinics->sapp_no->surrogacyclinic_id->validity_upto);
        $today = Carbon::now();
        $daysDifference = $certificate_expiry_date->diffInDays($today);
        //dd($daysDifference);
        if ($daysDifference > 0) {
            return view('layouts.clinic.surrogacy_certificate_expirealert', ['show_modal' => true], compact('daysDifference'));
        } else {
            return view('layouts.clinic.surrogacy_certificate_renewal',['show_modal' => true]);
        }
        // else{



        // dd($user);
        // $requesttable=requesttable::get();
        //return view('layouts/noc/add_noc_application_form', ['tab' => $request->input('tab', 1),'countries'=>$countries,'requesttable' => $user]);
        // } //return view('layouts/noc/add_noc_application_form');
    }
public function sclinicapplicationformSubmit(SurrogacyClinicRequest $request)
{
    //   dd($request->all());
    $user = signup::where('email', session('email'))->first();
    if (!$user) {
        return redirect()->route('clinic.loginclinicform');
    }

    $userId = Session::get('id');
    //   get SurrogacyClinicModel for this user
        $surrogacy = SurrogacyClinicModel::where('userid', $userId)->first();
    if ($surrogacy) {
        // Surrogacy record exists
        $u_id = $surrogacy->userid;
    } else {
    $u_id = $user->id;
    }
        $submitType = $request->input('submit_type'); // 'draft' or 'final'

    
    try {
        DB::beginTransaction();
        // ✅ Always reuse existing draft (status=0) for this user, else create new
        $sClinic = SurrogacyClinicModel::firstOrNew(
            ['userid' => $u_id, 'status' => 0]
        );
        // Fill common fields
        $sClinic->fill($request->all());
        $sClinic->address = htmlspecialchars($request->address, ENT_QUOTES, 'UTF-8');
        $sClinic->email = $request->input('email_clinic');
        $sClinic->contact_person_name = $request->input('personname');
        $sClinic->contact_person_mobile = $request->input('mobilecontact');
        $sClinic->contact_person_email = $request->input('emailcontact');

    //    dd($sClinic);
        $sClinic->status = ($submitType === 'draft') ? 0 : 1;
        // dd( $sClinic->status);
        $sClinic->save();

        // surrogacyclinic_id
        $sclinic_id = $sClinic->id;

        //  Clean old related data (so that update replaces instead of duplicating)
        //  DB::enableQueryLog();
        SurrogacyClinicDirectorModel::where('surrogacyclinic_id', $sclinic_id)->delete();
       //  dd(DB::getQueryLog());
        SurrogacyClinicOtherStaffModel::where('surrogacyclinic_id', $sclinic_id)->delete();
        SurrogacyClinicEquipmentModel::where('surrogacyclinic_id', $sclinic_id)->delete();

        // Save directors
      
        if ($request->director === 'Yes' && is_array($request->name_director)) {
            $newDirectors = [];
            foreach ($request->name_director as $key => $directorName) {
                $newDirectors[] = [
                    'name_director'     => $directorName,
                    'quali_director'    => $request->quali_director[$key] ?? null,
                    'reg_director'      => $request->reg_director[$key] ?? null,
                    'userid'            => $u_id,
                    'surrogacyclinic_id'=> $sclinic_id,
                ];
            }
            if (!empty($newDirectors)) {
                SurrogacyClinicDirectorModel::insert($newDirectors);
            }
            else {
            // If "No" is selected, ensure no directors remain in DB for this draft
            SurrogacyClinicDirectorModel::where('surrogacyclinic_id', $sclinic_id)->delete();
                }
        }

        // Save staff
        if (is_array($request->post_otherstaff)) {
            $staffData = [];
            foreach ($request->post_otherstaff as $k => $staff) {
                $postValue  = ($staff === 'Any Other') ? $request->anyotherpost[$k] : $staff;
                $qualiValue = ($request->quali_otherstaff[$k] === 'Any Other') ? $request->anyotherdegree[$k] : $request->quali_otherstaff[$k];

                $staffData[] = [
                    'post_otherstaff'   => $postValue,
                    'name_otherstaff'   => $request->name_otherstaff[$k] ?? null,
                    'regno'             => $request->regno[$k] ?? null,
                    'quali_otherstaff'  => $qualiValue,
                    'surrogacyclinic_id'=> $sclinic_id,
                    'userid'            => $u_id,
                ];
            }
            if (!empty($staffData)) {
                SurrogacyClinicOtherStaffModel::insert($staffData);
            }
        }

        // Save equipment
        if (is_array($request->equipmentname)) {
            $equipData = [];
            foreach ($request->equipmentname as $e => $equipment) {
                $equipData[] = [
                    'equipmentname'     => $equipment,
                    'surrogacyclinic_id'=> $sclinic_id,
                    'userid'            => $u_id,
                ];
            }
            if (!empty($equipData)) {
                SurrogacyClinicEquipmentModel::insert($equipData);
            }
        }

        // Only generate application number for final submit
        if ($submitType === 'final') {
            $year = Carbon::now()->year;
            $state = $request->input('state');
            $su_id = DB::table('state')
                ->where('state_name', $state)
                ->orderBy('state_name')
                ->value('state_abb');

            $latestApplication = SurrogacyClinicApplicationNo::orderBy('id', 'desc')->first();
            if ($latestApplication) {
                $ano = $latestApplication->applicationno;
                $ano_sub = substr($ano, -5);
                $getnumbers = str_replace("/", "", $ano_sub);
                $no_increase = $getnumbers + 1;
                $get_string = str_pad($no_increase, 5, '0', STR_PAD_LEFT);
                $enumber = $su_id . '/SC/' . $year . '/' . $get_string;
            } else {
                $enumber = $su_id . '/SC/' . $year . '/10001';
            }

            $sApplicationNo = new SurrogacyClinicApplicationNo();
            $sApplicationNo->applicationno = $enumber;
            $sApplicationNo->surrogacy_id =  $sclinic_id;
            $sApplicationNo->save();

            $sClinic->update([
                'applicationno' => $enumber,
                'applicationno_datetime_submission' => now()
            ]);
        }

        DB::commit();

        return $submitType === 'draft'
            ? redirect()->route('clinic.add_surrogacy_application_form')->with('success', 'Draft saved successfully.')
            : redirect()->route('clinic.application.surrogacy_success')->with('success', 'Surrogacy Clinic Application Submitted Successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        // Optional: log error for debugging
        Log::error('Surrogacy form submit failed: '.$e->getMessage());
        return response()->view('errors.500', [], 500);
    //      Log::error('Surrogacy form submit failed: ' . $e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine());
    // return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}



    public function sshowSuccessPage(Request $request)
    {
        // $ses_id = Session::get('id');
        // $ses_UID = Session::get('userid');
        // dd($ses_id);

        $ses_id = Session::get('id'); // ID from session
    //    dd($ses_id);
        // $signup = signup::find($ses_id); // Fetch Signup record
        $signup = SurrogacyClinicModel::where('userid', $ses_id)->first(); 

    //   dd($signup);

        // $artclinicIds = $signup->artclinics->pluck('id'); // Fetch related Artclinic IDs
        // $sclinicIds = $signup->surrogacyclinics->id;
         $sclinicIds = $signup->id;
    //    dd($sclinicIds);
        //dd($ses_id);
        // $applicationNo = $request->input('applicationNo');
        // dd($applicationNo);
        // $successMessage = session('success'); // Retrieve the success message from the session

        // if (!$applicationNo) {
        //     return redirect()->route('clinic.application.form')->with('error', 'Invalid application submission!');
        // }
    //    $applications = SurrogacyClinicModel::with('sapp_no')->where('id', $sclinicIds)->first();
       $applications =   SurrogacyClinicModel::where('id', $sclinicIds)
       ->where('status', 1)
       ->first();
        // dd($applications);
        // $appNo = $applications->pluck('app_no')->flatten()->pluck('id');
        // $appNo = $applications->sapp_no->applicationno;
    //    dd($appNo);
    //    $app_sclinic_id = $applications->sapp_no->surrogacy_id;

        $appNo = $applications->applicationno;  
        //  dd($appNo);   // direct column
        $app_sclinic_id = $applications->id; // direct column
//    dd($app_sclinic_id);
        return view('layouts.clinic.surrogacy_success', compact('appNo', 'applications', 'app_sclinic_id'))->with('success', 'Surrogacy Clinic Application Submitted Successfully!');
    }

    public function sclinicForm_view($id, $view = null)
    {
        // dd($id);
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        // $ses_id = Session::get('id');
        // dd($id);
        $surrogacyclinicIds = Crypt::decrypt($id);
        // dd($surrogacyclinicIds);
        $application = SurrogacyClinicModel::with('sapp_no')->where('id', $surrogacyclinicIds)->where('status',1)->get();
        $signup_data = $application[0];
        // dd($application);
        if (!$application) {
            abort(404, 'Application not found.');
        }
        $directors = SurrogacyClinicDirectorModel::where('Surrogacyclinic_id', $surrogacyclinicIds)->get();
        // dd($application);
        $staff = SurrogacyClinicOtherStaffModel::where('Surrogacyclinic_id', $surrogacyclinicIds)->get();
        $equipment = SurrogacyClinicEquipmentModel::where('Surrogacyclinic_id', $surrogacyclinicIds)->get();

        $user = signup::where('email', session('email'))->where('status', 1)->first();
        $adminuser = user::where('email',session('email'))->first();
        // dd($user);
        if (!$user && !$adminuser) {
            abort(404, 'User not found.');
        }

        if ($view == 'view') {
            
            return ['signup_data' => $application, 'application' => $application, 'directors' => $directors, 'staff' => $staff, 'equipment' => $equipment];
        }
        if($user){
            
            return view('layouts.clinic.surrogacy_clinic_form_view', compact('signup_data', 'application', 'directors', 'staff', 'equipment'));
        }
        if($adminuser)
        {
            return view('layouts.admin.surrogacy_clinic_form_view', compact('signup_data', 'application', 'directors', 'staff', 'equipment'));
        }
    }

   

    public function sclinicgeneratePdf($id)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $surrogacyclinicIds = Crypt::decrypt($id);
        $application = SurrogacyClinicModel::with('sapp_no')->where('id', $surrogacyclinicIds)->where('status',1)->get();
        $signup_data = $application[0];
        // dd($application);
        if (!$application) {
            abort(404, 'Application not found.');
        }
        $directors = SurrogacyClinicDirectorModel::where('surrogacyclinic_id', $surrogacyclinicIds)->get();
        //dd($directors);
        $staff = SurrogacyClinicOtherStaffModel::where('surrogacyclinic_id', $surrogacyclinicIds)->get();
        $equipment = SurrogacyClinicEquipmentModel::where('surrogacyclinic_id', $surrogacyclinicIds)->get();

        // $user = signup::where('email', session('email'))->first();
           $user = signup::where('email', session('email'))->where('status', 1)->first();
           $adminuser = user::where('email',session('email'))->first();
        //    dd($user);
        if (!$user && !$adminuser) {
            abort(404, 'User not found.');
        }
        $pdf = Pdf::loadView('layouts.clinic.sapplication_pdf', compact('signup_data', 'application', 'directors', 'staff', 'equipment'));
        //dd($pdf);
        // Optionally, stream or download the PDF
        return $pdf->stream('application_pdf.pdf');
        // For download: return $pdf->download('application_details.pdf');
    }
}
