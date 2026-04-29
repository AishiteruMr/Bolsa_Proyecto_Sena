<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AuditTestGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit:generate-tests';

    protected $description = 'Genera automáticamente Feature Tests basados en los middlewares de las rutas';

    public function handle(): int
    {
        $this->info("🧪 Generando pruebas automáticas...");

        $routes = \Illuminate\Support\Facades\Route::getRoutes();
        $testPath = base_path('tests/Feature/GeneratedAuditTests.php');
        
        $testCode = "<?php\n\nnamespace Tests\Feature;\n\nuse Illuminate\Foundation\Testing\RefreshDatabase;\nuse Tests\TestCase;\nuse App\Models\User;\n\nclass GeneratedAuditTests extends TestCase\n{\n    use RefreshDatabase;\n\n";

        foreach ($routes as $route) {
            if (!in_array('GET', $route->methods()) || str_contains($route->uri(), '{')) continue;

            $middlewares = $route->gatherMiddleware();
            $hasAuth = in_array('auth.custom', $middlewares);
            $requiredRole = null;
            foreach($middlewares as $m) {
                if (str_starts_with($m, 'rol:')) {
                    $requiredRole = (int)str_replace('rol:', '', $m);
                }
            }

            $routeName = str_replace(['/', '{', '}'], '_', $route->uri());
            $uri = '/' . ltrim($route->uri(), '/');

            // Test 1: Invitado
            if ($hasAuth) {
                $testCode .= "    public function test_guest_cannot_access_{$routeName}() {\n";
                $testCode .= "        \$this->get('{$uri}')->assertStatus(302);\n";
                $testCode .= "    }\n\n";
            }

            // Test 2: Rol incorrecto
            if ($requiredRole) {
                $testCode .= "    public function test_wrong_role_cannot_access_{$routeName}() {\n";
                $testCode .= "        \$user = User::factory()->create(['rol_id' => 99]);\n";
                $testCode .= "        \$this->actingAs(\$user)->get('{$uri}')->assertStatus(403);\n";
                $testCode .= "    }\n\n";
            }
        }

        $testCode .= "}\n";

        file_put_contents($testPath, $testCode);
        $this->info("✅ Pruebas generadas en: $testPath");

        return Command::SUCCESS;
    }

}
