<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistroEmpresaRequest extends FormRequest
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
            'nombre_empresa' => 'required|string|max:150',
            'nit'            => 'required|numeric|digits_between:6,15|unique:empresas,nit|unique:usuarios,numero_documento',
            'representante'  => 'required|string|max:100',
            'correo'         => 'required|email|max:255|unique:empresas,correo_contacto|unique:usuarios,correo',
            'password'       => 'required|string|min:8|max:100|confirmed',
            'terminos'       => 'accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'required'           => 'El campo :attribute es obligatorio.',
            'email'              => 'Ingresa un correo electrónico válido.',
            'unique'             => 'Este :attribute ya está registrado.',
            'min'                => 'El campo :attribute debe tener al menos :min caracteres.',
            'max'                => 'El campo :attribute no puede exceder :max caracteres.',
            'numeric'            => 'El campo :attribute debe ser numérico.',
            'digits_between'     => 'El documento debe tener entre :min y :max dígitos.',
            'accepted'           => 'Debes aceptar los términos y condiciones.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
