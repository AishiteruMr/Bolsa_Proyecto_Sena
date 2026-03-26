<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aprendiz extends Model
{
    use HasFactory;
    protected $table = 'aprendiz';
    protected $primaryKey = 'apr_id';
    public $timestamps = false;

    protected $fillable = [
        'usr_id',
        'apr_nombre',
        'apr_apellido',
        'apr_programa',
        'apr_estado',
    ];

    protected $casts = [
        'apr_estado' => 'integer',
    ];

    // ── RELACIONES ──
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usr_id', 'usr_id');
    }

    public function postulaciones(): HasMany
    {
        return $this->hasMany(Postulacion::class, 'apr_id', 'apr_id');
    }

    public function evidencias(): HasMany
    {
        return $this->hasMany(Evidencia::class, 'evid_apr_id', 'apr_id');
    }

    // ── ATRIBUTOS ──
    public function getFullNameAttribute(): string
    {
        return trim($this->apr_nombre . ' ' . $this->apr_apellido);
    }

    // ── SCOPES ──
    public function scopeActivos(Builder $query): Builder
    {
        return $query->where('apr_estado', 1);
    }

    public function scopeInactivos(Builder $query): Builder
    {
        return $query->where('apr_estado', 0);
    }

    // ── MÉTODOS ──
    public function isActivo(): bool
    {
        return $this->apr_estado === 1;
    }

    /**
     * Obtener postulaciones aprobadas
     */
    public function postulacionesAprobadas()
    {
        return $this->postulaciones()->where('pos_estado', 'Aprobada');
    }

    /**
     * Obtener postulaciones pendientes
     */
    public function postulacionesPendientes()
    {
        return $this->postulaciones()->where('pos_estado', 'Pendiente');
    }

    /**
     * Obtener postulaciones rechazadas
     */
    public function postulacionesRechazadas()
    {
        return $this->postulaciones()->where('pos_estado', 'Rechazada');
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
     * Obtener proyectos disponibles (activos)
     */
    public function proyectosDisponibles()
    {
        return Proyecto::where('pro_estado', 'Activo')->get();
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
