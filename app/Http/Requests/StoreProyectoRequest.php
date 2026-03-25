<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProyectoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return session()->has('nit') && session('rol') == 3;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo'       => 'required|string|max:200',
            'categoria'    => 'required|string|max:100',
            'descripcion'  => 'required|string|max:500',
            'requisitos'   => 'required|string|max:200',
            'habilidades'  => 'required|string|max:200',
            'fecha_publi'  => 'required|date',
            'imagen'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'latitud'      => 'nullable|numeric',
            'longitud'     => 'nullable|numeric',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'titulo.required' => 'El título de la misión es obligatorio para el despliegue.',
            'categoria.required' => 'Debe seleccionar una división técnica válida.',
            'descripcion.required' => 'El manifiesto del desafío es crítico para los aspirantes.',
            'fecha_publi.required' => 'La ventana temporal de inicio es obligatoria.',
            'imagen.image' => 'El artifacto visual debe ser una imagen válida (JPG, PNG).',
            'imagen.max' => 'El peso del artifacto excede el límite de seguridad (2MB).',
        ];
    }
}
