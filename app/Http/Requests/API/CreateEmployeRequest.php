<?php

namespace MetodikaTI\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeRequest extends FormRequest
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

        $rules = array();

        if ($this->type == "moral") {
            $rules["moral.razon_social"] = "required";
            //$rules["moral.commercial_denomination"] = "required";
            $rules["moral.rfc"] = "required";
            $rules["moral.responsable_name"] = "required";
        } else {
            $rules["fisica.name"] = "required";
            $rules["fisica.father_last_name"] = "required";
            //$rules["fisica.mother_last_name"] = "required";
        }


        //$rules["business_name"] = "required";

        $rules["address.address"] = "required";
        $rules["address.interior_exterior_number"] = "required";
        $rules["address.postal_code"] = "required";
        $rules["address.country"] = "required";
        $rules["address.state"] = "required";
        $rules["address.municipaly"] = "required";
        $rules["address.colony"] = "required";
        $rules["address.email"] = "required|email";
        $rules["address.phone"] = "required";

        $rules["general_information.email"] = "required|email";
        $rules["general_information.password"] = "required|confirmed";
        $rules["general_information.password_confirmation"] = "required";
        $rules["terminos_condiciones"] = "in:1";


        return $rules;
    }

    public function messages()
    {

        return [
            "moral.razon_social.required" => "El campo 'Razón social' en la sección 'Datos del empleador' es requerido.",
            "moral.commercial_denomination.required" => "El campo 'Denominación comercial' en la sección 'Datos del empleador' es requerido.",
            "moral.rfc.required" => "El campo 'RFC' en la sección 'Datos del empleador' es requerido.",
            "moral.responsable_name.required" => "El campo 'Nombre del responsable' en la sección 'Datos del empleador' es requerido.",

            "fisica.name.required" => "El campo 'Nombre(s)' en la sección 'Datos del empleador' es requerido.",
            "fisica.father_last_name.required" => "El campo 'Apellido paterno' en la sección 'Datos del empleador' es requerido.",
            "fisica.mother_last_name.required" => "El campo 'Apellido materno' en la sección 'Datos del empleador' es requerido.",

            "business_name.required" => "El campo 'Nombre de la empresa' en la sección 'Datos del empleador' es requerido.",


            "address.address.required" => "El campo 'Calle' en la sección 'Domicilio' es requerido.",
            "address.interior_exterior_number.required" => "El campo 'Número interior / exterior' en la sección 'Domicilio' es requerido.",
            "address.postal_code.required" => "El campo 'Código postal' en la sección 'Domicilio' es requerido.",
            "address.country.required" => "El campo 'País' en la sección 'Domicilio' es requerido.",
            "address.state.required" => "El campo 'Estado' en la sección 'Domicilio' es requerido.",
            "address.municipaly.required" => "El campo 'Municipio' en la sección 'Domicilio' es requerido.",
            "address.colony.required" => "El campo 'Colonia' en la sección 'Domicilio' es requerido.",
            "address.email.required" => "El campo 'Correo electrónico' en la sección 'Domicilio' es requerido.",
            "address.email.email" => "El campo 'Correo electrónico' en la sección 'Domicilio' no tiene un formato valido.",
            "address.phone.required" => "El campo 'Teléfono' en la sección 'Domicilio' es requerido.",

            "general_information.email.required" => "El campo 'Correo electrónico' en la sección 'Cuenta de acceso' es requerido.",
            "general_information.email.email" => "El campo 'Correo electrónico' en la sección 'Cuenta de acceso' no tiene un formato valido.",
            "general_information.email.unique" => "El campo 'Correo electrónico' ya se encuentra registrado.",
            "general_information.password.required" => "El campo 'Contraseña' en la sección 'Cuenta de acceso' es requerido.",
            "general_information.password_confirmation.required" => "El campo 'Confirmar contraseña' en la sección 'Cuenta de acceso' es requerido.",
            "general_information.password.confirmed" => "El campo 'Contraseña' y 'Confirmar contraseña' no coinciden.",
            "terminos_condiciones.in" => "Acepta los 'Términos y condiciones' y 'Aviso de privacidad' ",
        ];

    }

}
