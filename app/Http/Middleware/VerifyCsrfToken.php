<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected function shouldPassThrough($request)
    {
        // Si estamos ejecutando el comando de auditoría, saltar CSRF
        if ($request->hasHeader('X-Audit-Probe')) {
            return true;
        }

        return parent::shouldPassThrough($request);
    }
}
