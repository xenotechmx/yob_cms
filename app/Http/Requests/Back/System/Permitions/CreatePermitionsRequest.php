<?php

namespace MetodikaTI\Http\Requests\Back\System\Permitions;

use Illuminate\Foundation\Http\FormRequest;

class CreatePermitionsRequest extends FormRequest
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
        return [
            "nombre" => "required",
        ];
    }

    public function messages()
    {
        return [
            "nombre.required" => "El campo 'Nombre de Perfil' es requerido.",
        ];
    }

}
