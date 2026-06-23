<?php

namespace App\Services;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PerfilService
{
    public function actualizarPerfilEmpresa(int $empresaId, array $datos): array
    {
        try {
            $empresa = Empresa::findOrFail($empresaId);

            $actualizaciones = [
                'nombre' => $datos['nombre_empresa'],
                'representante' => $datos['representante'],
            ];

            if (array_key_exists('metodologia_url', $datos)) {
                if ($empresa->metodologia_url) {
                    Storage::disk('public')->delete($empresa->metodologia_url);
                }
                $actualizaciones['metodologia_url'] = $datos['metodologia_url'];
            } elseif (($datos['eliminar_metodologia'] ?? false) && $empresa->metodologia_url) {
                Storage::disk('public')->delete($empresa->metodologia_url);
                $actualizaciones['metodologia_url'] = null;
            }

            $empresa->update($actualizaciones);

            if (!empty($datos['password'])) {
                $usuario = User::find($empresa->usuario_id);
                if ($usuario) {
                    $usuario->update(['contrasena' => Hash::make($datos['password'])]);
                }
            }

            return [true, 'Perfil actualizado correctamente.'];
        } catch (\Exception $e) {
            return [false, 'Error al actualizar el perfil.'];
        }
    }

    public function actualizarPerfilInstructor(int $instructorId, array $datos): array
    {
        try {
            $instructor = \App\Models\Instructor::findOrFail($instructorId);

            $actualizaciones = [
                'nombres' => $datos['nombre'],
                'apellidos' => $datos['apellido'],
                'especialidad' => $datos['especialidad'],
            ];

            $instructor->update($actualizaciones);

            if (!empty($datos['password'])) {
                $usuario = User::find($instructor->usuario_id);
                if ($usuario) {
                    $usuario->update(['contrasena' => Hash::make($datos['password'])]);
                }
            }

            return [true, 'Perfil actualizado con éxito.'];
        } catch (\Exception $e) {
            return [false, 'Error al actualizar el perfil.'];
        }
    }
}