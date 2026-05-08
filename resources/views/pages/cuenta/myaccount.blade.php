<!-- ============================================================== -->
<!-- Mi cuenta: para que el usuario pueda hacer update de sus credenciales, etc -->
<!-- ============================================================== -->


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
            <li class="breadcrumb-item active">Mi Cuenta</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- end page title -->


  <!-- Gestión de correos del cliente -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
              <div class="icon-container me-3"
                style="width: 60px; height: 60px; background: linear-gradient(135deg, #c98c00 0%, #b07a00 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-envelope-fill text-white" style="font-size: 1.75rem;"></i>
              </div>
              <div>
                <h4 class="mb-1">Gestión de Correos Electrónicos</h4>
                <p class="text-muted mb-0">
                  Administra los correos asociados a tu cuenta para facturación, ventas y notificaciones
                </p>
              </div>
            </div>
            <a href="{{ route('client-emails.index') }}" class="btn btn-primary btn-lg">
              <i class="bi bi-gear me-2"></i>
              Gestionar Correos
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin -->

  <div class="row">
    <div class="col-12">
      @if (session('status'))
      <div class="alert alert-success alert-dismissible border-0 fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        {{ session('status') }}
      </div>
      @endif

      @if(auth()->user()->usunuevo == 1 || auth()->user()->usunuevo == null)
      <div class="alert alert-danger alert-dismissible border-0 fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h2><strong>{{ __('Es recomendable cambiar su contraseña') }}</strong></h2>
      </div>
      @endif

      <div class="card">
        <div class="card-body">
          <div class="container">
            <h2 class="pb-3">{{ __('Mi Cuenta') }}</h2>
            <h4 class="pb-2 text-primary font-22">{{ __('Mis datos de usuario') }}</h4>
            <form action="{{ route('myaccount.update') }}" method="POST">
              @csrf
              @method('PUT')
              <div class="form-group row py-1">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name', auth()->user()->name) }}" required autocomplete="name" autofocus>

                  @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row py-1">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico') }}</label>

                <div class="col-md-6">
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email', auth()->user()->email) }}" required autocomplete="email">

                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row py-1">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                <div class="col-md-6">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" autocomplete="new-password" placeholder="*********">

                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ __('La contraseña debe tener al menos 8 caracteres') }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row py-1">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar
                  contraseña') }}</label>

                <div class="col-md-6">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                    autocomplete="new-password" placeholder="*********">
                </div>
              </div>

              <div class="form-group row py-1 mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Actualizar perfil') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div> <!-- end card-body-->
      </div> <!-- end card-->
    </div> <!-- end col -->
  </div>
  <!-- end row -->



</div> <!-- container -->

@endsection