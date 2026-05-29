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
            'nombre.required' => 'Escribe un nombre.',
            'nombre.max' => 'Máximo 200 caracteres.',
            'descripcion.required' => 'Escribe una descripción.',
            'descripcion.max' => 'Máximo 1000 caracteres.',
            'orden.required' => 'Escribe el orden.',
            'orden.integer' => 'Debe ser un número entero.',
            'orden.min' => 'Mínimo 1.',
        ];
    }
}