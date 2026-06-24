<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EtapaSeeder extends Seeder
{
    public function run(): void
    {
        $proyectos = DB::table('proyectos')
            ->whereIn('estado', ['aprobado', 'en_progreso', 'completado', 'cerrado'])
            ->select('id', 'fecha_publicacion', 'duracion_estimada_dias', 'created_at')
            ->get()
            ->toArray();

        if (empty($proyectos)) {
            $this->command->info('No hay proyectos disponibles para crear etapas.');
            return;
        }

        $etapaTemplates = [
            ['Investigación Preliminar', 'Investigación de antecedentes, análisis de mercado y definición de requisitos iniciales.'],
            ['Planificación y Alcance', 'Definición de alcance, cronograma, recursos y presupuesto del proyecto.'],
            ['Diseño y Prototipado', 'Creación de diseños, wireframes, prototipos y maquetas funcionales.'],
            ['Desarrollo e Implementación', 'Implementación de la solución según las especificaciones y diseño aprobado.'],
            ['Pruebas y Control de Calidad', 'Ejecución de pruebas unitarias, de integración y control de calidad.'],
            ['Despliegue y Entrega', 'Despliegue en producción, documentación y entrega final al cliente.'],
            ['Evaluación y Cierre', 'Evaluación de resultados, retrospectiva y cierre formal del proyecto.'],
        ];

        $count = 0;

        foreach ($proyectos as $proyecto) {
            $numEtapas = rand(3, 7);
            $proyectoStartDate = Carbon::parse($proyecto->fecha_publicacion);

            for ($i = 0; $i < $numEtapas; $i++) {
                $template = $etapaTemplates[$i % count($etapaTemplates)];

                // Each etapa starts roughly spaced after the previous one
                $daysOffset = ($i + 1) * rand(5, 20);
                $etapaCreatedAt = (clone $proyectoStartDate)->addDays($daysOffset);

                DB::table('etapas')->insertOrIgnore([
                    'proyecto_id' => $proyecto->id,
                    'orden'       => $i + 1,
                    'nombre'      => $template[0],
                    'descripcion' => $template[1],
                    'created_at'  => $etapaCreatedAt,
                    'updated_at'  => (clone $etapaCreatedAt)->addDays(rand(1, 10)),
                ]);
                $count++;
            }
        }

        $this->command->info($count.' Etapas de ejemplo insertadas correctamente.');
    }
}
