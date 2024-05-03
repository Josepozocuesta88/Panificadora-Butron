@extends('layouts.app')

@section('content')
<div class="container-fluid bg-light pb-3">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li> -->
                        <li class="breadcrumb-item active">Productos</li>
                    </ol>
                </div>
                <h4 class="page-title">Productos</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <!-- ofertas -->
    <div class="container">
        <div id="carouselExampleIndicators" class="carousel slide pb-5" data-bs-ride="carousel">
            <!-- Indicadores del Carrusel -->
            <div class="carousel-indicators">
                @foreach($ofertas as $index => $image)
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}"
                    class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"
                    aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>

            <!-- Elementos del Carrusel -->
            <div class="carousel-inner">
                @foreach($ofertas as $image)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <a
                        href="{{ isset($image->ofcartcod) && $image->ofcartcod ? route('info', ['artcod' => $image->ofcartcod]) : 'javascript:void(0)' }}">
                        <img src="{{ asset('images/ofertas/' . trim($image->ofcima)) }}" class="d-block w-100 fill"
                            alt="banner publicitario">
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Controles del Carrusel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- fin ofertas -->

    <!-- categorias disponibles -->
    <div class="card p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="p-2">Categorías disponibles</h2>
            <div class="app-search dropdown d-none d-lg-block" style="width: auto;">
                <!-- buscar categoria -->
                <form method="GET" action="{{ route('search.category') }}">
                    <div class="input-group">
                        <input type="search" class="form-control dropdown-toggle" placeholder="Buscar categorías..."
                            id="top-search" name="query">
                        <span class="mdi mdi-magnify search-icon"></span>
                        <button class="input-group-text btn btn-primary" type="submit">Buscar</button>
                    </div>
                </form>
                <!-- end buscar categoria -->
            </div>
        </div>
        <!-- categorias disponibles -->
        <div class="row justify-content-center">
            @foreach($categorias as $category)
            <div class="categoria col-2 d-block position-relative p-0 m-2">
                <a href="{{ route('categories', ['catcod' => $category->id]) }}" title="" onclick="irAProductos()" >
                    <img src="{{ asset('images/categorias/' . $category->imagen) }}"
                        class="object-fit-fill border rounded" alt="{{ $category->nombre_es }}"
                        style="height:200px; width:100%;"
                        onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                </a>
                <div class="nombre-categoria bg-primary text-center">
                    <h5>
                        <a href="{{route('categories', ['catcod' => $category->id])}}" class="text-white" onclick="irAProductos()">
                            {{ $category->nombre_es }}
                        </a>
                    </h5>
                    <a href="{{route('categories', ['catcod' => $category->id])}}" onclick="irAProductos()"
                        class="categoria-link text-warning font-20">Ver más <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>


</div>
<!-- fin categorias disponibles -->
<!-- CARDS DE PRODUCTOS -->

