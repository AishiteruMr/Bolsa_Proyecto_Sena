<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Inertia\Middleware as InertiaMiddleware;

class HandleInertiaRequests extends InertiaMiddleware
{
    public function share($page)
    {
        return array_merge(parent::share($page), [
            'auth' => [
                'user' => Auth::check() ? Auth::user()->load(['aprendiz', 'empresa', 'instructor', 'administrador']) : null,
            ],
            'flash' => [
                'success' => fn () => session('success'),
                'error' => fn () => session('error'),
                'warning' => fn () => session('warning'),
            ],
        ]);
    }
}