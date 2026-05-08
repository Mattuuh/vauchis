@extends('layouts.app')

@section('title', 'Nueva plantilla')

@push('styles')
<style>
    .imagen-selector {
        border: 1px solid #ddd;
        transition: all .2s ease;
    }

    .imagen-selector.seleccionada {
        border: 2px solid #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, .15);
    }

    .imagen-selector.seleccionada .form-check-input {
        background-color: #0d6efd;
        border-color: #0d6efd;
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
            <h1 class="vch-title">Nueva plantilla para vouchers</h1>
            <p class="vch-subtitle">Estructuras visuales que determinan cómo se muestran los vouchers, incluyendo estilos, imágenes y campos dinámicos.</p>
        </div>
    </section>

    <form action="{{ route('voucher_plantillas.store') }}" method="POST" enctype="multipart/form-data" id="form_main">
        @csrf

        <!-- CARD -->
        <div class="vch-card p-3 mb-3">
            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label required-label">Nombre</label>
                    <input type="text" name="vpl_nombre" class="form-control field-required" value="{{ old('vpl_nombre') }}" placeholder="Ej: Regalo, 2x1, Ocacion, etc" required>

                    @error('vpl_nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea name="vpl_descripcion" class="form-control" rows="3" placeholder="Notas internas o descripción opcional...">{{ old('vpl_descripcion') }}</textarea>

                    @error('vpl_descripcion')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-6 col-md-6">
                    <label class="form-label required-label">Ancho</label>
                    <input type="text" name="vpl_ancho" id="vpl_ancho" class="form-control field-required" value="{{ old('vpl_ancho') }}" placeholder="Ej: 1080" readonly>

                    @error('vpl_ancho')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-6 col-md-6">
                    <label class="form-label required-label">Alto</label>
                    <input type="text" name="vpl_alto"id="vpl_alto" class="form-control field-required" value="{{ old('vpl_alto') }}" placeholder="Ej: 1350" readonly>

                    @error('vpl_alto')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Imagen de fondo</label>

                    <div class="row">
                        @foreach($imagenesBiblioteca as $imagen)
                            <div class="col-md-3 mb-3">
                                <label class="card p-2 imagen-selector" style="cursor:pointer;">
                                    <input type="radio" name="biblioteca_imagen_id" value="{{ $imagen->pf_id }}" class="d-none imagen-radio" data-ancho="{{ $imagen->pf_img_ancho }}" data-alto="{{ $imagen->pf_img_alto }}">
                                    <input type="hidden" name="img_path" value="{{ $imagen->pf_img_path }}">

                                    <img src="{{ asset('storage/' . $imagen->pf_img_path) }}" class="img-fluid rounded" style="height: 225px; object-fit: cover;">

                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" disabled>
                                        <span class="form-check-label">
                                            {{ $imagen->pf_img_nombre_legible ?? 'Seleccionar imagen' }}
                                        </span>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </label>

                    @error('biblioteca_imagen_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-between form-actions">
            <a href="{{ route('voucher_plantillas.index') }}" class="btn btn-outline-secondary">
                Cancelar
            </a>

            <button type="submit" class="btn btn-success" id="btn_guardar">
                Guardar
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {

        const $anchoInput = $('#vpl_ancho');
        const $altoInput = $('#vpl_alto');

        $('.imagen-selector').on('click', function () {

            // Limpiar selección previa
            $('.imagen-selector').removeClass('seleccionada');
            $('.imagen-selector .form-check-input').prop('checked', false);

            const $card = $(this);
            const $radio = $card.find('.imagen-radio');

            // Marcar seleccionada
            $card.addClass('seleccionada');
            $radio.prop('checked', true);
            $card.find('.form-check-input').prop('checked', true);

            // Setear ancho y alto
            $anchoInput.val($radio.data('ancho'));
            $altoInput.val($radio.data('alto'));
        });

    });
</script>
@endpush
