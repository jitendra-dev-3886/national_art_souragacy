<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\LoginAttempt;
use Illuminate\Support\Facades\Log;
class VerifySingleSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
     
        $sessionId = Session::getId();
        $usertype = Session::get("user_type");
        if ($usertype <= 5) {
            $userId = Session::get('id');
        } else {
            $userId = Session::get('userid');
        }
        //dd($sessionId);
        if (!$userId || !$sessionId) {
           
            return redirect('/')->with('error', 'Please log in.');
        }
        //dd($userId);
        //dd($sessionId);
        //dd($usertype);
        $loginAttempt = LoginAttempt::with('usertype')
            ->where('userid', $userId)
            ->where('session_id', $sessionId)
            ->where('user_type', $usertype)
            ->whereNull('end_time')
            ->first();
        // $sql = vsprintf(str_replace('?', '%s', $query->toSql()),collect($query->getBindings())->map(function ($binding) {
        //     return is_numeric($binding) ? $binding : "'$binding'";})->toArray());

        // dd($loginAttempt);
        if (!$loginAttempt) {
            // Try to fetch usertype for redirection even if session is invalid
            LoginAttempt::where('userid', $userId)
                ->where('user_type', $usertype)
                ->where('session_id', $sessionId)
                ->update(['end_time' => now()]);
            //return $next($request);
            $latestAttempt = LoginAttempt::with('usertype')
                ->where('userid', $userId)
                ->where('user_type', $usertype)
                //->whereNull('end_time')
                ->first();
            // dd($latestAttempt);
            $redirectTo = $latestAttempt && $latestAttempt->usertype && $latestAttempt->usertype->resourceurl
                ? '/' . ltrim($latestAttempt->usertype->resourceurl, '/')
                : '/';

            Session::flush();
            return redirect($redirectTo)->with('error', 'You have been logged out due to login on another device.');
        }
        // dd("temp");
      
        return $next($request);
    }

}

