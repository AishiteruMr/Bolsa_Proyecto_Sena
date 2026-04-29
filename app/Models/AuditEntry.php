<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditEntry extends Model
{
    protected $fillable = ['report_id', 'uri', 'expected', 'status', 'result', 'remediation'];
    public $timestamps = false;
}
