@extends('layouts.app')

@section('title', 'Nueva entidad')

@push('styles')
<style>
    body {
        background: #f5f7fb;
    }

    .card-custom {
        border-radius: 12px;
    }

    .btn-primary {
        background-color: #2f6fed;
        border: none;
    }

    .btn-success {
        background-color: #38b593;
        border: none;
    }

    .logo {
        height: 40px;
    }

    .required-label::after {
        content: ' *';
        color: #dc3545;
        font-weight: 700;
    }

    .sucursal-card {
        border: 1px solid #d9e1ec;
        border-radius: 12px;
        background: #fff;
    }

    .sucursal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .btn-delete-sucursal {
        border: none;
        background: transparent;
        color: #dc3545;
        font-weight: 600;
        padding: 0;
    }

    .btn-delete-sucursal:hover {
        color: #b02a37;
    }

    .field-required {
        border-left: 3px solid #dc3545;
    }

    .text-required {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 4px;
    }

    .tags-selected-box,
    .tags-available-box {
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

    .tags-selected-box {
        background: #fbfcff;
    }

    .tags-empty-text {
        color: #8a94a6;
        font-size: 0.95rem;
    }

    .tag-option,
    .tag-selected {
        border-radius: 999px;
        font-size: 0.92rem;
        font-weight: 600;
        padding: 8px 12px;
        line-height: 1;
        transition: all 0.2s ease;
    }

    .tag-option {
        border: 1px solid #d7e4ff;
        background: #eef4ff;
        color: #2f6fed;
        cursor: pointer;
    }

    .tag-option:hover {
        background: #e3edff;
        border-color: #bdd3ff;
    }

    .tag-option.is-disabled {
        opacity: 0.45;
        cursor: not-allowed;
        pointer-events: none;
    }

    .tag-selected {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #cfe0ff;
        background: #2f6fed;
        color: #fff;
    }

    .tag-remove-btn {
        border: none;
        background: transparent;
        color: #fff;
        font-size: 1rem;
        line-height: 1;
        padding: 0;
        cursor: pointer;
        opacity: 0.9;
    }

    .tag-remove-btn:hover {
        opacity: 1;
    }
</style>
@endpush

@section('content')

@include('partials.navbar')

<div class="container py-3">

    <h4 class="fw-bold">Nueva entidad</h4>
    <p class="text-muted small">Completá los campos para registrar una nueva entidad</p>

    <form method="POST" action="{{ route('comercios.store') }}" enctype="multipart/form-data">
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
                    <label class="form-label required-label">Tipo de responsabilidad</label>
                    <select name="tipo_resp_id" class="form-select field-required" required>
                        <option value="">Selecciona el tipo de responsabilidad</option>
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
                    <input type="file" name="logo" class="form-control">
                </div>

            </div>
        </div>

        <!-- SUCURSALES -->
        <div class="card card-custom p-3 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold mb-0">Domicilios</h6>
                <button type="button" class="btn btn-sm btn-primary" onclick="addSucursal()">+ Agregar</button>
            </div>

            <div id="sucursales-container">
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

                    <div class="row g-2">
                        <div class="col-12 col-md-4">
                            <label class="form-label required-label">Organización</label>
                            <select name="sucursales[0][org_id]" class="form-select">
                                <option value="">Selecciona una organización</option>
                                <option value="1">Organización 1</option>
                                <option value="2">Organización 2</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label required-label">País</label>
                            <select name="sucursales[0][pais_id]" class="form-select pais field-required" required>
                                <option value="">Selecciona el país</option>
                                @foreach($paises as $id => $nombre)
                                    <option value="{{ $id }}">{{ $nombre }}</option>
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

                    <div class="card card-custom p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold mb-0">Rubros</h6>
                            <button type="button" class="btn btn-sm btn-primary" onclick="addSucursal()">+ Agregar</button>
                        </div>

                        <p class="text-muted small mb-3">
                            Seleccioná una o más rubros para asociarlas a este domicilio.
                        </p>
                        <select name="sucursales[0][pais_id]" class="form-select pais field-required mb-3" required>
                            <option value="">Selecciona el Rubro    </option>
                            @foreach($paises as $id => $nombre)
                                <option value="{{ $id }}">{{ $nombre }}</option>
                            @endforeach
                        </select>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">SubRubros seleccionados</label>
                            <div id="selected-tags" class="tags-selected-box">
                                <span class="tags-empty-text">No hay Subrubros seleccionados.</span>
                            </div>
                        </div>

                        <div>
                            <label class="form-label fw-semibold">SubRubros disponibles</label>
                            <div class="tags-available-box">
                                @foreach($etiquetas as $etiqueta)
                                    <button
                                        type="button"
                                        class="tag-option"
                                        data-id="{{ $etiqueta['id'] }}"
                                        data-name="{{ $etiqueta['nombre'] }}"
                                        onclick="addTagFromOption(this)"
                                    >
                                        {{ $etiqueta['nombre'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div id="tags-hidden-inputs"></div>

                        @error('etiquetas')
                            <div class="text-required mt-2">{{ $message }}</div>
                        @enderror
                        @error('etiquetas.*')
                            <div class="text-required mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="card card-custom p-3 mb-3">
                        <h6 class="fw-bold mb-2">Etiquetas</h6>
                        <p class="text-muted small mb-3">
                            Seleccioná una o más etiquetas para asociarlas a este domicilio.
                        </p>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Etiquetas seleccionadas</label>
                            <div id="selected-tags" class="tags-selected-box">
                                <span class="tags-empty-text">No hay etiquetas seleccionadas.</span>
                            </div>
                        </div>

                        <div>
                            <label class="form-label fw-semibold">Etiquetas disponibles</label>
                            <div class="tags-available-box">
                                @foreach($etiquetas as $etiqueta)
                                    <button
                                        type="button"
                                        class="tag-option"
                                        data-id="{{ $etiqueta['id'] }}"
                                        data-name="{{ $etiqueta['nombre'] }}"
                                        onclick="addTagFromOption(this)"
                                    >
                                        {{ $etiqueta['nombre'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div id="tags-hidden-inputs"></div>

                        @error('etiquetas')
                            <div class="text-required mt-2">{{ $message }}</div>
                        @enderror
                        @error('etiquetas.*')
                            <div class="text-required mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <button class="btn btn-outline-secondary">Cancelar</button>
            <button class="btn btn-success">Guardar</button>
        </div>

    </form>

</div>

@php
    $selectedTagsOld = collect(old('etiquetas', []))
        ->map(function ($id) use ($etiquetas) {
            $item = collect($etiquetas)->firstWhere('id', (int) $id);

            return $item
                ? ['id' => $item['id'], 'name' => $item['nombre']]
                : null;
        })
        ->filter()
        ->values()
        ->toArray();
@endphp
<script>
    let sucursalIndex = 1;

    const provincias = @json($provincias);

    function addSucursal() {
        const container = document.getElementById('sucursales-container');
        const firstSucursal = container.querySelector('.sucursal');
        const clone = firstSucursal.cloneNode(true);

        clone.setAttribute('data-index', sucursalIndex);

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
                title.textContent = `Sucursal ${index + 1}`;
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
        });

        sucursalIndex = sucursales.length;
    }

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('pais')) {
            const paisId = e.target.value;
            const sucursal = e.target.closest('.sucursal');
            const provinciaSelect = sucursal.querySelector('.provincia');

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
    });

    
    let selectedTags = [];

    function renderSelectedTags() {
        const selectedBox = document.getElementById('selected-tags');
        const hiddenInputs = document.getElementById('tags-hidden-inputs');

        selectedBox.innerHTML = '';
        hiddenInputs.innerHTML = '';

        if (selectedTags.length === 0) {
            selectedBox.innerHTML = '<span class="tags-empty-text">No hay etiquetas seleccionadas.</span>';
            return;
        }

        selectedTags.forEach(tag => {
            const chip = document.createElement('span');
            chip.className = 'tag-selected';
            chip.innerHTML = `
                <span>${tag.name}</span>
                <button type="button" class="tag-remove-btn" onclick="removeTag(${tag.id})" aria-label="Quitar etiqueta">&times;</button>
            `;
            selectedBox.appendChild(chip);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'etiquetas[]';
            input.value = tag.id;
            hiddenInputs.appendChild(input);
        });

        updateAvailableTagsState();
    }

    function addTagFromOption(button) {
        const id = Number(button.dataset.id);
        const name = button.dataset.name;

        const exists = selectedTags.some(tag => tag.id === id);
        if (exists) return;

        selectedTags.push({ id, name });
        renderSelectedTags();
    }

    function removeTag(id) {
        selectedTags = selectedTags.filter(tag => tag.id !== id);
        renderSelectedTags();
    }

    function updateAvailableTagsState() {
        const buttons = document.querySelectorAll('.tag-option');

        buttons.forEach(button => {
            const id = Number(button.dataset.id);
            const isSelected = selectedTags.some(tag => tag.id === id);

            button.classList.toggle('is-disabled', isSelected);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        selectedTags = @json($selectedTagsOld);
        renderSelectedTags();
    });
</script>

@endsection