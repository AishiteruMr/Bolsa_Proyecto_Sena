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
            'nombre.required' => 'Escribe tu nombre.',
            'nombre.max' => 'Máximo 50 caracteres.',
            'apellido.required' => 'Escribe tu apellido.',
            'apellido.max' => 'Máximo 50 caracteres.',

            'password.min' => 'Mínimo '.config('app_config.password.min_length', 8).' caracteres.',
            'password.confirmed' => 'Las contraseñas no son iguales.',
        ];
    }
}