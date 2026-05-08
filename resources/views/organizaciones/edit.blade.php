@extends('layouts.app')

@section('title', 'Editar organizacion')

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
            <h1 class="vch-title">Editar organizacion</h1>
            <p class="vch-subtitle">Modifica los datos de la organización seleccionada.</p>
        </div>
    </section>

    <form method="POST" action="{{ route('organizacion.update', $organizacion->org_id) }}" id="form_main" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="vch-card p-3 mb-3">

            <h6 class="fw-bold">Datos de la organizacion</h6>

            <div class="row g-2">

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Tipo de documento</label>
                    <select name="tipo_doc_id" class="form-select field-required" required>
                        <option value="">Selecciona el tipo de documento</option>
                        @foreach($tiposDocumento as $id => $nombre)
                            <option value="{{ $id }}" {{ old('tipo_doc_id', $organizacion->tipo_doc_id) == $id ? 'selected' : '' }}>
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
                    <input type="text" name="f_documento" class="form-control field-required" value="{{ old('f_documento', $organizacion->org_documento) }}" required>
                    @error('f_documento')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Nombre de fantasía</label>
                    <input type="text" name="f_nombre_fantasia" class="form-control field-required" value="{{ old('f_nombre_fantasia', $organizacion->org_nombre_fantasia) }}" required>
                    @error('f_nombre_fantasia')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Nombre</label>
                    <input type="text" name="f_nombre" class="form-control field-required" value="{{ old('f_nombre', $organizacion->org_nombre) }}" required>
                    @error('f_nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Razón social</label>
                    <input type="text" name="f_razon_social" class="form-control field-required" value="{{ old('f_razon_social', $organizacion->org_razon_social) }}" required>
                    @error('f_razon_social')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Logo</label>
                    <div class="card card-custom p-3 mb-3">

                        {{-- @if($entidad->count()) --}}
                            <div class="row g-3">
                                {{-- @foreach($entidad as $logo) --}}
                                    <div class="col-12 col-md-4">
                                        <div class="border rounded p-2 h-100">
                                            <img src="{{ asset('storage/' . $organizacion->org_img_path) }}" class="img-fluid rounded mb-2" alt="{{ $organizacion->org_img_path }}">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="delete_banners[]" value="{{ $organizacion->org_id }}" id="banner-delete-{{ $organizacion->org_id }}">
                                                <label class="form-check-label" for="banner-delete-{{ $organizacion->org_id }}">
                                                    Eliminar logo
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                {{-- @endforeach --}}
                            </div>
                        {{-- @else
                            <div class="text-muted small">No hay entidad cargados.</div>
                        @endif --}}
                    </div>
                    <input type="file" name="logo" class="form-control">
                </div>

                <div class="row g-3">

                    <!-- COLUMNA IZQUIERDA (FORM) -->
                    <div class="col-12 col-lg-6">

                        <div class="row g-2">

                            <div class="col-12">
                                <label class="form-label required-label">País</label>
                                <select name="f_pais_id" id="f_pais_id" class="form-select pais field-required" required>
                                    <option value="">Selecciona el país</option>
                                    @foreach($paises as $id => $nombre)
                                        <option value="{{ $id }}" {{ old('f_pais_id', $organizacion->pais_id) == $id || $id == 5 ? 'selected' : '' }}>
                                            {{ $nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('f_pais_id')
                                    <div class="text-required">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label required-label">Provincia</label>
                                <select name="f_provincia_id" id="f_provincia_id" class="form-select provincia field-required" required>
                                    <option value="">Selecciona la provincia</option>
                                </select>
                                @error('f_provincia_id')
                                    <div class="text-required">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label required-label">Ciudad</label>
                                <input type="text" name="f_ciudad" class="form-control field-required" value="{{ old('f_ciudad', $organizacion->org_ciudad) }}" required>
                                @error('f_ciudad')
                                    <div class="text-required">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Código postal</label>
                                <input type="text" name="f_codigo_postal" class="form-control" value="{{ old('f_codigo_postal', $organizacion->org_codigo_postal) }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Barrio</label>
                                <input type="text" name="f_barrio" class="form-control" value="{{ old('f_barrio', $organizacion->org_barrio) }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label required-label">Dirección</label>
                                <input type="text" name="f_direccion" class="form-control field-required" value="{{ old('f_direccion', $organizacion->org_direccion) }}" required>
                                @error('f_direccion')
                                    <div class="text-required">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <!-- COLUMNA DERECHA (MAPA) -->
                    <div class="col-12 col-lg-6">

                        <label class="form-label">Mapa</label>

                        <div class="col-12 col-md-3" hidden>
                            <input
                                type="text"
                                name="f_latitud"
                                id="f_latitud"
                                value="{{ old('f_latitud', '-24.782127') }}"
                                hidden
                            >

                            <input
                                type="text"
                                name="f_longitud"
                                id="f_longitud"
                                value="{{ old('f_longitud', '-65.423198') }}"
                                hidden
                            >
                        </div>

                        <div id="map"
                            style="width: 100%; height: 85%; min-height: 420px; border-radius: 14px; overflow: hidden; border: 1px solid #e5e7eb;">
                        </div>

                        <small class="text-muted">
                            Puedes escribir una dirección, arrastrar el pin o hacer click en el mapa.
                        </small>

                    </div>

                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Email 1</label>
                    <input type="text" name="f_email1" class="form-control field-required" value="{{ old('f_email1', $organizacion->org_email1) }}" required>
                    @error('f_email1')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">Email 2</label>
                    <input type="text" name="f_email2" class="form-control" value="{{ old('f_email2', $organizacion->org_email2) }}">
                    @error('f_email2')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Telefono 1</label>
                    <input type="text" name="f_telefono1" class="form-control field-required" value="{{ old('f_telefono1', $organizacion->org_telefono1) }}" required>
                    @error('f_telefono1')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">Telefono 2</label>
                    <input type="text" name="f_telefono2" class="form-control" value="{{ old('f_telefono2', $organizacion->org_telefono2) }}">
                    @error('f_telefono2')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-12">
                    <label class="form-label required-label">Descripcion publica</label>
                    <input type="text" name="f_descripcion_publica" class="form-control field-required" value="{{ old('f_descripcion_publica', $organizacion->org_descripcion_publica) }}" required>
                    @error('f_descripcion_publica')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-12">
                    <label class="form-label required-label">Descripcion detallada</label>
                    <input type="text" name="f_descripcion_interna" class="form-control field-required" value="{{ old('f_descripcion_interna', $organizacion->org_descripcion_interna) }}" required>
                    @error('f_descripcion_interna')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>
        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-2">Comercios vinculados</h6>
            <p class="text-muted small mb-3">
                Seleccioná los domicilios comerciales que querés vincular a esta organización.
            </p>

            <div class="mb-3">
                <label class="form-label fw-semibold">Comercios seleccionados</label>
                <div id="selected-domicilios" class="entidades-selected-box">
                    <span class="entidades-empty-text">No hay comercios seleccionados.</span>
                </div>
                <div id="domicilios-hidden-inputs"></div>
            </div>

            <div>
                <label class="form-label fw-semibold">Comercios disponibles</label>
                <div class="entidades-available-box">
                    @foreach($domiciliosDisponibles as $domicilio)
                        <button
                            type="button"
                            class="entidad-option"
                            data-id="{{ $domicilio['id'] }}"
                            data-nombre="{{ $domicilio['nombre'] }}"
                            data-direccion="{{ $domicilio['direccion'] }}"
                            onclick="addDomicilioExistente(this)"
                        >
                            <strong>{{ $domicilio['nombre'] }}</strong><br>
                            <small>{{ $domicilio['direccion'] }}</small>
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

            <button type="button" class="btn btn-danger" data-id="{{ $organizacion->org_id }}" data-url="{{ route('organizacion.delete', $organizacion->org_id) }}" id="btn_eliminar">
                Eliminar
            </button>

            <div>
                <a href="{{ route('organizacion.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-success" id="btn_actualizar">
                    Actualizar
                </button>
            </div>

        </div>
    </form>
</div>

@push('scripts')
<script>
    const provincias = @json($provincias);
    const paisSeleccionado = "{{ old('f_pais_id', $organizacion->pais_id) }}";
    const provinciaSeleccionada = "{{ old('f_provincia_id', $organizacion->provincia_id) }}";

    let domiciliosSeleccionados = @json(old('domicilios_data', $domiciliosSeleccionados ?? []));

    function cargarProvincias(paisId, provinciaActual = null) {
        const provinciaSelect = $('#f_provincia_id');

        provinciaSelect.html('<option value="">Selecciona la provincia</option>');

        $.each(provincias, function (_, provincia) {
            if (String(provincia.pais_id) === String(paisId)) {
                provinciaSelect.append(
                    $('<option>', {
                        value: provincia.provincia_id,
                        text: provincia.provincia_nombre,
                        selected: String(provincia.provincia_id) === String(provinciaActual)
                    })
                );
            }
        });
    }

    function renderDomiciliosSeleccionados() {
        const box = document.getElementById('selected-domicilios');
        const hiddenInputs = document.getElementById('domicilios-hidden-inputs');

        box.innerHTML = '';
        hiddenInputs.innerHTML = '';

        if (domiciliosSeleccionados.length === 0) {
            box.innerHTML = '<span class="entidades-empty-text">No hay comercios seleccionados.</span>';
            updateDomiciliosDisponiblesState();
            return;
        }

        domiciliosSeleccionados.forEach(item => {
            const chip = document.createElement('div');
            chip.className = 'entidad-selected';
            chip.innerHTML = `
                <div class="entidad-selected__content">
                    <strong>${item.nombre}</strong>
                    <small>${item.direccion}</small>
                </div>
                <button type="button" class="entidad-remove-btn" onclick="removeDomicilio(${item.id})" aria-label="Quitar comercio">&times;</button>
            `;
            box.appendChild(chip);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'domicilios[]';
            input.value = item.id;
            hiddenInputs.appendChild(input);
        });

        updateDomiciliosDisponiblesState();
    }

    function addDomicilioExistente(button) {
        const id = Number(button.dataset.id);
        const nombre = button.dataset.nombre;
        const direccion = button.dataset.direccion;

        const exists = domiciliosSeleccionados.some(item => item.id === id);
        if (exists) return;

        domiciliosSeleccionados.push({ id, nombre, direccion });
        renderDomiciliosSeleccionados();
    }

    function removeDomicilio(id) {
        domiciliosSeleccionados = domiciliosSeleccionados.filter(item => item.id !== id);
        renderDomiciliosSeleccionados();
    }

    function updateDomiciliosDisponiblesState() {
        const buttons = document.querySelectorAll('.entidad-option');

        buttons.forEach(button => {
            const id = Number(button.dataset.id);
            const isSelected = domiciliosSeleccionados.some(item => item.id === id);

            button.classList.toggle('is-disabled', isSelected);
        });
    }

    $(document).ready(function () {
        if (paisSeleccionado) {
            cargarProvincias(paisSeleccionado, provinciaSeleccionada);
        }

        renderDomiciliosSeleccionados();
    });

    $(document).on('change', '#f_pais_id', function () {
        const paisId = $(this).val();
        cargarProvincias(paisId);
    });
</script>

<script>
$(document).on('click', '#btn_eliminar', function (e) {
    e.preventDefault();

    let url = $(this).data('url');

    Swal.fire({
        title: '¿Eliminar organizacion?',
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
                window.location.href = "{{ route('organizacion.index') }}";
            });

        }
    });
});
</script>
<script>

    let map;
    let marker;
    let autocomplete;
    let geocoder;

    async function initMap() {
        const initialPosition = {
            lat: parseFloat(document.getElementById('f_latitud').value) || -24.782127,
            lng: parseFloat(document.getElementById('f_longitud').value) || -65.423198
        };

        const { Map } = await google.maps.importLibrary("maps");
        const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
        await google.maps.importLibrary("places");

        geocoder = new google.maps.Geocoder();

        map = new Map(document.getElementById("map"), {
            center: initialPosition,
            zoom: 14,
            mapId: "DEMO_MAP_ID"
        });

        marker = new AdvancedMarkerElement({
            map,
            position: initialPosition,
            gmpDraggable: true,
            title: "Ubicación seleccionada"
        });

        updateLatLngInputs(initialPosition);

        const direccionInput = document.getElementById("f_direccion");

        autocomplete = new google.maps.places.Autocomplete(direccionInput, {
            fields: ["formatted_address", "geometry", "name"]
        });

        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();

            if (!place.geometry || !place.geometry.location) {
                return;
            }

            const newPosition = {
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng()
            };

            marker.position = newPosition;
            map.setCenter(newPosition);
            map.setZoom(17);

            if (place.formatted_address) {
                direccionInput.value = place.formatted_address;
            }

            updateLatLngInputs(newPosition);
        });

        marker.addListener("dragend", async () => {
            const pos = marker.position;

            const newPosition = {
                lat: pos.lat,
                lng: pos.lng
            };

            updateLatLngInputs(newPosition);
            await updateAddressFromCoordinates(newPosition);
        });

        map.addListener("click", async (e) => {
            const clickedPosition = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng()
            };

            marker.position = clickedPosition;
            updateLatLngInputs(clickedPosition);
            await updateAddressFromCoordinates(clickedPosition);
        });
    }

    function updateLatLngInputs(position) {
        document.getElementById("f_latitud").value = Number(position.lat).toFixed(6);
        document.getElementById("f_longitud").value = Number(position.lng).toFixed(6);
    }

    async function updateAddressFromCoordinates(position) {
        try {
            const response = await geocoder.geocode({
                location: position
            });

            if (response.results && response.results.length > 0) {
                document.getElementById("f_direccion").value = response.results[0].formatted_address;
            }
        } catch (error) {
            console.error("No se pudo obtener la dirección desde las coordenadas", error);
        }
    }
</script>

<script>
    (g => {
        var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__",
            m = document, b = window;
        b = b[c] || (b[c] = {});
        var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams,
            u = () => h || (h = new Promise(async (f, n) => {
                await (a = m.createElement("script"));
                e.set("key", "{{ config('services.google_maps.api_key') }}");
                e.set("v", "weekly");
                e.set("libraries", "places");
                e.set("callback", c + ".maps." + q);
                a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                d[q] = f;
                a.onerror = () => h = n(Error(p + " no se pudo cargar."));
                m.head.append(a);
            }));
        d[l] ? console.warn(p + " solo carga una vez.") :
            d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n));
    })({});

    initMap();
</script>
@endpush
@endsection