<section class="py-5" id="productos">

    @if (session('success') || session('error'))
    <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 1050;">
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



    <div class="container">
        @isset($catnom)
        <h3 class="text-primary pb-2">{{$catnom}}</h3>
        @endisset


        <div class="d-flex justify-content-end pb-3 gap-3">
            <!-- Botón para controlar el collapse ordenaciones -->
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                data-bs-target="#menuLateralFormulario" aria-expanded="false" aria-controls="menuLateralFormulario">
                Opciones de Ordenación
            </button>
            <!--end Botón para controlar el collapse ordenaciones -->
            <div class="app-search dropdown d-none d-lg-block" style="width: auto;">
                <!-- buscar producto -->
                <form method="GET" action="{{ route('search') }}">
                    <div class="input-group">
                        <input type="search" class="form-control dropdown-toggle" placeholder="Buscar artículos..."
                            id="top-search" name="query">
                        <span class="mdi mdi-magnify search-icon"></span>
                        <button class="input-group-text btn btn-primary" type="submit">Buscar</button>
                    </div>
                </form>
                <!-- end buscar producto -->
            </div>
        </div>

        <!-- Collapse ordenaciones  -->
        <div class="collapse" id="menuLateralFormulario">

            <div class="card card-body">

                <form action="{{ route('filtrarArticulos', ['catnom' => $catnom ?? null]) }}" method="GET"
                    class="ordenacion-formulario container mt-4">

                    <h3 class="text-center mb-4">Ordenar Productos</h3>
                    <p class="text-center">Seleccione cómo desea ordenar los productos. Puede combinar múltiples
                        criterios.</p>

                    <!-- Opciones de Ordenación -->
                    <div class="ordenacion-opciones row justify-content-center">

                        <!-- Sección: Ordenar por Nombre -->
                        <div class="col-md-4 mb-3">
                            <p class="font-weight-bold">Ordenar por nombre:</p>
                            <div class="form-check">
                                <input type="checkbox" name="orden_nombre" value="asc" id="orden_nombre_asc"
                                    class="form-check-input checkbox-orden-nombre">
                                <label class="form-check-label" for="orden_nombre_asc">A - Z</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="orden_nombre" value="desc" id="orden_nombre_desc"
                                    class="form-check-input checkbox-orden-nombre">
                                <label class="form-check-label" for="orden_nombre_desc">Z - A</label>
                            </div>

                        </div>

                        <!-- Sección: Ordenar por Precio -->
                        <div class="col-md-4 mb-3">
                            <p class="font-weight-bold">Ordenar por precio:</p>
                            <div class="form-check">
                                <input type="checkbox" name="orden_precio" value="asc" id="orden_precio_asc"
                                    class="form-check-input checkbox-orden-precio">
                                <label class="form-check-label" for="orden_precio_asc">Menor a Mayor</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="orden_precio" value="desc" id="orden_precio_desc"
                                    class="form-check-input checkbox-orden-precio">
                                <label class="form-check-label" for="orden_precio_desc">Mayor a Menor</label>
                            </div>
                        </div>

                        <!-- Sección: Ofertas Especiales -->
                        <div class="col-12 text-center mb-3">
                            <p class="font-weight-bold d-inline-block align-middle m-0 pe-2">
                                <i class="fas fa-star"></i> Ofertas Especiales:
                            </p>
                            <div class="form-check d-inline-block ml-2">
                                <input type="checkbox" name="orden_oferta" value="1" id="orden_oferta"
                                    class="form-check-input">
                                <label class="form-check-label" for="orden_oferta">Mostrar primero productos en
                                    oferta</label>
                            </div>
                        </div>

                    </div>

                    <!-- Botón de Envío -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Aplicar Ordenación</button>
                    </div>
                </form>

            </div>
        </div>
        <!--end Collapse ordenaciones  -->

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 p-3">
            @if($articulos->isNotEmpty())
            @foreach($articulos as $articulo)
            <div class="col">

                <div class="card h-100 border border-primary rounded-3 shadow-lg position-relative">

                    <!-- Ícono de la corazon -->
                    @if(in_array($articulo->artcod, $favoritos))
                    <i onclick="heart(this)" data-artcod="{{$articulo->artcod}}"
                        class="bi bi-suit-heart-fill red-heart position-absolute top-0 end-0 m-2 font-20 cursor-pointer heartIcon"></i>
                    @else
                    <i onclick="heart(this)" data-artcod="{{$articulo->artcod}}"
                        class="bi bi-suit-heart position-absolute top-0 end-0 m-2 font-20 cursor-pointer heartIcon"></i>
                    @endif

                    <figure class="d-flex bg-white overflow-hidden align-items-center justify-content-center m-0"
                        style="height:325px;">
                        <a href="{{route('info', ['artcod' => $articulo->artcod])}}" class="d-block">
                            @if($articulo->imagenes->isNotEmpty())
                            <img src="{{ asset('images/articulos/' . $articulo->imagenes->first()->imanom) }}"
                                class="d-block w-100 h-auto" alt="{{ $articulo->artnom }}"
                                title="{{ $articulo->artnom }}"
                                onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                            @else
                            <img src="{{ asset('images/articulos/noimage.jpg') }}" class="d-block w-100 h-auto"
                                alt="no hay imagen" title="No hay imagen">
                            @endif

                        </a>
                    </figure>

                    <div class="card-body pb-0 bg-white">
                        <a href="{{route('info', ['artcod' => $articulo->artcod])}}">
                            <h5 class="card-title text-primary">{{ $articulo->artnom }}</h5>
                            <p class="card-text l3truncate">{{$articulo->artobs}}</p>
                        </a>

                    </div>

                    <div class="card-footer pt-0">

                        <ul class="list-group list-group-flush">

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <a class="pe-2" href="{{route('info', ['artcod' => $articulo->artcod])}}"
                                        data-toggle="fullscreen" title="Stock disponible o no">
                                        @if($articulo->artstocon == 1)
                                        <i class="mdi mdi-archive-cancel font-24 text-danger"></i>
                                        @else
                                        <i class="mdi mdi-archive-check font-24 text-success"></i>
                                        @endif
                                    </a>
                                    <a class="pe-2" href="{{ asset('images/' . $articulo->artdocaso) }}"
                                        data-toggle="fullscreen" title="Ficha técnica">
                                        <i class="uil-clipboard-alt font-24"></i>
                                    </a>
                                    <a class="pe-2" href="{{route('info', ['artcod' => $articulo->artcod])}}"
                                        data-toggle="fullscreen" title="Información">
                                        <i class="mdi mdi-information-outline font-24"></i>
                                    </a>
                                </div>

                                <div class="text-end">
                                    @if ($articulo->precioOferta)
                                    <h5>
                                        <span class="badge badge-danger-lighten">
                                            OFERTA
                                            @if($articulo->precioDescuento)
                                            {{$articulo->precioDescuento}}%
                                            @endif
                                        </span>
                                    </h5>
                                    <span class="font-18 text-danger fw-bolder"> {{ $articulo->precioOferta }} €</span>
                                    <span class="text-decoration-line-through font-14 "> {{ $articulo->precioTarifa }}
                                        €</span>
                                    @elseif($articulo->precioTarifa)
                                    <span class="font-18"> {{ $articulo->precioTarifa }} €</span>
                                    @else
                                    <span class="font-18"></span>
                                    @endif
                                </div>

                            </li>


                            <li class="list-group-item">
                                <form method="POST" action="{{ route('cart.add', ['artcod' => $articulo->artcod]) }}"
                                    class="ps-lg-4">
                                    @csrf
                                    <button type="submit" class="btn btn-primary"
                                        onclick="$('#alertaStock').toast('show')">
                                        Añadir al carrito
                                    </button>
                                </form>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach


            @else
            <div class="alert alert-primary container text-center" role="alert">
                <i class="ri-information-line me-1 align-middle font-22"></i>
                <strong>Actualmente no disponemos de artículos en esta categoría</strong>
            </div>


            @endif
        </div>
        {{ $articulos->links('vendor.pagination.bootstrap-5') }}
    </div>
</section>

<!-- FIN CARDS DE PRODUCTOS -->
@endsection


@push('scripts')
<script src="{{ asset('js/checkbox.js') }}"></script>
<script src="{{ asset('js/scrollbar.js') }}"></script>
<script src="{{ asset('js/Ajax/favorites.js') }}"></script>
@endpush