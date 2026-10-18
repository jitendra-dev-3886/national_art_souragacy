<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Admin\userTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\approveauthoritytable;
use App\Models\LoginAttempt;

class AuthController extends Controller
{
    public function showLoginForm()
    {

        if(session()->has('userid')){
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }
    public function adminreloadCaptcha()
    
    {
        //echo "Check1";dd();
        return response()->json(['captcha' => captcha_img()]);
    }
    public function login(Request $request)
    {

        // Validate input fields
        // decryption of client side password field
        //dd($request->all());
        // $ivHex = $request->input('iv');
        // $ciphertextHex = $request->input('unknown_pwd');

        // $iv = hex2bin($ivHex);
        // $encrypted = hex2bin($ciphertextHex);
        // // ✅ Create the same key using hash('sha256')
        // $key = hash('sha256', 'my_shared_secret_1234567890123456', true); // true = raw binary

        // if (!$iv || !$encrypted) {
        //     dd("Invalid IV or Encrypted Password format", [
        //         'ivHex' => $ivHex,
        //         'encryptedHex' => $ciphertextHex,
        //         'ivLength' => strlen($ivHex),
        //         'encryptedLength' => strlen($ciphertextHex)
        //     ]);
        // }

        // $decryptedPassword = openssl_decrypt(
        //     $encrypted,
        //     'AES-256-CBC',
        //     $key,
        //     OPENSSL_RAW_DATA,
        //     $iv
        // );

        // if ($decryptedPassword === false) {
        //     dd("Decryption failed", [
        //         'iv' => bin2hex($iv),
        //         'encrypted' => bin2hex($encrypted),
        //         'key_length' => strlen($key),
        //         'iv_length' => strlen($iv),
        //         'encrypted_length' => strlen($encrypted)
        //     ]);
        // }

        // //dd("✅ Decryption succeeded", $decryptedPassword);
        // $request->merge(['password' => $decryptedPassword]);
        // decryption ends here
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

        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
                'captcha' => 'required|captcha'

            ],
            ['captcha.captcha' => 'Invalid captcha code.']
        );

        $email = $request->input('email');
        // $password = $request->input('password');
        $password = $decrypted;

        $user = DB::table('user_table')->where('email', $email)->first();


        if ($user && Hash::check($password, $user->password)) {
            // Check the user's status in the `approve_authority_table`
            $approvalStatus = approveauthoritytable::where('user_id', $user->userid)->value('is_active'); // Assuming `user_id` is the foreign key
            //add on 18-12-2024


            $role = DB::table('user_roles_access_table')->where('user_id', $user->userid)->first();
            // dd($user);
            if ($approvalStatus == 2) {
                // Store user details in the session
                $request->session()->put('email', $user->email);
                $request->session()->put('userid', $user->userid);
                $request->session()->put('role', $role->role_id);
                if ($role->role_id == 3) {
                    $request->session()->put('user_type', 9);
                } elseif ($role->role_id == 4) {
                    $request->session()->put('user_type', 7);
                } elseif ($role->role_id == 5) {
                    $request->session()->put('user_type', 6);
                } elseif ($role->role_id == 6) {
                    $request->session()->put('user_type', 10);
                } elseif ($role->role_id == 7) {
                    $request->session()->put('user_type', 11);
                } elseif ($role->role_id == 69) {
                    $request->session()->put('user_type', 12);
                } elseif ($role->role_id == 71) {
                    $request->session()->put('user_type', 13);
                }
                $request->session()->regenerate();
                //dd("test2");
                // ✅ Bind session to fingerprint
                session([
                    'fingerprint' => [
                        'ip' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ]
                ]);
                LoginAttempt::where('userid', session('userid'))
                            ->where('user_type', session('user_type'))
                            ->whereNull('end_time')
                            ->update([
                                'end_time' => Carbon::now(),
                            ]);
                $sessionhistory = new LoginAttempt();
                $sessionhistory->start_time = Carbon::now();
                $sessionhistory->session_id = $request->session()->getId();
                $sessionhistory->id = LoginAttempt::max('id') + 1;
                $sessionhistory->userid = session('userid');
                $sessionhistory->user_type = session('user_type');
                $sessionhistory->ip = $request->ip();
                $sessionhistory->save();

                return redirect()->route('dashboard')->with('success', 'Login successful!');
            } else {
                return redirect()->back()->withErrors(['error' => 'Your account is not active.']);
            }

        }




        // if ($user && Hash::check($password, $user->password)) {
        //     // $request->session()->put('name', $user->name);
        //     $request->session()->put('email', $user->email);

        //     return redirect()->route('dashboard')->with('success', 'Login successful!');
        // }

        // Redirect back with error message and old input
        return redirect()->route('admin.login')->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
    public function logout(Request $request)
    {
        //Auth::logout(); // Log the user out
        
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect('/login')->with('success', 'You have been logged out.');
    }

    // public function logout()
    // {
    //     Auth::logout();
    //     return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    // }
}
