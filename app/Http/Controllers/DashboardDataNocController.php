<?php

namespace App\Http\Controllers;

use App\Models\Noc\nocform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardDataNocController extends Controller
{
    public function nocdashboard()
    {
        if (empty(Session::has('id'))) {
            return redirect()->route('noc.loginnocform');
        }
        // Get the logged-in user ID from the session
        $userId = Session::get('id');

        // Count the total NOC applications submitted by the logged-in user
        $totalSubmittedData = nocform::where('noc_userid', $userId)->count();
        // Count the total NOC applications
        //$totalSubmittedData = nocform::count();        
        return view('layouts/noc/nocdashboard', compact('totalSubmittedData'));
    }
}
