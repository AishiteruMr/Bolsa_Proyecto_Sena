<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * RoleSeeder
 * Inserta los roles base del sistema.
 */
class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre' => 'aprendiz',      'nombre_visible' => 'Aprendiz'],
            ['nombre' => 'instructor',    'nombre_visible' => 'Instructor'],
            ['nombre' => 'empresa',       'nombre_visible' => 'Empresa'],
            ['nombre' => 'administrador', 'nombre_visible' => 'Administrador'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['nombre' => $role['nombre']],
                array_merge($role, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
