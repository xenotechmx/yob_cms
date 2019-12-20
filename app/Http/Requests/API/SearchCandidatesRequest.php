<?php

namespace MetodikaTI\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class SearchCandidatesRequest extends FormRequest
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

        if($this->minimiun_age != ""){
            $rules["maximium_age"] = "required";
        }

        return $rules;
    }


    public function messages()
    {
        return [
            "maximium_age" => "Ingresa edad máxima para buscar candidatos."
        ];
    }

}
