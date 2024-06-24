<!DOCTYPE html>
<html>

<head>
    <title>Pedido procesado</title>
    <style>
    .center {
        text-align: center;
    }

    .email-table {
        margin: 0 auto;
        border-collapse: collapse;
    }

    .email-table th,
    .email-table td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .totals {
        text-align: left;
        margin-top: 20px;
    }

    .line {
        text-decoration: line-through;
    }
    .text-decoration-line-through{
        text-decoration: line-through;
    }
    </style>
</head>

<body>
    <div class="center">
        <h3>Estimad@ {{ $usuario['name'] }}</h3>
        <p>Nos complace informarle que su pedido ha sido recibido y está siendo procesado. A continuación, encontrará
            los detalles de su pedido:</p>
    </div>
    <h4>Detalles del Cliente:</h4>
    <ul>
        <li>Nombre: {{ $usuario['name'] }}</li>
        <li>Correo Electrónico: {{ $usuario['email'] }}</li>
    </ul>
    <br>
    <h4>Detalles del Pedido:</h4>
    <table class="email-table">
        <thead>
            <tr>
                <th>Código de Artículo</th>
                <th>Nombre</th>
                @if(config('app.caja') == 'si')
                <th>Bulto</th>
                @endif
                <th>Cantidad Uds.</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($itemDetails as $detail)
            <tr>

                <td>{{ $detail['artcod'] }}</td>

                <td>
                    @if (array_key_exists('image', $detail))
                    <img src="{{ asset('images/articulos/'. $detail['image'] ) }}" height="48"
                        style="margin-right: 8px;" />
                    @endif
                    {{ $detail['name'] ??  'N/A' }}
                </td>
                @if(config('app.caja') == 'si')
                <td style="text-align: right;">{{ $detail['cantidad_cajas'] }}</td>
                @endif
                <td style="text-align: right;">{{ $detail['cantidad_unidades'] }}</td>

                <td style="text-align: right;">
                    {{ \App\Services\FormatoNumeroService::convertirADecimal($detail['price']) }} €
                    @if($detail['isOnOffer'])
                    <small class="text-decoration-line-through">{{ \App\Services\FormatoNumeroService::convertirADecimal($detail['tarifa']) }}
                        €</small>
                    @endif
                </td>

                <td style="text-align: right;">{{ \App\Services\FormatoNumeroService::convertirADecimal($detail['total']) }} €</td>

            </tr>
            @endforeach

        </tbody>
    </table>
    <br>

    @if(isset($comentario))
        <div class="comentario">
            <h4>Comentarios sobre el pedido:</h4>
            <p>{{ $comentario }}</p>
        </div>
    @endif
    <br>

    <div class="totals">
        <h4>Resumen del Pedido:</h4>
        <p>Subtotal: {{ $subtotal }} €</p>
        <p>Total: {{ $total }} €</p>
    </div>
    <br>

    <div class="center">
        <p>
            Si tiene alguna pregunta o necesita asistencia adicional, no dude en ponerse en contacto con nosotros
            llamando al {{ config('app.telefono') }}.
        </p>
        <p>¡Gracias por comprar con nosotros!</p>
        <p>Atentamente,</p>
        <p>{{ config('app.name') }}</p>
        <p><img src="{{ asset(config('app.logo')) }}" height="48" /></p>
        <p>{{ config('mail.cc') }}</p>
        <p>{{ config('app.telefono') }}</p>
        <p>{{ config('app.direccion') }}</p>
    </div>

</body>

</html>