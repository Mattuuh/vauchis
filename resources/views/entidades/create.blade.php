@extends('layouts.app')

@section('title', 'Nueva entidad')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/entidades/entidades.css') }}">
@endpush

@section('content')

@include('partials.navbar')

<div class="container py-3">

    <h4 class="fw-bold">Nueva entidad</h4>
    <p class="text-muted small">Completá los campos para registrar una nueva entidad</p>

    <form method="POST" action="{{ route('entidades.store') }}" enctype="multipart/form-data" id="form_main">
        @csrf

        <!-- DATOS -->
        <div class="card card-custom p-3 mb-3">

            <h6 class="fw-bold">Datos de la entidad</h6>

            <div class="row g-2">

                <div class="col-12">
                    <label class="form-label required-label">Tipo de entidad</label>
                    <select name="tipo_entidad_id" class="form-select field-required" required>
                        <option value="">Selecciona el tipo de entidad</option>
                        @foreach($tiposEntidad as $id => $nombre)
                            <option value="{{ $id }}">{{ $nombre }}</option>
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
                            <option value="{{ $id }}">{{ $nombre }}</option>
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
                            <option value="{{ $id }}">{{ $nombre }}</option>
                        @endforeach
                    </select>
                    @error('tipo_doc_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">N° de documento</label>
                    <input type="text" name="com_documento" class="form-control field-required" required>
                    @error('com_documento')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Nombre de fantasía</label>
                    <input type="text" name="com_nombre_fantasia" class="form-control field-required" required>
                    @error('com_nombre_fantasia')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Razón social</label>
                    <input type="text" name="com_razon_social" class="form-control field-required" required>
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

        <!-- SUCURSALES -->
        <div class="card card-custom p-3 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold mb-0">Domicilios</h6>
                <button type="button" class="btn btn-sm btn-primary" onclick="addSucursal()">+ Agregar domicilio</button>
            </div>

            <div id="sucursales-container">
                <div class="sucursal sucursal-card p-3 mt-2" data-index="0">
                    <div class="sucursal-header">
                        <div>
                            <strong>Domicilio 1</strong>
                            <span class="badge text-bg-success ms-2">Principal</span>
                        </div>
                        <button type="button" class="btn-delete-sucursal d-none" onclick="removeSucursal(this)">
                            Eliminar domicilio
                        </button>
                    </div>

                    <div class="row g-2">
                        <div class="col-12 col-md-4">
                            <label class="form-label required-label">Organización</label>
                            <select name="sucursales[0][org_id]" class="form-select">
                                <option value="">Selecciona una organización</option>
                                @foreach($organizaciones as $id => $nombre)
                                    <option value="{{ $id }}">{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label required-label">País</label>
                            <select name="sucursales[0][pais_id]" class="form-select pais field-required" required>
                                <option value="">Selecciona el país</option>
                                @foreach($paises as $id => $nombre)
                                    <option value="{{ $id }}" {{ $id == 5 ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                            @error('sucursales.0.pais_id')
                                <div class="text-required">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label required-label">Provincia</label>
                            <select name="sucursales[0][provincia_id]" class="form-select provincia field-required" required>
                                <option value="">Selecciona la provincia</option>
                            </select>
                            @error('sucursales.0.provincia_id')
                                <div class="text-required">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label required-label">Ciudad</label>
                            <input type="text" name="sucursales[0][cd_ciudad]" class="form-control field-required" placeholder="Selecciona la ciudad" required>
                            @error('sucursales.0.cd_ciudad')
                                <div class="text-required">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Barrio</label>
                            <input type="text" name="sucursales[0][cd_barrio]" class="form-control" placeholder="Introduce el barrio">
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label required-label">Dirección</label>
                            <input type="text" name="sucursales[0][cd_direccion]" class="form-control field-required" placeholder="Introduce la dirección" required>
                            @error('sucursales.0.cd_direccion')
                                <div class="text-required">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Código postal</label>
                            <input type="text" name="sucursales[0][cd_codigo_postal]" class="form-control" placeholder="Introduce el código postal">
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label required-label">Teléfono 1</label>
                            <input type="text" name="sucursales[0][cd_telefono1]" class="form-control field-required" placeholder="+54 11 1234-5678" required>
                            @error('sucursales.0.cd_telefono1')
                                <div class="text-required">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Teléfono 2</label>
                            <input type="text" name="sucursales[0][cd_telefono2]" class="form-control" placeholder="+54 11 9876-5432">
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">WhatsApp</label>
                            <input type="text" name="sucursales[0][cd_whatsapp]" class="form-control" placeholder="+54 11 1234-5678">
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Email 1</label>
                            <input type="email" name="sucursales[0][cd_email1]" class="form-control" placeholder="sucursal@comercio.com">
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Email 2</label>
                            <input type="email" name="sucursales[0][cd_email2]" class="form-control" placeholder="contacto@comercio.com">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Descripcion Publica</label>
                            <input type="text" name="sucursales[0][cd_descripcion_publica]" class="form-control" placeholder="Información adicional que sera publica de esta sucursal">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Descripcion Interna</label>
                            <input type="text" name="sucursales[0][cd_descripcion_interna]" class="form-control" placeholder="Información adicional detallada sobre esta sucursal">
                        </div>
                    </div>

                    <br>

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

                        @error('sucursales.0.rubros')
                            <div class="text-required mt-2">{{ $message }}</div>
                        @enderror
                        @error('sucursales.0.rubros.*')
                            <div class="text-required mt-2">{{ $message }}</div>
                        @enderror
                        @error('sucursales.0.subrubros')
                            <div class="text-required mt-2">{{ $message }}</div>
                        @enderror
                        @error('sucursales.0.subrubros.*')
                            <div class="text-required mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('entidades.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button class="btn btn-success" id="btn_guardar">Guardar</button>
        </div>

    </form>

</div>

<script>
    let sucursalIndex = 1;
    const provincias = @json($provincias);

    function getSucursalIndex(sucursal) {
        return sucursal.getAttribute('data-index');
    }

    function renderProvincias(selectPais, provinciaSelect) {
        const paisId = selectPais.value;
        provinciaSelect.innerHTML = '<option value="">Selecciona la provincia</option>';

        Object.values(provincias).forEach(provincia => {
            if (String(provincia.pais_id) === String(paisId)) {
                const option = document.createElement('option');
                option.value = provincia.provincia_id;
                option.textContent = provincia.provincia_nombre;
                provinciaSelect.appendChild(option);
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

    function sanitizeSubrubrosByRubros(sucursal) {
        const selectedRubros = getSelectedRubros(sucursal).map(item => item.id);
        let selectedSubrubros = getSelectedSubrubros(sucursal);

        selectedSubrubros = selectedSubrubros.filter(subrubro =>
            selectedRubros.includes(Number(subrubro.rub_id))
        );

        setSelectedSubrubros(sucursal, selectedSubrubros);
        renderSelectedSubrubros(sucursal);
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
        if (!sucursal.dataset.selectedRubros) {
            setSelectedRubros(sucursal, []);
        }

        if (!sucursal.dataset.selectedSubrubros) {
            setSelectedSubrubros(sucursal, []);
        }

        renderSelectedRubros(sucursal);
        renderSelectedSubrubros(sucursal);
    }

    function addSucursal() {
        const container = document.getElementById('sucursales-container');
        const firstSucursal = container.querySelector('.sucursal');
        const clone = firstSucursal.cloneNode(true);

        clone.setAttribute('data-index', sucursalIndex);
        clone.dataset.selectedRubros = '[]';
        clone.dataset.selectedSubrubros = '[]';

        clone.querySelectorAll('input, select, textarea').forEach(el => {
            const oldName = el.getAttribute('name');
            if (oldName) {
                el.setAttribute('name', oldName.replace(/\[\d+\]/, `[${sucursalIndex}]`));
            }

            if (el.tagName === 'SELECT') {
                el.selectedIndex = 0;

                if (el.classList.contains('provincia')) {
                    el.innerHTML = '<option value="">Selecciona la provincia</option>';
                }
            } else {
                el.value = '';
            }
        });

        const selectedRubrosBox = clone.querySelector('.selected-rubros');
        if (selectedRubrosBox) {
            selectedRubrosBox.innerHTML = '<span class="rubros-empty-text">No hay rubros seleccionados.</span>';
        }

        const rubrosHidden = clone.querySelector('.rubros-hidden-inputs');
        if (rubrosHidden) {
            rubrosHidden.innerHTML = '';
        }

        const selectedSubrubrosBox = clone.querySelector('.selected-subrubros');
        if (selectedSubrubrosBox) {
            selectedSubrubrosBox.innerHTML = '<span class="subrubros-empty-text">No hay subrubros seleccionados.</span>';
        }

        const subrubrosHidden = clone.querySelector('.subrubros-hidden-inputs');
        if (subrubrosHidden) {
            subrubrosHidden.innerHTML = '';
        }

        clone.querySelectorAll('.text-required').forEach(el => el.remove());

        const headerTitle = clone.querySelector('.sucursal-header strong');
        if (headerTitle) {
            headerTitle.textContent = `Domicilio ${sucursalIndex + 1}`;
        }

        const badge = clone.querySelector('.badge');
        if (badge) {
            badge.remove();
        }

        const deleteButton = clone.querySelector('.btn-delete-sucursal');
        if (deleteButton) {
            deleteButton.classList.remove('d-none');
        }

        container.appendChild(clone);
        initSucursalState(clone);
        sucursalIndex++;
    }

    function removeSucursal(button) {
        const sucursal = button.closest('.sucursal');
        if (!sucursal) return;

        sucursal.remove();
        reordenarSucursales();
    }

    function reordenarSucursales() {
        const sucursales = document.querySelectorAll('#sucursales-container .sucursal');

        sucursales.forEach((sucursal, index) => {
            sucursal.setAttribute('data-index', index);

            const title = sucursal.querySelector('.sucursal-header strong');
            if (title) {
                title.textContent = `Domicilio ${index + 1}`;
            }

            const deleteButton = sucursal.querySelector('.btn-delete-sucursal');
            if (deleteButton) {
                if (index === 0) {
                    deleteButton.classList.add('d-none');
                } else {
                    deleteButton.classList.remove('d-none');
                }
            }

            sucursal.querySelectorAll('input, select, textarea').forEach(el => {
                const oldName = el.getAttribute('name');
                if (oldName) {
                    el.setAttribute('name', oldName.replace(/\[\d+\]/, `[${index}]`));
                }
            });

            renderSelectedRubros(sucursal);
            renderSelectedSubrubros(sucursal);
        });

        sucursalIndex = sucursales.length;
    }

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('pais')) {
            const sucursal = e.target.closest('.sucursal');
            const provinciaSelect = sucursal.querySelector('.provincia');
            renderProvincias(e.target, provinciaSelect);
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.sucursal').forEach(sucursal => {
            initSucursalState(sucursal);
        });
    });
</script>
@endsection