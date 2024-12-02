<!-- ============================================================== -->
<!-- CLIENTE: Para ver histórico de productos que ha comprado -->
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
                        <li class="breadcrumb-item active">{{$doctip}}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{$doctip}}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    @if (session('error'))
    <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 1050;">
        <div class="toast show bg-primary" data-bs-delay="5000">
            <div class="toast-header">
                <strong class="mr-auto text-primary">Alerta</strong>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Cerrar"></button>
            </div>
            <div class="toast-body text-white">
                {{ session('error') }}
            </div>
        </div>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-end px-3">
        <div class="">
            @if(request()->is('documentos/Facturas'))
            <label class="form-label" for="estadoFiltro">Filtrar:</label>
            <select id="estadoFiltro" class="form-select">
                <option value="todas">Todas</option>
                <option value="1">Pagadas</option>
                <option value="0">Pendientes</option>
                <option value="2">Procesando</option>
            </select>
            @endif
        </div>
        <div class="">
            <a href="{{ route('documentos.347') }}" id="r347" name="r347" class="btn btn-primary">Resumen 347</a>
        </div>
    </div>



    <div class="row ">
        <div class="col-13">
            <div class="card">
                <div class="card-body">
                    <table id="tablaDocumentos" class="table table-centered w-100 dt-responsive nowrap"
                        data-doctip="{{ $doctip ?? '' }}">
                        <thead class="table-light">

                        </thead>
                        <tbody></tbody>
                    </table>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->



<!--  -->


@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/Ajax/document.js') }}"></script>


<script>


</script>



@endpush