<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=(), payment=()');

        // Mejorado: Removido unsafe-inline y unsafe-eval
        $csp = "default-src 'self'; ".
               "script-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; ".
               "style-src 'self' https://fonts.googleapis.com https://cdnjs.cloudflare.com; ".
               "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; ".
               "img-src 'self' data: https:; ".
               "frame-ancestors 'none'; ".
               "base-uri 'self'; ".
               "form-action 'self'; ".
               'upgrade-insecure-requests;';

        $response->headers->set('Content-Security-Policy', $csp);
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        return $response;
    }
}
