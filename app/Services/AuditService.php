<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Log;

/**
 * Phase 3: Comprehensive Audit Trail Service
 *
 * Centralized service for logging all significant user actions
 * Provides detailed audit trail for compliance and security monitoring
 */
class AuditService
{
    /**
     * Log user login
     */
    public static function logLogin(int $userId, bool $success = true, ?string $reason = null): void
    {
        self::log(
            userId: $userId,
            accion: 'login',
            modulo: 'autenticacion',
            tabla: 'usuarios',
            registroId: $userId,
            anteriores: ['success' => $success, 'reason' => $reason],
            nuevos: null
        );
    }

    /**
     * Log user logout
     */
    public static function logLogout(int $userId): void
    {
        self::log(
            userId: $userId,
            accion: 'logout',
            modulo: 'autenticacion',
            tabla: null,
            registroId: null,
            anteriores: null,
            nuevos: null
        );
    }

    /**
     * Log postulation (aprendiz posting to project)
     */
    public static function logPostulacion(int $userId, int $postulacionId, int $aprendizId, int $proyectoId): void
    {
        self::log(
            userId: $userId,
            accion: 'crear',
            modulo: 'postulaciones',
            tabla: 'postulaciones',
            registroId: $postulacionId,
            anteriores: null,
            nuevos: [
                'aprendiz_id' => $aprendizId,
                'proyecto_id' => $proyectoId,
                'estado' => 'pendiente',
            ]
        );
    }

    /**
     * Log postulation status change
     */
    public static function logPostulacionStatusChange(
        int $userId,
        int $postulacionId,
        string $oldStatus,
        string $newStatus,
        ?string $comment = null
    ): void {
        self::log(
            userId: $userId,
            accion: 'cambiar_estado',
            modulo: 'postulaciones',
            tabla: 'postulaciones',
            registroId: $postulacionId,
            anteriores: ['estado' => $oldStatus],
            nuevos: ['estado' => $newStatus, 'comentario' => $comment]
        );
    }

    /**
     * Log evidence upload
     */
    public static function logEvidenciaUpload(
        int $userId,
        int $evidenciaId,
        int $aprendizId,
        int $etapaId,
        int $proyectoId,
        ?string $archivoUrl = null
    ): void {
        self::log(
            userId: $userId,
            accion: 'crear',
            modulo: 'evidencias',
            tabla: 'evidencias',
            registroId: $evidenciaId,
            anteriores: null,
            nuevos: [
                'aprendiz_id' => $aprendizId,
                'etapa_id' => $etapaId,
                'proyecto_id' => $proyectoId,
                'archivo' => $archivoUrl ? 'uploaded' : 'sin_archivo',
                'estado' => 'pendiente',
            ]
        );
    }

    /**
     * Log evidence review
     */
    public static function logEvidenciaReview(
        int $userId,
        int $evidenciaId,
        string $oldStatus,
        string $newStatus,
        ?string $comentario = null
    ): void {
        self::log(
            userId: $userId,
            accion: 'cambiar_estado',
            modulo: 'evidencias',
            tabla: 'evidencias',
            registroId: $evidenciaId,
            anteriores: ['estado' => $oldStatus],
            nuevos: ['estado' => $newStatus, 'comentario' => $comentario]
        );
    }

    /**
     * Log project creation
     */
    public static function logProyectoCreacion(int $userId, int $proyectoId, array $proyectoData): void
    {
        self::log(
            userId: $userId,
            accion: 'crear',
            modulo: 'proyectos',
            tabla: 'proyectos',
            registroId: $proyectoId,
            anteriores: null,
            nuevos: [
                'titulo' => $proyectoData['titulo'] ?? null,
                'empresa_nit' => $proyectoData['empresa_nit'] ?? null,
                'estado' => 'pendiente',
            ]
        );
    }

    /**
     * Log project update
     */
    public static function logProyectoUpdate(
        int $userId,
        int $proyectoId,
        array $oldData,
        array $newData
    ): void {
        self::log(
            userId: $userId,
            accion: 'editar',
            modulo: 'proyectos',
            tabla: 'proyectos',
            registroId: $proyectoId,
            anteriores: $oldData,
            nuevos: $newData
        );
    }

