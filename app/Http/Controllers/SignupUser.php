<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\LoginOtp;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\clinic\signup;
use App\Mail\SignupUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Mail\SignupUserforgetpassword;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\LoginAttempt;
use Illuminate\Support\Facades\Log;
use App\Models\clinic\ClinicRegistrationModel;
use App\Models\renewal\RenewalSCApplication;
use Illuminate\Contracts\Encryption\DecryptException;
use Exception;

class SignupUser extends Controller
{
    public function index2()
    {
    //    dd(session()->all());

      
     //  dd($count);
       //return view('layouts/clinic/dashboard');
        if (session()->has('id')) {
            return redirect()->route('clinic.loginclinicform');
        } else {
            // dd(session()->all());
            $clinic = ClinicRegistrationModel::where('clinic_type','ARTCLINIC')->where('status',1)->count();
            $bank = ClinicRegistrationModel::where('clinic_type','ARTBANK')->where('status',1)->count();
            $surrogacy = ClinicRegistrationModel::where('clinic_type','ARTSURROGACY')->where('status',1)->count();

            $reject_application = RenewalSCApplication::where('appstatus', 'Rejected')
            ->get()
            ->groupBy('clinic_type')
            ->map(function($group) {
                return $group->count();
            });
            $re_artclinic = $reject_application['ARTCLINIC'] ?? 0;
            $re_artbank = $reject_application['ARTBANK'] ?? 0;
            $re_surrogacy = $reject_application['ARTSURROGACY'] ?? 0;

            // dd($re_artclinic, $re_artbank,$re_surrogacy );
            return view('layouts/clinic/dashboard',compact('clinic','bank','surrogacy','re_artclinic','re_artbank','re_surrogacy'));
        }
    }
    public function requestclinicSignUp()
    {

        return view('layouts/clinic/signup');
    }
    public function signup_submiited_msg()
    {
        // if(empty(Session::has('id'))){
        //          return redirect()->route('clinic.loginclinicform');
        //     }
        //dd("i am here");
        return view('layouts/clinic/signup_submitted_msg');
        Session::put('user_login', 'No');
    }
    public function requestSignUpData(Request $request)
    {
        // dd('hello');
        $request->validate([
            'clinicname' => 'required|string|max:255|regex:/^[A-Za-z0-9\s&()]+$/|not_regex:/[<>]/',
            'address' => 'required|string|max:255',
            'pincode' => 'required|regex:/^[0-9]{6}$/|not_regex:/[<>]/',
            'state' => 'required|string',
            'district' => 'required|string',
            'nature' => 'required|in:Government,Private',
            //'contactno' => 'required|regex:/^[0-9]{11}$/',
            'personname' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/|not_regex:/[<>]/',
            'email' => 'required|email|max:100|not_regex:/<[^>]*>/',
            'v_email' => 'required|same:email|not_regex:/<[^>]*>/',
            'mobile' => 'required|regex:/^[0-9]{10}$/|not_regex:/[<>]/',
            'v_mobile' => 'required|same:mobile|not_regex:/[<>]/',
            'email_contact_person' => 'required|email|max:100|not_regex:/<[^>]*>/',
            'v_email_contact_person' => 'required|email|same:email_contact_person|not_regex:/<[^>]*>/',
            'captcha' => 'required|captcha',
        ], [
            'clinicname.regex' => 'Clinic name must only contain letters and spaces.',
           // 'contactno.regex' => 'Contact number must be an 11-digit number.',
            'v_email.same' => 'The email addresses must match.',
            'mobile.regex' => 'The mobile number must be a valid 10-digit number.',
            'v_mobile.same' => 'The mobile numbers must match.',
            'email.not_regex' => 'HTML tags are not allowed in the email.',
            'v_email.not_regex' => 'HTML tags are not allowed in the verify email.',
            'mobile.not_regex' => 'HTML tags are not allowed in the mobile number.',
            'v_mobile.not_regex' => 'HTML tags are not allowed in the verify mobile number.',
            'email_contact_person.not_regex' => 'HTML tags are not allowed in the email of contact person.',
            'v_email_contact_person.same' => 'The confirmation email must match.',
            'v_email_contact_person.not_regex' => 'HTML tags are not allowed in the verify email of contact person.',
             'captcha.required' => 'The CAPTCHA is required.',
             'captcha.captcha' => 'The CAPTCHA verification failed. Please try again.',
        ]);
        $add_data = new signup(); // Assuming 'RequestTable' is the model
        $add_data->clinicname = $request->input('clinicname');
        $add_data->address = $request->input('address');
        $add_data->pincode = $request->input('pincode');
        $add_data->state = $request->input('state');
        $add_data->district = $request->input('district');
        $add_data->nature = $request->input('nature');
        $add_data->contactno = $request->input('contactno');
        $add_data->personname = $request->input('personname');
        $add_data->email = $request->input('email');
        $add_data->mobile = $request->input('mobile');
        $add_data->email_contact_person = $request->input('email_contact_person');
    // Generate a random token
        $token = Str::random(32);
        $add_data->token = $token;
        // Session::put('toke', $token);

    // Encrypt the email
        $encryptedEmail = Crypt::encryptString($add_data->email);

    // Store the current time for link generation
        $linkGeneratedAt = now();
        Session::put('linkGeneratedAt', $linkGeneratedAt);

        DB::beginTransaction();
        try {
            // Save the user data to the database
            $add_data->save();
            // Check OTP and expiration (if applicable)
            $linkGeneratedAt = Session::get('linkGeneratedAt');
            if ($linkGeneratedAt && now()->diffInMinutes($linkGeneratedAt) <= 2) {
                // Construct the verification link
                $link = url("signup-verified-form?email={$encryptedEmail}&token={$token}");
                
                // Prepare email data
                $signuprequestform = [
                'link' => $link,
                ];
                // Send the email
                Mail::to($add_data->email)->send(new SignupUserRequest($signuprequestform));
            } else {
                return response()->json(['error' => 'Link expired or invalid'], 400);
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::warning('signup failed', [
                'ip' => $request->ip(),
                'encrypted_email' => $request->input('email'),
                'error' => $e->getMessage(),
            ]);
            DB::rollBack(); // Something went wrong → cancel all changes
            throw $e; // Optionally re-throw the exception (or handle it)
        }

        //->with('link', $link);
        return redirect()->route('clinic.signup_submiited_msg')->with('success', 'Form Submitted Successfully.Please click the password Generation link sent to your email Id to Complete the Registration Process.');
        //return redirect()->back()->with('success', 'Form Submitted Successfully.Please click the password Generation link sent to your email Id to Complete the Registration Process.');
    }
   public function resend_verification_link()
    {
        return view('layouts/clinic/resend-verification-link');
    }

    public function resend_verification_email(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'captcha' => 'required|captcha'

            ],
            ['captcha.captcha' => 'Invalid captcha code.']
        );
        $data = $request->except("_token");

