@extends('layouts.app')

@section('title', 'Nuevo tipo de entidad')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/vouchers/vouchers.css') }}">
@endpush

@section('content')

@include('partials.navbar')

<div class="container py-3">
    <section class="vch-hero">
        <div class="vch-hero__content">
            <h1 class="vch-title">Nuevo voucher</h1>

            <div class="vch-hero-wave vch-hero-wave--one"></div>
            <div class="vch-hero-wave vch-hero-wave--two"></div>

            <span class="vch-dot vch-dot--pink-left"></span>
            <span class="vch-dot vch-dot--blue-left"></span>
            <span class="vch-dot vch-dot--yellow"></span>
            <span class="vch-dot vch-dot--blue"></span>
            <span class="vch-dot vch-dot--green"></span>
            <span class="vch-dot vch-dot--pink"></span>
            <span class="vch-dot vch-dot--blue-small"></span>
        </div>
    </section>

    <form method="POST" action="{{ route('vouchers.store') }}" enctype="multipart/form-data" id="form_main">
        @csrf

        <!-- CARD -->
        <div class="card card-custom p-3 mb-3">

            <h6 class="fw-bold mb-3">Datos del voucher</h6>

            <div class="row g-4">

                <div class="col-12">
                    <label class="form-label required-label">Nombre publico:</label>
                    <input type="text" name="f_nombre" class="form-control field-required" value="{{ old('f_nombre') }}" placeholder="Nombre publico" required>

                    @error('f_nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <!-- NOMBRE -->
                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Entidad:</label>
                    <select name="f_ent_id" class="form-select field-required" required>
                        <option value="">Selecciona la Entidad</option>
                        @foreach($entidades as $entidad)
                            <option value="{{ $entidad['id'] }}">{{ $entidad['nombre'] }} - {{ $entidad['direccion'] }}</option>
                        @endforeach
                    </select>
                    @error('f_ent_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Influencer:</label>
                    <select name="f_inf_id" class="form-select field-required" required>
                        <option value="">Selecciona el Influencer</option>
                        @foreach($influencers as $id => $nombre)
                            <option value="{{ $id }}">{{ $nombre }}</option>
                        @endforeach
                    </select>
                    @error('f_inf_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Modalidad:</label>
                    <select name="f_mod_id" class="form-select field-required" required>
                        <option value="">Selecciona el Modalidad</option>
                        @foreach($modalidades as $modalidad)
                            <option value="{{ $modalidad['mod_id'] }}">{{ $modalidad['mod_codigo'] }} - {{ $modalidad['mod_nombre'] }}</option>
                        @endforeach
                    </select>
                    @error('f_mod_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Categoría:</label>
                    <select name="f_cv_id" class="form-select field-required" required>
                        <option value="">Selecciona el Categoria</option>
                        @foreach($categorias as $id => $nombre)
                            <option value="{{ $id }}">{{ $nombre }}</option>
                        @endforeach
                    </select>
                    @error('f_cv_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Monto total:</label>
                    <input type="text" name="f_monto_total" class="form-control field-required" value="{{ old('f_monto_total') }}" placeholder="1.01" required>

                    @error('f_monto_total')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Stock:</label>
                    <input type="text" name="stock" class="form-control field-required" value="{{ old('stock') }}" placeholder="0" required>

                    @error('stock')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Fecha de inicio:</label>
                    <input type="text" name="f_fecha_ini_lab" id="f_fecha_ini_lab" class="form-control field-required" value="{{ old('f_fecha_ini_lab') }}" placeholder="dd/mm/yyyy" required>
                    <input type="hidden" name="f_fecha_ini" id="f_fecha_ini" value="{{ old('f_fecha_ini') }}">

                    @error('f_fecha_ini')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Fecha de vencimiento:</label>
                    <input type="text" name="f_fecha_fin_lab" id="f_fecha_fin_lab" class="form-control field-required" value="{{ old('f_fecha_fin_lab') }}" placeholder="dd/mm/yyyy" required>
                    <input type="hidden" name="f_fecha_fin" id="f_fecha_fin" value="{{ old('f_fecha_fin') }}">

                    @error('f_fecha_fin')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Permite personalización</label>
                    <select name="f_permite_personalizacion" class="form-select field-required" required>
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                    </select>
                    @error('f_permite_personalizacion')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Descripcion:</label>
                    <textarea id="description" name="description" rows="4" class="form-control voucher-textarea" placeholder="Descripción&#10;Incluye una descripción detallada del voucher.">{{ old('description') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Terminos y condiciones:</label>
                    <textarea id="terms" name="terms" rows="4" class="form-control voucher-textarea" placeholder="Términos y condiciones&#10;Incluye aqui los terminos y condiciones para este voucher (opcional).">{{ old('terms') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Banners:</label>
                    <div id="banners-wrapper">
                        <div class="banner-item mb-2">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-10">
                                    <input type="file" name="banners[]" class="form-control field-required" required>
                                </div>
                                <div class="col-md-2">
                                    {{-- El primero no se puede eliminar --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    @error('banners')
                        <div class="text-required">{{ $message }}</div>
                    @enderror

                    @error('banners.*')
                        <div class="text-required">{{ $message }}</div>
                    @enderror

                    <div class="mt-2 text-end">
                        <button type="button" class="btn btn-primary" onclick="addBanner()">
                            Agregar banner
                        </button>
                    </div>
                </div>

                <!-- OBSERVACIONES -->
                <div class="col-12">
                    <label class="form-label">Observaciones internas</label>
                    <textarea name="observaciones" class="form-control" rows="3" placeholder="Notas internas o descripción opcional...">{{ old('observaciones') }}</textarea>

                    @error('observaciones')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card card-custom p-3 mb-3">
            <h6 class="fw-bold mb-2">Etiquetas</h6>

            <p class="text-muted small mb-3">
                Seleccioná etiquetas existentes o creá nuevas para este voucher.
            </p>

            {{-- NUEVA ETIQUETA --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Nueva etiqueta</label>
                <div class="d-flex gap-2">
                    <input
                        type="text"
                        id="nueva-etiqueta-input"
                        class="form-control"
                        placeholder="Ej: Promoción, Regalo, Gourmet"
                    >
                    <button type="button" class="btn btn-primary" onclick="agregarNuevaEtiqueta()">
                        Agregar
                    </button>
                </div>
            </div>

            {{-- SELECCIONADAS --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Etiquetas seleccionadas</label>

                <div id="selected-etiquetas" class="chips-box chips-box--selected">
                    <span class="chips-empty-text">No hay etiquetas seleccionadas.</span>
                </div>

                {{-- INPUTS HIDDEN EXISTENTES --}}
                <div id="etiquetas-hidden-inputs"></div>

                {{-- INPUTS HIDDEN NUEVAS --}}
                <div id="etiquetas-nuevas-hidden-inputs"></div>
            </div>

            {{-- DISPONIBLES --}}
            <div>
                <label class="form-label fw-semibold">Etiquetas disponibles</label>

                <div class="chips-box">
                    @foreach($etiquetasDisponibles as $etiqueta)
                        <button
                            type="button"
                            class="chip-option"
                            data-id="{{ $etiqueta->eti_id }}"
                            data-name="{{ $etiqueta->eti_nombre }}"
                            onclick="addEtiquetaExistente(this)"
                        >
                            {{ $etiqueta->eti_nombre }}
                        </button>
                    @endforeach
                </div>
            </div>

            @error('etiquetas')
                <div class="text-required mt-2">{{ $message }}</div>
            @enderror

            @error('etiquetas.*')
                <div class="text-required mt-2">{{ $message }}</div>
            @enderror

            @error('etiquetas_nuevas')
                <div class="text-required mt-2">{{ $message }}</div>
            @enderror

            @error('etiquetas_nuevas.*')
                <div class="text-required mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('vouchers.index') }}" class="btn btn-outline-secondary">
                Cancelar
            </a>

            <button type="submit" class="btn btn-success" id="btn_guardar">
                Guardar
            </button>
        </div>

    </form>

</div>
@push('scripts')
<script>
    function addBanner() {
        const wrapper = document.getElementById('banners-wrapper');

        const item = document.createElement('div');
        item.classList.add('banner-item', 'mb-2');

        item.innerHTML = `
            <div class="row g-2 align-items-center">
                <div class="col-md-10">
                    <input type="file" name="banners[]" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger w-100" onclick="removeBanner(this)">
                        Quitar
                    </button>
                </div>
            </div>
        `;

        wrapper.appendChild(item);
    }

    function removeBanner(button) {
        const item = button.closest('.banner-item');
        if (item) {
            item.remove();
        }
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
    });

</script>
<script>
    let etiquetasExistentes = @json(old('etiquetas', $etiquetasSeleccionadas ?? []));
    let etiquetasNuevas = @json(old('etiquetas_nuevas', []));

    function normalizarEtiquetasExistentes() {
        if (!Array.isArray(etiquetasExistentes)) {
            etiquetasExistentes = [];
            return;
        }

        etiquetasExistentes = etiquetasExistentes.map(item => {
            // Si viene como objeto {id, name}
            if (typeof item === 'object' && item !== null) {
                return {
                    id: Number(item.id),
                    name: item.name
                };
            }

            // Si viene solo como id desde old()
            const boton = document.querySelector(`.chip-option[data-id="${item}"]`);
            return {
                id: Number(item),
                name: boton ? boton.dataset.name : `Etiqueta ${item}`
            };
        });
    }

    function renderEtiquetas() {
        const box = document.getElementById('selected-etiquetas');
        const hiddenExistentes = document.getElementById('etiquetas-hidden-inputs');
        const hiddenNuevos = document.getElementById('etiquetas-nuevas-hidden-inputs');

        box.innerHTML = '';
        hiddenExistentes.innerHTML = '';
        hiddenNuevos.innerHTML = '';

        if (etiquetasExistentes.length === 0 && etiquetasNuevas.length === 0) {
            box.innerHTML = '<span class="chips-empty-text">No hay etiquetas seleccionadas.</span>';
        }

        // EXISTENTES
        etiquetasExistentes.forEach(item => {
            const chip = document.createElement('span');
            chip.className = 'chip-selected';
            chip.innerHTML = `
                ${item.name}
                <button type="button" class="chip-remove-btn" onclick="removeEtiquetaExistente(${item.id})">&times;</button>
            `;
            box.appendChild(chip);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'etiquetas[]';
            input.value = item.id;
            hiddenExistentes.appendChild(input);
        });

        // NUEVAS
        etiquetasNuevas.forEach((nombre, index) => {
            const chip = document.createElement('span');
            chip.className = 'chip-selected';
            chip.innerHTML = `
                ${nombre}
                <button type="button" class="chip-remove-btn" onclick="removeEtiquetaNueva(${index})">&times;</button>
            `;
            box.appendChild(chip);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'etiquetas_nuevas[]';
            input.value = nombre;
            hiddenNuevos.appendChild(input);
        });

        actualizarEtiquetasDisponibles();
    }

    function addEtiquetaExistente(button) {
        const id = Number(button.dataset.id);
        const name = button.dataset.name;

        if (etiquetasExistentes.some(e => e.id === id)) {
            return;
        }

        etiquetasExistentes.push({ id, name });
        renderEtiquetas();
    }

    function removeEtiquetaExistente(id) {
        etiquetasExistentes = etiquetasExistentes.filter(e => e.id !== id);
        renderEtiquetas();
    }

    function agregarNuevaEtiqueta() {
        const input = document.getElementById('nueva-etiqueta-input');
        const nombre = input.value.trim();

        if (!nombre) {
            return;
        }

        const yaExisteNueva = etiquetasNuevas.some(
            e => e.toLowerCase() === nombre.toLowerCase()
        );

        const yaExisteSeleccionada = etiquetasExistentes.some(
            e => e.name.toLowerCase() === nombre.toLowerCase()
        );

        const yaExisteDisponible = Array.from(document.querySelectorAll('.chip-option')).some(
            btn => btn.dataset.name.toLowerCase() === nombre.toLowerCase()
        );

        if (yaExisteNueva || yaExisteSeleccionada || yaExisteDisponible) {
            input.value = '';
            return;
        }

        etiquetasNuevas.push(nombre);
        input.value = '';
        renderEtiquetas();
    }

    function removeEtiquetaNueva(index) {
        etiquetasNuevas.splice(index, 1);
        renderEtiquetas();
    }

    function actualizarEtiquetasDisponibles() {
        const botones = document.querySelectorAll('.chip-option');

        botones.forEach(btn => {
            const id = Number(btn.dataset.id);
            const seleccionada = etiquetasExistentes.some(e => e.id === id);

            btn.classList.toggle('is-disabled', seleccionada);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        normalizarEtiquetasExistentes();
        renderEtiquetas();
    });
</script>
@endpush
@endsection
