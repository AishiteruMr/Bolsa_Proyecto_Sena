<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aprendiz extends Model
{
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

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usr_id', 'usr_id');
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->apr_nombre . ' ' . $this->apr_apellido);
    }

    public function isActivo(): bool
    {
        return $this->apr_estado === 1;
    }
}
