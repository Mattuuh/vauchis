@extends('layouts.app')

@section('title', 'Nueva coleccion')

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
            f_nombre_interno: {
                required: true,
            },
            f_nombre: {
                required: true,
            },
            f_publico: {
                required: false,
            },
            f_descripcion: {
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
    <span class="vch-dot vch-dot--pink-left"></span>
    <span class="vch-dot vch-dot--blue-left"></span>
    <span class="vch-dot vch-dot--yellow"></span>
    <span class="vch-dot vch-dot--blue"></span>
    <span class="vch-dot vch-dot--green"></span>
    <span class="vch-dot vch-dot--pink"></span>
    <span class="vch-dot vch-dot--blue-small"></span>

    <section class="vch-hero">
        <div class="vch-hero__content">
            <h1 class="vch-title">Nueva coleccion</h1>
            <p class="vch-subtitle">####.</p>
        </div>
    </section>

    <form method="POST" action="{{ route('admin.colecciones.store') }}" enctype="multipart/form-data" id="form_main">
        @csrf

        <!-- CARD -->
        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-3">Datos de la coleccion</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label required-label">Nombre interno</label>
                    <input type="text" name="f_nombre_interno" class="form-control field-required" value="{{ old('f_nombre_interno') }}" placeholder="Ej: dia de la madre">
                </div>
                <div class="col-12">
                    <label class="form-label required-label">Nombre p&uacute;blico</label>
                    <input type="text" name="f_nombre" class="form-control field-required" value="{{ old('f_nombre') }}" placeholder="Ej: ¡Feliz d&iacute;a ma!">
                </div>
                <div class="col-12">
                    <label class="form-label required-label">Color de fondo</label>

                    <div class="color-selector">
                        <button type="button" class="color-option {{ old('f_color_fondo')=='#0065FA' ? 'selected' : '' }}" data-color="#0065FA" style="background-color: #0065FA"></button>
                        <button type="button" class="color-option {{ old('f_color_fondo')=='#07378C' ? 'selected' : '' }}" data-color="#07378C" style="background-color: #07378C"></button>
                        <button type="button" class="color-option {{ old('f_color_fondo')=='#3C66AD' ? 'selected' : '' }}" data-color="#3C66AD" style="background-color: #3C66AD"></button>
                        <button type="button" class="color-option {{ old('f_color_fondo')=='#49B384' ? 'selected' : '' }}" data-color="#49B384" style="background-color: #49B384"></button>
                        <button type="button" class="color-option {{ old('f_color_fondo')=='#E51281' ? 'selected' : '' }}" data-color="#E51281" style="background-color: #E51281"></button>
                        <button type="button" class="color-option {{ old('f_color_fondo')=='#FECF44' ? 'selected' : '' }}" data-color="#FECF44" style="background-color: #FECF44"></button>
                        <button type="button" class="color-option {{ old('f_color_fondo')=='#A2A2A1' ? 'selected' : '' }}" data-color="#A2A2A1" style="background-color: #A2A2A1"></button>
                        <button type="button" class="color-option {{ old('f_color_fondo')=='#FDFDFE' ? 'selected' : '' }}" data-color="#FDFDFE" style="background-color: #FDFDFE"></button>
                    </div>

                    <input type="hidden" id="selectedColor" name="f_color_fondo" value="{{ old('f_color_fondo') }}">
                    <br>
                </div>
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="f_publico" id="f_publico" value="1" {{ old('f_publico', 1) ? 'checked' : '' }}>
                        <label class="form-check-label" for="f_publico">Publico</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Descripci&oacute;n</label>
                    <textarea name="f_descripcion" class="form-control" rows="3" placeholder="Descripción opcional...">{{ old('f_descripcion') }}</textarea>
                </div>
                {{-- <div class="col-12">
                    <label class="form-label">Descripci&oacute;n interna</label>
                    <textarea name="f_descripcion_interna" class="form-control" rows="3" placeholder="Notas internas o descripción opcional...">{{ old('f_descripcion_interna') }}</textarea>
                </div> --}}
            </div>
        </div>


        {{-- ARCHIVOS --}}
        <div class="vch-card p-3 mb-3">
            <div class="col-12">
                <label class="form-label required-label">Imagen/es</label>
                <div id="logos-container">
                    <div class="row logo-item mb-2">
                        <div class="col-sm-8">
                            <input type="file" name="imagenes[]" accept="image/*" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <select name="f_tipo_archivo_id[]" id="f_tipo_archivo_id" class="form-select field-required" required>
                                <option value="">Selecciona el tipo de archivo</option>
                                @foreach($tipos_archivos as $tipo)
                                    <option value="{{ $tipo['tipo_archivo_id'] }}" {{ old('f_tipo_archivo_id') == $tipo['tipo_archivo_id'] ? 'selected' : '' }}>
                                        {{ $tipo['tipo_archivo_nombre'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1 d-flex align-items-center"></div>
                    </div>

                </div>
            </div>
            <button type="button" id="add-logo" class="btn btn-primary btn-block">Agregar otra imagen</button>
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-between form-actions">
            <a href="{{ route('admin.colecciones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
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
$(document).ready(function () {

    $('#add-logo').on('click', function () {
        let html = `
            <div class="row logo-item mb-2">
                <div class="col-sm-8">
                    <input type="file" name="imagenes[]" accept="image/*" class="form-control">
                </div>
                <div class="col-sm-3">
                    <select name="f_tipo_archivo_id[]" id="f_tipo_archivo_id" class="form-select field-required" required>
                        <option value="">Selecciona el tipo de archivo</option>
                        @foreach($tipos_archivos as $tipo)
                            <option value="{{ $tipo['tipo_archivo_id'] }}" {{ old('f_tipo_archivo_id') == $tipo['tipo_archivo_id'] ? 'selected' : '' }}>
                                {{ $tipo['tipo_archivo_nombre'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-1 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-logo">X</button>
                </div>
            </div>
        `;

        $('#logos-container').append(html);
    });

    $(document).on('click', '.remove-logo', function () {
        $(this).closest('.logo-item').remove();
    });

});
</script>
@endpush
