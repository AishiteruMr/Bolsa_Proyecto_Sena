<?php

namespace App\Services;

use App\Models\Proyecto;
use App\Models\Postulacion;
use App\Models\Etapa;
use App\Models\Evidencia;
use App\Models\Instructor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PostulacionEstadoCambiado;
use App\Notifications\PostulacionActualizada;
use App\Notifications\EvidenciaCalificada;
use App\Models\Aprendiz;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class InstructorService
{
    /**
     * Get dashboard statistics for an instructor.
     */
    public function getDashboardStats(string $documento, int $usrId): array
    {
        return [
            'proyectosAsignados' => Proyecto::where('ins_usr_documento', $documento)
                ->where('pro_estado', 'Activo')
                ->count(),
            'totalAprendices' => Postulacion::whereIn('pro_id', 
                Proyecto::where('ins_usr_documento', $documento)
                    ->where('pro_estado', 'Activo')
                    ->pluck('pro_id')
            )->where('pos_estado', 'Aprobada')
                ->distinct('apr_id')
                ->count(),
            'evidenciasPendientes' => Evidencia::whereIn('evid_pro_id',
                Proyecto::where('ins_usr_documento', $documento)
                    ->pluck('pro_id')
            )->where('evid_estado', 'Pendiente')
                ->count(),
            'nuevasPostulaciones' => Postulacion::whereIn('pro_id',
                Proyecto::where('ins_usr_documento', $documento)->pluck('pro_id')
            )->where('pos_fecha', '>=', now()->subHours(48))->count(),
            'proximoCierre' => Proyecto::where('ins_usr_documento', $documento)
                ->where('pro_estado', 'Activo')
                ->where('pro_fecha_finalizacion', '>=', now())
                ->orderBy('pro_fecha_finalizacion')
                ->first(),
        ];
    }

    /**
     * Get active projects for an instructor.
     */
    public function getProyectos(string $documento)
    {
        return Proyecto::where('ins_usr_documento', $documento)
            ->where('pro_estado', 'Activo')
            ->with(['empresa', 'postulaciones'])
            ->orderByDesc('pro_id')
            ->get();
    }

    /**
     * Update postulation status and notify learner.
     */
    public function updatePostulacionStatus(int $posId, string $estado, string $instructorDoc): bool
    {
        // Permission check
        Postulacion::where('pos_id', $posId)
            ->whereHas('proyecto', function($query) use ($instructorDoc) {
                $query->where('ins_usr_documento', $instructorDoc);
            })->firstOrFail();

        return (new PostulacionService())->updateStatus($posId, $estado);
    }

    /**
     * Grade an evidence.
     */
    public function gradeEvidence(int $evidId, string $estado, ?string $comentario, string $instructorDoc): bool
    {
        $evidencia = Evidencia::where('evid_id', $evidId)
            ->whereHas('proyecto', function($query) use ($instructorDoc) {
                $query->where('ins_usr_documento', $instructorDoc);
            })->firstOrFail();

        $evidencia->update([
            'evid_estado'     => $estado,
            'evid_comentario' => $comentario,
        ]);

        if ($estado !== 'Pendiente') {
            $aprendiz = $evidencia->aprendiz()->with('usuario')->first();
            if ($aprendiz?->usuario) {
                $aprendiz->usuario->notify(new EvidenciaCalificada(
                    $evidencia->proyecto->pro_titulo_proyecto,
                    $evidencia->etapa->eta_nombre,
                    $estado
                ));
            }
        }

        return true;
    }

    /**
     * Get project history for an instructor.
     */
    public function getHistorial(string $documento)
    {
        return Proyecto::where('ins_usr_documento', $documento)
            ->with(['empresa', 'postulaciones'])
            ->orderByDesc('pro_fecha_publi')
            ->get()
            ->map(function ($proyecto) {
                $totalAprendices = $proyecto->postulaciones->count();
                $aprendicesAprobados = $proyecto->postulaciones->where('pos_estado', 'Aprobada')->count();
                
                return (object) [
                    'pro_id' => $proyecto->pro_id,
                    'pro_titulo_proyecto' => $proyecto->pro_titulo_proyecto,
                    'pro_descr_proyecto' => $proyecto->pro_descr_proyecto,
                    'pro_categoria' => $proyecto->pro_categoria,
                    'pro_estado' => $proyecto->pro_estado,
                    'pro_fecha_publi' => $proyecto->pro_fecha_publi,
                    'pro_fecha_finalizacion' => $proyecto->pro_fecha_finalizacion,
                    'emp_nombre' => $proyecto->empresa?->emp_nombre ?? 'N/A',
                    'total_aprendices' => $totalAprendices,
                    'aprendices_aprobados' => $aprendicesAprobados,
                ];
            });
    }

    /**
     * Get approved learners for an instructor's projects.
     */
    public function getAprendices(string $documento)
    {
        return Aprendiz::whereHas('postulaciones', function($query) use ($documento) {
            $query->where('pos_estado', 'Aprobada')
                ->whereHas('proyecto', function($subQuery) use ($documento) {
                    $subQuery->where('ins_usr_documento', $documento)
                        ->where('pro_estado', 'Activo');
                });
        })->with(['usuario', 'postulaciones' => function($q) use ($documento) {
            $q->where('pos_estado', 'Aprobada')
                ->whereHas('proyecto', function($sq) use ($documento) {
                    $sq->where('ins_usr_documento', $documento);
                });
        }])->get();
    }

    /**
     * Update instructor profile.
     */
    public function updateProfile(int $usrId, array $data): bool
    {
        $instructor = Instructor::where('usr_id', $usrId)->firstOrFail();
        $usuario = User::where('usr_id', $usrId)->firstOrFail();

        $instructor->update([
            'ins_nombre'      => $data['nombre'],
            'ins_apellido'    => $data['apellido'],
            'ins_especialidad'=> $data['especialidad'],
        ]);

        if (!empty($data['password'])) {
            $usuario->update([
                'usr_contrasena' => Hash::make($data['password']),
            ]);
        }

        session(['nombre' => $data['nombre'], 'apellido' => $data['apellido']]);
        return true;
    }

    /**
     * Get profile statistics for an instructor.
     */
    public function getProfileStats(string $documento): array
    {
        return [
            'proyectosCount' => Proyecto::where('ins_usr_documento', $documento)->count(),
            'aprendicesCount' => Postulacion::whereIn('pro_id',
                Proyecto::where('ins_usr_documento', $documento)->pluck('pro_id')
            )->where('pos_estado', 'Aprobada')
                ->distinct('apr_id')
                ->count(),
            'evidenciasPendientesCount' => Evidencia::whereIn('evid_pro_id',
                Proyecto::where('ins_usr_documento', $documento)->pluck('pro_id')
            )->where('evid_estado', 'Pendiente')
                ->count(),
        ];
    }
}
