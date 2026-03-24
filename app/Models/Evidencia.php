<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Evidencia extends Model
{
    protected $table = 'evidencia';
    protected $primaryKey = 'evid_id';
    public $timestamps = false;

    protected $fillable = [
        'evid_apr_id',
        'evid_eta_id',
        'evid_pro_id',
        'evid_archivo',
        'evid_fecha',
        'evid_estado',
        'evid_comentario',
    ];

    protected $casts = [
        'evid_fecha' => 'datetime',
    ];

    // ── RELACIONES ──
    public function aprendiz(): BelongsTo
    {
        return $this->belongsTo(Aprendiz::class, 'evid_apr_id', 'apr_id');
    }

    public function etapa(): BelongsTo
    {
        return $this->belongsTo(Etapa::class, 'evid_eta_id', 'eta_id');
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'evid_pro_id', 'pro_id');
    }

    // ── SCOPES ──
    public function scopeAprobadas(Builder $query): Builder
    {
        return $query->where('evid_estado', 'Aprobada');
    }

    public function scopePendientes(Builder $query): Builder
    {
        return $query->where('evid_estado', 'Pendiente');
    }

    public function scopeRechazadas(Builder $query): Builder
    {
        return $query->where('evid_estado', 'Rechazada');
    }

    // ── MÉTODOS ──
    public function isAprobada(): bool
    {
        return $this->evid_estado === 'Aprobada';
    }

    public function isPendiente(): bool
    {
        return $this->evid_estado === 'Pendiente';
    }

    public function isRechazada(): bool
    {
        return $this->evid_estado === 'Rechazada';
    }

    /**
     * Obtener la URL del archivo
     */
    public function getFileUrl(): string
    {
        return asset('storage/' . $this->evid_archivo);
    }

    /**
     * Verificar si tiene archivo
     */
    public function hasFile(): bool
    {
        return !empty($this->evid_archivo);
    }

    /**
     * Obtener estado en español
     */
    public function getEstadoEspañol(): string
    {
        return match($this->evid_estado) {
            'Aprobada' => '✅ Aprobada',
            'Rechazada' => '❌ Rechazada',
            'Pendiente' => '⏳ Pendiente',
            default => $this->evid_estado,
        };
    }
}
