<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EvidenciaSeeder extends Seeder
{
    public function run(): void
    {
        $aprendices = DB::table('aprendices')->pluck('id')->toArray();
        $etapas = DB::table('etapas')
            ->join('proyectos', 'etapas.proyecto_id', '=', 'proyectos.id')
            ->whereIn('proyectos.estado', ['aprobado', 'en_progreso', 'completado', 'cerrado'])
            ->select('etapas.id as etapa_id', 'etapas.proyecto_id', 'proyectos.estado as proyecto_estado', 'proyectos.created_at')
            ->get()
            ->toArray();

        if (empty($aprendices) || empty($etapas)) {
            $this->command->info('No hay aprendices o etapas disponibles para evidencias.');
            return;
        }

        $estados = ['pendiente', 'aceptada', 'rechazada'];
        $archivos = [
            'documentos/informe_analisis.pdf',
            'documentos/requisitos_funcionales.docx',
            'documentos/diseno_base_datos.pdf',
            'documentos/manual_usuario.pdf',
            'documentos/plan_pruebas.xlsx',
            'documentos/entregable_tecnico.pdf',
            'documentos/presentacion_resultados.pptx',
            'documentos/codigo_fuente.zip',
            'documentos/capturas_pantalla.zip',
            'documentos/informe_avance.docx',
            'documentos/acta_reunion.pdf',
            'documentos/cronograma_actualizado.xlsx',
            'documentos/guia_instalacion.pdf',
            'documentos/certificado_calidad.pdf',
        ];

        $comentariosAceptados = [
            'Excelente trabajo, cumple con todos los requisitos.',
            'Bien desarrollado, se aprueba la evidencia.',
            'Cumple con los estándares establecidos. Aprobado.',
            'Muy buen análisis y presentación. Continúe así.',
            'Evidencia completa y bien documentada. Aprobada.',
            'Trabajo de calidad. Se da por recibido.',
        ];

        $comentariosRechazados = [
            'Faltan secciones importantes del análisis.',
            'La documentación no está completa. Debe complementar.',
            'No cumple con el formato establecido. Rehacer.',
            'Los anexos no corresponden a lo solicitado.',
            'El informe presenta inconsistencias en los datos.',
            'Falta profundidad en el análisis realizado.',
        ];

        $count = 0;

        // Create a dictionary mapping proyecto_id => list of (aprendiz_id) from postulaciones aceptadas
        $postulacionesAceptadas = DB::table('postulaciones')
            ->where('estado', 'aceptada')
            ->select('aprendiz_id', 'proyecto_id')
            ->get()
            ->groupBy('proyecto_id')
            ->toArray();

        foreach ($etapas as $etapa) {
            $etapaId = $etapa->etapa_id;
            $proyectoId = $etapa->proyecto_id;
            $proyectoCreatedAt = Carbon::parse($etapa->created_at);

            // Get apprentices for this project
            $proyectoAprendices = [];
            if (isset($postulacionesAceptadas[$proyectoId])) {
                foreach ($postulacionesAceptadas[$proyectoId] as $p) {
                    $proyectoAprendices[] = $p->aprendiz_id;
                }
            }

            if (empty($proyectoAprendices)) {
                continue;
            }

            // Each apprentice submits 0-3 evidencias per etapa
            foreach ($proyectoAprendices as $aprendizId) {
                $numEvidencias = rand(0, 3);
                if ($numEvidencias === 0) continue;

                for ($e = 0; $e < $numEvidencias; $e++) {
                    $estado = $estados[array_rand($estados)];
                    $fechaEnvio = (clone $proyectoCreatedAt)->addDays(rand(5, 120))->addHours(rand(8, 18))->addMinutes(rand(0, 59));

                    $comentario = null;
                    if ($estado === 'aceptada') {
                        $comentario = $comentariosAceptados[array_rand($comentariosAceptados)];
                    } elseif ($estado === 'rechazada') {
                        $comentario = $comentariosRechazados[array_rand($comentariosRechazados)];
                    }

                    DB::table('evidencias')->insertOrIgnore([
                        'aprendiz_id'         => $aprendizId,
                        'etapa_id'            => $etapaId,
                        'proyecto_id'         => $proyectoId,
                        'ruta_archivo'        => $archivos[array_rand($archivos)],
                        'estado'              => $estado,
                        'comentario_instructor' => $comentario,
                        'fecha_envio'         => $fechaEnvio,
                        'created_at'          => $fechaEnvio,
                        'updated_at'          => $fechaEnvio->addDays(rand(1, 15)),
                    ]);
                    $count++;
                }
            }
        }

        $this->command->info($count.' Evidencias de ejemplo insertadas correctamente.');
    }
}
