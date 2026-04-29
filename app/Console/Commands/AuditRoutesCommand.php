<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class AuditRoutesCommand extends Command
{
    protected $signature = 'audit:routes';

    protected $description = 'Explora las rutas del sistema y analiza su seguridad';

    public function handle(): int
    {
        $routes = Route::getRoutes();

        $this->info("🔎 Auditando rutas del sistema...");

        $data = [];
        foreach ($routes as $route) {
            $data[] = [
                'uri' => $route->uri(),
                'method' => implode('|', $route->methods()),
                'action' => $route->getActionName(),
                'middleware' => implode(', ', $route->gatherMiddleware()),
            ];
        }

        $this->table(['URI', 'Métodos', 'Acción', 'Middleware'], $data);

        return Command::SUCCESS;
    }
}
