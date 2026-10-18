<?php

namespace App\Http\Controllers;
use Exception;
use Carbon\Carbon;
use App\Mail\LoginOtp;
use App\Mail\NOCFormMail;
use App\Mail\UserRequest;
use App\Models\Noc\nocform;
use App\Models\Noc\UserNoc;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\clinic\signup;
use App\Models\DocFileUpload;
use App\Models\Admin\Noctable;
use App\Models\Admin\userTable;
use App\Models\LoginAttempt;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\Userforgetpassword;
use App\Models\ApplicantProfile;
use App\Models\clinic\BankModel;
use App\Models\Noc\countrytable;
use App\Models\Noc\requesttable;
use App\Models\Noc\verifiedtable;
use App\Models\Noc\docmastertable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\clinic\ArtClinicModel;

//add on 18-12-2024
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\ArtClinicRequest;
use Illuminate\Support\Facades\Session;
use App\Models\clinic\BankApplicationNo;
use Illuminate\Support\Facades\Password;
use App\Models\clinic\BankEquipmentModel;
use Illuminate\Support\Facades\Validator;
use App\Models\clinic\BankOtherStaffModel;
use App\Models\clinic\ClinicApplicationNo;
use Illuminate\Support\Facades\Log as log;
use App\Models\Admin\approveauthoritytable;
use App\Models\clinic\SurrogacyClinicModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Requests\SurrogacyClinicRequest;
use App\Models\clinic\ArtClinicDirectorModel;
use App\Models\clinic\ArtClinicEquipmentModel;
use App\Models\clinic\ArtClinicOtherStaffModel;
use App\Http\Requests\BankApplicationFormRequest;
use App\Models\clinic\SurrogacyClinicApplicationNo;
use App\Models\clinic\SurrogacyClinicDirectorModel;
use App\Models\clinic\SurrogacyClinicEquipmentModel;
use App\Models\clinic\SurrogacyClinicOtherStaffModel;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;




class NOCController extends Controller
{


    public function logout(Request $request)
    {
        // Clear session data for the NOC user
        //$request->session()->forget('noc_user');
        LoginAttempt::where('userid', session('id'))
                            ->where('user_type', session('user_type'))
                            ->whereNull('end_time')
                            ->update([
                                'end_time' => Carbon::now(),
                            ]);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page or any other desired route
        return redirect()->route('noc.loginnocform');
    }
    public function cliniclogout(Request $request)
    {
        // Clear session data for the NOC user
        //$request->session()->forget('clinic_user');
        LoginAttempt::where('userid', session('id'))
                            ->where('user_type', session('user_type'))
                            ->whereNull('end_time')
                            ->update([
                                'end_time' => Carbon::now(),
                            ]);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page or any other desired route
        return redirect()->route('clinic.loginclinicform');
    }
    public function nocapplicationform(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('noc.loginnocform');
        }

        $countries = countrytable::all();
        // Fetch records from requesttable for the logged-in user       

        $email = $request->session()->get('email');
        $user = requesttable::where('email', $email)->first();

        //dd($user);

        $get_id = Session::get('id');
        
        //dd($get_id);
        // Fetch the user profile based on the user ID
        $user_profile = ApplicantProfile::where('noc_userid', $get_id)->first();
        
