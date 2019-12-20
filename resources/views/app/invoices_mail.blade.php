<html>
<head>
</head>
<body class="email_recover" style="margin: 0; padding: 0; font-family: Arial; background: #f3f3f3;">

<div class="header" style="background: #ffffff; text-align: center; padding: 15px 0;">
    <div class="container" style="display: block; max-width: 650px; width: 100%; margin: 0 auto;">
        <img src="{{ asset('assets/images/logo_solid.png') }}" style="width: 100%; max-width: 120px;"/>
    </div>
</div>

<div class="content" style="width: 100%; display: inline-block; padding: 20px 0;">
    <div class="container" style="display: block; max-width: 650px; width: 100%; margin: 0 auto;">
        <p class="title" style="display: inline-block; margin: 0; font-size: 20px;">
            Factura de Yob
        </p>
        <br>
        <br>
        <p class="subtitle" style="display: inline-block; margin: 0; font-size: 17px;">{{ $invoice->get_packaged_buyed_by_user->get_user["business_name"] }}</p>
        <br>
        <p class="subtitle" style="display: inline-block; margin: 0; font-size: 17px;">
            Adjunto en este correo te hacemos llegar tu Comprobante Fiscal Digital por Internet que corresponde a la compra de "Plan {{ $invoice->get_packaged_buyed_by_user["package_name"] }}" dentro de la APP Yob.
        </p>
        <br>
        <br>
    </div>
</div>


</body>
</html>