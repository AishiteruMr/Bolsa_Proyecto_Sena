<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Etapa;
use App\Models\Evidencia;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    public function evidencia(int $id): StreamedResponse
    {
        $evidencia = Evidencia::findOrFail($id);

        abort_unless($evidencia->hasFile(), 404);
        abort_unless(Storage::disk('public')->exists($evidencia->ruta_archivo), 404);

        return Storage::disk('public')->download($evidencia->ruta_archivo);
    }

    public function etapaDocumento(int $id): StreamedResponse
    {
        $etapa = Etapa::findOrFail($id);

        abort_unless($etapa->hasDocumento(), 404);
        abort_unless(Storage::disk('public')->exists($etapa->url_documento), 404);

        return Storage::disk('public')->download($etapa->url_documento);
    }

    public function proyectoEstructura(int $id): StreamedResponse
    {
        $proyecto = Proyecto::findOrFail($id);

        abort_unless($proyecto->url_estructura, 404);
        abort_unless(Storage::disk('public')->exists($proyecto->url_estructura), 404);

        return Storage::disk('public')->download($proyecto->url_estructura);
    }

    public function empresaMetodologia(int $id): StreamedResponse
    {
        $empresa = Empresa::findOrFail($id);

        abort_unless($empresa->metodologia_url, 404);
        abort_unless(Storage::disk('public')->exists($empresa->metodologia_url), 404);

        return Storage::disk('public')->download($empresa->metodologia_url);
    }
}
