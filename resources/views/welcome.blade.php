<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset(config('app.logo')) }}">

    <!-- Theme Config Js -->
    <script src="{{asset('js/hyper-config.js')}}"></script>

    <!-- App css -->
    <!-- <link href="{{asset('css/app-saas.min.css')}}" rel="stylesheet" type="text/css" id="app-style" /> -->

    <!-- Iconos -->
    <link href="{{asset('css/icons.css') }}" rel="stylesheet" type="text/css" />
    <!-- Css personalizado -->
    <link href="{{asset('css/css.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('build/assets/app-7f9c8fa3.css') }}" rel="stylesheet" type="text/css" />

    <!-- Scripts -->
    <!-- vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
</head>

<body class="bg-white">
    <section class="position-relative">
        <div class="position-absolute top-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-primary pt-3">
                <div class="container-fluid px-3 justify-content-end d-flex">

                    <div style="flex: 0 0 calc((100% + 102px) / 2 - 78px); margin-bottom: -71px;">
                        <a class="" href="#">
                            <img src="{{ asset(config('app.logo')) }}" alt="Logo" width="220">
                        </a>
                    </div>

                    <div class="d-flex">
                        <a class="nav-link pe-2" href="{{ route('search') }}">
                            <i class="bi bi-search text-white font-25"></i>
                        </a>
                        <a class="nav-link pe-2" href="{{ route('login') }}">
                            <i class="bi bi-person-circle text-white font-25"></i>
                        </a>
                        <a class="nav-link pe-2" href="{{ route('cart.show') }}">
                            <i class="bi bi-cart3 text-white font-25"></i>
                        </a>

                    </div>
                </div>
            </nav>
            <img src="{{ asset('images/web/navbar.png') }}" style="margin:auto; width:99.3vw;" alt="navbar">
        </div>
        <div >
            <img src="{{ asset(config('app.hero_index')) }}" style="width:100vw; height:65vh; object-fit: cover; object-position: bottom;" alt="Imagen principal">
        </div>
    </section>



    <div class="container pb-3">
        <!-- novedades y ofertas -->
        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
            <li class="nav-item">
                <a href="#novedades" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                    <i class="mdi mdi-home-variant d-md-none d-block"></i>
                    <h2 class="d-none d-md-block">Novedades</h2>
                </a>
            </li>
            <li class="nav-item">
                <a href="#ofertas" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                    <i class="mdi mdi-account-circle d-md-none d-block"></i>
                    <h2 class="d-none d-md-block">Ofertas</h2>
                </a>
            </li>

        </ul>

        <div class="tab-content pb-5">
            <div class="tab-pane show active" id="novedades">
                <!-- novedades -->
                <div class="favoritos">

                    <button id="scrollLeft" class="btn btn-light "><i
                            class="bi bi-arrow-left-circle font-24 text-primary"></i></button>
                    <div id="productos" class="productos gap-3 row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 bg-light p-3">
                        @foreach($novedades as $articulo)
                        <div class="col d-flex flex-column align-content-between  align-items-center ">

                            <div class="card h-100 border border-primary rounded-3 shadow-lg position-relative">

                                <figure
                                    class="d-flex bg-white overflow-hidden align-items-center justify-content-center m-0"
                                    style="height:325px;">
                                    <a href="{{route('info', ['artcod' => $articulo->artcod])}}" class="d-block">
                                        @if($articulo->imagenes->isNotEmpty())
                                        <img src="{{ asset('images/articulos/' . $articulo->imagenes->first()->imanom) }}"
                                            class="d-block w-100 h-auto" alt="{{ $articulo->artnom }}"
                                            title="{{ $articulo->artnom }}"
                                            onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                                        @else
                                        <img src="{{ asset('images/articulos/noimage.jpg') }}"
                                            class="d-block w-100 h-auto" alt="no hay imagen" title="No hay imagen">
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
                                                <a class="pe-2"
                                                    href="{{route('info', ['artcod' => $articulo->artcod])}}"
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
                                                <a class="pe-2"
                                                    href="{{route('info', ['artcod' => $articulo->artcod])}}"
                                                    data-toggle="fullscreen" title="Información">
                                                    <i class="mdi mdi-information-outline font-24"></i>
                                                </a>
                                            </div>
                                        </li>


                                        <li class="list-group-item">
                                            <form method="POST"
                                                action="{{ route('cart.add', ['artcod' => $articulo->artcod]) }}"
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
                    </div>
                    <button id="scrollRight" class="btn btn-light "><i
                            class="bi bi-arrow-right-circle font-24 text-primary"></i></button>
                </div>
                <!-- fin novedades -->
            </div>
            <div class="tab-pane" id="ofertas">
                <!-- ofertas -->
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <!-- Indicadores del Carrusel -->
                    <div class="carousel-indicators">
                        @foreach($ofertas as $index => $image)
                        <button type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide-to="{{ $index }}" class="{{ $loop->first ? 'active' : '' }}"
                            aria-current="{{ $loop->first ? 'true' : 'false' }}"
                            aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>

                    <!-- Elementos del Carrusel -->
                    <div class="carousel-inner pb-3">
                        @foreach($ofertas as $image)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <a
                                href="{{ isset($image->ofcartcod) && $image->ofcartcod ? route('info', ['artcod' => $image->ofcartcod]) : 'javascript:void(0)' }}">
                                <img src="{{ asset('images/ofertas/' . trim($image->ofcima)) }}"
                                    class="d-block w-100 fill" alt="banner publicitario">
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
                <!-- fin ofertas -->
            </div>
        </div>
        <!-- fin novedades y ofertas -->

        <!-- categorias disponibles -->
        <h2 class="text-primary py-3">Nuestro Catálogo</h2>
        <div class="row justify-content-center">
            @foreach($categories as $category)
            <div class="categoria col-3 d-block position-relative p-0 m-2">
                <a href="{{ route('categories', ['catcod' => $category->id]) }}" title="" onclick="irAProductos()">
                    <img src="{{ asset('images/categorias/' . $category->imagen) }}"
                        class="object-fit-fill border rounded" alt="{{ $category->nombre_es }}"
                        style="height:300px; width:100%;"
                        onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                </a>
                <div class="nombre-categoria bg-primary text-center">
                    <h3>
                        <a href="{{route('categories', ['catcod' => $category->id])}}" class="text-white" onclick="irAProductos()">
                            {{ $category->nombre_es }}
                        </a>
                    </h3>
                    <a href="{{route('categories', ['catcod' => $category->id])}}" onclick="irAProductos()"
                        class="categoria-link text-warning font-20">Ver más <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!--fin categorias disponibles -->
    </div>


    <!--  -->
    <div class="row pt-5 pe-0">
        <div class="col bg-light pe-0 pt-1">
            <iframe src="{{config('app.maps')}}" width="100%" height="400" style="border:0;" allowfullscreen=""
                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <div class=" bg-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="px-2 pb-2 text-dark">
                            <i class="uil-truck font-30"></i>
                        </span>
                        <div class="">
                            <h3 class="text-dark">Envío Personalizado</h3>
                            <h5>Gestión rápida en el envío de sus pedidos</h5>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 col-lg-4">
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="px-2 pb-2 text-dark">
                            <i class="uil-shield-check font-30"></i>
                        </span>

                        <div class="">
                            <h3 class="text-dark">Acumula Puntos</h3>
                            <h5>Gana puntos en cada pedido</h5>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="px-2 pb-2 text-dark">
                            <i class="uil-life-ring font-30"></i>
                        </span>

                        <div class="">
                            <h3 class="text-dark">Atención Profesional</h3>
                            <h5>Consúltenos sus dudas</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <footer class=" pt-5 ">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3 p-3">
                    <div class="widget widget-about">
                        <img src="{{ asset(config('app.logo')) }}" class="footer-logo mb-3" alt="Florys"
                            style="max-width: 220px; margin: auto;">

                        <div class="d-flex border border-primary py-2 px-3 m-2 ">
                            <i class="ri-phone-fill font-25"></i>
                            <div class="ps-2">
                                ¿Alguna duda? ¡Llámanos!
                                <a href="tel:+34957690508">957 690 508</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 p-3">
                    <div class="widget">

                        <h4 class="widget-title">Legal</h4>

                        <ul class="widget-list">
                            <li><a href="{{ route('privacidad') }}">Política de Privacidad</a></li>
                            <li><a href="{{ route('avisoLegal') }}">Aviso Legal</a></li>
                            <li><a href="{{ route('cookies') }}">Política de Cookies</a></li>
                            <li><a href="{{ route('redes') }}">Política de Privacidad en Redes Sociales</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 p-3">
                    <div class="widget">


                        <h4 class="widget-title">Información</h4>

                        <ul class="widget-list">

                            <li><a href="7-vc-quienes-somos.html">Quiénes Somos</a></li>
                            <li><a href="10-vc-pago-seguro.html">Pago Seguro</a></li>
                            <li><a href="12-vc-devoluciones.html">Devoluciones</a></li>
                            <li><a href="5-vc-formas-de-envio.html">Formas de Envío</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 p-3">
                    <div class="widget">


                        <h4 class="widget-title">Clientes</h4>

                        <ul class="widget-list">

                            <li><a href="{{ route('contacto.formulario') }}">Contacto</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
<script src="{{asset('js/scrollbar.js')}}"></script>
<!-- Vendor js -->
<script src="{{asset('js/vendor.min.js')}}"></script>

<!-- App js -->
<script src="{{ asset('js/app.min.js') }}"></script>
<script src="{{ asset('js/scrollPositionSaver.js') }}"></script>

</html>