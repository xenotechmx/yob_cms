<?php

namespace MetodikaTI;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackagesBuyedByUser extends Model
{

    use SoftDeletes;

    public $appends = ['days_to_disabled'];

    public function getDaysToDisabledAttribute()
    {

        setlocale(LC_ALL, 'es_ES');

        return Carbon::createFromFormat("Y-m-d H:i:s", $this->package_disbaled_at)->formatLocalized('%d de %B del %Y %H:%M hrs');
    }


    public function getCreatedAtTranslateAttribute()
    {

        setlocale(LC_ALL, 'es_ES');

        return Carbon::createFromFormat("Y-m-d H:i:s", $this->created_at)->formatLocalized('%d de %B del %Y %H:%M hrs');
    }


    public function get_user()
    {
        return $this->hasOne(AppUser::class, "id", "app_user_id");
    }


    public function getStatusTranslateAttribute()
    {

        if ($this->status == "APPROVED") {
            return "<font style='color: #46d446; font-weight: bold;'>APROBADO</font>";
        } else if ($this->status == "PENDING") {
            return "<font style='color: #f74444; font-weight: bold;'>PENDIENTE</font>";
        }

    }


    public function getTypeTranslateAttribute()
    {

        if ($this->type == "OXXO") {
            return "Oxxo";
        } else if ($this->type == "CARD") {
            return "Tarjeta bancaria";
        }

    }


    public function get_invoice_information()
    {
        return $this->hasOne(AppUserInvoice::class, "app_user_id", "app_user_id");
    }


    public function get_invoice_payment_type()
    {

        $payment_type = "";
        switch ($this->type) {
            case "BANK_REFERENCED":
                $payment_type = "99";
                break;
            case "CARD":
                $payment_type = ($this->card_type == "DEBITO") ? "28" : "04";
                break;
            case "OTHERS_CASH_MX":
                $payment_type = "01";
                break;
            case "OXXO":
                $payment_type = "01";
                break;
            case "SEVEN_ELEVEN":
                $payment_type = "01";
                break;
        }

        return $payment_type;
    }


    public function get_price_without_iva()
    {

        $original_price = $this->original_price;
        return $original_price / 1.16;
    }


    public function get_iva()
    {

        $original_price = $this->original_price;
        $price_without_iva = $original_price / 1.16;
        return $price_without_iva * 0.16;
    }


    public function already_invoice_generated()
    {

        $invoices = Invoice::where("packages_buyed_by_users_id", $this->id)->where("responseCode", 1000)->count();


        if ($invoices > 0) {
            return true;
        } else {
            return false;
        }

    }


    

}
