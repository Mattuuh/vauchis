@extends('layouts.app')

@section('title', 'Nuevo voucher')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/vouchers/vouchers.css') }}">
@endpush

@section('content')

@include('partials.navbar')

<div class="container">

    <div class="vch-hero-wave vch-hero-wave--one"></div>
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
            <h1 class="vch-title">Nuevo voucher</h1>
            <p class="commerce-subtitle">Son productos digitales que el usuario compra para canjear en una entidad bajo condiciones acordadas.</p>
        </div>
    </section>

    <form method="POST" action="{{ route('vouchers.store') }}" enctype="multipart/form-data" id="form_main">
        @csrf

        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-3">Datos del voucher</h6>

            <div class="row g-4">

                <div class="col-12">
                    <label class="form-label required-label">Nombre público:</label>
                    <input type="text" name="f_nombre" class="form-control field-required" value="{{ old('f_nombre') }}" placeholder="Nombre público" required>

                    @error('f_nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Entidad:</label>
                    <select name="f_ent_id" class="form-select field-required" required>
                        <option value="">Selecciona la entidad</option>
                        @foreach($entidades as $entidad)
                            <option value="{{ $entidad['id'] }}" {{ old('f_ent_id') == $entidad['id'] ? 'selected' : '' }}>
                                {{ $entidad['nombre'] }} - {{ $entidad['direccion'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('f_ent_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Influencer:</label>
                    <select name="f_inf_id" class="form-select field-required">
                        <option value="">Selecciona el influencer</option>
                        @foreach($influencers as $id => $nombre)
                            <option value="{{ $id }}" {{ old('f_inf_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('f_inf_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Categoría:</label>
                    <select name="f_cv_id" class="form-select field-required" required>
                        <option value="">Selecciona la categoría</option>
                        @foreach($categorias as $id => $nombre)
                            <option value="{{ $id }}" {{ old('f_cv_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
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

                <div class="row">
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
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Permite personalización</label>
                    <select name="f_permite_personalizacion" class="form-select field-required" required>
                        <option value="0" {{ old('f_permite_personalizacion') === '0' ? 'selected' : '' }}>NO</option>
                        <option value="1" {{ old('f_permite_personalizacion') === '1' ? 'selected' : '' }}>SI</option>
                    </select>
                    @error('f_permite_personalizacion')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Descripción:</label>
                    <textarea id="description" name="description" rows="4" class="form-control voucher-textarea" placeholder="Descripción&#10;Incluye una descripción detallada del voucher.">{{ old('description') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Términos y condiciones:</label>
                    <textarea id="terms" name="terms" rows="4" class="form-control voucher-textarea" placeholder="Términos y condiciones&#10;Incluye aquí los términos y condiciones para este voucher (opcional).">{{ old('terms') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Plantillas:</label>
                    {{-- <div id="banners-wrapper">
                        <div class="banner-item mb-2">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-10">
                                    <input type="file" name="banners[]" class="form-control field-required" required>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>
                    </div> --}}

                    @error('banners')
                        <div class="text-required">{{ $message }}</div>
                    @enderror

                    @error('banners.*')
                        <div class="text-required">{{ $message }}</div>
                    @enderror

                    {{-- <div class="mt-2 text-end">
                        <button type="button" class="btn btn-primary" onclick="addBanner()">
                            Agregar banner
                        </button>
                    </div> --}}
                    <div class="card card-custom p-3 mb-3">
                        <div class="row g-3">
                            @foreach ($plantillas as $plantilla)
                                <div class="col-12 col-md-4">
                                    <div class="border rounded p-2 h-100">
                                        <img src="{{ asset($plantilla->vpl_fondo_path) }}" class="img-fluid rounded mb-2" alt="{{ $plantilla->vpl_nombre }}" style="height:160px;border-radius:6px;">

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="plantillas[]" value="{{ $plantilla->vpl_id }}" id="plantilla-{{ $plantilla->vpl_id }}">

                                            <label class="form-check-label" for="plantilla-{{ $plantilla->vpl_id }}">Seleccionar plantilla</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Observaciones internas</label>
                    <textarea name="observaciones" class="form-control" rows="3" placeholder="Notas internas o descripción opcional...">{{ old('observaciones') }}</textarea>

                    @error('observaciones')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- CAMPOS DINÁMICOS DE MODALIDAD --}}
        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-2">Configuración de la modalidad</h6>

            <div class="col-12 col-md-6">
                <label class="form-label required-label">Modalidad:</label>
                <select name="f_mod_id" id="f_mod_id" class="form-select field-required" required>
                    <option value="">Selecciona la modalidad</option>
                    @foreach($modalidades as $modalidad)
                        <option value="{{ $modalidad->mod_id }}" {{ old('f_mod_id') == $modalidad->mod_id ? 'selected' : '' }}>
                            {{ $modalidad->mod_codigo }} - {{ $modalidad->mod_nombre }}
                        </option>
                    @endforeach
                </select>
                @error('f_mod_id')
                    <div class="text-required">{{ $message }}</div>
                @enderror
            </div>

            <p class="text-muted small mb-3">
                Al seleccionar una modalidad, se mostrarán aquí los campos específicos que debe completar este voucher.
            </p>

            <div id="modalidad-campos-container">
                <div id="modalidad-empty-state" class="text-muted small">
                    Seleccioná una modalidad para completar su configuración específica.
                </div>
            </div>
        </div>

        {{-- ETIQUETAS --}}
        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-2">Etiquetas</h6>

            <p class="text-muted small mb-3">
                Seleccioná etiquetas existentes o creá nuevas para este voucher.
            </p>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nueva etiqueta</label>
                <div class="d-flex gap-2">
                    <input type="text" id="nueva-etiqueta-input" class="form-control" placeholder="Ej: Promoción, Regalo, Gourmet">
                    <button type="button" class="btn btn-primary" onclick="agregarNuevaEtiqueta()">
                        Agregar
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Etiquetas seleccionadas</label>
                <div id="selected-etiquetas" class="d-flex flex-wrap gap-2"></div>
            </div>

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
        </div>

        <div class="d-flex justify-content-between form-actions">
            <a href="{{ route('vouchers.index') }}" class="btn btn-outline-secondary">
                Cancelar
            </a>

            <button type="submit" class="btn btn-success" id="btn_guardar">
                Guardar
            </button>
        </div>
    </form>
</div>

<script id="modalidades-campos-json" type="application/json">
{!! $modalidadesCamposJson !!}
</script>
@endsection

@push('scripts')
<script>
    const modalidadesCampos = JSON.parse(document.getElementById('modalidades-campos-json').textContent || '{}');

    function addBanner() {
        const wrapper = document.getElementById('banners-wrapper');
        const div = document.createElement('div');
        div.className = 'banner-item mb-2';
        div.innerHTML = `
            <div class="row g-2 align-items-center">
                <div class="col-md-10">
                    <input type="file" name="banners[]" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.banner-item').remove()">Quitar</button>
                </div>
            </div>
        `;
        wrapper.appendChild(div);
    }

    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        return String(text)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function renderCampoInput(campo, oldValues = {}) {
        const value = oldValues[campo.mca_codigo] ?? '';
        const checked = oldValues[campo.mca_codigo] == 1 || oldValues[campo.mca_codigo] === '1';

        let html = '';

        if (campo.mca_tipo === 'textarea') {
            html = `
                <textarea
                    name="modalidad_valores[${campo.mca_codigo}]"
                    class="form-control"
                    rows="3"
                    placeholder="${escapeHtml(campo.mca_placeholder || '')}"
                    ${campo.mca_requerido ? 'required' : ''}
                >${escapeHtml(value)}</textarea>
            `;
        } else if (campo.mca_tipo === 'select') {
            const opciones = (campo.mca_opciones || '')
                .split(',')
                .map(item => item.trim())
                .filter(item => item !== '');

            html = `
                <select
                    name="modalidad_valores[${campo.mca_codigo}]"
                    class="form-select"
                    ${campo.mca_requerido ? 'required' : ''}
                >
                    <option value="">Seleccionar...</option>
                    ${opciones.map(opcion => `
                        <option value="${escapeHtml(opcion)}" ${value == opcion ? 'selected' : ''}>
                            ${escapeHtml(opcion)}
                        </option>
                    `).join('')}
                </select>
            `;
        } else if (campo.mca_tipo === 'boolean') {
            html = `
                <div class="form-check form-switch mt-2">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="modalidad_valores[${campo.mca_codigo}]"
                        value="1"
                        ${checked ? 'checked' : ''}
                    >
                    <label class="form-check-label">Sí</label>
                </div>
            `;
        } else {
            let inputType = 'text';

            if (campo.mca_tipo === 'number') inputType = 'number';
            if (campo.mca_tipo === 'decimal' || campo.mca_tipo === 'money') inputType = 'number';

            const step = (campo.mca_tipo === 'decimal' || campo.mca_tipo === 'money') ? 'step="0.01"' : '';

            html = `
                <input
                    type="${inputType}"
                    name="modalidad_valores[${campo.mca_codigo}]"
                    class="form-control"
                    value="${escapeHtml(value)}"
                    placeholder="${escapeHtml(campo.mca_placeholder || '')}"
                    ${step}
                    ${campo.mca_requerido ? 'required' : ''}
                >
            `;
        }

        return `
            <div class="col-12 col-md-6">
                <label class="form-label ${campo.mca_requerido ? 'required-label' : ''}">
                    ${escapeHtml(campo.mca_label || campo.mca_nombre)}
                </label>
                ${html}
                ${campo.mca_ayuda ? `<div class="form-text">${escapeHtml(campo.mca_ayuda)}</div>` : ''}
            </div>
        `;
    }

    function renderModalidadCampos(modalidadId) {
        const container = document.getElementById('modalidad-campos-container');
        const oldValues = @json(old('modalidad_valores', []));

        if (!modalidadId || !modalidadesCampos[modalidadId] || !modalidadesCampos[modalidadId].length) {
            container.innerHTML = `
                <div id="modalidad-empty-state" class="text-muted small">
                    Esta modalidad no tiene campos configurados.
                </div>
            `;
            return;
        }

        const campos = modalidadesCampos[modalidadId];

        container.innerHTML = `
            <div class="row g-3">
                ${campos.map(campo => renderCampoInput(campo, oldValues)).join('')}
            </div>
        `;
    }

    function addEtiquetaExistente(button) {
        const id = button.dataset.id;
        const name = button.dataset.name;
        const container = document.getElementById('selected-etiquetas');

        if (document.getElementById('tag-selected-' + id)) {
            return;
        }

        const badge = document.createElement('div');
        badge.className = 'badge bg-primary d-flex align-items-center gap-2';
        badge.id = 'tag-selected-' + id;
        badge.innerHTML = `
            <span>${name}</span>
            <button type="button" class="btn-close btn-close-white btn-sm" aria-label="Quitar"></button>
            <input type="hidden" name="etiquetas[]" value="${id}">
        `;

        badge.querySelector('button').addEventListener('click', function () {
            badge.remove();
        });

        container.appendChild(badge);
    }

    function agregarNuevaEtiqueta() {
        const input = document.getElementById('nueva-etiqueta-input');
        const nombre = input.value.trim();
        const container = document.getElementById('selected-etiquetas');

        if (!nombre) return;

        const uniqueId = 'new-' + Date.now();

        const badge = document.createElement('div');
        badge.className = 'badge bg-success d-flex align-items-center gap-2';
        badge.id = 'tag-selected-' + uniqueId;
        badge.innerHTML = `
            <span>${nombre}</span>
            <button type="button" class="btn-close btn-close-white btn-sm" aria-label="Quitar"></button>
            <input type="hidden" name="etiquetas_nuevas[]" value="${nombre}">
        `;

        badge.querySelector('button').addEventListener('click', function () {
            badge.remove();
        });

        container.appendChild(badge);
        input.value = '';
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modalidadSelect = document.getElementById('f_mod_id');

        modalidadSelect.addEventListener('change', function () {
            renderModalidadCampos(this.value);
        });

        if (modalidadSelect.value) {
            renderModalidadCampos(modalidadSelect.value);
        }
    });
</script>

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
@endpush