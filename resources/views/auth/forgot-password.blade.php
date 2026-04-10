<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña | Vauchis</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --vauchis-blue: #2f63c7;
            --vauchis-green: #46b989;
            --vauchis-pink: #ec4b93;
            --vauchis-text: #3f4358;
            --vauchis-muted: #6c7288;
            --vauchis-bg: #eeeff8;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(180deg, #eff0f8 0%, #e9ebf6 100%);
        }

        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 30px 0;
        }

        .auth-shell {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 28px;
            box-shadow: 0 24px 70px rgba(45, 62, 125, 0.12);
            overflow: hidden;
        }

        .left-side {
            padding: 42px;
        }

        .hero-title {
            font-size: 44px;
            line-height: 1.05;
            font-weight: 800;
            color: var(--vauchis-text);
            margin-bottom: 18px;
        }

        .hero-text {
            color: var(--vauchis-muted);
            font-size: 18px;
            line-height: 1.7;
            margin-bottom: 22px;
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


        .form-card-header small {
            color: rgba(255,255,255,.82);
            display: block;
            margin-bottom: 4px;
        }

        .form-card-body {
            padding: 34px;
        }

        .form-label {
            color: #4f5368;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .form-control-custom {
            background: #fbfcff;
            border: 1px solid #dde4f0;
            border-radius: 18px;
            min-height: 54px;
            padding: 14px 16px;
        }

        .form-control-custom:focus {
            border-color: var(--vauchis-blue);
            box-shadow: 0 0 0 0.25rem rgba(47, 99, 199, 0.14);
            background: #fff;
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

        .link-pink {
            color: var(--vauchis-pink);
            font-weight: 800;
            text-decoration: none;
        }

        .link-pink:hover {
            color: #d73b81;
        }

        @media (max-width: 991.98px) {
            .left-side { padding: 24px; }
            .hero-title { font-size: 34px; }
            .form-card { margin: 16px; }
            .form-card-body, .form-card-header { padding-left: 20px; padding-right: 20px; }
        }
    </style>
</head>
<body>
    <div class="auth-page">
        <div class="container">
            <div class="auth-shell">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="left-side">
                            <h1 class="hero-title">Recupera tu acceso en pocos pasos</h1>
                            <p class="hero-text">
                                Ingresa tu correo y te enviaremos instrucciones para restablecer tu contraseña y volver a tu cuenta de Vauchis.
                            </p>

                            <div>
                                <span class="feature-pill pill-green">Simple</span>
                                <span class="feature-pill pill-blue">Seguro</span>
                                <span class="feature-pill pill-pink">Rápido</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-card">
                            <div class="form-card-header">
                                <small>Vauchis</small>
                                <h2 class="mb-0">¿Olvidaste tu contraseña?</h2>
                            </div>

                            <div class="form-card-body">
                                @if (session('status'))
                                    <div class="alert alert-success rounded-4">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <p class="text-muted mb-4">
                                    Te enviaremos un enlace para restablecer tu contraseña.
                                </p>

                                <form method="POST" action="{{ route('password.email') }}">
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

                                    <div class="d-grid mb-3">
                                        <button type="submit" class="btn btn-vauchis btn-lg">
                                            Enviar enlace de recuperación
                                        </button>
                                    </div>
                                </form>

                                <p class="text-center mb-0 text-muted">
                                    ¿Recordaste tu contraseña?
                                    <a href="{{ route('login') }}" class="link-pink">Ingresar</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>