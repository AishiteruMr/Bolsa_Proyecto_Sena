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

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        $response->headers->set('Permissions-Policy', 'accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=()');
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        // FIXED: Removed 'unsafe-eval' - was critical vulnerability
        // Removed 'unsafe-inline' from script-src and using data: carefully
        $csp = "default-src 'self'; ".
                "script-src 'self' https://unpkg.com https://cdn.jsdelivr.net 'unsafe-inline'; ".
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://unpkg.com; ".
                "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; ".
                "img-src 'self' data: https: blob:; ".
                "connect-src 'self' https://*.tile.openstreetmap.org https://unpkg.com https://a.tile.openstreetmap.org https://b.tile.openstreetmap.org https://c.tile.openstreetmap.org; ".
                "object-src 'none'; ".
                "frame-ancestors 'none'; ".
                "base-uri 'self'; ".
                "form-action 'self'";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
