<!-- ======================================================================================= -->
<!-- CLIENTE o TODOS: Seccion para detalles del producto (boton de ver más de cada producto) -->
<!-- ======================================================================================= -->

@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('search') }}">Productos</a></li>

                        <!-- <li class="breadcrumb-item"><a href="{{ session('last_page_url') }}">Volver a:
                                    {{ session('last_page_name') }}</a></li> -->

                        <li class="breadcrumb-item active">Detalles del Producto</li>
                    </ol>
                </div>
                <h4 class="page-title">Detalles del Producto</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        @if(session('success') || session('error'))
        <div class="alert alert-{{ session('success') ? 'success' : 'danger' }}">
            {{ session('success') ?: session('error') }}
        </div>
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-lg-6">
                            <!-- Product image -->
                            <!-- Botón o enlace que activa el modal -->
                            <a href="javascript:void(0);" class="text-center d-block mb-4" data-bs-toggle="modal"
                                data-bs-target="#miModal">
                                <img src="{{ asset('images/articulos/' . $articulo->primeraImagen()) }}"
                                    class="img-fluid" style="max-width: 280px;" alt="Product-img" id="mainImage"
                                    onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';" />
                            </a>

                            <!-- Modal -->
                            <div class="modal fade" id="miModal" tabindex="-1" role="dialog"
                                aria-labelledby="miModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="miModalLabel">Imagen Ampliada</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body p-4 d-flex justify-content-center align-items-center">
                                            <img src="{{ asset('images/articulos/' . $articulo->primeraImagen()) }}"
                                                class="img-fluid" alt="Imagen ampliada"
                                                onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-lg-flex d-none justify-content-center">
                                @foreach($articulo->imagenes as $imagen)
                                <a href="javascript: void(0);">
                                    <img src="{{ asset('images/articulos/' . $imagen->imanom) }}"
                                        class="img-fluid img-thumbnail p-2" style="max-width: 75px;" alt="Product-img"
                                        onclick="changeMainImage('{{ asset('images/articulos/' . $imagen->imanom) }}')"
                                        onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';" />
                                </a>
                                @endforeach
                            </div>
                        </div> <!-- end col -->

                        <div class="col-lg-6">
                            <form method="POST" action="{{ route('cart.add', ['artcod' => $articulo->artcod]) }}"
                                class="ps-lg-4">
                                @csrf

                                <!-- Product title -->
                                <h3 class="mt-0">{{ $articulo->artnom }} </h3>

                                <div class="row">
                                    <div class="col">
                                        <h4><span class="badge badge-primary-lighten">{{$articulo->artcod}}</span></h4>

                                        <!-- Product stock -->
                                        <div class="mt-3">
                                            @if($articulo->artstocon > 0)
                                            <h4><span class="badge badge-danger-lighten">No
                                                    hay Stock</span></h4>
                                            @elseif($articulo->artstocon <= 0) <h4><span
                                                    class="badge badge-success-lighten">En Stock</span></h4>
                                                @endif
                                        </div>

                                        <!-- Product ficha tecnica -->
                                        @foreach($articulo->pdf as $file)
                                        <a class="p-1 link-info" href="{{ asset('images/files/' . $file->imanom) }}"
                                            data-toggle="fullscreen" title="Ficha técnica">
                                            <i class="uil-clipboard-alt font-23"></i> Ver Ficha Técnica
                                        </a>
                                        <!-- <a class="p-1 link-info " href="javascript:void(0);" data-toggle="fullscreen"
                                            title="Ficha técnica">
                                            <i class="uil-clipboard-alt font-23"></i> Ficha técnica no disponible,
                                            consultenos
                                            para más información.
                                        </a> -->
                                        @endforeach


                                        <!-- Product price -->
                                        <!-- para unidades -->
                                        <!-- <div class="product-price">
                                            @isset($articulo->precioTarifa)
                                            <h6 class="font-14">Precio:</h6>
                                            @if ($articulo->precioOferta)
                                            <span class="badge badge-danger-lighten">OFERTA</span>
                                            <h3 class="text-danger fw-bolder d-inline"> {{ $articulo->precioOferta }} €
                                            </h3>
                                            <span class="text-decoration-line-through font-15">
                                                {{ $articulo->precioTarifa }} €</span>

                                            @else
                                            <h3> {{ $articulo->precioTarifa }} €</h3>
                                            @endif
                                            @else
                                            <div class="mt-4">
                                                <h6 class="font-14">Precio: <span class="text-danger">El precio no está
                                                        disponible, consúltenos.</span></h6>
                                            </div>
                                            @endisset
                                        </div> -->
                                        @isset($cajas)
                                        <div class="d-flex gap-4">
                                            @foreach($cajas as $index => $caja)
                                            <div class="product-price">

                                                @isset($articulo->precioTarifa)
                                                    <h6 class="font-14">Precio  por @if($caja->cajtip == 'P' || $caja->cajtip == 'Unidades' ) pieza @else
                                                    caja @endif : </h6>

                                                    @if ($articulo->precioOferta)
                                                    <span class="badge badge-danger-lighten">OFERTA</span>
                                                    <h3 class="text-danger fw-bolder d-inline">
                                                        {{ $articulo->precioOferta }} €
                                                    </h3>
                                                    <span class="text-decoration-line-through font-15">
                                                        {{ $articulo->precioTarifa }} €</span>

                                                    @else
                                                    <h3> {{ $articulo->precioTarifa * $caja->cajreldir }} €</h3>
                                                    @endif

                                                    @else
                                                    <div class="mt-4">
                                                        <h6 class="font-14">Precio  por @if($caja->cajtip == 'P' || $caja->cajtip == 'Unidades' ) pieza @else
                                                    caja @endif : <span class="text-danger">El
                                                                precio
                                                                no está
                                                                disponible, consúltenos.</span></h6>
                                                    </div>
                                                @endisset
                                            </div>
                                            @endforeach
                                        </div>
                                        @endisset
                                        <!-- end product price -->

                                    </div>

                                    <div class="col text-end">
                                        @isset($alergenos)
                                        @foreach($alergenos as $alergeno)
                                        <p class="mb-0"><img src="{{ asset('images/alergenos/'. $alergeno . '.ico') }}"
                                                alt=""></p>
                                        @endforeach
                                        @endisset
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <div class="mt-3">

                                    <h6 class="font-14">Cantidad</h6>
                                    <div class="form-check">
                                        @isset($cajas)
                                        @foreach($cajas as $index => $caja)
                                        <div>
                                            <input class="form-check-input" type="radio" value="{{ $caja->cajcod }}"
                                                name="caja" id="caja{{ $index }}" @if($caja->cajdef == 1)
                                            checked
                                            @endif
                                            >
                                            <label class="form-check-label" for="caja{{ $index }}">
                                                {{ $caja->cajnom }}
                                                @if($caja->cajreldir > 0)
                                                ({{ $caja->cajreldir }} {{ $articulo->promedcod }})
                                                @endif
                                            </label>
                                        </div>
                                        @endforeach
                                        @endisset

                                        <!-- <div>
                                            <input class="form-check-input" type="radio" value="unidades" name="caja"
                                                id="ud" @if(!isset($caja->cajdef))
                                            checked
                                            @endif
                                            >
                                            <label class="form-check-label" for="ud">Unidades</label>
                                        </div> -->
                                    </div>

                                    <div class="d-flex align-items-end mt-3">
                                        <!-- <input type="number" min="1" value="1" name="quantity" id="quantity"
                                            class="form-control" placeholder="quantity" style="width: 90px;"> -->

                                        <!-- Campo para la cantidad de cajas -->
                                        <div id="box-quantity-input" style="display:none;">
                                            <label for="box-quantity">Cantidad de cajas:</label>
                                            <input type="number" id="box-quantity" name="box_quantity" min="1" value="1"
                                                style="width: 90px;" class="form-control">
                                        </div>

                                        <!-- Campo para la cantidad de unidades -->
                                        <div id="unit-quantity-input">
                                            <label for="unit-quantity">Cantidad de unidades:</label>
                                            <input type="number" id="unit-quantity" name="ud_quantity" min="1" value="1"
                                                style="width: 90px;" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-danger ms-2"><i
                                                class="mdi mdi-cart me-1"></i> Añadir al carrito</button>
                                    </div>
                                </div>

                                <!-- Product description -->
                                @if(!empty($articulo->artobs))
                                <div class="mt-4">
                                    <h6 class="font-14">Descripción:</h6>
                                    <p>{{ $articulo->artobs }}</p>
                                </div>
                                @endif
                            </form>
                        </div> <!-- end col -->

                    </div> <!-- end row-->

                    <!-- section Recomendados -->
                    <h3 class="pt-3 text-seccondary">También puede interesarte...</h3>
                    <hr />
                    <div class="favoritos mb-5">
                        <button id="scrollLeft" class="btn btn-link"><i
                                class="bi bi-arrow-left-circle-fill font-24 text-primary"></i></button>
                        <div id="productos" class="productos"></div>
                        <button id="scrollRight" class="btn btn-link"><i
                                class="bi bi-arrow-right-circle-fill font-24 text-primary"></i></button>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-12-->
    </div> <!-- end rowcol-->

</div>
<!-- end -->

@endsection


@push('scripts')
<script src="{{ asset('js/Ajax/recommended.js') }}"></script>
<script src="{{ asset('js/modal-zoom-img.js') }}"></script>
<!-- <script src="{{ asset('js/continueShopping.js') }}"></script> -->
<script src="{{ asset('js/scrollbar.js') }}"></script>
@endpush