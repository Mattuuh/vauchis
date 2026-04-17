@extends('layouts.app')

@section('title', 'Editar entidad')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/entidades/entidades.css') }}">
@endpush

@section('content')

@include('partials.navbar')

<div class="container py-3">

    <h4 class="fw-bold">Editar entidad</h4>
    <p class="text-muted small">Modificá los campos de la entidad seleccionada</p>

    <form method="POST" action="{{ route('entidades.update', $entidad->ent_id) }}" enctype="multipart/form-data" id="form_main">
        @csrf
        @method('PUT')

        <div class="card card-custom p-3 mb-3">

            <h6 class="fw-bold">Datos de la entidad</h6>

            <div class="row g-2">

                <div class="col-12">
                    <label class="form-label required-label">Tipo de entidad</label>
                    <select name="tipo_entidad_id" class="form-select field-required" required>
                        <option value="">Selecciona el tipo de entidad</option>
                        @foreach($tiposEntidad as $id => $nombre)
                            <option value="{{ $id }}" {{ old('tipo_entidad_id', $entidad->tipo_ent_id ?? '') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipo_entidad_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Condición ante IVA</label>
                    <select name="tipo_resp_id" class="form-select field-required" required>
                        <option value="">Selecciona una opcion</option>
                        @foreach($tiposResponsabilidad as $id => $nombre)
                            <option value="{{ $id }}" {{ old('tipo_resp_id', $entidad->tipo_resp_id) == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipo_resp_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Tipo de documento</label>
                    <select name="tipo_doc_id" class="form-select field-required" required>
                        <option value="">Selecciona el tipo de documento</option>
                        @foreach($tiposDocumento as $id => $nombre)
                            <option value="{{ $id }}" {{ old('tipo_doc_id', $entidad->tipo_doc_id) == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipo_doc_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">N° de documento</label>
                    <input type="text" name="com_documento" class="form-control field-required" value="{{ old('com_documento', $entidad->ent_documento) }}" required>
                    @error('com_documento')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Nombre de fantasía</label>
                    <input type="text" name="com_nombre_fantasia" class="form-control field-required" value="{{ old('com_nombre_fantasia', $entidad->ent_nombre_fantasia) }}" required>
                    @error('com_nombre_fantasia')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Razón social</label>
                    <input type="text" name="com_razon_social" class="form-control field-required" value="{{ old('com_razon_social', $entidad->ent_razon_social) }}" required>
                    @error('com_razon_social')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Logo</label>
                    <input type="file" name="logo" class="form-control">
                </div>

            </div>
        </div>

        <div class="card card-custom p-3 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold mb-0">Domicilios</h6>
                <button type="button" class="btn btn-sm btn-primary" onclick="addSucursal()">+ Agregar</button>
            </div>

            <div id="sucursales-container">
                @forelse(old('sucursales', $sucursales->toArray()) as $index => $sucursal)
                    <div class="sucursal sucursal-card p-3 mt-2" data-index="{{ $index }}">
                        <div class="sucursal-header">
                            <div>
                                <strong>Domicilio {{ $index + 1 }}</strong>
                                @if($index === 0)
                                    <span class="badge text-bg-success ms-2">Principal</span>
                                @endif
                            </div>
                            <button type="button" class="btn-delete-sucursal {{ $index === 0 ? 'd-none' : '' }}" onclick="removeSucursal(this)">
                                Eliminar
                            </button>
                        </div>

                        <div class="row g-2">
                            <div class="col-12 col-md-4">
                                <label class="form-label">Organización</label>
                                <select name="sucursales[{{ $index }}][org_id]" class="form-select">
                                    <option value="">Selecciona una organización</option>
                                    @foreach($organizaciones as $id => $nombre)
                                        <option value="{{ $id }}" {{ old("sucursales.$index.org_id", $sucursal->org_id ?? '') == $id ? 'selected' : '' }}>
                                            {{ $nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label required-label">País</label>
                                <select name="sucursales[{{ $index }}][pais_id]" class="form-select pais field-required" required>
                                    <option value="">Selecciona el país</option>
                                    @foreach($paises as $id => $nombre)
                                        <option value="{{ $id }}" {{ old("sucursales.$index.pais_id", $sucursal->pais_id ?? '') == $id ? 'selected' : '' }}>
                                            {{ $nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label required-label">Provincia</label>
                                <select name="sucursales[{{ $index }}][provincia_id]" class="form-select provincia field-required" required data-selected="{{ old("sucursales.$index.provincia_id", $sucursal->provincia_id ?? '') }}">
                                    <option value="">Selecciona la provincia</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label required-label">Ciudad</label>
                                <input type="text" name="sucursales[{{ $index }}][cd_ciudad]" class="form-control field-required" value="{{ old("sucursales.$index.cd_ciudad", $sucursal->ed_ciudad ?? '') }}" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Barrio</label>
                                <input type="text" name="sucursales[{{ $index }}][cd_barrio]" class="form-control" value="{{ old("sucursales.$index.cd_barrio", $sucursal->ed_barrio ?? '') }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label required-label">Dirección</label>
                                <input type="text" name="sucursales[{{ $index }}][cd_direccion]" class="form-control field-required" value="{{ old("sucursales.$index.cd_direccion", $sucursal->ed_direccion ?? '') }}" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Código postal</label>
                                <input type="text" name="sucursales[{{ $index }}][cd_codigo_postal]" class="form-control" value="{{ old("sucursales.$index.cd_codigo_postal", $sucursal->ed_codigo_postal ?? '') }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label required-label">Teléfono 1</label>
                                <input type="text" name="sucursales[{{ $index }}][cd_telefono1]" class="form-control field-required" value="{{ old("sucursales.$index.cd_telefono1", $sucursal->ed_telefono1 ?? '') }}" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Teléfono 2</label>
                                <input type="text" name="sucursales[{{ $index }}][cd_telefono2]" class="form-control" value="{{ old("sucursales.$index.cd_telefono2", $sucursal->ed_telefono2 ?? '') }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">WhatsApp</label>
                                <input type="text" name="sucursales[{{ $index }}][cd_whatsapp]" class="form-control" value="{{ old("sucursales.$index.cd_whatsapp", $sucursal->ed_whatsapp ?? '') }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Email 1</label>
                                <input type="email" name="sucursales[{{ $index }}][cd_email1]" class="form-control" value="{{ old("sucursales.$index.cd_email1", $sucursal->ed_email1 ?? '') }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label">Email 2</label>
                                <input type="email" name="sucursales[{{ $index }}][cd_email2]" class="form-control" value="{{ old("sucursales.$index.cd_email2", $sucursal->ed_email2 ?? '') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Descripcion Publica</label>
                                <input type="text" name="sucursales[{{ $index }}][cd_descripcion_publica]" class="form-control" value="{{ old("sucursales.$index.cd_descripcion_publica", $sucursal->ed_descripcion_publica ?? '') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Descripcion Interna</label>
                                <input type="text" name="sucursales[{{ $index }}][cd_descripcion_interna]" class="form-control" value="{{ old("sucursales.$index.cd_descripcion_interna", $sucursal->ed_descripcion_interna ?? '') }}">
                            </div>
                        </div>
                        @php
                            $domicilioId = $sucursal->ed_id ?? null;

                            $rubrosSeleccionados = old(
                                "sucursales.$index.rubros_data",
                                $domicilioId && isset($rubrosPorDomicilio[$domicilioId]) ? $rubrosPorDomicilio[$domicilioId] : []
                            );

                            $subrubrosSeleccionados = old(
                                "sucursales.$index.subrubros_data",
                                $domicilioId && isset($subrubrosPorDomicilio[$domicilioId]) ? $subrubrosPorDomicilio[$domicilioId] : []
                            );
                        @endphp

                        <div class="card card-custom p-3 mb-3 rubros-card">
                            <h6 class="fw-bold mb-2">Rubros y subrubros</h6>
                            <p class="text-muted small mb-3">
                                Seleccioná uno o más rubros para este domicilio y luego elegí los subrubros correspondientes.
                            </p>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Rubros disponibles</label>
                                <div class="rubros-available-box">
                                    @foreach($rubros as $id => $nombre)
                                        <button
                                            type="button"
                                            class="rubro-option"
                                            data-id="{{ $id }}"
                                            data-name="{{ $nombre }}"
                                            onclick="addRubroFromOption(this)"
                                        >
                                            {{ $nombre }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Rubros seleccionados</label>
                                <div class="rubros-selected-box selected-rubros">
                                    <span class="rubros-empty-text">No hay rubros seleccionados.</span>
                                </div>
                                <div class="rubros-hidden-inputs"></div>
                            </div>

                            <div>
                                <label class="form-label fw-semibold">Subrubros disponibles</label>
                                <div class="subrubros-available-box">
                                    @foreach($subrubros as $subrubro)
                                        <button
                                            type="button"
                                            class="subrubro-option"
                                            data-id="{{ $subrubro['sub_id'] }}"
                                            data-rub-id="{{ $subrubro['rub_id'] }}"
                                            data-name="{{ $subrubro['sub_nombre'] }}"
                                            onclick="addSubrubroFromOption(this)"
                                        >
                                            {{ $subrubro['sub_nombre'] }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label fw-semibold">Subrubros seleccionados</label>
                                <div class="subrubros-selected-box selected-subrubros">
                                    <span class="subrubros-empty-text">No hay subrubros seleccionados.</span>
                                </div>
                                <div class="subrubros-hidden-inputs"></div>
                            </div>

                            <input
                                type="hidden"
                                class="rubros-data"
                                value='@json(array_values($rubrosSeleccionados))'
                            >

                            <input
                                type="hidden"
                                class="subrubros-data"
                                value='@json(array_values($subrubrosSeleccionados))'
                            >
                        </div>
                    </div>
                @empty
                    <div class="sucursal sucursal-card p-3 mt-2" data-index="0">
                        <div class="sucursal-header">
                            <div>
                                <strong>Domicilio 1</strong>
                                <span class="badge text-bg-success ms-2">Principal</span>
                            </div>
                            <button type="button" class="btn-delete-sucursal d-none" onclick="removeSucursal(this)">
                                Eliminar
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-between">

            <button type="button" class="btn btn-danger" data-id="{{ $entidad->ent_id }}" data-url="{{ route('entidades.delete', $entidad->ent_id) }}" id="btn_eliminar">
                Eliminar
            </button>

            <div>
                <a href="{{ route('entidades.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-success" id="btn_guardar">
                    Actualizar
                </button>
            </div>

        </div>

    </form>
</div>

<script>
    let sucursalIndex = {{ count(old('sucursales', $sucursales->toArray())) ?: 1 }};
    const provincias = @json($provincias);
    const paises = @json($paises);
    const organizaciones = @json($organizaciones);
    const rubrosCatalogo = @json($rubros);

    function getSucursalIndex(sucursal) {
        return sucursal.getAttribute('data-index');
    }

    function getSelectedRubros(sucursal) {
        return JSON.parse(sucursal.dataset.selectedRubros || '[]');
    }

    function setSelectedRubros(sucursal, data) {
        sucursal.dataset.selectedRubros = JSON.stringify(data);
    }

    function getSelectedSubrubros(sucursal) {
        return JSON.parse(sucursal.dataset.selectedSubrubros || '[]');
    }

    function setSelectedSubrubros(sucursal, data) {
        sucursal.dataset.selectedSubrubros = JSON.stringify(data);
    }

    function renderProvincias(selectPais, selectProvincia, selectedValue = '') {
        selectProvincia.innerHTML = '<option value="">Selecciona la provincia</option>';

        Object.values(provincias).forEach(provincia => {
            if (String(provincia.pais_id) === String(selectPais.value)) {
                const option = document.createElement('option');
                option.value = provincia.provincia_id;
                option.textContent = provincia.provincia_nombre;

                if (String(provincia.provincia_id) === String(selectedValue)) {
                    option.selected = true;
                }

                selectProvincia.appendChild(option);
            }
        });
    }

    function initProvinciaSelects() {
        document.querySelectorAll('.sucursal').forEach(sucursal => {
            const pais = sucursal.querySelector('.pais');
            const provincia = sucursal.querySelector('.provincia');

            if (pais && provincia) {
                const selectedProvincia = provincia.dataset.selected || '';
                if (pais.value) {
                    renderProvincias(pais, provincia, selectedProvincia);
                }
            }
        });
    }

    function updateAvailableRubrosState(sucursal) {
        const selectedRubros = getSelectedRubros(sucursal);
        const buttons = sucursal.querySelectorAll('.rubro-option');

        buttons.forEach(button => {
            const id = Number(button.dataset.id);
            const isSelected = selectedRubros.some(rubro => rubro.id === id);
            button.classList.toggle('is-disabled', isSelected);
        });
    }

    function updateAvailableSubrubrosState(sucursal) {
        const selectedRubros = getSelectedRubros(sucursal).map(item => item.id);
        const selectedSubrubros = getSelectedSubrubros(sucursal);
        const buttons = sucursal.querySelectorAll('.subrubro-option');

        buttons.forEach(button => {
            const subId = Number(button.dataset.id);
            const rubId = Number(button.dataset.rubId);
            const isSelected = selectedSubrubros.some(sub => sub.id === subId);
            const rubroHabilitado = selectedRubros.includes(rubId);

            button.classList.toggle('is-disabled', isSelected || !rubroHabilitado);
        });
    }

    function sanitizeSubrubrosByRubros(sucursal) {
        const selectedRubros = getSelectedRubros(sucursal).map(item => item.id);
        let selectedSubrubros = getSelectedSubrubros(sucursal);

        selectedSubrubros = selectedSubrubros.filter(subrubro =>
            selectedRubros.includes(Number(subrubro.rub_id))
        );

        setSelectedSubrubros(sucursal, selectedSubrubros);
        renderSelectedSubrubros(sucursal);
    }

    function renderSelectedRubros(sucursal) {
        const index = getSucursalIndex(sucursal);
        const selectedBox = sucursal.querySelector('.selected-rubros');
        const hiddenInputs = sucursal.querySelector('.rubros-hidden-inputs');
        const selectedRubros = getSelectedRubros(sucursal);

        selectedBox.innerHTML = '';
        hiddenInputs.innerHTML = '';

        if (selectedRubros.length === 0) {
            selectedBox.innerHTML = '<span class="rubros-empty-text">No hay rubros seleccionados.</span>';
        } else {
            selectedRubros.forEach(rubro => {
                const chip = document.createElement('span');
                chip.className = 'rubro-selected';
                chip.innerHTML = `
                    <span>${rubro.name}</span>
                    <button type="button" class="rubro-remove-btn" onclick="removeRubro(this, ${rubro.id})">&times;</button>
                `;
                selectedBox.appendChild(chip);

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `sucursales[${index}][rubros][]`;
                input.value = rubro.id;
                hiddenInputs.appendChild(input);
            });
        }

        sanitizeSubrubrosByRubros(sucursal);
        updateAvailableRubrosState(sucursal);
        updateAvailableSubrubrosState(sucursal);
    }

    function renderSelectedSubrubros(sucursal) {
        const index = getSucursalIndex(sucursal);
        const selectedBox = sucursal.querySelector('.selected-subrubros');
        const hiddenInputs = sucursal.querySelector('.subrubros-hidden-inputs');
        const selectedSubrubros = getSelectedSubrubros(sucursal);

        selectedBox.innerHTML = '';
        hiddenInputs.innerHTML = '';

        if (selectedSubrubros.length === 0) {
            selectedBox.innerHTML = '<span class="subrubros-empty-text">No hay subrubros seleccionados.</span>';
        } else {
            selectedSubrubros.forEach(subrubro => {
                const chip = document.createElement('span');
                chip.className = 'subrubro-selected';
                chip.innerHTML = `
                    <span>${subrubro.name}</span>
                    <button type="button" class="subrubro-remove-btn" onclick="removeSubrubro(this, ${subrubro.id})">&times;</button>
                `;
                selectedBox.appendChild(chip);

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `sucursales[${index}][subrubros][]`;
                input.value = subrubro.id;
                hiddenInputs.appendChild(input);
            });
        }

        updateAvailableSubrubrosState(sucursal);
    }

    function addRubroFromOption(button) {
        const sucursal = button.closest('.sucursal');
        const selectedRubros = getSelectedRubros(sucursal);
        const id = Number(button.dataset.id);
        const name = button.dataset.name;

        if (selectedRubros.some(rubro => rubro.id === id)) {
            return;
        }

        selectedRubros.push({ id, name });
        setSelectedRubros(sucursal, selectedRubros);
        renderSelectedRubros(sucursal);
    }

    function removeRubro(button, rubroId) {
        const sucursal = button.closest('.sucursal');
        let selectedRubros = getSelectedRubros(sucursal);

        selectedRubros = selectedRubros.filter(rubro => rubro.id !== rubroId);
        setSelectedRubros(sucursal, selectedRubros);
        renderSelectedRubros(sucursal);
    }

    function addSubrubroFromOption(button) {
        const sucursal = button.closest('.sucursal');
        const selectedSubrubros = getSelectedSubrubros(sucursal);
        const selectedRubros = getSelectedRubros(sucursal).map(item => item.id);

        const id = Number(button.dataset.id);
        const name = button.dataset.name;
        const rubId = Number(button.dataset.rubId);

        if (!selectedRubros.includes(rubId)) {
            return;
        }

        if (selectedSubrubros.some(subrubro => subrubro.id === id)) {
            return;
        }

        selectedSubrubros.push({ id, name, rub_id: rubId });
        setSelectedSubrubros(sucursal, selectedSubrubros);
        renderSelectedSubrubros(sucursal);
    }

    function removeSubrubro(button, subrubroId) {
        const sucursal = button.closest('.sucursal');
        let selectedSubrubros = getSelectedSubrubros(sucursal);

        selectedSubrubros = selectedSubrubros.filter(subrubro => subrubro.id !== subrubroId);
        setSelectedSubrubros(sucursal, selectedSubrubros);
        renderSelectedSubrubros(sucursal);
    }

    function initSucursalState(sucursal) {
        const rubrosDataInput = sucursal.querySelector('.rubros-data');
        const subrubrosDataInput = sucursal.querySelector('.subrubros-data');

        if (rubrosDataInput && rubrosDataInput.value) {
            try {
                setSelectedRubros(sucursal, JSON.parse(rubrosDataInput.value));
            } catch {
                setSelectedRubros(sucursal, []);
            }
        } else if (!sucursal.dataset.selectedRubros) {
            setSelectedRubros(sucursal, []);
        }

        if (subrubrosDataInput && subrubrosDataInput.value) {
            try {
                setSelectedSubrubros(sucursal, JSON.parse(subrubrosDataInput.value));
            } catch {
                setSelectedSubrubros(sucursal, []);
            }
        } else if (!sucursal.dataset.selectedSubrubros) {
            setSelectedSubrubros(sucursal, []);
        }

        renderSelectedRubros(sucursal);
        renderSelectedSubrubros(sucursal);
    }

    function buildRubrosCard(index) {
        return `
            <div class="card card-custom p-3 mb-3 rubros-card">
                <h6 class="fw-bold mb-2">Rubros y subrubros</h6>
                <p class="text-muted small mb-3">
                    Seleccioná uno o más rubros para este domicilio y luego elegí los subrubros correspondientes.
                </p>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Rubros disponibles</label>
                    <div class="rubros-available-box">
                        ${Object.entries(rubrosCatalogo).map(([id, nombre]) => `
                            <button
                                type="button"
                                class="rubro-option"
                                data-id="${id}"
                                data-name="${nombre}"
                                onclick="addRubroFromOption(this)"
                            >
                                ${nombre}
                            </button>
                        `).join('')}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Rubros seleccionados</label>
                    <div class="rubros-selected-box selected-rubros">
                        <span class="rubros-empty-text">No hay rubros seleccionados.</span>
                    </div>
                    <div class="rubros-hidden-inputs"></div>
                </div>

                <div>
                    <label class="form-label fw-semibold">Subrubros disponibles</label>
                    <div class="subrubros-available-box">
                        @foreach($subrubros as $subrubro)
                            <button
                                type="button"
                                class="subrubro-option"
                                data-id="{{ $subrubro['sub_id'] }}"
                                data-rub-id="{{ $subrubro['rub_id'] }}"
                                data-name="{{ $subrubro['sub_nombre'] }}"
                                onclick="addSubrubroFromOption(this)"
                            >
                                {{ $subrubro['sub_nombre'] }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label fw-semibold">Subrubros seleccionados</label>
                    <div class="subrubros-selected-box selected-subrubros">
                        <span class="subrubros-empty-text">No hay subrubros seleccionados.</span>
                    </div>
                    <div class="subrubros-hidden-inputs"></div>
                </div>

                <input type="hidden" class="rubros-data" value="[]">
                <input type="hidden" class="subrubros-data" value="[]">
            </div>
        `;
    }

    function addSucursal() {
        const container = document.getElementById('sucursales-container');

        const html = `
            <div class="sucursal sucursal-card p-3 mt-2" data-index="${sucursalIndex}">
                <div class="sucursal-header">
                    <div>
                        <strong>Domicilio ${sucursalIndex + 1}</strong>
                    </div>
                    <button type="button" class="btn-delete-sucursal" onclick="removeSucursal(this)">
                        Eliminar
                    </button>
                </div>

                <div class="row g-2">
                    <div class="col-12 col-md-4">
                        <label class="form-label">Organización</label>
                        <select name="sucursales[${sucursalIndex}][org_id]" class="form-select">
                            <option value="">Selecciona una organización</option>
                            ${Object.entries(organizaciones).map(([id, nombre]) => `<option value="${id}">${nombre}</option>`).join('')}
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label required-label">País</label>
                        <select name="sucursales[${sucursalIndex}][pais_id]" class="form-select pais field-required" required>
                            <option value="">Selecciona el país</option>
                            ${Object.entries(paises).map(([id, nombre]) => `<option value="${id}">${nombre}</option>`).join('')}
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label class="form-label required-label">Provincia</label>
                        <select name="sucursales[${sucursalIndex}][provincia_id]" class="form-select provincia field-required" required>
                            <option value="">Selecciona la provincia</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label required-label">Ciudad</label>
                        <input type="text" name="sucursales[${sucursalIndex}][cd_ciudad]" class="form-control field-required" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Barrio</label>
                        <input type="text" name="sucursales[${sucursalIndex}][cd_barrio]" class="form-control">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label required-label">Dirección</label>
                        <input type="text" name="sucursales[${sucursalIndex}][cd_direccion]" class="form-control field-required" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Código postal</label>
                        <input type="text" name="sucursales[${sucursalIndex}][cd_codigo_postal]" class="form-control">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label required-label">Teléfono 1</label>
                        <input type="text" name="sucursales[${sucursalIndex}][cd_telefono1]" class="form-control field-required" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Teléfono 2</label>
                        <input type="text" name="sucursales[${sucursalIndex}][cd_telefono2]" class="form-control">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">WhatsApp</label>
                        <input type="text" name="sucursales[${sucursalIndex}][cd_whatsapp]" class="form-control">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Email 1</label>
                        <input type="email" name="sucursales[${sucursalIndex}][cd_email1]" class="form-control">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Email 2</label>
                        <input type="email" name="sucursales[${sucursalIndex}][cd_email2]" class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Descripcion Publica</label>
                        <input type="text" name="sucursales[${sucursalIndex}][cd_descripcion_publica]" class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Descripcion Interna</label>
                        <input type="text" name="sucursales[${sucursalIndex}][cd_descripcion_interna]" class="form-control">
                    </div>
                </div>

                <br>

                ${buildRubrosCard(sucursalIndex)}
            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);

        const nuevaSucursal = container.lastElementChild;
        initSucursalState(nuevaSucursal);
        sucursalIndex++;
    }

    function removeSucursal(button) {
        const sucursal = button.closest('.sucursal');
        if (sucursal) {
            sucursal.remove();
        }
    }

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('pais')) {
            const sucursal = e.target.closest('.sucursal');
            const provincia = sucursal.querySelector('.provincia');
            renderProvincias(e.target, provincia);
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        initProvinciaSelects();
        document.querySelectorAll('.sucursal').forEach(sucursal => {
            initSucursalState(sucursal);
        });
    });
</script>

<script>
$(document).on('click', '#btn_eliminar', function (e) {
    e.preventDefault();

    let url = $(this).data('url');

    Swal.fire({
        title: '¿Eliminar entidad?',
        text: "Esta acción lo desactivará",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            $.post(url, {
                _token: "{{ csrf_token() }}"
            }).done(function () {
                window.location.href = "{{ route('entidades.index') }}";
            });

        }
    });
});
</script>

@endsection