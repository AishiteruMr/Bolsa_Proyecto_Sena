<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $fillable = [
        'user_id',
        'accion',
        'modulo',
        'tabla_afectada',
        'registro_id',
        'datos_anteriores',
        'datos_nuevos',
        'ip_address',
        'user_agent',
        'descripcion',
    ];

    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function registrar(
        int $userId,
        string $accion,
        string $modulo,
        ?string $tabla = null,
        ?int $registroId = null,
        ?array $anteriores = null,
        ?array $nuevos = null,
        ?string $descripcion = null
    ): self {
        return self::create([
            'user_id' => $userId,
            'accion' => $accion,
            'modulo' => $modulo,
            'tabla_afectada' => $tabla,
            'registro_id' => $registroId,
            'datos_anteriores' => $anteriores,
            'datos_nuevos' => $nuevos,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'descripcion' => $descripcion,
        ]);
    }

    public static function registrarCambio($userId, $accion, $modulo, $tabla, $registroId, $anteriores, $nuevos, $descripcion = null)
    {
        if (!$descripcion) {
            $descripcion = self::generarDescripcion($accion, $modulo, $anteriores, $nuevos, $registroId);
        }
        return self::registrar($userId, $accion, $modulo, $tabla, $registroId, $anteriores, $nuevos, $descripcion);
    }

    private static function generarDescripcion(string $accion, string $modulo, ?array $anterior, ?array $nuevo, $registroId = null): string
    {
        $moduloLimpio = strtolower(str_replace('_', ' ', $modulo));
        $cambios = self::calcularDiff($anterior, $nuevo);
        $cambiosTexto = !empty($cambios) ? implode('; ', $cambios) : '';
        
        $nombreTarget = $nuevo['nombre_objetivo'] ?? $anterior['nombre_objetivo'] ?? $nuevo['titulo'] ?? $anterior['titulo'] ?? null;
        $targetDesc = $nombreTarget ? " de {$nombreTarget}" : ($registroId ? " con ID: #{$registroId}" : "");

        if ($accion === 'cambiar_estado' && empty($cambiosTexto)) {
            $valNue = isset($nuevo['estado']) || isset($nuevo['usr_estado']) || isset($nuevo['activo']) 
                ? self::formatearValor('estado', $nuevo['estado'] ?? $nuevo['usr_estado'] ?? $nuevo['activo']) 
                : 'actualizado';
            return "Se ha formalizado la transición de estado en el módulo de {$moduloLimpio} para {$nombreTarget}{$targetDesc}, estableciendo su condición actual como: {$valNue}.";
        }

        return match ($accion) {
            'cambiar_estado' => "Actualización de estatus administrativo en {$moduloLimpio} para {$nombreTarget}{$targetDesc}. Se confirman los siguientes ajustes: {$cambiosTexto}.",
            'crear' => "Registro inicial y alta oficial en el sistema para {$moduloLimpio} de {$nombreTarget}{$targetDesc}. La información ha sido validada y procesada correctamente.",
            'editar' => "Modificación de parámetros operativos en {$moduloLimpio} para {$nombreTarget}{$targetDesc}. Resumen de los campos actualizados: " . ($cambiosTexto ? $cambiosTexto : "atributos generales del registro") . ".",
            'eliminar' => "Baja definitiva y remoción de registro en la sección de {$moduloLimpio} para {$nombreTarget}{$targetDesc}. Se ha completado el protocolo de eliminación.",
            'asignar' => "Gestión de asignación y vinculación en {$moduloLimpio} para {$nombreTarget}{$targetDesc}. " . ($cambiosTexto ? "Detalles: {$cambiosTexto}" : "Se ha designado un nuevo responsable para la gestión de este elemento."),
            'login' => "Autenticación de seguridad procesada. Acceso autorizado al centro de control administrativo.",
            'logout' => "Finalización de sesión exitosa. La conexión del usuario ha sido cerrada por protocolos de seguridad.",
            'subir_archivo' => "Carga de nuevo material documental en {$moduloLimpio} para {$nombreTarget}{$targetDesc}. Recurso almacenado con éxito.",
            'exportar' => "Generación de reporte externo de {$moduloLimpio}. Extracción de datos realizada satisfactoriamente.",
            'activar' => "Reactivación administrativa del registro en {$moduloLimpio} para {$nombreTarget}{$targetDesc}. El elemento se encuentra plenamente operativo.",
            'desactivar' => "Suspensión de actividades o desactivación en {$moduloLimpio} para {$nombreTarget}{$targetDesc}. Estado modificado a inactivo.",
            'aprobar' => "Emisión de dictamen favorable y aprobación oficial para {$moduloLimpio} de {$nombreTarget}{$targetDesc}.",
            'rechazar' => "Denegación administrativa y rechazo del registro en {$moduloLimpio} para {$nombreTarget}{$targetDesc}.",
            default => "Registro de actividad tipo '{$accion}' para {$moduloLimpio} de {$nombreTarget}{$targetDesc}." . ($cambiosTexto ? " Detalle: {$cambiosTexto}" : ""),
        };
    }

    private static function calcularDiff(?array $anterior, ?array $nuevo): array
    {
        if (!$anterior || !$nuevo) {
            return [];
        }

        $cambios = [];
        $mapeoCampos = [
            'usr_correo' => 'correo',
            'usr_nombre' => 'nombre',
            'usr_estado' => 'estado',
            'prj_estado' => 'estado del proyecto',
            'prj_nombre' => 'título',
            'password' => 'contraseña',
            'activo' => 'estado de cuenta',
            'instructor_usuario_id' => 'instructor asignado',
            'estado' => 'estado actual',
            'respuesta' => 'respuesta enviada'
        ];

        foreach ($nuevo as $campo => $valorNuevo) {
            // Ignorar campos de sistema e internos de auditoría
            if (in_array($campo, ['updated_at', 'remember_token', 'nombre_objetivo'])) continue;

            if (!isset($anterior[$campo])) {
                $nombreCampo = $mapeoCampos[$campo] ?? str_replace('_', ' ', $campo);
                $cambios[] = "se definió {$nombreCampo}";
            } elseif ($anterior[$campo] !== $valorNuevo) {
                $nombreCampo = $mapeoCampos[$campo] ?? str_replace('_', ' ', $campo);
                
                if ($campo === 'password') {
                    $cambios[] = "se cambió la contraseña";
                } else {
                    $valAnt = self::formatearValor($campo, $anterior[$campo]);
                    $valNue = self::formatearValor($campo, $valorNuevo);
                    $cambios[] = "{$nombreCampo} cambió de '{$valAnt}' a '{$valNue}'";
                }
            }
        }

        return $cambios;
    }

    private static function formatearValor($campo, $valor): string
    {
        if (is_null($valor)) return 'Sin asignar';
        
        $valorStr = (string)$valor;

        // Mapeo de estados binarios (Activo/Inactivo)
        if (in_array($campo, ['activo', 'usr_estado', 'estado_cuenta', 'habilitado'])) {
            return $valorStr === '1' ? 'Habilitado' : 'Inactivo/Bloqueado';
        }

        // Mapeo de estados de proyecto
        if ($campo === 'estado' || $campo === 'prj_estado') {
            return match($valorStr) {
                'aprobado' => 'Aprobado y Vigente',
                'rechazado' => 'No Admitido',
                'pendiente' => 'Pendiente de Revisión',
                'cerrado' => 'Finalizado/Cerrado',
                'en_progreso' => 'En Ejecución',
                default => ucfirst($valorStr)
            };
        }

        // Roles
        if ($campo === 'rol_id') {
            return match((int)$valor) {
                1 => 'Aprendiz',
                2 => 'Instructor',
                3 => 'Empresa',
                4 => 'Administrador',
                default => 'Usuario'
            };
        }

        return $valorStr;
    }

    public function getAccionIconAttribute(): string
    {
        return match ($this->accion) {
            'crear' => 'fa-plus-circle text-success',
            'editar' => 'fa-edit text-warning',
            'eliminar' => 'fa-trash text-danger',
            'cambiar_estado' => 'fa-toggle-on text-info',
            'asignar' => 'fa-user-plus text-primary',
            'login' => 'fa-sign-in-alt text-success',
            'logout' => 'fa-sign-out-alt text-secondary',
            'exportar' => 'fa-file-export text-info',
            default => 'fa-circle text-muted',
        };
    }

    public function scopeModulo($query, string $modulo)
    {
        return $query->where('modulo', $modulo);
    }

    public function scopeAccion($query, string $accion)
    {
        return $query->where('accion', $accion);
    }

    public function scopeRecientes($query, int $dias = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($dias));
    }

    public function scopePorUsuario($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function getCambiosAttribute(): array
    {
        return self::calcularDiff($this->datos_anteriores, $this->datos_nuevos);
    }
}
