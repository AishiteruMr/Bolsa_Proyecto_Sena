<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalificarEvidenciaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estado' => 'required|string|in:pendiente,aceptada,rechazada',
            'comentario' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'estado.required' => 'Selecciona un estado.',
            'estado.in' => 'Estado no válido.',
            'comentario.max' => 'Máximo 1000 caracteres.',
        ];
    }
}