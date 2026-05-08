@extends('layouts.app')

@section('title', 'Nuevo influencer')


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
            <h1 class="vch-title">Nuevo influencer</h1>
            <p class="vch-subtitle">Usuarios que colaboran en la promoción de vouchers, generando visibilidad y atracción de clientes.</p>
        </div>
    </section>

    <form method="POST" action="{{ route('influencers.store') }}">
        @csrf

        <!-- CARD -->
        <div class="vch-card p-3 mb-3">

            <h6 class="fw-bold">Datos del influencer</h6>

            <div class="row g-2">

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
                    <input type="text" name="f_documento" class="form-control field-required" required>
                    @error('f_documento')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-12">
                    <label class="form-label required-label">Nombre de fantasía</label>
                    <input type="text" name="f_nombre_fantasia" class="form-control field-required" required>
                    @error('f_nombre_fantasia')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Apellido</label>
                    <input type="text" name="f_apellido" class="form-control field-required">
                    @error('f_apellido')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Nombre</label>
                    <input type="text" name="f_nombre" class="form-control field-required">
                    @error('f_nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">País</label>
                    <select name="f_pais_id" id="f_pais_id" class="form-select pais field-required" required>
                        <option value="">Selecciona el país</option>
                        @foreach($paises as $id => $nombre)
                            <option value="{{ $id }}">{{ $nombre }}</option>
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
                    <input type="text" name="f_ciudad" class="form-control field-required" placeholder="Selecciona la ciudad" required>
                    @error('f_ciudad')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">Instagram</label>
                    <input type="text" name="f_instagram" class="form-control" placeholder="Introduce el instagram">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">Facebook</label>
                    <input type="text" name="f_facebook" class="form-control" placeholder="Introduce el facebook">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">Tiktok</label>
                    <input type="text" name="f_tiktok" class="form-control" placeholder="Introduce el tiktok">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">X</label>
                    <input type="text" name="f_x" class="form-control" placeholder="Introduce el x">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">Whatsapp</label>
                    <input type="text" name="f_whatsapp" class="form-control" placeholder="Introduce el whatsapp">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Email 1</label>
                    <input type="text" name="f_email1" class="form-control field-required" required>
                    @error('f_email1')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">Email 2</label>
                    <input type="text" name="f_email2" class="form-control">
                    @error('f_email2')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                {{-- <div class="col-12 col-md-6">
                    <label class="form-label required-label">Telefono 1</label>
                    <input type="text" name="f_telefono1" class="form-control field-required" required>
                    @error('f_telefono1')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">Telefono 2</label>
                    <input type="text" name="f_telefono2" class="form-control">
                    @error('f_telefono2')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div> --}}

                <div class="col-12 col-md-12">
                    <label class="form-label required-label">Descripcion publica</label>
                    <input type="text" name="f_descripcion_publica" class="form-control field-required" required>
                    @error('f_descripcion_publica')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-12">
                    <label class="form-label required-label">Descripcion detallada</label>
                    <input type="text" name="f_descripcion_interna" class="form-control field-required" required>
                    @error('f_descripcion_interna')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Imagen/es</label>
                    <div id="imagenes_container">
                        <div class="row imagen-item mb-2">
                            <div class="col-sm-11">
                                <input type="file" name="imagenes[]" accept="image/*" class="form-control">
                            </div>
                            <div class="col-sm-1 d-flex align-items-center"></div>
                        </div>

                    </div>
                </div>
                <button type="button" id="agregar_imagen" class="btn btn-primary btn-block">Agregar otro imagen</button>

            </div>
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-between form-actions">
            <a href="{{ route('influencers.index') }}" class="btn btn-outline-secondary">
                Cancelar
            </a>

            <button type="submit" class="btn btn-success">
                Guardar
            </button>
        </div>

    </form>

</div>

<script>
    const provincias = @json($provincias);

    $(document).on('change', '#f_pais_id', function () {
        const paisId = $(this).val();
        const provinciaSelect = $('#f_provincia_id');

        provinciaSelect.html('<option value="">Selecciona la provincia</option>');

        $.each(provincias, function (_, provincia) {
            if (String(provincia.pais_id) === String(paisId)) {
                provinciaSelect.append(
                    $('<option>', {
                        value: provincia.provincia_id,
                        text: provincia.provincia_nombre
                    })
                );
            }
        });
    });

</script>
<script>
$(document).ready(function () {

    $('#agregar_imagen').on('click', function () {

        let html = `
            <div class="row imagen-item ">
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
