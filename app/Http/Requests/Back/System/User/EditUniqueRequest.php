<?php

namespace MetodikaTI\Http\Requests\Back\System\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditUniqueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (Auth::check() ? true : false);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.base64_decode($this->route()->parameter('id')).',id',
            //'perfil' => 'required',
            'password' => 'confirmed',
        ];
    }
}
