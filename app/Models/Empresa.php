<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Empresa extends Model
{
    protected $table = 'empresa';
    protected $primaryKey = 'emp_id';
    public $timestamps = false;

    protected $fillable = [
        'emp_nit',
        'emp_nombre',
        'emp_representante',
        'emp_correo',
        'emp_contrasena',
        'emp_estado',
    ];

    protected $hidden = [
        'emp_contrasena',
    ];

    protected $casts = [
        'emp_estado' => 'integer',
        'emp_contrasena' => 'hashed',
    ];

    public function proyectos(): HasMany
    {
        return $this->hasMany(Proyecto::class, 'emp_nit', 'emp_nit');
    }

    public function getAuthPassword(): string
    {
        return $this->emp_contrasena;
    }

    public function isActivo(): bool
    {
        return $this->emp_estado === 1;
    }
}
