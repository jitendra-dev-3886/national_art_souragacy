<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HideHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle($request, Closure $next)
    {
       $response = $next($request);

        // Headers to remove
        $headers = [
            'X-Powered-By',
            'Server',
            'X-Runtime',
            'X-Laravel-Version',
            'X-PHP-Version',
            'X-Backend-Server',
            'Strict-Transport-Security'
           
        ];

        foreach ($headers as $header) {
            $response->headers->remove($header);
        }

        return $response;
    }
}
