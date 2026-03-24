<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Postulacion extends Model
{
    protected $table = 'postulacion';
    protected $primaryKey = 'pos_id';
    public $timestamps = false;

    protected $fillable = [
        'apr_id',
        'pro_id',
        'pos_fecha',
        'pos_estado',
    ];

    protected $casts = [
        'pos_fecha' => 'datetime',
    ];

    // ── RELACIONES ──
    public function aprendiz(): BelongsTo
    {
        return $this->belongsTo(Aprendiz::class, 'apr_id', 'apr_id');
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'pro_id', 'pro_id');
    }

    // ── SCOPES ──
    public function scopeAprobadas(Builder $query): Builder
    {
        return $query->where('pos_estado', 'Aprobada');
    }

    public function scopePendientes(Builder $query): Builder
    {
        return $query->where('pos_estado', 'Pendiente');
    }

    public function scopeRechazadas(Builder $query): Builder
    {
        return $query->where('pos_estado', 'Rechazada');
    }

    public function scopePorAprendiz(Builder $query, $aprendizId): Builder
    {
        return $query->where('apr_id', $aprendizId);
    }

    public function scopePorProyecto(Builder $query, $proyectoId): Builder
    {
        return $query->where('pro_id', $proyectoId);
    }

    public function scopeRecientes(Builder $query): Builder
    {
        return $query->orderByDesc('pos_fecha');
    }

    // ── MÉTODOS ──
    public function isPendiente(): bool
    {
        return $this->pos_estado === 'Pendiente';
    }

    public function isAprobada(): bool
    {
        return $this->pos_estado === 'Aprobada';
    }

    public function isRechazada(): bool
    {
        return $this->pos_estado === 'Rechazada';
    }

    /**
     * Verificar si la postulación es duplicada
     * (ya existe una postulación de este aprendiz para este proyecto)
     */
    public static function yaPostulado($aprendizId, $proyectoId): bool
    {
        return self::where('apr_id', $aprendizId)
                   ->where('pro_id', $proyectoId)
                   ->exists();
    }

    /**
     * Obtener la postulación de un aprendiz para un proyecto específico
     */
    public static function obtenerPostulacion($aprendizId, $proyectoId): ?self
    {
        return self::where('apr_id', $aprendizId)
                   ->where('pro_id', $proyectoId)
                   ->first();
    }

    /**
     * Validar si puede postularse
     * Retorna array con [bool, string mensaje]
     */
    public static function validarPostulacion($aprendizId, $proyectoId): array
    {
        // Verificar que el aprendiz existe y está activo
        $aprendiz = Aprendiz::find($aprendizId);
        if (!$aprendiz || !$aprendiz->isActivo()) {
            return [false, 'Tu cuenta de aprendiz no está activa.'];
        }

        // Verificar que el proyecto existe y está activo
        $proyecto = Proyecto::find($proyectoId);
        if (!$proyecto) {
            return [false, 'El proyecto no existe.'];
        }

        if (!$proyecto->isActivo()) {
            return [false, 'El proyecto no está disponible para postulaciones.'];
        }

        // Verificar que no esté duplicada
        if (self::yaPostulado($aprendizId, $proyectoId)) {
            return [false, 'Ya te postulaste a este proyecto.'];
        }

        // Verificar si fue rechazado en este proyecto antes
        $rechazada = self::where('apr_id', $aprendizId)
                         ->where('pro_id', $proyectoId)
                         ->where('pos_estado', 'Rechazada')
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
        return match($this->pos_estado) {
            'Aprobada' => '✅ Aprobada',
            'Rechazada' => '❌ Rechazada',
            'Pendiente' => '⏳ Pendiente',
            default => $this->pos_estado,
        };
    }
}
