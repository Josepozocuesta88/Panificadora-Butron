<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="description"
    content="Creada en 1985, Repostería Flory´s distribuye en toda Andalucía una amplia gama de productos de Pastelería, Granel tradicional, Granel envuelto, Aperitivos y Productos integral sin azúcar.">
  <meta name="keywords" content="florys, respoteria, baena, dulces">
  <meta name="Author" content="gabinetetic.com">
  <meta name="copyright" content="gabinetetic.com">
  <meta name="Robots" content="all">
  <meta name="Distribution" content="Global">
  <meta name="Revisit-After" content="30 days">
  <meta name="Rating" content="General">
  <title>Profesional Congelados Florys | Baena (Córdoba)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Coderthemes" name="author" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
  <link rel="shortcut icon" href="{{ asset(config('app.favicon')) }}">
  <!-- Datatables css -->
  <link href="{{asset('vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet"
    type="text/css" />
  <link href="{{asset('vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet"
    type="text/css" />
  <link href="{{asset('vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet"
    type="text/css" />
  <link href="{{asset('vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css')}}" rel="stylesheet"
    type="text/css" />
  <!-- Theme Config Js -->
  <script src="{{asset('js/hyper-config.js')}}"></script>
  <!-- Iconos -->
  <link href="{{asset('css/icons.css') }}" rel="stylesheet" type="text/css" />
  <!-- Css personalizado -->
  <link href="{{asset('build/assets/app-7f9c8fa3.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{asset('css/css.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="bg-white">
  <div class="bg-light">
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
    <div>
      <img src="{{ asset('images/web/navbar.png') }}" style="margin:-2px; width:100vw;" alt="navbar">
    </div>
  </div>
  <div class="pb-3 container">
    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box">
          <div class="page-title-right">
            <ol class="m-0 breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Inicio</a></li>
              <li class="breadcrumb-item active">Productos</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="py-5" id="productos">
      <div class="container">
        <div class="gap-3 pb-3 d-flex justify-content-end">
          <!-- Ver todos los productos -->
          @isset($catnom)
          <a class="btn btn-primary" href="{{ route('search') }}">Ver todos los productos</a>
          @endisset
          <!-- ver todas las categorías -->
          <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#categoriasCollapse"
            aria-expanded="false" aria-controls="categoriasCollapse">Categorías</button>
          <!-- fin ver todas las categorías -->
          <!--end Botón para controlar el collapse ordenaciones -->
          <div class="app-search dropdown d-none d-lg-block" style="width: auto;">
            <!-- buscar producto -->
            <form method="GET" action="{{ route('searchNoLogin') }}">
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
        <!--end Collapse ordenaciones  -->
        <!-- Collapse categorias  -->
        <div class="collapse" id="categoriasCollapse">
          <div class="p-3 card">
            <x-categorias_logout :categorias="$categorias" />
          </div>
        </div>
        <!--end Collapse categorias  -->
        <div class="p-3 row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
          @if($articulos->isNotEmpty())
          @foreach($articulos as $articulo)
          <div class="col">
            <div class="border shadow-lg card h-100 border-primary rounded-3 position-relative">
              <figure class="m-0 overflow-hidden bg-white d-flex align-items-center justify-content-center"
                style="height:325px;">
                <a href="{{route('info', ['artcod' => $articulo->artcod])}}" class="d-block">
                  @if($articulo->imagenes->isNotEmpty())
                  <img src="{{ asset('images/articulos/' . $articulo->imagenes->first()->imanom) }}"
                    class="h-auto d-block w-100" alt="{{ $articulo->artnom }}" title="{{ $articulo->artnom }}"
                    onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                  @else
                  <img src="{{ asset('images/articulos/noimage.jpg') }}" class="h-auto d-block w-100"
                    alt="no hay imagen" title="No hay imagen">
                  @endif
                </a>
              </figure>
              <div class="pb-0 bg-white card-body">
                <a href="{{route('info', ['artcod' => $articulo->artcod])}}">
                  <h5 class="m-0 card-title text-primary">{{ $articulo->artnom }}</h5>
                  @isset($articulo->artobs)<p class="card-text l3truncate">{{$articulo->artobs}}</p>@endisset
                </a>
              </div>
              <div class="pt-0 card-footer">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center"></li>
                </ul>
              </div>
            </div>
          </div>
          @endforeach
          @else
          <div class="container text-center alert alert-primary" role="alert">
            <i class="align-middle ri-information-line me-1 font-22"></i>
            <strong>Actualmente no disponemos de artículos en esta categoría</strong>
          </div>
          @endif
        </div>
        {{ $articulos->links('vendor.pagination.bootstrap-5') }}
      </div>
    </section>
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
              <li>
                <a href="{{ route('contacto.formulario') }}">Contacto</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <script src="{{asset('js/vendor.min.js')}}"></script>
  <script src="{{ asset('js/checkbox.js') }}"></script>
  <script src="{{ asset('js/scrollbar.js') }}"></script>
</body>

</html>