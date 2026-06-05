
@extends('layouts.app')

@push('styles')
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
    </style>
@endpush

@push('validation')
<script>
$(document).ready(function () {
    $('#form').validate({
        rules: {
            usu_nombre: {
                required: true,
            },
            usu_apellido: {
                required: true,
            },
            tipo_doc_id: {
                required: true,
            },
            usu_documento: {
                required: true,
                number: true,
                minlength: 6
            },
            usu_email1: {
                required: true,
                email: true,
                minlength: 5
            },
            usu_email1_confirmar: {
                required: true,
                email: true,
                equalTo: "#usu_email1"
            },
            usu_celular1: {
                required: true,
                number: true,
                minlength: 8
            },
            usu_clave: {
                required: true,
                minlength: 8
            },
            usu_clave_confirmar: {
                required: true,
                minlength: 8,
                equalTo: "#usu_clave"
            },
        },
        messages: {
        },

        errorElement: 'small',

        errorPlacement: function(error, element) {
            error.addClass('vs-error-message');
            error.insertAfter(element);
        },

        highlight: function(element) {
            $(element)
                .addClass('is-invalid')
                .removeClass('is-valid');
        },

        unhighlight: function(element) {
            $(element)
                .removeClass('is-invalid')
                .addClass('is-valid');
        }
    });
});
</script>
@endpush

@section('content')

{{-- @include('partials.navbar') --}}

<div class="wrapper">
    <div class="container">
        <div class="main-card">
            {{-- <header class="topbar d-flex justify-content-between align-items-center">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-1.png') }}" alt="Vauchis" class="brand-logo">
                </a>
            </header> --}}

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
                            <form id="form" method="POST" action="{{ route('register.store') }}">
                                @csrf

                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <input type="text" name="usu_nombre" class="form-control" placeholder="Nombre">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="usu_apellido" class="form-control" placeholder="Apellido">
                                    </div>

                                    <div class="col-md-6">
                                        <select name="tipo_doc_id" class="form-select field-required" required>
                                            <option value="">Selecciona una opci&oacute;n</option>
                                            @foreach($tiposDocumento as $id => $nombre)
                                                <option value="{{ $id }}">{{ $nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="usu_documento" class="form-control" placeholder="Documento">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="email" name="usu_email1" id="usu_email1" class="form-control" placeholder="Email">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="email" name="usu_email1_confirmar" class="form-control" placeholder="Confirmar email">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="usu_celular1" class="form-control" placeholder="Celular">
                                    </div>

                                    <div class="col-sm-12"></div>

                                    <div class="col-md-6">
                                        <input type="password" name="usu_clave" id="usu_clave" class="form-control" placeholder="Contraseña">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="password" name="usu_clave_confirmation" class="form-control" placeholder="Confirmar contraseña">
                                    </div>

                                </div>

                                <div class="mt-4 d-grid">
                                    <button class="btn btn-vauchis btn-lg">Crear cuenta</button>
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

@include('partials.footer')
@endsection
