<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Etapa extends Model
{
    protected $table = 'etapas';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'proyecto_id',
        'nombre',
        'descripcion',
        'orden',
    ];

    // ── RELACIONES ──
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    }

    public function evidencias(): HasMany
    {
        return $this->hasMany(Evidencia::class, 'etapa_id', 'id');
    }

    public function scopeOrdenadas(Builder $query): Builder
    {
        return $query->orderBy('orden');
    }

    /**
     * Obtener evidencias aprobadas de esta etapa
     */
    public function evidenciasAprobadas()
    {
        return $this->evidencias()->where('estado', 'aprobada');
    }

    /**
     * Obtener evidencias pendientes de esta etapa
     */
    public function evidenciasPendientes()
    {
        return $this->evidencias()->where('estado', 'pendiente');
    }

    /**
     * Contar evidencias aprobadas
     */
    public function countEvidenciasAprobadas(): int
    {
        return $this->evidenciasAprobadas()->count();
    }

    /**
     * Contar todas las evidencias
     */
    public function countEvidencias(): int
    {
        return $this->evidencias()->count();
    }

    /**
     * Verificar si es la última etapa
     */
    public function isUltima(): bool
    {
        return $this->orden === $this->proyecto->etapas()->max('orden');
    }

    /**
     * Obtener la etapa anterior
     */
    public function anterior()
    {
        return $this->proyecto
            ->etapas()
            ->where('orden', '<', $this->orden)
            ->orderByDesc('orden')
            ->first();
    }

    /**
     * Obtener la próxima etapa
     */
    public function siguiente()
    {
        return $this->proyecto
            ->etapas()
            ->where('orden', '>', $this->orden)
            ->orderBy('orden')
            ->first();
    }
}
