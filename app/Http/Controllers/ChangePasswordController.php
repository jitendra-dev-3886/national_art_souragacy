<?php

namespace App\Http\Controllers;

use App\Models\Admin\user;
use Illuminate\Http\Request;
use App\Models\Admin\userTable;
use App\Models\Noc\verifiedtable;
use App\Models\Admin\approveauthoritytable;
use App\Mail\Userforgetpassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    // Show change password form
    public function showChangePasswordForm(Request $request)
    {
        // Debug the session       
        // Example: Check if user is logged in (manual logic)
        if (empty(Session::has('id'))) {
            return redirect()->route('noc.loginnocform');
        }
        return view('layouts.noc.change_password');
    }


    public function ssaadminChangePasswordForm(Request $request)
    {
        // Debug the session       
        // Example: Check if user is logged in (manual logic)
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        return view('layouts.admin.ssa_change_password');
    }

    public function changePassword(Request $request)
    {
        //decryption starts here
        $encryptedCurrentInput = $request->input('_current_password');
        $encryptedNewInput = $request->input('_new_password');
        $encryptedConfirmInput = $request->input('_new_password_confirmation');

        $privateKey = file_get_contents(storage_path('app/rsa/private.key'));
        $decryptedcurrentpwd = null;
        $decryptednewpwd = null;
        $decryptedconfirmpwd = null;
        if ((!openssl_private_decrypt(base64_decode($encryptedCurrentInput), $decryptedcurrentpwd, $privateKey)) ||
        (!openssl_private_decrypt(base64_decode($encryptedNewInput), $decryptednewpwd, $privateKey)) ||
        (!openssl_private_decrypt(base64_decode($encryptedConfirmInput), $decryptedconfirmpwd, $privateKey))) {
            return back()->withErrors(['current_password' => 'Decryption failed.']);
        }
        // Merge decrypted password into request for validation
        $request->merge(['current_password' => $decryptedcurrentpwd]);
        $request->merge(['new_password' => $decryptednewpwd]);
        $request->merge(['new_password_confirmation' => $decryptedconfirmpwd]);
        //decryption ends here
        // Validate the request
        $request->validate([
            'current_password' => 'required|string',  // Validate the current password
            'new_password' => 'required|string|max:50|min:8|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/|confirmed',  // Validate new password and its confirmation
        ]);

        // Get the logged-in user's ID from the session
        $userId = Session::get('id');  // Ensure that the session has the user ID
        // Retrieve the UserRequest and associated verifiedtable record using relationships   
        $userRequest = verifiedtable::with('requestData')->where('user_request_id', $userId)->first();  // Eager load the requestData relationship

        // Check if the userRequest and verifiedPassword relationship exists
        if ($userRequest && $userRequest->requestData) {
            // Access the user's email from the UserRequest model
            $email = $userRequest->requestData->email;
            // Access the password from the verifiedtable model
            $password = $userRequest->password;
            // Debug the result (you can remove this in production)   
            // Check if the current password matches the existing one
            if (Hash::check($request->current_password, $password)) {
                // Update the password in the verifiedPassword table
                if (Hash::check($request->new_password, $password)) {
                    // Update the password
                    return back()->withErrors(['current_password' => 'current password and new password must not be same.']);
                }
                $userRequest->password = Hash::make($request->new_password);
                $userRequest->save();
                $flash = ['status' => 'Password updated successfully.'];
                Session::invalidate();
                Session::regenerate();
                foreach ($flash as $key => $value) {
                    session()->flash($key, $value);
                }
                return redirect('/');
            } else {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }
        }
        // Return error if the user is not found
        return back()->withErrors(['email' => 'User not found.']);
    }
    public function adminChangePasswordForm(Request $request)
    {
        // Debug the session       
        // Example: Check if user is logged in (manual logic)
        //dd(session()->all());
        if (empty(Session::has('userid'))) {
            return redirect()->route('admin.login');
        }
        return view('layouts.admin.change_password');
    }

    public function adminchangePassword(Request $request)
    {
        if (empty(Session::has('userid'))) {
            return redirect()->route('admin.login');
        }
        //decryption starts here
        $encryptedCurrentInput = $request->input('_current_password');
        $encryptedNewInput = $request->input('_new_password');
        $encryptedConfirmInput = $request->input('_new_password_confirmation');

        $privateKey = file_get_contents(storage_path('app/rsa/private.key'));
        $decryptedcurrentpwd = null;
        $decryptednewpwd = null;
        $decryptedconfirmpwd = null;
        if ((!openssl_private_decrypt(base64_decode($encryptedCurrentInput), $decryptedcurrentpwd, $privateKey)) ||
        (!openssl_private_decrypt(base64_decode($encryptedNewInput), $decryptednewpwd, $privateKey)) ||
        (!openssl_private_decrypt(base64_decode($encryptedConfirmInput), $decryptedconfirmpwd, $privateKey))) {
            return back()->withErrors(['current_password' => 'Decryption failed.']);
        }
        // Merge decrypted password into request for validation
        $request->merge(['current_password' => $decryptedcurrentpwd]);
        $request->merge(['new_password' => $decryptednewpwd]);
        $request->merge(['new_password_confirmation' => $decryptedconfirmpwd]);
        //decryption ends here
        $request->validate([
            'current_password' => 'required|string',  // Validate the current password
            'new_password' => 'required|string|max:50|min:8|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/|confirmed',  // Validate new password and its confirmation
        ]);

        // Get the logged-in user's ID from the session
        $userId = Session::get('userid');  // Ensure that the session has the user ID
        //dd($userId);
        // Retrieve the UserRequest and associated verifiedtable record using relationships   
        $userRequest = userTable::where('userid', $userId)->first();

        if ($userRequest) {
            //$password = $userRequest->password;        
            if (Hash::check($request->current_password, $userRequest->password)) {
                // Update the password in the verifiedPassword table
                if (Hash::check($request->new_password, $userRequest->password)) {
                    // Update the password
                    return back()->withErrors(['current_password' => 'current password and new password must not be same.']);
                }
                userTable::where('userid', $userId)->update(['password' => Hash::make($request->new_password)]);

                $flash = ['status' => 'Password updated successfully.'];
                Session::invalidate();
                Session::regenerate();
                foreach ($flash as $key => $value) {
                    session()->flash($key, $value);
                }
                return redirect('/');
            } else {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }
        }
        // Return error if the user is not found
        return back()->withErrors(['email' => 'User not found.']);
    }
    public function ssaadminchangePassword(Request $request)
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }
        //decryption starts here
        $encryptedCurrentInput = $request->input('_current_password');
        $encryptedNewInput = $request->input('_new_password');
        $encryptedConfirmInput = $request->input('_new_password_confirmation');

        $privateKey = file_get_contents(storage_path('app/rsa/private.key'));
        $decryptedcurrentpwd = null;
        $decryptednewpwd = null;
        $decryptedconfirmpwd = null;
        if ((!openssl_private_decrypt(base64_decode($encryptedCurrentInput), $decryptedcurrentpwd, $privateKey)) ||
        (!openssl_private_decrypt(base64_decode($encryptedNewInput), $decryptednewpwd, $privateKey)) ||
        (!openssl_private_decrypt(base64_decode($encryptedConfirmInput), $decryptedconfirmpwd, $privateKey))) {
            return back()->withErrors(['current_password' => 'Decryption failed.']);
        }
        // Merge decrypted password into request for validation
        $request->merge(['current_password' => $decryptedcurrentpwd]);
        $request->merge(['new_password' => $decryptednewpwd]);
        $request->merge(['new_password_confirmation' => $decryptedconfirmpwd]);
        //decryption ends here
        $request->validate([
            'current_password' => 'required|string',  // Validate the current password
            'new_password' => 'required|string|max:50|min:8|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/|confirmed',  // Validate new password and its confirmation
        ]);

        // Get the logged-in user's ID from the session
        $userId = Session::get('id');  // Ensure that the session has the user ID
        //dd($userId);
        // Retrieve the UserRequest and associated verifiedtable record using relationships   
        $userRequest = user::where('id', $userId)->first();
           //dd($userRequest);
        if ($userRequest) {
            //$password = $userRequest->password;        
            if (Hash::check($request->current_password, $userRequest->password)) {
                // Update the password in the verifiedPassword table
                if (Hash::check($request->new_password, $userRequest->password)) {
                    // Update the password
                    return back()->withErrors(['current_password' => 'current password and new password must not be same.']);
                }
                user::where('id', $userId)->update(['password' => Hash::make($request->new_password)]);
                $flash = ['status' => 'Password updated successfully.'];
                Session::invalidate();
                Session::regenerate();
                foreach ($flash as $key => $value) {
                    session()->flash($key, $value);
                }
                return redirect('/');
            } else {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }
        }
        // Return error if the user is not found
        return back()->withErrors(['email' => 'User not found.']);
    }
    public function adminforgetPasswordForm()
    {
        return view('layouts.admin.forget_password');
    }
    public function adminforgetPassword(Request $request)
    {
        //decryption starts here
        try {
            if(!session()->has('tempurl')){
                $tempurl = $request->fullUrl();
                session()->put('tempurl', $tempurl);
                // dd($tempurl);
            }
        $request->validate(
            [
                'email' => 'required|email|exists:user_table,email',
                'username' => 'required|string|between:4,30|regex:/^[a-zA-Z0-9._ ]+$/',
                'captcha' => 'required|captcha'
            ],

            [
                // Email Messages
                'email.required' => 'Email address is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.exists' => 'Invalid user.',

                // Username Messages
                'username.required' => 'Username is required.',
                'username.string' => 'Username must be a valid text value.',
                'username.between' => 'Username must be between 4 and 30 characters.',
                'username.regex' => 'Username can contain only letters, numbers, spaces, dots (.), and underscores (_).',

                // Captcha Messages
                'captcha.required' => 'Captcha is required.',
                'captcha.captcha' => 'Invalid captcha code.'
            ]
        );
        }
            catch (ValidationException $e) {

            Log::error('admin forget password request failed', [
                'errors' => $e->errors(),
                'ip'     => $request->ip(),
            ]);
            
            throw $e; // IMPORTANT: sends errors back to Blade
        }

        // Find the user ID in the user_request_table
        session()->forget(['tempurl']);
        $userRequest = userTable::where([
                            ['email', $request->email],
                            ['Is_Active_and_Deactive', 1],
                            ['username', $request->username]
                        ])->first();

        if (!$userRequest) {
            Log::error('admin forget password request failed: either email not found or username', [
                'input1'  => $request->username,
                'input2'  => $request->email,
            ]);
            return redirect()->route('admin_password.request')->withErrors(['status' => 'Invalid user.']);
        }
        $service_id = DB::table('services_table')->where('service_name','registry view')->where('is_active',1)->value('id');
        if (!$service_id) {
            Log::error('admin forget password request failed: service not found', [
                'input1'  => $request->username,
                'input2'  => $request->email,
            ]);
            return redirect()->route('admin_password.request')->withErrors(['status' => 'Invalid user.']);
        }
        $isuservalid = approveauthoritytable::where([
                        ['user_id', $userRequest->userid],
                        ['service_id',$service_id],
                        ['is_active',2]
                    ])->first();
        if (!$isuservalid) {
            Log::error('admin forget password request failed: user not active check authority table', [
                'service id'  => $service_id,
                'userid'  => $userRequest->userid,
            ]);
            return redirect()->route('admin_password.request')->withErrors(['status' => 'Invalid user.']);
        }
        // Generate a secure token
        $token = Str::random(60);

        // Encrypt the email
        $encryptedEmail = Crypt::encryptString($userRequest->email);

        // Construct the custom link
        $link = url("admin/forgot-password-request?email={$encryptedEmail}&token={$token}");

        // Save the token in your password resets table or another appropriate location
        DB::table('tokens_admin')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'userid' => $userRequest->userid,
                'admin_type' => 'admin',
                'is_valid'  => 1
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
    public function adminforgetPasswordRequestForm(Request $request)
    {
        $decryptedEmail = Crypt::decryptString($request->email);
        $get_user = DB::table('tokens_admin')
                ->where([
                    'email' => $decryptedEmail,
                    'admin_type' => 'admin',
                    'is_valid'  => 1,
                ])->first();
        if (!$get_user || !Hash::check($request->token, $get_user->token)) {
            return redirect()->route('error.accesschange')
                                ->with('error', 'Invalid token');
        }
        $userRequest = userTable::where([
                            ['userid', $get_user->userid],
                            ['email', $get_user->email],
                            ['Is_Active_and_Deactive', 1],
                        ])->first();
        if (!$userRequest) {
            return redirect()->route('error.accesschange')
                                ->with('error', 'Invalid user');
        }
        $service_id = DB::table('services_table')->where('service_name','registry view')->where('is_active',1)->value('id');
        if (!$service_id) {
            Log::error('admin forget password request failed: service not found', [
                'input'  => $request->decryptedEmail,
            ]);
            return redirect()->route('error.accesschange')
                                ->with('error', 'Invalid user');
        }
        $isuservalid = approveauthoritytable::where([
                        ['user_id', $userRequest->userid],
                        ['service_id',$service_id],
                        ['is_active',2]
                    ])->first();
        if (!$isuservalid) {
            Log::error('admin forget password request failed: user not active check authority table', [
                'input'  => $decryptedEmail,
            ]);
            return redirect()->route('error.accesschange')
                                ->with('error', 'Invalid user');
        }
        return view('layouts/admin/signup-forget-password-admin', compact('userRequest'));
    }
    public function adminforgetPasswordRequest(Request $request)
    {
        try{
            if(!session()->has('tempurl')){
                    $tempurl = $request->fullUrl();
                    session()->put('tempurl', $tempurl);
                    // dd($tempurl);
                }
            $request->validate([
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'max:50',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.#^()_\-+=]).+$/',
                    'confirmed'
                ],
            ]);
        }   catch (ValidationException $e) {

            Log::error('admin forget password submission failed', [
                'errors' => $e->errors(),
                'ip'     => $request->ip(),
            ]);
            
            throw $e; // IMPORTANT: sends errors back to Blade
        }
        //  $pp = $request->all();
        session()->forget(['tempurl']);
        // Get user_request_table record
        $decryptedEmail = Crypt::decryptString($request->secure_email);
        // dd($request->secure_email);
        if($request->email != $decryptedEmail){
            Log::error('admin forget password request failed: email has been tempered with', [
                'emailfromblade'  => $request->email,
                'encryptedemail'  => $decryptedEmail
            ]);
            return redirect()->route('error.accesschange')
                                ->with('error', 'Invalid user');
        }
        
        $userRequest = userTable::where('email', $request->email)
                        ->where('username', $request->username)
                        ->first();
        if (!$userRequest) {
            Log::error('admin forget password request failed: emailid and username not found', [
                'email'  => $request->email,
                'username'  => $request->username
            ]);
            return redirect()->route('error.accesschange')
                                ->with('error', 'Invalid user');
        }
        $service_id = DB::table('services_table')->where('service_name','registry view')->where('is_active',1)->value('id');
        if (!$service_id) {
            Log::error('admin forget password request failed: service not found', [
                'input'  => $request->email,
            ]);
            return redirect()->route('error.accesschange')
                                ->with('error', 'Invalid user');
        }
        $isuservalid = approveauthoritytable::where([
                        ['user_id', $userRequest->userid],
                        ['service_id',$service_id],
                        ['is_active',2]
                    ])->first();
        if (!$isuservalid) {
            Log::error('admin forget password request failed: user not active check authority table', [
                'input'  => $request->email,
            ]);
            return redirect()->route('error.accesschange')
                                ->with('error', 'Invalid user');
        }
        try{
            DB::beginTransaction();
            $tokenQuery = DB::table('tokens_admin')
                            ->where('email', $request->email)
                            ->where('admin_type', 'admin')
                            ->where('is_valid', 1);

            $get_usertoken = $tokenQuery->first();
            if (!$get_usertoken || !Hash::check($request->secure_token, $get_usertoken->token)) {
                return redirect()->route('error.accesschange')
                                    ->with('error', 'Invalid token');
            }
            // Invalidate token
            $tokenQuery->update([
                            'is_valid' => 0,
                            'updated_at' => now(),
                        ]);
            $userRequest->update([
                    'password' => Hash::make($request->password),
                    'updated_at' => now(), // optional if timestamps enabled
                ]);
            DB::commit();
            return redirect()->route('admin.login')->with('status', 'Password reset successfully!');
        }catch (\Exception $e) {
                        Log::error('admin forget password submission failed', [
                            'email'      => $request->email,
                            'temptoken'  => $request->secure_token,
                            'ip_address' => $request->ip(),
                            'action'     => 'Token validation failed in admin password change',
                            'exception'  => $e->getMessage(),
                            'trace'      => $e->getTraceAsString(),
                        ]);
                        DB::rollBack();
                        throw $e; // or log error
                    }    
    }

}
