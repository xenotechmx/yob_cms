<?php

namespace MetodikaTI\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;

class DataToReservationRequest extends FormRequest
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

        $validation = array();

        $validation["nombre_completo"]              = "required";
        $validation["email"]                        = "required|email";
        $validation["telefono"]                     = "required";

        if($this->tipo_pago == "debito_credito"){
            $validation["nombre_del_tarjetahabiente"]   = "required";
            $validation["numero_de_tarjeta_de_credito"] = "required";
            $validation["exp_mes"]                      = "required";
            $validation["exp_anio"]                     = "required";
            $validation["cvc"]                          = "required";
        }

        return $validation;
    }


    public function messages()
    {
        return [
            "nombre_completo.required"                  => "El campo 'Nombre completo' es requerido.",
            "email.required"                            => "El campo 'Email' es requerido.",
            "telefono.required"                         => "El campo 'Teléfono' es requerido.",
            "nombre_del_tarjetahabiente.required"       => "El campo 'Nombre del tarjetahabiente' es requerido.",
            "numero_de_tarjeta_de_credito.required"     => "El campo 'Número de tarjeta de crédito' es requerido.",
            "exp_mes.required"                          => "El campo 'Mes de expiración' es requerido.",
            "exp_anio.required"                         => "El campo 'Año de expiración' es requerido.",
            "cvc.required"                              => "El campo 'CVC' es requerido.",

            "email.email"                              => "El campo 'Email' debe de ser un correo valido.",
        ];
    }

}
