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
                        <li class="breadcrumb-item"><a href="{{ route('search') }}">Productos</a></li>
                        <li class="breadcrumb-item active">Histórico de compras</li>
                    </ol>
                </div>
                <h4 class="page-title">Histórico de tus compras</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <!-- admin -->
                        <!-- <div class="col-sm-5">
                            <a href="javascript:void(0);" class="btn btn-danger mb-2"><i
                                    class="mdi mdi-plus-circle me-2"></i> Add Products</a>
                        </div> -->
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered w-100 dt-responsive nowrap" id="history-datatable">
                            <thead class="table-light">
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Fecha Ultima Compra</th>
                                    <th>Precio Ultima Compra</th>
                                    <th>Precio Venta Actual</th>
                                    <th>Cantidad Total</th>
                                    <!-- <th>Estado</th> -->
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->
@endsection


@push('scripts')
    <script src="{{ asset('js/Ajax/history.js') }}"></script>

    <script>
        cargarRejilla();
    </script>
@endpush