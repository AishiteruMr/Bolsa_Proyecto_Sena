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
            ['aprendiz_email' => 'juan_perez@soy.sena.edu.co', 'proyecto_titulo' => 'Sistema de Gestión de Inventarios Inteligente', 'estado' => 'aceptada'],
            ['aprendiz_email' => 'carlos_lopez@soy.sena.edu.co', 'proyecto_titulo' => 'App Móvil para Control de Asistencia', 'estado' => 'en_revision'],
            ['aprendiz_email' => 'laura_torres@soy.sena.edu.co', 'proyecto_titulo' => 'App Móvil para Control de Asistencia', 'estado' => 'pendiente'],
            ['aprendiz_email' => 'maria_garcia@soy.sena.edu.co', 'proyecto_titulo' => 'Rediseño de Identidad Visual Corporativa', 'estado' => 'aceptada'],
            ['aprendiz_email' => 'valentina_ortiz@soy.sena.edu.co', 'proyecto_titulo' => 'Rediseño de Identidad Visual Corporativa', 'estado' => 'aceptada'],
            ['aprendiz_email' => 'liyen_sanjuan@soy.sena.edu.co', 'proyecto_titulo' => 'Plataforma E-commerce para Artesanos', 'estado' => 'pendiente'],
            ['aprendiz_email' => 'santiago_morales@soy.sena.edu.co', 'proyecto_titulo' => 'Plataforma E-commerce para Artesanos', 'estado' => 'pendiente'],
            ['aprendiz_email' => 'diego_sanchez@soy.sena.edu.co', 'proyecto_titulo' => 'Campaña de Marketing Digital SENA 2026', 'estado' => 'en_revision'],
            ['aprendiz_email' => 'ana_martinez@soy.sena.edu.co', 'proyecto_titulo' => 'Campaña de Marketing Digital SENA 2026', 'estado' => 'pendiente'],
            ['aprendiz_email' => 'pedro_ramirez@soy.sena.edu.co', 'proyecto_titulo' => 'Modelado 3D para Planta Industrial', 'estado' => 'pendiente'],
            ['aprendiz_email' => 'laura_torres@soy.sena.edu.co', 'proyecto_titulo' => 'Automatización de Procesos con Python', 'estado' => 'aceptada'],
            ['aprendiz_email' => 'carlos_lopez@soy.sena.edu.co', 'proyecto_titulo' => 'Desarrollo de API Gateway para Pagos', 'estado' => 'pendiente'],
            ['aprendiz_email' => 'juan_perez@soy.sena.edu.co', 'proyecto_titulo' => 'Sistema de Análisis Predictivo con Machine Learning', 'estado' => 'pendiente'],
            ['aprendiz_email' => 'santiago_morales@soy.sena.edu.co', 'proyecto_titulo' => 'Migración a Infraestructura Cloud', 'estado' => 'pendiente'],
            ['aprendiz_email' => 'valentina_ortiz@soy.sena.edu.co', 'proyecto_titulo' => 'Diseño UI/UX para App de Fitness', 'estado' => 'pendiente'],
            ['aprendiz_email' => 'maria_garcia@soy.sena.edu.co', 'proyecto_titulo' => 'Rebranding Corporativo para Fintech', 'estado' => 'pendiente'],
            ['aprendiz_email' => 'pedro_ramirez@soy.sena.edu.co', 'proyecto_titulo' => 'Automatización PLC para Línea de Producción', 'estado' => 'pendiente'],
            ['aprendiz_email' => 'ana_martinez@soy.sena.edu.co', 'proyecto_titulo' => 'Documental Institucional "Talento de Oro"', 'estado' => 'aceptada'],
            ['aprendiz_email' => 'diego_sanchez@soy.sena.edu.co', 'proyecto_titulo' => 'SEO y Posicionamiento Web', 'estado' => 'rechazada'],
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
