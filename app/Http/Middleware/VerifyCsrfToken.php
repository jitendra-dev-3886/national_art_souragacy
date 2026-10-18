<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

use Closure;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
    // public function handle($request, Closure $next)
    // {
    //     // Log or display CSRF token verification status
    //     if ($request->hasSession()) {
    //         $token = $request->session()->token(); 
    //         // Get CSRF token from session
    //         $headerToken = $request['_token']; // CSRF token sent in request header (for AJAX)
    //         dd($token,$headerToken);

    //         // Check if the CSRF token is valid
    //         if ($token != $headerToken) {
    //             // Log or handle invalid CSRF token (you can log or display a message)
    //             \Log::warning('Invalid CSRF token detected!', [
    //                 'session_token' => $token,
    //                 'header_token' => $headerToken,
    //             ]);
    //         }
    //     }

    //     try {
    //         return parent::handle($request, $next);
    //     } catch (TokenMismatchException $e) {
    //         // Handle the exception or display a custom error
    //         return response('CSRF token mismatch', 419);
    //     }
    // }
    // public function handle($request, Closure $next)
    // {
    //     try {
    //         return parent::handle($request, $next);
    //     } catch (TokenMismatchException $e) {
    //         // Redirect ALL expired/invalid CSRF requests to login
    //     return redirect('/')
    //             ->with('error', 'Your session has expired. Please login again.');
    //     }
    // }
}