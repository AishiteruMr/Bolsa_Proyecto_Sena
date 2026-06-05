<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $adminRoleId      = DB::table('roles')->where('nombre', 'administrador')->value('id');
        $companyRoleId    = DB::table('roles')->where('nombre', 'empresa')->value('id');
        $instructorRoleId = DB::table('roles')->where('nombre', 'instructor')->value('id');
        $apprenticeRoleId = DB::table('roles')->where('nombre', 'aprendiz')->value('id');

        $credentials = [];

        $admins = [
            ['doc' => 1043277456, 'email' => 'geniszully@gmail.com', 'pass' => 'Admin123@', 'name' => 'Admin', 'last' => 'SENA'],
        ];
        foreach ($admins as $a) {
            $uid = $this->ensureUser($a['doc'], $a['email'], $a['pass'], $adminRoleId);
            $this->ensureProfile('administradores', ['usuario_id' => $uid, 'nombres' => $a['name'], 'apellidos' => $a['last'], 'activo' => true]);
            $credentials[] = "   -> {$a['email']} / {$a['pass']}";
        }

        $companies = [
            ['doc' => 12345475784, 'email' => 'camilopineda182@gmail.com', 'pass' => 'Camilo123@', 'name' => 'Cristian Padilla', 'rep' => 'Cristian Padilla', 'contact' => 'camilopineda182@gmail.com', 'loc' => 'Bogotá D.C., Colombia', 'lat' => 4.711, 'lng' => -74.0721],
        ];
        foreach ($companies as $c) {
            $uid = $this->ensureUser($c['doc'], $c['email'], $c['pass'], $companyRoleId);
            $this->ensureProfile('empresas', [
                'nit' => $c['doc'], 'usuario_id' => $uid, 'nombre' => $c['name'],
                'representante' => $c['rep'], 'correo_contacto' => $c['contact'],
                'ubicacion' => $c['loc'], 'latitud' => $c['lat'], 'longitud' => $c['lng'], 'activo' => true,
            ], 'nit');
            $credentials[] = "   -> {$c['email']} / {$c['pass']}";
        }

        $instructors = [
            ['doc' => 20123, 'email' => 'sherelynrocha939@gmail.com', 'pass' => 'Sherelyn123@', 'name' => 'Sherelyn', 'last' => 'Rocha', 'spec' => 'Desarrollo de Software'],
        ];
        foreach ($instructors as $i) {
            $uid = $this->ensureUser($i['doc'], $i['email'], $i['pass'], $instructorRoleId);
            $this->ensureProfile('instructores', [
                'usuario_id' => $uid, 'nombres' => $i['name'], 'apellidos' => $i['last'],
                'especialidad' => $i['spec'], 'activo' => true, 'disponibilidad' => 'disponible',
            ]);
            $credentials[] = "   -> {$i['email']} / {$i['pass']}";
        }

        $apprentices = [
<<<<<<< HEAD
            ['doc' => 1016555423, 'email' => 'liyen_sanjuan@soy.sena.edu.co', 'pass' => 'Liyen123@', 'name' => 'Liyen', 'last' => 'San Juan', 'prog' => 'Análisis y desarrollo de software (ADSO)'],
            ['doc' => 1016555424, 'email' => 'juan_perez@soy.sena.edu.co', 'pass' => 'Juan123@', 'name' => 'Juan', 'last' => 'Pérez', 'prog' => 'Análisis y desarrollo de software (ADSO)'],
            ['doc' => 1016555425, 'email' => 'maria_garcia@soy.sena.edu.co', 'pass' => 'Maria123@', 'name' => 'María', 'last' => 'García', 'prog' => 'Desarrollo web'],
            ['doc' => 1016555426, 'email' => 'carlos_lopez@soy.sena.edu.co', 'pass' => 'Carlos123@', 'name' => 'Carlos', 'last' => 'López', 'prog' => 'Bases de datos'],
            ['doc' => 1016555427, 'email' => 'ana_martinez@soy.sena.edu.co', 'pass' => 'Ana123@', 'name' => 'Ana', 'last' => 'Martínez', 'prog' => 'Programación de software'],
            ['doc' => 1016555428, 'email' => 'pedro_ramirez@soy.sena.edu.co', 'pass' => 'Pedro123@', 'name' => 'Pedro', 'last' => 'Ramírez', 'prog' => 'Instalaciones eléctricas industriales'],
            ['doc' => 1016555429, 'email' => 'laura_torres@soy.sena.edu.co', 'pass' => 'Laura123@', 'name' => 'Laura', 'last' => 'Torres', 'prog' => 'Análisis y desarrollo de software (ADSO)'],
            ['doc' => 1016555430, 'email' => 'diego_sanchez@soy.sena.edu.co', 'pass' => 'Diego123@', 'name' => 'Diego', 'last' => 'Sánchez', 'prog' => 'Configuración de redes de datos'],
            ['doc' => 1016555431, 'email' => 'valentina_ortiz@soy.sena.edu.co', 'pass' => 'Vale123@', 'name' => 'Valentina', 'last' => 'Ortiz', 'prog' => 'Electricidad residencial, comercial y de sistemas fotovoltaicos'],
            ['doc' => 1016555432, 'email' => 'santiago_morales@soy.sena.edu.co', 'pass' => 'Santiago123@', 'name' => 'Santiago', 'last' => 'Morales', 'prog' => 'Análisis y desarrollo de software (ADSO)'],
=======
            ['doc' => 1016555423, 'email' => 'liyen_sanjuan@soy.sena.edu.co', 'pass' => 'Liyen123@', 'name' => 'Liyen', 'last' => 'San Juan', 'prog' => 'Análisis y Desarrollo de Software'],
>>>>>>> b9a8d24711bfe5df046b2e0111a713b6193dc5ed
        ];
        foreach ($apprentices as $ap) {
            $uid = $this->ensureUser($ap['doc'], $ap['email'], $ap['pass'], $apprenticeRoleId);
            $this->ensureProfile('aprendices', [
                'usuario_id' => $uid, 'nombres' => $ap['name'], 'apellidos' => $ap['last'],
                'programa_formacion' => $ap['prog'], 'activo' => true,
            ]);
            $credentials[] = "   -> {$ap['email']} / {$ap['pass']}";
        }

        $this->call(ProjectSeeder::class);
        $this->call(PostulacionSeeder::class);
        $this->call(EtapaSeeder::class);

        $this->command->info('Datos de ejemplo insertados correctamente.');
        foreach ($credentials as $line) {
            $this->command->info($line);
        }
    }

    private function ensureUser($numDoc, $correo, $pass, $rolId): int
    {
        $id = DB::table('usuarios')->where('correo', $correo)->value('id');
        if (!$id) {
            $id = DB::table('usuarios')->insertGetId([
                'numero_documento'  => $numDoc,
                'correo'            => $correo,
                'contrasena'        => Hash::make($pass),
                'rol_id'            => $rolId,
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
        return $id;
    }

    private function ensureProfile(string $table, array $data, string $lookupKey = 'usuario_id'): void
    {
        $value = $data[$lookupKey] ?? null;
        $exists = $value ? DB::table($table)->where($lookupKey, $value)->exists() : false;
        if (!$exists) {
            DB::table($table)->insert(array_merge($data, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
