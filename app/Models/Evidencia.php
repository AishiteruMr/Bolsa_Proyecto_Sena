<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Evidencia extends Model
{
    protected $table = 'evidencias';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'aprendiz_id',
        'etapa_id',
        'proyecto_id',
        'ruta_archivo',
        'fecha_envio',
        'estado',
        'comentario_instructor',
    ];

    protected $casts = [
        'fecha_envio' => 'datetime',
    ];

    // ── RELACIONES ──
    public function aprendiz(): BelongsTo
    {
        return $this->belongsTo(Aprendiz::class, 'aprendiz_id', 'id');
    }

    public function etapa(): BelongsTo
    {
        return $this->belongsTo(Etapa::class, 'etapa_id', 'id');
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

    // ── MÉTODOS ──
    public function isAprobada(): bool
    {
        return $this->estado === 'aceptada';
    }

    public function isPendiente(): bool
    {
        return $this->estado === 'pendiente';
    }

    public function isRechazada(): bool
    {
        return $this->estado === 'rechazada';
    }

    /**
     * Obtener la URL del archivo
     */
    public function getFileUrl(): string
    {
        return asset('storage/' . $this->ruta_archivo);
    }

    /**
     * Verificar si tiene archivo
     */
    public function hasFile(): bool
    {
        return !empty($this->ruta_archivo);
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
