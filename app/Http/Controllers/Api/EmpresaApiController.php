<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmpresaApiController extends Controller
{
    /**
     * Obtener ubicación de la empresa por NIT
     * GET /api/empresa/{nit}/ubicacion
     */
    public function obtenerUbicacion($nit)
    {
        try {
            $empresa = DB::table('empresa')
                ->where('emp_nit', $nit)
                ->select(
                    'emp_id',
                    'emp_nit',
                    'emp_nombre',
                    'emp_ubicacion',
                    'emp_departamento',
                    'emp_ciudad',
                    'emp_direccion'
                )
                ->first();

            if (!$empresa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Empresa no encontrada',
                    'data' => null
                ], 404);
            }

            // Si no hay ubicación, devolver un valor por defecto
            if (!$empresa->emp_ubicacion && !$empresa->emp_ciudad && !$empresa->emp_departamento) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ubicación no configurada para esta empresa',
                    'data' => [
                        'emp_id' => $empresa->emp_id,
                        'emp_nit' => $empresa->emp_nit,
                        'emp_nombre' => $empresa->emp_nombre,
                        'ubicacion' => 'Por definir',
                        'ubicacion_completa' => 'Por definir'
                    ]
                ], 200);
            }

            // Construir ubicación completa
            $ubicacionCompleta = array_filter([
                $empresa->emp_direccion,
                $empresa->emp_ciudad,
                $empresa->emp_departamento,
                $empresa->emp_ubicacion
            ]);

            $ubicacion = $empresa->emp_ubicacion 
                ? $empresa->emp_ubicacion 
                : ($empresa->emp_ciudad 
                    ? $empresa->emp_ciudad 
                    : ($empresa->emp_departamento 
                        ? $empresa->emp_departamento 
                        : 'Por definir'));

            return response()->json([
                'success' => true,
                'message' => 'Ubicación obtenida correctamente',
                'data' => [
                    'emp_id' => $empresa->emp_id,
                    'emp_nit' => $empresa->emp_nit,
                    'emp_nombre' => $empresa->emp_nombre,
                    'ubicacion' => $ubicacion,
                    'ubicacion_completa' => implode(', ', $ubicacionCompleta),
                    'departamento' => $empresa->emp_departamento,
                    'ciudad' => $empresa->emp_ciudad,
                    'direccion' => $empresa->emp_direccion
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al obtener ubicación de empresa: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la ubicación de la empresa'
            ], 500);
        }
    }

    /**
     * Obtener ubicación por sesión (para usuario autenticado)
     * GET /api/empresa/ubicacion/sesion
     */
    public function obtenerUbicacionSesion(Request $request)
    {
        try {
            $nit = session('nit');

            if (!$nit) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay sesión de empresa activa',
                    'data' => null
                ], 401);
            }

            $empresa = DB::table('empresa')
                ->where('emp_nit', $nit)
                ->select(
                    'emp_id',
                    'emp_nit',
                    'emp_nombre',
                    'emp_ubicacion',
                    'emp_departamento',
                    'emp_ciudad',
                    'emp_direccion'
                )
                ->first();

            if (!$empresa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de empresa no encontrados',
                    'data' => null
                ], 404);
            }

            $ubicacionCompleta = array_filter([
                $empresa->emp_direccion,
                $empresa->emp_ciudad,
                $empresa->emp_departamento
            ]);

            $ubicacion = $empresa->emp_ubicacion 
                ? $empresa->emp_ubicacion 
                : ($empresa->emp_ciudad 
                    ? $empresa->emp_ciudad 
                    : ($empresa->emp_departamento 
                        ? $empresa->emp_departamento 
                        : ''));

            return response()->json([
                'success' => true,
                'message' => 'Ubicación obtenida correctamente',
                'data' => [
                    'emp_id' => $empresa->emp_id,
                    'emp_nit' => $empresa->emp_nit,
                    'emp_nombre' => $empresa->emp_nombre,
                    'ubicacion' => $ubicacion,
                    'ubicacion_completa' => implode(', ', $ubicacionCompleta),
                    'departamento' => $empresa->emp_departamento,
                    'ciudad' => $empresa->emp_ciudad,
                    'direccion' => $empresa->emp_direccion
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al obtener ubicación de sesión: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la ubicación'
            ], 500);
        }
    }

    /**
     * Actualizar ubicación de la empresa
     * PUT /api/empresa/{id}/ubicacion
     */
    public function actualizarUbicacion(Request $request, $id)
    {
        try {
            $request->validate([
                'ubicacion' => 'nullable|string|max:255',
                'departamento' => 'nullable|string|max:100',
                'ciudad' => 'nullable|string|max:100',
                'direccion' => 'nullable|string|max:255'
            ]);

            $actualizado = DB::table('empresa')
                ->where('emp_id', $id)
                ->update([
                    'emp_ubicacion' => $request->ubicacion,
                    'emp_departamento' => $request->departamento,
                    'emp_ciudad' => $request->ciudad,
                    'emp_direccion' => $request->direccion
                ]);

            if (!$actualizado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Empresa no encontrada',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Ubicación actualizada correctamente',
                'data' => [
                    'ubicacion' => $request->ubicacion,
                    'departamento' => $request->departamento,
                    'ciudad' => $request->ciudad,
                    'direccion' => $request->direccion
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al actualizar ubicación: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la ubicación'
            ], 500);
        }
    }

    /**
     * Listar todas las empresas (sin ubicación sensible)
     * GET /api/empresas
     */
    public function index()
    {
        try {
            $empresas = DB::table('empresa')
                ->select(
                    'emp_id',
                    'emp_nit',
                    'emp_nombre',
                    'emp_representante',
                    'emp_ubicacion',
                    'emp_ciudad',
                    'emp_departamento'
                )
                ->where('emp_estado', 1)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Empresas obtenidas correctamente',
                'data' => $empresas,
                'total' => count($empresas)
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error al listar empresas: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las empresas'
            ], 500);
        }
    }
}
