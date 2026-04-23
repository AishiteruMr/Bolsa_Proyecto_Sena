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
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser uno de los valores permitidos.',
            'comentario.max' => 'El comentario no puede exceder 1000 caracteres.',
        ];
    }
}