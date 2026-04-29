<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MiddlewareScannerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit:middleware-scan';

    protected $description = 'Analiza los middlewares personalizados de las rutas para inferir reglas de seguridad';

    public function handle(): int
    {
        $this->info("🔍 Analizando middlewares y sugiriendo remediación...");

        $routes = \Illuminate\Support\Facades\Route::getRoutes();
        $data = [];

        foreach ($routes as $route) {
            $middlewares = $route->gatherMiddleware();
            $hasAuth = in_array('auth.custom', $middlewares);
            $rules = [];
            $remediation = "Ninguna necesaria";

            foreach ($middlewares as $m) {
                if (str_starts_with($m, 'rol:')) {
                    $roleId = explode(':', $m)[1];
                    $roleName = match($roleId) {
                        '1' => 'Aprendiz', '2' => 'Instructor', '3' => 'Empresa', '4' => 'Administrador', default => 'Desconocido'
                    };
                    $rules[] = "Acceso: Rol $roleName";
                } elseif ($m === 'auth.custom') {
                    $rules[] = "Requiere Auth";
                }
            }

            // Lógica de remediación
            if (!$hasAuth) {
                if (str_starts_with($route->uri(), 'admin/')) $remediation = "Añadir ->middleware(['auth.custom', 'rol:4'])";
                elseif (str_starts_with($route->uri(), 'empresa/')) $remediation = "Añadir ->middleware(['auth.custom', 'rol:3'])";
                elseif (str_starts_with($route->uri(), 'instructor/')) $remediation = "Añadir ->middleware(['auth.custom', 'rol:2'])";
                elseif (str_starts_with($route->uri(), 'aprendiz/')) $remediation = "Añadir ->middleware(['auth.custom', 'rol:1'])";
                else $remediation = "Revisar protección de acceso";
            }

            if (!$hasAuth || !empty($rules)) {
                $data[] = [
                    'URI' => $route->uri(),
                    'Reglas' => implode("\n", $rules),
                    'Sugerencia' => $remediation,
                ];
            }
        }

        $this->table(['URI', 'Reglas', 'Sugerencia'], $data);

        return Command::SUCCESS;
    }

}
