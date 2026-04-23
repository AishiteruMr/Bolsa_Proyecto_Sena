<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CambiarEstadoUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo' => 'required|in:aprendiz,instructor',
            'estado' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'tipo.required' => 'El tipo de usuario es obligatorio.',
            'tipo.in' => 'El tipo debe ser aprendiz o instructor.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser 0 (inactivo) o 1 (activo).',
        ];
    }
}