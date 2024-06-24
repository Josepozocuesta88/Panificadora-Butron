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

<body class="">

    <!--Auth fluid left content -->
        <div class="px-2 " style="margin: 0 auto; max-width:900px;">
            <div class=" d-flex flex-column h-100 gap-1">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-start align-self-center mt-5">
                    <a href="{{ route('welcome') }}" class="logo-dark">
                        <span><img src="{{ asset(config('app.logo')) }}" alt="logo" height="100"></span>
                    </a>
                </div>

                <div class="mt-4">
                    <!-- title-->
                    <h4 class="mt-0 text-primary">Entrar</h4>
                    <p class="text-muted mb-4">Introduzca su email y contraseña para acceder a la cuenta.</p>

                    <!-- form -->
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label text-md-end">{{ __('Correo electrónico') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong> Email y/o contraseña incorrectas. </strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label text-md-end">{{ __('Contraseña') }}</label>

                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong> La contrasña no es correcta. </strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Recordar más tarde') }}
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid mb-0 text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Entrar') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('¿Olvidaste tu contraseña?') }}
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>
                    <!-- end form-->
                </div>


            </div> <!-- end .card-body -->
        </div>
        <!-- end auth-fluid-form-box-->


</body>

</html>