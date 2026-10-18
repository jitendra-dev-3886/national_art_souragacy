<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArtClinicRequest;
use App\Models\Admin\user;
use App\Models\ChangeAddress\ChangeAddressApplication;
use App\Models\ChangeManpower\ChangeManpowerApplication;
use App\Models\clinic\ArtClinicDirectorModel;
use App\Models\clinic\ArtClinicEquipmentModel;
use App\Models\clinic\ArtClinicModel;
use App\Models\clinic\ArtClinicOtherStaffModel;
use App\Models\clinic\BankModel;
use App\Models\clinic\ClinicApplicationNo;
use App\Models\Clinic\ClinicNameChangeApplication;
use App\Models\clinic\signup;
use App\Models\clinic\SurrogacyClinicModel;
use App\Models\renewal\RenewalSCApplication;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ClinicApplicationController extends Controller
{
    public function clinicForm_list()
    {      
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        // Get the logged-in user ID from the session
        // dd(session()->all());
        $userId = Session::get('id');
        $clinicForms = [
            'artClinics'       => ArtClinicModel::where(['userid' => $userId, 'status' => 1])->get(),
            'bankClinics'      => BankModel::where(['userid' => $userId, 'status' => 1])->get(),
            'surrogacyClinics' => SurrogacyClinicModel::where(['userid' => $userId, 'status' => 1])->get(),
            'renewalsurrogacyClinics' => RenewalSCApplication::where(['userid' => $userId, 'status' => 1])->get(),
            'change_address' => ChangeAddressApplication::where(['userid' => $userId, 'status' => 1])->get(),
            'change_name' => ClinicNameChangeApplication::where(['userid' => $userId, 'status' => 1])->get(),
            'changeManpower'=>ChangeManpowerApplication::where(['userid_applicant'=>$userId, 'status'=>1])->get(),
        ]; 
        //dd($clinicForms);       

        // dd($clinic_reg);
        // Fetch only the NOC applications submitted by the current user
        // $nocformList = nocform::where('noc_userid', $userId)
        //     ->orderBy('id', 'desc')
        //     ->get();
        //$nocformList = nocform::orderBy('id', 'desc')->get();
        //$data = new UserNoc();
        // $nocformList = $data->myapplication($userId);
        //return view('layouts.clinic.clinic_form_list', compact('clinicformList'));
        // Retrieve the user ID from the session
        // $userId = Session::get('id');

        // Return the clinic form list view
        //return view('layouts.clinic.clinic_form_list', ['userId' => $userId]);
        return view('layouts.clinic.clinic_form_list', compact('userId', 'clinicForms'));

        // return view('clinic.clinic_form_list');
    }

    public function clinicapplicationform(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        
        // $countries = countrytable::all();
        // Fetch records from requesttable for the logged-in user       
        
        $userId = Session::get('id');
        $email = $request->session()->get('email');
        $check_user = signup::where('email', $email)->first();
        $clinic_details = ArtClinicModel::where('userid', $userId)->first();
        // dd($clinic_details);
        if($clinic_details){
            if($clinic_details->applicationno !== NULL && $clinic_details->status == 1){
                return redirect()->route('clinic.clinicForm_view', ['id' => encrypt($clinic_details->id)]);

            }elseif($clinic_details->applicationno == NULL && $clinic_details->status == 0){
                $draft = ArtClinicModel::where('status',0)->where('applicationno',NULL)->where('userid', $userId)->where('id', $clinic_details->id)->first();
              

                $directors = ArtClinicDirectorModel::where('artclinic_id', $clinic_details->id)->get();
                // dd($directors);
      
                $staff = ArtClinicOtherStaffModel::where('artclinic_id', $clinic_details->id)->get();
       
                $equipment = ArtClinicEquipmentModel::where('artclinic_id', $clinic_details->id)->get();
                
                $user_profile = signup::with('artclinics.app_no')->where('id', $userId)->first();
                
                return view('layouts/clinic/add_clinic_application_form', ['tab' => $request->input('tab', 1), 'draft' => $draft, 'director' => $directors, 'staff' => $staff, 'equipment' => $equipment], compact('user_profile'));
            }
        }elseif($check_user){
            $user = signup::where('email', $email)->first();
            $user_profile = signup::with('artclinics.app_no')->where('id', $userId)->first();

            return view('layouts/clinic/add_clinic_application_form', ['tab' => $request->input('tab', 1), 'signup' => $user], compact('user_profile'));
        }

        
    }

    public function clinicapplicationformSubmit(ArtClinicRequest $request)
    {  
        // dd($request);
        $user = signup::where('email', session('email'))->first();
        if (!$user) {
            return redirect()->route('clinic.loginclinicform');
        }
        $u_id = $user->id;
        $id = $request->input('id');
        $person_name = $user->personname;
        try {
            DB::beginTransaction();
            if (!empty($id)) {
                $artClinic = ArtClinicModel::where('id', $id)->first();
            } else {
                $artClinic = ArtClinicModel::where('userid', $u_id)->first();
            }

            if ($artClinic) {
                $artclinic_id = $artClinic->id;
                ArtClinicDirectorModel::where('artclinic_id', $artclinic_id)->delete();
                ArtClinicOtherStaffModel::where('artclinic_id', $artclinic_id)->delete();
                ArtClinicEquipmentModel::where('artclinic_id', $artclinic_id)->delete();
                ClinicApplicationNo::where('clinic_id', $artclinic_id)->delete();

                $artClinic->fill($request->all());
            } else {
                // New clinic
                $artClinic = new ArtClinicModel();
                $artClinic->userid = $u_id;
                $artClinic->fill($request->all());
            }

            // Status set
            if ($request->input('common') == 'submit') {
                $artClinic->status = 1;

            } elseif ($request->input('common') == 'draft') {
                $artClinic->status = 0;
                
            }

            // Extra fields set
            $artClinic->email = $request->input('email_clinic');
            $artClinic->contact_person_name = $request->input('personname');
            $artClinic->contact_person_mobile = $request->input('mobilecontact');
            $artClinic->contact_person_email = $request->input('emailcontact');
            $artClinic->save();

            $artclinic_id = $artClinic->id; 
            $directorData = $request->name_director;
            $newDirectors = [];
            if ($request->director == 'Yes' && is_array($directorData)) {
                foreach ($directorData as $key => $directorName) {
                    $newDirectors[] = [
                        'name_director' => $directorName,
                        'quali_director' => $request->quali_director[$key],
                        'reg_director' => $request->reg_director[$key],
                        'userid' => $u_id,
                        'artclinic_id' => $artclinic_id
                    ];
                }
                ArtClinicDirectorModel::insert($newDirectors);
            }

            $postData = $request->post_otherstaff;
            $anyOtherPostData = $request->anyotherpost;
            $anyOtherDegreeData = $request->anyotherdegree;
            if (is_array($postData)) {
                $staffData = [];
                foreach ($postData as $k => $staff) {
                    $postValue = ($staff === 'Any Other') ? $anyOtherPostData[$k] : $staff;
                    $qualiValue = ($request->quali_otherstaff[$k] === 'Any Other') ? $anyOtherDegreeData[$k] : $request->quali_otherstaff[$k];
                    $staffData[] = [
                        'post_otherstaff' => $postValue,
                        'name_otherstaff' => $request->name_otherstaff[$k],
                        'regno' => $request->regno[$k],
                        'quali_otherstaff' => $qualiValue,
                        'regno' => $request->regno[$k],
                        'artclinic_id' => $artclinic_id,
                        'userid' => $u_id,
                    ];
                }
                ArtClinicOtherStaffModel::insert($staffData);
            }

            $equipmentData = $request->equipmentname;
            if (is_array($equipmentData)) {
                $equipData = [];
                foreach ($equipmentData as $e => $equipment) {
                    $equipData[] = [
                        'equipmentname' => $equipment,
                        'artclinic_id' => $artclinic_id,
                        'userid' => $u_id,
                    ];
                }
                ArtClinicEquipmentModel::insert($equipData);
            }

            if ($request->input('common') == 'submit') {
                $year = Carbon::now()->year;
                $state = $user->state;
                $su_id = DB::table('state')
                    ->where('state_name', $state)
                    ->orderBy('state_name')
                    ->value('state_abb');

                $latestApplication = ClinicApplicationNo::orderBy('id', 'desc')->first();
                if ($latestApplication) {
                    $ano = $latestApplication->applicationno;
                    $ano_sub = substr($ano, -5);
                    $getnumbers = str_replace("/", "", $ano_sub);
                    $no_increase = $getnumbers + 1;
                    $get_string = str_pad($no_increase, 5, '0', STR_PAD_LEFT);
                    $enumber = $su_id . '/AC/' . $year . '/' . $get_string;
                } else {
                    $enumber = $su_id . '/AC/' . $year . '/10001';
                }

                $clinicApplicationNo = new ClinicApplicationNo;
                $clinicApplicationNo->applicationno = $enumber;
                $clinicApplicationNo->clinic_id = $artclinic_id;
                $clinicApplicationNo->save();

                ArtClinicModel::where('id', $artclinic_id)->update([
                    'applicationno' => $enumber,
                    'applicationno_datetime_submission' => now()
                ]);

                DB::commit();
                return redirect()->route('clinic.application.success')
                    ->with('success', 'ART Clinic Application Submitted Successfully!');
            } else {
                DB::commit();
                return redirect()->route('clinic.clinicForm_list')
                    ->with('success', 'ART Clinic Application Saved as Draft Successfully!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
            return response()->view('errors.500', [], 500);
        }

        
    }

    public function showSuccessPage(Request $request)
    {
        // $ses_id = Session::get('id');
        // $ses_UID = Session::get('userid');
        // dd($ses_id);

        $ses_id = Session::get('id'); // ID from session
        //dd($ses_id);
        $signup = signup::find($ses_id); // Fetch Signup record

        //dd($ses_id);

        // $artclinicIds = $signup->artclinics->pluck('id'); // Fetch related Artclinic IDs
        $artclinicIds = $signup->artclinics->id;

        //dd($artclinicIds);
        //dd($ses_id);
        // $applicationNo = $request->input('applicationNo');
        // dd($applicationNo);
        // $successMessage = session('success'); // Retrieve the success message from the session

        // if (!$applicationNo) {
        //     return redirect()->route('clinic.application.form')->with('error', 'Invalid application submission!');
        // }
        $applications = ArtClinicModel::with('app_no')->where('id', $artclinicIds)->first();
        //dd($applications);
        // $appNo = $applications->pluck('app_no')->flatten()->pluck('id');
        $appNo = $applications->app_no->applicationno;
        $app_clinic_id = $applications->app_no->clinic_id;
        //dd($app_clinic_id);
        return view('layouts.clinic.success', compact('appNo', 'applications', 'app_clinic_id'))->with('success', 'ART Clinic Application Submitted Successfully!');
    }

    public function clinicForm_view($id, $view = null)
    {

                $user = signup::where('email', session('email'))->first();
        //dd($id);
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
       
        $artclinicIds = Crypt::decrypt($id);
        // dd($artclinicIds);
        $application = ArtClinicModel::with('app_no')
    ->where('id', $artclinicIds)
    ->where('userid', $user->id)
    ->firstOrFail();
        if (!$application) {
            abort(404, 'Application not found.');
        }

        $directors = ArtClinicDirectorModel::where('artclinic_id', $artclinicIds)->get();
        //dd($directors);
        $staff = ArtClinicOtherStaffModel::where('artclinic_id', $artclinicIds)->get();
        $equipment = ArtClinicEquipmentModel::where('artclinic_id', $artclinicIds)->get();

        $adminuser = user::where('email',session('email'))->first();
        // dd($adminuser);
        if (!$user && !$adminuser) {
            abort(404, 'User not found.');
        }

        if ($view == 'view') {

            return ['application' => $application, 'directors' => $directors, 'staff' => $staff, 'equipment' => $equipment];
        }
        if($user){
            return view('layouts.clinic.clinic_form_view', compact('application', 'directors', 'staff', 'equipment'));
        }
        if($adminuser)
        {
            return view('layouts.admin.clinic_form_view', compact('application', 'directors', 'staff', 'equipment'));
        }

        
    }

    public function clinicgeneratePdf($id)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $artclinicIds = Crypt::decrypt($id);

        $application = ArtClinicModel::with('app_no')->where('id', $artclinicIds)->get();
        if (!$application) {
            abort(404, 'Application not found.');
        }
        $directors = ArtClinicDirectorModel::where('artclinic_id', $artclinicIds)->get();
        //dd($directors);
        $staff = ArtClinicOtherStaffModel::where('artclinic_id', $artclinicIds)->get();
        $equipment = ArtClinicEquipmentModel::where('artclinic_id', $artclinicIds)->get();

        $user = Signup::where('email', session('email'))->first();
        $adminuser = user::where('email',session('email'))->first();
        if (!$user && !$adminuser) {
            abort(404, 'User not found.');
        }

        // // Fetch the application data (adjust as needed)
        // // $application = nocform::findOrFail($id);
        // // Fetch the clinic names from the signup table
        // $decryptedId = Crypt::decrypt($id);
        // $application = nocform::findOrFail($decryptedId);
        // $app_id = $application->id;
        // $clinicIds = [$application->from_name_clinic, $application->to_name_clinic]; // IDs to fetch
        // $clinicNames = DB::table('signup')
        //     ->whereIn('id', $clinicIds)
        //     ->pluck('clinicname', 'id'); // Retrieve clinic names with IDs as keys       
        // Load the view and pass data
        $pdf = Pdf::loadView('layouts.clinic.application_pdf', compact('application', 'directors', 'staff', 'equipment'));
        //dd($pdf);
        // Optionally, stream or download the PDF
        return $pdf->stream('application_pdf.pdf');
        // For download: return $pdf->download('application_details.pdf');
    }
}
