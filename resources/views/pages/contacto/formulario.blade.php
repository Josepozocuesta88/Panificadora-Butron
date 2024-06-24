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
                        <li class="breadcrumb-item active">Contacto</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="container">

        @if(session('success') || session('error'))
        <div class="alert alert-{{ session('success') ? 'success' : 'danger' }}">
            {{ session('success') ?: session('error') }}
        </div>
        @endif
        <h1 class="my-2 text-center">Contáctanos</h1>
        <!-- <div class="mb-4">
            <h3 class=" text-primary">Nosotros te llamaremos</h3>
            <p class="fs-5">Si lo deseas nosotros te llamamos para resolver tus dudas al teléfono y horario que nos indiques.</p>
            <form action="{{ route('contacto.email') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col mb-3">
                        <label for="nombre" class="form-label">Nombre </label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="col mb-3">
                        <label for="telefono" class="form-label">Teléfono </label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="col mb-3">
                        <label for="cuando" class="form-label">¿Cuándo? </label>
                        <input type="text" class="form-control" id="cuando" name="cuando" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary font-18">Enviar</button>
                
            </form>
        </div> -->

        <div class="mb-4">
            <h3 class=" text-primary ">Atención al cliente</h3>
            <p class="fs-5">Te recordamos que nuestro horario de atención al cliente es de 9.30 a 14 horas (Lunes a Viernes
                laborables).</p>
            <p>Te atenderemos por teléfono en el <span class="fs-4 fw-bold text-primary">957 690 508</span>.</p>
        </div>

        <div class="mb-4">
            <h3 class=" text-primary  mb-3">Consultas por E-mail:</h3>

            <form action="{{ route('contacto.email') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col mb-3">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="col mb-3">
                        <label for="telefono" class="form-label">Teléfono *</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="col mb-3">
                        <label for="asunto" class="form-label">Asunto *</label>
                        <input type="text" class="form-control" id="asunto" name="asunto" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje *</label>
                    <textarea class="form-control" id="mensaje" name="mensaje" rows="6" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary font-18">Enviar E-mail</button>
                
            </form>
        </div>

    </div>
</div>

@endsection