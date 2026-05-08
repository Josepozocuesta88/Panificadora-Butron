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
  </style>
</head>

<body>
  <div class="center">
    <h3>Estimad@ {{ $user->name }}</h3>
    <p>Nos complace informarle que su pedido ha sido recibido y está siendo procesado. A continuación, encontrará los
      detalles de su pedido:</p>
  </div>
  <h4>Detalles del Cliente:</h4>
  <ul>
    <li>Nombre: {{ $user->name }}</li>
    <li>Correo Electrónico: {{ $user->email }}</li>
  </ul>
  <h4>Detalles del Pedido:</h4>
  <table class="email-table">
    <thead>
      <tr>
        <th>Código</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>IVA</th>
        <th>Recargo</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($lineas as $linea)
      <tr>
        <td>{{ $linea->producto_ref }}</td>
        <td>
          @if ($linea->image)
          <img src="{{ asset('images/articulos/' . $linea->image) }}" height="48" alt="Producto" />
          @endif
          {{ $linea->nombre_articulo }}
        </td>
        <td>{{ $linea->cantidad }}</td>
        <td>{{ number_format($linea->precio, 2) }} €</td>
        <td>{{ number_format($linea->totalIva, 2) }} €</td>
        <td>{{ number_format($linea->recargo, 2) }} €</td>
        <td>{{ number_format($linea->total, 2) }} €</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <h4>Resumen del Pedido:</h4>
  <ul>
    <li>Subtotal: {{ number_format($subtotal, 2) }} €</li>
    <li>Total IVA: {{ number_format($totalIVA, 2) }} €</li>
    <li>Total Recargo: {{ number_format($totalRecargo, 2) }} €</li>
    <li>Total: {{ number_format($total, 2) }} €</li>
  </ul>
  <div class="center">
    <p>Gracias por su compra. Si tiene alguna duda, contáctenos en {{ config('app.telefono') }}.</p>
  </div>
</body>

</html>