<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Proyecto extends Model
{
    protected $table = 'proyectos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'empresa_nit',
        'instructor_usuario_id',
        'titulo',
        'descripcion',
        'categoria',
        'estado',
        'imagen_url',
        'requisitos_especificos',
        'habilidades_requeridas',
        'duracion_estimada_dias',
        'fecha_publicacion',
        'numero_postulantes',
        'ubicacion',
        'latitud',
        'longitud',
    ];

    protected $casts = [
        'fecha_publicacion' => 'date',
    ];

    // ── RELACIONES ──
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_nit', 'nit');
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class, 'instructor_usuario_id', 'usuario_id');
    }

    public function postulaciones(): HasMany
    {
        return $this->hasMany(Postulacion::class, 'proyecto_id', 'id');
    }

    public function etapas(): HasMany
    {
        return $this->hasMany(Etapa::class, 'proyecto_id', 'id');
    }

    public function evidencias(): HasMany
    {
        return $this->hasMany(Evidencia::class, 'proyecto_id', 'id');
    }

    // ── SCOPES ──
    public function scopeActivos(Builder $query): Builder
    {
        return $query->where('estado', 'aprobado');
    }

    public function scopePendientes(Builder $query): Builder
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeRechazados(Builder $query): Builder
    {
        return $query->where('estado', 'rechazado');
    }

    public function scopeFinalizados(Builder $query): Builder
    {
        return $query->where('estado', 'cerrado');
    }

    public function scopeDondeDisponibles(Builder $query): Builder
    {
        return $query->where('estado', 'aprobado'); // alias para semántica vieja
    }

    public function scopePorEmpresa(Builder $query, $empNit): Builder
    {
        return $query->where('empresa_nit', $empNit);
    }

    public function scopePorCategoria(Builder $query, $categoria): Builder
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeBusqueda(Builder $query, $termino): Builder
    {
        return $query->where(function($q) use ($termino) {
            $q->where('titulo', 'like', "%{$termino}%")
              ->orWhere('descripcion', 'like', "%{$termino}%");
        });
    }

    public function scopeRecientes(Builder $query): Builder
    {
        return $query->orderByDesc('fecha_publicacion');
    }

    // ── MÉTODOS ──
    public function isActivo(): bool
    {
        return in_array($this->estado, ['aprobado', 'en_progreso']);
    }

    public function isPendiente(): bool
    {
        return $this->estado === 'pendiente';
    }

    public function isRechazado(): bool
    {
        return $this->estado === 'rechazado';
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
        return $this->numero_postulantes ?: $this->countPostulaciones();
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
        return $this->etapas()->orderBy('orden')->get();
    }

    /**
     * Verificar si está vencido (Usaba fecha_finalizacion, ahora estimamos por duracion o estado cerrado)
     */
    public function isVencido(): bool
    {
        if ($this->estado == 'cerrado') return true;
        if (!$this->fecha_publicacion || !$this->duracion_estimada_dias) return false;
        
        $fechaFinEstimada = Carbon::parse($this->fecha_publicacion)->addDays($this->duracion_estimada_dias);
        return now()->isAfter($fechaFinEstimada);
    }

    /**
     * Obtener el nombre de la empresa
     */
    public function getEmpresaNombreAttribute(): string
    {
        return $this->empresa?->nombre ?? 'Empresa no asignada';
    }

    /**
     * Accesor para la URL de la imagen del proyecto
     */
    public function getImagenUrlAttribute($value): string
    {
        // En Eloquent, recibir el $value original de la BD si usamos el mutator:
        if (empty($value)) {
            return asset('assets/default-project.jpg');
        }

        // Si la URL ya es completa o empieza por /storage, la devolvemos tal cual
        if (str_starts_with($value, 'http') || str_starts_with($value, '/storage')) {
            return $value;
        }

        // De lo contrario, asumimos que está en el disco public de storage
        return asset('storage/' . $value);
    }

    /**
     * Evalúa la calidad del proyecto basándose en características específicas.
     * Retorna un array con el puntaje y los puntos fallidos.
     */
    public function calidadProyecto(): array
    {
        $detalles = [
            'titulo'      => strlen($this->titulo) >= 15,
            'descripcion' => strlen($this->descripcion) >= 100,
            'requisitos'  => strlen($this->requisitos_especificos) >= 20,
            'habilidades' => strlen($this->habilidades_requeridas) >= 15,
            'ubicacion'   => !is_null($this->latitud) && !is_null($this->longitud),
            'imagen'      => !empty($this->getRawOriginal('imagen_url'))
        ];

        $puntos = 0;
        $total = count($detalles);
        foreach ($detalles as $ok) {
            if ($ok) $puntos++;
        }

        $porcentaje = ($puntos / $total) * 100;

        return [
            'porcentaje' => round($porcentaje),
            'detalles'   => $detalles,
            'es_apto'    => $porcentaje >= 80 // Consideramos apto si tiene 80% o más
        ];
    }
}
