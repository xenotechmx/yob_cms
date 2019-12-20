<?php

namespace MetodikaTI\Http\Requests\Back\Package;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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

        //destacable

        $rules = array();

        $rules["name"] = "required";
        $rules["duration_plan_in_days"] = "required";

        if( $this->ilimited_total_jobs_to_post == null ){
            $rules["total_jobs_to_post"] = "required";
        }

        if( $this->ilimited_total_profiles_to_view == null ){
            $rules["total_profiles_to_view"] = "required";
        }

        if( $this->ilimited_duration_in_days == null ){
            $rules["duration_in_days"] = "required";
        }

        $rules["price"] = "required";

        return $rules;
    }

    public function messages()
    {
        return [
            "name.required" => "El campo 'Nombre' es requerido.",
            "duration_plan_in_days.required" => "El campo 'Días de duración del plan' es requerido.",
            "total_jobs_to_post.required" => "El campo 'Empleos permitidos para publicar' es requerido.",
            "total_profiles_to_view.required" => "El campo 'Identidades' es requerido.",
            "duration_in_days.required" => "El campo 'Días de duración' es requerido.",
            "price.required" => "El campo 'Precio' es requerido.",
        ];
    }
}
