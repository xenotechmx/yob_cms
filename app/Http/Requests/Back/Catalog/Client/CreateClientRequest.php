<?php

namespace MetodikaTI\Http\Requests\Back\Catalog\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "business_name" => "required",
            "address"       => "required",
            "user_name"     => "required",
            "email"         => "required|email|unique:clients,email",
            "phone"         => "required",
            "password"      => "required|confirmed"
        ];
    }

    public function messages()
    {
        return [
            "business_name.required" => "El campo 'Nombre comercial de la empresa' es requerido.",
            "address.required"       => "El campo 'Dirección' es requerido.",
            "user_name.required"     => "El campo 'Nombre del usuario' es requerido.",
            "email.required"         => "El campo 'Correo electrónico' es requerido.",
            "email.email"             => "El campo 'Correo electrónico' debe de tener formato de email.",
            "email.unique"           => "El campo 'Correo electrónico' ya se encuentra registrado.",
            "phone.required"         => "El campo 'Teléfono' es requerido.",
            "password.required"      => "El campo 'Contraseña' es requerido.",
            "password.confirmed"     => "El campo 'Contraseña' y 'Confirma Contraseña' no coinciden.",
        ];
    }

}
