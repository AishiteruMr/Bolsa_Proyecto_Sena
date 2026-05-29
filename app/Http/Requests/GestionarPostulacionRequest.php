<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GestionarPostulacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estado' => 'required|in:pendiente,aceptada,rechazada',
        ];
    }

    public function messages(): array
    {
        return [
            'estado.required' => 'Selecciona un estado.',
            'estado.in' => 'Estado no válido.',
        ];
    }
}