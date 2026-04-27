<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajeSoporte extends Model
{
    use HasFactory;

    protected $table = 'mensajes_soporte';

    protected $fillable = [
        'nombre',
        'email',
        'motivo',
        'mensaje',
        'respuesta',
        'estado',
    ];
}
