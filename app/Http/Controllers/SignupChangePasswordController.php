<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\clinic\signup;
use App\Models\Admin\userTable;
use App\Models\Noc\verifiedtable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SignupChangePasswordController extends Controller
{
    // Show change password form
    public function signupshowChangePasswordForm(Request $request)
    {
        // Debug the session       
        // Example: Check if user is logged in (manual logic)
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        return view('layouts.clinic.signup_change_password');
    }
public function signupchangePassword(Request $request)
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
    //dd($decrypted);
    // Validate the request

    $request->validate([
        'current_password' => 'required|string',
        'new_password' => [
            'required',
            'string',
            'max:50',
            'min:8',
            'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/',
            'confirmed',
        ],
    ]);

    // Get logged-in user ID from session
    $userId = Session::get('id');
    $user = signup::find($userId);

    if ($user) {
        // Check if the current password matches the existing one
        if (Hash::check($request->current_password, $user->password)) {
            // Update the password
            if (Hash::check($request->new_password, $user->password)) {
                // Update the password
                return back()->withErrors(['current_password' => 'current password and new password must not be same.']);
            }
            $user->password = Hash::make($request->new_password);
            $user->save();  // Save the changes to the database
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

        // New password must be different from current password.
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'New password must be different from current password.']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('status', 'Password updated successfully.');
    }

    return back()->withErrors(['email' => 'User not found.']);
}



    // public function signupchangePassword(Request $request)
    // {
    //    // dd('check 1');
    //     // Validate the request
    //     $request->validate([
    //         'current_password' => 'required|string',  // Validate the current password
    //         'new_password' => 'required|string|min:8|confirmed',  // Validate new password and its confirmation
    //     ]);
       
    //     // Get the logged-in user's ID from the session
    //     $userId = Session::get('id');  // Ensure that the session has the user ID
        
    //     // Retrieve the UserRequest and associated verifiedtable record using relationships   
    //    // $userRequest = verifiedtable::with('requestData')->where('user_request_id', $userId)->first();  // Eager load the requestData relationship
    //    //$userRequest = signup::where('id', $userId)->first();
    //    $userRequest = DB::table('signup')->where('id', $userId)->first();
    //    //dd($userRequest);
    //     // Check if the userRequest and verifiedPassword relationship exists
    //     if ($userRequest && $userRequest->id) {
    //         // Access the user's email from the UserRequest model
    //         $email = $userRequest->email;
    //         // Access the password from the verifiedtable model
    //         $password = $userRequest->password;
    //         //dd($password);
    //         // Debug the result (you can remove this in production)   
    //         // Check if the current password matches the existing one
    //         if (Hash::check($request->current_password, $password)) {
    //             // Update the password in the verifiedPassword table
    //             $userRequest->password = Hash::make($request->new_password);
    //             //dd();
    //             $userRequest->save();
    //             return back()->with('status', 'Password updated successfully.');
    //         } else {
    //             return back()->withErrors(['current_password' => 'The current password is incorrect.']);
    //         }
    //     }
    //     // Return error if the user is not found
    //     return back()->withErrors(['email' => 'User not found.']);
    // }
    // public function adminChangePasswordForm(Request $request)
    // {
    //     // Debug the session       
    //     // Example: Check if user is logged in (manual logic)
    //     if (empty(Session::has('userid'))) {
    //         return redirect()->route('admin.login');
    //     }
    //     return view('layouts.admin.change_password');
    // }

    // public function adminchangePassword(Request $request)
    // {
    //     if (empty(Session::has('userid'))) {
    //         return redirect()->route('admin.login');
    //     }
    //     $request->validate([
    //         'current_password' => 'required|string',  // Validate the current password
    //         'new_password' => 'required|string|min:8|confirmed',  // Validate new password and its confirmation
    //     ]);

    //     // Get the logged-in user's ID from the session
    //     $userId = Session::get('userid');  // Ensure that the session has the user ID
    //     //dd($userId);
    //     // Retrieve the UserRequest and associated verifiedtable record using relationships   
    //     $userRequest = userTable::where('userid', $userId)->first();

    //     if ($userRequest) {
    //         //$password = $userRequest->password;        
    //         if (Hash::check($request->current_password, $userRequest->password)) {
    //             // Update the password in the verifiedPassword table

    //             userTable::where('userid', $userId)->update(['password' => Hash::make($request->new_password)]);
    //             return back()->with('status', 'Password updated successfully.');
    //         } else {
    //             return back()->withErrors(['current_password' => 'The current password is incorrect.']);
    //         }
    //     }
    //     // Return error if the user is not found
    //     return back()->withErrors(['email' => 'User not found.']);
    // }
}
