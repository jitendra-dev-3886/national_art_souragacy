<?php

namespace App\Http\Controllers\renewal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\clinic\signup;
use App\Models\clinic\SurrogacyClinicModel;
use App\Models\clinic\SurrogacyClinicApplicationNo;
use App\Models\clinic\SurrogacyClinicDirectorModel;
use App\Models\clinic\SurrogacyClinicEquipmentModel;
use App\Models\clinic\SurrogacyClinicOtherStaffModel;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\clinic\clinicStaffModel;
use App\Models\clinic\clinicDirectorModel;
use App\Models\clinic\ClinicEquipmentModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\renewal\RenewalSCApplication;
use App\Models\renewal\RenewalSCDirector;
use App\Models\renewal\RenewalSCEquipment;
use App\Helpers\ClinicRegistration;
use App\Models\renewal\RenewalSCStaff;
use App\Models\renewal\workflowlog;
use App\Models\Admin\WorkFlowTable;
use App\Models\renewal\DocFilereceivedUploadRenewal;
use App\Models\Noc\docmastertable;
use Illuminate\Validation\ValidationException;




class renewalApplicationController extends Controller
{
    // view applications
    public function surrogacyRenewalApplicationform(Request $request, $encryptedClinicId)
    {
        // dd($encryptedClinicId);
        // Step 0: Decrypt the clinic ID
        try {
            $clinic_id = Crypt::decryptString($encryptedClinicId);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid or expired link.');
        }

        // Step 1: Check session
        if (!Session::has('id')) {

            return redirect()->route('clinic.loginclinicform');
        }

        $userId = Session::get('id');
        $email = $request->session()->get('email');
        $check_user = signup::where('email', $email)->first();

        // Step 2: Fetch clinic data by clinic_id
        $clinic_data = ClinicRegistrationModel::where('clinic_id', $clinic_id)
            ->where('userid_applicant', $userId)
            ->where('status', 1)
            ->first();

        if (!$clinic_data) {
            return redirect()->back()->with('error', 'Clinic data not found.');
        }

        // Step 3: Check if renewal allowed (within 60 days before expiry)
        $allowRenewal = false;
        if (!empty($clinic_data->certificate_valid_date)) {
            try {
                $cutoff = Carbon::parse($clinic_data->certificate_valid_date)->copy()->subDays(60);
                $allowRenewal = now()->greaterThanOrEqualTo($cutoff);
                // dd($cutoff,$allowRenewal);
            } catch (\Exception $e) {
                Log::error('Invalid certificate_valid_date for clinic_id: ' . $clinic_data->clinic_id);
            }
        }
        // Step 4: Check if a draft renewal exists for this clinic
        $draft_data = RenewalSCApplication::where('userid', $userId)
            ->where('clinic_id', $clinic_id)
            ->where('status', 0)
            ->orderBy('id', 'desc')
            ->first();
            
        $existing_data = RenewalSCApplication::where('userid', $userId)
            ->where('clinic_id', $clinic_id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->first();
        if ($draft_data) {
            // Load renewal sub-tables
            $directors = RenewalSCDirector::where('clinic_id', $clinic_id)
                ->where('application_id', $draft_data->id)
                ->get();

            $staff = RenewalSCStaff::where('clinic_id', $clinic_id)
                ->where('application_id', $draft_data->id)
                ->get()
                ->toArray();

            $equipment = RenewalSCEquipment::where('clinic_id', $clinic_id)
                ->where('application_id', $draft_data->id)
                ->get();

            // If sub-tables empty → load from main clinic tables
            if ($directors->isEmpty() && empty($staff) && $equipment->isEmpty()) {
                Log::info('First-time draft renewal — loading data from main clinic tables.');
                $directors = clinicDirectorModel::where('clinic_id', $clinic_id)->get();
                $staff = clinicStaffModel::where('clinic_id', $clinic_id)->get()->toArray();
                $equipment = ClinicEquipmentModel::where('clinic_id', $clinic_id)->get();
            }
            // dd(strtoupper($clinic_data->clinic_type));
            // Select correct form view based on clinic type
            $view = match (strtoupper($clinic_data->clinic_type)) {
                'ARTCLINIC' => 'renewal.artclinic_application_form',
                'ARTSURROGACY' => 'renewal.surrogacy_application_form',
                'ARTBANK' => 'renewal.artbank_application_form',
            };
            
            $encryptedAppId = !empty($existing_data) ? Crypt::encryptString($existing_data->id) : NULL ;
            $fees = $existing_data->fee_amount ?? '';
            $reject = $existing_data->appstatus ?? ''; 
            return view($view, compact(
                'clinic_data',
                'directors',
                'staff',
                'equipment',
                'allowRenewal',
                'encryptedAppId',
                'fees',
                'reject',
                'draft_data',
                'encryptedClinicId'
            ));
        }
        
        // dd($draft_data,$allowRenewal,$existing_data);
        if (!$draft_data && $allowRenewal && (!$existing_data || $existing_data->appstatus == 'Approved' || $existing_data->appstatus == 'Rejected')) {
            // Step 6: First-time renewal → load from main clinic tables
            $directors = clinicDirectorModel::where('clinic_id', $clinic_id)->where('status', 1)->get();
            $staff = clinicStaffModel::where('clinic_id', $clinic_id)->where('status', 1)->get()->toArray();
            $equipment = ClinicEquipmentModel::where('clinic_id', $clinic_id)->where('status', 1)->get();

            // Select correct form view
            $view = match (strtoupper($clinic_data->clinic_type)) {
                'ARTCLINIC' => 'renewal.artclinic_application_form',
                'ARTSURROGACY' => 'renewal.surrogacy_application_form',
                'ARTBANK' => 'renewal.artbank_application_form',
            };
            if (!$existing_data) {
                return view($view, compact(
                    'clinic_data',
                    'directors',
                    'staff',
                    'equipment',
                    'allowRenewal',
                    'encryptedClinicId'
                ));
            } else {
                $encryptedAppId = Crypt::encryptString($existing_data->id);
                $fees = $existing_data->fee_amount ?? '';
                $reject = $existing_data->appstatus ?? ''; 
                return view($view, compact(
                    'clinic_data',
                    'directors',
                    'staff',
                    'equipment',
                    'encryptedAppId',
                    'fees',
                    'reject',
                    'allowRenewal',
                    'encryptedClinicId'
                ));
            }
        }
        // Step 5: If already submitted → show view mode
        if ($existing_data) {
            // encrypt the application ID for viewing
            $encryptedAppId = Crypt::encryptString($existing_data->id);
            return $this->sc_renewalform_view($encryptedAppId);
        }

        $view = match (strtoupper($clinic_data->clinic_type)) {
            'ARTCLINIC' => 'renewal.artclinic_application_form',
            'ARTSURROGACY' => 'renewal.surrogacy_application_form',
            'ARTBANK' => 'renewal.artbank_application_form',
        };

        return view($view, compact(
            'allowRenewal'
        ));
    }

    // submit application
    public function submit_surrogacyRenewalApplicationform(Request $request)
    {
        $user = signup::where('email', session('email'))->first();
        if (!$user) {
            return redirect()->route('clinic.loginnocform');
        }
        if (!empty($request->r_id)) {
            $r_id  = Crypt::decryptString($request->r_id) ?? '';
            $reject_data =  RenewalSCApplication::find($r_id);
        }
        $userId = session('id');
        $clinicId = Crypt::decryptString($request->clinic_id) ?? '';
        $submitType = $request->input('submit_type'); // 'draft' or 'final'
         // Step 2: Fetch clinic data for server side validation of read only field
        $clinic_data = ClinicRegistrationModel::where('clinic_id', $clinicId)
            ->where('userid_applicant', $userId)
            ->where('status', 1)
            ->first();

        if (!$clinic_data) {
            return redirect()->back()->with('error', 'Clinic data not found.');
        }
        if(trim($request->input('clinicname'))==trim($clinic_data->name) && 
        trim($request->input('address'))==trim($clinic_data->address) &&
        trim($request->input('pincode'))==trim($clinic_data->pincode) &&
        trim($request->input('state'))==trim($clinic_data->state) &&
        trim($request->input('district'))==trim($clinic_data->district) &&
        trim($request->input('nature'))==trim($clinic_data->nature) &&
        trim($request->input('email_clinic'))==trim($clinic_data->email) &&
        trim($request->input('dateestab'))==trim($clinic_data->date_of_establishment) &&
        trim($request->input('current_registration_date'))==trim($clinic_data->rgistration_date) &&
        trim($request->input('original_rgistration_date'))==trim($clinic_data->first_registration_date))
        {
        // Fetch existing renewal (if any)
        $existingRenewal = RenewalSCApplication::where('userid', $userId)
            ->where('clinic_id', $clinicId)
            ->where('status', 0)
            ->first();


        try {
            DB::beginTransaction();
            // Create or update renewal application

            $srClinic = RenewalSCApplication::firstOrNew([
                'userid' => $userId,
                'clinic_id' => $clinicId,
                'status' => 0
            ]);
       
            $srClinic->fill($request->all());
            $srClinic->email = $request->input('email_clinic');
            $srClinic->contact_person_name = $request->input('personname');
            $srClinic->contact_person_mobile = $request->input('mobilecontact');
            $srClinic->contact_person_email = $request->input('emailcontact');
            $srClinic->clinic_id = $clinicId;
            // $srClinic->status = ($submitType === 'draft') ? 0 : 1;
            $srClinic->status = 0;
            $srClinic->otherprocedure = $request->otherprocedure ? $request->otherprocedure : NULL;
            $srClinic->current_registration_date = $request->current_registration_date;
            $srClinic->first_registration_date = $request->original_rgistration_date;
            $srClinic->current_certificate_valid_date = $clinic_data->certificate_valid_date;
            // dd($srClinic, $request->all());
            $srClinic->save();
        
            $srClinic_id = $srClinic->id;
            // 🧹 Clear existing related data
            RenewalSCDirector::where('application_id', $srClinic_id)->delete();
            RenewalSCStaff::where('application_id', $srClinic_id)->delete();
            RenewalSCEquipment::where('application_id', $srClinic_id)->delete();

            // 👨‍⚕️ Save Directors
            if ($request->filled('director') && $request->director === 'Yes' && is_array($request->name_director)) {
                $newDirectors = [];
                foreach ($request->name_director as $key => $directorName) {
                    $newDirectors[] = [
                        'name_director'     => $directorName,
                        'quali_director'    => $request->quali_director[$key] ?? null,
                        'reg_director'      => $request->reg_director[$key] ?? null,
                        'userid'            => $userId,
                        'application_id'    => $srClinic_id,
                        'clinic_id'         => $clinicId,
                        'clinic_type'    => $request->input('clinic_type'),
                    ];
                }
                RenewalSCDirector::insert($newDirectors);
            }

            // 👥 Save Staff
            if (is_array($request->post)) {
                $staffData = []; 
                foreach ($request->post as $k => $staff) {

                    $postValue  = ($staff === 'Any Other') ? $request->anyotherpost[$k] : $staff;
                    //  dd($request->$postValue);
                    $qualiValue = ($request->quali_otherstaff[$k] === 'Any Other') ? $request->anyotherdegree[$k] : $request->quali_otherstaff[$k];

                    $staffData[] = [
                        'post'           => $postValue,
                        'name'           => $request->name_otherstaff[$k] ?? null,
                        'regno'          => $request->regno[$k] ?? null,
                        'qualification'  => $qualiValue,
                        'application_id' => $srClinic_id,
                        'clinic_id'      => $clinicId,
                        'userid'         => $userId,
                        // 'application_no' => $request->applicationno,
                        'clinic_type'    => $request->input('clinic_type'),
                    ];
                }
                RenewalSCStaff::insert($staffData);
            }

            // ⚙️ Save Equipment
            if (is_array($request->equipmentname)) {
                $equipData = [];
                foreach ($request->equipmentname as $e => $equipment) {
                    $equipData[] = [
                        'equipmentname'  => $equipment,
                        'clinic_id'      => $clinicId,
                        'userid'         => $userId,
                        'application_id' => $srClinic_id,
                        'clinic_type'    => $request->input('clinic_type'),
                    ];
                }
                RenewalSCEquipment::insert($equipData);
            }

            // 🏁 Final submission logic
            if ($submitType === 'final') {
                // if (!$request->has('applicationno')) {
                //     return response()->json(['error' => 'Application number is required'], 400);
                // }

                $rules = [
                    'clinicname'        => 'required',
                    'address'           => 'required',
                    'pincode'           => 'required',
                    'contactno'         => 'required',
                    'personname'        => 'required',
                    'mobilecontact'     => 'required',
                    'emailcontact'      => 'required',
                ];

                if($request->clinic_type == 'ARTSURROGACY' && $request->clinic_type == 'ARTCLINIC'){
                    
                    $rules['pcpndtact']         = 'required';
                    $rules['mtpact']            = 'required';
                    $rules['email_clinic']      = 'required|email';
                    $rules['iuih']              = 'required';
                    $rules['iuid']              = 'required';
                    $rules['ivfet']             = 'required';
                    $rules['icsi']              = 'required';
                    $rules['pgt']               = 'required';
                    $rules['spermandoocyte']    = 'required';
                    $rules['anyotherprocedure'] = 'required|in:Yes,No';
                    $rules['director']          = 'required|in:Yes,No';
                }

                if ($request->director === 'Yes') {

                    $rules['name_director']      = 'required|array|min:1';
                    $rules['name_director.*']    = 'required';

                    $rules['quali_director']     = 'required|array|min:1';
                    $rules['quali_director.*']   = 'required';

                    $rules['reg_director']       = 'nullable|array';
                    $rules['reg_director.*']     = 'nullable|string|max:255';
                }
                if ($request->anyotherprocedure === 'Yes') {
                    $rules['otherprocedure'] = 'required|string|max:255';
                }
                $request->validate($rules, [
                    'name_director.*.required'    => 'The Name Director field is required.',
                    'quali_director.*.required'   => 'The Qualification Director field is required.',
                    'reg_director.*.required'     => 'The Registration No. field is required.',
                    'otherprocedure.required'     => 'The Other procedure field is required.',
                ]);
                
                $srClinic->application_datetime_submission = now();
                $srClinic->application_type = 2; // Renewal
                $srClinic->appstatus = 'Pending';
                $srClinic->status = 1;
                // $srClinic->clinic_type = $request->input('clinic_type'); // Dynamic
               $lastApplication = RenewalSCApplication::where('status', 1)->latest()->first();
                $su_id = DB::table('state')
                ->where('state_name', $clinic_data->state)
                ->orderBy('state_name')
                ->value('state_abb');
                $year = Carbon::now()->year;
                $clinic_type_abbr = $srClinic->clinic_type == 'ARTSURROGACY' ? 'SC' : ( $srClinic->clinic_type == 'ARTBANK' ? 'AB' : 'AC');
                if ($lastApplication) {
                    $ano = $lastApplication->applicationno;
                    $ano_sub = substr($ano, -5);
                    $getnumbers = str_replace("/", "", $ano_sub);
                    $no_increase = $getnumbers + 1;
                    $get_string = str_pad($no_increase, 5, '0', STR_PAD_LEFT);
                    $enumber = $su_id . '/'. $clinic_type_abbr .'/RN/' . $year . '/' . $get_string;
                } else {
                    $enumber = $su_id . '/'. $clinic_type_abbr . '/RN/'. $year . '/10001';
                }
                if(!empty($reject_data) && $reject_data->appstatus == 'Rejected'){

                   if (empty($reject_data->fees_via_application_no)) {
                        $reject_application_no = $reject_data->applicationno;
                        // $reject_count = 1;
                   }else{
                   
                        $reject_application_no = $reject_data->fees_via_application_no;
                        // $reject_count = RenewalSCApplication::where('fees_via_application_no', $reject_application_no)->where('appstatus', 'Rejected')->count() +1;
                   }
                
                    // $enumber = $request->input('applicationno');
                    // $enumberWithSlash = $enumber . '/R'.'/'.date('Y');
                    // $enumberWithSlash = $enumber . '/R/R'. $reject_count;
                    $srClinic->applicationno = $enumber;

                    
                    $srClinic->app_date_payment =  $reject_data->app_date_payment;
                    $srClinic->mode_payment =  $reject_data->mode_payment;
                    $srClinic->transaction_id =  $reject_data->transaction_id;
                    $srClinic->fee_amount =  $reject_data->fee_amount;
                    $srClinic->fees_via_application_no =  $reject_application_no;
                    
                    $srClinic->is_resubmission =  1;
                }else{
                    //application number chnage
                    // $enumber = $request->input('applicationno');
                    // $enumberWithSlash = $enumber . '/R'.'/'.date('Y');
                    // $enumberWithSlash = $enumber . '/R';

                    $srClinic->applicationno = $enumber;
                    $srClinic->application_datetime_submission = now();
                    $srClinic->application_type = 2; // Renewal
                    $srClinic->appstatus = 'Pending';
                    // $srClinic->clinic_type = $request->input('clinic_type'); // Dynamic
                    $srClinic->is_resubmission =  0;
                }

                $srClinic->save();
            }

            DB::commit();
            return $submitType === 'draft'
                ? redirect()->back()->with('success', 'Draft saved successfully.')
                : redirect()->route('renewal.application.success', ['encryptedId' => Crypt::encryptString($srClinic->id)])->with('success', 'Renewal Application Submitted Successfully!');
            // redirect()->route('renewal.application.surrogacy_success')->with('success', 'Renewal Application Submitted Successfully!');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Renewal form submission failed: due to validation error: ' . $e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine() . ':' . $srClinic_id);
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Renewal form submission failed: ' . $e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine() . ':' . $clinicId);
            return redirect()->route('renewal.surrogacy_renewal_applicationform', Crypt::encryptString($clinicId))->with('failure', 'Something went wrong');
            // return redirect()->back()->with('errors', 'Something went wrong: ' . $e->getMessage());
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Renewal form submission failed: ' . $e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine() . ':' . $clinicId);
            return redirect()->route('renewal.surrogacy_renewal_applicationform', Crypt::encryptString($clinicId))->with('failure', 'Something went wrong');
            // return redirect()->back()->with('errors', 'Something went wrong: ' . $e->getMessage());
        }
        }
        else{
            Log::error('Renewal form submission failed client side tempring: ' . session('email'));
            return redirect()->route('renewal.surrogacy_renewal_applicationform', Crypt::encryptString($clinicId))->with('failure', 'The renewal application could not be submitted due to a validation error. Kindly refresh the page, verify the read only details, and try again. If the issue persists, contact support team.');
        }
    }




    // public function renewal_sc_success(Request $request)
    // {

    //     $ses_id = Session::get('id'); // ID from session
    //     // dd($ses_id);
    //     $signup = RenewalSCApplication::where('userid', $ses_id)->first();
    //     $sclinicIds = $signup->id;

    //     $applications =   RenewalSCApplication::where('id', $sclinicIds)
    //         ->where('status', 1)
    //         ->where('userid', $ses_id)
    //         ->first();
    //     $appNo = $applications->applicationno;
    //     $app_sclinic_id = $applications->id; // direct column



    //     return view('renewal.surrogacy_renewal_success', compact('appNo', 'applications', 'app_sclinic_id'))->with('success', 'Surrogacy Clinic Application Submitted Successfully!');
    // }
    public function renewal_sc_success(Request $request, $encryptedId)
    {
        //  dd($encryptedId);
        $ses_id = Session::get('id');

        try {
            $applicationId = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid or expired link.');
        }

        $application = RenewalSCApplication::where('id', $applicationId)
            ->where('userid', $ses_id)
            ->where('status', 1)
            ->first();

        if (!$application) {
            return redirect()->back()->with('error', 'Application not found or not submitted yet.');
        }

        $appNo = $application->applicationno;
        $clinicType = strtoupper($application->clinic_type);

        return view('renewal.surrogacy_renewal_success', compact('appNo', 'application', 'clinicType'))
            ->with('success', "{$clinicType} Renewal Application Submitted Successfully!");
    }



    public function sc_renewalform_view($encryptedId)
    {

        // dd(Crypt::decryptString($encryptedId));
        // Step 1: Check session
        if (!Session::has('id')) {
            return redirect()->route('clinic.loginclinicform');
        }
        try {
            $applicationId = Crypt::decryptString($encryptedId);
        } catch (\Exception $e) {

            abort(404, 'Invalid or expired link.');
        }
        // dd(Session::all(),Crypt::decryptString($encryptedId));
        $ssaId = false;
        if (Session::get('user_type') < 4) {
            $ses_id = Session::get('id');
        } elseif (Session::get('user_type') == 5) {

            $ssaId = Session::get('id');
            $ses_id = RenewalSCApplication::where('id', $applicationId)
                ->where('state', Session::get('state_name'))
                ->where('status', 1)
                ->value('userid');
            // dd($ses_id);
            // $ses_id = Session::get('id');
        }

        // Step 2: Decrypt the application ID
        
        // $adminUser = signup::find($ses_id);

        // Step 3: Fetch the renewal application for this user
        $application = RenewalSCApplication::where('id', $applicationId)
            ->where('userid', $ses_id)
            ->where('status', 1)
            ->first();
        // dd('sfadf',$applicationId,$ses_id,$application);
        if (!$application) {
            abort(404, 'Application not found.');
        }

        // Step 4: Fetch related sub-tables
        $directors = RenewalSCDirector::where('clinic_id', $application->clinic_id)
            ->where('application_id', $applicationId)
            ->get();

        $staff = RenewalSCStaff::where('clinic_id', $application->clinic_id)
            ->where('application_id', $applicationId)
            ->get();

        $equipment = RenewalSCEquipment::where('clinic_id', $application->clinic_id)
            ->where('application_id', $applicationId)
            ->get();

        if ($ssaId) {
            // Step 6: Choose the correct blade view based on clinic type
            $bladeView = match (strtoupper($application->clinic_type)) {
                'ARTSURROGACY' => 'renewal.surrogacy_application_view_ssa',
                'ARTBANK'      => 'renewal.artbank_application_view_ssa',
                'ARTCLINIC'    => 'renewal.artclinic_application_view_ssa',
                // default        => 'renewal.surrogacy_application_view', // fallback
            };
        } else {
            // dd($application->clinic_type);
            // Step 6: Choose the correct blade view based on clinic type
            $bladeView = match (strtoupper($application->clinic_type)) {
                'ARTSURROGACY' => 'renewal.surrogacy_application_view',
                'ARTBANK'      => 'renewal.artbank_application_view',
                'ARTCLINIC'    => 'renewal.artclinic_application_view',
                // default        => 'renewal.surrogacy_application_view', // fallback
            };
        }
        // Step 7: Return the selected view
        return view($bladeView, compact(
            'application',
            'directors',
            'staff',
            'equipment'
        ));
    }
    // view from dashboard
    public function surrogacyssarenewal_list()

    {
        //  dd('text');
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        $userId = Session::get('id');
        $stateName = Session::get('state_name');
        $ssasurogacyformList = RenewalSCApplication::where('state', $stateName)->where('status', 1)->where('clinic_type', 'ARTSURROGACY')->get();
        // dd($ssasurogacyformList);
        return view('renewal.surrogacy_ssa_list_rec', compact('ssasurogacyformList'));
    }
}