        // Check if the user profile is empty or incomplete
        // Check if the user profile exists and if the profile is updated
        if (!$user_profile) {
            // If no user profile exists, redirect to the profile update page
            return redirect()->route('noc.profile.update')->with('success', 'Please complete your profile before proceeding to the application form.');
        }
        //dd($user);
        // Check if the profile is updated, if not, prompt user to update it 
        if ($user_profile) {
            return view('layouts/noc/add_noc_application_form_willbeupdated', ['tab' => $request->input('tab', 1), 'countries' => $countries, 'requesttable' => $user], compact('user_profile'));
        }
    }



    // Show the profile update form
    public function showUpdateForm()
    {
        // dd('sdfsdfs');
        // Assuming the user is logged in, get the current user's profile data
        $user = requesttable::where('email', session('email'))->first();

        if (!$user) {
            return redirect()->route('noc.loginnocform');
        }
        // dd('sdfsdfs');
         $applicantProfile = ApplicantProfile::where('noc_userid', $user->id)->first();
         $countries = countrytable::all();
        return view('layouts.noc.applicant_update', compact('user', 'applicantProfile')); // Adjust view name accordingly
    }

    // Handle the profile update form submission
    public function updateProfile(Request $request)
   {
    try {
        // Check if user exists by email in session
        $user = requesttable::where('email', session('email'))->first();
        if (!$user) {
            return redirect()->route('noc.loginnocform');
        }

        $noc_userid = Session::get('id');
        
    //  dd($request->all());
        // Validation rules
             $validator = Validator::make($request->all(), [
                    'name_applicant'    => 'required',
                    'gender'            => 'required',
                    'address'           => 'required',
                    'nationality_type'  => 'required',

                    // For Indian nationals
                    'pincode' => [
                        function ($attribute, $value, $fail) use ($request) {
                            if ($request->input('nationality_type') === 'Indian' && empty($value)) {
                                $fail('Please select pincode.');
                            }
                        },
                    ],
                    'state' => [
                        function ($attribute, $value, $fail) use ($request) {
                            if ($request->input('nationality_type') === 'Indian' && empty($value)) {
                                $fail('Please select state.');
                            }
                        },
                    ],
                    'district' => [
                        function ($attribute, $value, $fail) use ($request) {
                            if ($request->input('nationality_type') === 'Indian' && empty($value)) {
                                $fail('Please select district.');
                            }
                        },
                    ],

                    // For Foreign nationals
                    'country' => [
                        function ($attribute, $value, $fail) use ($request) {
                            if ($request->input('nationality_type') === 'Foreigner' && empty($value)) {
                                $fail('Please select country.');
                            }
                        },
                    ],
                    'zipcode' => [
                        function ($attribute, $value, $fail) use ($request) {
                            if ($request->input('nationalty_type') === 'Foreigner' && empty($value)) {
                                $fail('Please select zipcode.');
                            }
                        },
                    ],
                ]);
            
                if ($validator->fails()) {
                  //  dd('sdfsdfsdfsdfsdfs');
                    return redirect()->back()->withErrors($validator)->withInput();
                }

        $applicant_profile = ApplicantProfile::where('noc_userid', $noc_userid)->first();

        if ($applicant_profile){

            $applicant_profile->name_applicant  = $request->input('name_applicant');
            $applicant_profile->gender          = $request->input('gender');
            $applicant_profile->address         = $request->input('address');
            $applicant_profile->pincode         = $request->input('pincode');
            $applicant_profile->state           = $request->input('state');
            $applicant_profile->district        = $request->input('district');
            $applicant_profile->nationality_type = $request->input('nationality_type');

            if ($request->input('nationality_type') == 'Indian') {
                $applicant_profile->country = 'India';
                $applicant_profile->zipcode = null;
            } else {
                $applicant_profile->country = $request->input('country');
                $applicant_profile->zipcode = $request->input('zipcode');
            }

            $applicant_profile->save();

        }else{

            ApplicantProfile::create([
                'noc_userid'       => $noc_userid,
                'name_applicant'   => $request->input('name_applicant'),
                'gender'           => $request->input('gender'),
                'address'          => $request->input('address'),
                'pincode'          => $request->input('pincode'),
                'state'            => $request->input('state'),
                'district'         => $request->input('district'),
                'zipcode'          => $request->input('zipcode'),
                'country'          => $request->input('nationality_type') === 'Indian' ? 'India' : $request->input('country'),
                'nationality_type' => $request->input('nationality_type'),
            ]);
        }

       
        return redirect()->route('noc.profile')->with('update_message', 'Profile updated successfully!');

    } catch (\Exception $e) {
        // Log error for debugging
        Log::error('Profile update failed: '.$e->getMessage(), [
            'user_id' => $noc_userid ?? null,
            'trace'   => $e->getTraceAsString(),
        ]);

        return redirect()->back()->with('error_message', 'Something went wrong while updating the profile. Please try again.');
    }
}





    public function checkPincode(Request $request)
    {
        $pincode = $request->input('pincode');

        // Query the database for state and district
        //DB::connection('art_db')->table('some_table')->get();
        $pincodeData = DB::table('pincode')
            // $pincodeData = DB::connection('artregistry_11-11-2024')->table('pincode')
            ->select('state', 'district')
            ->where('pincode', $pincode)
            ->first();

        if ($pincodeData) {
            return response()->json([
                'success' => true,
                'state' => $pincodeData->state,
                'district' => $pincodeData->district,
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    public function checkPincodesignup(Request $request)
    {
        $pincode = $request->input('pincode');

        // Query the database for state and districts
        $pincodeData = DB::table('pincode')
            ->select('state', 'district')
            ->where('pincode', $pincode)
            ->get()->unique('district'); // Fetch all matching records
//dd( $pincodeData);
        if ($pincodeData->isNotEmpty()) {
            $state = $pincodeData->first()->state; // All records have the same state
           //$districts = $pincodeData->pluck('district')->unique()->toArray(); // Get unique districts
           $districts = $pincodeData->pluck('district')->toArray(); // Get unique districts
            // $districts = $pincodeData->where('pincode', $pincode)->pluck('district')->unique()->values()->toArray();
            return response()->json([
                'success' => true,
                'state' => $state,
                'districts' => $districts, // Return multiple districts
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    // public function checkPincodesignup(Request $request)
    // {
    //     //dd('hello');
    //     $pincode = $request->input('pincode');

    //     // Query the database for state and district
    //     //DB::connection('art_db')->table('some_table')->get();
    //     $pincodeData = DB::table('pincode')
    //         //$pincodeData = DB::connection('artregistry_11-11-2024')->table('pincode')
    //         ->select('state', 'district')
    //         ->where('pincode', $pincode)
    //         ->first();

    //     if ($pincodeData) {
    //         return response()->json([
    //             'success' => true,
    //             'state' => $pincodeData->state,
    //             'district' => $pincodeData->district,
    //         ]);
    //     } else {
    //         return response()->json(['success' => false]);
    //     }
    // }
    public function fetchClinicData(Request $request)
    {
        $clinicType = $request->input('clinic_type');
        $statusType = $request->input('status_type');

        if ($clinicType && $statusType) {
            // Define the query based on the inputs
            $query = match ([$clinicType, $statusType]){
                ['ART', 'Registered'] => DB::table('signup')
                    ->join('artclinic_certificate_details', 'signup.id', '=', 'artclinic_certificate_details.userid')
                    ->join('artclinic', 'signup.id', '=', 'artclinic.userid')
                    ->select('signup.id', 'signup.clinicname', 'signup.state', 'signup.district')
                    ->where('artclinic_certificate_details.approved_rejected','Registration Granted')
                    ->where('artclinic.status',1)
                    ->where('artclinic.cliniclevel', 'Level-2') 
                    ->orderBy('signup.clinicname', 'ASC'),

                ['Surrogacy', 'Registered'] => DB::table('signup')
                    ->join('surrogacy_certificate_details', 'signup.id', '=', 'surrogacy_certificate_details.userid')
                    ->join('surrogacyclinic', 'signup.id', '=', 'surrogacyclinic.userid')
                    ->select('signup.id', 'signup.clinicname', 'signup.state', 'signup.district')
                    ->where('surrogacy_certificate_details.approved_rejected','Registration Granted')
                    ->where('surrogacyclinic.status',1)
                    ->orderBy('signup.clinicname', 'ASC'),

                ['ART', 'Applied for'] => DB::table('signup')
                    ->join('artclinic', 'signup.id', '=', 'artclinic.userid')
                    ->join('clinic_applicationno', 'artclinic.id', '=', 'clinic_applicationno.clinic_id')
                    ->select(
                        'signup.id',
                        'signup.clinicname',
                        'signup.state',
                        'signup.district',
                        'artclinic.appstatus',
                        'clinic_applicationno.applicationno'
                    )
                    ->where('artclinic.cliniclevel', 'Level-2')
                    ->where('artclinic.status', 1)
                    ->orderBy('signup.clinicname', 'ASC'),

                ['Surrogacy', 'Applied for'] => DB::table('signup')
                    ->join('surrogacyclinic', 'signup.id', '=', 'surrogacyclinic.userid')
                    ->join('s_applicationno', 'surrogacyclinic.id', '=', 's_applicationno.surrogacy_id')
                    ->select(
                        'signup.id',
                        'signup.clinicname',
                        'signup.state',
                        'signup.district',
                        'surrogacyclinic.appstatus',
                        's_applicationno.applicationno'
                    )
                    ->where('surrogacyclinic.status', 1)
                    ->orderBy('signup.clinicname', 'ASC'),

                default => null,
            };

            if ($query) {
                $results = $query->get();
                $output = '<option value="">Select</option>';
                foreach ($results as $row) {
                    $output .= "<option value=\"{$row->id}\">{$row->clinicname}, {$row->state}, {$row->district}</option>";
                }
                return response()->json($output);
            } else {
                return response()->json('<option value="">No clinics found</option>');
            }
        }

        return response()->json('<option value="">No clinic type or status received</option>');
    }
    public function fetchClinicDatafrom(Request $request)
    {
        $clinicType = $request->input('clinic_type');
        $statusType = $request->input('status_type');

        if ($clinicType && $statusType) {
            // Define the query based on the inputs
            $query = match ([$clinicType, $statusType]) {
                ['ART Clinic', 'Registered'] => DB::table('signup')
                    ->join('artclinic_certificate_details', 'signup.id', '=', 'artclinic_certificate_details.userid')
                    ->join('artclinic', 'signup.id', '=', 'artclinic.userid')
                    ->select('signup.id', 'signup.clinicname', 'signup.state', 'signup.district')
                    ->where('artclinic_certificate_details.approved_rejected','Registration Granted')
                    ->where('artclinic.status',1)
                    ->orderBy('signup.clinicname', 'ASC'),

                ['Surrogacy Clinic', 'Registered'] => DB::table('signup')
                    ->join('surrogacy_certificate_details', 'signup.id', '=', 'surrogacy_certificate_details.userid')
                    ->join('surrogacyclinic', 'signup.id', '=', 'surrogacyclinic.userid')
                    ->select('signup.id', 'signup.clinicname', 'signup.state', 'signup.district')
                    ->where('surrogacy_certificate_details.approved_rejected','Registration Granted')
                    ->where('surrogacyclinic.status',1)
                    ->orderBy('signup.clinicname', 'ASC'),

                ['ART Clinic', 'Applied for'] => DB::table('signup')
                    ->join('artclinic', 'signup.id', '=', 'artclinic.userid')
                    ->join('clinic_applicationno', 'artclinic.id', '=', 'clinic_applicationno.clinic_id')
                    ->select(
                        'signup.id',
                        'signup.clinicname',
                        'signup.state',
                        'signup.nature',
                        'signup.district',
                        'signup.email',
                        'signup.mobile',
                        'signup.address',
                        'artclinic.appstatus',
                        'artclinic.appstatus',
                        'clinic_applicationno.applicationno'
                    )
                    ->where(['artclinic.appstatus'=>'Pending','artclinic.status'=>1])
                    ->orderBy('signup.clinicname', 'ASC'),

                ['Surrogacy Clinic', 'Applied for'] => DB::table('signup')
                    ->join('surrogacyclinic', 'signup.id', '=', 'surrogacyclinic.userid')
                    ->join('s_applicationno', 'surrogacyclinic.id', '=', 's_applicationno.surrogacy_id')
                    ->select(
                        'signup.id',
                        'signup.clinicname',
                        'signup.state',
                        'signup.nature',
                        'signup.district',
                        'signup.email',
                        'signup.mobile',
                        'signup.address',
                        'surrogacyclinic.appstatus',
                        's_applicationno.applicationno'
                    )
                    ->where(['surrogacyclinic.appstatus'=> 'Pending','surrogacyclinic.status'=>1])
                    ->orderBy('signup.clinicname', 'ASC'),

                default => null,
            };

            if ($query) {
                $results = $query->get();
                $output = '<option value="">Select</option>';
                foreach ($results as $row) {
                    $output .= "<option value=\"{$row->id}\">{$row->clinicname}, {$row->state}, {$row->district}</option>";
                }
                return response()->json($output);
            } else {
                return response()->json('<option value="">No clinics found</option>');
            }
        }

        return response()->json('<option value="">No clinic type or status received</option>');
    }

    public function fetchClinicDetails(Request $request)
    {
        $clinicType = $request->input('clinicType');
        $statusType = $request->input('statusType');
        $clinicId = $request->input('to_name_clinic_fetch_reg');

        if (!$clinicType || !$statusType || !$clinicId) {
            return response()->json(['error' => 'Invalid parameters'], 400);
        }

        $query = null;

        if ($clinicType === 'ART' && $statusType === 'Registered') {
            $query = DB::table('signup')
                ->join('artclinic_certificate_details', 'signup.id', '=', 'artclinic_certificate_details.userid')
                ->join('artclinic', 'signup.id', '=', 'artclinic.userid')
                ->select(
                    'signup.clinicname',
                    'signup.state',
                    'signup.district',
                    'signup.pincode',
                    'signup.email',
                    'signup.contactno',
                    'signup.address',
                    'artclinic_certificate_details.registration_no',
                    'artclinic_certificate_details.application_no'
                )
                ->where('signup.id', $clinicId)
                ->where('artclinic.status',1)
                ->where('artclinic_certificate_details.approved_rejected','Registration Granted')
                ->orderBy('signup.clinicname');
        } elseif ($clinicType === 'Surrogacy' && $statusType === 'Registered') {
            $query = DB::table('signup')
                ->join('surrogacy_certificate_details', 'signup.id', '=', 'surrogacy_certificate_details.userid')
                ->join('surrogacyclinic', 'signup.id', '=', 'surrogacyclinic.userid')
                ->select(
                    'signup.clinicname',
                    'signup.state',
                    'signup.district',
                    'signup.pincode',
                    'signup.email',
                    'signup.contactno',
                    'signup.address',
                    'surrogacy_certificate_details.registration_no',
                    'surrogacy_certificate_details.application_no'
                )
                ->where('signup.id', $clinicId)
                ->where('surrogacyclinic.status',1)
                ->where('surrogacy_certificate_details.approved_rejected','Registration Granted')
                ->orderBy('signup.clinicname');
        }

        $result = $query->first();

        if ($result) {
            return response()->json($result);
        }

        return response()->json([]);
    }

    public function fetchClinicApplicationDetails(Request $request)
    {
        $clinicType = $request->input('clinicType');
        $statusType = $request->input('statusType');
        $clinicId = $request->input('to_name_clinic_fetch_app');

        if (!$clinicType || !$statusType || !$clinicId) {
            return response()->json(['error' => 'Invalid parameters'], 400);
        }

        $query = null;

        if ($clinicType === 'ART' && $statusType === 'Applied for') {
            $query = DB::table('signup')
                ->join('artclinic', 'signup.id', '=', 'artclinic.userid')
                ->join('clinic_applicationno', 'artclinic.id', '=', 'clinic_applicationno.clinic_id')
                ->select(
                    'signup.id',
                    'signup.clinicname',
                    'signup.state',
                    'signup.pincode',
                    'signup.nature',
                    'signup.district',
                    'signup.email',
                    'signup.mobile',
                    'signup.address',
                    'artclinic.appstatus',
                    'artclinic.userid',
                    'clinic_applicationno.applicationno'
                )
                ->where('signup.id', $clinicId)
                ->where('artclinic.status',1)
                ->orderBy('signup.clinicname');
        } elseif ($clinicType === 'Surrogacy' && $statusType === 'Applied for') {
            $query = DB::table('signup')
                ->join('surrogacyclinic', 'signup.id', '=', 'surrogacyclinic.userid')
                ->join('s_applicationno', 'surrogacyclinic.id', '=', 's_applicationno.surrogacy_id')
                ->select(
                    'signup.id',
                    'signup.clinicname',
                    'signup.state',
                    'signup.pincode',
                    'signup.nature',
                    'signup.district',
                    'signup.email',
                    'signup.mobile',
                    'signup.address',
                    'surrogacyclinic.appstatus',
                    'surrogacyclinic.userid',
                    's_applicationno.applicationno'
                )
                ->where('signup.id', $clinicId)
                ->where('surrogacyclinic.status',1)
                ->orderBy('signup.clinicname');
        }

        $result = $query->first();

        if ($result) {
            return response()->json($result);
        }

        return response()->json([]);
    }
    public function fetchClinicDataFromm(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'clinicType' => 'required|string',
            'statusType' => 'required|string',
            'from_name_clinic_fetch_reg' => 'required|string'
        ]);

        // Retrieve the request data
        $clinicType = $validatedData['clinicType'];
        $statusType = $validatedData['statusType'];
        $clinicRegistrationId = $validatedData['from_name_clinic_fetch_reg'];

        // Determine the table and perform the query
        if ($clinicType === "ART Clinic" && $statusType === "Registered") {
            $userDetails = DB::table('signup')
                ->join('artclinic_certificate_details', 'signup.id', '=', 'artclinic_certificate_details.userid')
                ->select(
                    'signup.id',
                    'signup.clinicname',
                    'signup.state',
                    'signup.district',
                    'signup.pincode',
                    'signup.email',
                    'signup.contactno',
                    'signup.address',
                    'artclinic_certificate_details.registration_no',
                    'artclinic_certificate_details.application_no'
                )
                ->where('signup.id', $clinicRegistrationId)
                ->where('artclinic_certificate_details.approved_rejected','Registration Granted')
                //->groupBy('signup.clinicname')
                ->orderBy('signup.clinicname', 'ASC')
                ->first();
        } elseif ($clinicType === "Surrogacy Clinic" && $statusType === "Registered") {
            $userDetails = DB::table('signup')
                ->join('surrogacy_certificate_details', 'signup.id', '=', 'surrogacy_certificate_details.userid')
                ->select(
                    'signup.id',
                    'signup.clinicname',
                    'signup.state',
                    'signup.district',
                    'signup.pincode',
                    'signup.email',
                    'signup.contactno',
                    'signup.address',
                    'surrogacy_certificate_details.registration_no',
                    'surrogacy_certificate_details.application_no'
                )
                ->where('signup.id', $clinicRegistrationId)
                ->where('surrogacy_certificate_details.approved_rejected','Registration Granted')
                ->orderBy('signup.clinicname', 'ASC')
                ->first();
        } else {
            // Return an error response for invalid clinic type or status type
            return response()->json(['error' => 'Invalid clinic type or status type'], 400);
        }

        // Check if user details exist
        if ($userDetails) {
            return response()->json($userDetails);
        }

        // Return an empty response if no data is found
        return response()->json([]);
    }

    public function nocClinicFetchAppFrom(Request $request)
    {
        $clinicType = $request->input('clinicType');
        $statusType = $request->input('statusType');
        $clinicId = $request->input('from_name_clinic_fetch_app');

        if (!$clinicType || !$statusType || !$clinicId) {
            return response()->json(['error' => 'Invalid parameters'], 400);
        }

        $query = null;
        if ($clinicType == "ART Clinic" && $statusType == "Applied for") {
            $query = DB::table('signup')
                ->join('artclinic', 'signup.id', '=', 'artclinic.userid')
                ->join('clinic_applicationno', 'artclinic.id', '=', 'clinic_applicationno.clinic_id')
                ->where('signup.id', $clinicId)
                ->where('artclinic.status',1)
                ->select('signup.*', 'artclinic.appstatus', 'clinic_applicationno.applicationno')
                ->first();
        } elseif ($clinicType == "Surrogacy Clinic" && $statusType == "Applied for") {
            $query = DB::table('signup')
                ->join('surrogacyclinic', 'signup.id', '=', 'surrogacyclinic.userid')
                ->join('s_applicationno', 'surrogacyclinic.id', '=', 's_applicationno.surrogacy_id')
                ->where('signup.id', $clinicId)
                ->where('surrogacyclinic.status',1)
                ->select('signup.*', 'surrogacyclinic.appstatus', 's_applicationno.applicationno')
                ->first();
        }

        return response()->json($query ?? []);
    }


    private function generateApplicationNo($latestForm, $transfer, $transferOf, $purposeOfTransfer)
    {
        $year = Carbon::now()->year;
        $prefix = 'NOC';

        // Check transfer type (Within India or Outside India)
        if ($transfer === 'Within India') {
            $transferPrefix = 'WI';
        } elseif ($transfer === 'Outside India') {
            $transferPrefix = 'Exp'; // "Exp" for Export (Outside India)
        } else {
            throw new Exception("Invalid transfer type provided.");
        }

        // Define transfer_of prefix for multiple values
        $transferOfMapping = [
            'Embryos' => 'Emb',
            'Sperms' => 'S',
            'Oocytes' => 'O',
        ];

        if (is_array($transferOf)) {
            $transferOfPrefix = array_map(function ($item) use ($transferOfMapping) {
                return $transferOfMapping[$item] ?? throw new Exception("Invalid transfer_of value: $item");
            }, $transferOf);

            $transferOfPrefix = implode('-', $transferOfPrefix);
        } else {
            throw new Exception("transfer_of must be an array.");
        }

        // Define purpose_of_transfer suffix
        $purposeSuffix = match ($purposeOfTransfer) {
            'Invitro Fertilization' => 'IVF',
            'Surrogacy' => 'Surrogacy',
            'Future Cryopreservation' => 'Cry',
            default => throw new Exception("Invalid purpose_of_transfer value provided."),
        };

        // Generate serial number
        if ($latestForm) {
            $ano = $latestForm->application_no;
            $serialNumber = (int)substr($ano, -7, 3) + 1; // Extract and increment last 3 digits of serial number
            $serialNumber = str_pad($serialNumber, 3, '0', STR_PAD_LEFT);
        } else {
            $serialNumber = '001'; // Start at 001 if no previous record exists
        }

        // Combine to form the application number
        return "{$prefix}/{$transferPrefix}/{$transferOfPrefix}/{$year}/{$purposeSuffix}/{$serialNumber}-DHR";
    }

    private function handleFileUploads(Request $request, $nocForm, $application_no)
    {
        // dd($request->all(), $nocForm, $application_no);
        //$allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
        $allowedExtensions = ['pdf'];
        $docMasters = DB::table('doc_masters')
            ->whereIn('doc_type', [
                            'target_file_affidavit_embryos_outside',
                            'target_file_affidavit_gametes_outside',
                            'target_file_affidavit_embryos_within',
                            'target_file_affidavit_gametes_within',
                            'target_file_affidavit_clinic_holding_embryos',
                            'target_file_affidavit_clinic_holding_gametes',
                            'target_file_affidavit_clinic_receiving_embryos',
                            'target_file_affidavit_clinic_receiving_gametes',
                            'target_file_copy_aadhar',
                            'target_file_copy_passport',
                            'target_file_copy_aadhar_card_spouse',
                            'target_file_copy_passport_spouse',
                            'target_file_dob_proof_applicant',
                            'target_file_dob_proof_spouse',
                            'target_file_other_docs',
                            'target_file_sign_spouse',
                            'copy_of_identity_proof_applicant',
                            'copy_of_identity_proof_spouse',
                            'oci_applicant_file',
                            'oci_spouse_file',
                            'target_file_ssn',
                            'target_file_declaration_applicant',
                            'target_file_sign_applicant',
            ])
            ->where('status', 1)
            ->select('doc_type', 'status', 'doc_desc', 'id', 'doc_master_id')
            ->get();

    
        $User = $this->getUserdata();

        $rawFolder = $application_no; 
        $newappno = sanitizeFolderName($rawFolder);

        // $url = url('/');
        // $parsed_url = parse_url($url);
        // $newUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        // $baseUrl = "$newUrl/artprojfiles/noc_application/";

        foreach ($docMasters as $docMaster) {

            $fileKey = str_replace('target_file_', '', $docMaster->doc_type);

            if ($request->hasFile($fileKey)) {

                $file = $request->file($fileKey);
                $extension = $file->getClientOriginalExtension();

                if (in_array(strtolower($extension), $allowedExtensions)){
                    // $directoryName = "D:/xampp/htdocs/webprodfiles/noc_application/{$newappno}/applicant/";
                    $foldername   = 'noc_application';
                    $directoryName     = folderpath($foldername) . "/{$newappno}/applicant/";
                    $filename = $docMaster->doc_type . '-' . Carbon::now()->format('d-m-Y') . '-' .Carbon::now()->timestamp . '.' . $extension;
                    $filePath = $file->move($directoryName, $filename);
                    $dbpath = $filename;

                    DocFileUpload::create([
                            'noc_user_id' => $User->id,
                            'app_id' => $nocForm->id,
                            'doc_id' => $docMaster->id,
                            'doc_type' => $docMaster->doc_type,
                            'upload_desc' => $docMaster->doc_desc,
                            'doc_master_id_ref' => $docMaster->doc_master_id,
                            'doc_upload_ref' => $dbpath,
                            'created_at'     =>  Carbon::now()->format('Y-m-d H:i:s')
                    ]);


                    // Optionally, log or display the uploaded file details
                    Log::debug('File uploaded:', ['filename' => $filename, 'filePath' => $filePath]);
                } else {
                    // Log or display an error if the extension is not allowed
                    Log::warning('Invalid file extension for doc type:', ['docType' => $docMaster->doc_type, 'extension' => $extension]);
                }
            } else {
                // Log or display if no file was uploaded for the doc type
                Log::warning('No file uploaded for doc type:', ['docType' => $docMaster->doc_type]);
            }
        }
    }



    public function submitForm(Request $request)
    {


        $validator = Validator::make($request->all(), [
       
            'name_applicant'                       => 'required|string',
            'gender'                               => 'required|string',
            'nationality_applicant'                => 'required|string',
            'm_status'                             => 'required|string',
            'mobileno'                             => 'required',
            'email'                                => 'required|email',
            'transfer'                             => 'required|string',
            'transfer_of'                          => 'required|array|min:1',
            'embryos_number'                       => 'required_if:transfer_of,1|nullable',
            'sperm_vials'                          => 'required_if:transfer_of,1|nullable',
            'oocytes_number'                       => 'required_if:transfer_of,1|nullable',
            'purpose_of_transfer'                  => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if (($request->input('m_status') == 'Unmarried' || 
                                                                    $request->input('m_status') == 'Divorced' || 
                                                                    $request->input('m_status') == 'Widow') && 
                                                                    $request->input('gender') == 'Man' && 
                                                                    ($request->input('nationality_applicant') == 'Indian' || $request->input('nationality_applicant') == 'Foreigner') &&
                                                                    $request->input('transfer') == 'Within India' &&
                                                                    $value != 'Future Cryopreservation'){
                                                                    $fail("Future Cryopreservation is mondatory");

                                                               }else if(($request->input('m_status') == 'Unmarried' || 
                                                                    $request->input('m_status') == 'Divorced' || 
                                                                    $request->input('m_status') == 'Widow') && 
                                                                    $request->input('gender') == 'Man' && 
                                                                    ($request->input('nationality_applicant') == 'Indian' || $request->input('nationality_applicant') == 'Foreigner') &&
                                                                    $request->input('transfer') == 'Outside India' &&
                                                                    $value != 'Future Cryopreservation'){
                                                                $fail("Future Cryopreservation is mondatory");

                                                               }else if($request->input('m_status') == 'Married' && 
                                                                    $request->input('gender') == 'Man' && 
                                                                    $request->input('nationality_applicant') == 'Indian' && $request->input('nationality_spouse') == 'Foreigner' &&
                                                                    $request->input('transfer') == 'Within India' &&
                                                                    $value == 'Surrogacy'){
                                                                 $fail("Future cryopreservation or in vitro fertilization is mandatory.");

                                                               }else if($request->input('m_status') == 'Married' && 
                                                                    $request->input('gender') == 'Man' && 
                                                                    $request->input('nationality_applicant') == 'Foreigner' && $request->input('nationality_spouse') == 'Foreigner' &&
                                                                    $request->input('transfer') == 'Within India' &&
                                                                    $value == 'Surrogacy'){
                                                                 $fail("Future cryopreservation or in vitro fertilization is mandatory.");

                                                                }else if($request->input('m_status') == 'Unmarried' && 
                                                                    $request->input('gender') == 'Woman' && 
                                                                    ($request->input('nationality_applicant') == 'Indian' || $request->input('nationality_applicant') == 'Foreigner') &&
                                                                    $request->input('transfer') == 'Within India' &&
                                                                    $value == 'Surrogacy'){
                                                                 $fail("Future cryopreservation or in vitro fertilization is mandatory.");

                                                                }else if($request->input('m_status') == 'Unmarried' && 
                                                                    $request->input('gender') == 'Woman' && 
                                                                    $request->input('nationality_applicant') == 'Indian' &&
                                                                    $request->input('transfer') == 'Outside India' &&
                                                                    $value == 'Surrogacy'){
                                                                 $fail("Future cryopreservation or in vitro fertilization is mandatory.");

                                                                }else if(($request->input('m_status') == 'Divorced' || 
                                                                    $request->input('m_status') == 'Widow') && 
                                                                    $request->input('gender') == 'Woman' && 
                                                                    $request->input('nationality_applicant') == 'Foreigner' &&
                                                                    $request->input('transfer') == 'Within India' &&
                                                                    $value == 'Surrogacy'){
                                                                 $fail("Future cryopreservation or in vitro fertilization is mandatory.");

                                                                }else if($request->input('m_status') == 'Married' && 
                                                                    $request->input('gender') == 'Woman' && 
                                                                    $request->input('nationality_applicant') == 'Indian' && $request->input('nationality_spouse') == 'Foreigner' &&
                                                                    $request->input('transfer') == 'Within India' &&
                                                                    $value == 'Surrogacy'){
                                                                 $fail("Future cryopreservation or in vitro fertilization is mandatory.");

                                                               }else if($request->input('m_status') == 'Married' && 
                                                                    $request->input('gender') == 'Woman' && 
                                                                    $request->input('nationality_applicant') == 'Foreigner' && $request->input('nationality_spouse') == 'Foreigner' &&
                                                                    $request->input('transfer') == 'Within India' &&
                                                                    $value == 'Surrogacy'){
                                                                 $fail("Future cryopreservation or in vitro fertilization is mandatory.");

                                                               }else if(empty($value)){
                                                                  $fail("Please select purpose_of_transfer");
                                                               }
                                                        }
                                                        
                                                    ],
            'passport_applicant'                   => 'required_if:nationality_applicant,Foreigner|nullable',
            'voterid_applicant'                    => '',
            'pan_applicant'                        => '',
            'aadhar_applicant'                     => '',
            'country'                              => 'required_if:transfer,Outside India|nullable',
            
            'status_clinic'                        => 'required|string',
            'status_from_clinic'                   => 'required|string',
            'to_status_clinic'                     => 'required_if:status_from_clinic,Not Registered|nullable',
            'from_name_clinic'                     => '',
            'from_name_clinic1'                    => '',
            'from_doctor'                          => 'required|string',
            'to_doctor'                            => 'required|string',
            
            'from_name_clinic2'                    => 'required_if:status_from_clinic,Not Registered|nullable',
            'from_address'                         => 'required_if:status_from_clinic,Not Registered|nullable',
            'f_pincode'                            => 'required_if:status_from_clinic,Not Registered|nullable',
            'f_state'                              => 'required_if:status_from_clinic,Not Registered|nullable',
            'f_district'                           => 'required_if:status_from_clinic,Not Registered|nullable',
            'f_contact'                            => 'required_if:status_from_clinic,Not Registered|nullable',
            'f_email'                              => 'required_if:status_from_clinic,Not Registered|nullable', 

            'to_address'                           => 'required_if:transfer,Outside India|nullable',
            't_pincode'                            => 'required_if:transfer,Within India|nullable',
            't_state'                              => 'required_if:transfer,Within India|nullable',
            't_district'                           => 'required_if:transfer,Within India|nullable',
            't_contact'                            => 'required_if:transfer,Outside India|nullable',
            't_email'                              => 'required_if:transfer,Outside India|nullable',
            'identity_proof_applicant'             => '',
            'copy_passport'                        => '', 
            'ssn'                                  => '',
            
            'sign_applicant'                       => 'required',
            'dob_proof_applicant'                  => 'required',
            'dob_proof_ap'                         => 'required',
            'gender_sp'                            => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if ($request->input('m_status') === 'Married' && empty($value)) {
                                                                $fail("Please select gender of spouse.");
                                                            }
                                                        }
                                                        
                                                    ],
            'name_spouse'                          => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if($request->input('m_status') === 'Married' && empty($value)){
                                                                $fail("Please select Name of spouse");
                                                            }
                                                        }
                                                    ],
            'nationality_spouse'                   => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if($request->input('m_status') === 'Married' && empty($value)){ 
                                                                $fail("Please select Nationality of spouse");
                                                            }

                                                          }
                                                        
                                                    ],
            'country_applicant_spouse'             => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if($request->input('m_status') === 'Married' && $request->input('nationality_spouse') === 'Foreigner' && empty($value)){
                                                                $fail("Please select Country applicant of spouse");
                                                             }
                                                        }
                                                    ],
            'email_spouse'                         => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if($request->input('m_status') === 'Married' && empty($value)){
                                                                $fail("Please select Email of spouse");
                                                            }
                                                        }
                                                    ],
            'countryCode'                          =>[ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['m_status']) === 'Married' || !empty($request['m_status']) != 'Married'){
                                                                if(empty($value)){
                                                                $fail("Please select Country code");
                                                            }

                                                        }
                                                        }
                                                    ],
            'country_code_sp'                      => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if($request->input('m_status') === 'Married' && empty($value)){
                                                                 $fail("Please select Country code of spouse");
                                                             }
                                                        }
                                                    ],
            'mobile_spouse'                        => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if($request->input('m_status') === 'Married' && empty($value)){
                                                               $fail("Please select Mobile number of spouse");
                                                            }

                                                        }
                                                        
                                                    ],
            'voterid_spouse'                       => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['m_status']) === 'Married'){
                                                                if(empty($request['passport_spouse']) && empty($request['aadhar_spouse']) && empty($request['pan_spouse']) && empty($request['value'])){
                                                                   $fail("Please select Voter id of spouse");
                                                                 }

                                                            }
                                                        }
                                                    ],
            'passport_spouse'                      => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['m_status']) === 'Married'){
                                                                if(empty($request['voterid_spouse']) && empty($request['aadhar_spouse']) && empty($request['pan_spouse']) && empty($request['value'])){
                                                                $fail("Please select Voter id of spouse");
                                                            }

                                                        }
                                                        }
                                                    ],
                                                    
            'pan_spouse'                           => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['m_status']) === 'Married'){
                                                                if(empty($request['voterid_spouse']) && empty($request['aadhar_spouse']) && empty($request['passport_spouse']) && empty($request['value'])){
                                                                $fail("Please select Voter id of spouse");
                                                            }

                                                        }
                                                        }
                                                    ],
            'oci_spouse'                           => 'nullable',
            'dob_spouse'                           => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['m_status']) === 'Married'){
                                                                if(empty($value)){
                                                                $fail("Please select Date of birth of spouse");
                                                            }

                                                        }
                                                        }
                                                    ],
            'identity_proof_applicant_spouse'      => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['m_status']) === 'Married'){
                                                                if(empty($value)){
                                                                $fail("Please select Identity Proof Applicant Spouse");
                                                            }

                                                        }
                                                        }
                                                    ],
            'copy_aadhar_card_spouse'              => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['m_status']) === 'Married'){
                                                                if(empty($value)){
                                                                $fail("Please select copy aadhar card Spouse");
                                                            }

                                                        }
                                                        }
                                                    ],
            'copy_of_identity_proof_spouse'        => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['m_status']) === 'Married'){
                                                                if(empty($value)){
                                                                $fail("Please select copy of identity proof spouse");
                                                            }

                                                        }
                                                        }
                                                    ],

            'country_applicant'                    => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['m_status']) === 'Married' && $request['nationality_applicant'] === 'Foreigner'){
                                                                if(empty($value)){
                                                                $fail("Please select Country applicant");
                                                            }

                                                        }
                                                        }
                                                    ],
            'zipcode'                              => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['m_status']) === 'Married' && $request['nationality_applicant'] === 'Foreigner'){
                                                                if(empty($value)){
                                                                $fail("Please select Zipcode applicant");
                                                            }

                                                        }
                                                        }
                                                    ],
            'address'                              => 'required',
            'pincode'                              => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['m_status']) === 'Married' && $request['nationality_applicant'] === 'Indian'){
                                                                if(empty($value)){
                                                                $fail("Please select Pincode applicant");
                                                            }

                                                        }
                                                        }
                                                    ],
            'state'                                => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['m_status']) === 'Married' && $request['nationality_applicant'] === 'Indian'){
                                                                if(empty($value)){
                                                                $fail("Please select State applicant");
                                                            }

                                                        }
                                                        }
                                                    ],
            'district'                             => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['m_status']) === 'Married' && $request['nationality_applicant'] === 'Indian'){
                                                                if(empty($value)){
                                                                $fail("Please select District applicant");
                                                            }

                                                        }
                                                        }
                                                    ],
            'dob_applicant'                        => [
            
            function ($attribute, $value, $fail) use ($request) {
                if(!empty($value)){
                    $date1 = Carbon::now();
                    $date2 = Carbon::parse($value);
                    $year = $date1->diffInYears($date2);


                                   if($request['gender'] == 'Woman' && $request['purpose_of_transfer'] == 'Surrogacy' && $request['m_status'] == 'Divorced'){

                                                if (!empty($year) < 34 || !$year > 44) {
                                                    $fail("Age of applicant should be between 35 and 45 years.");  
                                                }

                                            }else if($request['gender'] === 'Woman' && $request['purpose_of_transfer'] === 'Surrogacy' && $request['m_status'] === 'Widow'){
                    
                                                if ($year < 35 || $year > 45) {
                    
                                                    $fail("Age of applicant should be between 35 and 45 years.");
                                                
                                                }
                    
                                            }else if($request['gender'] === 'Man' && $request['purpose_of_transfer'] === 'Surrogacy' && $request['m_status'] === 'Divorced'){
                                                    $fail("if applicant is man and choose divore and widow ?");
                                                    
                                                
                                            }else if($request['gender'] === 'Man' && $request['purpose_of_transfer'] === 'Future Cryopreservation' && $request['m_status'] === 'Unmarried'){
                                                    if ($year < 21 || $year > 55) {
                                                       // dd($year);
                                                    $fail("Age of applicant should be between 21 and 55 years.");
                                                
                                                }                            
                    
                                            }else if($request['gender'] === 'Man' && $request['purpose_of_transfer'] === 'Surrogacy' && $request['m_status'] === 'Widow'){
                                                $fail("if applicant is man and choose divore and widow ?");
                        
                                            }else if($request['gender'] === 'Man' && $request['purpose_of_transfer'] === 'Future Cryopreservation' && ($request['m_status'] === 'Divorced' || $request['m_status'] === 'Widow')){
                    
                                                if ($year < 21 || $year > 55) {
                                                    $fail("Age of applicant should be between 21 and 55 years.");
                                                
                                                }
                    
                                            }else if($request['gender'] === 'Man' && $request['m_status'] === 'Married' && $request['nationality_spouse'] === 'Foreigner' && ($request['purpose_of_transfer'] === 'Invitro Fertilization' || $request['purpose_of_transfer'] === 'Future Cryopreservation')){
                    
                                                if ($year < 21 || $year > 55) {
                                                    $fail("Age of applicant should be between 21 and 55 years");
                                                    
                                                }
                    
                                            }else if($request['gender'] === 'Man' && $request['m_status'] === 'Married' && ($request['purpose_of_transfer'] === 'Invitro Fertilization' || $request['purpose_of_transfer'] === 'Future Cryopreservation')){
                    
                                                if ($year < 21 || $year > 55) {
                                                    $fail("Age of applicant should be between 21 and 55 years.");
                                                    
                                                }
                    
                                            }else if($request['gender'] === 'Man' && $request['m_status'] === 'Married' && ($request['purpose_of_transfer'] === 'Invitro Fertilization' || $request['purpose_of_transfer'] === 'Future Cryopreservation')){
                    
                                                if ($year < 21 || $year > 55) {
                                                    $fail("Age of applicant should be between 21 and 55 years.");
                                                
                                                }
                    
                                            }else if($request['gender'] === 'Man' && $request['m_status'] === 'Married' && ($request['purpose_of_transfer'] === 'Invitro Fertilization' || $request['purpose_of_transfer'] === 'Future Cryopreservation')){
                    
                                                if ($year < 21 || $year > 55) {
                                                    $fail("Age of applicant should be between 21 and 55 years.");
                                                    
                                                }
                    
                                            }else if($request['gender'] === 'Man' && $request['purpose_of_transfer'] === 'Surrogacy'){
                    
                                                if ($year < 26 || $year > 55) {
                                                    $fail("Age of applicant should be between 26 and 55 years.");
                                                    
                                            }
                    
                                            }else if($request['gender'] === 'Woman' && $request['purpose_of_transfer'] === 'Surrogacy'){
                    
                                                if ($year < 23 || $year > 50) {
                                                    $fail("Age of applicant should be between 23 and 50 years.");
                                                
                                                }
                    
                                            }else if($request['gender'] === 'Woman') {
                    
                                                if ($year < 21 || $year > 50) {
                                                    $fail("Age of applicant should be between 21 and 50 years.");
                                                
                                                }
                                            }else if($request['gender'] === 'Man'){
                    
                                                if ($year < 26 || $year > 55) {
                                                    $fail("Age of applicant should be between 26 and 55 years.");
                                                    
                                                }
                    
                                            }
                                    }else{
                                        if (empty($value)){
                                        $fail('Date of birth of applicant is required.');
                                        }
                                    } 
                        }

                        
                 ],
            
            'affidavit_embryos_outside'            => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['transfer_of'][0]) === 'Embryos' && $request['transfer'] === 'Outside India'){
                                                                if(empty($value)){
                                                                $fail("Please upload this file affidavit_embryos_outside!");
                                                            }

                                                        }
                                                        }
                                                    ],
            'affidavit_gametes_outside'            => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                                if(!empty($request['transfer_of'][0]) === 'Sperms' && $request['transfer'] === 'Outside India'){
                                                                    if(empty($value)){
                                                                    $fail("Please upload this file affidavit_embryos_outside!");
                                                                }

                                                            }
                                                            }
                                                        ],
            'affidavit_embryos_within'             => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                                if(!empty($request['transfer_of'][0]) === 'Embryos' && $request['transfer'] === 'Within India'){
                                                                    if(empty($value)){
                                                                    $fail("Please upload this file affidavit_embryos_within!");
                                                                }

                                                            }
                                                            }
                                                        ],
            'affidavit_gametes_within'             => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                        if((!empty($request['transfer_of'][1]) === 'Sperms' || !empty($request['transfer_of'][2]) === 'Oocytes') && $request['transfer'] === 'Within India'){
                                                            if(empty($value)){
                                                            $fail("Please upload this file affidavit_gametes_within!");
                                                        }

                                                    }
                                                    }
                                                ],
            'affidavit_clinic_holding_embryos'     => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                                if(!empty($request['transfer_of'][0]) === 'Embryos' && ($request['transfer'] === 'Within India' || $request['transfer'] === 'Outside India')){
                                                                        if(empty($value)){
                                                                        $fail("Please upload this file affidavit_clinic_holding_embryos!");
                                                                    }

                                                                }
                                                        }
                                                        ],
            'affidavit_clinic_holding_gametes'     => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if((!empty($request['transfer_of'][1]) === 'Sperms' || !empty($request['transfer_of'][2]) === 'Oocytes')  && ($request['transfer'] === 'Within India' || $request['transfer'] === 'Outside India')){
                                                                    if(empty($value)){
                                                                    $fail("Please upload this file affidavit_clinic_holding_gametes!");
                                                                }

                                                            }
                                                        }
                                                    ],
            'affidavit_clinic_receiving_embryos'   => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['transfer_of'][0]) === 'Embryos' && ($request['transfer'] === 'Within India' || $request['transfer'] === 'Outside India')){
                                                                if(empty($value)){
                                                                $fail("Please upload this file affidavit_clinic_receiving_embryos!");
                                                            }

                                                        }
                                                        }
                                                    ],
            'affidavit_clinic_receiving_gametes'   => [ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if((!empty($request['transfer_of'][1]) === 'Sperms' || !empty($request['transfer_of'][2]) === 'Oocytes')  && ($request['transfer'] === 'Within India' || $request['transfer'] === 'Outside India')){
                                                                if(empty($value)){
                                                                $fail("Please upload this file affidavit_clinic_receiving_gametes!");
                                                            }

                                                        }
                                                        }
                                                    ],
            'dob_proof_sp'                         =>[ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['m_status']) === 'Married'){
                                                                  if(empty($value)){
                                                                  $fail("Please select Date birth proof spouse");
                                                             }

                                                           }
                                                        }
                                                     ],
            'dob_proof_spouse'                      =>[ 
                                                        function ($attribute, $value, $fail) use ($request) {
                                                            if(!empty($request['m_status']) === 'Married'){
                                                                  if(empty($value)){
                                                                  $fail("Please select Date birth proof spouse file");
                                                             }

                                                           }
                                                        }
                                                     ], 
            'copy_of_identity_proof_applicant'     => 'required',
            'oci_applicant'                        => 'nullable',
            'oci_applicant_file'                   => '',
            'oci_applicant_spouse'                 => ''

        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Start the transaction
        try {
            DB::beginTransaction();
            //   DB::enableQueryLog();
            $User = $this->getUserdata();
            $data = $request->all();
            $latestForm = nocform::orderBy('created_at', 'desc')->first(); // Retrieve the latest record

            $transfer = $request->transfer; // "Within India" or "Outside India"
           /// dd($transfer);
            $transferOf        = $request->transfer_of; // Array e.g., ["Embryos", "Sperms"]
            $purposeOfTransfer = $request->purpose_of_transfer; // Purpose like "Surrogacy", etc.
            // Generate the application number
            $application_no = $this->generateApplicationNo($latestForm, $transfer, $transferOf, $purposeOfTransfer);
            
            // Prepare the data for insertion            
            $data['transfer_of'] = implode(',', $request->transfer_of);
            $data['application_no'] = $application_no;  // Assign the generated application number

            $data['noc_userid'] = $User->id;  // Assign the generated application number         

            $emailDetails = [
                'name_applicant' => $data['name_applicant'],
                //'transfer_type' => $transfer,
                'application_no' => $application_no,
            ];

            Mail::to($data['email'])->send(new NOCFormMail($emailDetails));
          //  dd($data);
            $latestForm = new nocform($data); // Create a new instance with the data
          //  dd($latestForm);
           // dd(now());

            $latestForm->save(); 
        //    dd(DB::getQueryLog());

            $this->handleFileUploads($request, $latestForm, $application_no);

            $appId = $latestForm->id;
            $service_id = 1;
            $level_id = 1;
            $action_taken_by = 'Submitted By User';
            $is_active = 'Yes';
            $remarks = 'user application submitted';
            $get_userid = nextActor($level_id, $appId, $service_id);
            //dd($get_userid);
  
            DB::table('work_flow_table')->insert([
                'application_id'   => $latestForm->id,
                'service_id'       => $service_id,
                'level_id'         => $level_id,
                'user_id'          => $get_userid ?? null,
                'remarks'          => $remarks,
                'is_active'        => $is_active,
                'action_taken_by'  => $action_taken_by,
                'submission_date'  => Carbon::now()->format('Y-m-d H:i:s'),
            ]);


            DB::commit();

            return redirect()->route('noc.add_noc_application_form')
                ->with('success', 'Application No: ' . $application_no . ' Your Application has been successfully Submitted !');
            return redirect()->route('noc.nocForm_list')->with('success', $application_no);
        } catch (\Exception $e){
            // In case of an error, rollback the transaction
            DB::rollBack();
            //dd($e->getMessage());
            // Optionally log the error
            log::error("Error inserting data: " . $e->getMessage());

            return redirect()->route('noc.add_noc_application_form')->with('error', 'Failed to insert data!');
        }
    }



    public function nocForm_list()
    {

        // $url = url('/');
        // $parsed_url = parse_url($url);
        // $newUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        // $baseUrl = "$newUrl/artprojfiles/noc_application/";
        if (empty(Session::has('id'))) {
            return redirect()->route('noc.loginnocform');
        }

        $userId = Session::get('id');

        $data = new UserNoc();
        $nocformList = $data->myapplication($userId);
        $nocformList_foreigner = $data->myapplication_foreigner($userId);

        return view('layouts.noc.noc_form_list', compact('nocformList','nocformList_foreigner'));
    }


    public function nocForm_view($id)
    {
      
        if (empty(Session::has('id'))) {
            return redirect()->route('noc.loginnocform');
        }

        // $url = url('/');
        // $parsed_url = parse_url($url);
        // $newUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        // $baseUrl = "$newUrl/artprojfiles/noc_application/";

        try {
              
            $decryptedId = Crypt::decrypt($id);
          // dd($decryptedId);
            $application = nocform::findOrFail($decryptedId);
            // dd($application);
            $app_id = $application->id;

            // Fetch the clinic names from the signup table
            $clinicIds = [$application->from_name_clinic, $application->to_name_clinic]; // IDs to fetch
            $clinicNames = DB::table('signup')
                ->whereIn('id', $clinicIds)
                ->pluck('clinicname', 'id');


            $fromClinicName = $clinicNames[$application->from_name_clinic] ?? null;
            $toClinicName   = $clinicNames[$application->to_name_clinic] ?? null;


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
          // dd($app_id);
            $get_docfileData = DB::table('doc_file_uploads')
                ->where('doc_file_uploads.app_id', $app_id)
                ->orderBy('doc_master_id_ref','ASC')
                ->get();

                
            // dd($application);
            // Return the view with the record data
            return view('layouts.noc.noc_form_view', compact('application', 'get_docfileData', 'fromClinicName', 'toClinicName', 'CountryName'));
        } catch (DecryptException $e) {
            //Handle invalid or tampered encrypted ID
            abort(404, 'Invalid ID');
        }
    }
    public function nocgeneratePdf($id)
    {
        ///dd('sdfsdfsd');
        // $url = url('/');
        // $parsed_url = parse_url($url);
        // $newUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        // $baseUrl = "$newUrl/artprojfiles/noc_application/";

        $decryptedId = Crypt::decrypt($id);
        $application = nocform::findOrFail($decryptedId);
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

       // dd($get_docfileData);

    
        // Load the view and pass data
        $pdf = Pdf::loadView('layouts.noc.application_pdf', compact('application', 'get_docfileData', 'fromClinicName', 'toClinicName', 'CountryName'));
        //dd($pdf);
        // Optionally, stream or download the PDF
        return $pdf->stream('application_pdf.pdf');
        // For download: return $pdf->download('application_details.pdf');
    }


    //****************************add on 18-12-2024*******************************

    public function myapplication()
    {
        $uid = session()->get('id');
        // dd($uid);
        $data = new UserNoc();
        $userdata = $data->myapplication_query_raised($uid);
        $userdata_foreigner = $data->myapplication_query_raised_foreigner($uid);
        

        // dd($userdata);
        return view('layouts.noc.myapplication', compact('userdata','userdata_foreigner'));
    }


    public function noc_genrate_list_user()
    {

        // $url = url('/');
        // $parsed_url = parse_url($url);
        // $newUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        // $baseUrl = "$newUrl/artprojfiles/noc_application/";

        $uid = session()->get('id');
        $data = new UserNoc();
        $userdata = $data->noc_genrate_view($uid);
        return view('layouts.noc.noc_genrate_user_view_list', compact('userdata'));
    }


