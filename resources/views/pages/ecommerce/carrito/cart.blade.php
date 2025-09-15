@php
use App\Models\QanetParametro2;
$minSubtotal = QanetParametro2::where('connom', 'QCLOUDVENTAMINIMA')->first();
@endphp
@extends('layouts.app')

@section('content')
<style>
  .direccion-card.selected {
    border: 2px solid #007bff;
  }

  @keyframes moverLadoALado {
    0% {
      transform: rotate(0deg);
    }

    25% {
      transform: rotate(10deg);
    }

    50% {
      transform: rotate(-10deg);
    }

    75% {
      transform: rotate(10deg);
    }

    100% {
      transform: rotate(0deg);
    }
  }

  @keyframes pulseBorder {
    0% {
      box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
      /* verde */
      border-color: #28a745;
    }

    70% {
      box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
      /* verde */
      border-color: #218838;
    }

    100% {
      box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
      border-color: #28a745;
    }
  }

  .border-animation {
    display: inline-block;
    animation: pulseBorder 1s ease-in-out infinite;
  }

  .icono-animated {
    display: inline-block;
    animation: moverLadoALado 1s ease-in-out infinite;
  }

  .direccion-card.selected {
    border: 2px solid #007bff;
  }



  /* terminos y condiciones modal */
  /* Estilo checkbox + texto */
  .terms-container {
    background: #f5f5f5;
    padding: 12px;
    border-radius: 4px;
    margin: 15px 0;
    font-size: 14px;
  }

  .terms-container a {
    color: #000;
    text-decoration: underline;
  }

  .required {
    color: red;
  }

  /* Botón principal */
  .pedido-btn {
    background: #000;
    color: #fff;
    width: 100%;
    padding: 14px;
    text-transform: uppercase;
    font-weight: bold;
    border: none;
    cursor: pointer;
    display: block;
    margin-top: 10px;
    border-radius: 4px;
  }

  .pedido-btn:hover {
    background: #333;
  }

  /* Botón cancelar */
  .cancel-btn {
    background: #ddd;
    color: #000;
    width: 100%;
    padding: 12px;
    border: none;
    margin-top: 10px;
    cursor: pointer;
    border-radius: 4px;
  }

  .cancel-btn:hover {
    background: #bbb;
  }

  /* Modal base */
  .modal {
    display: none;
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
  }

  /* Contenido modal */
  .modal-content {
    background: #fff;
    width: 500px;
    max-width: 90%;
    margin: 8% auto;
    padding: 25px 30px;
    border-radius: 8px;
    position: relative;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    animation: fadeIn 0.3s ease-in-out;
    text-align: center;
  }

  /* Título */
  .modal-content h2 {
    margin-top: 0;
    font-size: 22px;
    font-weight: bold;
  }

  .subtitle {
    font-size: 14px;
    color: #555;
    margin-bottom: 15px;
  }

  /* Botón cerrar */
  .close-btn {
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 24px;
    cursor: pointer;
    color: #999;
  }

  .close-btn:hover {
    color: #000;
  }

  /* Contenedor de botones */
  .modal-actions {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    margin-top: 20px;
  }

  /* Botón aceptar */
  .modal-actions .pedido-btn {
    flex: 1;
  }

  /* Botón cancelar */
  .modal-actions .cancel-btn {
    flex: 1;
  }


  /* Animación */
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="page-title-box">
          <div class="page-title-right">
            <ol class="m-0 breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{ route('search') }}">Productos</a></li>
              <li class="breadcrumb-item active">Carrito de Compras</li>
            </ol>
          </div>
          <h4 class="page-title">Carrito de Compras</h4>
        </div>
        @if(Auth::user()->usudiareparto !== null)
        <div class="alert alert-info text-center mb-0">
          Día de reparto habitual: {{ Auth::user()->usudiareparto }}
        </div>
        @endif
        @if(isset($subtotal) && $minSubtotal->condoble !== null)
        <div>
          Para poder realizar el pedido, el importe debe ser de un mínimo de: {{ $minSubtotal->condoble }} €
          (Base imponible)
        </div>
        @endif
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        @if (session('success') || session('error'))
        <!-- <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 1050;">
          <div class="toast show bg-primary" data-bs-delay="5000">
            <div class="toast-header">
              <strong class="mr-auto text-primary">Alerta</strong>
              <button type="button" class="m-auto btn-close me-2" data-bs-dismiss="toast" aria-label="Cerrar"></button>
            </div>
            <div class="text-white toast-body">
              {{ session('success') ?? session('error') }}
            </div>
          </div>
        </div> -->
        @endif

        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-xl-9">
                @if (isset($message))
                <div class="alert alert-dark" role="alert">
                  <h5>{{ $message }}</h5>
                </div>
                @else
                <div class="table-responsive" data-simplebar data-simplebar-primary>
                  <table class="table mb-0 table-borderless table-nowrap table-centered">
                    <thead class="table-light">
                      <tr>
                        <th>Producto</th>
                        @if (config('app.caja') == 'si')
                        <th class="px-0">Bulto</th>
                        <th>Tipo</th>
                        @endif
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th>Eliminar</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($items as $item)
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            @if ($item['image'])
                            <img src="{{ asset('images/articulos/' . $item['image']) }}" alt="img" class="rounded me-2 tw-h-12" height="48" />
                            @else
                            <img src="{{ asset('images/articulos/noimage.jpg') }}" alt="img" class="rounded me-2 tw-h-12" height="48" />
                            @endif
                            <p class="m-0 align-middle d-inline-block text-truncate" style="max-width: 150px;">
                              <a href="{{ route('info', ['artcod' => $item['artcod']]) }}" class="text-body fw-semibold">{{ $item['name'] }}</a>
                              <br>
                              <small>{{ $item['cantidad_unidades'] }} x {{ $item['price'] }}</small>
                            </p>
                          </div>
                        </td>

                        <td class="px-0">
                          <div class="">
                            <input type="number" class="quantity-update box_quantity form-control" name="box_quantity"
                              min="1" data-cartcod="{{ $item['cartcod'] }}" data-update-type=""
                              value="{{ $item['cantidad_cajas'] }}" style="width: 80px;">
                          </div>
                        </td>
                        @if (config('app.caja') == 'si')
                        <td>
                          <select class="tipoCajaSelect form-select" data-cartcod="{{ $item['cartcod'] }}"
                            data-artcod="{{ $item['artcod'] }}" data-cajcod="{{ $item['cajcod'] }}"
                            data-cartcant="{{ $item['cantidad_cajas'] }}"></select>
                        </td>
                        <td class="pe-0">
                          <div class="d-flex align-items-center justify-content-start">
                            <input type="number" class="form-control me-1" disabled
                              data-cartcod="{{ $item['cartcod'] }}" name="ud_quantity" min="1"
                              value="{{ $item['cantidad_unidades'] }}" style="width:90px;">
                            <label for="unit-quantity-input" class="mb-0 quantity-update">{{ $item['promedcod'] }}</label>
                          </div>
                        </td>
                        @endif
                        <td>
                          {{ \App\Services\FormatoNumeroService::convertirADecimal($item['price']) }} €
                          @if (Auth::user()->usudistribuidor !== 1 && $item['isOnOffer'])
                          <small class="text-decoration-line-through">
                            {{ \App\Services\FormatoNumeroService::convertirADecimal($item['tarifa']) }} €
                          </small>
                          @endif
                        </td>
                        <td>
                          {{ \App\Services\FormatoNumeroService::convertirADecimal($item['total']) }} €
                        </td>
                        <td>
                          <form method="POST" id="removeItem" action="{{ route('cart.removeItem', ['artcod' => $item['artcod']]) }}">
                            @csrf
                            <input type="hidden" name="artcod" value="{{ $item['artcod'] }}">
                            <button type="submit" class="remove-item action-icon btn btn-white">
                              <i class="mdi mdi-delete text-primary font-22"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>

                <div class="mt-5">
                  <div class="mb-3 h4">Selecciona los datos de envío</div>
                  <div id="direcciones" class="row">
                    @foreach ($direcciones as $direccion)
                    <div class="mb-1 col-11 col-md-5 col-lg-4">
                      <div class="card direccion-card {{ $loop->first ? 'selected' : '' }}" data-direccion-id="{{ $direccion->dirid }}">
                        <div class="card-body">
                          <p class="card-text">
                            <strong>Nombre:</strong>
                            {{ $direccion->dirnom }}<br>
                            <strong>Apellidos:</strong>
                            {{ $direccion->dirape }}<br>
                            <strong>Dirección:</strong>
                            {{ $direccion->dirdir }}<br>
                            <strong>Población:</strong>
                            {{ $direccion->dirpob }}<br>
                            <strong>País:</strong>
                            {{ $direccion->dirpai }}<br>
                            <strong>Código Postal:</strong>
                            {{ $direccion->dircp }}<br>
                            <strong>Teléfono:</strong>
                            {{ $direccion->dirtfno1 }}<br>
                          </p>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>

                <div class="mt-3">
                  <label for="comentario" class="form-label">Añadir un comentario:</label>
                  <textarea
                    class="form-control"
                    id="comentario"
                    rows="3"
                    placeholder="Este campo es opcional, puedes escribir algún comentario si lo deseas..">
                  {{ session('comentario') }}
                  </textarea>
                </div>

                <div class="mt-4 row">
                  <div class="col-sm-12">
                    <div class="text-sm-end">
                      <a onclick="window.location.href='/articles/search?query=';" class="btn btn-info">
                        <i class="mdi mdi-arrow-left"></i> Continuar comprando
                      </a>
                      @if($minSubtotal->condoble === null || $subtotal >= $minSubtotal->condoble)
                      <button class="btn btn-danger" id="procesarPedido">
                        <i class="mdi mdi-cart-plus me-1"></i> Procesar el pedido
                      </button>
                      @endif
                    </div>
                  </div>
                </div>

              </div>
              <div class="mt-4 col-lg-12 col-xl-3 mt-xl-0">

                <!-- para el descuento especial -->
                {{-- @if(!$descuento)
                <div class="alert alert-success border-animation" role="alert">
                  <i class="bi bi-gift me-1 align-middle font-20 icono-animated"></i>
                  ¡Felicidades! tiene un descuento de <strong>5%</strong> para su compra.
                </div>
                @endif --}}
                <!-- fin del descuento especial -->

                <div class="p-3 border rounded">
                  <h4 class="mb-3 header-title">Detalles del pedido</h4>
                  <div class="table-responsive">
                    <table class="table mb-0">
                      <tbody>
                        <tr>
                          <!-- para descuento especial -->
                          {{-- @if($descuento)
                          <td>Subtotal :</td>
                          @else
                          <td>Subtotal + Descuento (5%):</td>
                          @endif
                          --}}
                          <!-- fin del descuento especial -->

                          <td>Subtotal :</td>
                          <td class="ps-0">
                            {{ \App\Services\FormatoNumeroService::convertirADecimal($subtotal) }} €
                          </td>
                        </tr>
                        <tr>
                          <td>Descuento: </td>
                          <td class="ps-0"> {{ $user->usudes1 !== 0 ? $user->usudes1 : 0 }} % </td>
                        </tr>
                        <tr>
                          <td>Gastos de envío :</td>
                          <td class="ps-0">
                            {{ \App\Services\FormatoNumeroService::convertirADecimal($shippingCost) }} €
                          </td>
                        </tr>
                        <tr>
                          <td>Total IVA :</td>
                          <td class="ps-0">
                            {{ \App\Services\FormatoNumeroService::convertirADecimal($artivapor) }} €
                          </td>
                        </tr>
                        <tr>
                          <td>Total Recargo :</td>
                          <td class="ps-0" id="td-recargo" data-recargo="{{ $artrecpor }}">
                            {{ \App\Services\FormatoNumeroService::convertirADecimal($artrecpor) }} €
                          </td>
                        </tr>
                        @if ($artsigimp > 0)
                        <tr>
                          <td>Impuesto eliminación de residuos :</td>
                          <td class="ps-0">
                            {{ \App\Services\FormatoNumeroService::convertirADecimal($artsigimp) }} €
                          </td>
                        </tr>
                        @endif
                        <tr>
                          <th>Total:</th>
                          <th class="ps-0">
                            {{ \App\Services\FormatoNumeroService::convertirADecimal($total) }} €
                          </th>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  @endif
                </div>

                <div class="mt-3 alert alert-warning" role="alert">
                  ¡ Usa tus <strong>{{ config('app.points') }}</strong> para tener el x% de descuento!
                </div>
                <div class="mt-3 input-group">
                  <input type="text" class="form-control" placeholder="Inserta el código de cupón"
                    aria-label="Recipient's username">
                  <button class="input-group-text btn-light" type="button">Aplicar</button>
                </div>
                <div class="gap-2 mt-3 d-grid">
                  <a href="{{ route('all.points') }}" class="btn btn-warning text-body fw-bold">
                    <i class="bi bi-coin me-1"></i> Ver mis cupones
                  </a>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Termino y condiciones -->
