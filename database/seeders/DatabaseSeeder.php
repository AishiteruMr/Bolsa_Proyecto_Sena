<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles base del sistema
        $this->call(RoleSeeder::class);

        $adminRoleId      = DB::table('roles')->where('nombre', 'administrador')->value('id');
        $companyRoleId    = DB::table('roles')->where('nombre', 'empresa')->value('id');
        $instructorRoleId = DB::table('roles')->where('nombre', 'instructor')->value('id');
        $apprenticeRoleId = DB::table('roles')->where('nombre', 'aprendiz')->value('id');

// 2. Administrador
        $adminUserId = DB::table('usuarios')->where('correo', 'geniszully@gmail.com')->value('id');
        if (!$adminUserId) {
            $adminUserId = DB::table('usuarios')->insertGetId([
                'numero_documento' => 1043277456,
                'correo'           => 'geniszully@gmail.com',
                'contrasena'       => Hash::make('Admin123@'),
                'rol_id'           => $adminRoleId,
                'email_verified_at' => now(),
                'created_at'       => now(),
                'updated_at'      => now(),
            ]);
        }
        $admin = DB::table('administradores')->where('usuario_id', $adminUserId)->first();
        if (!$admin) {
            DB::table('administradores')->insert([
                'usuario_id' => $adminUserId,
                'nombres' => 'Admin',
                'apellidos' => 'SENA',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

// 3. Empresa
        $companyUserId = DB::table('usuarios')->where('correo', 'camilopineda182@gmail.com')->value('id');
        if (!$companyUserId) {
            $companyUserId = DB::table('usuarios')->insertGetId([
                'numero_documento' => 12345475784,
                'correo'           => 'camilopineda182@gmail.com',
                'contrasena'       => Hash::make('Camilo123@'),
                'rol_id'           => $companyRoleId,
                'email_verified_at' => now(),
                'created_at'       => now(),
                'updated_at'      => now(),
            ]);
        }
        $empresa = DB::table('empresas')->where('nit', 12345475784)->first();
        if (!$empresa) {
            DB::table('empresas')->insert([
                'nit'            => 12345475784,
                'usuario_id'      => $companyUserId,
                'nombre'          => 'Cristian Padilla',
                'representante'   => 'Representante Legal',
                'correo_contacto' => 'camilopineda182@gmail.com',
                'activo'          => true,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

// 4. Instructor
        $instructorUserId = DB::table('usuarios')->where('correo', 'sherelynrocha939@gmail.com')->value('id');
        if (!$instructorUserId) {
            $instructorUserId = DB::table('usuarios')->insertGetId([
                'numero_documento' => 20123,
                'correo'           => 'sherelynrocha939@gmail.com',
                'contrasena'       => Hash::make('Sherelyn123@'),
                'rol_id'           => $instructorRoleId,
                'email_verified_at' => now(),
                'created_at'       => now(),
                'updated_at'      => now(),
            ]);
        }
        $instructor = DB::table('instructores')->where('usuario_id', $instructorUserId)->first();
        if (!$instructor) {
            DB::table('instructores')->insert([
                'usuario_id'    => $instructorUserId,
                'nombres'        => 'Sherelyn',
                'apellidos'      => 'Rocha',
                'especialidad'   => 'Desarrollo de Software',
                'activo'         => true,
                'disponibilidad' => 'disponible',
                'created_at'     => now(),
                'updated_at'      => now(),
            ]);
        }

// 5. Aprendiz
        $apprenticeUserId = DB::table('usuarios')->where('correo', 'liyen_sanjuan@soy.sena.edu.co')->value('id');
        if (!$apprenticeUserId) {
            $apprenticeUserId = DB::table('usuarios')->insertGetId([
                'numero_documento' => 1016555423,
                'correo'           => 'liyen_sanjuan@soy.sena.edu.co',
                'contrasena'       => Hash::make('Liyen123@'),
                'rol_id'           => $apprenticeRoleId,
                'email_verified_at' => now(),
                'created_at'       => now(),
                'updated_at'      => now(),
            ]);
        }
        $aprendiz = DB::table('aprendices')->where('usuario_id', $apprenticeUserId)->first();
        if (!$aprendiz) {
            DB::table('aprendices')->insert([
                'usuario_id'        => $apprenticeUserId,
                'nombres'            => 'Liyen',
                'apellidos'          => 'San Juan',
                'programa_formacion' => 'Análisis y Desarrollo de Software',
                'activo'             => true,
                'created_at'         => now(),
                'updated_at'          => now(),
            ]);
        }

        // 6. Proyectos de ejemplo
        $this->call(ProjectSeeder::class);

        $this->command->info('✅ Datos iniciales insertados correctamente.');
        $this->command->info('   → geniszully@gmail.com        / Admin123@');
        $this->command->info('   → camilopineda182@gmail.com      / Camilo123@');
        $this->command->info('   → sherelynrocha939@gmail.com   / Sherelyn123@');
        $this->command->info('   → liyen_sanjuan@soy.sena.edu.co     / Liyen123@');
    }
}
