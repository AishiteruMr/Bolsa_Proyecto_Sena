<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostulacionSeeder extends Seeder
{
    public function run(): void
    {
        $aprendices = DB::table('aprendices')->pluck('id')->toArray();
        $proyectos = DB::table('proyectos')
            ->whereIn('estado', ['aprobado', 'en_progreso', 'completado', 'cerrado'])
            ->select('id', 'fecha_publicacion', 'created_at')
            ->get()
            ->toArray();

        if (empty($aprendices) || empty($proyectos)) {
            $this->command->info('No hay aprendices o proyectos disponibles para postulaciones.');
            return;
        }

        $estados = ['pendiente', 'en_revision', 'aceptada', 'rechazada'];
        $count = 0;

        foreach ($aprendices as $aprendizId) {
            $numPostulaciones = rand(1, 6);
            $proyectosAsignados = [];

            for ($i = 0; $i < $numPostulaciones; $i++) {
                $proyecto = $proyectos[array_rand($proyectos)];

                if (in_array($proyecto->id, $proyectosAsignados)) {
                    continue;
                }
                $proyectosAsignados[] = $proyecto->id;

                $estado = $estados[array_rand($estados)];

                // Postulacion date: between project publication and up to 60 days after
                $projPubDate = Carbon::parse($proyecto->fecha_publicacion);
                $maxDaysAfterPub = min(60, Carbon::now()->diffInDays($projPubDate));
                $daysAfterPub = rand(0, max(0, $maxDaysAfterPub));
                $fechaPostulacion = (clone $projPubDate)->addDays($daysAfterPub)->addHours(rand(8, 18))->addMinutes(rand(0, 59));

                try {
                    DB::table('postulaciones')->insertOrIgnore([
                        'aprendiz_id'       => $aprendizId,
                        'proyecto_id'       => $proyecto->id,
                        'estado'            => $estado,
                        'fecha_postulacion' => $fechaPostulacion,
                        'created_at'        => $fechaPostulacion,
                        'updated_at'        => $fechaPostulacion->addDays(rand(0, 20)),
                    ]);
                    $count++;
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        $this->command->info($count.' Postulaciones de ejemplo insertadas correctamente.');
    }
}
