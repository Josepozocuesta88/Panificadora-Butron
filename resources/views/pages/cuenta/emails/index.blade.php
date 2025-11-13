@extends('layouts.app')

@section('content')
<style>
    .email-card {
        border-radius: 12px;
        border: 2px solid #e3e6f0;
        transition: all 0.3s ease;
        background: white;
    }

    .email-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(201, 140, 0, 0.15);
        border-color: #c98c00;
    }

    .email-card.primary {
        border-color: #c98c00;
        background: linear-gradient(135deg, #fff9e6 0%, #ffffff 100%);
    }

    .badge-type {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-facturacion {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .badge-ventas {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .badge-admin {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: #333;
    }

    .badge-soporte {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .badge-logistica {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: #333;
    }

    .badge-general {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        color: #333;
    }

    .badge-primary-email {
        background: linear-gradient(135deg, #c98c00 0%, #b07a00 100%);
        color: white;
        font-size: 0.7rem;
        padding: 0.3rem 0.6rem;
    }

    .badge-active {
        background: #d4edda;
        color: #155724;
    }

    .badge-inactive {
        background: #f8d7da;
        color: #721c24;
    }

    .btn-action {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-add-email {
        background: linear-gradient(135deg, #c98c00 0%, #b07a00 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(201, 140, 0, 0.3);
    }

    .btn-add-email:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(201, 140, 0, 0.4);
        color: white;
    }

    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background: linear-gradient(135deg, #c98c00 0%, #b07a00 100%);
        color: white;
        border-radius: 16px 16px 0 0;
        padding: 1.5rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #c98c00;
        box-shadow: 0 0 0 0.2rem rgba(201, 140, 0, 0.25);
    }

    .email-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #c98c00 0%, #b07a00 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        margin-right: 1rem;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: #c98c00;
        margin-bottom: 1rem;
    }
</style>

<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('myaccount') }}">Mi Cuenta</a></li>
                        <li class="breadcrumb-item active">Gestión de Correos</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    <i class="bi bi-envelope-fill me-2"></i>
                    Gestión de Correos Electrónicos
                </h4>
            </div>
        </div>
    </div>

    <!-- Alertas -->
    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Error:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Botón añadir -->
    <div class="row mb-4">
        <div class="col-12">
            <button class="btn btn-add-email" data-bs-toggle="modal" data-bs-target="#addEmailModal">
                <i class="bi bi-plus-circle me-2"></i>
                Añadir Nuevo Correo
            </button>
        </div>
    </div>

    <!-- Lista de correos -->
    <div class="row">
        @forelse($emails as $email)
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="email-card {{ $email->is_primary ? 'primary' : '' }} p-4">
                <div class="d-flex align-items-start mb-3">
                    <div class="email-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="mb-0" style="word-break: break-all;">{{ $email->email }}</h5>
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <span class="badge badge-type badge-{{ $email->type }}">
                                {{ $email->type_name }}
                            </span>
                            @if($email->is_primary)
                            <span class="badge badge-primary-email">
                                <i class="bi bi-star-fill me-1"></i>Principal
                            </span>
                            @endif
                            <span class="badge {{ $email->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $email->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($email->notes)
                <div class="mb-3 p-2 bg-light rounded">
                    <small class="text-muted">
                        <i class="bi bi-sticky me-1"></i>
                        {{ $email->notes }}
                    </small>
                </div>
                @endif

                <div class="d-flex flex-wrap gap-2">
                    @if(!$email->is_primary)
                    <form action="{{ route('client-emails.set-primary', $email) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-action btn-outline-warning btn-sm" title="Establecer como principal">
                            <i class="bi bi-star"></i>
                        </button>
                    </form>
                    @endif

                    <button class="btn btn-action btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#editEmailModal{{ $email->id }}" title="Editar">
                        <i class="bi bi-pencil"></i>
                    </button>

                    <form action="{{ route('client-emails.toggle-active', $email) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-action btn-outline-secondary btn-sm"
                            title="{{ $email->is_active ? 'Desactivar' : 'Activar' }}">
                            <i class="bi bi-{{ $email->is_active ? 'toggle-on' : 'toggle-off' }}"></i>
                        </button>
                    </form>

                    <form action="{{ route('client-emails.destroy', $email) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('¿Está seguro de eliminar este correo?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-action btn-outline-danger btn-sm" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Editar -->
        <div class="modal fade" id="editEmailModal{{ $email->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil me-2"></i>
                            Editar Correo Electrónico
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('client-emails.update', $email) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_email{{ $email->id }}" class="form-label">
                                    <i class="bi bi-envelope me-1"></i>
                                    Correo Electrónico *
                                </label>
                                <input type="email" class="form-control" id="edit_email{{ $email->id }}" name="email"
                                    value="{{ $email->email }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit_type{{ $email->id }}" class="form-label">
                                    <i class="bi bi-tag me-1"></i>
                                    Tipo de Correo *
                                </label>
                                <select class="form-select" id="edit_type{{ $email->id }}" name="type" required>
                                    @foreach(\App\Models\ClientEmail::getTypes() as $key => $value)
                                    <option value="{{ $key }}" {{ $email->type == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="edit_notes{{ $email->id }}" class="form-label">
                                    <i class="bi bi-sticky me-1"></i>
                                    Notas (opcional)
                                </label>
                                <textarea class="form-control" id="edit_notes{{ $email->id }}" name="notes" rows="3"
                                    maxlength="500">{{ $email->notes }}</textarea>
                                <small class="text-muted">Máximo 500 caracteres</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>
                                Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body empty-state">
                    <i class="bi bi-envelope-slash"></i>
                    <h4 class="text-muted">No hay correos electrónicos registrados</h4>
                    <p class="text-muted">Añade tu primer correo electrónico para comenzar</p>
                    <button class="btn btn-add-email mt-3" data-bs-toggle="modal" data-bs-target="#addEmailModal">
                        <i class="bi bi-plus-circle me-2"></i>
                        Añadir Correo
                    </button>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Añadir -->
<div class="modal fade" id="addEmailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>
                    Añadir Nuevo Correo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('client-emails.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope me-1"></i>
                            Correo Electrónico *
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                            value="{{ old('email') }}" required placeholder="ejemplo@dominio.com">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">
                            <i class="bi bi-tag me-1"></i>
                            Tipo de Correo *
                        </label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="">Seleccione un tipo...</option>
                            @foreach(\App\Models\ClientEmail::getTypes() as $key => $value)
                            <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                            @endforeach
                        </select>
                        @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-1">
                            Seleccione el departamento o área asociada a este correo
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">
                            <i class="bi bi-sticky me-1"></i>
                            Notas (opcional)
                        </label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3"
                            maxlength="500" placeholder="Añade notas o comentarios adicionales...">{{ old('notes') }}</textarea>
                        @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Máximo 500 caracteres</small>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Nota:</strong> El primer correo que añadas será establecido automáticamente como principal.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>
                        Añadir Correo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection