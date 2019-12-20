<?php

namespace MetodikaTI\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class MakePaymentCardRequest extends FormRequest
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

        if ($this->use_new_card) {
            $rules["card_data.number"] = "required";
            $rules["card_data.date"] = "required";
            $rules["card_data.cvc"] = "required";
            $rules["card_data.name"] = "required";
            $rules["card_data.card_type"] = "required";
            $rules["card_data.card_type_method"] = "required";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            "card_data.number.required" => "Ingresa el número de tarjeta.",
            "card_data.date.required" => "Ingresa la fecha de vencimiento.",
            "card_data.cvc.required" => "Ingresa el número CVC.",
            "card_data.name.required" => "Ingresa el nombre del titular de la tarjeta.",
            "card_data.card_type.required" => "Selecciona tarjeta.",
            "card_data.card_type_method.required" => "Selecciona el tipo de tarjeta.",
        ];
    }

}
