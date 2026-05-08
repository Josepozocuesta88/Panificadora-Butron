<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    
    <link rel="shortcut icon" href="{{ asset(config('app.favicon')) }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Theme Config Js -->
    <script src="{{asset('js/hyper-config.js')}}"></script>

    <!-- App css -->
    <link href="{{asset('css/app-saas.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Iconos -->
    <link href="{{asset('css/icons.css') }}" rel="stylesheet" type="text/css" />
    <!-- Css personalizado -->
    <link href="{{asset('css/css.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('build/assets/app-7f9c8fa3.css') }}" rel="stylesheet" type="text/css" />


    <!-- Scripts -->
    <!-- vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
</head>

<body class="authentication-bg pb-0">

    <div class="auth-fluid" id="app">
        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3">Bienvenid@ a {{ config('app.name') }} !</h2>
            </div> <!-- end auth-user-testimonial-->
        </div>
        <!-- end Auth fluid right content -->
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="card-body d-flex flex-column h-100 gap-3">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-start align-self-center mt-5">
                    <a href="index.html" class="logo-dark">
                        <span><img src="{{ asset(config('app.logo')) }}" alt="logo" height="100"></span>
                    </a>
                </div>

                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <h4 class="mt-0 text-primary">Ayuda de contraseña</h4>
                    <p class="text-muted mb-4">Introduzca su email y le enviaremos un correo para restablecer su contraseña.</p>

                    <div class="mb-3">
                        <label for="email" class="form-label text-md-end">{{ __('Correo electrónico') }}</label>

                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="row mb-0">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Enviar para restablecer contraseña') }}
                        </button>
                    </div>
                </form>

            </div> <!-- end .card-body -->
        </div>
        <!-- end auth-fluid-form-box-->

    </div>

</body>

</html>