{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Vauchis</title>

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
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(180deg, #eff0f8 0%, #e9ebf6 100%);
        }

        .wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 30px 0;
        }

        .main-card {
            background: rgba(255,255,255,0.9);
            border-radius: 28px;
            box-shadow: 0 24px 70px rgba(45,62,125,0.12);
            overflow: hidden;
        }

        .left-side {
            padding: 40px;
        }

        .title {
            font-size: 42px;
            font-weight: 800;
            color: var(--vauchis-text);
        }

        .subtitle {
            color: var(--vauchis-muted);
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .login-card {
            background: #fff;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 24px 70px rgba(48,71,148,0.16);
        }

        .login-header {
            background: linear-gradient(135deg, var(--vauchis-blue), #4c74d1);
            color: #fff;
            padding: 25px;
        }

        .login-body {
            padding: 25px;
        }

        .form-control {
            border-radius: 14px;
        }

        .btn-main {
            background: var(--vauchis-green);
            border: none;
            font-weight: 700;
        }

        .btn-main:hover {
            background: #3da67a;
        }

        .link-pink {
            color: var(--vauchis-pink);
            font-weight: 700;
            text-decoration: none;
        }

        .link-pink:hover {
            color: #d73b81;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="container">
        <div class="main-card">

            <div class="row g-0 align-items-center">

                {{-- LEFT INFO (igual estilo login) --}}
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="left-side">
                        <h1 class="title">Crea tu cuenta y empieza a regalar</h1>
                        <p class="subtitle">
                            Registrate en Vauchis y accede a vouchers de marcas, experiencias y ONGs.
                        </p>

                        <div>
                            <span class="badge bg-success-subtle text-success">Simple</span>
                            <span class="badge bg-primary-subtle text-primary">Seguro</span>
                            <span class="badge bg-danger-subtle text-danger">Rápido</span>
                        </div>
                    </div>
                </div>

                {{-- FORMULARIO --}}
                <div class="col-lg-6">
                    <div class="login-card m-3">

                        <div class="login-header">
                            <h4 class="mb-0">Registro</h4>
                        </div>

                        <div class="login-body">

                            {{-- <form method="POST" action="#"> --}}
                            <form method="POST" action="{{ route('register.store') }}">
                                @csrf

                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <input type="text" name="usu_nombre" class="form-control" placeholder="Nombre">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="usu_apellido" class="form-control" placeholder="Apellido">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="tipo_doc_id" class="form-control" placeholder="Tipo doc">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="usu_documento" class="form-control" placeholder="Documento">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="email" name="usu_email1" class="form-control" placeholder="Email">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="email" name="usu_email2" class="form-control" placeholder="Email">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="usu_celular1" class="form-control" placeholder="Celular">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="usu_celular2" class="form-control" placeholder="Celular">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="usu_nick" class="form-control" placeholder="Usuario">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="password" name="usu_clave" class="form-control" placeholder="Contraseña">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="password" name="usu_clave_confirmation" class="form-control" placeholder="Confirmar contraseña">
                                    </div>

                                </div>

                                <div class="mt-4 d-grid">
                                    <button class="btn btn-main btn-lg">Crear cuenta</button>
                                </div>

                                <p class="text-center mt-3">
                                    ¿Ya tienes cuenta?
                                    <a href="{{ route('login') }}" class="link-pink">Ingresar</a>
                                </p>

                            </form>

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

{{-- Ruta sugerida:
Route::get('/register', fn() => view('auth.register'))->name('register');
--}}