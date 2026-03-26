<?php

namespace App\Services;

use App\Models\Postulacion;
use Illuminate\Support\Facades\Mail;
use App\Mail\PostulacionEstadoCambiado;
use App\Notifications\PostulacionActualizada;

class PostulacionService
{
    /**
     * Update postulation status and notify learner.
     */
    public function updateStatus(int $posId, string $estado): bool
    {
        $postulacion = Postulacion::with(['aprendiz.usuario', 'proyecto'])->findOrFail($posId);
        $postulacion->update(['pos_estado' => $estado]);

        if (in_array($estado, ['Aprobada', 'Rechazada'])) {
            $aprendiz = $postulacion->aprendiz;
            $proyecto = $postulacion->proyecto;
            
            if ($aprendiz?->usuario) {
                try {
                    Mail::to($aprendiz->usuario->usr_correo)
                        ->send(new PostulacionEstadoCambiado(
                            $aprendiz->apr_nombre,
                            $proyecto->pro_titulo_proyecto,
                            $estado
                        ));

                    $aprendiz->usuario->notify(new PostulacionActualizada(
                        $proyecto->pro_titulo_proyecto,
                        $estado
                    ));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Error sending postulation notification: ' . $e->getMessage());
                }
            }
        }

        return true;
    }
}
