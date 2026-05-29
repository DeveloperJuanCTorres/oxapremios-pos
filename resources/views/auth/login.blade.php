@extends('layouts.app')

<link href="{{ asset('css/login.css')}}?v=1993.0.1" rel="stylesheet" />

@section('content')

<div class="container-fluid p-0">
    <div class="row g-0 login-wrapper">
        <!-- Visual Section (Split Screen Left) -->
        <section class="col-lg-6 marketing-panel px-4">
            <img alt="Retail Environment" class="marketing-bg" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAeUxRbD5YBU2jDxmHeqeFPzRr0Cn7HhVVNhGdjPgGYPpYnjijxF770E9sFEteyghGSCAx1z1JHt6vjZuznqlu1cnKGCzAtij5U9zJQp8fZpzVVmK_gSxh5jEA7DJhdtHDOpRqnF2tLaQGb9TfBOZVkI276ytTKoyLZYmtbuz301yJNC4WXpY1FnbqWM34_5YSyWitEil2vs-Sk7DorobZdwJ-D9nJ-vejuqMW9dZ2XvkqxMcWYXJ3nGFkWDOd1NeZKbTeJmM6u5lE" />
            <div class="marketing-content">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <img src="{{asset('images/logo.png')}}" width="200" alt="logo">
                </div>
                <h3>
                    Sistema POS
                </h3>
            </div>
            <div class="marketing-content">
                <div class="feature-card d-flex align-items-center gap-3">
                    <i class="fa-solid fa-shield-check fa-xl text-info"></i>
                    <div>
                        <div class="text-label text-white opacity-75">Seguridad Certificada</div>
                        <div class="small">Encriptación de extremo a extremo en cada transacción.</div>
                    </div>
                </div>
                <div class="feature-card d-flex align-items-center gap-3">
                    <i class="fa-solid fa-rotate fa-xl text-info"></i>
                    <div>
                        <div class="text-label text-white opacity-75">Sincronización Real</div>
                        <div class="small">Inventario y reportes actualizados al instante.</div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Login Form Section (Split Screen Right) -->
        <section class="col-lg-6 login-panel">
            <div class="login-form-container">
                <!-- Mobile Brand Header -->
                <div class="d-lg-none d-flex align-items-center gap-2 mb-5">
                    <img src="{{asset('images/logo.png')}}" width="100%" alt="logo">
                </div>
                <div class="mb-5">
                    <h2 class="fw-bold mb-2">Bienvenido de nuevo</h2>
                    <p class="text-secondary mb-0">Ingresa tus credenciales para acceder al terminal</p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                        @csrf

                    <!-- Email / Username Field -->
                    <div class="mb-4">
                        <label class="form-label text-label mb-2" for="username">Email o Usuario</label>
                        <div class="form-control-icon-wrapper">
                            <i class="fa-solid fa-user"></i>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nombre@tienda.com">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!-- Password Field -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label text-label mb-0" for="password">Contraseña</label>
                            <a class="text-decoration-none small fw-semibold" href="#">¿Olvidé mi contraseña?</a>
                        </div>
                        <div class="form-control-icon-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input
                                id="password"
                                type="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••">
                            <button
                                class="password-toggle"
                                onclick="togglePassword()"
                                type="button">

                                <i class="fa-solid fa-eye" id="password-toggle-icon"></i>

                            </button>
                            
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <!-- Remember Me -->
                    <div class="mb-4 form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-secondary" for="remember">
                            Recordarme en este equipo
                        </label>
                    </div>
                    <!-- Primary Action -->
                    <button class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center gap-2 mb-3" type="submit">
                        <span>Iniciar Sesión</span>
                        <i class="fa-solid fa-right-to-bracket"></i>
                    </button>

                    @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                    @endif
                </form>

                <!-- Footer -->
                <footer class="mt-5 pt-4 text-center border-top border-light">
                    <p class="text-muted small mb-2">
                        © 2026 OXAPREMIOS TREFF v2.4.1 | <a href="https://www.vesergenperu.com" target="_blank">Creado por Grupo VesergenPeru</a>
                    </p>
                    <div class="d-flex justify-content-center gap-3 small">
                        <a class="text-decoration-none" href="#">Soporte Técnico</a>
                        <span class="text-muted">•</span>
                        <a class="text-decoration-none" href="#">Términos de Uso</a>
                    </div>
                </footer>
            </div>
        </section>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('password-toggle-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>
@endsection
