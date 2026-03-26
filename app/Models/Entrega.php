<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entrega extends Model
{
    protected $table = 'entrega_etapa';
    protected $primaryKey = 'ene_id';
    public $timestamps = false;

    protected $fillable = [
        'ene_apr_id',
        'ene_eta_id',
        'ene_pro_id',
        'ene_archivo_url',
        'ene_descripcion',
        'ene_fecha',
        'ene_estado',
    ];

    public function aprendiz(): BelongsTo
    {
        return $this->belongsTo(Aprendiz::class, 'ene_apr_id', 'apr_id');
    }

    public function etapa(): BelongsTo
    {
        return $this->belongsTo(Etapa::class, 'ene_eta_id', 'eta_id');
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'ene_pro_id', 'pro_id');
    }
}
