@extends('layouts.app')

@section('content')
<style>
    .stats-card {
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        height: 80%;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        line-height: 1;
        margin: 0;
    }

    .stats-label {
        font-size: 0.9rem;
        font-weight: 500;
        opacity: 0.8;
        margin: 0;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .action-card {
        border: none;
        border-radius: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transition: all 0.3s ease;
        height: 80%;
    }

    .action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .nav-pills .nav-link {
        border-radius: 12px;
        font-weight: 500;
        padding: 12px 24px;
        margin-right: 8px;
    }

    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    @media (max-width: 768px) {
        .stats-number {
            font-size: 2rem;
        }

        .section-title {
            font-size: 1.3rem;
        }
    }
</style>

<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Herramientas de Gestión</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    <i class="mdi mdi-tools me-2 text-primary"></i>
                    Dashboard de Gestión
                </h4>
            </div>
        </div>
    </div>

    <!-- Navigation Pills -->
    <ul class="nav nav-pills mb-4" id="toolsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="budget-documents-tab" data-bs-toggle="pill" data-bs-target="#budget-documents" type="button" role="tab">
                <i class="mdi mdi-file-document-outline me-2"></i>Presupuestos (Documentos)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="invoice-documents-tab" data-bs-toggle="pill" data-bs-target="#invoice-documents" type="button" role="tab">
                <i class="mdi mdi-receipt me-2"></i>Facturas (Documentos)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="budget-orders-tab" data-bs-toggle="pill" data-bs-target="#budget-orders" type="button" role="tab">
                <i class="mdi mdi-cart-outline me-2"></i>Presupuestos (Pedidos)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="orders-tab" data-bs-toggle="pill" data-bs-target="#orders" type="button" role="tab">
                <i class="mdi mdi-package-variant me-2"></i>Pedidos
            </button>
        </li>
    </ul>
    <div class="tab-content" id="toolsTabsContent">
        <!-- Tab Presupuestos (Documentos) -->
        <div class="tab-pane fade show active" id="budget-documents" role="tabpanel">
            <!-- Statistics Cards -->
            <div class="section-title">
                <i class="mdi mdi-chart-box-outline text-primary"></i>
                Estadísticas de Presupuestos (Documentos)
            </div>

            <div class="row g-3 mb-4">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                                    <i class="mdi mdi-file-multiple"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-primary">{{ $budgetDocumentStats['total'] }}</p>
                                    <p class="stats-label text-muted">Total</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-warning bg-opacity-10 text-warning me-3">
                                    <i class="mdi mdi-clock-outline"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-warning">{{ $budgetDocumentStats['pendientes'] }}</p>
                                    <p class="stats-label text-muted">Pendientes por enviar por email</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-info bg-opacity-10 text-info me-3">
                                    <i class="mdi mdi-send"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-info">{{ $budgetDocumentStats['enviados'] }}</p>
                                    <p class="stats-label text-muted">Enviados por email</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                                    <i class="mdi mdi-check-circle"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-success">{{ $budgetDocumentStats['aceptados'] }}</p>
                                    <p class="stats-label text-muted">Aceptados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-danger bg-opacity-10 text-danger me-3">
                                    <i class="mdi mdi-close-circle"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-danger">{{ $budgetDocumentStats['rechazados'] }}</p>
                                    <p class="stats-label text-muted">Rechazados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card action-card shadow-sm">
                        <div class="card-body p-3 text-center">
                            <div class="mb-2">
                                <i class="mdi mdi-email-send fs-1"></i>
                            </div>
                            <button
                                id="send-budgets-button"
                                type="button"
                                class="btn btn-light btn-sm w-100">
                                Enviar Todos
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="mdi mdi-file-document-outline me-2"></i>
                            Presupuestos
                        </h5>
                        <span class="badge bg-warning">{{ $budgetDocumentStats['pendientes'] }} pendientes de envío por email</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="budget-documents-table" class="table table-hover dt-responsive nowrap" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 8%;">ID</th>
                                    <th style="width: 20%;">Cliente</th>
                                    <th class="text-center" style="width: 6%;">Serie</th>
                                    <th class="text-center" style="width: 6%;">Ej.</th>
                                    <th class="text-center" style="width: 8%;">Fecha</th>
                                    <th class="text-center" style="width: 10%;">Importe</th>
                                    <th class="text-center" style="width: 10%;">Total</th>
                                    <th class="text-center" style="width: 8%;">Envío</th>
                                    <th class="text-center" style="width: 8%;">Estado</th>
                                    <th class="text-center" style="width: 16%;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($budgetDocumentStats['list'] as $budget)
                                <tr>
                                    <td class="fw-bold">#{{ $budget->doccon }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="mdi mdi-account text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $budget->usuario->name ?? 'Sin usuario' }}</div>
                                                <small class="text-muted">{{ $budget->usuario->email ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-secondary">{{ $budget->docser }}</span></td>
                                    <td><span class="badge bg-info">{{ $budget->doceje }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($budget->docfec)->format('d/m/Y') }}</td>
                                    <td class="fw-medium">{{ number_format($budget->docimp, 2) }} €</td>
                                    <td class="fw-bold text-primary">{{ number_format($budget->docimptot, 2) }} €</td>
                                    <td>
                                        @if($budget->docenviado == 0)
                                        <span class="badge bg-warning">
                                            <i class="mdi mdi-clock me-1"></i>Pendiente
                                        </span>
                                        @else
                                        <span class="badge bg-success">
                                            <i class="mdi mdi-check me-1"></i>Enviado
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(empty($budget->docestado))
                                        <span class="badge bg-secondary">
                                            <i class="mdi mdi-help-circle me-1"></i>Pendiente
                                        </span>
                                        @elseif($budget->docestado == 'R')
                                        <span class="badge bg-danger">
                                            <i class="mdi mdi-close-circle me-1"></i>Rechazado
                                        </span>
                                        @elseif($budget->docestado == 'F')
                                        <span class="badge bg-success">
                                            <i class="mdi mdi-check-circle me-1"></i>Finalizado
                                        </span>
                                        @else
                                        <span class="badge bg-info">
                                            <i class="mdi mdi-information me-1"></i>{{ $budget->docestado }}
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button
                                                type="button"
                                                class="btn btn-outline-info btn-sm showBudget"
                                                data-href="/tools/ver/"
                                                data-file="{{$budget->ficheroIndividual->docfichero ?? ''}}"
                                                title="Ver Presupuesto">
                                                <i class="mdi mdi-eye"></i>
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-outline-secondary btn-sm downloadBudget"
                                                data-id="{{$budget->doccon}}"
                                                title="Descargar Presupuesto">
                                                <i class="mdi mdi-download"></i>
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-outline-primary btn-sm sendBudget"
                                                data-id="{{$budget->doccon}}"
                                                data-client-name="{{$budget->usuario->name ?? 'Sin usuario'}}"
                                                data-client-email="{{$budget->usuario->email ?? 'Sin email'}}"
                                                title="Enviar por Email">
                                                <i class="mdi mdi-email-send"></i>
                                            </button>

                                            @if(empty($budget->docestado) || $budget->docestado == 'R')
                                            @if(empty($budget->docestado))
                                            <!-- Mostrar ambos botones cuando docestado es null o vacío -->
                                            <button
                                                type="button"
                                                class="btn btn-outline-success btn-sm acceptBudget"
                                                data-id="{{$budget->doccon}}"
                                                data-client-name="{{$budget->usuario->name ?? 'Sin usuario'}}"
                                                title="Aceptar Documento">
                                                <i class="mdi mdi-check"></i>
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-outline-danger btn-sm rejectBudget"
                                                data-id="{{$budget->doccon}}"
                                                data-client-name="{{$budget->usuario->name ?? 'Sin usuario'}}"
                                                title="Rechazar Documento">
                                                <i class="mdi mdi-close"></i>
                                            </button>
                                            @elseif($budget->docestado == 'R')
                                            <!-- Mostrar solo aceptar cuando docestado es 'R' -->
                                            <button
                                                type="button"
                                                class="btn btn-outline-success btn-sm acceptBudget"
                                                data-id="{{$budget->doccon}}"
                                                data-client-name="{{$budget->usuario->name ?? 'Sin usuario'}}"
                                                title="Aceptar Documento">
                                                <i class="mdi mdi-check"></i>
                                            </button>
                                            @endif
                                            @endif
                                            <!-- Cuando docestado es 'F', no aparece ningún botón -->
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Facturas (Documentos) -->
        <div class="tab-pane fade" id="invoice-documents" role="tabpanel">
            <!-- Statistics Cards -->
            <div class="section-title">
                <i class="mdi mdi-chart-line text-success"></i>
                Estadísticas de Facturas (Documentos)
            </div>

            <div class="row g-3 mb-4">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                                    <i class="mdi mdi-receipt"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-success">{{ $invoiceDocumentStats['total'] }}</p>
                                    <p class="stats-label text-muted">Total</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-warning bg-opacity-10 text-warning me-3">
                                    <i class="mdi mdi-clock-outline"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-warning">{{ $invoiceDocumentStats['pendientes'] }}</p>
                                    <p class="stats-label text-muted">Pendientes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-info bg-opacity-10 text-info me-3">
                                    <i class="mdi mdi-send"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-info">{{ $invoiceDocumentStats['enviados'] }}</p>
                                    <p class="stats-label text-muted">Enviadas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                                    <i class="mdi mdi-check-circle"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-success">{{ $invoiceDocumentStats['pagados'] }}</p>
                                    <p class="stats-label text-muted">Pagadas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-secondary bg-opacity-10 text-secondary me-3">
                                    <i class="mdi mdi-progress-clock"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-secondary">{{ $invoiceDocumentStats['procesando'] }}</p>
                                    <p class="stats-label text-muted">Procesando</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card action-card shadow-sm">
                        <div class="card-body p-3 text-center">
                            <div class="mb-2">
                                <i class="mdi mdi-email-send fs-1"></i>
                            </div>
                            <button
                                id="send-invoices-button"
                                type="button"
                                class="btn btn-light btn-sm w-100">
                                Enviar Todas
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="mdi mdi-receipt me-2"></i>
                            Facturas
                        </h5>
                        <span class="badge bg-warning">{{ $invoiceDocumentStats['pendientes'] }} pendientes de envío por correo</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="invoice-documents-table" class="table table-hover dt-responsive nowrap" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="mdi mdi-pound me-1"></i>ID</th>
                                    <th><i class="mdi mdi-account me-1"></i>Cliente</th>
                                    <th><i class="mdi mdi-format-list-numbered me-1"></i>Serie</th>
                                    <th><i class="mdi mdi-calendar me-1"></i>Ejercicio</th>
                                    <th><i class="mdi mdi-calendar-today me-1"></i>Fecha</th>
                                    <th><i class="mdi mdi-currency-eur me-1"></i>Importe</th>
                                    <th><i class="mdi mdi-currency-eur me-1"></i>Total</th>
                                    <th><i class="mdi mdi-send me-1"></i>Estado Envío</th>
                                    <th><i class="mdi mdi-credit-card me-1"></i>Pago</th>
                                    <th><i class="mdi mdi-cog me-1"></i>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoiceDocumentStats['list'] as $invoice)
                                <tr>
                                    <td class="fw-bold">#{{ $invoice->doccon }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="mdi mdi-account text-success"></i>
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $invoice->usuario->name ?? 'Sin usuario' }}</div>
                                                <small class="text-muted">{{ $invoice->usuario->email ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-secondary">{{ $invoice->docser }}</span></td>
                                    <td><span class="badge bg-info">{{ $invoice->doceje }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->docfec)->format('d/m/Y') }}</td>
                                    <td class="fw-medium">{{ number_format($invoice->docimp, 2) }} €</td>
                                    <td class="fw-bold text-success">{{ number_format($invoice->docimptot, 2) }} €</td>
                                    <td>
                                        @if($invoice->docenviado == 0)
                                        <span class="badge bg-warning">
                                            <i class="mdi mdi-clock me-1"></i>Pendiente
                                        </span>
                                        @else
                                        <span class="badge bg-success">
                                            <i class="mdi mdi-check me-1"></i>Enviado
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($invoice->doccob == 1)
                                        <span class="badge bg-success">
                                            <i class="mdi mdi-check me-1"></i>Pagado
                                        </span>
                                        @elseif($invoice->doccob == 2)
                                        <span class="badge bg-info">
                                            <i class="mdi mdi-progress-clock me-1"></i>Procesando
                                        </span>
                                        @else
                                        <span class="badge bg-danger">
                                            <i class="mdi mdi-clock-alert me-1"></i>Pendiente
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button
                                                type="button"
                                                class="btn btn-outline-info btn-sm showInvoice"
                                                data-href="/tools/ver/"
                                                data-file="{{$invoice->ficheroIndividual->docfichero ?? ''}}"
                                                title="Ver Factura">
                                                <i class="mdi mdi-eye"></i>
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-outline-secondary btn-sm downloadInvoice"
                                                data-id="{{$invoice->doccon}}"
                                                title="Descargar Factura">
                                                <i class="mdi mdi-download"></i>
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-outline-success btn-sm sendInvoice"
                                                data-id="{{$invoice->doccon}}"
                                                data-client-name="{{$invoice->usuario->name ?? 'Sin usuario'}}"
                                                data-client-email="{{$invoice->usuario->email ?? 'Sin email'}}"
                                                title="Enviar por Email">
                                                <i class="mdi mdi-email-send"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Presupuestos (Pedidos) -->
        <div class="tab-pane fade" id="budget-orders" role="tabpanel">
            <!-- Statistics Cards -->
            <div class="section-title">
                <i class="mdi mdi-chart-donut text-info"></i>
                Estadísticas de Presupuestos (Pedidos)
            </div>

            <div class="row g-3 mb-4">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-info bg-opacity-10 text-info me-3">
                                    <i class="mdi mdi-cart-outline"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-info">{{ $budgetOrderStats['total'] }}</p>
                                    <p class="stats-label text-muted">Total</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-warning bg-opacity-10 text-warning me-3">
                                    <i class="mdi mdi-clock-outline"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-warning">{{ $budgetOrderStats['pendientes'] }}</p>
                                    <p class="stats-label text-muted">Pendientes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-info bg-opacity-10 text-info me-3">
                                    <i class="mdi mdi-check-circle-outline"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-info">{{ $budgetOrderStats['confirmados'] }}</p>
                                    <p class="stats-label text-muted">Confirmados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                                    <i class="mdi mdi-cart"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-primary">{{ $budgetOrderStats['realizados'] }}</p>
                                    <p class="stats-label text-muted">Realizados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-secondary bg-opacity-10 text-secondary me-3">
                                    <i class="mdi mdi-progress-clock"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-secondary">{{ $budgetOrderStats['procesando'] }}</p>
                                    <p class="stats-label text-muted">Procesando</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                                    <i class="mdi mdi-package-variant"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-success">{{ $budgetOrderStats['preparados'] }}</p>
                                    <p class="stats-label text-muted">Preparados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="mdi mdi-cart-outline me-2"></i>
                            Lista de Presupuestos (Pedidos)
                        </h5>
                        <span class="badge bg-info">{{ $budgetOrderStats['total'] }} total</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="budget-orders-table" class="table table-hover dt-responsive nowrap" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="mdi mdi-pound me-1"></i>ID</th>
                                    <th><i class="mdi mdi-account me-1"></i>Cliente</th>
                                    <th><i class="mdi mdi-calendar-today me-1"></i>Fecha</th>
                                    <th><i class="mdi mdi-currency-eur me-1"></i>Subtotal</th>
                                    <th><i class="mdi mdi-currency-eur me-1"></i>Total</th>
                                    <th><i class="mdi mdi-flag me-1"></i>Estado</th>
                                    <th><i class="mdi mdi-format-list-bulleted me-1"></i>Artículos</th>
                                    <th><i class="mdi mdi-cog me-1"></i>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DEBUG: Total registros: {{ $budgetOrderStats['list']->count() }} -->
                                @forelse ($budgetOrderStats['list'] as $budgetOrder)
                                <tr>
                                    <td class="fw-bold">#{{ $budgetOrder->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="mdi mdi-account text-info"></i>
                                            </div>
                                            <div>
                                                <div class="fw-medium">Cliente #{{ $budgetOrder->accclicod }}</div>
                                                <small class="text-muted">Centro: {{ $budgetOrder->acccencod }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($budgetOrder->fecha)->format('d/m/Y H:i') }}</td>
                                    <td class="fw-medium">{{ number_format($budgetOrder->subtotal, 2) }} €</td>
                                    <td class="fw-bold text-info">{{ number_format($budgetOrder->total, 2) }} €</td>
                                    <td>
                                        @if($budgetOrder->estado == 10)
                                        <span class="badge bg-warning">
                                            <i class="mdi mdi-clock me-1"></i>Pendiente
                                        </span>
                                        @elseif($budgetOrder->estado == 11)
                                        <span class="badge bg-info">
                                            <i class="mdi mdi-check me-1"></i>Confirmado
                                        </span>
                                        @elseif($budgetOrder->estado == 2)
                                        <span class="badge bg-primary">
                                            <i class="mdi mdi-cart me-1"></i>Pedido Realizado
                                        </span>
                                        @elseif($budgetOrder->estado == 3)
                                        <span class="badge bg-secondary">
                                            <i class="mdi mdi-progress-clock me-1"></i>Procesando
                                        </span>
                                        @elseif($budgetOrder->estado == 4)
                                        <span class="badge bg-warning text-dark">
                                            <i class="mdi mdi-package me-1"></i>Preparado
                                        </span>
                                        @elseif($budgetOrder->estado == 6)
                                        <span class="badge bg-success">
                                            <i class="mdi mdi-truck me-1"></i>Entregado
                                        </span>
                                        @else
                                        <span class="badge bg-secondary">Estado {{ $budgetOrder->estado }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $budgetOrder->pedidos_lineas->count() }} artículos
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('pedido.mostrarPedido', $budgetOrder->id) }}"
                                                class="btn btn-outline-info btn-sm"
                                                title="Ver Detalles">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            @if($budgetOrder->estado == 10)
                                            <button type="button"
                                                class="btn btn-outline-success btn-sm confirm-budget-order"
                                                data-id="{{ $budgetOrder->id }}"
                                                title="Confirmar Presupuesto">
                                                <i class="mdi mdi-check"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="mdi mdi-information-outline me-2"></i>
                                        No se encontraron presupuestos de pedidos. Debug: {{ $budgetOrderStats['list']->count() }} registros
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Pedidos -->
        <div class="tab-pane fade" id="orders" role="tabpanel">
            <!-- Statistics Cards -->
            <div class="section-title">
                <i class="mdi mdi-chart-pie text-success"></i>
                Estadísticas de Pedidos
            </div>

            <div class="row g-3 mb-4">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                                    <i class="mdi mdi-package-variant"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-success">{{ $orderStats['total'] }}</p>
                                    <p class="stats-label text-muted">Total</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary bg-opacity-10 text-primary me-3">
                                    <i class="mdi mdi-cart-plus"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-primary">{{ $orderStats['realizados'] }}</p>
                                    <p class="stats-label text-muted">Realizados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-info bg-opacity-10 text-info me-3">
                                    <i class="mdi mdi-progress-clock"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-info">{{ $orderStats['procesando'] }}</p>
                                    <p class="stats-label text-muted">Procesando</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-warning bg-opacity-10 text-warning me-3">
                                    <i class="mdi mdi-package-variant-closed"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-warning">{{ $orderStats['preparados'] }}</p>
                                    <p class="stats-label text-muted">Preparados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="card stats-card shadow-sm">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-success bg-opacity-10 text-success me-3">
                                    <i class="mdi mdi-truck-delivery"></i>
                                </div>
                                <div>
                                    <p class="stats-number text-success">{{ $orderStats['entregados'] }}</p>
                                    <p class="stats-label text-muted">Entregados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="mdi mdi-package-variant me-2"></i>
                            Lista de Pedidos
                        </h5>
                        <span class="badge bg-success">{{ $orderStats['total'] }} total</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="orders-table" class="table table-hover dt-responsive nowrap" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="mdi mdi-pound me-1"></i>ID</th>
                                    <th><i class="mdi mdi-account me-1"></i>Cliente</th>
                                    <th><i class="mdi mdi-calendar-today me-1"></i>Fecha</th>
                                    <th><i class="mdi mdi-currency-eur me-1"></i>Subtotal</th>
                                    <th><i class="mdi mdi-currency-eur me-1"></i>Total</th>
                                    <th><i class="mdi mdi-flag me-1"></i>Estado</th>
                                    <th><i class="mdi mdi-format-list-bulleted me-1"></i>Artículos</th>
                                    <th><i class="mdi mdi-cog me-1"></i>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DEBUG: Total pedidos: {{ $orderStats['list']->count() }} -->
                                @forelse ($orderStats['list'] as $order)
                                <tr>
                                    <td class="fw-bold">#{{ $order->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="mdi mdi-account text-success"></i>
                                            </div>
                                            <div>
                                                <div class="fw-medium">Cliente #{{ $order->accclicod }}</div>
                                                <small class="text-muted">Centro: {{ $order->acccencod }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($order->fecha)->format('d/m/Y H:i') }}</td>
                                    <td class="fw-medium">{{ number_format($order->subtotal, 2) }} €</td>
                                    <td class="fw-bold text-success">{{ number_format($order->total, 2) }} €</td>
                                    <td>
                                        @if($order->estado == 2)
                                        <span class="badge bg-primary">
                                            <i class="mdi mdi-cart me-1"></i>Realizado
                                        </span>
                                        @elseif($order->estado == 3)
                                        <span class="badge bg-info">
                                            <i class="mdi mdi-progress-clock me-1"></i>Procesando
                                        </span>
                                        @elseif($order->estado == 4)
                                        <span class="badge bg-warning">
                                            <i class="mdi mdi-package me-1"></i>Preparado
                                        </span>
                                        @elseif($order->estado == 6)
                                        <span class="badge bg-success">
                                            <i class="mdi mdi-truck me-1"></i>Entregado
                                        </span>
                                        @else
                                        <span class="badge bg-secondary">Estado {{ $order->estado }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $order->pedidos_lineas->count() }} artículos
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('pedido.mostrarPedido', $order->id) }}"
                                                class="btn btn-outline-info btn-sm"
                                                title="Ver Detalles">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            @if($order->estado < 6)
                                                <button type="button"
                                                class="btn btn-outline-primary btn-sm update-order-status"
                                                data-id="{{ $order->id }}"
                                                data-current-status="{{ $order->estado }}"
                                                title="Actualizar Estado">
                                                <i class="mdi mdi-arrow-up-circle"></i>
                                                </button>
                                                @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="mdi mdi-information-outline me-2"></i>
                                        No se encontraron pedidos. Debug: {{ $orderStats['list']->count() }} registros
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#budget-documents-table').DataTable({
            responsive: true,
            order: [
                [4, 'desc']
            ], // Ordenar por fecha
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            }
        });

        $('#invoice-documents-table').DataTable({
            responsive: true,
            order: [
                [4, 'desc']
            ], // Ordenar por fecha
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            }
        });

        $('#budget-orders-table').DataTable({
            responsive: true,
            order: [
                [2, 'desc']
            ], // Ordenar por fecha
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            }
        });

        $('#orders-table').DataTable({
            responsive: true,
            order: [
                [2, 'desc']
            ], // Ordenar por fecha
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            }
        });
    });

    // === BULK ACTIONS ===
    $('#send-budgets-button').on('click', function() {
        const $btn = $(this);
        $btn.prop('disabled', true);
        const originalText = $btn.html();
        $btn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Enviando...');

        $.ajax({
            url: "{{ route('tools.sendBudgetForEmail') }}",
            type: "POST",
            data: {
                sendEmail: true
            },
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.message,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr, status, error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al enviar los presupuestos.',
                    confirmButtonText: 'Aceptar'
                });
            },
            complete: function() {
                $btn.prop('disabled', false);
                $btn.html(originalText);
            }
        });
    });

    $('#send-invoices-button').on('click', function() {
        const $btn = $(this);
        $btn.prop('disabled', true);
        const originalText = $btn.html();
        $btn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Enviando...');

        $.ajax({
            url: "{{ route('tools.sendInvoiceForEmail') }}",
            type: "POST",
            data: {
                sendEmail: true
            },
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.message,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr, status, error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al enviar las facturas.',
                    confirmButtonText: 'Aceptar'
                });
            },
            complete: function() {
                $btn.prop('disabled', false);
                $btn.html(originalText);
            }
        });
    });

    // === DOCUMENT ACTIONS ===
    // Ver documentos (Presupuestos y Facturas)
    $(document).on("click", ".showBudget", function(e) {
        e.preventDefault();

        let urlDoc = window.location.origin;
        const url = urlDoc + e.currentTarget.dataset.href + e.currentTarget.dataset.file;
        console.log("URL del documento:", url);

        fetch(url)
            .then(async (response) => {
                console.log("Response:", response);
                if (!response.ok) {
                    let errorMsg = 'Error desconocido al obtener el documento.';
                    try {
                        const err = await response.json();
                        if (err && err.error) {
                            errorMsg = err.error;
                        }
                    } catch (e) {
                        // No JSON, keep default errorMsg
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg,
                        confirmButtonText: 'Aceptar'
                    });
                } else {
                    const blob = await response.blob();
                    const fileUrl = window.URL.createObjectURL(blob);
                    window.open(fileUrl, "_blank");
                }
            })
            .catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al realizar la petición: ' + error,
                    confirmButtonText: 'Aceptar'
                });
                console.error("Error al realizar la petición:", error);
            });
    });

    $(document).on("click", ".sendBudget", function(e) {
        e.preventDefault();

        const budgetID = e.currentTarget.dataset.id;
        const clientName = e.currentTarget.dataset.clientName;
        const clientEmail = e.currentTarget.dataset.clientEmail;

        // Mostrar modal de confirmación
        Swal.fire({
            title: 'Enviar Presupuesto',
            html: `¿Desea enviar el presupuesto <strong>#${budgetID}</strong> al cliente <strong>${clientName}</strong> a la dirección <strong>${clientEmail}</strong>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, enviar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar indicador de carga
                Swal.fire({
                    title: 'Enviando...',
                    text: 'Por favor espere mientras se envía el presupuesto.',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Realizar el envío
                $.ajax({
                    url: "{{ route('tools.sendSingleBudgetForEmail') }}",
                    type: "POST",
                    data: {
                        budgetID: budgetID
                    },
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.message) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Enviado!',
                                text: response.message,
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Atención',
                                text: 'Respuesta desconocida del servidor.',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMsg = 'Ocurrió un error al enviar el presupuesto.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMsg,
                            confirmButtonText: 'Aceptar'
                        });
                        console.error("Error al realizar la petición:", error);
                    }
                });
            }
        });
    });

    // Aceptar documento
    $(document).on('click', '.acceptBudget', function(e) {
        e.preventDefault();

        const budgetID = $(this).data('id');
        const clientName = $(this).data('client-name');

        Swal.fire({
            title: 'Aceptar Documento',
            html: `¿Está seguro de que desea aceptar el documento <strong>#${budgetID}</strong> del cliente <strong>${clientName}</strong>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar indicador de carga
                Swal.fire({
                    title: 'Procesando...',
                    text: 'Por favor espere mientras se procesa la aceptación.',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('tools.updateBudget') }}",
                    method: 'POST',
                    data: {
                        id: budgetID,
                        observation: 'Documento aceptado',
                        estado: 'F',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('¡Aceptado!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message || 'No se pudo aceptar el documento.', 'error');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'No se pudo aceptar el documento.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.fire('Error', errorMsg, 'error');
                    }
                });
            }
        });
    });

    // Rechazar documento
    $(document).on('click', '.rejectBudget', function(e) {
        e.preventDefault();

        const budgetID = $(this).data('id');
        const clientName = $(this).data('client-name');

        Swal.fire({
            title: 'Rechazar Documento',
            html: `Va a rechazar el documento <strong>#${budgetID}</strong> del cliente <strong>${clientName}</strong>.<br><br>Por favor, escriba la razón del rechazo:`,
            input: 'textarea',
            inputPlaceholder: 'Escriba la observación del rechazo...',
            inputAttributes: {
                'aria-label': 'Observación del rechazo'
            },
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Rechazar',
            cancelButtonText: 'Cancelar',
            inputValidator: (value) => {
                if (!value || value.trim().length === 0) {
                    return 'La observación del rechazo es obligatoria';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar indicador de carga
                Swal.fire({
                    title: 'Procesando...',
                    text: 'Por favor espere mientras se procesa el rechazo.',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('tools.updateBudget') }}",
                    method: 'POST',
                    data: {
                        id: budgetID,
                        observation: result.value,
                        estado: 'R',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Rechazado', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message || 'No se pudo rechazar el documento.', 'error');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'No se pudo rechazar el documento.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.fire('Error', errorMsg, 'error');
                    }
                });
            }
        });
    });

    $(document).on('click', '[id="declineBudget"]', function(e) {
        e.preventDefault();

        let docId = $(e.currentTarget).data('id');

        Swal.fire({
            title: 'Rechazar presupuesto',
            input: 'textarea',
            inputLabel: 'Nos podrías escribir la razón del rechazo.',
            inputPlaceholder: 'Escribe una observación...',
            showCancelButton: true,
            confirmButtonText: 'Continuar',
            cancelButtonText: 'Cancelar',
            inputValidator: (value) => {
                if (!value) {
                    return 'Debes escribir una observación';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('tools.updateBudget') }}",
                    method: 'POST',
                    data: {
                        id: docId,
                        observation: result.value,
                        estado: "R",
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Rechazado', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message || 'No se pudo rechazar el presupuesto.', 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'No se pudo rechazar el presupuesto.', 'error');
                    }
                });
            }
        });
    });

    // Facturas
    $(document).on("click", ".showInvoice", function(e) {
        e.preventDefault();

        let urlDoc = window.location.origin;
        const url = urlDoc + e.currentTarget.dataset.href + e.currentTarget.dataset.file;
        console.log("URL del documento:", url);

        fetch(url)
            .then(async (response) => {
                console.log("Response:", response);
                if (!response.ok) {
                    let errorMsg = 'Error desconocido al obtener el documento.';
                    try {
                        const err = await response.json();
                        if (err && err.error) {
                            errorMsg = err.error;
                        }
                    } catch (e) {
                        // No JSON, keep default errorMsg
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg,
                        confirmButtonText: 'Aceptar'
                    });
                } else {
                    const blob = await response.blob();
                    const fileUrl = window.URL.createObjectURL(blob);
                    window.open(fileUrl, "_blank");
                }
            })
            .catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al realizar la petición: ' + error,
                    confirmButtonText: 'Aceptar'
                });
                console.error("Error al realizar la petición:", error);
            });
    });

    // Descargar facturas
    $(document).on("click", ".downloadInvoice", function(e) {
        e.preventDefault();

        const invoiceID = $(this).data('id');

        // Mostrar indicador de descarga
        Swal.fire({
            title: 'Descargando...',
            text: 'Por favor espere mientras se prepara la descarga.',
            icon: 'info',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Realizar la descarga usando la nueva ruta de tools
        window.location.href = `/tools/download/${invoiceID}`;

        // Cerrar el modal de carga después de un breve delay
        setTimeout(() => {
            Swal.close();
        }, 1500);
    });

    // Descargar presupuestos
    $(document).on("click", ".downloadBudget", function(e) {
        e.preventDefault();

        const budgetID = $(this).data('id');

        // Mostrar indicador de descarga
        Swal.fire({
            title: 'Descargando...',
            text: 'Por favor espere mientras se prepara la descarga.',
            icon: 'info',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Realizar la descarga usando la nueva ruta de tools
        window.location.href = `/tools/download/${budgetID}`;

        // Cerrar el modal de carga después de un breve delay
        setTimeout(() => {
            Swal.close();
        }, 1500);
    });

    $(document).on("click", ".sendInvoice", function(e) {
        e.preventDefault();

        const invoiceID = e.currentTarget.dataset.id;
        const clientName = e.currentTarget.dataset.clientName;
        const clientEmail = e.currentTarget.dataset.clientEmail;

        // Mostrar modal de confirmación
        Swal.fire({
            title: 'Enviar Factura',
            html: `¿Desea enviar la factura <strong>#${invoiceID}</strong> al cliente <strong>${clientName}</strong> a la dirección <strong>${clientEmail}</strong>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, enviar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar indicador de carga
                Swal.fire({
                    title: 'Enviando...',
                    text: 'Por favor espere mientras se envía la factura.',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Realizar el envío
                $.ajax({
                    url: "{{ route('tools.sendSingleInvoiceForEmail') }}",
                    type: "POST",
                    data: {
                        invoiceID: invoiceID
                    },
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.message) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Enviado!',
                                text: response.message,
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Atención',
                                text: 'Respuesta desconocida del servidor.',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMsg = 'Ocurrió un error al enviar la factura.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMsg,
                            confirmButtonText: 'Aceptar'
                        });
                        console.error("Error al realizar la petición:", error);
                    }
                });
            }
        });
    });

    // Rechazar presupuesto
    $(document).on('click', '.declineBudget', function(e) {
        e.preventDefault();

        let docId = $(this).data('id');

        Swal.fire({
            title: 'Rechazar presupuesto',
            input: 'textarea',
            inputLabel: 'Razón del rechazo',
            inputPlaceholder: 'Escribe una observación...',
            showCancelButton: true,
            confirmButtonText: 'Rechazar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc3545',
            inputValidator: (value) => {
                if (!value) {
                    return 'Debes escribir una observación';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('tools.updateBudget') }}",
                    method: 'POST',
                    data: {
                        id: docId,
                        observation: result.value,
                        estado: "R",
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Rechazado', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message || 'No se pudo rechazar el presupuesto.', 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'No se pudo rechazar el presupuesto.', 'error');
                    }
                });
            }
        });
    });

    // Confirmar presupuesto de pedido
    $(document).on('click', '.confirm-budget-order', function(e) {
        e.preventDefault();

        const budgetId = $(this).data('id');
        const $btn = $(this);

        Swal.fire({
            title: '¿Confirmar presupuesto?',
            text: 'Esta acción confirmará el presupuesto y cambiará su estado.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#28a745'
        }).then((result) => {
            if (result.isConfirmed) {
                $btn.html('<span class="spinner-border spinner-border-sm"></span>');
                $btn.prop('disabled', true);

                $.ajax({
                    url: `/pedidos/update-presupuesto/${budgetId}`,
                    method: 'PUT',
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Confirmado', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', 'No se pudo confirmar el presupuesto.', 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Ocurrió un error al confirmar el presupuesto.', 'error');
                    },
                    complete: function() {
                        $btn.html('<i class="mdi mdi-check"></i>');
                        $btn.prop('disabled', false);
                    }
                });
            }
        });
    });

    // Actualizar estado de pedido
    $(document).on('click', '.update-order-status', function(e) {
        e.preventDefault();

        const orderId = $(this).data('id');
        const currentStatus = $(this).data('current-status');

        let nextStatus, statusText;

        switch (parseInt(currentStatus)) {
            case 2: // Realizado -> Procesando
                nextStatus = 3;
                statusText = 'Procesando';
                break;
            case 3: // Procesando -> Preparado
                nextStatus = 4;
                statusText = 'Preparado';
                break;
            case 4: // Preparado -> Entregado
                nextStatus = 6;
                statusText = 'Entregado';
                break;
            default:
                Swal.fire('Info', 'Este pedido ya está en su estado final.', 'info');
                return;
        }

        Swal.fire({
            title: `¿Cambiar estado a "${statusText}"?`,
            text: `El pedido #${orderId} cambiará su estado.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#007bff'
        }).then((result) => {
            if (result.isConfirmed) {
                const $btn = $(this);
                $btn.html('<span class="spinner-border spinner-border-sm"></span>');
                $btn.prop('disabled', true);

                // Note: This would require a new route and method in the controller
                $.ajax({
                    url: `/pedidos/update-status/${orderId}`,
                    method: 'PUT',
                    data: {
                        status: nextStatus
                    },
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire('Actualizado', `Estado cambiado a "${statusText}"`, 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'No se pudo actualizar el estado del pedido.', 'error');
                    },
                    complete: function() {
                        $btn.html('<i class="mdi mdi-arrow-up-circle"></i>');
                        $btn.prop('disabled', false);
                    }
                });
            }
        });
    });
</script>
@endpush