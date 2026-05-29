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
            'tipo' => 'required|in:aprendiz,instructor,empresa',
            'estado' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'tipo.required' => 'Selecciona el tipo de usuario.',
            'tipo.in' => 'Tipo no válido.',
            'estado.required' => 'Selecciona un estado.',
            'estado.in' => 'Estado no válido.',
        ];
    }
}