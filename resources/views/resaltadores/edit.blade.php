@extends('layouts.app')

@section('title', 'Editar resaltador')

@push('validation')
<script>
$(document).ready(function () {
    $('#form_main').validate({
        submitHandler: function(form){

            // if ($('[name="subrubros_nuevos[]"]').length == 0) {
            //     Swal.fire({
            //         title: 'Error',
            //         text: "Debe ingresar al menos 1 (uno) subrubro",
            //         icon: 'error',
            //         confirmButtonColor: '#d33',
            //         confirmButtonText: 'Entendido'
            //     });

            //     return false;
            // }

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
            f_nombre: {
                required: true,
            },
            f_publico: {
                required: false,
            },
            f_observaciones: {
                required: false,
            },
            imagen: {
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
    
    <span class="vch-dot vch-dot--pink-left"></span>
    <span class="vch-dot vch-dot--blue-left"></span>
    <span class="vch-dot vch-dot--yellow"></span>
    <span class="vch-dot vch-dot--blue"></span>
    <span class="vch-dot vch-dot--green"></span>
    <span class="vch-dot vch-dot--pink"></span>
    <span class="vch-dot vch-dot--blue-small"></span>

    <section class="vch-hero">
        <div class="vch-hero__content">
            <h1 class="vch-title">Editar resaltador</h1>
            <p class="vch-subtitle">Modifica los datos del resaltador seleccionado.</p>
        </div>
    </section>

    <form method="POST" action="{{ route('resaltadores.update', $resaltador->resal_id) }}" enctype="multipart/form-data" id="form_main">
        @csrf
        @method('PUT')

        <div class="vch-card p-3 mb-3">

            <h6 class="fw-bold mb-3">Datos del resaltador</h6>

            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label required-label">Nombre</label>
                    <input type="text" name="f_nombre" class="form-control field-required" value="{{ old('f_nombre', $resaltador->resal_nombre) }}" placeholder="Ej: Empresa, Persona, ONG..." required>

                    @error('f_nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                {{-- <div class="col-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="form-label required-label">Fecha inicio</label>
                            <input type="text" name="f_fecha_ini_lab" id="f_fecha_ini_lab" class="form-control field-required" value="{{ old('f_fecha_ini_lab', $resaltador->resal_fecha_ini!='' ? $resaltador->resal_fecha_ini->format('d/m/Y') : '') }}" placeholder="01/01/2026" required>
                            <input type="hidden" name="f_fecha_ini" id="f_fecha_ini" value="{{ old('f_fecha_ini', $resaltador->resal_fecha_ini) }}">

                            @error('f_fecha_ini_lab')
                                <div class="text-required">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label required-label">Fecha finalizacion</label>
                            <input type="text" name="f_fecha_fin_lab" id="f_fecha_fin_lab" class="form-control field-required" value="{{ old('f_fecha_fin_lab', $resaltador->resal_fecha_fin!='' ? $resaltador->resal_fecha_fin->format('d/m/Y') : '') }}" placeholder="31/01/2026" required>
                            <input type="hidden" name="f_fecha_fin" id="f_fecha_fin" value="{{ old('f_fecha_fin', $resaltador->resal_fecha_fin) }}">

                            @error('f_fecha_fin_lab')
                                <div class="text-required">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div> --}}

                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="f_publico" id="f_publico" value="1" {{ old('f_publico', $resaltador->resal_publico) ? 'checked' : '' }}>
                        <label class="form-check-label" for="f_publico">Publico</label>
                    </div>

                    @error('f_publico')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ARCHIVOS --}}
                <div class="col-12">
                    <label class="form-label required-label">Imagen</label>
                    <input type="file" name="imagen" id="imagen" accept="image/*" class="form-control">
                </div>

                <div class="col-12">
                    <label class="form-label">Observaciones</label>
                    <textarea name="f_observaciones" class="form-control" rows="3" placeholder="Notas internas o descripción opcional...">{{ old('f_observaciones', $resaltador->resal_descripcion) }}</textarea>

                    @error('f_observaciones')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-between form-actions">
            <button type="button" class="btn btn-danger" data-id="{{ $resaltador->resal_id }}" data-url="{{ route('resaltadores.delete', $resaltador->resal_id) }}" id="btn_eliminar">Eliminar</button>
            <div>
                <a href="{{ route('resaltadores.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success" id="btn_actualizar">Actualizar</button>
            </div>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        let fpFechaFin = $("#f_fecha_fin_lab").flatpickr({
            dateFormat: "d/m/Y",
            altInput: false,
            locale: "es",
            onChange: function (selectedDates) {
                let fecha = selectedDates[0];

                if (fecha) {
                    let yyyy = fecha.getFullYear();
                    let mm = String(fecha.getMonth() + 1).padStart(2, '0');
                    let dd = String(fecha.getDate()).padStart(2, '0');

                    $("#f_fecha_fin").val(`${yyyy}-${mm}-${dd}`);

                    fpFechaIni[0].set("maxDate", fecha);

                    let fechaIniSeleccionada = fpFechaIni[0].selectedDates[0];
                    if (fechaIniSeleccionada && fechaIniSeleccionada > fecha) {
                        fpFechaIni[0].clear();
                        $("#f_fecha_ini").val("");
                    }
                } else {
                    $("#f_fecha_fin").val("");
                }
            }
        });

        let fpFechaIni = $("#f_fecha_ini_lab").flatpickr({
            dateFormat: "d/m/Y",
            altInput: false,
            locale: "es",
            onChange: function (selectedDates) {
                let fecha = selectedDates[0];

                if (fecha) {
                    let yyyy = fecha.getFullYear();
                    let mm = String(fecha.getMonth() + 1).padStart(2, '0');
                    let dd = String(fecha.getDate()).padStart(2, '0');

                    $("#f_fecha_ini").val(`${yyyy}-${mm}-${dd}`);

                    // La fecha fin no puede ser menor a la fecha inicio
                    fpFechaFin[0].set("minDate", fecha);

                    // Si la fecha fin actual quedó inválida, la limpiamos
                    let fechaFinSeleccionada = fpFechaFin[0].selectedDates[0];
                    if (fechaFinSeleccionada && fechaFinSeleccionada < fecha) {
                        fpFechaFin[0].clear();
                        $("#f_fecha_fin").val("");
                    }
                } else {
                    $("#f_fecha_ini").val("");
                    fpFechaFin[0].set("minDate", null);
                }
            }
        });
    });
</script>
<script>
$(document).on('click', '#btn_eliminar', function (e) {
    e.preventDefault();

    let url = $(this).data('url');

    Swal.fire({
        title: '¿Eliminar resaltador?',
        text: "Esta acción la desactivará",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            $.post(url, {
                _token: "{{ csrf_token() }}"
            }).done(function () {
                window.location.href = "{{ route('resaltadores.index') }}";
            });

        }
    });
});
</script>
@endpush