    /**
     * Log profile update
     */
    public static function logPerfilUpdate(int $userId, string $userType, array $changes): void
    {
        self::log(
            userId: $userId,
            accion: 'editar',
            modulo: 'perfil',
            tabla: 'usuarios',
            registroId: $userId,
            anteriores: null,
            nuevos: [
                'user_type' => $userType,
                'cambios' => array_keys($changes),
            ]
        );
    }

    /**
     * Log password change
     */
    public static function logPasswordChange(int $userId): void
    {
        self::log(
            userId: $userId,
            accion: 'editar',
            modulo: 'seguridad',
            tabla: 'usuarios',
            registroId: $userId,
            anteriores: ['campo' => 'contrasena'],
            nuevos: ['campo' => 'contrasena', 'actualizado' => true]
        );
    }

    /**
     * Log email verification
     */
    public static function logEmailVerification(int $userId, string $email): void
    {
        self::log(
            userId: $userId,
            accion: 'verificar',
            modulo: 'autenticacion',
            tabla: 'usuarios',
            registroId: $userId,
            anteriores: ['email' => $email, 'verificado' => false],
            nuevos: ['email' => $email, 'verificado' => true]
        );
    }

    /**
     * Log failed login attempt
     */
    public static function logFailedLoginAttempt(string $email, ?string $ip = null): void
    {
        try {
            AuditLog::create([
                'user_id' => null,
                'accion' => 'failed_login',
                'modulo' => 'autenticacion',
                'tabla_afectada' => 'usuarios',
                'registro_id' => null,
                'datos_anteriores' => ['email' => $email],
                'datos_nuevos' => null,
                'ip_address' => $ip ?? request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Exception $e) {
            Log::warning('Error logging failed login attempt: '.$e->getMessage());
        }
    }

    /**
     * Log data export
     */
    public static function logDataExport(int $userId, string $exportType, int $recordCount): void
    {
        self::log(
            userId: $userId,
            accion: 'exportar',
            modulo: 'reportes',
            tabla: null,
            registroId: null,
            anteriores: null,
            nuevos: [
                'tipo' => $exportType,
                'registros' => $recordCount,
            ]
        );
    }

    /**
     * Log data deletion
     */
    public static function logDelecion(
        int $userId,
        string $modulo,
        string $tabla,
        int $registroId,
        array $datosEliminados
    ): void {
        self::log(
            userId: $userId,
            accion: 'eliminar',
            modulo: $modulo,
            tabla: $tabla,
            registroId: $registroId,
            anteriores: $datosEliminados,
            nuevos: ['estado' => 'eliminado']
        );
    }

    /**
     * Log security event
     */
    public static function logSecurityEvent(
        int $userId,
        string $evento,
        ?array $detalles = null
    ): void {
        self::log(
            userId: $userId,
            accion: 'security_event',
            modulo: 'seguridad',
            tabla: null,
            registroId: null,
            anteriores: null,
            nuevos: [
                'evento' => $evento,
                'detalles' => $detalles,
            ]
        );
    }

    /**
     * Generic log method - used by all specific logging functions
     */
    private static function log(
        int $userId,
        string $accion,
        string $modulo,
        ?string $tabla = null,
        ?int $registroId = null,
        ?array $anteriores = null,
        ?array $nuevos = null
    ): void {
        try {
            AuditLog::registrar(
                userId: $userId,
                accion: $accion,
                modulo: $modulo,
                tabla: $tabla,
                registroId: $registroId,
                anteriores: $anteriores,
                nuevos: $nuevos
            );
        } catch (\Exception $e) {
            Log::error('Error creating audit log: '.$e->getMessage(), [
                'usuario_id' => $userId,
                'accion' => $accion,
                'modulo' => $modulo,
            ]);
        }
    }

    /**
     * Get audit logs for a specific user
     */
    public static function getUserAuditLogs(int $userId, int $limit = 50)
    {
        return AuditLog::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Get audit logs for a module
     */
    public static function getModuleAuditLogs(string $modulo, int $limit = 50)
    {
        return AuditLog::modulo($modulo)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent security events
     */
    public static function getRecentSecurityEvents(int $days = 7, int $limit = 100)
    {
        return AuditLog::where('accion', 'like', '%security%')
            ->orWhere('accion', 'like', '%failed%')
            ->where('created_at', '>=', now()->subDays($days))
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }
}
