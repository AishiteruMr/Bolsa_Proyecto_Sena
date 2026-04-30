<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use App\Models\User;
use App\Models\AuditReport;
use App\Models\AuditEntry;
use App\Mail\AuditReportMailable;

class AuditProbeCommand extends Command
{
    protected $signature = 'guard:probe 
        {--only-failed : Mostrar solo fallos}
        {--format=table : Formato de salida (table, json)}
        {--send-email= : Enviar reporte por email a esta dirección}';

    protected $description = 'Prueba rutas del sistema y genera reportes de vulnerabilidades';

    public function handle(): int
    {
        $routes = Route::getRoutes();
        $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
        
        $scenarios = [
            ['name' => 'Invitado', 'role' => null, 'state' => 'normal'],
            ['name' => 'Aprendiz Activo', 'role' => 1, 'state' => 'active'],
            ['name' => 'Aprendiz Inactivo', 'role' => 1, 'state' => 'inactive'],
            ['name' => 'Aprendiz No Verificado', 'role' => 1, 'state' => 'unverified'],
            ['name' => 'Instructor Sin Perfil', 'role' => 2, 'state' => 'no_profile'],
        ];

        $fullReport = [];

        foreach ($scenarios as $scenario) {
            $this->info("\n🚀 Probando escenario: " . $scenario['name']);
            
            DB::beginTransaction();
            try {
                $user = $this->createScenarioUser($scenario);
                Auth::logout();

                $scenarioResults = [];
                foreach ($routes as $route) {
                    $method = current($route->methods());
                    if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE']) || str_contains($route->uri(), '{')) continue;

                    $path = '/' . ltrim($route->uri(), '/');
                    $request = \Illuminate\Http\Request::create($path, $method);
                    $request->headers->set('X-Audit-Probe', 'true');
                    if ($user) $request->setUserResolver(fn() => $user);

                    $response = $kernel->handle($request);
                    $status = $response->getStatusCode();
                    
                    $isFailed = ($status === 500); // Simplificación: error 500 es fallo crítico
                    $remediation = $isFailed ? "Revisar lógica de negocio/relaciones" : "Ninguna";

                    $scenarioResults[] = [
                        'uri' => $route->uri(),
                        'expected' => 200,
                        'status' => $status,
                        'result' => $isFailed ? '❌ FALLO' : '✅ Correcto',
                        'remediation' => $remediation
                    ];
                    $kernel->terminate($request, $response);
                }
                $fullReport[$scenario['name']] = $scenarioResults;
            } finally {
                DB::rollBack();
            }
        }
        
        // Persistencia
        $total = 0; $failed = 0;
        foreach ($fullReport as $results) {
            $total += count($results);
            foreach ($results as $res) if($res['result'] === '❌ FALLO') $failed++;
        }
        $report = AuditReport::create(['total_scanned' => $total, 'vulnerabilities_found' => $failed]);
        foreach ($fullReport as $results) {
            foreach ($results as $res) {
                AuditEntry::create([
                    'report_id' => $report->id,
                    'uri' => $res['uri'],
                    'expected' => $res['expected'],
                    'status' => $res['status'],
                    'result' => $res['result'],
                    'remediation' => $res['remediation']
                ]);
            }
        }

        // Envío de correo
        $email = $this->option('send-email');
        if ($email) {
            $csvContent = "URI,Expected,Status,Result,Remediation\n";
            $entries = \App\Models\AuditEntry::where('report_id', $report->id)->get();
            foreach ($entries as $entry) {
                $csvContent .= "{$entry->uri},{$entry->expected},{$entry->status},{$entry->result},{$entry->remediation}\n";
            }
            Mail::to($email)->send(new AuditReportMailable($fullReport, $csvContent));
            $this->info("\n📧 Reporte enviado a: $email");
        }

        $this->info("\n💾 Reporte guardado.");
        
        return Command::SUCCESS;
    }

    private function createScenarioUser($scenario) {
        if (!$scenario['role']) return null;
        $user = User::where('rol_id', $scenario['role'])->first();
        if (!$user) return null;
        
        $user->email_verified_at = now();
        
        switch ($scenario['state']) {
            case 'unverified': $user->email_verified_at = null; break;
            case 'inactive': $this->setProfileActiveState($user, 0); break;
            case 'no_profile': $this->dropProfileRelation($user); break;
            case 'active': $this->setProfileActiveState($user, 1); break;
        }
        return $user;
    }

    private function setProfileActiveState($user, $state) {
        $relation = $this->getProfileRelation($user);
        if ($relation) $user->{$relation}()->update(['activo' => $state]);
    }

    private function dropProfileRelation($user) {
        $relation = $this->getProfileRelation($user);
        if ($relation) $user->{$relation}()->delete();
    }

    private function getProfileRelation($user) {
        return match ($user->rol_id) {
            1 => 'aprendiz',
            2 => 'instructor',
            3 => 'empresa',
            default => null,
        };
    }
}
