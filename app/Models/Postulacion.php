<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Postulacion extends Model
{
    protected $table = 'postulacion';
    protected $primaryKey = 'pos_id';
    public $timestamps = false;

    protected $fillable = [
        'apr_id',
        'pro_id',
        'pos_fecha',
        'pos_estado',
    ];

    protected $casts = [
        'pos_fecha' => 'datetime',
    ];

    public function aprendiz(): BelongsTo
    {
        return $this->belongsTo(Aprendiz::class, 'apr_id', 'apr_id');
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'pro_id', 'pro_id');
    }

    public function isPendiente(): bool
    {
        return $this->pos_estado === 'Pendiente';
    }

    public function isAprobada(): bool
    {
        return $this->pos_estado === 'Aprobada';
    }

    public function isRechazada(): bool
    {
        return $this->pos_estado === 'Rechazada';
    }
}
