@extends('layouts.app')

@section('title', 'Nueva organizacion')

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
                } else {
                    return false;
                }
            });
        },
        rules: {
            tipo_doc_id: {
                required: true,
            },
            f_documento: {
                required: true,
                number: true,
                minlength: 6
            },
            f_nombre_fantasia: {
                required: true,
            },
            f_nombre: {
                required: true,
            },
            f_razon_social: {
                required: true,
            },
            logo: {
                required: true,
            },
            f_pais_id: {
                required: true,
            },
            f_provincia_id: {
                required: true,
            },
            f_ciudad: {
                required: true,
            },
            f_codigo_postal: {
                required: true,
            },
            f_direccion: {
                required: true,
            },
            f_email1: {
                required: true,
                email: true,
                minlength: 5
            },
            f_email2: {
                required: true,
                email: true,
                minlength: 5
            },
            f_telefono1: {
                required: true,
                number: true,
                minlength: 8
            },
            f_telefono2: {
                required: true,
                number: true,
                minlength: 8
            },
            f_descripcion_publica: {
                required: true,
            },
            f_descripcion_interna: {
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

@push('styles')
<style>
    .color-selector {
      display: flex;
      gap: 10px;
    }

    .color-option {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      border: 3px solid #000;
      cursor: pointer;
    }

    .color-option:hover {
      transform: scale(1.1);
    }

    .color-option.selected {
        border-color: #ff0000;
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
            <h1 class="vch-title">Nueva organizacion</h1>
            <p class="vch-subtitle">Consulta y administra los tipos de entidad disponibles en la plataforma.</p>
        </div>
    </section>

    <form method="POST" action="{{ route('admin.organizacion.store') }}" id="form_main" enctype="multipart/form-data">
        @csrf

        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold">Datos de la organizacion</h6>

            <div class="row g-2">

                <div class="col-12 col-md-6">
                    <label class="form-label required-label" for="tipo_doc_id">Tipo de documento</label>
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
                    <input type="text" name="f_documento" class="form-control field-required" required value="{{ old('f_documento') }}">
                    @error('f_documento')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Nombre de fantasía</label>
                    <input type="text" name="f_nombre_fantasia" class="form-control field-required" required value="{{ old('f_nombre_fantasia') }}">
                    @error('f_nombre_fantasia')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Nombre</label>
                    <input type="text" name="f_nombre" class="form-control field-required" required value="{{ old('f_nombre') }}">
                    @error('f_nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Razón social</label>
                    <input type="text" name="f_razon_social" class="form-control field-required" required value="{{ old('f_razon_social') }}">
                    @error('f_razon_social')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                {{-- <div class="col-12">
                    <label class="form-label required-label">Logo</label>
                    <input type="file" name="logo" class="form-control" value="{{ old('logo') }}">
                </div> --}}

                <div class="row g-3">

                    <!-- COLUMNA IZQUIERDA (FORM) -->
                    <div class="col-12 col-lg-6">

                        <div class="row g-2">

                            <div class="col-12">
                                <label class="form-label required-label">País</label>
                                <select name="f_pais_id" id="f_pais_id" class="form-select field-required" required>
                                    <option value="">Selecciona el país</option>
                                    @foreach($paises as $id => $nombre)
                                        <option value="{{ $id }}" {{ $id == 5 ? 'selected' : '' }}>
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
                                <select name="f_provincia_id" id="f_provincia_id" class="form-select field-required" required>
                                    <option value="">Selecciona la provincia</option>
                                </select>
                                @error('f_provincia_id')
                                    <div class="text-required">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label required-label">Ciudad</label>
                                <input type="text" name="f_ciudad" class="form-control field-required" required value="{{ old('f_ciudad') }}">
                                @error('f_ciudad')
                                    <div class="text-required">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Código postal</label>
                                <input type="text" name="f_codigo_postal" class="form-control" value="{{ old('f_codigo_postal') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Barrio</label>
                                <input type="text" name="f_barrio" class="form-control" value="{{ old('f_barrio') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label required-label">Dirección</label>
                                <input type="text" name="f_direccion" id="f_direccion" class="form-control field-required" placeholder="Escribe una dirección" required value="{{ old('f_direccion') }}">
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
                            <input type="text" name="f_latitud" id="f_latitud" value="{{ old('f_latitud', '-24.782127') }}" hidden>

                            <input type="text" name="f_longitud" id="f_longitud" value="{{ old('f_longitud', '-65.423198') }}" hidden>
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
                    <input type="text" name="f_email1" class="form-control field-required" required value="{{ old('f_email1') }}">
                    @error('f_email1')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">Email 2</label>
                    <input type="text" name="f_email2" class="form-control" value="{{ old('f_email2') }}">
                    @error('f_email2')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Telefono 1</label>
                    <input type="text" name="f_telefono1" class="form-control field-required" required value="{{ old('f_telefono1') }}">
                    @error('f_telefono1')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">Telefono 2</label>
                    <input type="text" name="f_telefono2" class="form-control" value="{{ old('f_telefono2') }}">
                    @error('f_telefono2')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
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

                    @error('f_publico')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-12">
                    <label class="form-label required-label">Descripcion publica</label>
                    <input type="text" name="f_descripcion_publica" class="form-control field-required" required value="{{ old('f_descripcion_publica') }}">
                    @error('f_descripcion_publica')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-12">
                    <label class="form-label required-label">Descripcion detallada</label>
                    <input type="text" name="f_descripcion_interna" class="form-control field-required" required value="{{ old('f_descripcion_interna') }}">
                    @error('f_descripcion_interna')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ARCHIVOS --}}
                <div class="vch-card p-3 mb-3">
                    {{-- <h6 class="fw-bold mb-2">Imagenes</h6>  --}}

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

            </div>
        </div>

        <div class="d-flex justify-content-between form-actions">
            <a href="{{ route('admin.organizacion.index') }}" class="btn btn-outline-secondary">
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
    const provincias = @json($provincias);

    const paisId = 5;
    const provinciaSelect = $('#f_provincia_id');

    provinciaSelect.html('<option value="">Selecciona la provincia</option>');

    $.each(provincias, function (_, provincia) {
        if (String(provincia.pais_id) === String(paisId)) {
            if (provincia.provincia_id == 1834) {
                provinciaSelect.append(
                    $('<option>', {
                        selected: 'selected',
                        value: provincia.provincia_id,
                        text: provincia.provincia_nombre
                    })
                );
            } else {
                provinciaSelect.append(
                    $('<option>', {
                        value: provincia.provincia_id,
                        text: provincia.provincia_nombre
                    })
                );
            }
        }
    });

    $(document).on('change', '#f_pais_id', function () {
        const paisId = $(this).val();
        const provinciaSelect = $('#f_provincia_id');

        provinciaSelect.html('<option value="">Selecciona la provincia</option>');

        $.each(provincias, function (_, provincia) {
            if (String(provincia.pais_id) === String(paisId)) {
                if (provincia.provincia_id == 1834) {
                    provinciaSelect.append(
                        $('<option>', {
                            selected: 'selected',
                            value: provincia.provincia_id,
                            text: provincia.provincia_nombre
                        })
                    );
                } else {
                    provinciaSelect.append(
                        $('<option>', {
                            value: provincia.provincia_id,
                            text: provincia.provincia_nombre
                        })
                    );
                }
            }
        });
    });

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


<script>
    const colors = document.querySelectorAll(".color-option");
    const selectedColor = document.getElementById("selectedColor");

    colors.forEach(color => {
        color.addEventListener("click", () => {

        // Sacar selección anterior
        colors.forEach(c => c.classList.remove("selected"));

        // Marcar seleccionado
        color.classList.add("selected");

        // Guardar el color
        selectedColor.value = color.dataset.color;

        // console.log("Color seleccionado:", selectedColor.value);
        });
    });
</script>
@endpush
@endsection