<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Instructor extends Model
{
    protected $table = 'instructores';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'usuario_id',
        'nombres',
        'apellidos',
        'especialidad',
        'activo',
        'disponibilidad',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->nombres . ' ' . $this->apellidos);
    }

    public function isActivo(): bool
    {
        return $this->activo === true;
    }
}
