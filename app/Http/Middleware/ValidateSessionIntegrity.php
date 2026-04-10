<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ValidateSessionIntegrity
{
    /**
     * Phase 3: Session Integrity Validation and IP Locking
     *
     * This middleware validates:
     * 1. Session hasn't expired
     * 2. IP address hasn't changed (IP locking)
     * 3. User agent hasn't changed (device validation)
     * 4. Session integrity tokens match
     *
     * Invalidates suspicious sessions to prevent session hijacking
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip validation for unauthenticated routes
        if ($this->shouldSkipValidation($request)) {
            return $next($request);
        }

        $usrId = session('usr_id');

        if ($usrId) {
            $currentIp = $request->ip();
            $currentUserAgent = $request->userAgent();

            // Get stored session info
            $sessionIp = session('session_ip');
            $sessionUserAgent = session('session_user_agent');
            $sessionToken = session('session_integrity_token');

            // Validate or initialize session security data
            if (! $sessionIp) {
                // First request - store session data
                session(['session_ip' => $currentIp]);
                session(['session_user_agent' => $currentUserAgent]);

                // Generate integrity token
                $token = hash('sha256', $usrId.$currentIp.$currentUserAgent.config('app.key'));
                session(['session_integrity_token' => $token]);
            } else {
                // Validate IP hasn't changed
                if ($currentIp !== $sessionIp) {
                    $this->logSecurityEvent($usrId, 'IP_CHANGE_DETECTED', $sessionIp, $currentIp);
                    $this->invalidateSession($request, $usrId);

                    return redirect()->route('login')
                        ->with('error', '🔒 Sesión invalidada: Se detectó cambio en tu dirección IP. Por seguridad, debes volver a iniciar sesión.');
                }

                // Validate user agent (device) hasn't changed significantly
                if ($this->deviceChanged($sessionUserAgent, $currentUserAgent)) {
                    $this->logSecurityEvent($usrId, 'DEVICE_CHANGE_DETECTED', $sessionUserAgent, $currentUserAgent);
                    $this->invalidateSession($request, $usrId);

                    return redirect()->route('login')
                        ->with('error', '🔒 Sesión invalidada: Se detectó cambio en tu dispositivo. Por seguridad, debes volver a iniciar sesión.');
                }

                // Validate session integrity token
                $expectedToken = hash('sha256', $usrId.$sessionIp.$sessionUserAgent.config('app.key'));
                if ($sessionToken !== $expectedToken) {
                    $this->logSecurityEvent($usrId, 'SESSION_TOKEN_INVALID', 'computed', 'stored');
                    $this->invalidateSession($request, $usrId);

                    return redirect()->route('login')
                        ->with('error', '🔒 Sesión comprometida. Por favor, vuelve a iniciar sesión.');
                }

                // Session is valid, update last activity time
                session(['last_activity' => now()->timestamp]);
            }
        }

        return $next($request);
    }

    /**
     * Determine if validation should be skipped
     */
    private function shouldSkipValidation(Request $request): bool
    {
        $skipPaths = [
            'login',
            'registro',
            'registroAprendiz',
            'registroInstructor',
            'registroEmpresa',
            'forgot-password',
            'reset-password',
            'verify-email',
            'logout',
            'health',
        ];

        foreach ($skipPaths as $path) {
            if ($request->is($path) || $request->is($path.'/*')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if device (user agent) has changed significantly
     * Allows minor variations (like browser updates) but catches major device changes
     */
    private function deviceChanged(string $oldAgent, string $newAgent): bool
    {
        // Extract browser family (rough comparison)
        $oldBrowser = $this->extractBrowser($oldAgent);
        $newBrowser = $this->extractBrowser($newAgent);

        // If browser family changed significantly, flag it
        if ($oldBrowser !== $newBrowser) {
            return true;
        }

        // Check if OS changed (mobile vs desktop)
        $oldOS = $this->extractOS($oldAgent);
        $newOS = $this->extractOS($newAgent);

        if ($oldOS !== $newOS) {
            return true;
        }

        return false;
    }

    /**
     * Extract browser family from user agent
     */
    private function extractBrowser(string $userAgent): string
    {
        if (stripos($userAgent, 'Firefox') !== false) {
            return 'firefox';
        }
        if (stripos($userAgent, 'Chrome') !== false) {
            return 'chrome';
        }
        if (stripos($userAgent, 'Safari') !== false) {
            return 'safari';
        }
        if (stripos($userAgent, 'Edge') !== false) {
            return 'edge';
        }

        return 'other';
    }

    /**
     * Extract OS from user agent
     */
    private function extractOS(string $userAgent): string
    {
        if (stripos($userAgent, 'Windows') !== false) {
            return 'windows';
        }
        if (stripos($userAgent, 'Mac') !== false) {
            return 'macos';
        }
        if (stripos($userAgent, 'Linux') !== false) {
            return 'linux';
        }
        if (stripos($userAgent, 'iPhone') !== false || stripos($userAgent, 'iPad') !== false) {
            return 'ios';
        }
        if (stripos($userAgent, 'Android') !== false) {
            return 'android';
        }

        return 'other';
    }

    /**
     * Log security event for audit trail
     */
    private function logSecurityEvent(int $userId, string $event, string $old, string $new): void
    {
        try {
            AuditLog::registrar(
                userId: $userId,
                accion: 'security_alert',
                modulo: 'session',
                tabla: 'usuarios',
                registroId: $userId,
                anteriores: ['event' => $event, 'value' => $old],
                nuevos: ['event' => $event, 'value' => $new]
            );
        } catch (\Exception $e) {
            Log::error('Error logging security event: '.$e->getMessage());
        }
    }

    /**
     * Invalidate session
     */
    private function invalidateSession(Request $request, int $userId): void
    {
        $request->session()->flush();
        $request->session()->regenerate();

        // Log the session invalidation
        try {
            AuditLog::registrar(
                userId: $userId,
                accion: 'session_invalidated',
                modulo: 'session',
                tabla: null,
                registroId: null,
                anteriores: ['reason' => 'security_violation'],
                nuevos: null
            );
        } catch (\Exception $e) {
            Log::error('Error logging session invalidation: '.$e->getMessage());
        }
    }
}
