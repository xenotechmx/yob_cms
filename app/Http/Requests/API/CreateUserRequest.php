<?php

namespace MetodikaTI\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            "name" => "required",
            "father_last_name" => "required",
            "phone" => "required",
            "email" => "required|email",
            "password" => "required|confirmed",
            "password_confirmation" => "required",
            "terminos_condiciones" => "in:1",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "El campo 'Nombre(s)' es requerido.",
            "father_last_name.required" => "El campo 'Apellido paterno' es requerido.",
            "mother_last_name.required" => "El campo 'Apellido materno' es requerido.",
            "phone.required" => "El campo 'Teléfono' es requerido.",
            "email.required" => "El campo 'Correo electrónico' es requerido.",
            //"email.unique" => "El campo 'Correo electrónico' ya se encuentra registrado.",
            "email.email" => "El campo 'Correo electrónico' no tiene un formato valido.",
            "password.required" => "El campo 'Contraseña' es requerido.",
            "password.confirmed" => "El campo 'Contraseña' y 'Confirmar contraseña' no coinciden.",
            "password_confirmation.required" => "El campo 'Confirmar contraseña' es requerido.",
            "terminos_condiciones.in" => "Acepta los 'Términos y condiciones' y 'Aviso de privacidad' ",
        ];
    }

}
