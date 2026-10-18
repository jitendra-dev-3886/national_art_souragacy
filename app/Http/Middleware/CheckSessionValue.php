<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CheckSessionValue
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

        public function handle(Request $request, Closure $next)
        {   
            
            $checklogin = Session::get('userid');
            $checkloginssa = Session::get('id');
            // dd($checklogin);
            // dd($checkloginssa);
            if (!$checklogin && !$checkloginssa){
                return redirect('login');
            }
            return $next($request);
        }
   
}
