{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar | Vauchis</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Font similar al estilo de la referencia --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --vauchis-blue: #2f63c7;
            --vauchis-blue-dark: #264f9e;
            --vauchis-green: #46b989;
            --vauchis-pink: #ec4b93;
            --vauchis-text: #3f4358;
            --vauchis-muted: #6c7288;
            --vauchis-bg: #eeeff8;
            --vauchis-card: #ffffff;
            --vauchis-border: #e6ebf5;
            --vauchis-input: #fbfcff;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(180deg, #eff0f8 0%, #e9ebf6 100%);
            color: var(--vauchis-text);
        }

        .login-page {
            min-height: 100vh;
            padding: 32px 0;
            display: flex;
            align-items: center;
        }

        .login-shell {
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 24px 70px rgba(45, 62, 125, 0.10);
            backdrop-filter: blur(6px);
        }

        .topbar {
            padding: 28px 38px;
        }

        .brand-logo {
            max-height: 52px;
            width: auto;
        }

        .nav-link-custom {
            color: #4c4f64;
            font-weight: 600;
            text-decoration: none;
            margin-left: 28px;
        }

        .nav-link-custom:hover {
            color: var(--vauchis-blue);
        }

        .hero-section {
            padding: 20px 38px 48px;
        }

        .hero-badge {
            display: inline-block;
            background: #f1f6ff;
            color: var(--vauchis-blue);
            padding: 10px 18px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 22px;
        }

        .hero-title {
            font-size: 56px;
            line-height: 1.05;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--vauchis-text);
            margin-bottom: 22px;
            max-width: 560px;
        }

        .hero-text {
            font-size: 20px;
            line-height: 1.8;
            color: var(--vauchis-muted);
            max-width: 530px;
            margin-bottom: 28px;
        }

        .feature-pill {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 800;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .pill-green { background: #e8f8f0; color: var(--vauchis-green); }
        .pill-blue { background: #edf3ff; color: var(--vauchis-blue); }
        .pill-pink { background: #fff0f7; color: var(--vauchis-pink); }

        .visual-side {
            position: relative;
            padding: 20px 20px 20px 10px;
        }

        .visual-side::before {
            content: "";
            position: absolute;
            right: 30px;
            top: 10px;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: #edf3ff;
            filter: blur(8px);
            z-index: 0;
        }

        .visual-side::after {
            content: "";
            position: absolute;
            left: 30px;
            bottom: 30px;
            width: 240px;
            height: 70px;
            border-radius: 50%;
            background: rgba(47, 99, 199, 0.08);
            filter: blur(10px);
            z-index: 0;
        }

        .dot {
            position: absolute;
            border-radius: 50%;
            z-index: 1;
        }

        .dot-yellow { width: 10px; height: 10px; background: #f3cc51; top: 40px; left: 30px; }
        .dot-teal { width: 12px; height: 12px; background: #76cfd3; top: 120px; right: 20px; }
        .dot-red { width: 12px; height: 12px; background: #ff6c68; bottom: 120px; left: 10px; }
        .dot-blue { width: 10px; height: 10px; background: #69b0ff; bottom: 70px; right: 60px; }

        .login-card {
            position: relative;
            z-index: 2;
            max-width: 460px;
            margin: 0 auto;
            background: var(--vauchis-card);
            border-radius: 30px;
            overflow: hidden;
            border: 1px solid #edf1f8;
            box-shadow: 0 24px 70px rgba(48, 71, 148, 0.16);
        }

        .login-card-header {
            background: linear-gradient(135deg, var(--vauchis-blue) 0%, #4c74d1 100%);
            padding: 28px 34px;
        }

        .login-card-header small {
            color: rgba(255, 255, 255, 0.82);
            display: block;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .login-card-header h2 {
            color: #fff;
            font-size: 32px;
            font-weight: 800;
            margin: 0;
        }

        .login-card-body {
            padding: 34px;
        }

        .form-label {
            color: #4f5368;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .form-control-custom {
            background: var(--vauchis-input);
            border: 1px solid #dde4f0;
            border-radius: 18px;
            min-height: 54px;
            padding: 14px 16px;
            color: var(--vauchis-text);
        }

        .form-control-custom:focus {
            border-color: var(--vauchis-blue);
            box-shadow: 0 0 0 0.25rem rgba(47, 99, 199, 0.14);
            background: #fff;
        }

        .link-green {
            color: var(--vauchis-green);
            font-weight: 700;
            text-decoration: none;
        }

        .link-green:hover {
            color: #349a70;
        }

        .btn-vauchis {
            background: var(--vauchis-green);
            border: none;
            color: #fff;
            font-weight: 800;
            border-radius: 18px;
            padding: 14px 20px;
            box-shadow: 0 12px 24px rgba(70, 185, 137, 0.28);
        }

        .btn-vauchis:hover,
        .btn-vauchis:focus {
            background: #3eab7d;
            color: #fff;
        }

        .btn-outline-soft {
            border: 1px solid #e2e7f0;
            border-radius: 18px;
            padding: 12px 18px;
            font-weight: 700;
            background: #fff;
            color: #4b5066;
        }

        .btn-outline-soft:hover {
            background: #f8faff;
            color: var(--vauchis-blue);
            border-color: #dbe4f2;
        }

        .separator {
            position: relative;
            text-align: center;
            margin: 24px 0;
        }

        .separator::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #edf0f7;
            transform: translateY(-50%);
        }

        .separator span {
            position: relative;
            background: #fff;
            color: #97a0b2;
            font-size: 14px;
            padding: 0 14px;
        }

        .signup-text {
            color: var(--vauchis-muted);
            text-align: center;
            margin-top: 24px;
            margin-bottom: 0;
        }

        .link-pink {
            color: var(--vauchis-pink);
            font-weight: 800;
            text-decoration: none;
        }

        .link-pink:hover {
            color: #d73b81;
        }

        @media (max-width: 991.98px) {
            .hero-title {
                font-size: 42px;
            }

            .hero-text {
                font-size: 18px;
                line-height: 1.7;
            }

            .hero-section,
            .topbar {
                padding-left: 24px;
                padding-right: 24px;
            }

            .visual-side {
                padding: 10px 16px 30px;
            }
        }

        @media (max-width: 767.98px) {
            .login-page {
                padding: 16px 0;
            }

            .login-shell {
                border-radius: 20px;
            }

            .topbar {
                padding: 20px 18px;
            }

            .hero-section {
                padding: 8px 18px 24px;
            }

            .hero-title {
                font-size: 34px;
            }

            .hero-text {
                font-size: 16px;
            }

            .login-card-body,
            .login-card-header {
                padding-left: 20px;
                padding-right: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="container">
            <div class="login-shell">
                <header class="topbar d-flex justify-content-between align-items-center">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo-vauchis.jpg') }}" alt="Vauchis" class="brand-logo">
                    </a>
                </header>

                <div class="row g-0 align-items-center">
                    <div class="col-lg-6">
                        <section class="hero-section">
                            <span class="hero-badge">Bienvenido a Vauchis</span>

                            <h1 class="hero-title">Ingresa a tu cuenta y sigue regalando fácil</h1>

                            <p class="hero-text">
                                Accede a tu panel para comprar, enviar y gestionar vouchers de marcas,
                                negocios y ONGs locales en un solo lugar.
                            </p>

                            <div>
                                <span class="feature-pill pill-green">Simple</span>
                                <span class="feature-pill pill-blue">Seguro</span>
                                <span class="feature-pill pill-pink">Rápido</span>
                            </div>
                        </section>
                    </div>

                    <div class="col-lg-6">
                        <section class="visual-side">
                            <span class="dot dot-yellow"></span>
                            <span class="dot dot-teal"></span>
                            <span class="dot dot-red"></span>
                            <span class="dot dot-blue"></span>

                            <div class="login-card">
                                <div class="login-card-header">
                                    <small>Vauchis</small>
                                    <h2>Ingresar</h2>
                                </div>

                                <div class="login-card-body">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="mb-4">
                                            <label for="email" class="form-label">Correo electrónico</label>
                                            <input
                                                type="email"
                                                id="email"
                                                name="email"
                                                value="{{ old('email') }}"
                                                class="form-control form-control-custom @error('email') is-invalid @enderror"
                                                placeholder="tu@email.com"
                                                required
                                                autofocus
                                            >
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2 gap-2 flex-wrap">
                                                <label for="password" class="form-label mb-0">Contraseña</label>
                                                @if (Route::has('password.request'))
                                                    <a href="{{ route('password.request') }}" class="link-green">¿Olvidaste tu contraseña?</a>
                                                @endif
                                            </div>

                                            <input
                                                type="password"
                                                id="password"
                                                name="password"
                                                class="form-control form-control-custom @error('password') is-invalid @enderror"
                                                placeholder="••••••••"
                                                required
                                            >
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                                            <div class="form-check m-0">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label text-muted" for="remember">
                                                    Recordarme
                                                </label>
                                            </div>
                                        </div>

                                        <div class="d-grid">
                                            {{-- <button type="submit" class="btn btn-vauchis btn-lg">
                                                Ingresar
                                            </button> --}}
                                            <a href="{{ route('home') }}" class="btn btn-vauchis btn-lg">Ingresar</a>
                                        </div>
                                    </form>

                                    <div class="separator">
                                        <span>o continúa con</span>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-outline-soft w-100">Google</button>
                                        </div>
                                        <div class="col-6">
                                            <button type="button" class="btn btn-outline-soft w-100">Facebook</button>
                                        </div>
                                    </div>

                                    <p class="signup-text">
                                        ¿No tienes cuenta?
                                        <a href="{{ route('register') }}" class="link-pink">Crear cuenta</a>
                                    </p>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

{{--
Rutas sugeridas (web.php):
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Ubicación sugerida del logo:
public/images/logo-vauchis_v1.jpg
--}}
