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

    <form method="POST" action="{{ route('admin.resaltadores.update', $resaltador->resal_id) }}" enctype="multipart/form-data" id="form_main">
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
        
        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-2">Entidades vinculados</h6>
            <p class="text-muted small mb-3">Seleccioná las entidades que querés vincular a este resaltador.</p>

            <div class="mb-3">
                <label class="form-label fw-semibold">Entidades seleccionadas</label>
                <div id="selected-entidades" class="entidades-selected-box">
                    <span class="entidades-empty-text">No hay entidades seleccionadas.</span>
                </div>
                <div id="entidades-hidden-inputs"></div>
            </div>
            <div>
                <label class="form-label fw-semibold">Entidades disponibles</label>
                <div class="entidades-available-box">
                    @foreach($entidadesDisponibles as $entidad)
                        <button type="button" class="entidad-option" data-id="{{ $entidad['id'] }}" data-nombre="{{ $entidad['nombre'] }}" onclick="addEntidadExistente(this)">
                            <strong>{{ $entidad['nombre'] }}</strong>
                        </button>
                    @endforeach
                </div>
            </div>

            @error('domicilios')
                <div class="text-required mt-2">{{ $message }}</div>
            @enderror

            @error('domicilios.*')
                <div class="text-required mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-between form-actions">
            <button type="button" class="btn btn-danger" data-id="{{ $resaltador->resal_id }}" data-url="{{ route('admin.resaltadores.delete', $resaltador->resal_id) }}" id="btn_eliminar">Eliminar</button>
            <div>
                <a href="{{ route('admin.resaltadores.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success" id="btn_actualizar">Actualizar</button>
            </div>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>

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
                window.location.href = "{{ route('admin.resaltadores.index') }}";
            });

        }
    });
});
</script>
@endpush