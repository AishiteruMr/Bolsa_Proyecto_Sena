<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Blade::directive('rol', function ($rol) {
            return "<?php if(session('rol') == {$rol}): ?>";
        });

        \Illuminate\Support\Facades\Blade::directive('endrol', function () {
            return "<?php endif; ?>";
        });
    }
}
