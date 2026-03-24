<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Instructor extends Model
{
    protected $table = 'instructor';
    protected $primaryKey = 'usr_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'usr_id',
        'ins_nombre',
        'ins_apellido',
        'ins_especialidad',
        'ins_estado',
        'ins_estado_dis',
    ];

    protected $casts = [
        'ins_estado' => 'integer',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usr_id', 'usr_id');
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->ins_nombre . ' ' . $this->ins_apellido);
    }

    public function isActivo(): bool
    {
        return $this->ins_estado === 1;
    }
}