        list($name, $domain) = explode('@', $request->email);
        $visiblePart = substr($name, 0, 3);
        $maskedPart = str_repeat('*', strlen($name) - 3);
        $maskedEmail = $visiblePart . $maskedPart . '@' . $domain;


        $exists = signup::where('email', $data['email'])->where('status',0)->first();

        if (!$exists) {
            return redirect()->route('clinic.resendLink')->with("failure","Either email is already verified or not exits.");
        }

        // Generate a secure token
        $token = Str::random(60);

        // Encrypt the email
        $encryptedEmail = Crypt::encryptString($request->email);
        
        $link = url("signup-verified-form?email={$encryptedEmail}&token={$token}");
        // Save the token in your password resets table or another appropriate location
        DB::table('signup')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'updated_at' => now(),
            ]
        );

        $signuprequestform = [
                'link' => $link,
                ];
                // Send the email
            Mail::to($request->email)->send(new SignupUserRequest($signuprequestform));

        return redirect()->route('clinic.resendLink')->with("success","A verification link has been sent to ".$maskedEmail." address, if it is registered with us.");

    }
    public function requestreloadCaptcha()
    {
        //echo "Check1";dd();
        return response()->json(['captcha' => captcha_img()]);
    }

    public function checkEmail(Request $request)
    {
        // dd("test");
        $email = $request->input('email');

        if (!$email) {
            return response()->json(['status' => 'error', 'message' => 'Email is required'], 400);
        }

        $exists = signup::where('email', $email)->exists();

        if ($exists) {
            return response()->json(['status' => 'exists']);
        }

        return response()->json(['status' => 'available']);
    }
    public function verifiedSignUp(Request $request)
    {
        try {
        $ses = Session::get('id');
        $encryptedtoken = $request->token;
        if (!$request->email) {
            Log::warning('verification link not valid - email not present in the link', [
                'ip'      => $request->ip(),
                'token'   => $encryptedtoken,
            ]);
            return redirect()->route('error.accesschange');
        }
        $decryptedEmail = Crypt::decryptString($request->email);
        $encryptedEmail = $request->email;
        $get_user = DB::table('signup')->where('email', $decryptedEmail)->where('status', 0)->first();
        if (!$get_user) {
            // session(['statuss' => 'valhjnghnhgue']);
            Log::warning('verification link not valid - user not found', [
                'ip'      => $request->ip(),
                'token'   => $encryptedtoken,
            ]);
            return redirect()->route('clinic.dashboardsgs');
        }
        // dd($get_user->token,'   ', $request->token);
        if($get_user->token == $request->token){
            Session::put('user_login', 'No');
            return view('layouts/clinic/verifiedform', compact('get_user','encryptedEmail','encryptedtoken'));
        }else{
            Log::warning('verification link not valid - token not valid or unknown reason', [
                'ip'      => $request->ip(),
                'token'   => $encryptedtoken,
            ]);
            return redirect()->route('error.accesschange');
            //return view('layouts/clinic/verifiedform', compact('get_user','encryptedEmail','encryptedtoken'));
            //return "verify";
        }
        } catch (DecryptException $e) {
        Log::warning('Email decryption failed', [
            'ip' => $request->ip(),
            'encrypted_email' => $request->email,
            'error' => $e->getMessage(),
        ]);
        return redirect()->route('error.accesschange');
        } catch (\Throwable $e) {
            Log::error('Unexpected error during access change verification', [
                'ip' => $request->ip(),
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('error.accesschange');
        }
    }
    public function create_password_clinic_msg()
    {
        // if(empty(Session::has('id'))){
        //          return redirect()->route('clinic.loginclinicform');
        //     }
        return view('layouts/clinic/verifiedform_submitted_msg');
        Session::put('user_login', 'No');
    }
    public function verifiedreloadCaptcha()
    {
        //echo "Check1";dd();
        return response()->json(['captcha' => captcha_img()]);
    }
    public function verifiedSignUpdata(Request $request)
    {
        
        // dd($request->all());

        // Validation rules
        // dd("test");
        $validator = Validator::make($request->all(), [
            'password' => [
                'required',
                'string',
                'max:50',
                'min:8', // Minimum length
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[0-9]/', // At least one number
                'regex:/[\W]/', // At least one special character
                'confirmed' // Matches with password_confirmation field
            ],
            'captcha' => 'required|captcha'
        ], [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'password.confirmed' => 'Passwords do not match.',
            'captcha.required' => 'Captcha is required.',
            'captcha.captcha' => 'Invalid captcha entered.'
        ]);
            // If validation fails
            // dd("test1");
        if ($validator->fails()) {
            Log::warning('Password not created - validation failed', [
                'ip'      => $request->ip(),
                'token'   => $request->encryptedtoken,
                'errors'  => $validator->errors()->toArray(),
            ]);
            return redirect()->route('clinic.verified_clinic_signup', [
                                    'email' => $request->encryptedEmail,
                                    'token' => $request->encryptedtoken,
                                    ])->withErrors($validator)->withInput();
        }

        $decryptedEmail = Crypt::decryptString($request->encryptedEmail);
        $userRequest = Signup::where('email', $decryptedEmail)->first(); // Example logic
        if (!$userRequest) {
            return redirect()->route('clinic.loginclinicform')->withErrors(['message' => 'User request not found.']);
        }else{
            // Check if a record exists in the verified table for this user request
            // $userVerified = Signup::where('id', $userRequest->id)->first();
            // dd($userVerified);
            if ($userRequest->status) {
                // If password is already set, redirect to login or show a message
                return redirect()->route('clinic.loginclinicform')->with('message', 'Password already created. Please log in.');
            }
            $newPassword = bcrypt($request->input('password'));
            $userRequest->update(['password' => $newPassword,'status' => 1]);

            return redirect()->route('clinic.create_password_clinic_msg')->with('success', 'Password created successfully. Kindly click on login.');


        }

       // return redirect()->back()->with('success', 'Password created successfully. Kindly click on login');
    }

    public function showLoginForm_clinic()
    {
        return view('layouts/clinic/loginclinicform');
        //Session::invalidate();
        //Session::regenerate();
        Session::put('user_login', 'No');

    }
    public function signupshowForgotPasswordForm()
    {
        return view('layouts/clinic/signup-forgot-password');
    }
    public function forgetreloadCaptcha()
    {
        //echo "Check1";dd();
        return response()->json(['captcha' => captcha_img()]);
    }

    public function signupsendResetLinkEmail(Request $request)
    {
        //dd($request->all());
        $request->validate(
            [
                'email' => 'required|email|exists:signup,email',
                'captcha' => 'required|captcha'

            ],
            ['captcha.captcha' => 'Invalid captcha code.']
        );

        // Find the user ID in the user_request_table
        $userRequest = DB::table('signup')->where('email', $request->email)->where('status', 1)->exists();

        if (!$userRequest) {
            return redirect()->route('password.request_signup')->withErrors(['email' => 'Email address is not verified.']);
        }

        // Generate a secure token
        $token = Str::random(60);

        // Encrypt the email
        $encryptedEmail = Crypt::encryptString($request->email);

        // Construct the custom link
        $link = url("signup-reset-password?email={$encryptedEmail}&token={$token}");

        // Save the token in your password resets table or another appropriate location
        DB::table('signup')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Prepare the email content
        $signuppasswordrequest = [
            'link' => $link,
        ];

        // Send the email
        Mail::to($request->email)->send(new SignupUserforgetpassword($signuppasswordrequest));

        // Return success message
        return back()->with(['status' => 'A password reset link has been sent to your email address.']);
    }
    public function signupshowResetForm(Request $request)
    {
        $decryptedEmail = Crypt::decryptString($request->email);
        $get_user = DB::table('signup')->where('email', $decryptedEmail)->first();
        //dd($get_user);
        return view('layouts/clinic/signup-reset-password', compact('get_user'));
    }
    public function signupresetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|max:50|min:8|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/|confirmed',
            //'password' => ['required', 'confirmed'],
        ]);
        //  $pp = $request->all();
        // Get user_request_table record
        $userRequest = DB::table('signup')->where('email', $request->email)->first();
        if (!$userRequest) {
            return back()->withErrors(['email' => 'Invalid email address.']);
        }

        // Get user_verified_table record using the foreign key
        // $userVerified = DB::table('user_verified_table')
        //     ->where('user_request_id', $userRequest->id)
        //     ->first();
        if (!$userRequest) {
            return back()->withErrors(['email' => 'No associated user found.']);
        }
        //check last password should not match:
        if (Hash::check($request->password, $userRequest->password)) {
            //dd($storedHashedPassword);
            return back()->withErrors(['email' => 'New password should not be the same as last one']);
        } else {
                // Update the password in user_verified_table
                DB::table('signup')
                    ->where('id', $userRequest->id)
                    ->where('status',1)
                    ->update([
                        'password' => Hash::make($request->password),
                        'updated_at' => now(),
                    ]);
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('clinic.loginclinicform')->with('status', 'Password reset successfully!');
        }
    }
    public function showLoginForm_clinic_data(Request $request)
    {
        //decryption starts here
            Log::info('Login method triggered', [
            'ip' => $request->ip(),
            'email' => $request->input('email')
        ]);
        $encryptedPassword = $request->input('_password');

        $privateKey = file_get_contents(storage_path('app/rsa/private.key'));
        $decrypted = null;
        


        if (!openssl_private_decrypt(base64_decode($encryptedPassword), $decrypted, $privateKey)) {
            Log::error('Password decryption failed', ['encrypted' => $encryptedPassword]);
            return back()->withErrors(['password' => 'Decryption failed.']);
        }
        Log::info('Password decryption successful');

        // Merge decrypted password into request for validation
        $request->merge(['password' => $decrypted]);
        //decryption ends here
        //dd($decrypted);
        // Validate input fields
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
                'captcha' => 'required|captcha'

            ],
            ['captcha.captcha' => 'Invalid captcha code.']
        );

        $email = $request->input('email');
        $password = $request->input('password');
        // dd($password);
        // // decryption of client side password
        // $encryptedPassword = base64_decode($password);
        // $privateKey = Storage::get('rsa/private.key');
        // openssl_private_decrypt($encryptedPassword, $decryptedPassword, $privateKey, OPENSSL_PKCS1_OAEP_PADDING);

        // Retrieve the user along with the related verified data
        //$user = signup::with('clinic_reg_no.surrogacy_reg_no')->where('email', $request->email)->first();
        $user = signup::with(['artclinics','clinic_reg_no', 'surrogacy_reg_no', 'bank_reg_no'])->where('email', $request->email)->where('status',1)->first();
        if(!empty($user)){
            $cr = ClinicRegistrationModel::where('userid_applicant', $user->id)->where('status',1)->get();
            if(!empty($cr)){
                foreach($cr as $c){
                    if (!empty($c) && in_array($c->clinic_type, ['ARTCLINIC', 'ARTBANK','ARTSURROGACY'])) {
                        $data[] = $c->clinic_type; 
                    }
                }
            }
        $registration_and_application_no_all = $cr->mapWithKeys(function ($item) {
                            return [$item->clinic_type =>  [
                                'registration_no' => $item->registration_no,
                                'application_no'  => $item->application_no,
                            ]
                        ];
                        })->toArray();   
        }
        // dd($registration_and_application_no_all);
        // $user = signup::with(['clinic_reg_no',
        //     'clinic_reg_no.surrogacy_reg_no',
        //     'clinic_reg_no.bank_reg_no'
        // ])->where('email', $request->email)->first();
        //dd($user);
        //$user = signup::where('email', $email)->with('verifiedData')->first();
        if ($user && Hash::check($password, $user->password)) {
        //if ($user && $user->verifiedData && Hash::check($password, $user->verifiedData->password)) {
            // Store email in session
            $request->session()->put('email', $user->email);
            $request->session()->put('clinicname', $user->clinicname);
            $request->session()->put('id', $user->id);
            $request->session()->put('state', $user->state);
            $request->session()->put('user_type', 1);
            if(!empty($data)){ 
                Session::put('clinic_bank_surrogacy', $data);
            }
            //$usertype = LoginAttempt::where('userid', session('id'))
            //            ->latest()
            //             ->value('user_type');
          // dd($user->state);
            if (array_key_exists('ARTCLINIC', $registration_and_application_no_all)) {
                $request->session()->put('user_type', 1);
                $request->session()->put('patient_artclinic_cliniclevel', $user->artclinics->cliniclevel);
                $request->session()->put('patient_artclinic_registration_no', $registration_and_application_no_all['ARTCLINIC']['registration_no']);
                $request->session()->put('patient_artclinic_application_no', $registration_and_application_no_all['ARTCLINIC']['application_no']);
                $request->session()->put('patient_clinic_type', 'patient_artclinic');  // Store clinic type
            }
            if (array_key_exists('ARTSURROGACY', $registration_and_application_no_all)) {
                $request->session()->put('user_type', 2);
                $request->session()->put('patient_surrogacy_registration_no', $registration_and_application_no_all['ARTSURROGACY']['registration_no']);
                $request->session()->put('patient_surrogacy_application_no', $registration_and_application_no_all['ARTSURROGACY']['application_no']);
                $request->session()->put('patient_surrogacy_type', 'patient_surrogacyclinic');  // Store clinic type
            }
            if (array_key_exists('ARTBANK', $registration_and_application_no_all)) {
                $request->session()->put('user_type', 3);
                $request->session()->put('patient_artbank_registration_no', $registration_and_application_no_all['ARTBANK']['registration_no']);
                $request->session()->put('patient_artbank_application_no', $registration_and_application_no_all['ARTBANK']['application_no']);
                $request->session()->put('patient_bank_type', 'patient_artbank');  // Store clinic type
            }


            $otp = rand(100000, 999999); // 6 digit OTP
            // Store OTP in session
            Session::put('login_otp', $otp);
            Session::put('otp_generated_at', now());
            // Prepare the email content
            $otprequest = [
                'link' => $otp,
            ];

            // Send the email
            // Mail::to($request->email)->send(new LoginOtp($otprequest));
            // Redirect to dashboard with a success message
            return redirect()->route('clinic.showOtpForm_clinic')->with('success', 'Please check the email to Verify the OTP.'.$otp);
            ///return redirect()->route('noc.dashboard')->with('success', 'Login successful!');
        }
        return redirect()->route('clinic.loginclinicform')->withErrors(['email' => 'Invalid credentials'])->withInput();
        // return redirect()->route('clinic.loginform')->withErrors(['email' => 'Invalid credentials'])->withInput();
        // return redirect(/)->back()->with('error','Invalid credentials');
    }
    public function reloadCaptchaclinic()
    {
        //echo "Check1";dd();
        return response()->json(['captcha' => captcha_img()]);
    }
    public function showOtpForm_clinic()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        Session::put('user_login', 'No');
        return view('layouts.clinic.login_otp');
    }
    public function otpreloadCaptcha()
    {
        //echo "Check1";dd();
        return response()->json(['captcha' => captcha_img()]);
    }

    public function verifyclinicOtpLogin(Request $request)
    {
        // Validate OTP
        $request->validate(
            [
                'login_otp' => 'required|numeric|digits:6',
                'captcha' => 'required|captcha'

            ],
            ['captcha.captcha' => 'Invalid captcha code.']
        );
        // Check if a user is already logged in
        // if (Session::has('user_logged_in')) {
        //     return redirect()->route('clinic.clinicForm_list')->withErrors(['login_otp' => 'Another user is already logged in. Please log out first.']);
        // }
        // Retrieve OTP from session
        $sessionOtp = Session::get('login_otp');
        $sessionOtp1 = Session::get('id');
        // dd($sessionOtp1);
        // dd($alloweduser);
        $otpGeneratedAt = Session::get('otp_generated_at');
        //dd($sessionOtp);
        // Check if OTP matches and is within the expiration time
        //dd(session()->all());
        //dd(session('user_type'));
        if ($sessionOtp && $sessionOtp == $request->login_otp && now()->diffInMinutes($otpGeneratedAt) <= 5) {


            $request->session()->regenerate();
            //dd(session()->all());
                // ✅ Bind session to fingerprint
                session([
                    'fingerprint' => [
                        'ip' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ]
                ]);
            // OTP is valid
            //dd(Session::getId());
            Session::forget(['login_otp', 'otp_generated_at']); // Clear OTP from session
            //LoginAttempt::where('userid', session('id'))->latest()->first();
            //print_r($sessionhistory);
            // ✅ Step 3: Invalidate any old session for this user
            $alloweduser = DB::table('verified_patient_reporting_clinics')->where('userid_applicant', $sessionOtp1)->where('is_valid_clinic', 1)->get();
            $allowed_clinic =          [
                        'ARTCLINIC' => 0,
                        'ARTBANK' => 0,
                        'ARTSURROGACY' => 0
                        ];
            if($alloweduser)
            {
                foreach ($alloweduser as $row) {
                    $key = $row->clinic_type; // convert to lowercase if needed
                    $allowed_clinic[$key] = 1;
                }
            }
            $request->session()->put('p_reporting', $allowed_clinic);
            // dd(session()->all());
            LoginAttempt::where('userid', session('id'))
                            ->where('user_type', session('user_type'))
                            ->whereNull('end_time')
                            ->update([
                                'end_time' => Carbon::now(),
                            ]);
            $sessionhistory = new LoginAttempt();
            $sessionhistory->start_time = Carbon::now();
            $sessionhistory->session_id = $request->session()->getId();
            $sessionhistory->id = LoginAttempt::max('id') + 1;
            $sessionhistory->userid = session('id');
            $sessionhistory->user_type = session('user_type');
            $sessionhistory->ip = $request->ip();
            $sessionhistory->save();
            //dd(session()->all());
            //Session::put('user_logged_in', true); // Mark the user as logged in
            
            return redirect()->route('clinic.clinicForm_list'); // Redirect to the home page or the dashboard
            //return redirect()->route('noc.dashboard')->with('success', 'Login successful!'); // Redirect to the home page or the dashboard
        } else {
            // OTP is invalid or expired
            return redirect()->route('clinic.showOtpForm_clinic')->withErrors(['login_otp' => 'Invalid or expired OTP.']);
        }
    }
}
