<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Postulacion extends Model
{
    protected $table = 'postulaciones';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'aprendiz_id',
        'proyecto_id',
        'fecha_postulacion',
        'estado',
    ];

    protected $casts = [
        'fecha_postulacion' => 'datetime',
    ];

    // ── RELACIONES ──
    public function aprendiz(): BelongsTo
    {
        return $this->belongsTo(Aprendiz::class, 'aprendiz_id', 'id');
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    }

    // ── SCOPES ──
    public function scopeAprobadas(Builder $query): Builder
    {
        return $query->where('estado', 'aceptada');
    }

    public function scopePendientes(Builder $query): Builder
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeRechazadas(Builder $query): Builder
    {
        return $query->where('estado', 'rechazada');
    }

    public function scopePorAprendiz(Builder $query, $aprendizId): Builder
    {
        return $query->where('aprendiz_id', $aprendizId);
    }

    public function scopePorProyecto(Builder $query, $proyectoId): Builder
    {
        return $query->where('proyecto_id', $proyectoId);
    }

    public function scopeRecientes(Builder $query): Builder
    {
        return $query->orderByDesc('fecha_postulacion');
    }

    // ── MÉTODOS ──
    public function isPendiente(): bool
    {
        return $this->estado === 'pendiente';
    }

    public function isAprobada(): bool
    {
        return $this->estado === 'aceptada';
    }

    public function isRechazada(): bool
    {
        return $this->estado === 'rechazada';
    }

    /**
     * Verificar si la postulación es duplicada
     */
    public static function yaPostulado($aprendizId, $proyectoId): bool
    {
        return self::where('aprendiz_id', $aprendizId)
                   ->where('proyecto_id', $proyectoId)
                   ->exists();
    }

    /**
     * Obtener la postulación de un aprendiz para un proyecto específico
     */
    public static function obtenerPostulacion($aprendizId, $proyectoId): ?self
    {
        return self::where('aprendiz_id', $aprendizId)
                   ->where('proyecto_id', $proyectoId)
                   ->first();
    }

    /**
     * Validar si puede postularse
     */
    public static function validarPostulacion($aprendizId, $proyectoId): array
    {
        $aprendiz = Aprendiz::find($aprendizId);
        if (!$aprendiz || !$aprendiz->isActivo()) {
            return [false, 'Tu cuenta de aprendiz no está activa.'];
        }

        $proyecto = Proyecto::find($proyectoId);
        if (!$proyecto) {
            return [false, 'El proyecto no existe.'];
        }

        if (!$proyecto->isActivo()) {
            return [false, 'El proyecto no está disponible para postulaciones.'];
        }

        if (self::yaPostulado($aprendizId, $proyectoId)) {
            return [false, 'Ya te postulaste a este proyecto.'];
        }

        $rechazada = self::where('aprendiz_id', $aprendizId)
                         ->where('proyecto_id', $proyectoId)
                         ->where('estado', 'rechazada')
                         ->exists();
        
        if ($rechazada) {
            return [false, 'Tu postulación a este proyecto fue rechazada. No puedes postularte nuevamente.'];
        }

        return [true, 'Validación exitosa'];
    }

    /**
     * Obtener estado en español
     */
    public function getEstadoEspañol(): string
    {
        return match($this->estado) {
            'aceptada' => '✅ Aprobada',
            'rechazada' => '❌ Rechazada',
            'pendiente' => '⏳ Pendiente',
            default => ucfirst($this->estado),
        };
    }
}
