<?php

namespace MetodikaTI\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class SearchJobRequest extends FormRequest
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

        if($this->puesto_area == "" && $this->empresa == "" && $this->municipio == ""){
            $rules["parameter"] = "required";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            "parameter.required" => "Ingresa al menos un campo para buscar empleos."
        ];
    }


}
