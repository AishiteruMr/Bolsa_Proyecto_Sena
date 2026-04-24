<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GestionarProyectoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return match (true) {
            $this->routeIs('empresa.proyectos.store') => [
                'titulo' => 'required|string|min:10|max:200',
                'categoria' => 'required|string|max:100',
                'descripcion' => 'required|string|min:80|max:5000',
                'requisitos' => 'required|string|min:20|max:200',
                'habilidades' => 'required|string|min:15|max:200',
                'fecha_publi' => 'required|date',
                'duracion' => 'required|integer|min:7|max:365',
                'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
                'latitud' => 'nullable|numeric',
                'longitud' => 'nullable|numeric',
            ],
            $this->routeIs('empresa.proyectos.update') => [
                'titulo' => 'required|string|max:200',
                'categoria' => 'required|string|max:100',
                'descripcion' => 'required|string|min:80|max:5000',
                'requisitos' => 'required|string|max:200',
                'habilidades' => 'required|string|max:200',
                'fecha_publi' => 'required|date',
                'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'latitud' => 'nullable|numeric',
                'longitud' => 'nullable|numeric',
            ],
            $this->routeIs('admin.proyectos.estado') => [
                'estado' => 'required|in:aprobado,rechazado,pendiente,cerrado,en_progreso',
            ],
            default => [],
        };
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.min' => 'El título debe tener al menos 10 caracteres.',
            'titulo.max' => 'El título no puede exceder 200 caracteres.',
            'categoria.required' => 'La categoría es obligatoria.',
            'categoria.max' => 'La categoría no puede exceder 100 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 80 caracteres.',
            'descripcion.max' => 'La descripción no puede exceder 5000 caracteres.',
            'requisitos.required' => 'Los requisitos son obligatorios.',
            'requisitos.min' => 'Los requisitos deben tener al menos 20 caracteres.',
            'requisitos.max' => 'Los requisitos no pueden exceder 200 caracteres.',
            'habilidades.required' => 'Las habilidades son obligatorias.',
            'habilidades.min' => 'Las habilidades deben tener al menos 15 caracteres.',
            'habilidades.max' => 'Las habilidades no pueden exceder 200 caracteres.',
            'fecha_publi.required' => 'La fecha de publicación es obligatoria.',
            'fecha_publi.date' => 'La fecha de publicación debe ser válida.',
            'duracion.required' => 'La duración es obligatoria.',
            'duracion.integer' => 'La duración debe ser un número válido.',
            'duracion.min' => 'La duración mínima es de 7 días.',
            'duracion.max' => 'La duración máxima es de 365 días.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.max' => 'La imagen no puede ser mayor a 4MB.',
            'imagen.mimes' => 'La imagen debe ser JPG, PNG o WebP.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser uno de los valores permitidos.',
        ];
    }
}