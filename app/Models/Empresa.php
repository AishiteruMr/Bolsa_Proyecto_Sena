<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;
    protected $table = 'empresas';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'usuario_id',
        'nit',
        'nombre',
        'representante',
        'correo_contacto',
        'ubicacion',
        'latitud',
        'longitud',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function proyectos(): HasMany
    {
        return $this->hasMany(Proyecto::class, 'empresa_nit', 'nit');
    }

    public function isActivo(): bool
    {
        return (bool) $this->activo;
    }
}
