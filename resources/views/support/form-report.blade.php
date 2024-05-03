@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Soporte Técnico</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">

            @if(session('success') || session('error'))
            <div class="alert alert-{{ session('success') ? 'success' : 'danger' }}">
                {{ session('success') ?: session('error') }}
            </div>
            @endif
            <h3 class=" text-primary text-center">Informar sobre un error:</h3>
            <form action="{{ route('reportar.error') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="error" class="form-label">Resúmenos en qué consistía el error.</label>
                    <input type="text" class="form-control" id="error" name="error" required>
                </div>
                <div class="mb-3">
                    <label for="ubicacion" class="form-label">¿Dónde te has encontrado el error?</label>
                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                </div>
                <div class="mb-3">
                    <label for="pasos" class="form-label">Pasos Seguidos</label>
                    <textarea class="form-control" id="pasos" name="pasos" rows="6" placeholder="Enumera los pasos seguidos antes de que se produjera el error:
                        1....
                        2....
                        3....
                        Resultado esperado:
                        Resultado obtenido:" required></textarea>
                </div>


                <button type="submit" class="btn btn-primary">Enviar Reporte</button>
            </form>

        </div>
    </div>
</div>

@endsection