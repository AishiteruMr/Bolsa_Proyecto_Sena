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
            ['doc' => 1016555423, 'email' => 'liyen_sanjuan@soy.sena.edu.co', 'pass' => 'Liyen123@', 'name' => 'Liyen', 'last' => 'San Juan', 'prog' => 'Análisis y Desarrollo de Software'],
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
