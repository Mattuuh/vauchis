@extends('layouts.app')

@section('title', 'Editar coleccion')

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

            // Swal.fire({
            //     title: '¿Estás seguro?',
            //     text: "Se va a crear el registro",
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#5cb85c',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Sí, crear',
            //     cancelButtonText: 'Cancelar'
            // }).then((result) => {
            //     if (result.isConfirmed) {

            //         // Loader opcional
            //         Swal.fire({
            //             title: 'Procesando...',
            //             allowOutsideClick: false,
            //             didOpen: () => {
            //                 Swal.showLoading();
            //             }
            //         });

                    form.submit();
            //     }
            // });
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
                required: false,
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

@push('styles')
<style>
    .entidades-selected-box,
    .entidades-available-box {
        border: 1px solid #d9e1ec;
        border-radius: 12px;
        background: #fff;
        padding: 14px;
        min-height: 56px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: flex-start;
    }

    .entidades-selected-box {
        background: #fbfcff;
    }

    .entidades-empty-text {
        color: #8a94a6;
        font-size: 0.95rem;
    }

    .entidad-option,
    .entidad-selected {
        border-radius: 14px;
        font-size: 0.92rem;
        padding: 10px 12px;
        line-height: 1.25;
        transition: all 0.2s ease;
        text-align: left;
    }

    .entidad-option {
        border: 1px solid #d7e4ff;
        background: #eef4ff;
        color: #2f6fed;
        cursor: pointer;
        min-width: 220px;
    }

    .entidad-option:hover {
        background: #e3edff;
        border-color: #bdd3ff;
    }

    .entidad-option.is-disabled {
        opacity: 0.45;
        cursor: not-allowed;
        pointer-events: none;
    }

    .entidad-selected {
        display: inline-flex;
        align-items: flex-start;
        gap: 10px;
        border: 1px solid #cfe0ff;
        background: #2f6fed;
        color: #fff;
        min-width: 220px;
        justify-content: space-between;
    }

    .entidad-selected__content {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .entidad-selected__content small {
        opacity: 0.9;
    }

    .entidad-remove-btn {
        border: none;
        background: transparent;
        color: #fff;
        font-size: 1rem;
        line-height: 1;
        padding: 0;
        cursor: pointer;
        opacity: 0.9;
    }

    .entidad-remove-btn:hover {
        opacity: 1;
    }
</style>
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
            <h1 class="vch-title">Editar coleccion</h1>
            <p class="vch-subtitle">Modifica los datos de la coleccion seleccionada.</p>
        </div>
    </section>

    <form method="POST" action="{{ route('admin.colecciones.update', $coleccion->colecc_id) }}" enctype="multipart/form-data" id="form_main">
        @csrf
        @method('PUT')

        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-3">Datos de la coleccion</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label required-label">Nombre interno</label>
                    <input type="text" name="f_nombre_interno" class="form-control field-required" value="{{ old('f_nombre_interno', $coleccion->colecc_nombre_interno) }}" placeholder="Ej: dia de la madre">
                </div>
                <div class="col-12">
                    <label class="form-label required-label">Nombre p&uacute;blico</label>
                    <input type="text" name="f_nombre" class="form-control field-required" value="{{ old('f_nombre', $coleccion->colecc_nombre) }}" placeholder="Ej: ¡Feliz d&iacute;a ma!">
                </div>
                <div class="col-12">
                    <label class="form-label required-label">Color de fondo</label>
                    <div class="color-selector">
                        <button type="button" class="color-option {{ old('f_color_fondo', $coleccion->colecc_color_fondo)=='#0065FA' ? 'selected' : '' }}" data-color="#0065FA" style="background-color: #0065FA"></button>
                        <button type="button" class="color-option {{ old('f_color_fondo', $coleccion->colecc_color_fondo)=='#07378C' ? 'selected' : '' }}" data-color="#07378C" style="background-color: #07378C"></button>
                        <button type="button" class="color-option {{ old('f_color_fondo', $coleccion->colecc_color_fondo)=='#3C66AD' ? 'selected' : '' }}" data-color="#3C66AD" style="background-color: #3C66AD"></button>
                        <button type="button" class="color-option {{ old('f_color_fondo', $coleccion->colecc_color_fondo)=='#49B384' ? 'selected' : '' }}" data-color="#49B384" style="background-color: #49B384"></button>
                        <button type="button" class="color-option {{ old('f_color_fondo', $coleccion->colecc_color_fondo)=='#E51281' ? 'selected' : '' }}" data-color="#E51281" style="background-color: #E51281"></button>
                        <button type="button" class="color-option {{ old('f_color_fondo', $coleccion->colecc_color_fondo)=='#FECF44' ? 'selected' : '' }}" data-color="#FECF44" style="background-color: #FECF44"></button>
                        <button type="button" class="color-option {{ old('f_color_fondo', $coleccion->colecc_color_fondo)=='#A2A2A1' ? 'selected' : '' }}" data-color="#A2A2A1" style="background-color: #A2A2A1"></button>
                        <button type="button" class="color-option {{ old('f_color_fondo', $coleccion->colecc_color_fondo)=='#FDFDFE' ? 'selected' : '' }}" data-color="#FDFDFE" style="background-color: #FDFDFE"></button>
                    </div>

                    <input type="hidden" id="selectedColor" name="f_color_fondo" value="{{ old('f_color_fondo', $coleccion->colecc_color_fondo) }}">
                    <br>
                </div>
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="f_publico" id="f_publico" value="1" {{ old('f_publico', $coleccion->colecc_publico) ? 'checked' : '' }}>
                        <label class="form-check-label" for="f_publico">Publico</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Descripci&oacute;n</label>
                    <textarea name="f_descripcion" class="form-control" rows="3" placeholder="Descripción opcional...">{{ old('f_descripcion', $coleccion->colecc_descripcion) }}</textarea>
                </div>
                {{-- <div class="col-12">
                    <label class="form-label">Descripci&oacute;n interna</label>
                    <textarea name="f_descripcion_interna" class="form-control" rows="3" placeholder="Notas internas o descripción opcional...">{{ old('f_descripcion_interna') }}</textarea>
                </div> --}}
            </div>
        </div>

        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-2">Imagenes</h6>
            <div class="row g-3">
                @foreach ($coleccion->imagenes as $imagen)
                    <div class="col-12 col-md-4">
                        <div class="border rounded p-2 h-100">
                            <img src="{{ asset('storage/'. $imagen->cf_img_path) }}" class="img-fluid rounded mb-2" alt="{{ $imagen->cf_nombre }}" style="height:160px;border-radius:6px;">

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="delete_imagenes[]" value="{{ $imagen->cf_id }}" id="imagen-delete-{{ $imagen->cf_id }}">
                                <label class="form-check-label" for="imagen-delete-{{ $imagen->cf_id }}">Eliminar imagen</label>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="radio" name="imagen_principal_{{ $imagen->tipo_archivo_id }}" value="{{ $imagen->cf_id }}" id="imagen-principal-{{ $imagen->cf_id }}" {{ $imagen->cf_principal == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="imagen-principal-{{ $imagen->cf_id }}">Imagen principal</label>
                            </div>

                            <div class="form-check">
                                <select name="f_tipo_archivo_id_[]" id="f_tipo_archivo_id_" class="form-select field-required" required>
                                <option value="">Selecciona el tipo de archivo</option>
                                @foreach($tipos_archivos as $tipo)
                                    <option value="{{ $tipo['tipo_archivo_id'] }}" {{ $tipo['tipo_archivo_id']==$imagen->tipo_archivo_id ? 'selected' : '' }}>{{ $tipo['tipo_archivo_nombre'] }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-12">
                <label class="form-label required-label">Imagen/es</label>
                <div id="logos-container">
                    <div class="row logo-item mb-2">
                        <div class="col-sm-8">
                            <input type="file" name="imagenes[]" accept="image/*" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <select name="f_tipo_archivo_id[]" id="f_tipo_archivo_id" class="form-select field-required">
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
        
        {{-- <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-2">Vouchers vinculados</h6>
            <p class="text-muted small mb-3">Seleccioná los vouchers que querés vincular a este resaltador.</p>

            <div class="mb-3">
                <label class="form-label fw-semibold">Vouchers seleccionadas</label>
                <div id="selected-entidades" class="entidades-selected-box">
                    <span class="entidades-empty-text">No hay vouchers seleccionadas.</span>
                </div>
                <div id="entidades-hidden-inputs"></div>
            </div>
            <div>
                <label class="form-label fw-semibold">Vouchers disponibles</label>
                <div class="entidades-available-box">
                    @foreach($entidadesDisponibles as $entidad)
                        <button type="button" class="entidad-option" data-id="{{ $entidad['id'] }}" data-nombre="{{ $entidad['nombre'] }}" onclick="addEntidadExistente(this)">
                            <strong>{{ $entidad['nombre'] }}</strong>
                        </button>
                    @endforeach
                </div>
            </div>
        </div> --}}

        <!-- BOTONES -->
        <div class="d-flex justify-content-between form-actions">
            <button type="button" class="btn btn-danger" data-id="{{ $coleccion->colecc_id }}" data-url="{{ route('admin.colecciones.delete', $coleccion->colecc_id) }}" id="btn_eliminar">Eliminar</button>
            <div>
                <a href="{{ route('admin.colecciones.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success" id="btn_actualizar">Actualizar</button>
            </div>
        </div>

    </form>
</div>
@endsection

@push('scripts')
{{-- <script>

    let entidadesSeleccionados = @json(old('entidades_data', $entidadesSeleccionados ?? []));

    function renderEntidadesSeleccionados() {
        const box = document.getElementById('selected-entidades');
        const hiddenInputs = document.getElementById('entidades-hidden-inputs');

        box.innerHTML = '';
        hiddenInputs.innerHTML = '';

        if (entidadesSeleccionados.length === 0) {
            box.innerHTML = '<span class="entidades-empty-text">No hay entidades seleccionadas.</span>';
            updateEntidadesDisponiblesState();
            return;
        }

        entidadesSeleccionados.forEach(item => {
            const chip = document.createElement('div');
            chip.className = 'entidad-selected';
            chip.innerHTML = `
                <div class="entidad-selected__content">
                    <strong>${item.nombre}</strong>
                </div>
                <button type="button" class="entidad-remove-btn" onclick="removeEntidad(${item.id})" aria-label="Quitar comercio">&times;</button>
            `;
            box.appendChild(chip);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'entidades[]';
            input.value = item.id;
            hiddenInputs.appendChild(input);
        });

        updateEntidadesDisponiblesState();
    }

    function addEntidadExistente(button) {
        const id = Number(button.dataset.id);
        const nombre = button.dataset.nombre;

        const exists = entidadesSeleccionados.some(item => item.id === id);
        if (exists) return;

        entidadesSeleccionados.push({ id, nombre });
        renderEntidadesSeleccionados();
    }

    function removeEntidad(id) {
        entidadesSeleccionados = entidadesSeleccionados.filter(item => item.id !== id);
        renderEntidadesSeleccionados();
    }

    function updateEntidadesDisponiblesState() {
        const buttons = document.querySelectorAll('.entidad-option');

        buttons.forEach(button => {
            const id = Number(button.dataset.id);
            const isSelected = entidadesSeleccionados.some(item => item.id === id);

            button.classList.toggle('is-disabled', isSelected);
        });
    }

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

    renderEntidadesSeleccionados();
});
</script> --}}
<script>
$(document).on('click', '#btn_eliminar', function (e) {
    e.preventDefault();

    let url = $(this).data('url');

    Swal.fire({
        title: '¿Eliminar coleccion?',
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
                window.location.href = "{{ route('admin.colecciones.index') }}";
            });

        }
    });
});
</script>
@endpush