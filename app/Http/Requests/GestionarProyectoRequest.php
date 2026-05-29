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
                'requisitos' => 'required|string|min:20|max:400',
                'habilidades' => 'required|string|min:15|max:200',
                'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
                'latitud' => 'nullable|numeric',
                'longitud' => 'nullable|numeric',
                'oferta' => 'required|string|in:pasantias,contrato_aprendizaje,auxilio_transporte,otro',
                'oferta_otro' => 'required_if:oferta,otro|nullable|string|max:100',
            ],
            $this->routeIs('empresa.proyectos.update') => [
                'titulo' => 'required|string|max:200',
                'categoria' => 'required|string|max:100',
                'descripcion' => 'required|string|min:80|max:5000',
                'requisitos' => 'required|string|max:400',
                'habilidades' => 'required|string|max:200',
                'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'latitud' => 'nullable|numeric',
                'longitud' => 'nullable|numeric',
                'oferta' => 'required|string|in:pasantias,contrato_aprendizaje,auxilio_transporte,otro',
                'oferta_otro' => 'required_if:oferta,otro|nullable|string|max:100',
            ],
            $this->routeIs('admin.proyectos.estado') => [
                'estado' => 'required|in:aprobado,rechazado,pendiente,cerrado,en_progreso,completado',
            ],
            default => [],
        };
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'Escribe un título.',
            'titulo.min' => 'Mínimo 10 caracteres.',
            'titulo.max' => 'Máximo 200 caracteres.',
            'categoria.required' => 'Elige una categoría.',
            'categoria.max' => 'Máximo 100 caracteres.',
            'descripcion.required' => 'Escribe una descripción.',
            'descripcion.min' => 'Escribe al menos 80 caracteres.',
            'descripcion.max' => 'Máximo 5000 caracteres.',
            'requisitos.required' => 'Escribe los requisitos.',
            'requisitos.min' => 'Mínimo 20 caracteres.',
            'requisitos.max' => 'Máximo 400 caracteres.',
            'habilidades.required' => 'Escribe las habilidades requeridas.',
            'habilidades.min' => 'Mínimo 15 caracteres.',
            'habilidades.max' => 'Máximo 200 caracteres.',
            'fecha_publi.required' => 'Elige una fecha de publicación.',
            'fecha_publi.date' => 'Fecha no válida.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.max' => 'Máximo 4MB.',
            'imagen.mimes' => 'Formatos: JPG, PNG o WebP.',
            'estado.required' => 'Selecciona un estado.',
            'estado.in' => 'Estado no válido.',
            'oferta.required' => 'Elige un tipo de oferta.',
            'oferta.in' => 'Oferta no válida.',
            'oferta_otro.required_if' => 'Especifica la oferta en el campo "¿Cuál?".',
            'oferta_otro.max' => 'Máximo 100 caracteres.',
        ];
    }
}