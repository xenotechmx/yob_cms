<?php

namespace MetodikaTI\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveStudyExperienceRequest extends FormRequest
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

        if (isset($this->no_study)) {
            if ($this->no_study == false) {
                $rules["school_name"] = "required";
                $rules["study_level"] = "required";
                $rules["description"] = "required";
            }
        } else {
            $rules["school_name"] = "required";
            $rules["study_level"] = "required";
            $rules["description"] = "required";
        }


        return $rules;
    }

    public function messages()
    {
        return [
            "school_name.required" => "El campo 'Escuela o institución' es requerido.",
            "study_level.required" => "El campo 'Nivel de estudios' es requerido.",
            "description.required" => "Especifica la carrera o título obtenido.",
        ];
    }
}
