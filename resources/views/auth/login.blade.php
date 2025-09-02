<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="{{ asset(config('app.favicon')) }}">

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="{{asset('css/app-saas.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{asset('css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/css.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('build/assets/app-7f9c8fa3.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{asset('js/hyper-config.js')}}"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>

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
                <p class="text-muted mb-4">Accede con tu usuario y contraseña o con un código de invitación.</p>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

                        <div class="mb-3">
                            <label for="invite_code" class="form-label text-md-end">Código de Invitación (opcional)</label>
                            <div class="input-group">
                                <input id="invite_code" type="text" class="form-control @error('invite_code') is-invalid @enderror"
                                    name="invite_code" value="{{ old('invite_code') }}">
                                <button type="button" class="btn btn-outline-primary" id="checkInviteBtn">Validar</button>
                            </div>
                            @error('invite_code')
                            <span class="invalid-feedback" role="alert">
                                <strong> Código de invitación inválido. </strong>
                            </span>
                            @enderror
                            <div id="inviteCodeFeedback" class="form-text text-success d-none"></div>
                        </div>

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
                                <strong> La contraseña no es correcta. </strong>
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
            </div>

            <script>
                document.getElementById('checkInviteBtn').addEventListener('click', function() {
                    const code = document.getElementById('invite_code').value;
                    const feedback = document.getElementById('inviteCodeFeedback');
                    feedback.classList.add('d-none');
                    if (!code) return;

                    fetch('{{ route("loginValidateCode") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                invite_code: code
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('email').value = data.email;
                                document.getElementById('password').value = data.password;
                                feedback.textContent = 'Código válido. Datos cargados.';
                                feedback.classList.remove('d-none', 'text-danger');
                                feedback.classList.add('text-success');
                            } else {
                                feedback.textContent = 'Código de invitación inválido.';
                                feedback.classList.remove('d-none', 'text-success');
                                feedback.classList.add('text-danger');
                            }
                        })
                        .catch(() => {
                            feedback.textContent = 'Error al validar el código.';
                            feedback.classList.remove('d-none', 'text-success');
                            feedback.classList.add('text-danger');
                        });
                });

                document.addEventListener('DOMContentLoaded', function() {
                    // Cargar credenciales si existen en localStorage
                    const saved = localStorage.getItem('loginCredentials');
                    if (saved) {
                        try {
                            const creds = JSON.parse(saved);
                            if (creds.email) document.getElementById('email').value = creds.email;
                            if (creds.password) document.getElementById('password').value = creds.password;
                            document.getElementById('remember').checked = true;
                        } catch (e) {}
                    }

                    // Guardar credenciales al enviar el formulario si "Recordar más tarde" está marcado
                    document.getElementById('loginForm').addEventListener('submit', function() {
                        const remember = document.getElementById('remember').checked;
                        const email = document.getElementById('email').value;
                        const password = document.getElementById('password').value;
                        if (remember) {
                            localStorage.setItem('loginCredentials', JSON.stringify({
                                email,
                                password
                            }));
                        } else {
                            localStorage.removeItem('loginCredentials');
                        }
                    });
                });
            </script>

        </div>
    </div>

</body>

</html>