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
      width: 90%;
    }

    .email-table th,
    .email-table td {
      border: 1px solid #ddd;
      padding: 8px;
    }

    .totals,
    .shipping {
      margin-top: 20px;
    }

    ul {
      padding-left: 16px;
    }

    img {
      vertical-align: middle;
      margin-right: 6px;
    }

    h4 {
      margin-bottom: 6px;
    }
  </style>
</head>

<body>
  <div class="center">
    <h3>Estimad@ {{ $usuario['name'] }}</h3>
    <p>Nos complace informarle que su pedido ha sido recibido y está siendo procesado. A continuación, encontrará los detalles de su pedido:</p>
  </div>

  <h4>Detalles del Cliente:</h4>
  <ul>
    <li>Nombre: {{ $usuario['name'] }}</li>
    <li>Correo Electrónico: {{ $usuario['email'] }}</li>
  </ul>

  <h4>Detalles del Pedido:</h4>
  <table class="email-table">
    <thead>
      <tr>
        <th>Código</th>
        <th>Producto</th>
        @if(config('app.caja') == 'si')
        <th>Bulto</th>
        @endif
        <th>Cantidad</th>
        <th>Precio</th>
        <th>IVA</th>
        <th>Recargo</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($itemDetails as $detail)
      <tr>
        <td>{{ $detail['artcod'] }}</td>
        <td>
          @if (array_key_exists('image', $detail))
          <img src="{{ asset('images/articulos/'. $detail['image']) }}" height="48" alt="Producto" />
          @endif
          {{ $detail['name'] ?? 'N/A' }}
        </td>
        @if(config('app.caja') == 'si')
        <td>{{ $detail['cantidad_cajas'] }}</td>
        @endif
        <td>{{ $detail['cantidad_unidades'] }}</td>
        <td>
          {{ \App\Services\FormatoNumeroService::convertirADecimal($detail['price']) }} €
          @if($detail['isOnOffer'])
          <small style="text-decoration: line-through;">
            {{ \App\Services\FormatoNumeroService::convertirADecimal($detail['tarifa']) }} €
          </small>
          @endif
        </td>
        <td>{{ $detail['iva_porcentaje'] }}% - {{ \App\Services\FormatoNumeroService::convertirADecimal($detail['iva']) }} €</td>
        <td>{{ \App\Services\FormatoNumeroService::convertirADecimal($detail['recargo']) }} €</td>
        <td>{{ \App\Services\FormatoNumeroService::convertirADecimal($detail['total'] + $detail['cantidad_unidades'] * ($detail['iva'] + $detail['recargo'])) }} €</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  @if(isset($comentario))
  <h4>Comentarios sobre el pedido:</h4>
  <p>{{ $comentario }}</p>
  @endif

  <h4>Resumen del Pedido:</h4>
  <ul>
    <li>Subtotal: {{ \App\Services\FormatoNumeroService::convertirADecimal($subtotal) }} €</li>
    <li>Total IVA: {{ \App\Services\FormatoNumeroService::convertirADecimal($itemDetails->sum(fn($item) => $item['iva'] * $item['cantidad_unidades'])) }} €</li>
    <li>Total Recargo: {{ \App\Services\FormatoNumeroService::convertirADecimal($itemDetails->sum(fn($item) => $item['recargo'] * $item['cantidad_unidades'])) }} €</li>
    @php
    $totalSinRedondeo = floor(($pedido->total + $itemDetails->sum(fn($item) => $item['recargo'] * $item['cantidad_unidades'])) * 100) / 100;
    @endphp
    <li>Total: {{ number_format($totalSinRedondeo, 2, ',', '.') }} €</li>
  </ul>

  <h4>Dirección de envío:</h4>
  <ul class="shipping">
    <li>Nombre: {{ $pedido->env_nombre }} {{ $pedido->env_apellidos }}</li>
    <li>Dirección: {{ $pedido->env_direccion }}</li>
    <li>Población: {{ $pedido->env_poblacion }}</li>
    <li>País: {{ $pedido->env_pais_txt }}</li>
    <li>Código Postal: {{ $pedido->env_cp }}</li>
    <li>Teléfonos: {{ $pedido->env_tfno_1 }} {{ $pedido->env_tfno_2 }}</li>
  </ul>

  <div class="center">
    <p>Gracias por su compra. Si tiene alguna duda, contáctenos en {{ config('app.telefono') }}.</p>
    <p>Atentamente,</p>
    <p>{{ config('app.name') }}</p>
    <img src="{{ asset(config('app.logo')) }}" height="48" />
    <p>{{ config('mail.cc') }}</p>
    <p>{{ config('app.direccion') }}</p>
  </div>
</body>

@dd($itemDetails, $pedido)

</html>