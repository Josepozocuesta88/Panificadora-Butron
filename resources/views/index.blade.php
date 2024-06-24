<!-- ============================================================== -->
<!-- TODOS: Página principal de inicio -->
<!-- ============================================================== -->


@extends('layouts.app')

@section('content')

<div class="container py-5">

    <!-- carrusel imagenes -->
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
        <div class="carousel-inner">
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


    <!-- end carrusel imagenes -->


    <!-- novedades -->
    <div class="container mt-3">
        <div class="row mb-3">
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
        <div class="row mb-3">
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
        <div class="row pt-4">
            <div class="col-lg-12">
                <div class="nav nav-tabs text-dark ">
                    <h3>Histórico de compras</h3>
                </div>
            </div>
        </div>
        <div class="table-responsive pt-3">
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