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
            @if($store_name == "Oxxo")
                Baucher de pago para establecimientos Oxxo
            @elseif($store_name == "7 eleven")
                Baucher de pago para establecimientos 7 eleven
            @elseif($store_name == "Afiliados")
                Baucher de pago para establecimientos Farmacias del ahorro o Benavides
            @elseif($store_name == "Referencia bancaria")
                Baucher de pago para establecimientos BBVA
            @else
                Baucher de pago
            @endif
        </p>
        <br>
        <br>
        <p class="subtitle" style="display: inline-block; margin: 0; font-size: 17px;">{{ $user->business_name }}</p>
        <br>
        <p class="subtitle" style="display: inline-block; margin: 0; font-size: 17px;">
            @if($store_name == "Oxxo")
                Te adjuntamos el baucher de pago para establecimientos Oxxo.
            @elseif($store_name == "7 eleven")
                Te adjuntamos el baucher de pago para establecimientos 7 eleven.
            @elseif($store_name == "Afiliados")
                Te adjuntamos el baucher de pago para establecimientos Farmacias del ahorro o Benavides.
            @elseif($store_name == "Referencia bancaria")
                Te adjuntamos el baucher de pago para referencia bancaria BBVA.
            @else
                Te adjuntamos el baucher de pago.
            @endif
        </p>
        <p class="subtitle" style="display: inline-block; margin: 0; font-size: 17px;">No es necesario imprimir.</p>
        <br>
        <br>
    </div>
</div>


</body>
</html>