<!-- Modal -->
<div id="termsModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" id="closeModal">&times;</span>
    <h2>Términos y Condiciones</h2>
    <p class="subtitle">Por favor, revisa y acepta los términos antes de continuar con tu pedido.</p>
    <div class="terms-container">
      <label>
        <input type="checkbox" id="modalTermsCheckbox">
        He leído y estoy de acuerdo con los
        <a href="/terminos-condiciones" target="_blank">términos y condiciones</a>
        de la web <span class="required">*</span>
      </label>
    </div>
    <div class="modal-actions">
      <button id="acceptTerms" class="pedido-btn">ACEPTAR Y CONTINUAR</button>
      <button id="cancelModal" class="cancel-btn">CANCELAR</button>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.direccion-card');
    cards.forEach(card => {
      card.addEventListener('click', function() {
        cards.forEach(c => c.classList.remove('selected'));
        this.classList.add('selected');
      });
    });

    // verifica si se aceptaron los términos
    if (getTerms('termsAccepted') === 'true') {
      document.getElementById('modalTermsCheckbox').checked = true;
    }

  });

  // Guardar cookie
  function setTerms(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
  }

  // Obtener cookie
  function getTerms(name) {
    let cname = name + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i].trim();
      if (c.indexOf(cname) === 0) {
        return c.substring(cname.length, c.length);
      }
    }
    return "";
  }

  const modal = document.getElementById('termsModal');
  const closeModal = document.getElementById('closeModal');

  document.getElementById('procesarPedido').addEventListener('click', function(event) {
    event.preventDefault();

    const selectedCard = document.querySelector('.direccion-card.selected');
    if (!selectedCard) {
      alert("Por favor, selecciona una dirección de envío.");
      return;
    }

    const termsCheckbox = document.getElementById('modalTermsCheckbox');
    if (!termsCheckbox || !termsCheckbox.checked) {
      modal.style.display = 'block'; // abrir modal
      return;
    }

    procesarPedido();
  });

  document.getElementById('acceptTerms').addEventListener('click', function() {
    const modalTermsCheckbox = document.getElementById('modalTermsCheckbox');
    if (!modalTermsCheckbox.checked) {
      alert("Debes aceptar los términos y condiciones.");
      return;
    }

    document.getElementById('modalTermsCheckbox').checked = true;
    modal.style.display = 'none';

    setTerms('termsAccepted', 'true', 365); // dura 1 año
    procesarPedido();
  });

  document.getElementById('cancelModal').addEventListener('click', function() {
    modal.style.display = 'none';
  });

  closeModal.addEventListener('click', function() {
    modal.style.display = 'none';
  });

  // Cerrar si se hace clic fuera del modal
  window.addEventListener('click', function(event) {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  });

  function procesarPedido() {
    const direccionId = document.querySelector('.direccion-card.selected').getAttribute('data-direccion-id');
    const comentario = document.getElementById('comentario').value;
    const recargoValue = document.getElementById('td-recargo').getAttribute('data-recargo');

    const formData = new FormData();
    formData.append('direccionId', direccionId);
    formData.append('comentario', comentario);
    formData.append('recargo', recargoValue);

    fetch('/order', {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
      })
      .then(response => {
        if (response.ok) {
          window.location.href = `/order/ok`;
        } else {
          alert("Error al procesar el pedido.");
        }
      })
      .catch(() => {
        alert("Error en la conexión con el servidor.");
      });
  }

  function showToast(message) {
    const toastContainer = document.createElement('div');
    toastContainer.setAttribute('aria-live', 'polite');
    toastContainer.setAttribute('aria-atomic', 'true');
    toastContainer.style.position = 'fixed';
    toastContainer.style.top = '20px';
    toastContainer.style.right = '20px';
    toastContainer.style.zIndex = '1050';

    const toast = document.createElement('div');
    toast.classList.add('toast', 'show', 'bg-primary');
    toast.setAttribute('data-bs-delay', '5000');

    const toastHeader = document.createElement('div');
    toastHeader.classList.add('toast-header');

    const strong = document.createElement('strong');
    strong.classList.add('mr-auto', 'text-primary');
    strong.innerText = 'Alerta';

    const button = document.createElement('button');
    button.type = 'button';
    button.classList.add('btn-close', 'me-2', 'm-auto');
    button.setAttribute('data-bs-dismiss', 'toast');
    button.setAttribute('aria-label', 'Cerrar');

    const toastBody = document.createElement('div');
    toastBody.classList.add('toast-body', 'text-white');
    toastBody.innerText = message;

    toastHeader.appendChild(strong);
    toastHeader.appendChild(button);
    toast.appendChild(toastHeader);
    toast.appendChild(toastBody);
    toastContainer.appendChild(toast);

    document.body.appendChild(toastContainer);

    setTimeout(() => {
      toast.classList.remove('show');
      document.body.removeChild(toastContainer);
    }, 5000);
  }
</script>

@endsection