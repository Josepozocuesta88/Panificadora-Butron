<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <title>Panificadora Butrón | Chiclana de la Frontera (Cádiz)</title>

  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta name="keywords" content="panificadora, butrón, chiclana, frontera, cádiz">
  <meta name="Author" content="gabinetetic.com">
  <meta name="copyright" content="gabinetetic.com">
  <meta name="Robots" content="all">
  <meta name="Distribution" content="Global">
  <meta name="Revisit-After" content="30 days">
  <meta name="Rating" content="General">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Coderthemes" name="author" />

  <link rel="shortcut icon" href="{{ asset(config('app.favicon')) }}">

  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

  <link href="{{asset('vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />

  <link href="{{asset('css/app-saas.css')}}" rel="stylesheet" type="text/css" id="app-style" />
  <link href="{{asset('css/icons.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{asset('css/css.css') }}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://unpkg.com/dropzone@5.9.3/dist/min/dropzone.min.css" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <script src="{{asset('js/hyper-config.js')}}"></script>

  @yield('css')
  @vite('resources/sass/app.scss')
  @stack('header')
</head>

<body>
  <div class="wrapper">
    @include('layouts.navbar')

    <div class="fotobackground">
      <div class="content-page @if(!auth::user()) ms-0 @endif">
        <x-success-alert />
        <x-error-alert />
        @yield('content')
      </div>
    </div>
  </div>

  <footer class="footer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
          <div class="text-md-end footer-links d-none d-md-block">
            <a href="{{ route('privacidad') }}">Política de Privacidad</a>
            <a href="{{ route('cookies') }}">Política de Cookies</a>
            <a href="{{ route('redes') }}">Política de Privacidad Redes Sociales</a>
            <a href="{{ route('avisoLegal') }}">Aviso Legal</a>
            <a href="">Contáctanos</a>
          </div>
        </div>
      </div>
    </div>

    <script src="{{asset('js/vendor.min.js')}}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>

    <script src="{{ asset('vendor/chart.js/chart.min.js ')}}"></script>
    <script src="{{ asset('vendor/apexcharts/apexcharts.min.js ')}}"></script>

    <script src="{{ asset('vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"></script>

    <script src="{{ asset('js/Ajax/cart.js') }}"></script>

    <script src="{{ asset('js/scrollPositionSaver.js') }}"></script>

    <script src="{{asset('vendor/fullcalendar/main.min.js')}}"></script>

    <script src="https://unpkg.com/dropzone@5.9.3/dist/min/dropzone.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script defer src="https://downloads-global.3cx.com/downloads/livechatandtalk/v1/callus.js" id="tcx-callus-js" charset="utf-8"></script>

    @stack('scripts')
  </footer>
</body>

</html>