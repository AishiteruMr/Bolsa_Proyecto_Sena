<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidarLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'correo' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'correo.required' => 'Escribe tu correo.',
            'correo.email' => 'Correo no válido.',
            'correo.max' => 'Máximo 255 caracteres.',
            'password.required' => 'Escribe tu contraseña.',
            'password.min' => 'Mínimo 8 caracteres.',
            'password.max' => 'Máximo 100 caracteres.',
        ];
    }
}
