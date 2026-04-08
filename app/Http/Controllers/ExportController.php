<?php

namespace App\Http\Controllers;

use App\Models\Aprendiz;
use App\Models\Empresa;
use App\Models\Instructor;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function proyectos(Request $request)
    {
        $format = $request->get('format', 'csv');

        $proyectos = Proyecto::with(['empresa', 'instructor.usuario'])
            ->orderByDesc('id')
            ->get();

        $data = $proyectos->map(function ($p) {
            return [
                'ID' => $p->id,
                'Título' => $p->titulo,
                'Empresa' => $p->empresa->nombre ?? 'N/A',
                'Instructor' => $p->instructor ? ($p->instructor->nombres.' '.$p->instructor->apellidos) : 'Sin asignar',
                'Categoría' => $p->categoria ?? 'N/A',
                'Estado' => ucfirst($p->estado),
                'Fecha Publicación' => $p->fecha_publicacion ? $p->fecha_publicacion->format('Y-m-d') : 'N/A',
                'Duración (días)' => $p->duracion_estimada_dias ?? 'N/A',
                'Postulaciones' => $p->countPostulaciones(),
                'Creado' => $p->created_at->format('Y-m-d H:i:s'),
            ];
        });

        if ($format === 'csv') {
            return $this->exportCSV($data, 'proyectos');
        }

        return response()->json(['data' => $data, 'total' => $data->count()]);
    }

    public function usuarios(Request $request)
    {
        $format = $request->get('format', 'csv');

        $usuarios = User::orderByDesc('id')->get();

        $data = $usuarios->map(function ($u) {
            return [
                'ID' => $u->id,
                'Nombre' => $u->nombre ?? 'N/A',
                'Correo' => $u->correo,
                'Tipo' => match ($u->rol) {
                    1 => 'Aprendiz',
                    2 => 'Instructor',
                    3 => 'Empresa',
                    4 => 'Administrador',
                    default => 'Desconocido'
                },
                'Estado' => $u->activo ? 'Activo' : 'Inactivo',
                'Último Acceso' => $u->ultimo_acceso ? $u->ultimo_acceso->format('Y-m-d H:i:s') : 'Nunca',
                'Creado' => $u->created_at->format('Y-m-d H:i:s'),
            ];
        });

        if ($format === 'csv') {
            return $this->exportCSV($data, 'usuarios');
        }

        return response()->json(['data' => $data, 'total' => $data->count()]);
    }

    public function empresas(Request $request)
    {
        $format = $request->get('format', 'csv');

        $empresas = Empresa::with('usuario')->orderByDesc('id')->get();

        $data = $empresas->map(function ($e) {
            return [
                'NIT' => $e->nit,
                'Nombre' => $e->nombre,
                'Representante' => $e->representante ?? 'N/A',
                'Correo' => $e->correo_contacto ?? 'N/A',
                'Teléfono' => $e->telefono ?? 'N/A',
                'Dirección' => $e->direccion ?? 'N/A',
                'Estado' => $e->activo ? 'Activo' : 'Inactivo',
                'Proyectos' => $e->proyectos()->count(),
                'Creado' => $e->created_at->format('Y-m-d H:i:s'),
            ];
        });

        if ($format === 'csv') {
            return $this->exportCSV($data, 'empresas');
        }

        return response()->json(['data' => $data, 'total' => $data->count()]);
    }

    public function aprendices(Request $request)
    {
        $format = $request->get('format', 'csv');

        $aprendices = Aprendiz::with('usuario')->orderByDesc('id')->get();

        $data = $aprendices->map(function ($a) {
            return [
                'ID' => $a->id,
                'Documento' => $a->usuario->numero_documento ?? 'N/A',
                'Nombre' => ($a->usuario->nombre ?? '').' '.($a->usuario->apellido ?? ''),
                'Correo' => $a->usuario->correo ?? 'N/A',
                'Programa' => $a->programa,
                'Estado' => $a->activo ? 'Activo' : 'Inactivo',
                'Creado' => $a->created_at->format('Y-m-d H:i:s'),
            ];
        });

        if ($format === 'csv') {
            return $this->exportCSV($data, 'aprendices');
        }

        return response()->json(['data' => $data, 'total' => $data->count()]);
    }

    public function instructores(Request $request)
    {
        $format = $request->get('format', 'csv');

        $instructores = Instructor::with('usuario')->orderByDesc('id')->get();

        $data = $instructores->map(function ($i) {
            return [
                'ID' => $i->id,
                'Documento' => $i->usuario->numero_documento ?? 'N/A',
                'Nombre' => $i->nombres.' '.$i->apellidos,
                'Correo' => $i->usuario->correo ?? 'N/A',
                'Especialidad' => $i->especialidad ?? 'N/A',
                'Disponibilidad' => ucfirst(str_replace('_', ' ', $i->disponibilidad)),
                'Estado' => $i->activo ? 'Activo' : 'Inactivo',
                'Proyectos' => $i->proyectos()->count(),
                'Creado' => $i->created_at->format('Y-m-d H:i:s'),
            ];
        });

        if ($format === 'csv') {
            return $this->exportCSV($data, 'instructores');
        }

        return response()->json(['data' => $data, 'total' => $data->count()]);
    }

    private function exportCSV($data, $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'_'.date('Y-m-d_His').'.csv"',
        ];

        $output = fopen('php://temp', 'r+');

        if ($data->isNotEmpty()) {
            fputcsv($output, array_keys($data->first()->toArray()));

            foreach ($data as $row) {
                fputcsv($output, array_values($row->toArray()));
            }
        }

        rewind($output);
        $content = stream_get_contents($output);
        fclose($output);

        return response($content, 200, $headers);
    }
}
