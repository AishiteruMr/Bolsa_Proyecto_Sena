<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$updated = DB::table('proyectos')->whereNull('calidad_aprobada')->update(['calidad_aprobada' => 0]);
echo "Updated $updated rows\n";