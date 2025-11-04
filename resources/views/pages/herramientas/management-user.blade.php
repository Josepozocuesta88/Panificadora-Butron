@extends('layouts.app')
@section('content')
<!-- Estilos personalizados -->
<style>
    .avatar-sm {
        width: 40px;
        height: 40px;
    }

    .bg-soft {
        background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.05) !important;
    }

    .btn-group .btn {
        border-radius: 0.375rem !important;
        margin: 0 2px;
    }

    .modal-content {
        border-radius: 12px;
    }

    .table th {
        font-weight: 600;
        border-bottom: 2px solid #e3ebf0;
    }

    /* Mejoras responsive */
    @media (max-width: 575.98px) {
        .container-fluid {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .card {
            margin: 0 0.25rem;
        }

        .page-title-box {
            padding: 0.5rem 0;
        }

        .page-title {
            font-size: 1.25rem;
        }

        .breadcrumb {
            font-size: 0.8rem;
        }

        .modal-dialog {
            margin: 0.25rem !important;
            max-width: calc(100% - 0.5rem) !important;
        }

        .modal-body {
            padding: 1rem !important;
        }

        .modal-header {
            padding: 0.75rem 1rem !important;
        }

        .modal-footer {
            padding: 0.75rem 1rem !important;
        }

        .btn-group .btn {
            margin: 0 1px;
            font-size: 0.8rem;
            padding: 0.25rem 0.4rem;
        }

        .badge {
            font-size: 0.75rem !important;
        }

        /* Evitar desbordamiento horizontal */
        body {
            overflow-x: hidden;
        }

        .container-fluid {
            overflow-x: hidden;
        }
    }

    /* Ajustes para tablets */
    @media (min-width: 576px) and (max-width: 991.98px) {
        .btn-group .btn {
            font-size: 0.85rem;
            padding: 0.3rem 0.5rem;
        }
    }

    /* Responsive específico para DataTables */
    @media (max-width: 767.98px) {

        /* Ocultar columnas menos importantes en móvil */
        .table th:nth-child(4),
        .table td:nth-child(4) {
            display: none;
        }

        /* Ajustar tamaños de texto */
        .table {
            font-size: 0.85rem;
        }

        .table th {
            font-size: 0.8rem;
        }

        .table td h6 {
            font-size: 0.9rem;
        }

        .table td small {
            font-size: 0.75rem;
        }

        /* Mejorar espaciado */
        .card-body {
            padding: 1rem;
        }

        /* Ajustar controles de DataTables */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 0.5rem;
        }

        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            font-size: 0.85rem;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            font-size: 0.85rem;
        }

        /* Ajustar paginación */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }

        /* Información de registros más compacta */
        .dataTables_wrapper .dataTables_info {
            font-size: 0.8rem;
        }
    }

    /* Para pantallas muy pequeñas */
    @media (max-width: 480px) {

        .table th:nth-child(3),
        .table td:nth-child(3) {
            display: none;
        }

        .btn-group {
            flex-direction: column;
            gap: 0.25rem;
        }

        .btn-group .btn {
            border-radius: 0.375rem !important;
            margin: 0;
        }

        .card-header h5 {
            font-size: 1rem;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            text-align: center;
        }

        .dataTables_wrapper .dataTables_paginate {
            text-align: center;
            margin-top: 1rem;
        }
    }

    /* Estilos para el dropdown de acciones en móvil */
    .action-dropdown .dropdown-menu {
        min-width: 200px;
        font-size: 0.9rem;
    }

    .action-dropdown .dropdown-item {
        padding: 0.5rem 1rem;
        transition: all 0.2s ease;
    }

    .action-dropdown .dropdown-item:hover {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
    }

    .action-dropdown .dropdown-item i {
        width: 1.2rem;
    }

    /* Estilos para el modal de WhatsApp */
    .contact-item {
        transition: all 0.2s ease;
        border: 1px solid transparent;
        border-radius: 8px;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        cursor: pointer;
    }

    .contact-item:hover {
        background-color: rgba(40, 167, 69, 0.1);
        border-color: rgba(40, 167, 69, 0.3);
    }

    .contact-item.selected {
        background-color: rgba(40, 167, 69, 0.15);
        border-color: #28a745;
    }

    .contact-checkbox {
        transform: scale(1.2);
    }

    .contact-info h6 {
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
    }

    .contact-info small {
        font-size: 0.85rem;
    }

    .whatsapp-link:hover {
        transform: scale(1.05);
        transition: transform 0.2s ease;
    }

    /* Responsive para el modal de WhatsApp */
    @media (max-width: 575.98px) {
        .contact-item {
            padding: 0.5rem;
            margin-bottom: 0.25rem;
        }

        .contact-info h6 {
            font-size: 0.9rem;
        }

        .contact-info small {
            font-size: 0.8rem;
        }

        .contact-checkbox {
            transform: scale(1.1);
        }

        #whatsappModal .modal-body {
            padding: 1rem !important;
        }

        #whatsappModal .btn-group {
            flex-direction: column;
            gap: 0.25rem;
        }

        #whatsappModal .btn-group .btn {
            border-radius: 0.375rem !important;
            margin: 0;
        }
    }

    /* Mejorar espaciado de la tabla en móvil */
    @media (max-width: 767.98px) {
        .table td {
            padding: 0.75rem 0.5rem;
            vertical-align: middle;
        }

        .table th {
            padding: 0.75rem 0.5rem;
        }

        /* Mejorar legibilidad del email */
        .table td a {
            word-break: break-all;
            font-size: 0.85rem;
        }
    }
