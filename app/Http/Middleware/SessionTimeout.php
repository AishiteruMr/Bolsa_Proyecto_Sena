<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionTimeout
{
    private const IDLE_TIMEOUT_MINUTES = 30;

    private const ABSOLUTE_TIMEOUT_MINUTES = 480;

    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('usr_id')) {
            return $next($request);
        }

        $lastActivity = $request->session()->get('last_activity');
        $rol = $request->session()->get('rol');

        $now = now();

        if ($lastActivity) {
            $idleMinutes = $now->diffInMinutes($lastActivity);

            $timeout = match ($rol) {
                4 => 15, // Admin: 15 min
                default => self::IDLE_TIMEOUT_MINUTES,
            };

            if ($idleMinutes > $timeout) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('error', 'Tu sesión ha expirado por inactividad.');
            }
        }

        $absoluteStart = $request->session()->get('session_start');
        if (! $absoluteStart) {
            $absoluteStart = $now;
            $request->session()->put('session_start', $absoluteStart);
        }

        if ($now->diffInMinutes($absoluteStart) > self::ABSOLUTE_TIMEOUT_MINUTES) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Tu sesión ha expirado. Por favor inicia sesión nuevamente.');
        }

        $request->session()->put('last_activity', $now);

        return $next($request);
    }
}
