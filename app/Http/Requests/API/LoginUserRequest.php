<?php

namespace MetodikaTI\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
            "email" => "required",
            "password" => "required",
        ];
    }

    public function messages()
    {
        return [
            "email.required" => "El campo 'Correo electrónico' es requerido.",
            "password.required" => "El campo 'Contraseña' es requerido.",
        ];
    }

}
