<html>
<head></head>
<body>

<table>
    <tr>
        <td>
            <img src="{{ public_path('assets/images/logo_solid.png') }}" class="logo">
            <br>
            <br>
        </td>
    </tr>
    <tr>
        <td style="width: 40%;" class="text-left">
            <p class="business_name">{{ $cfdi_signed["Emisor"]["@attributes"]["Nombre"] }}</p>
            <p>Avenida Eugenio Garza Sada 1892,</p>
            <p>Sin Nombre de Col 42</p>
            <p>Monterrey, 64740, Mexico</p>
            <p>RFC: {{ $cfdi_signed["Emisor"]["@attributes"]["Rfc"] }}</p>
            <p>Regimen fiscal: {{ $cfdi_signed["Emisor"]["@attributes"]["RegimenFiscal"] }}</p>
        </td>
        <td style="width: 20%;"></td>
        <td style="width: 40%;" class="text-left">
            <p>Tipo de comprobante: {{ $cfdi_signed["@attributes"]["TipoDeComprobante"] }}</p>
            <p>Folio: {{ $cfdi_signed["@attributes"]["Folio"] }}</p>
            <p>Serie: {{ $cfdi_signed["@attributes"]["Serie"] }}</p>
            <p>Fecha y hora de emisión: {{ $cfdi_signed["@attributes"]["Fecha"] }}</p>
            <p>Forma de pago: {{ $cfdi_signed["@attributes"]["FormaPago"] }}</p>
            <p>Método de pago: {{ $cfdi_signed["@attributes"]["MetodoPago"] }}</p>
        </td>
    </tr>
    <tr>
        <td class="text-left">
            <br>
            <p class="strong">Receptor:</p>
            <p>{{ $cfdi_signed["Receptor"]["@attributes"]["Nombre"] }}</p>
            <p>RFC: {{ $cfdi_signed["Receptor"]["@attributes"]["Rfc"] }}</p>
            <p>Uso del CFDI: {{ $cfdi_signed["Receptor"]["@attributes"]["UsoCFDI"] }}</p>
        </td>
    </tr>
</table>

<br><br>

<table class="concepts_products">
    <tr>
        <th>Clave de producto-Servicio</th>
        <th>Cantidad</th>
        <th>Descripción</th>
        <th>Valor unitario</th>
        <th>Descuento</th>
        <th>Total</th>
    </tr>
    <tr>
        <td>{{ $cfdi_signed["Conceptos"]["Concepto"]["@attributes"]["ClaveProdServ"] }}</td>
        <td>{{ $cfdi_signed["Conceptos"]["Concepto"]["@attributes"]["Cantidad"] }}</td>
        <td>{{ $cfdi_signed["Conceptos"]["Concepto"]["@attributes"]["Descripcion"] }}</td>
        <td>${{ $cfdi_signed["Conceptos"]["Concepto"]["@attributes"]["ValorUnitario"] }}</td>
        <td>$0.00</td>
        <td>${{ $cfdi_signed["Conceptos"]["Concepto"]["@attributes"]["Importe"] }}</td>
    </tr>
</table>

<br><br>

<table>
    <tr>
        <td class="text-right strong" style="width: 85%;">Subtotal</td>
        <td class="text-right" style="15%;">${{ $cfdi_signed["@attributes"]["SubTotal"] }}</td>
    </tr>
    <tr>
        <td class="text-right strong" style="width: 85%;">IVA</td>
        <td class="text-right" style="15%;">${{ $cfdi_signed["@attributes"]["Total"] - $cfdi_signed["@attributes"]["SubTotal"] }}</td>
    </tr>
    <tr>
        <td class="text-right strong" style="width: 85%;">Total</td>
        <td class="text-right" style="15%;">${{ $cfdi_signed["@attributes"]["Total"] }}</td>
    </tr>
    <tr>
        <td colspan="2" style="width: 100%; font-size: 12px;">
            <br>
            Candidad con letra:<br>
            {{ $price_with_letter }}
        </td>
    </tr>
</table>

<br><br>

<table style="position: absolute; bottom: 260px;">
    <tr>
        <td style="width: 20%; vertical-align: top;" class="text-center">
            <img src="{{ $qr_image }}" style="width: 120px;">
        </td>
        <td style="width: 80%;" class="sellos">
            <p class="strong">Sello digital del CFDI:</p>
            <span style="word-wrap: break-word;">{{ $cfdi_signed["Complemento"]["TimbreFiscalDigital"]["@attributes"]["SelloCFD"] }}</span>
            <p class="strong">Sello del SAT:</p>
            <span style="word-wrap: break-word;">{{ $cfdi_signed["Complemento"]["TimbreFiscalDigital"]["@attributes"]["SelloSAT"] }}</span>
            <p class="strong">Cadena original del complemento de certificación digital del SAT:</p>
            <span style="word-wrap: break-word;">||{{ $cfdi_signed["Complemento"]["TimbreFiscalDigital"]["@attributes"]["Version"] }}|{{ $cfdi_signed["Complemento"]["TimbreFiscalDigital"]["@attributes"]["UUID"] }}|{{ $cfdi_signed["Complemento"]["TimbreFiscalDigital"]["@attributes"]["FechaTimbrado"] }}|{{ $cfdi_signed["Complemento"]["TimbreFiscalDigital"]["@attributes"]["SelloCFD"] }}|{{ $cfdi_signed["Complemento"]["TimbreFiscalDigital"]["@attributes"]["NoCertificadoSAT"] }}||</span>
        </td>
    </tr>
</table>


</body>
</html>

<style>

    * {
        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
    }

    table {
        width: 100%;
    }

    .sellos p, .sellos span {
        width: 100%;
        font-size: 11px;
    }

    .concepts_products {
        border-collapse: collapse;
    }

    .concepts_products th {
        font-size: 11px;
        text-align: center;
        border: 1px solid #4e4e4e;
        background: #e2e2e2;
        padding: 5px;
    }

    .concepts_products td {
        font-size: 11px;
        text-align: center;
        border: 1px solid #4e4e4e;
        padding: 5px;
    }

    .business_name {
        font-weight: bold;
        font-size: 15px;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    p {
        font-size: 12px;
        padding: 0;
        margin: 0;
        vertical-align: top;
    }

    .strong {
        font-weight: bold;
    }

    .logo {
        width: 120px;
    }

</style>