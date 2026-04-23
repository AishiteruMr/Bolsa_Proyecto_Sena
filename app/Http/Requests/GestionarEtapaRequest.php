<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GestionarEtapaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return match ($this->route()->getName()) {
            'instructor.etapas.crear' => [
                'nombre' => 'required|string|max:200',
                'descripcion' => 'required|string|max:1000',
                'orden' => 'required|integer|min:1',
            ],
            'instructor.etapas.editar' => [
                'nombre' => 'required|string|max:200',
                'descripcion' => 'required|string|max:1000',
                'orden' => 'required|integer|min:1',
            ],
            default => [],
        };
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder 200 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.max' => 'La descripción no puede exceder 1000 caracteres.',
            'orden.required' => 'El orden es obligatorio.',
            'orden.integer' => 'El orden debe ser un número entero.',
            'orden.min' => 'El orden debe ser al menos 1.',
        ];
    }
}