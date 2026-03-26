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
                'usr_documento'    => 1043178690,
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

        // =============================
        // EMPRESA
        // =============================
        $usuarioEmpresa = DB::table('usuario')->where('usr_correo', 'empresa@gmail.com')->first();
        if (!$usuarioEmpresa) {
            $empresaId = DB::table('usuario')->insertGetId([
                'usr_documento'      => 12345475784,
                'usr_correo'         => 'empresa@gmail.com',
                'usr_contrasena'     => Hash::make('empresa123'),
                'rol_id'             => 3,
                'usr_fecha_creacion' => now(),
            ]);
        } else {
            $empresaId = $usuarioEmpresa->usr_id;
        }

        DB::table('empresa')->insertOrIgnore([
            'usr_id'            => $empresaId,
            'emp_nit'           => 12345475784,
            'emp_nombre'        => 'Empresa',
            'emp_representante' => 'Representante',
            'emp_correo'        => 'empresa@gmail.com',
            'emp_contrasena'    => Hash::make('empresa123'),
            'emp_estado'        => 1,
        ]);

        // =============================
        // INSTRUCTOR
        // =============================
        $instructor = DB::table('usuario')->where('usr_correo', 'instructor@gmail.com')->first();
        if (!$instructor) {
            $instructorId = DB::table('usuario')->insertGetId([
                'usr_documento'      => 20123,
                'usr_correo'         => 'instructor@gmail.com',
                'usr_contrasena'     => Hash::make('instructor123'),
                'rol_id'             => 2,
                'usr_fecha_creacion' => now(),
            ]);

            DB::table('instructor')->insertOrIgnore([
                'usr_id'        => $instructorId,
                'ins_nombre'    => 'Instructor',
                'ins_apellido'  => 'INS',
                'ins_especialidad' => 'Programador',
                'ins_estado'    => 1,
                'ins_estado_dis' => 'Disponible',
            ]);
        }

        // =============================
        // APRENDIZ 
        // =============================
        $aprendiz = DB::table('usuario')->where('usr_correo', 'aprendiz@gmail.com')->first();
        if (!$aprendiz) {
            $aprendizId = DB::table('usuario')->insertGetId([
                'usr_documento'      => 1016555423,
                'usr_correo'         => 'aprendiz@gmail.com',
                'usr_contrasena'     => Hash::make('aprendiz123'),
                'rol_id'             => 1,
                'usr_fecha_creacion' => now(),
            ]);

            DB::table('aprendiz')->insertOrIgnore([
                'apr_id'        => $aprendizId,
                'usr_id'        => $aprendizId,
                'apr_nombre'    => 'Aprendiz',
                'apr_apellido'  => 'APP',
                'apr_programa'   => 'Analasis',
                'apr_estado'    => 1,
            ]);
        }

        $this->call(ProyectoSeeder::class);

        $this->command->info('    Datos iniciales insertados correctamente.');
        $this->command->info('   Credenciales admin: admin@gmail.com / admin123');
        $this->command->info('   Credenciales empresa: empresa@gmail.com / empresa123');
        $this->command->info('   Credenciales instructor: instructor@gmail.com / instructor123');
        $this->command->info('   Credenciales aprendiz: aprendiz@gmail.com / aprendiz123');
    }
}
