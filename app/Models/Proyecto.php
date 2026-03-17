<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    protected $casts = [
        'pro_fecha_inicio' => 'datetime',
        'pro_fecha_fin' => 'datetime',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'emp_nit', 'emp_nit');
    }

    public function postulaciones(): HasMany
    {
        return $this->hasMany(Postulacion::class, 'pro_id', 'pro_id');
    }

    public function isActivo(): bool
    {
        return $this->pro_estado === 'Activo';
    }

    public function getPostulantesCountAttribute(): int
    {
        return $this->postulaciones()->count();
    }
}
