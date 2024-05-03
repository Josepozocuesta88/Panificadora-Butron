<!DOCTYPE html>
<html>

<head>
    <title>Pedido procesado</title>
    <style>
    .email-container {
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
    </style>
</head>

<body>
    <div class="email-container">
        <h2>¡Tu pedido ha sido procesado!</h2>
        <p>Gracias por tu compra. Aquí están los detalles de tu pedido:</p>
        <table class="email-table">
            <thead>
                <tr>
                    <th>Código de Artículo</th>
                    <th>Nombre</th>
                    <th>Bulto</th>
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
                        <img src="{{ asset('images/articulos/'. $detail['image'] ) }}" height="48" style="margin-right: 8px;"/>
                        @endif
                        {{ $detail['artnom'] ?? 'N/A' }}
                    </td>
                    
                    <td>{{ $detail['cantidad_cajas'] }}</td>

                    <td>{{ $detail['cantidad_unidades'] }}</td>

                    <td>  
                        {{ $detail['price'] }} €
                        @if($detail['tarifa'] !== null )
                        <small class="line">{{ $detail['tarifa'] }} €</small>
                        @endif
                    </td>

                    <td>{{ $detail['total'] }} €</td>

                </tr>
                @endforeach

            </tbody>
        </table>
        <div class="totals">
            <p>Subtotal: {{ $subtotal }} €</p>
            <p>Total: {{ $total }} €</p>
        </div>
    </div>
</body>

</html>