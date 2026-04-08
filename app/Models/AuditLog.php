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
        ?array $nuevos = null
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
        ]);
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
}
