@extends('layouts.app')
@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <!-- Tarjeta -->
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
          <h4 class="mb-0">Seleccione las imágenes corporativas</h4>
        </div>
        <div class="card-body">
          <!-- Mensaje de éxito  si existe-->
          @if(session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif

          <form action="{{ route('updateLogo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="logo" class="form-label">Nuevo Logo (PNG)</label>
              <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo"
                accept="image/png">
              @error('logo')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
              <div class="form-text">El archivo debe ser .png y reemplazará el logo actual.</div>
            </div>

            <div class="mb-3">
              <label for="bglogin" class="form-label">Nuevo fondo Login (PNG)</label>
              <input type="file" class="form-control @error('bglogin') is-invalid @enderror" name="bglogin"
                accept="image/png">
              @error('bglogin')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
              <div class="form-text">El archivo debe ser .png y reemplazará el fondo de login actual.</div>
            </div>

            <div class="mb-3">
              <label for="bgprincipal" class="form-label">Nuevo fondo principal (PNG)</label>
              <input type="file" class="form-control @error('bgprincipal') is-invalid @enderror" name="bgprincipal"
                accept="image/png">
              @error('bgprincipal')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
              <div class="form-text">El archivo debe ser .png y reemplazará el fondo principal actual.</div>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-success">Actualizar imágenes Corporativas</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection