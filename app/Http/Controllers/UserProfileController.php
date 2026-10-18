<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noc\requesttable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\userrolesaccesstable;
use App\Models\ApplicantProfile;
use App\Models\admin\user;

class UserProfileController extends Controller
{
    public function showProfile()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('noc.loginnocform');
        }
        $userId = Session::get('id');
        // Fetch the user's data from the database
        $user = requesttable::find($userId);
        $profile = ApplicantProfile::with('requestData')->where('noc_userid', $userId)->first();


       // dd($profile);
        //$user = Session::get('id');
        return view('layouts.noc.user_profile', compact('user', 'profile')); // Pass user data to the view
    }
    public function adminshowProfile()
    {
        if (empty(Session::has('userid'))) {
            return redirect()->route('admin.login');
        }

        $userId = Session::get('userid');
        //dd($userId);
        $user_data = userrolesaccesstable::with('user')->where('user_id', $userId)->first();
        //dd($user_data->user->username);
        $role_id = $user_data->role_id;

        $roles = DB::table('role_table')->where('id', $role_id)->first();

        //dd($roles);
        $role_type = $roles->role_name;


      // dd($role_type);
    if($role_type == $role_type && $user_data->role_id == $role_id)
    {

        $userrolesaccesstable = userrolesaccesstable::with('rolesAccess','user')->whereHas('rolesAccess', function ($query) {
            $query->whereIn('is_active', [1, 2]); // Replace with your condition
        })->get();

            return view('layouts.admin.admin_profile', compact('userrolesaccesstable', 'user_data'));
        } else {
            return redirect()->route('admin.login');
        }
    }
    public function ssashowProfile()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('admin.loginssaform');
        }

        $userId = Session::get('id');
        //dd($userId);
        $user_data = user::with('state')->where('id', $userId)->first();
        // dd($user_data);
        
        if($user_data)
        {
            return view('layouts.admin.ssa_profile', compact('user_data'));
        }
        return redirect()->route('admin.loginssaform');
    }
}
