<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostulacionSeeder extends Seeder
{
    public function run(): void
    {
        $postulaciones = [
            ['aprendiz_email' => 'liyen_sanjuan@soy.sena.edu.co', 'proyecto_titulo' => 'Sistema de Gestión de Inventarios Inteligente', 'estado' => 'aceptada'],
            ['aprendiz_email' => 'liyen_sanjuan@soy.sena.edu.co', 'proyecto_titulo' => 'Plataforma E-commerce para Artesanos', 'estado' => 'pendiente'],
        ];

        $count = 0;
        foreach ($postulaciones as $p) {
            $aprendizId = DB::table('aprendices')
                ->join('usuarios', 'aprendices.usuario_id', '=', 'usuarios.id')
                ->where('usuarios.correo', $p['aprendiz_email'])
                ->value('aprendices.id');
            $proyectoId = DB::table('proyectos')->where('titulo', $p['proyecto_titulo'])->value('id');

            if (!$aprendizId || !$proyectoId) continue;

            DB::table('postulaciones')->insertOrIgnore([
                'aprendiz_id'      => $aprendizId,
                'proyecto_id'      => $proyectoId,
                'estado'           => $p['estado'],
                'fecha_postulacion' => now(),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
            $count++;
        }

        $this->command->info($count.' Postulaciones de ejemplo insertadas correctamente.');
    }
}
