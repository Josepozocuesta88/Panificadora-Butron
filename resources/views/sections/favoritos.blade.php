@extends('layouts.app')

@section('content')
<div class="container-fluid bg-light pb-3">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('search') }}">Productos</a></li>

                        <li class="breadcrumb-item active">Favoritos</li>
                    </ol>
                </div>
                <h4 class="page-title">Mis Favoritos</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- CARDS DE PRODUCTOS -->

    <section class="py-5">

        <div class="container">
            <h3 class="text-primary pb-2">Mis Favoritos</h3>

            <div class="row row-cols-1 row-cols-md-4 g-4 p-3">
                @if($articulos->isNotEmpty())
                @foreach($articulos as $articulo)
                <div class="col">

                    <div class="card h-100 border border-primary rounded-3 shadow-lg position-relative">
                        <!-- Ícono de la corazon -->
                        <i onclick="heart(this)" data-artcod="{{$articulo->artcod}}"
                            class="bi bi-suit-heart-fill red-heart position-absolute top-0 end-0 m-2 font-20 cursor-pointer heartIcon"></i>


                        <figure class="d-flex bg-white overflow-hidden align-items-center justify-content-center m-0"
                            style="height:325px;">
                            <a href="{{route('info', ['artcod' => $articulo->artcod])}}" class="d-block">
                            @if($articulo->imagenes->isNotEmpty())
                            <img src="{{ asset('images/articulos/' . $articulo->imagenes->first()->imanom) }}"
                                class="d-block w-100 h-auto" alt="{{ $articulo->artnom }}"
                                title="{{ $articulo->artnom }}"
                                onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                            @else
                            <img src="{{ asset('images/articulos/noimage.jpg') }}" class="d-block w-100 h-auto"
                                alt="no hay imagen" title="No hay imagen">
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
                                        <a class="pe-2" href="{{route('info', ['artcod' => $articulo->artcod])}}"
                                            data-toggle="fullscreen" title="">
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
                                        <a class="pe-2" href="{{route('info', ['artcod' => $articulo->artcod])}}"
                                            data-toggle="fullscreen" title="Información">
                                            <i class="mdi mdi-information-outline font-24"></i>
                                        </a>
                                    </div>
                                    <div class="text-end">
                                        @if ($articulo->precioOferta)
                                        <h5>
                                            <span class="badge badge-danger-lighten">
                                                OFERTA
                                                @if($articulo->precioDescuento)
                                                {{$articulo->precioDescuento}}%
                                                @endif
                                            </span>
                                        </h5>
                                        <span class="font-18 text-danger fw-bolder"> {{ $articulo->precioOferta }}
                                            €</span>
                                        <span class="text-decoration-line-through font-14 ">
                                            {{ $articulo->precioTarifa }} €</span>
                                        @else
                                        <span class="font-18"> {{ $articulo->precioTarifa }} €</span>
                                        @endif
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


                @else
                <div class="alert alert-primary container text-center mt-3" role="alert">
                    <i class="bi bi-suit-heart-fill me-1 align-middle font-22"></i>
                    <strong>Aún no has añadido ningún producto a favoritos.</strong>
                </div>


                @endif
            </div>
            {{ $articulos->links('vendor.pagination.bootstrap-5') }}
        </div>
    </section>

    <!-- FIN CARDS DE PRODUCTOS -->
@endsection


@push('scripts')
    <script src="{{ asset('js/Ajax/favorites.js') }}"></script>
@endpush