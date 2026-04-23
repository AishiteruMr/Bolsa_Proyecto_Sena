<?php

namespace App\Services;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

            return [true, 'Perfil actualizado correctamente.'];
        } catch (\Exception $e) {
            return [false, 'Error al actualizar el perfil.'];
        }
    }
}