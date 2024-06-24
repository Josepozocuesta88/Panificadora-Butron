<!-- ============================================================== -->
<!-- SEGUIMIENTO DE PEDIDOS WEB -->
<!-- ============================================================== -->

@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li>
                        <li class="breadcrumb-item active">Detalles del Pedido</li>
                    </ol>
                </div>
                <h4 class="page-title">Detalles del Pedido</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    @isset($pedido)
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10 col-sm-11">

            <div class="horizontal-steps mt-4 mb-4 pb-5" id="tooltip-container" data-estado={{$pedido->estado}}>
                <div class="horizontal-steps-content">
                    <div class="step-item">
                        <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="20/08/2018 07:24 PM">Pedido Realizado</span>
                    </div>
                    <div class="step-item">
                        <span data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            title="21/08/2018 11:32 AM">Procesando</span>
                    </div>
                    <div class="step-item">
                        <span>Preparado</span>
                    </div>
                    <div class="step-item">
                        <span>Entregado</span>
                    </div>
                </div>

                <div class="process-line" style="width: 0%;"></div>
            </div>
        </div>
    </div>
    <!-- end row -->


    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3"> Productos del pedido #{{ $pedido->id }}</h4>

                    <div class="table-responsive" data-simplebar data-simplebar-primary>
                        <table class="table table-borderless table-nowrap table-centered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    @if(config('app.caja') == 'si')
                                    <th class="px-0">Bulto</th>
                                    <th>Tipo</th>
                                    @endif
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                <tr>
                                    <!-- producto -->
                                    <td>
                                        @if ($item['image'])
                                        <img src="{{ asset('images/articulos/'. $item['image'] ) }}" alt="img"
                                            class="rounded me-2" height="48" />
                                        @else
                                        <img src="{{ asset('images/articulos/noimage.jpg') }}" alt="img"
                                            class="rounded me-2" height="48" />
                                        @endif

                                        <p class="m-0 d-inline-block align-middle" style="max-width: 150px;">
                                            <a href="{{route('info', ['artcod' => $item['producto_ref']])}}"
                                                class="text-body fw-semibold">{{ $item['nombre_articulo'] }}</a>
                                        </p>
                                    </td>

                                    @if(config('app.caja') == 'si')
                                    <!-- bulto -->
                                    <td class="px-0">
                                        {{ $item['aclcancaj'] }}
                                    </td>

                                    <!-- tipo -->
                                    <td>
                                        @if($item['aclcajcod'] == '0001')
                                        Caja
                                        @elseif($item['aclcajcod'] == '0002')
                                        Media
                                        @else
                                        Pieza
                                        @endif

                                    </td>
                                    @endif
                                    <!-- cantidad ud -->
                                    <td class="pe-0">
                                        {{ $item['cantidad'] }}
                                    </td>
                                    <!-- precio -->
                                    <td>
                                        {{ \App\Services\FormatoNumeroService::convertirADecimal($item['precio']) }} €
                                    </td>
                                    <!-- total -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Resumen del Pedido</h4>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td>Subtotal :</td>
                                    <td class="ps-0">
                                        {{ \App\Services\FormatoNumeroService::convertirADecimal($pedido->subtotal) }} €
                                    </td>
                                </tr>

                                <tr>
                                    <td>Gastos de envío :</td>
                                    <td class="ps-0">
                                        {{ \App\Services\FormatoNumeroService::convertirADecimal(0) }} €
                                    </td>
                                </tr>

                                <tr>
                                    <th>Total :</th>
                                    <th class="ps-0">
                                        {{ \App\Services\FormatoNumeroService::convertirADecimal($pedido->total) }}
                                        €</th>
                                </tr>

                                <tr>
                                    <th>( Impuestos no incluidos )</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->

                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->


    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Información del Cliente</h4>

                    <h5>{{ $user->name }}</h5>

                    <address class="mb-0 font-14 address-lg">
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br>
                        <abbr title="Phone">Teléfono:</abbr> (123) 456-7890 <br />
                        <abbr title="email">Mail:</abbr> {{ $user->email }}
                    </address>

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Información de la Empresa</h4>

                    <h5>{{ config('app.name') }}</h5>

                    <address class="mb-0 font-14 address-lg">
                        {{ config('app.direccion') }}<br>
                        <abbr title="Phone">Teléfono:</abbr> {{ config('app.telefono') }}<br />
                        <abbr title="email">Mail:</abbr> {{ config('mail.cc') }}
                    </address>

                </div>
            </div>
        </div> <!-- end col -->


        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">

                    <table id="tablaPedidos" class="table table-centered w-100 dt-responsive nowrap">
                        <thead class="table-light">
                            TODOS LOS PEDIDOS
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->
    @else
    <div class="alert alert-primary container text-center" role="alert">
        <i class="ri-information-line me-1 align-middle font-22"></i>
        <strong>{{ $message }}</strong>
    </div>
    @endisset
</div> <!-- container -->

@endsection


@push('scripts')
<script src="{{ asset('js/Ajax/order.js') }}"></script>
@endpush