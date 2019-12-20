<?php

namespace MetodikaTI\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class PostJobRequest extends FormRequest
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
        $rules["category_id"] = "required";
        $rules["description"] = "required";
        $rules["minimun_age"] = "required";
        $rules["maximum_age"] = "required";
        $rules["sex"] = "required";
        $rules["school_grade_id"] = "required";
        $rules["languages_id"] = "required";
        $rules["state"] = "required";
        $rules["municipaly"] = "required";
        $rules["colony"] = "required";
        $rules["how_to_go"] = "required";

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
