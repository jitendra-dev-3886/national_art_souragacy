<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRefererAndIntended
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $referer = $request->headers->get('referer');
        $intended = session('url.intended');

        Log::info('Request Debug', [
            'current_url' => $request->fullUrl(),
            'referer' => $referer,
            'url_intended' => $intended,
        ]);

        return $next($request);
    }
}