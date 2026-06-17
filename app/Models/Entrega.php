<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Entrega extends Model
{
    protected $table = 'entregas_etapa';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'aprendiz_id',
        'etapa_id',
        'proyecto_id',
        'url_archivo',
        'descripcion',
        'estado',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Entrega $entrega) {
            if ($entrega->hasFile()) {
                Storage::disk('public')->delete($entrega->url_archivo);
            }
        });
    }

    public function aprendiz(): BelongsTo
    {
        return $this->belongsTo(Aprendiz::class, 'aprendiz_id', 'id');
    }

    public function etapa(): BelongsTo
    {
        return $this->belongsTo(Etapa::class, 'etapa_id', 'id');
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id', 'id');
    }

    public function getFileUrl(): string
    {
        if (empty($this->url_archivo)) {
            return '';
        }
        return asset('storage/' . $this->url_archivo);
    }

    public function hasFile(): bool
    {
        return !empty($this->url_archivo);
    }
}
