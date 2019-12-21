<?php

namespace MetodikaTI;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    public function url_for_qr($cfdi_signed)
    {

        $fe = substr($cfdi_signed["@attributes"]["Sello"], (strlen($cfdi_signed["@attributes"]["Sello"]) - 8), 8);

        return "https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?id=" . $cfdi_signed["Complemento"]["TimbreFiscalDigital"]["@attributes"]["UUID"] . "&re=" . $cfdi_signed["Emisor"]["@attributes"]["Rfc"] . "&rr=" . $cfdi_signed["Receptor"]["@attributes"]["Rfc"] . "&tt=" . $cfdi_signed["@attributes"]["Total"] . "&fe=" . $fe;
    }


    public function get_packaged_buyed_by_user()
    {
        return $this->hasOne(PackagesBuyedByUser::class, "id", "packages_buyed_by_users_id");
    }

    

}
