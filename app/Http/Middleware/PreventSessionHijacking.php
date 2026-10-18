<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Log;

class PreventSessionHijacking
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('userid')) {
            //dd("test0");
            $currentFingerprint = [
                'ua' => $request->userAgent(),
                'ip_prefix' => substr($request->ip(), 0, strrpos($request->ip(), '.')), // subnet only
            ];
            $fingerprint = session('fingerprint');
            //dd(Session::getId());
            
            if (!$fingerprint) {
                //dd("test1");
                session([
                    'fingerprint' => $currentFingerprint
                ]);
            } else {
                //dd("test2");
                if ($fingerprint['user_agent'] !== $request->userAgent()) {
                    //dd("test3");
                    //Auth::logout();
                    Log::warning('Session hijack suspected', [
                        'old' => $fingerprint,
                        'new' => $currentFingerprint,
                        'user_id' => session('userid'),
                        'ip' => $request->ip(),
                    ]);
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    throw new HttpException(403, 'Session hijack attempt detected.');
                }
                //dd("test2");
            }
        }
        //dd(session()->all());
        return $next($request);
    }
}
