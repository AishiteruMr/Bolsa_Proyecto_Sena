<?php
// Test script para verificar conexion SMTP
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Test de conexion SMTP desde la Bolsa de Proyectos SENA', function ($message) {
        $message->to('bolsadeproyectossena@gmail.com')
                ->subject('Test SMTP - ' . date('H:i:s'));
    });
    echo "✅ Correo enviado correctamente\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
