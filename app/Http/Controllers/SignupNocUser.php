<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\LoginOtp;
use App\Mail\UserRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\Userforgetpassword;
use App\Models\Noc\requesttable;
use App\Models\Noc\verifiedtable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\LoginAttempt;
use App\Models\Noc\countrytable;

class SignupNocUser extends Controller
{
    public function storeShaPass(Request $request)
    {
        session(['sha_password' => $request->input('sha_password')]);
        return response()->json(['status' => true]);
    }
    public function requestNocSignUp()
    {
        $countries = CountryTable::orderBy('country_name', 'asc')->get();


        return view('layouts.noc.requestform', compact('countries'));
    }
    public function requestNocSignUpData(Request $request)
    {
        //dd($request);
        $request->validate([
            'user_name' => [
                'required',
                'string',
                'max:255',
                'not_regex:/<[^>]*>/' // Disallow HTML tags
            ],
            'email' => [
                'required',
                'email',
                'not_regex:/<[^>]*>/' // Disallow HTML tags
            ],
            'v_email' => [
                'required',
                'same:email',
                'not_regex:/<[^>]*>/' // Disallow HTML tags
            ],

            'countryCode' => [
                'required',
                'same:countryCode' 
            ],

            'v_countryCode' => [
                'required',
                'same:countryCode' 
            ],

            'mobileno' => [
                'required',
                'regex:/^[0-9]{10}$/', // Validate 10-digit mobile number
                'not_regex:/<[^>]*>/' // Disallow HTML tags
            ],
            'v_mobileno' => [
                'required',
                'same:mobileno',
                'not_regex:/<[^>]*>/' // Disallow HTML tags
            ],
            'captcha' => [
                'required',
                'captcha' // Validate CAPTCHA using the "captcha" validation rule
            ],
        ], [
            'v_email.same' => 'The email addresses must match.',
            'mobileno.regex' => 'The mobile number must be a valid 10-digit number.',
            'v_countryCode.same' => 'The Country code must match.',
            'v_mobileno.same' => 'The mobile numbers must match.',
            'user_name.not_regex' => 'HTML tags are not allowed in the user name.',
            'email.not_regex' => 'HTML tags are not allowed in the email.',
            'v_email.not_regex' => 'HTML tags are not allowed in the verify email.',
            'mobileno.not_regex' => 'HTML tags are not allowed in the mobile number.',
            'v_mobileno.not_regex' => 'HTML tags are not allowed in the verify mobile number.',
            'captcha.required' => 'The CAPTCHA is required.',
            'captcha.captcha' => 'The CAPTCHA verification failed. Please try again.',
        ]);  
    $add_data = new requesttable(); // Assuming 'RequestTable' is the model
    $add_data->user_name = $request->input('user_name');
    $add_data->email = $request->input('email');
    $add_data->countryCode = $request->input('countryCode');
    $add_data->mobileno = $request->input('mobileno');
    
    // Generate a random token
    $token = Str::random(32);
    $add_data->token = $token;
    
    // Encrypt the email
    $encryptedEmail = Crypt::encryptString($add_data->email);
    
    // Store the current time for link generation
    $linkGeneratedAt = now();
    Session::put('linkGeneratedAt', $linkGeneratedAt);
    
    // Save the user data to the database
    $add_data->save();
    
    // Check OTP and expiration (if applicable)
    $linkGeneratedAt = Session::get('linkGeneratedAt');
//    dd($linkGeneratedAt);
    if ($linkGeneratedAt && now()->diffInMinutes($linkGeneratedAt) <= 2) {
        // Construct the verification link
        $link = url("verified-form?email={$encryptedEmail}&token={$token}");
        // dd($link);
        // Prepare email data
        $requestform = [
            'link' => $link,
        ];
    
        // Send the email
        Mail::to($add_data->email)->send(new UserRequest($requestform));
        }else{
            return response()->json(['error' => 'Link expired or invalid'], 400);
        }
        return redirect()->back()->with('success', 'Form Submitted Successfully.Please click the password Generation link sent to your email Id to Complete the Registration Process.');
    }
    public function requestreloadCaptcha()
    {
        //echo "Check1";dd();
        return response()->json(['captcha' => captcha_img()]);
    }
    public function checkEmailnoc(Request $request)
    {
        $email = $request->input('email');

        if (!$email) {
            return response()->json(['status' => 'error', 'message' => 'Email is required'], 400);
        }

        $exists = requesttable::where('email', $email)->exists();

        if ($exists) {
            return response()->json(['status' => 'exists']);
        }

        return response()->json(['status' => 'available']);
    }
    public function verifiedNocSignUp(Request $request)
    {

        // if(empty(Session::has('id'))){
        //     return redirect()->route('noc.loginnocform'); 
        // }
        // $ses = Session::get('id');
        // dd($request->email);
        //$get_user = requesttable::get()->first();
        $decryptedEmail = Crypt::decryptString($request->email);
        $get_user = DB::table('user_request_table')->where('email', $decryptedEmail)->first();
        //dd($emails);
        Session::put('user_login', 'No');
        return view('layouts/noc/verifiedform', compact('get_user'));
        //return "verify";
    }
    public function verifiedreloadCaptcha()
    {
        //echo "Check1";dd();
        return response()->json(['captcha' => captcha_img()]);
    }
    public function verifiedNocSignUpdata(Request $request)
    {

        // Validate the password fields
        $request->validate(
            [
                'password' => 'required|string|max:50|min:8|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/|confirmed',
                'captcha' => 'required|captcha'

            ],

            ['captcha.captcha' => 'Invalid captcha code.']
        );

        //dd($request->all());
        // Fetch the user_request_id (modify this based on your logic, e.g., using $request or auth)
        $userRequest = requesttable::where('email', $request->email)->first(); // Example logic

        if (!$userRequest) {
            return redirect()->back()->withErrors(['error' => 'User request not found.']);
        }
        $userVerified = verifiedtable::where('user_request_id', $userRequest->id)->first();

    if ($userVerified && isset($userVerified->password)) {
        // If password is already set, redirect to login or show a message
        return redirect()->route('noc.loginnocform')->with('message', 'Password already created. Please log in.');
    }

    // Create or update the user verified record
    if (!$userVerified) {
        $userVerified = new verifiedtable();
        $userVerified->user_request_id = $userRequest->id; // Set the foreign key
    }

    // Set the password and hash it
    $userVerified->password = bcrypt($request->input('password'));

    // Save the record
 

        if (!$userRequest) {
            return redirect()->back()->withErrors(['error' => 'User request not found.']);
        }

        // Save data into the user_verified_table
        $userVerified = new verifiedtable();
        $userVerified->password = bcrypt($request->input('password')); // Hash the password
        $userVerified->user_request_id = $userRequest->id; // Set the foreign key
        $userVerified->save();

        return redirect()->back()->with('success', 'Password created successfully. Kindly click on login');

         }
    public function showLoginForm_noc()
    {

        return view('layouts/noc/loginnocform');
        Session::invalidate();
        Session::regenerate();
        Session::put('user_login', 'No');
    }
    public function showForgotPasswordForm()
    {
        return view('layouts/noc/forgot-password');
    }
    public function forgetreloadCaptcha()
    {
        //echo "Check1";dd();
        return response()->json(['captcha' => captcha_img()]);
    }

