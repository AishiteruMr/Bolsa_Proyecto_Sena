<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Administrador extends Model
{
    protected $table = 'administrador';
    protected $primaryKey = 'adm_id';
    public $timestamps = false;

    protected $fillable = [
        'usr_id',
        'adm_nombre',
        'adm_apellido',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usr_id', 'usr_id');
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->adm_nombre . ' ' . $this->adm_apellido);
    }
}
