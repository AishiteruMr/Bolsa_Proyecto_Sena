<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnviarEvidenciaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'descripcion' => 'required|string|max:1000',
            'archivo' => 'nullable|file|max:5120|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx',
        ];
    }

    public function messages(): array
    {
        return [
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.max' => 'La descripción no puede exceder 1000 caracteres.',
            'archivo.max' => 'El archivo no puede ser mayor a 5MB.',
            'archivo.mimes' => 'Tipo de archivo no permitido.',
        ];
    }
}