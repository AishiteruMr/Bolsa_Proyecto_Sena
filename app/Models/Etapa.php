<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Etapa extends Model
{
    protected $table = 'etapa';
    protected $primaryKey = 'eta_id';
    public $timestamps = false;

    protected $fillable = [
        'eta_pro_id',
        'eta_nombre',
        'eta_descripcion',
        'eta_orden',
        'eta_estado',
    ];

    // ── RELACIONES ──
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'eta_pro_id', 'pro_id');
    }

    public function evidencias(): HasMany
    {
        return $this->hasMany(Evidencia::class, 'evid_eta_id', 'eta_id');
    }

    // ── SCOPES ──
    public function scopeActivas(Builder $query): Builder
    {
        return $query->where('eta_estado', 'Activa');
    }

    public function scopeInactivas(Builder $query): Builder
    {
        return $query->where('eta_estado', 'Inactiva');
    }

    public function scopeOrdenadas(Builder $query): Builder
    {
        return $query->orderBy('eta_orden');
    }

    // ── MÉTODOS ──
    public function isActiva(): bool
    {
        return $this->eta_estado === 'Activa';
    }

    /**
     * Obtener evidencias aprobadas de esta etapa
     */
    public function evidenciasAprobadas()
    {
        return $this->evidencias()->where('evid_estado', 'Aprobada');
    }

    /**
     * Obtener evidencias pendientes de esta etapa
     */
    public function evidenciasPendientes()
    {
        return $this->evidencias()->where('evid_estado', 'Pendiente');
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
        return $this->eta_orden === $this->proyecto->etapas()->max('eta_orden');
    }

    /**
     * Obtener la etapa anterior
     */
    public function anterior()
    {
        return $this->proyecto
            ->etapas()
            ->where('eta_orden', '<', $this->eta_orden)
            ->orderByDesc('eta_orden')
            ->first();
    }

    /**
     * Obtener la próxima etapa
     */
    public function siguiente()
    {
        return $this->proyecto
            ->etapas()
            ->where('eta_orden', '>', $this->eta_orden)
            ->orderBy('eta_orden')
            ->first();
    }
}
