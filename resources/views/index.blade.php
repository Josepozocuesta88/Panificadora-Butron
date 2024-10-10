<!-- ============================================================== -->
<!-- TODOS: Página principal de inicio -->
<!-- ============================================================== -->


@extends('layouts.app')

@section('content')

<div class="container py-5">

    <div class="tw-flex tw-justify-between tw-align-middle tw-ml-4">
        <div class="nav nav-tabs text-dark ">
            <h3>Pruega git</h3>
            <h3>Productos en oferta</h3>
        </div>
        <ul class="mb-3 nav nav-pills bg-nav-pills nav-justified tw-w-4/12 tw-mr-4">

            <li class="nav-item">
                <a href="#tarjetasOfertas" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                    <i class="bi bi-percent d-md-none d-block"></i>
                    <h2 class="d-none d-md-block">Ofertas generales</h2>
                </a>
            </li>
            <li class="nav-item">
                <a href="#carrouselOfertas" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 ">
                    <i class="bi bi-lightbulb d-md-none d-block"></i>
                    <h2 class="d-none d-md-block">Ofertas PRUEBA DEP</h2>
                </a>
            </li>
        </ul>
    </div>
    <div class="pb-5 tab-content">
        <!-- carrusel de ofertas generales -->
        <div class="tab-pane show active" id="tarjetasOfertas">
            <div class="favoritos">
                <button id="scrollLeft" class="scrollLeft btn btn-light ">
                    <i class="bi bi-arrow-left-circle font-24 text-primary"></i>
                </button>
                <div id="categorias"
                    class="gap-3 pt-3 categorias scrollbar row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 bg-light">
                    @foreach ($articulosOferta as $ofertaArticulo)
                    <div class="">
                        <div class="card h-100 rounded-3 position-relative">
                            <!-- Ícono de la corazon -->
                            @if (in_array($ofertaArticulo->artcod, $favoritos))
                            <i onclick="heart(this)" data-artcod="{{ $ofertaArticulo->artcod }}"
                                class="top-0 m-2 cursor-pointer bi bi-suit-heart-fill red-heart position-absolute end-0 font-20 heartIcon"></i>
                            @else
                            <i onclick="heart(this)" data-artcod="{{ $ofertaArticulo->artcod }}"
                                class="top-0 m-2 cursor-pointer bi bi-suit-heart position-absolute end-0 font-20 heartIcon"></i>
                            @endif
                            <figure
                                class="m-0 overflow-hidden bg-white d-flex align-items-center justify-content-center"
                                style="height:325px;">
                                <a href="{{ route('info', ['artcod' => $ofertaArticulo->artcod]) }}" class="d-block">
                                    @if ($ofertaArticulo->imagenes->isNotEmpty())
                                    <img src="{{ asset('images/articulos/' . $ofertaArticulo->imagenes->first()->imanom) }}"
                                        class="h-auto d-block w-100" alt="{{ $ofertaArticulo->artnom }}"
                                        title="{{ $ofertaArticulo->artnom }}"
                                        onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                                    @else
                                    <img src="{{ asset('images/articulos/noimage.jpg') }}" class="h-auto d-block w-100"
                                        alt="no hay imagen" title="No hay imagen">
                                    @endif
                                </a>
                            </figure>
                            <div class="pb-0 bg-white card-body">
                                <a href="{{ route('info', ['artcod' => $ofertaArticulo->artcod]) }}">
                                    <h5 class="m-0 card-title text-primary">{{ $ofertaArticulo->artnom }}</h5>
                                    @isset($ofertaArticulo->artobs)
                                    <p class="card-text l3truncate">{{ $ofertaArticulo->artobs }}</p>
                                    @endisset
                                </a>
                            </div>
                            <div class="pt-0 card-footer">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <a class="pe-1"
                                                href="{{ route('info', ['artcod' => $ofertaArticulo->artcod]) }}"
                                                data-toggle="fullscreen" title="Stock disponible o no">
                                                @if ($ofertaArticulo->artstocon == 1 || $ofertaArticulo->artstock >
                                                1)
                                                <i class="mdi mdi-archive-check font-24 text-success"></i>
                                                @else
                                                <i class="mdi mdi-archive-cancel font-24 text-danger"></i>
                                                @endif
                                            </a>
                                            <a class="pe-1" href="{{ asset('images/' . $ofertaArticulo->artdocaso) }}"
                                                data-toggle="fullscreen" title="Ficha técnica">
                                                <i class="uil-clipboard-alt font-24"></i>
                                            </a>
                                            <a class="pe-1"
                                                href="{{ route('info', ['artcod' => $ofertaArticulo->artcod]) }}"
                                                data-toggle="fullscreen" title="Información">
                                                <i class="mdi mdi-information-outline font-24"></i>
                                            </a>
                                        </div>
                                        <div class="text-end">
                                            @if ($ofertaArticulo->precioOferta)
                                            <h5>
                                                <span class="badge badge-danger-lighten">
                                                    OFERTA
                                                    @if ($ofertaArticulo->precioDescuento)
                                                    {{ $ofertaArticulo->precioDescuento }}%
                                                    @endif
                                                </span>
                                            </h5>
                                            <span class="font-18 text-danger fw-bolder">
                                                {{
                                                \App\Services\FormatoNumeroService::convertirADecimal($ofertaArticulo->precioOferta)
                                                }}
                                                €
                                            </span>
                                            <span class="text-decoration-line-through font-14">
                                                {{
                                                \App\Services\FormatoNumeroService::convertirADecimal($ofertaArticulo->precioTarifa)
                                                }}
                                                €
                                            </span>
                                            @elseif(isset($ofertaArticulo->precioTarifa))
                                            <span class="font-18">
                                                {{
                                                \App\Services\FormatoNumeroService::convertirADecimal($ofertaArticulo->precioTarifa)
                                                }}
                                                €</span>
                                            @else
                                            <span class="font-18"></span>
                                            @endif
                                        </div>
                                    </li>
                                    <li class="list-group-item product-card">
                                        <form method="POST"
                                            action="{{ route('cart.add', ['artcod' => $ofertaArticulo->artcod]) }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    @if ($ofertaArticulo->cajas->isNotEmpty() && config('app.caja')
                                                    ==
                                                    'si')
                                                    <div class="row">
                                                        <div class="quantity-input col">
                                                            <input type="number" class="quantity form-control"
                                                                name="quantity" min="1" value="1">
                                                        </div>
                                                        <div class="col-auto">
                                                            @foreach ($ofertaArticulo->cajas as $index => $caja)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    data-id="$caja->cajartcod"
                                                                    value="{{ $caja->cajcod }}" name="input-tipo"
                                                                    id="caja{{ $index }}" @if($caja->cajdef==
                                                                1)
                                                                checked
                                                                @endif
                                                                >
                                                                <label class="form-check-label" for="caja{{ $index }}">
                                                                    @if ($caja->cajreldir > 0)
                                                                    {{ $caja->cajreldir }}
                                                                    {{ $ofertaArticulo->promedcod }}
                                                                    @endif
                                                                    @if ($caja->cajcod == '0003')
                                                                    (Pieza)
                                                                    @elseif($caja->cajcod == '0002')
                                                                    (Media)
                                                                    @else
                                                                    (Caja)
                                                                    @endif
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <!-- end product price unidades-->
                                                </div>
                                            </div>
                                            <!-- submit -->
                                            <div class="mt-3">
                                                <div class="row align-items-end ">
                                                    <button type="submit" class="btn btn-primary ms-2 col"
                                                        onclick="$('#alertaStock').toast('show')"><i
                                                            class="mdi mdi-cart me-1"></i>
                                                        Añadir</button>
                                                </div>
                                            </div>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button id="scrollRight" class="scrollRight btn btn-light ">
                    <i class="bi bi-arrow-right-circle font-24 text-primary"></i>
                </button>
            </div>
        </div>
        <!-- fin de carrusel de ofertas generales -->
        <!-- carrusel de ofertas personalizadas -->
        <div class="tab-pane " id="carrouselOfertas">
            <!-- parte 1 -->
            <div class="container">
                <div id="carouselExampleIndicators" class="pb-5 carousel slide" data-bs-ride="carousel">
                    <!-- Indicadores del Carrusel -->
                    <div class="carousel-indicators">
                        @foreach ($ofertas as $index => $image)
                        <button type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}"
                            aria-current="{{ $loop->first ? 'true' : 'false' }}"
                            aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>

                    <!-- Elementos del Carrusel -->
                    <div class="carousel-inner">
                        <!-- usar cuando hay imagenes del baner -->
                        <!-- @foreach ($ofertasPer as $image)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <a href="{{ isset($image->ofcartcod) && $image->ofcartcod ? route('info', ['artcod' => $image->ofcartcod]) : 'javascript:void(0)' }}">
                                <img src="{{ asset('images/ofertas/' . trim($image->ofcima)) }}" class="d-block fill" alt="banner publicitario" style="width: 100%; height: auto; aspect-ratio: 3/1;">
                            </a>
                        </div>
                        @endforeach -->
                        <!-- fin del baner principal -->
                        <!-- usar esto cuando no hay imagenes del banner quitar cuando existan y usar la de arriba -->
                        @foreach ($articulosOfertaPer as $ofertaArticuloPer)
                                @if ($ofertaArticuloPer->imagenes->isNotEmpty())
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}  max-w-50">
                                    <a href="{{ route('info', ['artcod' => $ofertaArticuloPer->artcod]) }}" class="d-block">
                                        <img src="{{ asset('images/articulos/' . $ofertaArticuloPer->imagenes->first()->imanom) }}"
                                        class="d-block w-100 mx-auto" alt="banner publicitario" style="object-fit: contain;  width: 100%; height: auto;  aspect-ratio: 3/1;"
                                        title="{{ $ofertaArticuloPer->artnom }}"
                                        onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                                    </a>
                                    @else
                                    <img src="{{ asset('images/articulos/noimage.jpg') }}" class="d-block w-100 mx-auto" 
                                        style="object-fit: contain; width: 100%; height: auto; aspect-ratio: 3/1;"
                                        alt="no hay imagen" title="No hay imagen">
                                    @endif
                                </div>
                        @endforeach
                        <!-- fin de uso cuando no hay imagenes de banner -->
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
            <!-- fin de parte 1 -->
            <!-- parte 2 -->
            <div class="favoritos">
                <button id="scrollLeft" class="scrollLeft btn btn-light ">
                    <i class="bi bi-arrow-left-circle font-24 text-primary"></i>
                </button>
                <div id="categorias"
                    class="gap-3 pt-3 categorias scrollbar row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 bg-light">
                    @foreach ($articulosOfertaPer as $ofertaArticuloPer)
                    <div class="">
                        <div class="card h-100 rounded-3 position-relative">
                            <!-- Ícono de la corazon -->
                            @if (in_array($ofertaArticuloPer->artcod, $favoritos))
                            <i onclick="heart(this)" data-artcod="{{ $ofertaArticuloPer->artcod }}"
                                class="top-0 m-2 cursor-pointer bi bi-suit-heart-fill red-heart position-absolute end-0 font-20 heartIcon"></i>
                            @else
                            <i onclick="heart(this)" data-artcod="{{ $ofertaArticuloPer->artcod }}"
                                class="top-0 m-2 cursor-pointer bi bi-suit-heart position-absolute end-0 font-20 heartIcon"></i>
                            @endif
                            <figure
                                class="m-0 overflow-hidden bg-white d-flex align-items-center justify-content-center"
                                style="height:325px;">
                                <a href="{{ route('info', ['artcod' => $ofertaArticuloPer->artcod]) }}" class="d-block">
                                    @if ($ofertaArticuloPer->imagenes->isNotEmpty())
                                    <img src="{{ asset('images/articulos/' . $ofertaArticuloPer->imagenes->first()->imanom) }}"
                                        class="h-auto d-block w-100" alt="{{ $ofertaArticuloPer->artnom }}"
                                        title="{{ $ofertaArticuloPer->artnom }}"
                                        onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                                    @else
                                    <img src="{{ asset('images/articulos/noimage.jpg') }}" class="h-auto d-block w-100"
                                        alt="no hay imagen" title="No hay imagen">
                                    @endif
                                </a>
                            </figure>
                            <div class="pb-0 bg-white card-body">
                                <a href="{{ route('info', ['artcod' => $ofertaArticuloPer->artcod]) }}">
                                    <h5 class="m-0 card-title text-primary">{{ $ofertaArticuloPer->artnom }}</h5>
                                    @isset($ofertaArticuloPer->artobs)
                                    <p class="card-text l3truncate">{{ $ofertaArticuloPer->artobs }}</p>
                                    @endisset
                                </a>
                            </div>
                            <div class="pt-0 card-footer">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <a class="pe-1"
                                                href="{{ route('info', ['artcod' => $ofertaArticuloPer->artcod]) }}"
                                                data-toggle="fullscreen" title="Stock disponible o no">
                                                @if ($ofertaArticuloPer->artstocon == 1 || $ofertaArticuloPer->artstock >
                                                1)
                                                <i class="mdi mdi-archive-check font-24 text-success"></i>
                                                @else
                                                <i class="mdi mdi-archive-cancel font-24 text-danger"></i>
                                                @endif
                                            </a>
                                            <a class="pe-1" href="{{ asset('images/' . $ofertaArticuloPer->artdocaso) }}"
                                                data-toggle="fullscreen" title="Ficha técnica">
                                                <i class="uil-clipboard-alt font-24"></i>
                                            </a>
                                            <a class="pe-1"
                                                href="{{ route('info', ['artcod' => $ofertaArticuloPer->artcod]) }}"
                                                data-toggle="fullscreen" title="Información">
                                                <i class="mdi mdi-information-outline font-24"></i>
                                            </a>
                                        </div>
                                        <div class="text-end">
                                            @if ($ofertaArticuloPer->precioOferta)
                                            <h5>
                                                <span class="badge badge-danger-lighten">
                                                    OFERTA
                                                    @if ($ofertaArticuloPer->precioDescuento)
                                                    {{ $ofertaArticuloPer->precioDescuento }}%
                                                    @endif
                                                </span>
                                            </h5>
                                            <span class="font-18 text-danger fw-bolder">
                                                {{
                                                \App\Services\FormatoNumeroService::convertirADecimal($ofertaArticuloPer->precioOferta)
                                                }}
                                                €
                                            </span>
                                            <span class="text-decoration-line-through font-14">
                                                {{
                                                \App\Services\FormatoNumeroService::convertirADecimal($ofertaArticulo->precioTarifa)
                                                }}
                                                €
                                            </span>
                                            @elseif(isset($ofertaArticuloPer->precioTarifa))
                                            <span class="font-18">
                                                {{
                                                \App\Services\FormatoNumeroService::convertirADecimal($ofertaArticuloPer->precioTarifa)
                                                }}
                                                €</span>
                                            @else
                                            <span class="font-18"></span>
                                            @endif
                                        </div>
                                    </li>
                                    <li class="list-group-item product-card">
                                        <form method="POST"
                                            action="{{ route('cart.add', ['artcod' => $ofertaArticuloPer->artcod]) }}">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    @if ($ofertaArticuloPer->cajas->isNotEmpty() && config('app.caja')
                                                    ==
                                                    'si')
                                                    <div class="row">
                                                        <div class="quantity-input col">
                                                            <input type="number" class="quantity form-control"
                                                                name="quantity" min="1" value="1">
                                                        </div>
                                                        <div class="col-auto">
                                                            @foreach ($ofertaArticuloPer->cajas as $index => $caja)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    data-id="$caja->cajartcod"
                                                                    value="{{ $caja->cajcod }}" name="input-tipo"
                                                                    id="caja{{ $index }}" @if($caja->cajdef==
                                                                1)
                                                                checked
                                                                @endif
                                                                >
                                                                <label class="form-check-label" for="caja{{ $index }}">
                                                                    @if ($caja->cajreldir > 0)
                                                                    {{ $caja->cajreldir }}
                                                                    {{ $ofertaArticuloPer->promedcod }}
                                                                    @endif
                                                                    @if ($caja->cajcod == '0003')
                                                                    (Pieza)
                                                                    @elseif($caja->cajcod == '0002')
                                                                    (Media)
                                                                    @else
                                                                    (Caja)
                                                                    @endif
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <!-- end product price unidades-->
                                                </div>
                                            </div>
                                            <!-- submit -->
                                            <div class="mt-3">
                                                <div class="row align-items-end ">
                                                    <button type="submit" class="btn btn-primary ms-2 col"
                                                        onclick="$('#alertaStock').toast('show')"><i
                                                            class="mdi mdi-cart me-1"></i>
                                                        Añadir</button>
                                                </div>
                                            </div>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button id="scrollRight" class="scrollRight btn btn-light ">
                    <i class="bi bi-arrow-right-circle font-24 text-primary"></i>
                </button>
            </div>
            <!-- fin de parte 2 -->
        </div>
        <!-- fin de carrusel de ofertas personalizadas -->
    </div>
    <!-- end carrusel imagenes -->


    <!-- novedades -->
    <div class="container mt-3">
        <div class="mb-3 row">
            <div class="col-lg-12">
                <div class="nav nav-tabs text-dark ">
                    <h3>Novedades</h3>
                </div>
            </div>
        </div>
        <x-novedades :novedades="$novedades" />
    </div>
    <!-- fin novedades -->


    <!-- categories -->

    <div class="container mt-3">
        <div class="mb-3 row">
            <div class="col-lg-12">
                <div class="nav nav-tabs text-dark ">
                    <h3>Categor&#237;as</h3>
                </div>
            </div>
        </div>
        <!-- categorias disponibles -->
        <div class="row justify-content-center">
            <x-categorias :categorias="$categorias" />
        </div>


        <!-- historico -->
        <div class="pt-4 row">
            <div class="col-lg-12">
                <div class="nav nav-tabs text-dark ">
                    <h3>Histórico de compras</h3>
                </div>
            </div>
        </div>
        <div class="pt-3 table-responsive">
            <table class="table table-centered w-100 dt-responsive nowrap" id="history-datatable">
                <thead class="table-light">
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Fecha Compra</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <!-- <th>Estado</th> -->
                    </tr>
                </thead>

            </table>
        </div>

        <!-- fin historico -->
    </div>
</div>
@endsection


@push('scripts')
<script src="{{ asset('js/scrollbar.js') }}"></script>
<script src="{{ asset('js/Ajax/history.js') }}"></script>
<script>
    cargarRejilla();
</script>
@endpush