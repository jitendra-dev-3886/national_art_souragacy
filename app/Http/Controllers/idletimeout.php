<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IdleTimeoutController extends Controller
{
    public function handle(Request $request)
    {
        // Log out the user (if using Auth)

        // Invalidate and flush the session
        Session::flush();
        Session::invalidate();
        Session::regenerateToken();

        // Optionally redirect to login or idle timeout view
        return redirect()->route('/')->with('status', 'You have been logged out due to inactivity.');
    }
}
