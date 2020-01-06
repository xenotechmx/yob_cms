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
        <p class="title" style="display: inline-block; margin: 0; font-size: 20px;">¡Bienvenido a Yob!</p>
        <br>
        <br>
        <p class="subtitle" style="display: inline-block; margin: 0; font-size: 17px;">Hola {{ $user->business_name }}</p>
        <br>
        <p class="subtitle" style="display: inline-block; margin: 0; font-size: 17px;">Te compartimos la información de tu cuenta de acceso a la APP Yob:</p>
        <br>
        <br>
        <p class="label" style="display: inline-block; margin: 0; font-size: 16px;"><strong>Correo electrónico:</strong> {{ $user->email }}</p>
        <br>
        <p class="label" style="display: inline-block; margin: 0; font-size: 16px;"><strong>Contraseña:</strong> {{ $nueva_contrasena }}</p>
        <br>
        <br>
        <p class="subtitle" style="display: inline-block; margin: 0; font-size: 17px;">Usa el siguiente código QR en tus publicaciones físicas de empleo para que los usuarios de Yob desde la APP puedan ver y postularse a tus vacantes publicadas:</p>
        <br>
        <br>
        <img src="{{ url($user->qr_path) }}" style="width: 100%; display: block; max-width: 220px; margin: 0 auto;">

    </div>
</div>


</body>
</html>