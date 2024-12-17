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
        <div class="container-fluid px-3 d-flex justify-content-between align-items-center">
          <!-- Logo pequeño visible solo en pantallas pequeñas -->
          <a class="navbar-brand d-block d-md-none" href="#">
            <img src="{{ asset(config('app.logo')) }}" alt="Logo pequeño" width="100">
          </a>

          <!-- Logo grande visible solo en pantallas medianas y superiores -->
          <div class="d-none d-md-flex justify-content-center flex-grow-1 ps-5">
            <a class="d-md-block" href="#" style="margin-bottom: -71px;">
              <img src="{{ asset(config('app.logo')) }}" alt="Logo" width="220">
            </a>
          </div>

          <!-- Iconos de navegación -->
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

      <img src="{{ asset('images/web/navbar.png') }}" style="margin:auto; width:100vw;" alt="navbar">
      <div class="justify-content-center d-flex mt-5">
        <a href="{{ route('productsnologin') }}" class="btn btn-primary">VER NUESTRO CATALOGO</a>
      </div>
    </div>
    <div>
      <img src="{{ asset(config('app.hero_index')) }}"
        style="width:100vw; height:100vh; object-fit: cover; object-position: bottom;" alt="Imagen principal">
    </div>
  </section>



  <div class="container pb-3 position-relative" style="top: -400px;">
    <!-- novedades y ofertas -->
    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
      <li class="nav-item">
        <a href="#novedades" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
          <i class="bi bi-lightbulb d-md-none d-block"></i>
          <h2 class="d-none d-md-block">Novedades</h2>
        </a>
      </li>
      <li class="nav-item">
        <a href="#ofertas" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
          <i class="bi bi-percent d-md-none d-block"></i>
          <h2 class="d-none d-md-block">Ofertas</h2>
        </a>
      </li>

    </ul>

    <div class="tab-content pb-5">
      <div class="tab-pane show active" id="novedades">

        <!-- novedades -->
        <x-novedades :novedades="$novedades" />
        <!-- fin novedades -->
      </div>
      <div class="tab-pane" id="ofertas">
        <!-- ofertas -->
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
          <!-- Indicadores del Carrusel -->
          <div class="carousel-indicators">
            @foreach($ofertas as $index => $image)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}"
              class="{{ $loop->first ? 'active' : '' }}" aria-current="{{ $loop->first ? 'true' : 'false' }}"
              aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
          </div>

          <!-- Elementos del Carrusel -->
          <div class="carousel-inner pb-3">
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
        <!-- fin ofertas -->
      </div>
    </div>
    <!-- fin novedades y ofertas -->

    <!-- categorias disponibles -->
    <h2 class="text-primary py-3">Nuestro Catálogo</h2>
    <div class="row justify-content-center">
      @foreach($categories as $category)
      <div class="categoria col-4 col-sm-3 d-block position-relative p-0 m-2">
        <a href="{{ route('categories', ['catcod' => $category->id]) }}" title="" onclick="irAProductos()">
          <img src="{{ asset('images/categorias/' . $category->imagen) }}" class="object-fit-fill border rounded"
            alt="{{ $category->nombre_es }}" style="height:300px; width:100%;"
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


  <div class="row pt-5 pe-0 mx-0">
    <div class="col-12 bg-light pe-0 pt-1">
      <iframe src="{{ config('app.maps') }}" height="400" style="width: 100%; border: 0;" allowfullscreen=""
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