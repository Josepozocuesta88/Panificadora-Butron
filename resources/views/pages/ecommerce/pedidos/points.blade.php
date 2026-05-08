<!-- ============================================================== -->
<!-- CLIENTE: Para ver los puntosque ha acumulado -->
<!-- ============================================================== -->
<!-- VER SI SE PUEDE MEZCLAR CON LA PAGINA DE PRODUCTOS DEL ADMINISTRADOR -->


@extends('layouts.app')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('search') }}">Productos</a></li>
                        <li class="breadcrumb-item active">Tus Puntos</li>
                    </ol>
                </div>
                <h4 class="page-title">Tus Puntos</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class = "position-relative pb-3" style="max-width:1200px;  margin: 0 auto;">
                    <h3 class="position-absolute top-50  ps-5">¡Has acumulado {{$puntos}} puntos!</h3>
                        <img src="{{ asset(config('app.hero_gift')) }}" style="object-fit: cover; background-position: center; width:1200px; height:400px;" class="img-fluid"
                            alt="Imagen principal">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered w-100 dt-responsive nowrap" id="points">
                            <thead class="table-light">
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Fecha Compra</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Puntos</th>
                                </tr>
                            </thead>

                        </table>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
    <div class="gift-container">
        <i id="gift-icon" class="mdi mdi-gift"></i>
    </div>
</div> <!-- container -->
@endsection


@push('scripts')
<script src="{{ asset('js/Ajax/points.js') }}"></script>
@endpush