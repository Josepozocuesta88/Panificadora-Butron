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
    /* Estilos para pantallas pequeñas (ejemplo: hasta 576px) */
    @media (max-width: 576px) {
      .container-fluid {
        max-height: 2vh !important;
        /* !important para sobreescribir estilos en línea */
      }

    }

    /* Estilos para pantallas medianas (ejemplo: de 577px a 992px) */
    @media (min-width: 577px) and (max-width: 992px) {
      .container-fluid {
        max-height: 10vh !important;
      }
    }

    .commingSon {
      margin-top: -50%;
      position: absolute;
      font-size: 5rem;
      color: white;
      font-weight: bold;
      text-align: center;
      /* Centrar el texto para mejor apariencia en pantallas pequeñas */
    }

    .sub-commingSon {
      margin-top: -40%;
      position: absolute;
      font-size: 2rem;
      color: white;
      font-weight: bold;
      text-align: center;
      /* Centrar el texto para mejor apariencia en pantallas pequeñas */
    }

    .container {
      display: flex;
      align-items: center;
      justify-content: center;
      justify-items: center;
      text-align: center;
      /* Centrar el texto para mejor apariencia en pantallas pequeñas */
    }
  </style>

  <!-- Vite -->
  @vite('resources/sass/app.scss')

</head>

<body class="bg-white">


  <section class="position-sticky">
    <div class="position-absolute top-0 w-100 z-1">
      <nav class="navbar navbar-expand-2xl navbar-light bg-primary pt-3">
        <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 12vh;">
          <a class="navbar-brand d-md-none position-absolute  translate-middle-y" style="margin-top: 5vh;" href="#">
            <img src="{{ asset(config('app.logo')) }}" alt="Logo pequeño" width="100">
          </a>
          <div class="d-none d-md-flex justify-content-center flex-grow-1">
            <a class="" style="margin-bottom: -71px; margin-left:11rem; margin-top: -80px;" href="#">
              <img src="{{ asset(config('app.logo')) }}" alt="Logo grande" width="190">
            </a>
          </div>
          <div class="d-flex" style="height: 50px;">
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
    </div>

    <div>
      <div class="">
        <img src="{{ asset(config('app.hero_index')) }}" class="img-fluid w-100"
          style="height: 100vh; object-fit: cover; object-position: bottom;" alt="Imagen principal">
        <div
          style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: black; opacity: 0.75;">
        </div>
      </div>
    </div>
  </section>

  <div class="container">
    <h1 class="commingSon">PÁGINA EN CONSTRUCCIÓN</h1>
    <h4 class="sub-commingSon">Estamos trabajando para ofrecerte una mejor experiencia. <br /> ¡Vuelve pronto! </h4>
  </div>

  <div class=" row pe-0 mx-0">
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
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 col-lg-3 p-3">
          <div class="widget widget-about">
            <img src="{{ asset(config('app.logo')) }}" class="footer-logo mb-3" alt="Florys"
              style="max-width: 220px; margin: auto;">

            <div class="d-flex border border-primary py-2 px-3 m-2 ">
              <i class="ri-phone-fill font-25"></i>
              <div class="ps-2">
                ¿Alguna duda? ¡Llámanos!
                <a href="tel:+34607047099">607 047 099</a>
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