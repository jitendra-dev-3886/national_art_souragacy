<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetectSessionHijack
{
    public function handle(Request $request, Closure $next)
    {
        $session = $request->session();

        // Generate fingerprint from IP + User-Agent
        $fingerprint = sha1($request->ip() . '|' . $request->userAgent());

        if (!$session->has('session_fingerprint')) {
            // Store it on first request
            $session->put('session_fingerprint', $fingerprint);
        } elseif ($session->get('session_fingerprint') !== $fingerprint) {
            // Detected mismatch → possible hijack
            $session->invalidate(); // Destroy session
            Auth::logout();         // Log user out

            abort(403, 'Session fingerprint mismatch — possible hijacking attempt.');
        }

        return $next($request);
    }
}
