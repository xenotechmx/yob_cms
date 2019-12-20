<?php

namespace MetodikaTI\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class SaveJobRequest extends FormRequest
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

        $rules["job_title"] = "required";

        if( $this->postal_code != "" ){
            $rules["postal_code"] = "numeric";
        }


//        return [
//            "job_title" => "required",
//            "category_id" => "required",
//            "description" => "required",
//            "minimun_age" => "required",
//            "maximum_age" => "required",
//            "sex" => "required",
//            "school_grade_id" => "required",
//            "experience" => "required",
//            "languages_id" => "required",
//            "functions" => "required",
//            "benefist" => "required",
//            "street" => "required",
//            "number" => "required",
//            "postal_code" => "required|numeric",
//            "state" => "required",
//            "municipaly" => "required",
//            "colony" => "required",
//            "how_to_go" => "required",
//        ];

        return $rules;
    }

    public function messages()
    {
        return [
            "job_title.required" => "Ingresa el título de la vacante.",
            "category_id.required" => "Selecciona una categoría.",
            "description.required" => "Ingresa una descripción.",
            "minimun_age.required" => "Ingresa un rango minímo de edad.",
            "maximum_age.required" => "Ingresa un rango maximo de edad.",
            "sex.required" => "Selecciona un genero.",
            "school_grade_id.required" => "Selecciona escolaridad.",
            "experience.required" => "Ingresa la experiencia necesaria.",
            "languages_id.required" => "Selecciona los idiomas indispensables.",
            "functions.required" => "Describe las funciones a realizar.",
            "benefist.required" => "Ingresa las prestaciones a ofrecer.",
            "street.required" => "Ingresa la calle del lugar del empleo.",
            "number.required" => "Ingresa el número del lugar del empleo.",
            "postal_code.required" => "Ingresa el código postal del lugar del empleo.",
            "postal_code.numeric" => "El código postal debe de ser númerico.",
            "state.required" => "Selecciona el estado del lugar del empleo.",
            "municipaly.required" => "Selecciona el municipio del lugar del empleo.",
            "colony.required" => "Selecciona la colonia del lugar del empleo.",
            "how_to_go.required" => "Indica como llegar al lugar del empleo (rutas de camiones, transporte, etc.).",
        ];
    }

}
