<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // VALIDACIÓN DE INTEGRIDAD DE SESIÓN (Session Hijacking Protection)
        $this->validateSessionIntegrity($request);

        if (! session()->has('usr_id')) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar.');
        }

        // Validar que existe un rol válido
        $rol = session('rol');
        if (! in_array($rol, [1, 2, 3, 4], true)) {
            // Rol inválido - cerrar sesión
            session()->flush();

            return redirect()->route('login')->with('error', 'Sesión inválida. Por favor inicia sesión nuevamente.');
        }

        // Verificar si el usuario o empresa sigue activo y tiene perfil
        $usrId = session('usr_id');

        $perfil = match ($rol) {
            1 => DB::table('aprendices')->where('usuario_id', $usrId)->first(),
            2 => DB::table('instructores')->where('usuario_id', $usrId)->first(),
            3 => DB::table('empresas')->where('usuario_id', $usrId)->first(),
            4 => (object) ['activo' => 1], // Admin siempre activo
            default => null
        };

        if (! $perfil || (isset($perfil->activo) && $perfil->activo == 0)) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Tu sesión ha expirado o tu perfil no fue encontrado.');
        }

        // AUTO-HEAL: Asegurar que variables críticas estén en sesión
        if ($rol === 3 && ! session()->has('nit')) {
            session([
                'nit' => $perfil->nit,
                'emp_id' => $perfil->id,
                'documento' => $perfil->nit, // compatibilidad si hay algo usando documento
            ]);
        }
        if ($rol === 2 && ! session()->has('documento')) {
            $usuario = DB::table('usuarios')->where('id', $usrId)->first();
            if ($usuario) {
                session(['documento' => $usuario->numero_documento]);
            }
        }

        return $next($request);
    }

    /**
     * Validar integridad de la sesión para prevenir session hijacking
     * FIXED: Enabled IP validation to prevent session hijacking
     */
    private function validateSessionIntegrity(Request $request): void
    {
        $session = $request->session();

        // Validar IP de sesión - previene session hijacking
        $savedIp = $session->get('session_ip');
        $currentIp = $this->getClientIp($request);

        if ($savedIp && $currentIp && ! $this->isValidIpTransition($savedIp, $currentIp)) {
            Log::warning('IP change detected - possible session hijacking', [
                'saved_ip' => $savedIp,
                'current_ip' => $currentIp,
                'user_id' => $session->get('usr_id'),
            ]);
            // Invalidar sesión por seguridad
            $this->invalidateSession($request, 'Sesión iniciada desde otra ubicación.');

            return;
        }

        // Validar User Agent
        $savedAgent = $session->get('session_user_agent');
        $currentAgent = $request->userAgent();

        if ($savedAgent && ! $this->isSimilarUserAgent($savedAgent, $currentAgent)) {
            Log::warning('User agent mismatch - possible session anomaly', [
                'saved' => $savedAgent,
                'current' => $currentAgent,
                'ip' => $currentIp,
                'user_id' => $session->get('usr_id'),
            ]);
        }

        // Regenerar ID de sesión periódicamente - cada 5 minutos (antes 30)
        $lastRegen = $session->get('last_session_regen');
        if (! $lastRegen || now()->diffInMinutes($lastRegen) > 5) {
            $session->regenerate();
            $session->put('last_session_regen', now());
        }

        // Guardar información de seguridad
        if (! $session->has('session_ip')) {
            $session->put('session_ip', $currentIp);
        }
        if (! $session->has('session_user_agent')) {
            $session->put('session_user_agent', $currentAgent);
        }
        if (! $session->has('last_session_regen')) {
            $session->put('last_session_regen', now());
        }
    }

    /**
     * Obtener IP real del cliente considerando proxies
     */
    private function getClientIp(Request $request): string
    {
        // Considerar X-Forwarded-For para proxies/CDNs
        if ($request->header('X-Forwarded-For')) {
            $ips = explode(',', $request->header('X-Forwarded-For'));

            return trim($ips[0]);
        }
        if ($request->header('X-Real-IP')) {
            return $request->header('X-Real-IP');
        }

        return $request->ip() ?? '';
    }

    /**
     * Verificar si la transición de IP es válida (legítima)
     */
    private function isValidIpTransition(string $savedIp, string $currentIp): bool
    {
        // Misma subred /24 (misma red local)
        $savedParts = explode('.', $savedIp);
        $currentParts = explode('.', $currentIp);

        if (count($savedParts) === 4 && count($currentParts) === 4) {
            // Mismo /24 subnet = misma red local
            if ($savedParts[0] === $currentParts[0] &&
                $savedParts[1] === $currentParts[1] &&
                $savedParts[2] === $currentParts[2]) {
                return true;
            }
        }

        // IPv6: verificar prefix similar
        if (strpos($savedIp, ':') !== false && strpos($currentIp, ':') !== false) {
            // Mismo /64 prefix
            $savedPrefix = substr($savedIp, 0, strpos($savedIp, '::') !== false ? strpos($savedIp, '::') : 4);
            $currentPrefix = substr($currentIp, 0, strpos($currentIp, '::') !== false ? strpos($currentIp, '::') : 4);
            if ($savedPrefix === $currentPrefix) {
                return true;
            }
        }

        return false;
    }

    /**
     * Verificar si el user agent es similar (ignorar versiones de navegador)
     */
    private function isSimilarUserAgent(string $saved, string $current): bool
    {
        // Extraer palabras clave principales
        $savedKeywords = $this->extractUserAgentKeywords($saved);
        $currentKeywords = $this->extractUserAgentKeywords($current);

        // Si comparten al menos una palabra clave principal (browser/OS), es probable que sea el mismo dispositivo
        return count(array_intersect($savedKeywords, $currentKeywords)) > 0;
    }

    private function extractUserAgentKeywords(string $ua): array
    {
        $keywords = [];

        // Buscar patrones comunes
        $patterns = ['Chrome', 'Firefox', 'Safari', 'Edge', 'Opera', 'Chrome', 'Mobile', 'Android', 'Windows', 'Mac', 'Linux'];

        foreach ($patterns as $pattern) {
            if (stripos($ua, $pattern) !== false) {
                $keywords[] = $pattern;
            }
        }

        return $keywords;
    }

    /**
     * Invalidar sesión de forma segura
     */
    private function invalidateSession(Request $request, string $reason): void
    {
        Log::info('Session invalidated: '.$reason, [
            'user_id' => $request->session()->get('usr_id'),
            'ip' => $request->ip(),
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Invalidar y redirigir
        $request->session()->flush();

        // Usar redirect con->send() para salir del middleware
        redirect()->route('login')->with('error', $reason)->send();
        exit;
    }
}