</style>

<!-- Start Content-->
<div class="container-fluid">

    <!-- Page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tools.index') }}">Herramientas</a></li>
                        <li class="breadcrumb-item active">Gestión de Usuarios</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    <i class="mdi mdi-account-multiple me-2 text-primary"></i>
                    Gestión de Usuarios
                </h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="mdi mdi-account-group me-2 fs-5"></i>
                        <h5 class="mb-0 fw-semibold">Lista de Usuarios del Sistema</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="users-table" class="table table-hover table-centered table-nowrap table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        <i class="mdi mdi-account me-1"></i>Nombre
                                    </th>
                                    <th>
                                        <i class="mdi mdi-email me-1"></i>Correo Electrónico
                                    </th>
                                    <th class="text-center" style="width: 120px;">
                                        <i class="mdi mdi-shield-account me-1"></i>Rol
                                    </th>
                                    <th class="text-center" style="width: 120px;">
                                        <i class="mdi mdi-shield-account me-1"></i>Cod. Invitación
                                    </th>
                                    <th class="text-center" style="width: 200px;">
                                        <i class="mdi mdi-cog me-1"></i>Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                                            <small class="text-muted">Usuario del sistema</small>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                            {{ $user->email }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @php
                                        $roleClass = match($user->usugrucod) {
                                        'Admin' => 'bg-danger',
                                        'SA' => 'bg-warning text-dark',
                                        'Cliente' => 'bg-success',
                                        default => 'bg-secondary'
                                        };
                                        @endphp
                                        <span class="badge {{ $roleClass }} px-2 py-1">
                                            <i class="mdi mdi-shield-account me-1"></i>
                                            {{ $user->usugrucod }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(!empty($user->accesorapido))
                                        <a href="#" class="text-decoration-none"
                                            onclick="openWhatsAppModal({{ $user->id }}, '{{ addslashes($user->accesorapido) }}', '{{ addslashes($user->name) }}')"
                                            data-bs-toggle="tooltip"
                                            title="Compartir código de invitación">
                                            <i class="mdi mdi-whatsapp me-1" style="color:#25D366"></i>
                                            {{$user->accesorapido}}
                                        </a>
                                        @else
                                        <span class="text-muted"> - </span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <!-- Botones para pantallas >= sm -->
                                        <div class="btn-group d-none d-sm-inline-flex" role="group" aria-label="Acciones de usuario">
                                            <button class="btn btn-sm btn-outline-warning"
                                                onclick="openPasswordModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                                data-bs-toggle="tooltip"
                                                title="Actualizar contraseña">
                                                <i class="mdi mdi-key-variant"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-info"
                                                onclick="openRoleModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->usugrucod }}')"
                                                data-bs-toggle="tooltip"
                                                title="Cambiar rol">
                                                <i class="mdi mdi-shield-edit"></i>
                                            </button>
                                        </div>

                                        <!-- Dropdown para pantallas < sm -->
                                        <div class="dropdown d-inline-block d-sm-none action-dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="actionsDropdown{{ $user->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown{{ $user->id }}">
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="openPasswordModal({{ $user->id }}, '{{ addslashes($user->name) }}'); return false;">
                                                        <i class="mdi mdi-key-variant me-2"></i>Actualizar contraseña
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="openRoleModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->usugrucod }}'); return false;">
                                                        <i class="mdi mdi-shield-edit me-2"></i>Cambiar rol
                                                    </a>
                                                </li>
                                            </ul>
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
    </div>
</div>
<!-- container -->

<!-- Modal Actualizar Contraseña -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" role="dialog" aria-labelledby="updatePasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="update-password-form" id="updatePasswordForm">
            @csrf
            <input type="hidden" name="user_id" id="passwordUserId">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-warning text-dark border-0">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="mdi mdi-key-variant fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0 fw-semibold" id="updatePasswordLabel">Actualizar Contraseña</h5>
                            <small class="opacity-75">Modificar credenciales de acceso</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="passwordUserName" class="mb-3 p-3 bg-light rounded-3">
                        <i class="mdi mdi-account-circle me-2 text-muted"></i>
                        <span class="fw-semibold text-dark"></span>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">
                            <i class="mdi mdi-lock me-1 text-muted"></i>Nueva Contraseña
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-key"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Mínimo 8 caracteres">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-semibold">
                            <i class="mdi mdi-lock-check me-1 text-muted"></i>Confirmar Contraseña
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-key-check"></i></span>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Repetir contraseña">
                        </div>
                    </div>

                    <div class="alert alert-success d-none" id="successPasswordMsg">
                        <i class="mdi mdi-check-circle me-2"></i>Contraseña actualizada correctamente.
                    </div>
                    <div class="alert alert-danger d-none" id="errorPasswordMsg">
                        <i class="mdi mdi-alert-circle me-2"></i>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="mdi mdi-close me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="mdi mdi-content-save me-1"></i>Actualizar Contraseña
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Cambiar Rol -->
<div class="modal fade" id="changeRoleModal" tabindex="-1" role="dialog" aria-labelledby="changeRoleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="change-role-form" id="changeRoleForm">
            @csrf
            <input type="hidden" name="user_id" id="roleUserId">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-info text-white border-0">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-white bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3">
                            <i class="mdi mdi-shield-edit fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0 fw-semibold" id="changeRoleLabel">Cambiar Rol de Usuario</h5>
                            <small class="opacity-75">Modificar permisos y accesos</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="roleUserName" class="mb-3 p-3 bg-light rounded-3">
                        <i class="mdi mdi-account-circle me-2 text-muted"></i>
                        <span class="fw-semibold text-dark"></span>
                    </div>

                    <div class="mb-3">
                        <label for="usugrucod" class="form-label fw-semibold">
                            <i class="mdi mdi-shield-account me-1 text-muted"></i>Seleccionar Nuevo Rol
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-shield"></i></span>
                            <select class="form-select" id="usugrucod" name="usugrucod" required>
                                @foreach($roles as $rol)
                                <option value="{{ $rol }}">
                                    @switch($rol)
                                    @case('Admin')
                                    🔴 {{ $rol }} - Administrador del Sistema
                                    @break
                                    @case('SA')
                                    🟡 {{ $rol }} - Super Administrador
                                    @break
                                    @case('Cliente')
                                    🟢 {{ $rol }} - Usuario Cliente
                                    @break
                                    @default
                                    ⚪ {{ $rol }}
                                    @endswitch
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-muted mt-1">
                            <i class="mdi mdi-information-outline me-1"></i>
                            Selecciona cuidadosamente el rol apropiado para este usuario
                        </small>
                    </div>

                    <div class="alert alert-success d-none" id="successMsg">
                        <i class="mdi mdi-check-circle me-2"></i>Rol actualizado correctamente.
                    </div>
                    <div class="alert alert-danger d-none" id="errorMsg">
                        <i class="mdi mdi-alert-circle me-2"></i>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="mdi mdi-close me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="mdi mdi-content-save me-1"></i>Cambiar Rol
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Compartir por WhatsApp -->
<div class="modal fade" id="whatsappModal" tabindex="-1" role="dialog" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white border-0">
                <div class="d-flex align-items-center">
                    <div class="avatar-sm border border-white border-3 bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center me-3">
                        <i class="mdi mdi-whatsapp fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0 fw-semibold" id="whatsappModalLabel">Compartir Código de Invitación</h5>
                        <small class="opacity-75">Selecciona los contactos de tu agenda</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Información del código -->
                <div id="invitationInfo" class="mb-3 p-3 bg-light rounded-3">
                    <div class="d-flex align-items-center">
                        <i class="mdi mdi-account-circle me-2 text-muted fs-4"></i>
                        <div>
                            <h6 class="mb-0 fw-semibold" id="userNameInfo"></h6>
                            <small class="text-muted">Código: <span class="fw-bold text-success" id="invitationCode"></span></small>
                        </div>
                    </div>
                </div>

                <!-- Búsqueda -->
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                        <input type="text" class="form-control" id="searchContacts" placeholder="Buscar por nombre o teléfono...">
                    </div>
                </div>

                <!-- Lista de contactos -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label fw-semibold mb-0">
                            <i class="mdi mdi-contacts me-1"></i>Contactos de la Agenda
                        </label>
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="selectAllContacts">
                                <i class="mdi mdi-checkbox-multiple-marked-outline me-1"></i>Seleccionar todos
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary d-none" id="deselectAllContacts">
                                <i class="mdi mdi-checkbox-multiple-blank-outline me-1"></i>Deseleccionar todos
                            </button>
                        </div>
                    </div>

                    <!-- Loading spinner -->
                    <div class="text-center py-4" id="contactsLoading">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Cargando contactos...</span>
                        </div>
                        <p class="mt-2 text-muted">Cargando contactos...</p>
                    </div>

                    <!-- Contenedor de contactos -->
                    <div class="border rounded-3 p-3" id="contactsList" style="max-height: 300px; overflow-y: auto; display: none;">
                        <!-- Los contactos se cargarán aquí dinámicamente -->
                    </div>

                    <!-- Mensaje cuando no hay contactos -->
                    <div class="text-center py-4 d-none" id="noContactsMessage">
                        <i class="mdi mdi-contacts-outline fs-1 text-muted"></i>
                        <p class="mt-2 text-muted">No se encontraron contactos en la agenda</p>
                    </div>
                </div>

                <!-- Contador de seleccionados -->
                <div class="alert alert-info d-none" id="selectedCounter">
                    <i class="mdi mdi-information-outline me-2"></i>
                    <span id="selectedCount">0</span> contacto(s) seleccionado(s)
                </div>

                <!-- Mensajes de estado -->
                <div class="alert alert-success d-none" id="whatsappSuccessMsg">
                    <i class="mdi mdi-check-circle me-2"></i>
                </div>
                <div class="alert alert-danger d-none" id="whatsappErrorMsg">
                    <i class="mdi mdi-alert-circle me-2"></i>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="mdi mdi-close me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="sendWhatsAppBtn" disabled>
                    <i class="mdi mdi-whatsapp me-1"></i>Enviar por WhatsApp
                </button>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#users-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            },
            responsive: true,
            pageLength: 10,
            order: [
                [0, 'asc']
            ],
            scrollX: false,
            autoWidth: false,
            drawCallback: function() {
                // Reinicializar tooltips después de cada redraw
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    $(document).on('submit', '.update-password-form', function(e) {
        e.preventDefault();
        var form = $(this);
        var userId = form.data('user-id');
        var url = "{{ url('users/update-password') }}/" + userId;
        var token = form.find('input[name="_token"]').val();
        var password = form.find('input[name="password"]').val();
        var password_confirmation = form.find('input[name="password_confirmation"]').val();

        $.ajax({
            url: url,
            type: 'PUT',
            data: {
                _token: token,
                password: password,
                password_confirmation: password_confirmation
            },
            success: function(response) {
                $('#successPasswordMsg').removeClass('d-none');
                $('#errorPasswordMsg').addClass('d-none');
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.message || 'Contraseña actualizada correctamente.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(function() {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('updatePasswordModal'));
                    if (modal) {
                        modal.hide();
                    } else {
                        $('#updatePasswordModal').modal('hide');
                    }
                    form[0].reset();
                });
            },
            error: function(xhr) {
                var errorMsg = 'Ocurrió un error.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    errorMsg = Object.values(errors).join(' ');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                $('#errorPasswordMsg').removeClass('d-none').text(errorMsg);
                $('#successPasswordMsg').addClass('d-none');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMsg,
                    confirmButtonText: 'Cerrar'
                });
            }
        });
    });

    $(document).on('submit', '.change-role-form', function(e) {
        e.preventDefault();
        var form = $(this);
        var userId = form.data('user-id');
        var url = "{{ url('users/change-role') }}/" + userId;
        var token = form.find('input[name="_token"]').val();
        var usugrucod = form.find('select[name="usugrucod"]').val();

        $.ajax({
            url: url,
            type: 'PUT',
            data: {
                _token: token,
                usugrucod: usugrucod
            },
            success: function(response) {
                $('#successMsg').removeClass('d-none');
                $('#errorMsg').addClass('d-none');
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.message || 'Rol de usuario actualizado correctamente.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(function() {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('changeRoleModal'));
                    if (modal) {
                        modal.hide();
                    } else {
                        $('#changeRoleModal').modal('hide');
                    }
                    location.reload();
                });
            },
            error: function(xhr) {
                var errorMsg = 'Ocurrió un error.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                $('#errorMsg').removeClass('d-none').text(errorMsg);
                $('#successMsg').addClass('d-none');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMsg,
                    confirmButtonText: 'Cerrar'
                });
            }
        });
    });

    function openPasswordModal(userId, userName) {
        $('#passwordUserId').val(userId);
        $('#passwordUserName span').text(userName);
        $('#successPasswordMsg').addClass('d-none');
        $('#errorPasswordMsg').addClass('d-none').text('');
        $('#updatePasswordForm')[0].reset();
        $('#updatePasswordForm').data('user-id', userId);

        var modal = new bootstrap.Modal(document.getElementById('updatePasswordModal'));
        modal.show();
    }

    function openRoleModal(userId, userName, currentRole) {
        $('#roleUserId').val(userId);
        $('#roleUserName span').text(userName);
        $('#successMsg').addClass('d-none');
        $('#errorMsg').addClass('d-none').text('');
        $('#changeRoleForm')[0].reset();
        $('#changeRoleForm').data('user-id', userId);

        // Establecer el rol actual después de resetear el formulario
        $('#usugrucod').val(currentRole);

        var modal = new bootstrap.Modal(document.getElementById('changeRoleModal'));
        modal.show();
    }

    // Limpiar modales al cerrarlos
    document.getElementById('updatePasswordModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('updatePasswordForm').reset();
        document.getElementById('successPasswordMsg').classList.add('d-none');
        document.getElementById('errorPasswordMsg').classList.add('d-none');
        document.getElementById('errorPasswordMsg').textContent = '';
    });

    document.getElementById('changeRoleModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('changeRoleForm').reset();
        document.getElementById('successMsg').classList.add('d-none');
        document.getElementById('errorMsg').classList.add('d-none');
        document.getElementById('errorMsg').textContent = '';
    });

    // Variables globales para el modal de WhatsApp
    let currentUserId = null;
    let currentInvitationCode = null;
    let userAgenda = [];
    let selectedContacts = [];

    function openWhatsAppModal(userId, invitationCode, userName) {
        currentUserId = userId;
        currentInvitationCode = invitationCode;
        selectedContacts = [];

        // Actualizar información del usuario
        document.getElementById('userNameInfo').textContent = userName;
        document.getElementById('invitationCode').textContent = invitationCode;

        // Resetear elementos del modal
        document.getElementById('contactsLoading').style.display = 'block';
        document.getElementById('contactsList').style.display = 'none';
        document.getElementById('noContactsMessage').classList.add('d-none');
        document.getElementById('selectedCounter').classList.add('d-none');
        document.getElementById('sendWhatsAppBtn').disabled = true;
        document.getElementById('searchContacts').value = '';

        // Mostrar el modal
        var modal = new bootstrap.Modal(document.getElementById('whatsappModal'));
        modal.show();

        // Cargar los contactos de la agenda del usuario
        loadUserAgenda(userId);
    }

    function loadUserAgenda(userId) {
        fetch(`{{ url('users/agenda') }}/${userId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                userAgenda = data;
                displayContacts(data);
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('contactsLoading').style.display = 'none';
                document.getElementById('whatsappErrorMsg').classList.remove('d-none');
                document.getElementById('whatsappErrorMsg').textContent = 'Error al cargar los contactos de la agenda';
            });
    }

    function displayContacts(contacts) {
        document.getElementById('contactsLoading').style.display = 'none';

        if (contacts.length === 0) {
            document.getElementById('noContactsMessage').classList.remove('d-none');
            return;
        }

        document.getElementById('contactsList').style.display = 'block';

        const contactsContainer = document.getElementById('contactsList');
        contactsContainer.innerHTML = '';

        contacts.forEach(contact => {
            if (contact.agenom && contact.agetelmov) {
                const contactElement = createContactElement(contact);
                contactsContainer.appendChild(contactElement);
            }
        });
    }

    function createContactElement(contact) {
        const div = document.createElement('div');
        div.className = 'contact-item';
        div.dataset.contactId = contact.id;

        div.innerHTML = `
            <div class="d-flex align-items-center">
                <input type="checkbox" class="form-check-input contact-checkbox me-3" 
                       id="contact_${contact.id}" 
                       onchange="toggleContact(${contact.id}, '${contact.agenom}', '${contact.agetelmov}')">
                <div class="contact-info flex-grow-1">
                    <h6 class="mb-0">${contact.agenom}</h6>
                    <small class="text-muted">
                        <i class="mdi mdi-phone me-1"></i>${contact.agetelmov}
                        ${contact.ageema ? `<i class="mdi mdi-email ms-2 me-1"></i>${contact.ageema}` : ''}
                    </small>
                </div>
                <i class="mdi mdi-whatsapp text-success fs-4"></i>
            </div>
        `;

        // Hacer clickeable toda la tarjeta
        div.addEventListener('click', function(e) {
            if (e.target.type !== 'checkbox') {
                const checkbox = div.querySelector('input[type="checkbox"]');
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            }
        });

        return div;
    }

    function toggleContact(contactId, name, phone) {
        const checkbox = document.getElementById(`contact_${contactId}`);
        const contactElement = checkbox.closest('.contact-item');

        if (checkbox.checked) {
            selectedContacts.push({
                id: contactId,
                name: name,
                phone: phone.replace(/\s+/g, '') // Limpiar espacios
            });
            contactElement.classList.add('selected');
        } else {
            selectedContacts = selectedContacts.filter(c => c.id !== contactId);
            contactElement.classList.remove('selected');
        }

        updateSelectedCounter();
        updateSendButton();
    }

    function updateSelectedCounter() {
        const counter = document.getElementById('selectedCounter');
        const countElement = document.getElementById('selectedCount');

        if (selectedContacts.length > 0) {
            counter.classList.remove('d-none');
            countElement.textContent = selectedContacts.length;
        } else {
            counter.classList.add('d-none');
        }
    }

    function updateSendButton() {
        const sendBtn = document.getElementById('sendWhatsAppBtn');
        sendBtn.disabled = selectedContacts.length === 0;
    }

    // Seleccionar/Deseleccionar todos los contactos
    document.getElementById('selectAllContacts').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.contact-checkbox');
        checkboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                checkbox.checked = true;
                checkbox.dispatchEvent(new Event('change'));
            }
        });

        this.classList.add('d-none');
        document.getElementById('deselectAllContacts').classList.remove('d-none');
    });

    document.getElementById('deselectAllContacts').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.contact-checkbox');
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                checkbox.checked = false;
                checkbox.dispatchEvent(new Event('change'));
            }
        });

        this.classList.add('d-none');
        document.getElementById('selectAllContacts').classList.remove('d-none');
    });

    // Búsqueda de contactos
    document.getElementById('searchContacts').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const filteredContacts = userAgenda.filter(contact =>
            (contact.agenom && contact.agenom.toLowerCase().includes(searchTerm)) ||
            (contact.agetelmov && contact.agetelmov.includes(searchTerm)) ||
            (contact.ageema && contact.ageema.toLowerCase().includes(searchTerm))
        );

        displayContacts(filteredContacts);
    });

    // Enviar por WhatsApp
    document.getElementById('sendWhatsAppBtn').addEventListener('click', function() {
        if (selectedContacts.length === 0) {
            return;
        }

        const androidLink = '{{ env("APP_ANDROID_LINK", "https://play.google.com/store/apps/details?id=com.redesycomponentes.GABINETETIC") }}';
        const appleLink = '{{ env("APP_APPLE_LINK", "https://apps.apple.com/us/app/gabinetetic/id6753976281") }}';
        const message = `Hola, descarga nuestra nueva app móvil en:\n\nAndroid: ${androidLink}\niOS: ${appleLink}\n\nY podrás acceder rápidamente con este código: ${currentInvitationCode}`;

        // Si solo hay un contacto seleccionado, abrir WhatsApp directamente
        if (selectedContacts.length === 1) {
            const contact = selectedContacts[0];
            const waUrl = `https://api.whatsapp.com/send?phone=${contact.phone}&text=${encodeURIComponent(message)}`;
            window.open(waUrl, '_blank');
        } else {
            // Para múltiples contactos, mostrar opciones
            let urls = [];
            selectedContacts.forEach(contact => {
                const waUrl = `https://api.whatsapp.com/send?phone=${contact.phone}&text=${encodeURIComponent(message)}`;
                urls.push({
                    name: contact.name,
                    phone: contact.phone,
                    url: waUrl
                });
            });

            // Crear modal con links individuales
            showMultipleContactsModal(urls);
        }
    });

    function showMultipleContactsModal(urls) {
        let modalHtml = `
            <div class="modal fade" id="multipleContactsModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title">
                                <i class="mdi mdi-whatsapp me-2"></i>Enviar a ${urls.length} contactos
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-3">Haz clic en cada contacto para enviar el mensaje por WhatsApp:</p>
                            <div class="list-group">
        `;

        urls.forEach(contact => {
            modalHtml += `
                <a href="${contact.url}" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center whatsapp-link">
                    <i class="mdi mdi-whatsapp text-success me-3 fs-4"></i>
                    <div>
                        <div class="fw-semibold">${contact.name}</div>
                        <small class="text-muted">${contact.phone}</small>
                    </div>
                </a>
            `;
        });

        modalHtml += `
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Agregar el modal al DOM y mostrarlo
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        const multiModal = new bootstrap.Modal(document.getElementById('multipleContactsModal'));
        multiModal.show();

        // Limpiar el modal del DOM cuando se cierre
        document.getElementById('multipleContactsModal').addEventListener('hidden.bs.modal', function() {
            this.remove();
        });

        // Cerrar el modal principal
        const mainModal = bootstrap.Modal.getInstance(document.getElementById('whatsappModal'));
        if (mainModal) {
            mainModal.hide();
        }
    }

    // Limpiar modal al cerrar
    document.getElementById('whatsappModal').addEventListener('hidden.bs.modal', function() {
        selectedContacts = [];
        userAgenda = [];
        document.getElementById('contactsList').innerHTML = '';
        document.getElementById('searchContacts').value = '';
        document.getElementById('selectedCounter').classList.add('d-none');
        document.getElementById('whatsappSuccessMsg').classList.add('d-none');
        document.getElementById('whatsappErrorMsg').classList.add('d-none');
        document.getElementById('selectAllContacts').classList.remove('d-none');
        document.getElementById('deselectAllContacts').classList.add('d-none');
    });
</script>
@endpush