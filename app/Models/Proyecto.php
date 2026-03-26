<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Proyecto extends Model
{
    protected $table = 'proyecto';
    protected $primaryKey = 'pro_id';
    public $timestamps = false;

    protected $fillable = [
        'emp_nit',
        'pro_titulo_proyecto',
        'pro_descripcion',
        'pro_categoria',
        'pro_estado',
        'pro_imagen_url',
        'pro_fecha_inicio',
        'pro_fecha_fin',
        'pro_num_postulantes',
        'pro_requisitos_especificos',
        'pro_habilidades_requerida',
        'pro_duracion_estimada',
        'pro_fecha_publi',
        'pro_fecha_finalizacion',
        'ins_usr_documento',
        'pro_latitud',
        'pro_longitud',
    ];

    protected $casts = [
        'pro_fecha_inicio' => 'datetime',
        'pro_fecha_fin' => 'datetime',
        'pro_fecha_publi' => 'datetime',
        'pro_fecha_finalizacion' => 'datetime',
    ];

    // ── RELACIONES ──
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'emp_nit', 'emp_nit');
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class, 'ins_usr_documento', 'usr_id');
    }

    public function postulaciones(): HasMany
    {
        return $this->hasMany(Postulacion::class, 'pro_id', 'pro_id');
    }

    public function etapas(): HasMany
    {
        return $this->hasMany(Etapa::class, 'eta_pro_id', 'pro_id');
    }

    public function evidencias(): HasMany
    {
        return $this->hasMany(Evidencia::class, 'evid_pro_id', 'pro_id');
    }

    // ── SCOPES ──
    public function scopeActivos(Builder $query): Builder
    {
        return $query->where('pro_estado', 'Activo');
    }

    /**
     * Proyectos aprobados por el admin — visibles para aprendices
     */
    public function scopeAprobados(Builder $query): Builder
    {
        return $query->where('pro_estado', 'Aprobado');
    }

    /**
     * Proyectos pendientes de aprobación por el admin
     */
    public function scopePendientes(Builder $query): Builder
    {
        return $query->where('pro_estado', 'Pendiente');
    }

    public function scopeInactivos(Builder $query): Builder
    {
        return $query->where('pro_estado', 'Inactivo');
    }

    public function scopeFinalizados(Builder $query): Builder
    {
        return $query->where('pro_estado', 'Finalizado');
    }

    public function scopePorEmpresa(Builder $query, $empNit): Builder
    {
        return $query->where('emp_nit', $empNit);
    }

    public function scopePorCategoria(Builder $query, $categoria): Builder
    {
        return $query->where('pro_categoria', $categoria);
    }

    public function scopeBusqueda(Builder $query, $termino): Builder
    {
        return $query->where(function($q) use ($termino) {
            $q->where('pro_titulo_proyecto', 'like', "%{$termino}%")
              ->orWhere('pro_descripcion', 'like', "%{$termino}%");
        });
    }

    public function scopeRecientes(Builder $query): Builder
    {
        return $query->orderByDesc('pro_fecha_publi');
    }

    // ── MÉTODOS ──
    public function isActivo(): bool
    {
        return $this->pro_estado === 'Activo';
    }

    public function isAprobado(): bool
    {
        return $this->pro_estado === 'Aprobado';
    }

    public function isPendiente(): bool
    {
        return $this->pro_estado === 'Pendiente';
    }

    public function isRechazado(): bool
    {
        return $this->pro_estado === 'Rechazado';
    }

    public function isFinalizado(): bool
    {
        return $this->pro_estado === 'Finalizado';
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
     * Contar postulantes aprobados
     */
    public function countPostulantesAprobados(): int
    {
        return $this->postulacionesAprobadas()->count();
    }

    /**
     * Contar postulantes pendientes
     */
    public function countPostulantesPendientes(): int
    {
        return $this->postulacionesPendientes()->count();
    }

    /**
     * Contar todas las postulaciones
     */
    public function countPostulaciones(): int
    {
        return $this->postulaciones()->count();
    }

    /**
     * Obtener atributo contador de postulantes
     */
    public function getPostulantesCountAttribute(): int
    {
        return $this->countPostulaciones();
    }

    /**
     * Contar etapas totales
     */
    public function countEtapas(): int
    {
        return $this->etapas()->count();
    }

    /**
     * Obtener etapas ordenadas
     */
    public function etapasOrdenadas()
    {
        return $this->etapas()->orderBy('eta_orden')->get();
    }

    /**
     * Verificar si está vencido
     */
    public function isVencido(): bool
    {
        return now()->isAfter($this->pro_fecha_finalizacion);
    }

    /**
     * Obtener días restantes
     */
    public function diasRestantes(): int
    {
        return max(0, now()->diffInDays($this->pro_fecha_finalizacion, false));
    }

    /**
     * Obtener el nombre de la empresa
     */
    public function getEmpresaNombreAttribute(): string
    {
        return $this->empresa?->emp_nombre ?? 'Empresa no asignada';
    }

    /**
     * Accesor para la URL de la imagen del proyecto
     */
    public function getImagenUrlAttribute(): string
    {
        if (empty($this->pro_imagen_url)) {
            return asset('assets/default-project.jpg');
        }

        // Si la URL ya es completa o empieza por /storage, la devolvemos tal cual
        if (str_starts_with($this->pro_imagen_url, 'http') || str_starts_with($this->pro_imagen_url, '/storage')) {
            return $this->pro_imagen_url;
        }

        // De lo contrario, asumimos que está en el disco public de storage
        return asset('storage/' . $this->pro_imagen_url);
    }
}
