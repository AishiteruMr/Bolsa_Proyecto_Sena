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
        $adminUserId = DB::table('usuarios')->where('correo', 'admin@gmail.com')->value('id');
        if (!$adminUserId) {
            $adminUserId = DB::table('usuarios')->insertGetId([
                'numero_documento' => 1043178690,
                'correo'           => 'admin@gmail.com',
                'contrasena'       => Hash::make('admin123'),
                'rol_id'           => $adminRoleId,
                'email_verified_at' => now(),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
        DB::table('administradores')->updateOrInsert(
            ['usuario_id' => $adminUserId],
            ['nombres' => 'Admin', 'apellidos' => 'SENA', 'activo' => true, 'created_at' => now(), 'updated_at' => now()]
        );

        // 3. Empresa
        $companyUserId = DB::table('usuarios')->where('correo', 'empresa@gmail.com')->value('id');
        if (!$companyUserId) {
            $companyUserId = DB::table('usuarios')->insertGetId([
                'numero_documento' => 12345475784,
                'correo'           => 'empresa@gmail.com',
                'contrasena'       => Hash::make('empresa123'),
                'rol_id'           => $companyRoleId,
                'email_verified_at' => now(),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
        DB::table('empresas')->updateOrInsert(
            ['nit' => 12345475784],
            [
                'usuario_id'      => $companyUserId,
                'nombre'          => 'Empresa Demo',
                'representante'   => 'Representante Legal',
                'correo_contacto' => 'empresa@gmail.com',
                'activo'          => true,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]
        );

        // 4. Instructor
        $instructorUserId = DB::table('usuarios')->where('correo', 'instructor@gmail.com')->value('id');
        if (!$instructorUserId) {
            $instructorUserId = DB::table('usuarios')->insertGetId([
                'numero_documento' => 20123,
                'correo'           => 'instructor@gmail.com',
                'contrasena'       => Hash::make('instructor123'),
                'rol_id'           => $instructorRoleId,
                'email_verified_at' => now(),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
        DB::table('instructores')->updateOrInsert(
            ['usuario_id' => $instructorUserId],
            [
                'nombres'        => 'Instructor',
                'apellidos'      => 'Demo',
                'especialidad'   => 'Desarrollo de Software',
                'activo'         => true,
                'disponibilidad' => 'disponible',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]
        );

        // 5. Aprendiz
        $apprenticeUserId = DB::table('usuarios')->where('correo', 'aprendiz@gmail.com')->value('id');
        if (!$apprenticeUserId) {
            $apprenticeUserId = DB::table('usuarios')->insertGetId([
                'numero_documento' => 1016555423,
                'correo'           => 'aprendiz@gmail.com',
                'contrasena'       => Hash::make('aprendiz123'),
                'rol_id'           => $apprenticeRoleId,
                'email_verified_at' => now(),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
        DB::table('aprendices')->updateOrInsert(
            ['usuario_id' => $apprenticeUserId],
            [
                'nombres'            => 'Aprendiz',
                'apellidos'          => 'Demo',
                'programa_formacion' => 'Análisis y Desarrollo de Software',
                'activo'             => true,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]
        );

        // 6. Proyectos de ejemplo
        $this->call(ProjectSeeder::class);

        $this->command->info('✅ Datos iniciales insertados correctamente.');
        $this->command->info('   → admin@gmail.com        / admin123');
        $this->command->info('   → empresa@gmail.com      / empresa123');
        $this->command->info('   → instructor@gmail.com   / instructor123');
        $this->command->info('   → aprendiz@gmail.com     / aprendiz123');
    }
}
