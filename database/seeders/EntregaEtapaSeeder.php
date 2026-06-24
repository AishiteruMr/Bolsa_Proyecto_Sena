<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EntregaEtapaSeeder extends Seeder
{
    public function run(): void
    {
        $etapas = DB::table('etapas')
            ->join('proyectos', 'etapas.proyecto_id', '=', 'proyectos.id')
            ->whereIn('proyectos.estado', ['aprobado', 'en_progreso', 'completado', 'cerrado'])
            ->select('etapas.id as etapa_id', 'etapas.proyecto_id', 'etapas.orden', 'proyectos.estado as proyecto_estado', 'proyectos.created_at')
            ->get()
            ->toArray();

        if (empty($etapas)) {
            $this->command->info('No hay etapas disponibles para entregas.');
            return;
        }

        $postulacionesAceptadas = DB::table('postulaciones')
            ->where('estado', 'aceptada')
            ->select('aprendiz_id', 'proyecto_id')
            ->get()
            ->groupBy('proyecto_id')
            ->toArray();

        $estados = ['pendiente', 'aceptada', 'rechazada'];

        $descripciones = [
            'Entrega del informe completo con todos los anexos solicitados.',
            'Documento con el análisis detallado de requisitos funcionales y no funcionales.',
            'Prototipo funcional entregado según especificaciones del cliente.',
            'Código fuente completo con documentación técnica y comentarios.',
            'Manual de usuario y guía de instalación del sistema.',
            'Plan de pruebas y resultados de ejecución.',
            'Acta de reunión con cliente y firmas de aprobación.',
            'Presentación de resultados finales del proyecto.',
            'Base de datos con datos de prueba y script de inicialización.',
            'Informe de avance con métricas y cronograma actualizado.',
        ];

        $count = 0;

        foreach ($etapas as $etapa) {
            $etapaId = $etapa->etapa_id;
            $proyectoId = $etapa->proyecto_id;
            $proyectoCreatedAt = Carbon::parse($etapa->created_at);

            $proyectoAprendices = [];
            if (isset($postulacionesAceptadas[$proyectoId])) {
                foreach ($postulacionesAceptadas[$proyectoId] as $p) {
                    $proyectoAprendices[] = $p->aprendiz_id;
                }
            }

            if (empty($proyectoAprendices)) continue;

            foreach ($proyectoAprendices as $aprendizId) {
                $numEntregas = rand(1, 2);

                for ($e = 0; $e < $numEntregas; $e++) {
                    $estado = $estados[array_rand($estados)];
                    $fechaEntrega = (clone $proyectoCreatedAt)
                        ->addDays(rand(3, 90))
                        ->addHours(rand(8, 18))
                        ->addMinutes(rand(0, 59));

                    DB::table('entregas_etapa')->insertOrIgnore([
                        'aprendiz_id'  => $aprendizId,
                        'etapa_id'     => $etapaId,
                        'proyecto_id'  => $proyectoId,
                        'url_archivo'  => 'entregas/proyecto_' . $proyectoId . '/entrega_etapa_' . $etapaId . '_v' . ($e + 1) . '.pdf',
                        'descripcion'  => $descripciones[array_rand($descripciones)],
                        'estado'       => $estado,
                        'created_at'   => $fechaEntrega,
                        'updated_at'   => $fechaEntrega->addDays(rand(1, 10)),
                    ]);
                    $count++;
                }
            }
        }

        $this->command->info($count.' Entregas de etapa de ejemplo insertadas correctamente.');
    }
}
