<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $reportType,
        private array $params = [],
        private ?string $outputPath = null
    ) {
        $this->onQueue('low');
    }

    public function handle(): void
    {
        $data = match ($this->reportType) {
            'usuarios' => $this->generateUserReport(),
            'proyectos' => $this->generateProjectReport(),
            'postulaciones' => $this->generatePostulacionReport(),
            default => throw new \InvalidArgumentException("Tipo de reporte '{$this->reportType}' no soportado"),
        };

        if ($this->outputPath) {
            Storage::put($this->outputPath, $data);
        }
    }

    private function generateUserReport(): string
    {
        $usuarios = \App\Models\User::with('rol')->get();
        $csv = "ID,Nombre,Correo,Rol,Creado\n";
        foreach ($usuarios as $u) {
            $csv .= "{$u->id},{$u->nombre_completo},{$u->email},{$u->rol?->nombre},{$u->created_at}\n";
        }
        return $csv;
    }

    private function generateProjectReport(): string
    {
        $proyectos = \App\Models\Proyecto::with(['aprendiz', 'programa'])->get();
        $csv = "ID,Título,Aprendiz,Programa,Estado,Creado\n";
        foreach ($proyectos as $p) {
            $csv .= "{$p->id},{$p->titulo},{$p->aprendiz?->nombre_completo},{$p->programa?->nombre},{$p->estado},{$p->created_at}\n";
        }
        return $csv;
    }

    private function generatePostulacionReport(): string
    {
        $postulaciones = \App\Models\Postulacione::with(['aprendiz', 'proyecto'])->get();
        $csv = "ID,Aprendiz,Proyecto,Estado,Fecha Postulación\n";
        foreach ($postulaciones as $p) {
            $csv .= "{$p->id},{$p->aprendiz?->nombre_completo},{$p->proyecto?->titulo},{$p->estado},{$p->created_at}\n";
        }
        return $csv;
    }
}
