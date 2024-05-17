<!-- ======================================================================================= -->
<!-- CLIENTE o TODOS: Carrito de compra -->
<!-- ======================================================================================= -->

@extends('layouts.app')

@section('content')
<div class="content">

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('search') }}">Productos</a></li>
                            <li class="breadcrumb-item active">Carrito de Compras</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Carrito de Compras</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                @if (session('success') || session('error'))
                <div aria-live="polite" aria-atomic="true"
                    style="position: fixed; top: 20px; right: 20px; z-index: 1050;">
                    <div class="toast show bg-primary" data-bs-delay="5000">
                        <div class="toast-header">
                            <strong class="mr-auto text-primary">Alerta</strong>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="toast-body text-white">
                            {{ session('success') ?? session('error') }}
                        </div>
                    </div>
                </div>
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
                                    <table class="table table-borderless table-nowrap table-centered mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Producto</th>
                                                <th class="px-0">Bulto</th>
                                                <th>Tipo</th>
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                                <th>Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                            <tr>
                                                <!-- producto -->
                                                <td>
                                                    @if ($item['image'])
                                                    <img src="{{ asset('images/articulos/'. $item['image'] ) }}"
                                                        alt="img" class="rounded me-2" height="48" />
                                                    @else
                                                    <img src="{{ asset('images/articulos/noimage.jpg') }}" alt="img"
                                                        class="rounded me-2" height="48" />
                                                    @endif

                                                    <p class="m-0 d-inline-block align-middle text-truncate"
                                                        style="max-width: 150px;">
                                                        <a href="{{route('info', ['artcod' => $item['artcod']])}}"
                                                            class="text-body fw-semibold">{{ $item['name'] }}</a>
                                                        <br>
                                                        <small>{{ $item['cantidad_unidades'] }} x
                                                            {{ $item['price'] }}</small>
                                                    </p>
                                                </td>

                                                <!-- bulto -->
                                                <td class="px-0">
                                                    <!-- Campo para la cantidad de cajas -->
                                                    <div class="">
                                                        <input type="number"
                                                            class="quantity-update box_quantity form-control"
                                                            name="box_quantity" min="1"
                                                            data-cartcod="{{ $item['cartcod'] }}" data-update-type=""
                                                            value="{{ $item['cantidad_cajas'] }}" style="width: 80px;">
                                                    </div>
                                                </td>

                                                <!-- tipo -->
                                                <td>
                                                    <select class="tipoCajaSelect form-select"
                                                        data-cartcod="{{ $item['cartcod'] }}"
                                                        data-artcod="{{ $item['artcod'] }}"
                                                        data-cajcod="{{ $item['cajcod'] }}"
                                                        data-cartcant="{{ $item['cantidad_cajas'] }}">
                                                    </select>
                                                </td>
                                                <!-- cantidad ud -->
                                                <td class="pe-0">
                                                    <div class="d-flex align-items-center justify-content-start">
                                                        <input type="number" class="form-control me-1" disabled
                                                            data-cartcod="{{ $item['cartcod'] }}" name="ud_quantity"
                                                            min="1" value="{{ $item['cantidad_unidades'] }}"
                                                            style="width:90px;">
                                                        <label for="unit-quantity-input"
                                                            class="quantity-update mb-0">{{ $item['promedcod'] }}</label>
                                                    </div>
                                                </td>

                                                <td>
                                                    {{ $item['price'] }} €
                                                    @if($item['isOnOffer'])
                                                    <small class="text-decoration-line-through">{{ $item['tarifa'] }}
                                                        €</small>
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $item['total'] }} €
                                                </td>
                                                <td>
                                                    <form method="POST" id="removeItem"
                                                        action="{{route('cart.removeItem', ['artcod' => $item['artcod']])}}">
                                                        @csrf
                                                        <input type="hidden" name="artcod"
                                                            value="{{ $item['artcod'] }}">
                                                        <button type="submit"
                                                            class="remove-item action-icon btn btn-white">
                                                            <i class="mdi mdi-delete text-primary font-22"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive-->

                                <!-- Add note input-->
                                <div class="mt-3">
                                    <label for="example-textarea" class="form-label">Añadir un comentario:</label>
                                    <textarea class="form-control" id="example-textarea" rows="3"
                                        placeholder="Este campo es opcional, puedes escribir algún comentario si lo deseas.."></textarea>
                                </div>

                                <!-- action buttons-->
                                <div class="row mt-4">
                                    <div class="col-sm-6">
                                        <a onclick="window.location.href='/articles/search?query=';"
                                            class="btn text-muted d-none d-sm-inline-block btn-link fw-semibold">
                                            <i class="mdi mdi-arrow-left"></i> Continuar comprando </a>
                                    </div> <!-- end col -->
                                    <div class="col-sm-6">
                                        <div class="text-sm-end">
                                            <a href="{{route('makeOrder')}}" class="btn btn-danger">
                                                <i class="mdi mdi-cart-plus me-1"></i> Procesar el pedido </a>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row-->
                                @endif
                            </div>
                            <div class="col-lg-12 col-xl-3 mt-4 mt-xl-0">
                                <div class="border p-3 rounded">
                                    <h4 class="header-title mb-3">Detalles del pedido</h4>

                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                                <tr>
                                                    <td>Subtotal :</td>
                                                    <td class="ps-0">{{ number_format($subtotal, 2) }} €</td>
                                                </tr>
                                                <tr>
                                                    <td>Descuento: </td>
                                                    <td class="ps-0">- X €</td>
                                                </tr>
                                                <tr>
                                                    <td>Gastos de envío :</td>
                                                    <td class="ps-0">{{ number_format($shippingCost, 2) }} €</td>
                                                </tr>
                                                <tr>
                                                    <th>Total :</th>
                                                    <th class="ps-0">{{ number_format($total, 2) }} €</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="alert alert-warning mt-3" role="alert">
                                    ¡ Usa tus <strong>{{ config('app.points') }}</strong> para tener el x% de descuento!
                                </div>

                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Inserta el código de cupón"
                                        aria-label="Recipient's username">
                                    <button class="input-group-text btn-light" type="button">Aplicar</button>
                                </div>
                            </div> <!-- end col -->
                        </div>

                        <!-- end col -->
                    </div> <!-- end row -->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->

@endsection