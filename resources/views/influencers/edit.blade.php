@extends('layouts.app')

@section('title', 'Editar influencer')

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
            <h1 class="vch-title">Editar influencer</h1>
            <p class="vch-subtitle">Modifica los datos del influencer seleccionado.</p>
        </div>
    </section>

    <form method="POST" action="{{ route('influencers.update', $influencer->inf_id) }}" enctype="multipart/form-data" id="form_main">
        @csrf
        @method('PUT')

        <div class="vch-card p-3 mb-3">

            <h6 class="fw-bold">Datos del influencer</h6>

            <div class="row g-2">

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Tipo de documento</label>
                    <select name="tipo_doc_id" class="form-select field-required" required>
                        <option value="">Selecciona el tipo de documento</option>
                        @foreach($tiposDocumento as $id => $nombre)
                            <option value="{{ $id }}" {{ old('tipo_doc_id', $influencer->tipo_doc_id) == $id ? 'selected' : '' }}>
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
                    <input type="text" name="f_documento" class="form-control field-required" value="{{ old('f_documento', $influencer->inf_documento) }}" required>
                    @error('f_documento')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-12">
                    <label class="form-label required-label">Nombre de fantasía</label>
                    <input type="text" name="f_nombre_fantasia" class="form-control field-required" value="{{ old('f_nombre_fantasia', $influencer->inf_nombre_fantasia) }}" required>
                    @error('f_nombre_fantasia')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Apellido</label>
                    <input type="text" name="f_apellido" class="form-control field-required" value="{{ old('f_apellido', $influencer->inf_apellido) }}">
                    @error('f_apellido')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Nombre</label>
                    <input type="text" name="f_nombre" class="form-control field-required" value="{{ old('f_nombre', $influencer->inf_nombre) }}">
                    @error('f_nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">País</label>
                    <select name="f_pais_id" id="f_pais_id" class="form-select pais field-required" required>
                        <option value="">Selecciona el país</option>
                        @foreach($paises as $id => $nombre)
                            <option value="{{ $id }}" {{ old('f_pais_id', $influencer->pais_id) == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('f_pais_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Provincia</label>
                    <select name="f_provincia_id" id="f_provincia_id" class="form-select provincia field-required" required>
                        <option value="">Selecciona la provincia</option>
                    </select>
                    @error('f_provincia_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Ciudad</label>
                    <input type="text" name="f_ciudad" class="form-control field-required" value="{{ old('f_ciudad', $influencer->inf_ciudad) }}" required>
                    @error('f_ciudad')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">Instagram</label>
                    <input type="text" name="f_instagram" class="form-control" value="{{ old('f_instagram', $influencer->inf_instagram) }}">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">Facebook</label>
                    <input type="text" name="f_facebook" class="form-control" value="{{ old('f_facebook', $influencer->inf_facebook) }}">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">Tiktok</label>
                    <input type="text" name="f_tiktok" class="form-control" value="{{ old('f_tiktok', $influencer->inf_tiktok) }}">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">X</label>
                    <input type="text" name="f_x" class="form-control" value="{{ old('f_x', $influencer->inf_x) }}">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">Whatsapp</label>
                    <input type="text" name="f_whatsapp" class="form-control" value="{{ old('f_whatsapp', $influencer->inf_whatsapp) }}">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Email 1</label>
                    <input type="text" name="f_email1" class="form-control field-required" value="{{ old('f_email1', $influencer->inf_email1) }}" required>
                    @error('f_email1')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">Email 2</label>
                    <input type="text" name="f_email2" class="form-control" value="{{ old('f_email2', $influencer->inf_email2) }}">
                    @error('f_email2')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-12">
                    <label class="form-label required-label">Descripcion publica</label>
                    <input type="text" name="f_descripcion_publica" class="form-control field-required" value="{{ old('f_descripcion_publica', $influencer->inf_descripcion_publica) }}" required>
                    @error('f_descripcion_publica')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-12">
                    <label class="form-label required-label">Descripcion detallada</label>
                    <input type="text" name="f_descripcion_interna" class="form-control field-required" value="{{ old('f_descripcion_interna', $influencer->inf_descripcion_interna) }}" required>
                    @error('f_descripcion_interna')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Imagen/es</label>

                    <div class="card card-custom p-3 mb-3">
                        <div class="row g-3">
                            @foreach ($influencer->imagenes as $imagen)
                                <div class="col-12 col-md-4">
                                    <div class="border rounded p-2 h-100">
                                        <img src="{{ asset('storage/' . $imagen->if_img_path) }}" class="img-fluid rounded mb-2" alt="{{ $imagen->if_img_nombre_legible }}">

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="delete_imagenes[]" value="{{ $imagen->if_id }}" id="imagen-delete-{{ $imagen->if_id }}">
                                            <label class="form-check-label" for="imagen-delete-{{ $imagen->if_id }}">Eliminar imagen</label>
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="imagen_principal" value="{{ $imagen->if_id }}" id="imagen-principal-{{ $imagen->if_id }}" {{ $imagen->if_principal == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="imagen-principal-{{ $imagen->if_id }}">Imagen principal</label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div id="imagenes_container">
                        <div class="row imagen-item mb-2">
                            <div class="col-sm-11">
                                <input type="file" name="imagenes[]" accept="image/*" class="form-control">
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                    </div>
                </div>
                <button type="button" id="agregar_imagen" class="btn btn-primary btn-block">Agregar otra imagen</button>

            </div>
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-between form-actions">

            <button type="button" class="btn btn-danger" data-id="{{ $influencer->inf_id }}" data-url="{{ route('influencers.delete', $influencer->inf_id) }}" id="btn_eliminar">
                Eliminar
            </button>

            <div>
                <a href="{{ route('influencers.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-success" id="btn_actualizar">
                    Actualizar
                </button>
            </div>

        </div>

    </form>
</div>

<script>
    const provincias = @json($provincias);
    const paisSeleccionado = "{{ old('f_pais_id', $influencer->pais_id) }}";
    const provinciaSeleccionada = "{{ old('f_provincia_id', $influencer->provincia_id) }}";

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

    $(document).ready(function () {
        if (paisSeleccionado) {
            cargarProvincias(paisSeleccionado, provinciaSeleccionada);
        }
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
        title: '¿Eliminar influencer?',
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
                window.location.href = "{{ route('influencers.index') }}";
            });

        }
    });
});
</script>

<script>
$(document).ready(function () {

    $('#agregar_imagen').on('click', function () {
        let html = `
            <div class="row imagen-item mb-2">
                <div class="col-sm-11">
                    <input type="file" name="imagenes[]" accept="image/*" class="form-control">
                </div>

                <div class="col-sm-1 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-imagen">X</button>
                </div>
            </div>
        `;

        $('#imagenes_container').append(html);
    });

    $(document).on('click', '.remove-imagen', function () {
        $(this).closest('.imagen-item').remove();
    });

});
</script>
@endsection