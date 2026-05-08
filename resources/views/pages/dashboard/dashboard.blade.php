<!-- ======================================================================================= -->
<!-- CLIENTE o TODOS: Dashboard -->
<!-- ======================================================================================= -->

@extends('layouts.app')

@section('content')
<div class="content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ul class="nav nav-tabs nav-bordered mb-2">
                            <li class="nav-item">
                                <button onclick="ajaxGraph('mesActual')" data-bs-toggle="tab" aria-expanded="true" class="nav-link py-2">
                                    Mes Actual
                                    ( {{ \Carbon\Carbon::now()->subMonth()->format('d/m') }} - {{ \Carbon\Carbon::now()->format('d/m') }} )
                                </button>
                            </li>
                            <li class="nav-item">
                                <button onclick="ajaxGraph('ultimoMes')" data-bs-toggle="tab" aria-expanded="true" class="nav-link py-2">
                                    Último Mes
                                    ( {{ \Carbon\Carbon::now()->startOfMonth()->format('d/m') }} - {{ \Carbon\Carbon::now()->format('d/m') }} )
                                </button>
                            </li>
                            <li class="nav-item">
                                <button onclick="ajaxGraph('trimestreActual')" data-bs-toggle="tab" aria-expanded="true" class="nav-link py-2">
                                    Trimestre Actual
                                    ( {{ \Carbon\Carbon::now()->startOfQuarter()->format('d/m') }} - {{ \Carbon\Carbon::now()->endOfQuarter()->format('d/m') }} )
                                </button>
                            </li>
                            <li class="nav-item">
                                <button onclick="ajaxGraph('ultimoTrimestre')" data-bs-toggle="tab" aria-expanded="true" class="nav-link py-2">
                                    Último Trimestre
                                    ( {{ \Carbon\Carbon::now()->subQuarter()->startOfQuarter()->format('d/m') }} - {{ \Carbon\Carbon::now()->subQuarter()->endOfQuarter()->format('d/m') }} )
                                </button>
                            </li>
                            <li class="nav-item">
                                <button onclick="ajaxGraph('anioActual')" data-bs-toggle="tab" aria-expanded="true" class="nav-link py-2">
                                    Año Actual
                                    ( {{ \Carbon\Carbon::now()->startOfYear()->format('Y') }} )
                                </button>
                            </li>
                            <li class="nav-item">
                                <button onclick="ajaxGraph('utlimoAnio')" data-bs-toggle="tab" aria-expanded="true" class="nav-link active py-2">
                                    Último Año
                                    ( {{ \Carbon\Carbon::now()->subYear()->startOfYear()->format('Y') }} )
                                </button>
                            </li>
                            <li>
                                <button href="javascript(0);" onclick="location.reload()" class="btn btn-primary ms-3">
                                    <i class="mdi mdi-autorenew"></i>
                                </button>
                            </li>
                        </ul>

                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-xl-3 col-lg-4">
                <div class="card tilebox-one">
                    <div class="card-body">
                        <i class='bi bi-bag float-end'></i>
                        <h6 class="text-uppercase mt-0">Pedidos realizados</h6>
                        <h2 class="my-2" id="ordersCount"></h2>
                    </div> <!-- end card-body-->
                </div>
                <!--end card-->

                <div class="card tilebox-one">
                    <div class="card-body">
                        <i class='bi bi-cash float-end'></i>
                        <h6 class="text-uppercase mt-0">Importe de Compras</h6>
                        <h2 class="my-2" id="purchaseAmount"></h2>
                    </div> <!-- end card-body-->
                </div>
                <!--end card-->

                <div class="card tilebox-one">
                    <div class="card-body">
                        <i class='bi bi-wallet float-end'></i>
                        <h6 class="text-uppercase mt-0">Saldo de la cuenta</h6>
                        <h2 class="my-2" id="accountBalance"></h2>
                    </div> <!-- end card-body-->
                </div>
                <!--end card-->
            </div> <!-- end col -->

            <div class="col-xl-9 col-lg-8">
                <div class="card card-h-100">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Compras por Meses</h4>

                        <div dir="ltr">
                            <div id="sessions-overview" class="apex-charts mt-3" data-colors="#0acf97"></div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="header-title">Top 10 Artículos Más Comprados</h4>
                    </div>

                    <div class="card-body pt-0">

                        <div class="table-responsive">
                            <table class="table table-sm table-centered mb-0 font-14">
                                <thead class="table-light">
                                    <tr>
                                        <th>Cód.</th>
                                        <th style="width: 34%;">Nombre</th>
                                        <th>Unidades Compradas</th>
                                        <th>Total invertido</th>
                                        <th>Comprar de nuevo</th>
                                    </tr>
                                </thead>
                                <tbody id="top-10-tbody">
                                    <!-- <td>
                                            <div class="progress" style="height: 3px;">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: 65%; height: 20px;" aria-valuenow="65"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td> -->
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive-->
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

        </div>
        <!-- end row -->

    </div>
</div>


@endsection

@push('scripts')
<script src="{{ asset('js/Ajax/dashboard.js') }}"></script>

@if(session('success'))
<script>
    showToast("{{ session('success') }}", "success");
</script>
@elseif(session('error'))
<script>
    showToast("{{ session('error') }}", "error");
</script>
@endif

<script>
    ajaxGraph();

    function showToast(message) {
        const toastContainer = document.createElement('div');
        toastContainer.setAttribute('aria-live', 'polite');
        toastContainer.setAttribute('aria-atomic', 'true');
        toastContainer.style.position = 'fixed';
        toastContainer.style.top = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '1050';

        const toast = document.createElement('div');
        toast.classList.add('toast', 'show', 'bg-primary');
        toast.setAttribute('data-bs-delay', '5000');

        const toastHeader = document.createElement('div');
        toastHeader.classList.add('toast-header');

        const strong = document.createElement('strong');
        strong.classList.add('mr-auto', 'text-primary');
        strong.innerText = 'Alerta';

        const button = document.createElement('button');
        button.type = 'button';
        button.classList.add('btn-close', 'me-2', 'm-auto');
        button.setAttribute('data-bs-dismiss', 'toast');
        button.setAttribute('aria-label', 'Cerrar');

        const toastBody = document.createElement('div');
        toastBody.classList.add('toast-body', 'text-white');
        toastBody.innerText = message;

        toastHeader.appendChild(strong);
        toastHeader.appendChild(button);
        toast.appendChild(toastHeader);
        toast.appendChild(toastBody);
        toastContainer.appendChild(toast);

        document.body.appendChild(toastContainer);

        setTimeout(() => {
            toast.classList.remove('show');
            document.body.removeChild(toastContainer);
        }, 5000);
    }
</script>
@endpush