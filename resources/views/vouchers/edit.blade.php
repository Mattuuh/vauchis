@extends('layouts.app')

@section('title', 'Editar voucher')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/vouchers/vouchers.css') }}">
@endpush

@section('content')

@include('partials.navbar')

<div class="container py-3">
    <section class="vch-hero">
        <div class="vch-hero__content">
            <h1 class="vch-title">Editar voucher</h1>

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

    <form method="POST" action="{{ route('vouchers.update', $voucher->vou_id) }}" enctype="multipart/form-data" id="form_main">
        @csrf
        @method('PUT')

        <div class="card card-custom p-3 mb-3">
            <h6 class="fw-bold mb-3">Datos del voucher</h6>

            <div class="row g-4">

                <div class="col-12">
                    <label class="form-label required-label">Nombre público:</label>
                    <input type="text" name="f_nombre" class="form-control field-required" value="{{ old('f_nombre', $voucher->vou_nombre) }}" required>
                    @error('f_nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Entidad:</label>
                    <select name="f_ent_id" class="form-select field-required" required>
                        <option value="">Selecciona la entidad</option>
                        @foreach($entidades as $entidad)
                            <option value="{{ $entidad['id'] }}"
                                {{ old('f_ent_id', $voucher->ed_id) == $entidad['id'] ? 'selected' : '' }}>
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
                    <select name="f_inf_id" class="form-select">
                        <option value="">Selecciona el influencer</option>
                        @foreach($influencers as $id => $nombre)
                            <option value="{{ $id }}" {{ old('f_inf_id', $voucher->inf_id) == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('f_inf_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Modalidad:</label>
                    <select name="f_mod_id" id="f_mod_id" class="form-select field-required" required>
                        <option value="">Selecciona la modalidad</option>
                        @foreach($modalidades as $modalidad)
                            <option value="{{ $modalidad->mod_id }}"
                                {{ old('f_mod_id', $voucher->mod_id) == $modalidad->mod_id ? 'selected' : '' }}>
                                {{ $modalidad->mod_codigo }} - {{ $modalidad->mod_nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('f_mod_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Categoría:</label>
                    <select name="f_cv_id" class="form-select field-required" required>
                        <option value="">Selecciona la categoría</option>
                        @foreach($categorias as $id => $nombre)
                            <option value="{{ $id }}" {{ old('f_cv_id', $voucher->cv_id) == $id ? 'selected' : '' }}>
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
                    <input type="text" name="f_monto_total" class="form-control field-required" value="{{ old('f_monto_total', $voucher->vou_monto_fijo) }}" required>
                    @error('f_monto_total')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Stock:</label>
                    <input type="text" name="stock" class="form-control field-required" value="{{ old('stock', $voucher->vou_stock) }}" required>
                    @error('stock')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Fecha de inicio:</label>
                    <input type="text" name="f_fecha_ini_lab" id="f_fecha_ini_lab" class="form-control field-required" value="{{ old('f_fecha_ini_lab', \Carbon\Carbon::parse($voucher->vou_fecha_inicio)->format('d/m/Y')) }}" placeholder="dd/mm/yyyy" required>
                    <input type="hidden" name="f_fecha_ini" id="f_fecha_ini" value="{{ old('f_fecha_ini') }}">
                    @error('f_fecha_ini')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Fecha de vencimiento:</label>
                    <input type="text" name="f_fecha_fin_lab" id="f_fecha_fin_lab" class="form-control field-required" value="{{ old('f_fecha_fin_lab', \Carbon\Carbon::parse($voucher->vou_fecha_fin)->format('d/m/Y')) }}" placeholder="dd/mm/yyyy" required>
                    <input type="hidden" name="f_fecha_fin" id="f_fecha_fin" value="{{ old('f_fecha_fin') }}">
                    @error('f_fecha_fin')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Permite personalización</label>
                    <select name="f_permite_personalizacion" class="form-select field-required" required>
                        <option value="0" {{ old('f_permite_personalizacion', (string) $voucher->vou_permite_personalizacion) === '0' ? 'selected' : '' }}>NO</option>
                        <option value="1" {{ old('f_permite_personalizacion', (string) $voucher->vou_permite_personalizacion) === '1' ? 'selected' : '' }}>SI</option>
                    </select>
                    @error('f_permite_personalizacion')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Descripción:</label>
                    <textarea name="description" rows="4" class="form-control voucher-textarea">{{ old('description', $voucher->vou_descripcion) }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Términos y condiciones:</label>
                    <textarea name="terms" rows="4" class="form-control voucher-textarea">{{ old('terms', $voucher->vou_terminos_condiciones) }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Observaciones internas</label>
                    <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones', $voucher->vou_mensaje_predeterminado) }}</textarea>
                </div>
            </div>
        </div>

        <div class="card card-custom p-3 mb-3">
            <h6 class="fw-bold mb-2">Configuración de la modalidad</h6>
            <p class="text-muted small mb-3">
                Podés cambiar la modalidad y editar sus valores específicos.
            </p>

            <div id="modalidad-campos-container">
                <div id="modalidad-empty-state" class="text-muted small">
                    Seleccioná una modalidad para completar su configuración específica.
                </div>
            </div>
        </div>

        <div class="card card-custom p-3 mb-3">
            <h6 class="fw-bold mb-2">Etiquetas</h6>

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
                <div id="selected-etiquetas" class="d-flex flex-wrap gap-2">
                    @foreach(old('etiquetas', collect($etiquetasSeleccionadas)->pluck('id')->toArray()) as $etiId)
                        @php
                            $eti = collect($etiquetasDisponibles)->firstWhere('eti_id', $etiId);
                        @endphp
                        @if($eti)
                            <div class="badge bg-primary d-flex align-items-center gap-2" id="tag-selected-{{ $eti->eti_id }}">
                                <span>{{ $eti->eti_nombre }}</span>
                                <button type="button" class="btn-close btn-close-white btn-sm" aria-label="Quitar" onclick="this.parentElement.remove()"></button>
                                <input type="hidden" name="etiquetas[]" value="{{ $eti->eti_id }}">
                            </div>
                        @endif
                    @endforeach

                    @foreach(old('etiquetas_nuevas', []) as $nuevaEtiqueta)
                        <div class="badge bg-success d-flex align-items-center gap-2">
                            <span>{{ $nuevaEtiqueta }}</span>
                            <button type="button" class="btn-close btn-close-white btn-sm" aria-label="Quitar" onclick="this.parentElement.remove()"></button>
                            <input type="hidden" name="etiquetas_nuevas[]" value="{{ $nuevaEtiqueta }}">
                        </div>
                    @endforeach
                </div>
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

        <div class="card card-custom p-3 mb-3">
            <h6 class="fw-bold mb-2">Banners actuales</h6>

            @if($banners->count())
                <div class="row g-3">
                    @foreach($banners as $banner)
                        <div class="col-12 col-md-4">
                            <div class="border rounded p-2 h-100">
                                <img src="{{ asset('storage/' . $banner->vf_img_path) }}" class="img-fluid rounded mb-2" alt="{{ $banner->vf_img_nombre_legible }}">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="delete_banners[]" value="{{ $banner->vf_id }}" id="banner-delete-{{ $banner->vf_id }}">
                                    <label class="form-check-label" for="banner-delete-{{ $banner->vf_id }}">
                                        Eliminar banner
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-muted small">No hay banners cargados.</div>
            @endif
        </div>

        <div class="card card-custom p-3 mb-3">
            <h6 class="fw-bold mb-2">Agregar nuevos banners</h6>
            <div id="banners-wrapper">
                <div class="banner-item mb-2">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-10">
                            <input type="file" name="banners[]" class="form-control">
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>

            <div class="mt-2 text-end">
                <button type="button" class="btn btn-primary" onclick="addBanner()">
                    Agregar banner
                </button>
            </div>
        </div>

        <div class="card card-custom p-3 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold mb-1">Vouchers generados</h6>
                    <p class="text-muted small mb-0">
                        Detalles creados automáticamente a partir del stock del voucher.
                    </p>
                </div>
                <span class="badge bg-primary">{{ $voucherDetalles->count() }} registros</span>
            </div>

            @if($voucherDetalles->isEmpty())
                <p class="text-muted mb-0">No hay vouchers_detalles generados.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código interno</th>
                                <th>Código</th>
                                <th>Cliente</th>
                                {{-- <th>Variante</th> --}}
                                <th>Monto</th>
                                <th>Estado</th>
                                <th>Fecha alta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($voucherDetalles as $detalle)
                                <tr>
                                    <td>{{ $detalle->vd_id }}</td>
                                    <td>{{ $detalle->vd_codigo_interno }}</td>
                                    <td>{{ $detalle->vd_codigo ?? '-' }}</td>
                                    {{-- <td>{{ $detalle->cli_id ?? 'Libre' }}</td> --}}
                                    <td>
                                        @if($detalle->vd_variante_nombre)
                                            <div class="fw-semibold">{{ $detalle->vd_variante_nombre }}</div>
                                            <div class="text-muted small">{{ $detalle->vd_variante_descripcion }}</div>
                                        @else
                                            <span class="">Libre</span>
                                        @endif
                                    </td>
                                    <td>${{ number_format((float) $detalle->vd_monto_total, 2, ',', '.') }}</td>
                                    <td>
                                        <div class="small">
                                            <div>{{ $detalle->vd_estado == 1 ? 'ACTIVO' : 'BLOQUEADO' }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($detalle->vd_fecha_alta)->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('vouchers.index') }}" class="btn btn-outline-secondary">
                Cancelar
            </a>

            <button type="submit" class="btn btn-success">
                Actualizar
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
    const modalidadValoresGuardados = @json(old('modalidad_valores', $voucherModalidadValores ?? []));

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

    function renderCampoInput(campo, values = {}) {
        const value = values[campo.mca_codigo] ?? '';
        const checked = value == 1 || value === '1';

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
                ${campos.map(campo => renderCampoInput(campo, modalidadValoresGuardados)).join('')}
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