public function download($token)
{
     try {
        // Decrypt the token to get the relative path inside art/storage
        $filePath = Crypt::decryptString($token);

        // Prevent directory traversal attack
        if (str_contains($filePath, '..')) {
            abort(403, 'Invalid file path.');
        }

        // Return file to browser
        return response()->file($filePath);

    } catch (\Exception $e) {
        abort(403, 'Invalid or expired file link.');
    }
}



    public function add_user_remarks(Request $request)
    {

        $uid = session()->get('id');
        $validated = $request->validate([
            'application_id'       => 'required|integer',
            'remarks'              => '',
            'uploadremarks.*'      => '',
            'level_action'         => 'required|integer',
            'uploadfile.*'         => 'file|mimes:pdf|max:250000',
            'uploadfileMedical.*'  => 'file|mimes:pdf|max:512000',
            'medical_report'        => '',
            'created_at'           => 'required'
        ]);

        try {
             DB::beginTransaction();
            $medicalReport = isset($validated['medical_report']) ? $validated['medical_report'] : '';
            $uplodremr = $validated['uploadremarks'];
            $arr1 = isset($validated['uploadfileMedical']) ? $validated['uploadfileMedical'] : [];

            $noc_user_id = $uid;
            $doc_id = 24;
            $doc_master_id_ref = 900;
            $doc_type = doc_type($doc_id);
            $arr2 = isset($validated['uploadfile']) ? $validated['uploadfile'] : [];
            $application_id = $validated['application_id'];
            $service_id = 1;
            $remarks = $validated['remarks'];
            $level_id = $validated['level_action'];
            $is_active = "YES";
            $get_userid = nextActor($level_id, $application_id, $service_id);

            $pre_level = $level_id - 1;
            $currentDate = Carbon::now()->format('Y-m-d');


        $receiving_date = previoucs_date_wfd($application_id,$pre_level);

            if (!empty($arr1)) {
                $files = array_merge($arr1, $arr2);
            } else {
                $files = $request->file('uploadfile');
            }

            $rawFolder   = $request->application_no;
           
            $newAppNo    = sanitizeFolderName($rawFolder);
           
            // $basePath    = "D:/xampp/htdocs/webprodfiles/noc_application/{$newAppNo}/";
            $foldername   = 'noc_application';
            $basePath     = folderpath($foldername) . "/{$newAppNo}/";
            $applicantPath = $basePath . 'applicant/';
   

            if (!is_dir($basePath)) {
                Log::error("Base directory does not exist: {$basePath}");
                return;
            }

        // Ensure registry directory exists
            if (!is_dir($applicantPath) && !mkdir($applicantPath, 0777, true)) {
                Log::error("Failed to create applicant directory: {$applicantPath}");
                return;
            }

        if (!empty($files) && is_array($files)) {
            $i = 0;
            $now = Carbon::now();
            $date = $now->format('d-m-Y');
            $timestamp = $now->timestamp;

            foreach ($files as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $safeName = preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
                $uniqueFileName = strtolower($safeName) . "_{$date}_{$timestamp}." . $extension;
                $fileMimeType = $file->getMimeType();

                $uploadDesc = $uplodremr[$i] ?? '';

                if ($fileMimeType === 'application/pdf' && $extension === 'pdf') {
                    $destinationPath = $applicantPath;
                        $file->move($destinationPath, $uniqueFileName);
                        $dbPath = $uniqueFileName;

                        DB::table('doc_file_uploads')->insert([
                            'noc_user_id'       => $noc_user_id,
                            'app_id'            => $application_id,
                            'doc_id'            => $doc_id,
                            'doc_type'          => $doc_type,
                            'doc_upload_ref'    => $dbPath,
                            'doc_master_id_ref' => $doc_master_id_ref,
                            'upload_desc'       => $uploadDesc,
                            'created_at'        => now()
                        ]);
                   
                }

                $i++;
            }
        }

       
        DB::table('work_flow_table')
            // ->where('level_id', $pre_level)
            ->where('service_id', $service_id)
            ->where('application_id', $application_id)
            ->where('is_active', 'YES')
            ->update([
                'submission_date' => $currentDate,
                'action_date' => $currentDate,
                'remarks' => $remarks,
                'noc_user' => 1,
                'query_raised_by' => $get_userid,
                'is_active' => 'NO',
                'submission_date' =>Carbon::now()->format('Y-m-d H:i:s'),
                'action_date' => Carbon::now()->format('Y-m-d H:i:s')
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
            'submission_date' =>Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::commit();
        return redirect()->route('noc.nocForm_list')->with('success_user_add', 'Application has been submitted successfully!');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Transaction failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Something went wrong. Please try again.');
            }
    }
    
    public function front_user_attachment($cry_id, $cry_level_id)
    {


        $id = Crypt::decrypt($cry_id);

        // $url = url('/');
        // $parsed_url = parse_url($url);
        // $newUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        // $baseUrl = "$newUrl/artprojfiles/noc_application/";


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
                'doc_file_uploads.created_at as created_at',  
                'doc_file_uploads.updated_at as updated_at'  
            )

            ->where('doc_file_uploads.app_id', $id)
            ->where('doc_file_uploads.doc_id', '!=', 99)
            ->get();
        //dd($getdata_front_attach);


        return view('layouts.noc.front_user_attachement', compact('getdata_front_attach', 'view_attachment', 'cry_id', 'cry_level_id'));
    }
    public function back_user_attachment($cry_id, $cry_level_id)
    {
        $id = Crypt::decrypt($cry_id);
        // $url = url('/');
        // $parsed_url = parse_url($url);
        // $newUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        // $baseUrl = "$newUrl/artprojfiles/noc_application/";

        $uid = session()->get('id');
        $view_back_attachment = DB::table('noc_form')->where('id', $id)->first();

       $getbackdata = DB::table('doc_file_uploads')
                        ->join('user_table', 'doc_file_uploads.noc_user_id', '=', 'user_table.userid')
                        ->where('doc_file_uploads.app_id', $id)
                        ->where('doc_file_uploads.doc_id', 99)
                        ->select(
                            'user_table.First_name',
                            'user_table.Last_name',
                            'doc_file_uploads.id',
                            'doc_file_uploads.noc_user_id',
                            'doc_file_uploads.app_id',
                            'doc_file_uploads.doc_id',
                            'doc_file_uploads.upload_desc',
                            'doc_file_uploads.doc_upload_ref',
                            'doc_file_uploads.created_at',
                            'doc_file_uploads.updated_at'
                            // add other columns from doc_file_uploads if needed
                        )
                      ->get();
          //dd($getbackdata);

        return view('layouts.noc.user_back_attachment', compact('getbackdata', 'view_back_attachment', 'cry_id', 'cry_level_id'));
    }



    public function view_user_application($cry_id, $cry_level_id)
    {
    
        // $url = url('/');
        // $parsed_url = parse_url($url);
        // $newUrl = $parsed_url['scheme'] . '://' . $parsed_url['host'];
        // $baseUrl = "$newUrl/artprojfiles/noc_application/";

        $id = Crypt::decrypt($cry_id);
        $application = DB::table('noc_form')->where('id', $id)->first();
        $get_docfileData = DB::table('doc_file_uploads')
            ->where('doc_file_uploads.app_id', $application->id)
            ->orderBy('doc_file_uploads.doc_master_id_ref', 'ASC')
            ->get();

        //dd($application);

        return view('layouts.noc.view_user_application', compact('application', 'cry_id', 'cry_level_id', 'get_docfileData'));
    }

    public function view_user_remarks($cry_id, $cry_level_id)
    {
        $id = Crypt::decrypt($cry_id);
        $ide = '';
        $uid = session()->get('id');
        //dd($uid);

        $view_back_attachment = DB::table('noc_form')->where('id', $id)->first();
        $view_user_remarks = DB::table('work_flow_table')
            ->leftJoin('noc_form', function ($join) {
                $join->on('work_flow_table.user_id', '=', 'noc_form.noc_userid')
                    ->on('work_flow_table.application_id', '=', 'noc_form.id');
            })
            ->leftJoin('user_table', 'user_table.userid', '=', 'work_flow_table.user_id')
            ->where('work_flow_table.application_id', $id)
            ->where('work_flow_table.query_raised_by', '!=', '')
            ->where('work_flow_table.query_raised_by', $uid)//add this code
            ->orderBy('work_flow_table.id', 'asc')
            ->get();



        //dd($view_user_remarks);

        return view('layouts.noc.view_user_remarks', compact('view_user_remarks', 'view_back_attachment', 'id', 'cry_id', 'cry_level_id'));
    }


    public function view_user_form($cry_id, $cry_level_id)
    {
        $id = Crypt::decrypt($cry_id);
        $level_id = Crypt::decrypt($cry_level_id);
        $role = session()->get('role');
        $userid = session()->get('id');

        $level_id = $level_id;
        $nocForm = DB::table('noc_form')->where('id', $id)->first();
        $created_at = date("Y-m-d", strtotime($nocForm->created_at));
        $noc_enc = $id;

        $medical_status = DB::table('work_flow_table')
            ->where('application_id', $id)
            ->where('level_id', $level_id)
            ->where('user_id', $userid)
            ->first();


        $links = [
            'view_user_application' => 'View Application',
            'front_user_attachment' => "My Attachment's",
            'back_user_attachment'  => 'Back Attachment',
            'view_user_remarks'     => 'Remarks',
        ];

        $linkColors = [
            'view_user_application' => '#105f73',
            'front_user_attachment' => '#412904',
            'back_user_attachment' => '#0e471c',
            'view_user_remarks' => '#710d0d',
        ];

        $tabcss = 'col-xl-3';
        return view('layouts.noc.view_user_form', compact('medical_status', 'nocForm', 'links', 'linkColors', 'tabcss', 'noc_enc', 'role', 'level_id', 'created_at'));
    }




    public function nocPdf($id)
    {

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
        //$qr_data = "NOC Number = XXXXXX" . $iec_number . ", Name = " . $results->sending_applicant_name . ",  NOC No = " . $results->noc_number . ",    Application No =" . $results->application_number . ",    Purpose Of =" . $purpose_of;
        $qrcode = QrCode::size(400)->generate($qr_data);
        //dd($qr_data);
        // Load the view and pass data
        // $pdf = Pdf::loadView('layouts.noc.noc_pdf', compact('application','qrcode','currentDate', 'fromClinicName', 'toClinicName','CountryName'));

        $pdf = Pdf::loadView('layouts.noc.noc_pdf', compact('application', 'qrcode', 'currentDate', 'fromClinicName', 'toClinicName', 'CountryName'))
            ->setOptions([
                'isRemoteEnabled' => true, // Enable fetching images from remote URLs
            ]);

        // Optionally, stream or download the PDF
        return $pdf->download('noc_pdf.pdf');
        // For download: return $pdf->download('application_details.pdf');

    }

    public function downloadPDF($type)
    {
        switch ($type) {
            case 'form_17.pdf':
                $filePath = public_path("pdf_format/" . $type);

                break;

            case 'form_18.pdf':
                $filePath = public_path("pdf_format/" . $type);
                break;

            case 'form_19.pdf':
                $filePath = public_path("pdf_format/" . $type);
                break;

            case 'form_20.pdf':
                $filePath = public_path("pdf_format/" . $type);
                break;

            case 'form_21.pdf':
                $filePath = public_path("pdf_format/" . $type);
                break;

            case 'form_22.pdf':
                $filePath = public_path("pdf_format/" . $type);
                break;

            case 'form_23.pdf':
                $filePath = public_path("pdf_format/" . $type);
                break;

            case 'form_24.pdf':
                $filePath = public_path("pdf_format/" . $type);
                break;


            case 'hin_form_17.pdf':
                $filePath = public_path("pdf_format/" . $type);

                break;

            case 'hin_form_18.pdf':
                $filePath = public_path("pdf_format/" . $type);
                break;

            case 'hin_form_19.pdf':
                $filePath = public_path("pdf_format/" . $type);
                break;

            case 'hin_form_20.pdf':
                $filePath = public_path("pdf_format/" . $type);
                break;

            case 'hin_form_21.pdf':
                $filePath = public_path("pdf_format/" . $type);
                break;

            case 'hin_form_22.pdf':
                $filePath = public_path("pdf_format/" . $type);
                break;

            case 'hin_form_23.pdf':
                $filePath = public_path("pdf_format/" . $type);
                break;

            case 'hin_form_24.pdf':
                $filePath = public_path("pdf_format/" . $type);
                break;

            case 'declaration_applicant.pdf':
                $filePath = public_path("pdf_format/" . $type);
                break;

            default:
                abort(404, 'PDF type not found.');
        }

        // dd($filePath);

        if (File::exists($filePath)) {
            return response()->download($filePath);
        }
    }
}
