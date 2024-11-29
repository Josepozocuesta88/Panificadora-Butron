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

  <!-- ajax cart update qty -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
  <!-- App favicon -->
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

  <!-- App css -->
  <link href="{{asset('css/app-saas.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

  <!-- Iconos -->
  <link href="{{asset('css/icons.css') }}" rel="stylesheet" type="text/css" />
  <!-- Css personalizado -->
  <link href="{{asset('build/assets/app-7f9c8fa3.css') }}" rel="stylesheet" type="text/css" />

  <link href="{{asset('css/css.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>

</html>
<div class="pb-3 container-fluid bg-light">
  <!-- start page title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <div class="page-title-right">
          <ol class="m-0 breadcrumb">
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

  <!-- CARDS DE PRODUCTOS -->

  <section class="py-5" id="productos">
    <div class="container">
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
                <img src="{{ asset('images/articulos/noimage.jpg') }}" class="h-auto d-block w-100" alt="no hay imagen"
                  title="No hay imagen">
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

                <li class="list-group-item d-flex justify-content-between align-items-center">


                </li>
              </ul>
            </div>
          </div>
        </div>
        @endforeach

        @endif
      </div>
      {{ $articulos->links('vendor.pagination.bootstrap-5') }}
    </div>
  </section>
  </body>

  <!-- FIN CARDS DE PRODUCTOS -->


  @push('scripts')
  <script src="{{ asset('js/checkbox.js') }}"></script>
  <script src="{{ asset('js/scrollbar.js') }}"></script>
  <script src="{{ asset('js/Ajax/favorites.js') }}"></script>
  @endpush