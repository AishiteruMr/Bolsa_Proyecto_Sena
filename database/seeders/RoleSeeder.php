<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insertOrIgnore([
            ['id' => 1, 'nombre' => 'aprendiz', 'nombre_visible' => 'Aprendiz', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'instructor', 'nombre_visible' => 'Instructor', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'empresa', 'nombre_visible' => 'Empresa', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nombre' => 'administrador', 'nombre_visible' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
