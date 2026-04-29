<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditReport extends Model
{
    protected $fillable = ['total_scanned', 'vulnerabilities_found'];
    public $timestamps = false;

    public function entries()
    {
        return $this->hasMany(AuditEntry::class, 'report_id');
    }
}
