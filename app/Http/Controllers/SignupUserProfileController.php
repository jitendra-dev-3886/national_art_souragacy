<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\clinic\signup;
use App\Models\ApplicantProfile;
use App\Models\Noc\requesttable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\userrolesaccesstable;

class SignupUserProfileController extends Controller
{
    public function signupshowProfile()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('clinic.loginclinicform');
        }
        $userId = Session::get('id');
        // Fetch the user's data from the database
        $user = signup::find($userId);
        $profile = signup::where('id', $userId)->first();
       // $profile = ApplicantProfile::with('requestData')->where('noc_userid', $userId)->first();


        //dd($profile);
        //$user = Session::get('id');
        return view('layouts.clinic.signup_user_profile', compact('user', 'profile')); // Pass user data to the view
    }
    // public function adminshowProfile()
    // {
    //     if (empty(Session::has('userid'))) {
    //         return redirect()->route('admin.login');
    //     }

    //     $userId = Session::get('userid');
    //     //dd($userId);
    //     $user_data = userrolesaccesstable::with('user')->where('user_id', $userId)->first();
    //     //dd($user_data->user->username);
    //     $role_id = $user_data->role_id;

    //     $roles = DB::table('role_table')->where('id', $role_id)->first();

    //     //dd($roles);
    //     $role_type = $roles->role_name;


    //   // dd($role_type);
    // if($role_type == $role_type && $user_data->role_id == $role_id)
    // {

    //     $userrolesaccesstable = userrolesaccesstable::with('rolesAccess','user')->whereHas('rolesAccess', function ($query) {
    //         $query->whereIn('is_active', [1, 2]); // Replace with your condition
    //     })->get();

    //         return view('layouts.admin.admin_profile', compact('userrolesaccesstable', 'user_data'));
    //     } else {
    //         return redirect()->route('admin.login');
    //     }
    // }
}
