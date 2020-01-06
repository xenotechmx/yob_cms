<?php

namespace MetodikaTI\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveJobExperienceRequest extends FormRequest
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

        if (isset($this->no_working)) {
            if ($this->no_working == false) {
                $rules["place"] = "required";
                $rules["duration"] = "required";
                $rules["position"] = "required";
            }
        } else {
            $rules["place"] = "required";
            $rules["duration"] = "required";
            $rules["position"] = "required";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            "place.required" => "El campo 'Nombre o lugar donde laboraste' es requerido.",
            "duration.required" => "El campo 'Duración' es requerido.",
            "position.required" => "El campo 'Puesto' es requerido.",
            "laboral_function.required" => "El campo 'Funciones laborales' es requerido.",
        ];
    }

}
