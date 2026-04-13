<?php

// Script para debuggear los datos del dashboard

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Aprendiz;
use App\Models\Empresa;
use App\Models\Instructor;
use App\Models\Proyecto;
use App\Models\User;

echo "========== DEBUG STATS ==========\n\n";

echo 'Total de Proyectos: '.Proyecto::count()."\n";
echo "Proyectos por estado:\n";
echo '  - Pendiente: '.Proyecto::where('estado', 'pendiente')->count()."\n";
echo '  - Aprobado: '.Proyecto::where('estado', 'aprobado')->count()."\n";
echo '  - Rechazado: '.Proyecto::where('estado', 'rechazado')->count()."\n";
echo '  - En Progreso: '.Proyecto::where('estado', 'en_progreso')->count()."\n";
echo '  - Cerrado: '.Proyecto::where('estado', 'cerrado')->count()."\n\n";

echo 'Total de Usuarios: '.User::count()."\n";
echo "Usuarios por tipo:\n";
echo '  - Aprendices: '.Aprendiz::count()."\n";
echo '  - Instructores: '.Instructor::count()."\n";
echo '  - Empresas: '.Empresa::count()."\n";
echo '  - Admins: '.User::where('rol_id', 4)->count()."\n\n";

echo "Top 5 Empresas por proyectos:\n";
$empresas = Empresa::withCount('proyectos')
    ->having('proyectos_count', '>', 0)
    ->orderByDesc('proyectos_count')
    ->limit(5)
    ->get();

if ($empresas->isEmpty()) {
    echo "  - No hay empresas con proyectos\n";
} else {
    foreach ($empresas as $emp) {
        echo "  - {$emp->nombre}: {$emp->proyectos_count} proyectos\n";
    }
}

echo "\n========== FIN DEBUG ==========\n";
