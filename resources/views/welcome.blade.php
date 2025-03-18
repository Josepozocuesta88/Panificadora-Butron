<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Laravel') }}</title>


  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ asset(config('app.favicon')) }}">

  <!-- Theme Config JS -->
  <script src="{{asset('js/hyper-config.js')}}"></script>

  <!-- Vendor CSS -->
  <link href="{{ asset('css/vendor.min.css') }}" rel="stylesheet" type="text/css" />

  <!-- App CSS -->
  <link href="{{asset('css/app-saas.css')}}" rel="stylesheet" type="text/css" id="app-style" />
  <link href="{{asset('css/css.css')}}" rel="stylesheet" type="text/css" />

  <!-- Iconos -->
  <link href="{{asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />

  <style>
    .etiqueta {
      display: inline-block;
      background: #fff;
      color: #340051;
      padding: 0.4em 1.5em;
      font-size: 0.8rem;
      /* Usar rem para escalabilidad */
      font-weight: bold;
      border: 2px solid #340051;
      border-bottom-width: 4px;
      border-radius: 1.25em 1.25em 0 0;
      box-shadow: 0 0.125em 0.3125em rgba(0, 0, 0, 0.1);
      margin-bottom: -0.25em;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      text-align: center;
      z-index: 0;
    }

    .btn-catalogo {
      display: inline-block;
      padding: 0.75em 2.5em;
      /* Ajustar con em para que escale */
      font-size: 1rem;
      /* Responsivo con rem */
      color: #fff;
      background: linear-gradient(90deg, #5c2b87, #b59ec9);
      border: 2px solid #340051;
      border-radius: 0 0 0.75em 0.75em;
      font-weight: 500;
      text-transform: capitalize;
      letter-spacing: 0.03em;
      cursor: pointer;
      position: relative;
      z-index: 1;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-catalogo:hover {
      transform: scale(1.05);
      box-shadow: 0 0.375em 0.75em rgba(0, 0, 0, 0.15);
    }

    .d-flex-column-centered {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .margen-abajo {
      margin-top: -120vh;
      margin-bottom: 10vh;
      /* Usar vh para un margen dinámico según la altura de la pantalla */
    }

    @media (max-width: 768px) {
      .responsive-style {
        width: 100vw;
        height: 100vh;
        object-fit: contain;
        object-position: top;
        margin-top: 100px;
        margin-bottom: -170%;
      }
    }

    @media (min-width: 768px) {
      .responsive-style {
        width: 100vw;
        height: 100vh;
        object-fit: contain;
        object-position: top;
        margin-bottom: 120px;
      }
    }
  </style>

  <!-- Vite -->
  @vite('resources/sass/app.scss')

</head>

<body class="bg-white">
  <section class="position-stick">
    <div class="position-absolute top-0">
      <nav class="navbar navbar-expand-2xl navbar-light bg-primary pt-3">
        <div class="container-fluid d-flex justify-content-between align-items-center">
          <!-- Logo pequeño visible solo en pantallas pequeñas -->
          <a class="navbar-brand d-block d-md-none" href="#">
            <img src="{{ asset(config('app.logo')) }}" alt="Logo pequeño" width="100">
          </a>

          <!-- Logo grande visible solo en pantallas medianas y superiores -->
          <div class="d-none d-md-flex justify-content-center flex-grow-1">
            <a class="" href="#" style="margin-bottom: -71px; margin-left:8rem">
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
      <div>
        <img src="{{ asset('images/web/navbar.png') }}" style="margin:auto;margin-top:-2px; width:100vw;" alt="navbar">
      </div>
    </div>
    <div>
      <img src="{{ asset(config('app.hero_index')) }}" class="img-fluid responsive-style" {{--
        style="width:100vw; height:100vh; object-fit: cover; object-position: bottom;" --}} alt="Imagen principal">
    </div>
  </section>
  <div class="container pb-3" style="top:-400px; bottom:0%;">
    <div class="d-flex flex-column justify-content-center align-items-center margen-abajo">
      <div class="etiqueta">¿Aún no eres cliente?</div>
      <a href="{{ route('productsnologin') }}" class=" btn-catalogo"> Visite nuestro catálogo</a>
    </div>
    <!-- novedades y ofertas -->
    {{-- <ul class="nav nav-pills bg-nav-pills nav-justified mb-3 ">
      <li class="nav-item bg-white">
        <a href="#novedades" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
          <i class="bi bi-lightbulb d-md-none d-block"></i>
          <h2 class="d-none d-md-block">Novedades</h2>
        </a>
      </li>
      <li class="nav-item bg-white">
        <a href="#ofertas" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
          <i class="bi bi-percent d-md-none d-block"></i>
          <h2 class="d-none d-md-block">Ofertas</h2>
        </a>
      </li>
    </ul> --}}

    <div class="tab-content pb-5">
      {{-- <div class="tab-pane show active" id="novedades">
        <!-- novedades -->
        <x-novedades :novedades="$novedades" />
        <!-- fin novedades -->
      </div> --}}
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
      <div class="categoria col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 d-block position-relative p-0 m-2">
        <a href="{{ route('categories', ['catcod' => $category->catcod]) }}" title="" onclick="irAProductos()">
          <img src="{{ asset('images/categorias/' . $category->catima) }}" class="object-fit-fill border rounded"
            alt="{{ $category->catnom }}" style="height:300px; width:100%;r"
            onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
        </a>
        <div class="nombre-categoria bg-primary text-center">
          <h3>
            <a href="{{route('categories', ['catcod' => $category->catcod])}}" class="text-white"
              onclick="irAProductos()">
              {{ $category->catnom }}
            </a>
          </h3>
          <a href="{{route('categories', ['catcod' => $category->catcod])}}" onclick="irAProductos()"
            class="categoria-link text-warning font-20">Ver más <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <div class="row pe-0 mx-0">
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

    <!-- Vendor js -->
    <script src="{{asset('js/vendor.min.js')}}"></script>

    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>

    <script src="{{asset('js/scrollbar.js')}}"></script>

    <script src="{{ asset('js/scrollPositionSaver.js') }}"></script>


  </footer>

</body>

</html>