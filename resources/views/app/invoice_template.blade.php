<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<cfdi:Comprobante
            Fecha="{{ date("Y-m-d") }}T{{ date("H:i:s") }}" Folio="{{ date("YmdHis") }}-{{ $packages_buyed_by_users->id }}" FormaPago="{{ $packages_buyed_by_users->get_invoice_payment_type() }}"
            LugarExpedicion="64740" MetodoPago="{{ $packages_buyed_by_users->get_invoice_information["payment_method"] }}" Moneda="MXN"
            Serie="AA" SubTotal="{{ number_format($packages_buyed_by_users->get_price_without_iva(), 2, ".", "") }}" TipoDeComprobante="I"
            Total="{{ number_format($packages_buyed_by_users->original_price, 2, ".", "") }}" Version="3.3"
            xmlns:cfdi="http://www.sat.gob.mx/cfd/3"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd">
    <cfdi:Emisor Nombre="Grupo Yob Internacional, S.A. de C.V."
                 RegimenFiscal="601" Rfc="GYI190325PS4"/>
    <cfdi:Receptor Nombre="{{ $packages_buyed_by_users->get_invoice_information["comercial_name"] }}"
                   Rfc="{{ $packages_buyed_by_users->get_invoice_information["rfc"] }}" UsoCFDI="{{ $packages_buyed_by_users->get_invoice_information["cfdi_use"] }}"/>
    <cfdi:Conceptos>
        <cfdi:Concepto Cantidad="1.00" ClaveProdServ="83121700"
                       ClaveUnidad="E48"
                       Unidad="Unidad de servicio"
                       Descripcion="Plan {{ $packages_buyed_by_users->package_name }}"
                       Importe="{{ number_format($packages_buyed_by_users->get_price_without_iva(), 2, ".", "") }}"
                       NoIdentificacion="3"
                       ValorUnitario="{{ number_format($packages_buyed_by_users->get_price_without_iva(), 2, ".", "") }}">
            <cfdi:Impuestos>
                <cfdi:Traslados>
                    <cfdi:Traslado Base="{{ number_format($packages_buyed_by_users->get_price_without_iva(), 2, ".", "") }}"
                                   Importe="{{ number_format($packages_buyed_by_users->get_iva(), 2, ".", "") }}"
                                   Impuesto="002"
                                   TasaOCuota="0.160000"
                                   TipoFactor="Tasa"/>
                </cfdi:Traslados>
            </cfdi:Impuestos>
        </cfdi:Concepto>
    </cfdi:Conceptos>
    <cfdi:Impuestos TotalImpuestosTrasladados="{{ number_format($packages_buyed_by_users->get_iva(), 2, ".", "") }}">
        <cfdi:Traslados>
            <cfdi:Traslado Importe="{{ number_format($packages_buyed_by_users->get_iva(), 2, ".", "") }}"
                           Impuesto="002"
                           TasaOCuota="0.160000"
                           TipoFactor="Tasa"/>
        </cfdi:Traslados>
    </cfdi:Impuestos>
</cfdi:Comprobante>