<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura disponible</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 620px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
            padding: 30px;
        }

        .logo img {
            max-height: 100px;
        }

        .content {
            font-size: 14px;
            line-height: 1.6;
        }

        .content h2 {
            color: #0071bc;
        }

        .button {
            display: inline-block;
            padding: 10px 18px;
            margin: 10px 10px 0 0;
            text-decoration: none;
            color: #0071bc;
            border: 2px solid #0071bc;
            border-radius: 8px;
            background-color: #fff;
            font-weight: bold;
        }

        .btn-sign {
            background-color: #d9534f;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ccc;
            padding-top: 15px;
        }

        .footer a {
            color: #0071bc;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="logo">
            <img src="https://gabinetetic.com/public/images/web/PN-GabineteLogo.png" alt="Redes y Componentes Logo" />
        </div>

        <div class="content">
            <p>
                <strong>Redes y Componentes, S.L.,</strong>
                ya dispone de su factura
                <strong>{{$documento->doccon}}</strong>
                para
                <strong>{{$user->name}}</strong>.
            </p>

            <p>Estimado Cliente,</p>

            <p>Podrá encontrar como documento entrando en el QCloud principal o pulsando en "ver documento".</p>

            <p>Un saludo y gracias por confiar en Redes y Componentes SL.</p>

            <p><strong>Jose Manuel Pozo Cuesta</strong></p>

            <a href="{{$link}}" class="button">Ver documento</a>
        </div>

        <div class="footer">
            <p><strong>Qanet | Redes y Componentes SL.</strong><br>
                Av. de la Estación, 25, Bajo<br>
                14500 Puente Genil<br>
                Córdoba<br>
            </p>

            <p>En cumplimiento del Reglamento General de Protección de Datos, le informamos que puede ejercer sus derechos en cualquier momento. Lea nuestra
                <a href="#">Política de privacidad</a> y <a href="#">Términos legales</a>.
            </p>

        </div>
    </div>

</body>

</html>