<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\RoleTable;
use App\Models\Admin\userTable;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\servicesTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\userrolesaccesstable;
use App\Models\Admin\approveauthoritytable;
use App\Models\Admin\serviceexaminationtable;
use App\Models\User;

//add on 18-12-2024

class UserTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add_new()
    {
        if (empty(Session::has('userid'))) {
            return redirect()->route('admin.login');
        }

        $userId = Session::get('userid');
        //dd($userId);
        $user_data = userrolesaccesstable::with('user')->where('user_id', $userId)->first();
        // dd($user_data->role_id);
        $role_id = $user_data->role_id;

        $roles = DB::table('role_table')->where('id', $role_id)->first();

        //dd($roles);
        $role_type = $roles->role_name;

        // dd($role_type);
        if ($role_type == 'Admin' && $user_data->role_id == $role_id) {
            return view('layouts.admin.add_user');
        } else {
            return redirect()->route('admin.login');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function add_user_store(Request $request)
    {
        $test = $request->all();
        //dd($test);
        // Validate the form inputs
        $request->validate([
            'user_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            // 'phone' => 'required|digits_between:10,15',
            'email' => 'required|email|max:255|unique:users,email',
            'mobile_no' => 'required|digits_between:10,15',
            'address' => 'required|string|max:500',
            'password' => 'required|min:8|confirmed',
        ]);
        $add_data = new userTable();
        //dd( $add_data);
        $add_data->username  = $request->input('username');
        $add_data->first_name  = $request->input('first_name');
        $add_data->last_name  = $request->input('last_name');
        $add_data->designation  = $request->input('designation');
        $add_data->phone  = $request->input('phone');
        $add_data->address  = $request->input('address'); 
        $add_data->mobile_no  = $request->input('mobile_no'); 
        $add_data->email  = $request->input('email'); 
        //$add_data->password  = $request->input('password');
        $add_data->password = bcrypt($request->input('password'));
       //dd( $add_data);
        $add_data->save();
        return redirect()->back()->with('success', 'User created successfully.');
    }


    public function user_list()
    {

        if (empty(Session::has('userid'))) {
            return redirect()->route('admin.login');
        }

        $userId = Session::get('userid');
        //dd($userId);
        $user_data = userrolesaccesstable::with('user')->where('user_id', $userId)->first();
        // dd($user_data->role_id);
        $role_id = $user_data->role_id;

        $roles = DB::table('role_table')->where('id', $role_id)->first();

        //dd($roles);
        $role_type = $roles->role_name;

        // dd($role_type);
        if ($role_type == 'Admin' && $user_data->role_id == $role_id) {
            $get_userData = userTable::all();
            return view('layouts.admin.user_list_noc', compact('get_userData'));
        } else {
            return redirect()->route('admin.login');
        }
    }
    public function add_user_role()
    {
        if (empty(Session::has('userid'))) {
            return redirect()->route('admin.login');
        }

        $userId = Session::get('userid');
        //dd($userId);
        $user_data = userrolesaccesstable::with('user')->where('user_id', $userId)->first();
        // dd($user_data->role_id);
        $role_id = $user_data->role_id;

        $roles = DB::table('role_table')->where('id', $role_id)->first();

        //dd($roles);
        $role_type = $roles->role_name;

        // dd($role_type);
        if ($role_type == 'Admin' && $user_data->role_id == $role_id) {
            return view('layouts.admin.add_user_role');
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function add_user_role_store(Request $request)
    {
        // $test = $request->all();
        //dd($test);
        // Validate the form inputs
        $request->validate([
            'role_name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        $add_data_role = new RoleTable();
        //dd( $add_data);
        $add_data_role->role_name  = $request->input('role_name');
        $add_data_role->description  = $request->input('description');
        $add_data_role->save();
        return redirect()->back()->with('success', 'add role successfully.');
    }


    public function add_user_role_access()
    {
        if (empty(Session::has('userid'))) {
            return redirect()->route('admin.login');
        }

        $userId = Session::get('userid');
        //dd($userId);
        $user_data = userrolesaccesstable::with('user')->where('user_id', $userId)->first();
        // dd($user_data->role_id);
        $role_id = $user_data->role_id;

        $roles = DB::table('role_table')->where('id', $role_id)->first();

        //dd($roles);
        $role_type = $roles->role_name;

        // dd($role_type);
        if ($role_type == 'Admin' && $user_data->role_id == $role_id) {
            // Fetch all users and roles from the database
            $users = userTable::all();
            $roles = RoleTable::all();
            return view('layouts.admin.add_user_role_access', compact('users', 'roles'));
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function add_user_role_access_store(Request $request)
    {
        $test = $request->all();
        //dd($test);
        // Validate the form inputs
        // $request->validate([
        // 'user_id' => 'required|string|max:255',
        // 'role_id' => 'required|string|max:255',       
        // ]);
        // dd($test);
        $request->validate([
            'user_id' => 'required|exists:user_table,userid',
            'role_id' => 'required|exists:role_table,id',
        ]);

        $add_data_role_access = new userrolesaccesstable();
        //dd( $add_data);
        $add_data_role_access->user_id  = $request->input('user_id');
        $add_data_role_access->role_id  = $request->input('role_id');
        $add_data_role_access->save();
        return redirect()->back()->with('success', 'Assign the role to the user successfully.');
    }

    public function user_list_noc_role()
    {
        if (empty(Session::has('userid'))) {
            return redirect()->route('admin.login');
        }

        $userId = Session::get('userid');
        //dd($userId);
        $user_data = userrolesaccesstable::with('user')->where('user_id', $userId)->first();
        // dd($user_data->role_id);
        $role_id = $user_data->role_id;

        $roles = DB::table('role_table')->where('id', $role_id)->first();

        //dd($roles);
        $role_type = $roles->role_name;

        // dd($role_type);
        if ($role_type == 'Admin' && $user_data->role_id == $role_id) {
            $get_userData = userrolesaccesstable::with(['user', 'role'])->get();
            //  dd($get_userData);
            return view('layouts.admin.user_list_noc_role', compact('get_userData'));
        } else {
            return redirect()->route('admin.login');
        }
    }


    public function add_service()
    {
        if (empty(Session::has('userid'))) {
            return redirect()->route('admin.login');
        }

        $userId = Session::get('userid');
        //dd($userId);
        $user_data = userrolesaccesstable::with('user')->where('user_id', $userId)->first();
        // dd($user_data->role_id);
        $role_id = $user_data->role_id;

        $roles = DB::table('role_table')->where('id', $role_id)->first();

        //dd($roles);
        $role_type = $roles->role_name;

        // dd($role_type);
        if ($role_type == 'Admin' && $user_data->role_id == $role_id) {
            return view('layouts.admin.add_service');
        } else {
            return redirect()->route('admin.login');
        }
    }




    public function add_service_data(Request $request)
    {
        // $test = $request->all();
        //dd($test);
        // Validate the form inputs
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_description' => 'required|string|max:255',
        ]);
        $add_data_service = new servicesTable();
        //dd( $add_data);
        $add_data_service->service_name  = $request->input('service_name');
        $add_data_service->service_description  = $request->input('service_description');
        $add_data_service->save();
        return redirect()->back()->with('success', 'add service successfully.');
    }

    public function assign_service()
    {
        if (empty(Session::has('userid'))) {
            return redirect()->route('admin.login');
        }

        $userId = Session::get('userid');
        //dd($userId);
        $user_data = userrolesaccesstable::with('user')->where('user_id', $userId)->first();
        // dd($user_data->role_id);
        $role_id = $user_data->role_id;

        $roles = DB::table('role_table')->where('id', $role_id)->first();

        //dd($roles);
        $role_type = $roles->role_name;

        // dd($role_type);
        if ($role_type == 'Admin' && $user_data->role_id == $role_id) {
            $users = userTable::all();
            $services = servicesTable::get();
            return view('layouts.admin.assign_service', compact('users', 'services'));
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function assign_service_data(Request $request)
    {
        $add_data_service_data = new serviceexaminationtable();
        //dd( $add_data);
        $add_data_service_data->user_id  = $request->user_id;
        $add_data_service_data->service_id  = $request->service_id;
        $add_data_service_data->save();

        $add_data_service = new approveauthoritytable();
        //dd( $add_data_service);
        $add_data_service->user_id  = $request->user_id;
        $add_data_service->service_id  = $request->service_id;
        $add_data_service->save();
        return redirect()->back()->with('success', 'assign service successfully.');
    }

    // public function assign_service_data()
    // {
    //      // Fetch all users and roles from the database
    //      $users = userTable::all();
    //      $services = servicesTable::all();
    //     return view('layouts.admin.assign_service', compact('users','services'));
    // }


    public function list_service_approval()
    {
        if (empty(Session::has('userid'))) {
            return redirect()->route('admin.login');
        }

        $userId = Session::get('userid');
        //dd($userId);
        $user_data = userrolesaccesstable::with('user')->where('user_id', $userId)->first();
        // dd($user_data->role_id);
        $role_id = $user_data->role_id;

        $roles = DB::table('role_table')->where('id', $role_id)->first();

        //dd($roles);
        $role_type = $roles->role_name;


      // dd($role_type);
    if($role_type == 'Admin' && $user_data->role_id == $role_id)
    {
        $userrolesaccesstable = userrolesaccesstable::with('rolesAccess','user')->whereHas('rolesAccess', function ($query) {
            $query->where('is_active', 0); // Replace with your condition
        })->get();
//dd($userrolesaccesstable);
        return view('layouts.admin.list_service_approval',compact('userrolesaccesstable'));
    }else{
        return redirect()->route('admin.login');
    }
    }


    public function service_approval($id)
    {
        approveauthoritytable::where('id', $id)->update(['is_active' => 1]);
        return redirect()->back()->with('success', 'Send for approval successfully.');
    }


    public function logout(Request $request)
    {
        Auth::logout(); // Log the user out

        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect('/login')->with('success', 'You have been logged out.');
    }


    public function list_accept_approval()
    {
        if (empty(Session::has('userid'))) {
            return redirect()->route('admin.login');
        }

        $userId = Session::get('userid');
        //dd($userId);
        $user_data = userrolesaccesstable::with('user')->where('user_id', $userId)->first();
        // dd($user_data->role_id);
        $role_id = $user_data->role_id;

        $roles = DB::table('role_table')->where('id', $role_id)->first();

        //dd($roles);
        $role_type = $roles->role_name;

        // dd($role_type);
        if ($role_type == 'Admin-II' && $user_data->role_id == $role_id) {
            $userrolesaccesstable = userrolesaccesstable::with('rolesAccess', 'user')->whereHas('rolesAccess', function ($query) {
                $query->whereIn('is_active', [1, 2]); // Replace with your condition
            })->get();

            return view('layouts.admin.list_accept_approval', compact('userrolesaccesstable'));
        } else {
            return redirect()->route('admin.login');
        }

        // return view('layouts.admin.list_accept_approval');
    }
    public function accept_approval($id)
    {
        approveauthoritytable::where('id', $id)->update(['is_active' => 2]);
        return redirect()->back()->with('success', 'active user successfully.');
    }

    public function reject_approval($id)
    {
        approveauthoritytable::where('id', $id)->update(['is_active' => 1]);
        return redirect()->back()->with('success', 'deactive user successfully.');
    }

    // public function toggleStatus($id)
    // {
    //     approveauthoritytable::where('id',$id)->update(['is_active'=>2]);
    //     return redirect()->back()->with('success', 'Send for approval successfully.');


    // }
}
