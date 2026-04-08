<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Aprendiz extends Model
{
    protected $table = 'aprendices';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'usuario_id',
        'nombres',
        'apellidos',
        'programa_formacion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // ── RELACIONES ──
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function postulaciones(): HasMany
    {
        return $this->hasMany(Postulacion::class, 'aprendiz_id', 'id');
    }

    public function evidencias(): HasMany
    {
        return $this->hasMany(Evidencia::class, 'aprendiz_id', 'id');
    }

    public function entregas(): HasMany
    {
        return $this->hasMany(Entrega::class, 'aprendiz_id', 'id');
    }

    // ── ATRIBUTOS ──
    public function getFullNameAttribute(): string
    {
        return trim($this->nombres . ' ' . $this->apellidos);
    }

    // ── SCOPES ──
    public function scopeActivos(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    public function scopeInactivos(Builder $query): Builder
    {
        return $query->where('activo', false);
    }

    // ── MÉTODOS ──
    public function isActivo(): bool
    {
        return $this->activo === true;
    }

    /**
     * Obtener postulaciones aprobadas
     */
    public function postulacionesAprobadas()
    {
        return $this->postulaciones()->where('estado', 'aceptada');
    }

    /**
     * Obtener postulaciones pendientes
     */
    public function postulacionesPendientes()
    {
        return $this->postulaciones()->where('estado', 'pendiente');
    }

    /**
     * Obtener postulaciones rechazadas
     */
    public function postulacionesRechazadas()
    {
        return $this->postulaciones()->where('estado', 'rechazada');
    }

    /**
     * Contar postulaciones aprobadas
     */
    public function countPostulacionesAprobadas(): int
    {
        return $this->postulacionesAprobadas()->count();
    }

    /**
     * Contar todas las postulaciones
     */
    public function countPostulaciones(): int
    {
        return $this->postulaciones()->count();
    }

    /**
     * Obtener proyectos disponibles (aprobados en la nueva estructura)
     */
    public function proyectosDisponibles()
    {
        return Proyecto::dondeDisponibles()->get();
    }

    /**
     * Obtener proyectos donde está postulado
     */
    public function proyectosPostulados()
    {
        return $this->postulaciones()->with('proyecto')->get();
    }

    /**
     * Obtener proyectos aprobados
     */
    public function proyectosAprobados()
    {
        return $this->postulacionesAprobadas()->with('proyecto')->get();
    }
}
