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

    public static function registrarCambio(
        int $userId,
        string $accion,
        string $modulo,
        ?string $tabla = null,
        ?int $registroId = null,
        ?array $anteriores = null,
        ?array $nuevos = null
    ): self {
        $descripcion = self::generarDescripcion($accion, $modulo, $anteriores, $nuevos);

        return self::registrar($userId, $accion, $modulo, $tabla, $registroId, $anteriores, $nuevos, $descripcion);
    }

    private static function generarDescripcion(string $accion, string $modulo, ?array $anterior, ?array $nuevo): string
    {
        $cambios = self::calcularDiff($anterior, $nuevo);
        $cambiosTexto = implode(', ', $cambios);

        return match ($accion) {
            'cambiar_estado' => "Cambio de estado en {$modulo}: {$cambiosTexto}",
            'crear' => "Registro creado en {$modulo}",
            'editar' => "Valores modificados en {$modulo}: {$cambiosTexto}",
            'eliminar' => "Registro eliminado en {$modulo}",
            'asignar' => "Asignación realizada en {$modulo}: {$cambiosTexto}",
            'login' => "Inicio de sesión en {$modulo}",
            'logout' => "Cierre de sesión en {$modulo}",
            default => "Acción '{$accion}' en {$modulo}",
        };
    }

    private static function calcularDiff(?array $anterior, ?array $nuevo): array
    {
        if (!$anterior || !$nuevo) {
            return [];
        }

        $cambios = [];

        foreach ($nuevo as $campo => $valorNuevo) {
            if (!isset($anterior[$campo])) {
                $cambios[] = "{$campo}=nuevo({$valorNuevo})";
            } elseif ($anterior[$campo] !== $valorNuevo) {
                $valorAnterior = var_export($anterior[$campo], true);
                $valorNuevo = var_export($valorNuevo, true);
                $cambios[] = "{$campo}: {$valorAnterior}→{$valorNuevo}";
            }
        }

        return $cambios;
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
