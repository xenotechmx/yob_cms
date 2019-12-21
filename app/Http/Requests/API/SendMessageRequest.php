<?php

namespace MetodikaTI\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
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
            "message" => "required",
            //"asunto" => "required",
        ];
    }

    public function messages()
    {
        return [
            //"message.required" => "Ingresa un asunto al mensaje.",
            "message.required" => "Redacta el mensaje a enviar.",
        ];
    }

}
