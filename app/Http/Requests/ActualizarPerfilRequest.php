<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarPerfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $minPassword = config('app_config.password.min_length', 8);

        return match ($this->user()->rol_id ?? 0) {
            1 => [
                'nombre' => 'required|string|max:50',
                'apellido' => 'required|string|max:50',
                'programa' => 'nullable|string|max:100',
                'password' => 'nullable|string|min:'.$minPassword.'|confirmed',
            ],
            2 => [
                'nombre' => 'required|string|max:50',
                'apellido' => 'required|string|max:50',
                'especialidad' => 'required|string|max:100',
                'password' => 'nullable|string|min:'.$minPassword,
            ],
            default => [],
        };
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder 50 caracteres.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no puede exceder 50 caracteres.',
            'programa.required' => 'El programa de formación es obligatorio.',
            'programa.max' => 'El programa no puede exceder 100 caracteres.',
            'password.min' => 'La contraseña debe tener al menos '.config('app_config.password.min_length', 8).' caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}