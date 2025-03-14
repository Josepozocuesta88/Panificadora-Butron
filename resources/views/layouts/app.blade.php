<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Creada en 1985, Repostería Flory´s distribuye en toda Andalucía una amplia gama de productos de Pastelería, Granel tradicional, Granel envuelto, Aperitivos y Productos integral sin azúcar.">
  <meta name="keywords" content="florys, respoteria, baena, dulces">
  <meta name="Author" content="gabinetetic.com">
  <meta name="copyright" content="gabinetetic.com">
  <meta name="Robots" content="all">
  <meta name="Distribution" content="Global">
  <meta name="Revisit-After" content="30 days">
  <meta name="Rating" content="General">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Coderthemes" name="author" />

  <title>Repostería Florys | Baena (Córdoba)</title>


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

  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/searchpanes/2.3.3/css/searchPanes.dataTables.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/select/3.0.0/css/select.dataTables.css" rel="stylesheet">

  <!-- Vite -->
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
      @include('layouts.footer')
    </div>
  </div>

  <footer>

    <!-- Vendor js -->
    <script src="{{asset('js/vendor.min.js')}}"></script>

    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>

    <!-- FullCalendar js -->
    <script src="{{asset('vendor/fullcalendar/main.min.js')}}"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.3.3/js/dataTables.searchPanes.min.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.3.3/js/searchPanes.dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/select/3.0.0/js/dataTables.select.js"></script>
    <script src="https://cdn.datatables.net/select/3.0.0/js/select.dataTables.js"></script>

    <!-- Charts js -->
    <script src="{{ asset('vendor/chart.js/chart.min.js ')}}"></script>
    <script src="{{ asset('vendor/apexcharts/apexcharts.min.js ')}}"></script>

    <!-- Vector Map js -->
    <script src="{{ asset('vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- Cart -->
    <script src="{{ asset('js/Ajax/cart.js') }}"></script>

    <!-- Histórico -->
    <script src="{{ asset('js/scrollPositionSaver.js') }}"></script>

    @stack('scripts')
  </footer>

</body>

</html>