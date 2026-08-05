@extends('layouts.app')

@section('title', 'Nuevo tipo de modalidad')

@push('validation')
<script>
$(document).ready(function () {
    $('#form_main').validate({
        submitHandler: function(form){

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se va a crear el registro",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5cb85c',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, crear',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    // Loader opcional
                    Swal.fire({
                        title: 'Procesando...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    form.submit();
                }
            });
        },
        rules: {
            nombre: {
                required: true,
            },
            descripcion: {
                required: false,
            },
            condiciones: {
                required: true,
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

@include('partials.navbar')

<div class="container">

    {{-- <div class="vch-hero-wave vch-hero-wave--one"></div> --}}
    <div class="vch-hero-wave vch-hero-wave--two"></div>

    <span class="vch-dot vch-dot--pink-left"></span>
    <span class="vch-dot vch-dot--blue-left"></span>
    <span class="vch-dot vch-dot--yellow"></span>
    <span class="vch-dot vch-dot--blue"></span>
    <span class="vch-dot vch-dot--green"></span>
    <span class="vch-dot vch-dot--pink"></span>
    <span class="vch-dot vch-dot--blue-small"></span>

    <section class="vch-hero">
        <div class="vch-hero__content">
            <h1 class="vch-title">Nuevo tipo de modalidad</h1>
            <p class="vch-subtitle">...</p>
        </div>
    </section>

    <form method="POST" action="{{ route('admin.tipos_modalidades.store') }}" id="form_main">
        @csrf

        <!-- CARD -->
        <div class="vch-card p-3 mb-3">

            <h6 class="fw-bold mb-3">Datos del tipo de modalidad</h6>

            <div class="row g-3">

                <!-- NOMBRE -->
                <div class="col-12">
                    <label class="form-label required-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control field-required" value="{{ old('nombre') }}" placeholder="Ej: Empresa, Persona, ONG..." required>

                    @error('nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Descripci&oacute;n</label>
                    <textarea name="descripcion" class="form-control" rows="3" placeholder="Notas internas o descripción opcional...">{{ old('descripcion') }}</textarea>

                    @error('descripcion')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Condiciones</label>
                    <textarea name="condiciones" class="form-control" rows="3" placeholder="Condiciones preestablecidas para el voucher...">{{ old('condiciones') }}</textarea>
                </div>

            </div>
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-between form-actions">
            <a href="{{ route('admin.tipos_modalidades.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </div>

    </form>

</div>
@endsection
