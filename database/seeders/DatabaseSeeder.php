<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        DB::table('rol')->insertOrIgnore([
            ['rol_id' => 1, 'rol_nombre' => 'Aprendiz'],
            ['rol_id' => 2, 'rol_nombre' => 'Instructor'],
            ['rol_id' => 3, 'rol_nombre' => 'Empresa'],
            ['rol_id' => 4, 'rol_nombre' => 'Administrador'],
        ]);

        // Admin inicial
        $usuarioAdmin = DB::table('usuario')->where('usr_correo', 'admin@gmail.com')->first();
        
        if (!$usuarioAdmin) {
            $adminId = DB::table('usuario')->insertGetId([
                'usr_documento'    => 10431,
                'usr_correo'       => 'admin@gmail.com',
                'usr_contrasena'   => Hash::make('admin123'),
                'rol_id'           => 4,
                'usr_fecha_creacion' => now(),
            ]);
        } else {
            $adminId = $usuarioAdmin->usr_id;
        }

        DB::table('administrador')->insertOrIgnore([
            'usr_id'      => $adminId,
            'adm_nombre'  => 'Admin',
            'adm_apellido'=> 'SENA',
            'adm_correo'  => 'admin@gmail.com',
            'adm_estado'  => 1,
        ]);

        $this->command->info('✅ Datos iniciales insertados correctamente.');
        $this->command->info('   Credenciales admin: admin@gmail.com / admin123');
    }
}
