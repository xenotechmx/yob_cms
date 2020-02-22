<?php

namespace MetodikaTI\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceInformationRequest extends FormRequest
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
            "invoice.social_reason" => "required",
            "invoice.cp" => "required",
            "invoice.rfc" => "required",
            "invoice.email_send_invoice" => "required",
        ];
    }


    public function messages()
    {
        return [
            "invoice.social_reason.required" => "El campo 'Razón social' es requerido.",
            "invoice.comercial_name.required" => "El campo 'Nombre comercial' es requerido.",
            "invoice.rfc.required" => "El campo 'CP' es requerido.",
            "invoice.rfc.required" => "El campo 'RFC' es requerido.",
            "invoice.fiscal_address.required" => "El campo 'Domicilio fiscal' es requerido.",
            "invoice.email_send_invoice.required" => "El campo 'Correo para enviar facturas' es requerido.",
        ];
    }

}
