<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SecureHeaders
{
    // Define allowed hosts
    protected array $allowedHosts = [
        '10.197.254.86',
        '10.197.254.138',
        '10.197.254.59',
        '10.197.254.86/artprojfiles',
        'http://10.197.254.59',
        'http://10.197.254.86',
        'http://10.246.166.249',
        'http://10.197.254.138',
        'https://10.197.254.59',
        'https://10.197.254.86',
        'https://10.246.166.249',
        'https://192.168.3.169',
        'https://192.168.3.157',
        'localhost',
        '127.0.0.1', // optional for local testing
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Validate Host header
        $host = $request->getHost();
        if (!in_array($host, $this->allowedHosts, true)) {
            throw new BadRequestHttpException('Invalid Host header');
        }

        // Generate a unique CSP nonce
        $nonce = base64_encode(random_bytes(16));
        View::share('cspNonce', $nonce);
        
        /** @var Response $response */
        $response = $next($request);
        // Set Security Headers 'nonce-$nonce'
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=()');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' 'nonce-$nonce' ; style-src 'self' 'nonce-$nonce'; object-src 'none'; frame-ancestors 'none';");
        return $response;
    }
} 
