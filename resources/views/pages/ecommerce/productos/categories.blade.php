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
                        <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">eCommerce</a></li> -->
                        <li class="breadcrumb-item active">Categorías</li>
                    </ol>
                </div>
                <h4 class="page-title">Categorías Disponibles</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- categorias disponibles -->
    <div class="card p-3">
        <!-- categorias disponibles -->
        <div class="row justify-content-center">
            @foreach($categorias as $category)
            <div class="categoria col-2 d-block position-relative p-0 m-2">
                <a href="{{ route('categories', ['catcod' => $category->id]) }}" title="" onclick="irAProductos()">
                    <img src="{{ asset('images/categorias/' . $category->imagen) }}"
                        class="object-fit-fill border rounded" alt="{{ $category->nombre_es }}"
                        style="height:200px; width:100%;"
                        onerror="this.onerror=null; this.src='{{ asset('images/articulos/noimage.jpg') }}';">
                </a>
                <div class="nombre-categoria bg-primary text-center">
                    <h5>
                        <a href="{{route('categories', ['catcod' => $category->id])}}" class="text-white"
                            onclick="irAProductos()">
                            {{ $category->nombre_es }}
                        </a>
                    </h5>
                    <a href="{{route('categories', ['catcod' => $category->id])}}" onclick="irAProductos()"
                        class="categoria-link text-warning font-20">Ver más <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            @endforeach
        </div>
    </div>


</div>
<!-- fin categorias disponibles -->
@endsection


@push('scripts')
<script src="{{ asset('js/checkbox.js') }}"></script>
<script src="{{ asset('js/scrollbar.js') }}"></script>
<script src="{{ asset('js/Ajax/favorites.js') }}"></script>
@endpush