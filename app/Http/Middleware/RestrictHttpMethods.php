<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictHttpMethods
{
    public function handle(Request $request, Closure $next)
    {
        $allowedMethods = ['GET', 'POST','HEAD'];

        if (!in_array($request->getMethod(), $allowedMethods)) {
            return response('HTTP method not allowed.', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        return $next($request);
    }
}
