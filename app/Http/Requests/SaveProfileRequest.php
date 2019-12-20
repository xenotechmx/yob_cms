<?php

namespace MetodikaTI\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProfileRequest extends FormRequest
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
            //"mother_last_name" => "required",
            "father_last_name" => "required",
            "birthday" => "required",
            "address" => "required",
            "postal_code" => "required",
            "state" => "required",
            "municipaly" => "required",
            "colony" => "required",
            "phone" => "required",
            "email" => "required|email|unique:app_users,email,".$this->user_id,
        ];
    }

    public function messages(){
        return [
            "name.required" => "El campo 'Nombre(s)' es requerido.",
            "father_last_name.required" => "El campo 'Apellido paterno' es requerido.",
            "mother_last_name.required" => "El campo 'Apellido materno' es requerido.",
            "birthday.required" => "El campo 'Fecha de nacimiento' es requerido.",
            "address.required" => "El campo 'Calle o avenida' es requerido.",
            "postal_code.required" => "El campo 'Código postal' es requerido.",
            "state.required" => "El campo 'Estado' es requerido.",
            "municipaly.required" => "El campo 'Municipio' es requerido.",
            "colony.required" => "El campo 'Colonia' es requerido.",
            "phone.required" => "El campo 'Teléfono' es requerido.",
            "email.required" => "El campo 'Correo electrónico' es requerido.",
            "email.email" => "El campo 'Correo electrónico' no tiene un formato valido.",
            "email.unique" => "El campo 'Correo electrónico' ya se encuentra registrado.",
        ];
    }


}
