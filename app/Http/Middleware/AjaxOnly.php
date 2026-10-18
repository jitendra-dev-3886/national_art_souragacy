<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AjaxOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->header('X-Requested-With') && !$request->expectsJson()) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
