<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Empresa;

$user = User::factory()->create(['rol_id' => 3]);
$empresa = Empresa::factory()->create(['usr_id' => $user->usr_id, 'emp_estado' => 1]);

echo "User ID: " . $user->usr_id . "\n";
echo "User Rol: " . $user->rol_id . "\n";
echo "Empresa User ID: " . $empresa->usr_id . "\n";
echo "Empresa Estado: " . $empresa->emp_estado . "\n";

$refreshUser = User::find($user->usr_id);
echo "Relation Empresa: " . ($refreshUser->empresa ? 'Found' : 'NULL') . "\n";
echo "isActivo: " . ($refreshUser->isActivo() ? 'YES' : 'NO') . "\n";

if ($refreshUser->empresa) {
    echo "Empresa Estado from Relation: " . $refreshUser->empresa->emp_estado . "\n";
}