    public function sendResetLinkEmail(Request $request)

    {
        //dd($request->all());
        $request->validate(
            [
                'email' => 'required|email|exists:user_request_table,email',
                'captcha' => 'required|captcha'

            ],

            ['captcha.captcha' => 'Invalid captcha code.']
        );

        // Find the user ID in the user_request_table
        $userRequest = DB::table('user_request_table')->where('email', $request->email)->exists();

        if (!$userRequest) {
            return back()->withErrors(['email' => 'Email address not found.']);
        }

        // Generate a secure token
        $token = Str::random(60);

        // Encrypt the email
        $encryptedEmail = Crypt::encryptString($request->email);

        // Construct the custom link
        $link = url("reset-password?email={$encryptedEmail}&token={$token}");

        // Save the token in your password resets table or another appropriate location
        DB::table('user_request_table')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Prepare the email content
        $passwordrequest = [
            'link' => $link,
        ];

        // Send the email
        Mail::to($request->email)->send(new Userforgetpassword($passwordrequest));

        // Return success message
        return back()->with(['status' => 'A password reset link has been sent to your email address.']);
    }
    public function showResetForm(Request $request)
    {
        $decryptedEmail = Crypt::decryptString($request->email);
        $get_user = DB::table('user_request_table')->where('email', $decryptedEmail)->first();
        //dd($emails);
        return view('layouts/noc/reset-password', compact('get_user'));
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|max:50|min:8|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/|confirmed',
            //'password' => ['required', 'confirmed'],
        ]);
        //  $pp = $request->all();   
        // Get user_request_table record
        $userRequest = DB::table('user_request_table')->where('email', $request->email)->first();
        if (!$userRequest) {
            return back()->withErrors(['email' => 'Invalid email address.']);
        }

        // Get user_verified_table record using the foreign key
        $userVerified = DB::table('user_verified_table')
            ->where('user_request_id', $userRequest->id)
            ->first();
        if (!$userVerified) {
            return back()->withErrors(['email' => 'No associated user found.']);
        }
        //check last password should not match:
        $storedHashedPassword = DB::table('user_verified_table')
                                ->where('user_request_id', $userRequest->id)
                                ->value('password');
        if (Hash::check($request->password, $storedHashedPassword)) {
            //dd($storedHashedPassword);
            return back()->withErrors(['email' => 'New password should not be the same as last one']);
        } else {
                 // Update the password in user_verified_table
                DB::table('user_verified_table')
                    ->where('user_request_id', $userRequest->id)
                    ->update([
                        'password' => Hash::make($request->password),
                    ]);
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('noc.loginnocform')->with('status', 'Password reset successfully!');
        }
    }
    public function showLoginForm_noc_data(Request $request)
    {
         //decryption starts here
        $encryptedPassword = $request->input('_password');

        $privateKey = file_get_contents(storage_path('app/rsa/private.key'));
        $decrypted = null;

        if (!openssl_private_decrypt(base64_decode($encryptedPassword), $decrypted, $privateKey)) {
            return back()->withErrors(['password' => 'Decryption failed.']);
        }

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
        // $password = session('sha_password');


    // Retrieve the user along with the related verified data
    $user = requesttable::where('email', $email)->with('verifiedData')->first();
    //  dd($user); 
    //  dd($user->verifiedData);
    //  dd($password);
    //  dd($user->verifiedData->password);
    if ($user && $user->verifiedData && Hash::check($password, $user->verifiedData->password)) {
        // Store email in session
        $request->session()->put('email', $user->email);
        $request->session()->put('name', $user->name);
        $request->session()->put('id', $user->id);
        $request->session()->put('user_type', 4);

        $otp = rand(100000, 999999); // 6 digit OTP
        error_log("otp of user is ...................................".$otp);
        // Store OTP in session
        Session::put('login_otp', $otp);
        Session::put('otp_generated_at', now());
            // Prepare the email content
            $otprequest = [
                'link' => $otp,
            ];

            // Send the email
            // Mail::to($request->email)->send(new LoginOtp($otprequest));
            // Redirect to dashboard with a success message ->with('login_otp', $otp)
            return redirect()->route('noc.showOtpForm_noc')->with('success', 'Please check the email to Verify the OTP.' . $otp);
            ///return redirect()->route('noc.dashboard')->with('success', 'Login successful!');
        }
        
        return redirect()->route('noc.loginnocform')->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
    public function reloadCaptchanoc()
    {
        //echo "Check1";dd();
        return response()->json(['captcha' => captcha_img()]);
    }
    public function showOtpForm_noc()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('noc.loginnocform');
        }
        Session::put('user_login', 'No');
        return view('layouts.noc.login_otp');
    }
    public function otpreloadCaptcha()
    {
        //echo "Check1";dd();
        return response()->json(['captcha' => captcha_img()]);
    }

    public function verifyNocOtpLogin(Request $request)
    {
        // Validate OTP
        $request->validate(
            [
                'login_otp' => 'required|numeric|digits:6',
                'captcha' => 'required|captcha'

            ],

            ['captcha.captcha' => 'Invalid captcha code.']
        );

        // Retrieve OTP from session
        $sessionOtp = Session::get('login_otp');
        $otpGeneratedAt = Session::get('otp_generated_at');
        //dd($sessionOtp);
        // Check if OTP matches and is within the expiration time
        if ($sessionOtp && $sessionOtp == $request->login_otp && now()->diffInMinutes($otpGeneratedAt) <= 5) {
            //dd(session()->all());


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
            Session::forget(['login_otp', 'otp_generated_at']); // Clear OTP from session
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
            return redirect()->route('noc.add_noc_application_form')->with('success', 'Login successful!'); // Redirect to the home page or the dashboard
        } else {
            // OTP is invalid or expired
            return redirect()->route('noc.showOtpForm_noc')->withErrors(['login_otp' => 'Invalid or expired OTP.']);
        }
    }
}
