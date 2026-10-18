<?php

namespace App\Exceptions;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;



use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {
        $errorRef = Str::uuid()->toString();
        if ($exception instanceof ThrottleRequestsException) {
            return redirect()->route('clinic.resendLink')->with('success', 'Too many attempts. Please try again later.');
        }
        if ($exception instanceof ValidationException) {

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => $exception->errors()
                ], 422);
            }
            if(session()->has('tempurl')){
                return redirect(session('tempurl'))
                    ->withInput()
                    ->withErrors($exception->errors(), $exception->errorBag);
            }
            return redirect()->back()
                    ->withInput()
                    ->withErrors($exception->errors(), $exception->errorBag);
        }

        if ($exception instanceof InvalidSignatureException) {
            // Log attack attempt
            Log::warning('Invalid Signature Link Attempt', [
                'url'        => $request->fullUrl(),
                'ip'         => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return redirect()->route('error.accesschange')
                ->with('error', 'This link is invalid or has been tampered with.');
        }
        // Database errors
        if ($exception instanceof QueryException) {

            Log::error("[$errorRef] Database Exception", [
                'exception' => $exception
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Database error occurred',
                    'error_ref' => $errorRef
                ], 500);
            }

            return response()->view('errors.db', [
                'error_ref' => $errorRef
            ], 500);
        }

        // Page not found
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        // CSRF token expired
        if ($exception instanceof TokenMismatchException) {
            return redirect()->back()->with('error', 'Session expired. Please try again.');
        }
        // 🔐 Session hijack / HTTP errors
        if ($exception instanceof HttpException) {

            Log::warning("[$errorRef] HTTP Exception", [
                'status_code' => $exception->getStatusCode(),
                'message'     => $exception->getMessage(),
                'url'         => $request->fullUrl(),
                'ip'          => $request->ip(),
                'user_agent'  => $request->userAgent(),
            ]);

            if ($exception->getStatusCode() === 403) {
                return response()->view('errors.403', [
                    'message'   => $exception->getMessage(),
                    'error_ref' => $errorRef
                ], 403);
            }

            return response()->view('errors.http', [
                'code'       => $exception->getStatusCode(),
                'message'    => $exception->getMessage(),
                'error_ref'  => $errorRef
            ], $exception->getStatusCode());
        }

        // API fallback
        if ($request->expectsJson()) {

            Log::error("[$errorRef] API Exception", [
                'exception' => $exception
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Server error',
                'error_ref' => $errorRef
            ], 500);
        }
        // Log any remaining unhandled exception
        Log::error("[$errorRef] Unhandled Exception", [
            'exception' => $exception
        ]);

        // return response()->view('errors.500', [
        //     'error_ref' => $errorRef
        // ], 500);
        return parent::render($request, $exception);
    }
}

