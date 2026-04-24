@extends('layouts.app')

@section('title', 'Editar Plantilla')

@section('content')

@include('partials.navbar')

<div class="container py-3">
    <section class="vch-hero">
        <div class="vch-hero__content">
            <h1 class="vch-title">Editar plantilla</h1>

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

    <form action="{{ route('voucher_plantillas.update', $plantilla->vpl_id) }}" method="POST" enctype="multipart/form-data" id="form_main">
        @csrf
        @method('PUT')

        <div class="card card-custom p-3 mb-3">

            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label required-label">Nombre</label>
                    <input type="text" name="vpl_nombre" class="form-control field-required" value="{{ old('vpl_nombre', $plantilla->vpl_nombre) }}" required>

                    @error('vpl_nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea name="vpl_descripcion" class="form-control" rows="3" placeholder="Notas internas o descripción opcional...">{{ old('vpl_descripcion', $plantilla->vpl_descripcion) }}</textarea>

                    @error('vpl_descripcion')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-6 col-md-6">
                    <label class="form-label required-label">Ancho:</label>
                    <input type="number" name="vpl_ancho" class="form-control field-required" value="{{ old('vpl_ancho', $plantilla->vpl_ancho) }}" placeholder="Ej: 1080" required>

                    @error('vpl_ancho')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-6 col-md-6">
                    <label class="form-label required-label">Alto:</label>
                    <input type="number" name="vpl_alto" class="form-control field-required" value="{{ old('vpl_alto', $plantilla->vpl_alto) }}" placeholder="Ej: 1350" required>

                    @error('vpl_alto')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Imagen de fondo:</label>
                    @if($plantilla->vpl_fondo_path)
                        <div class="mb-3">
                            <img src="{{ asset($plantilla->vpl_fondo_path) }}" alt="" style="max-height:180px;border-radius:8px;">
                        </div>
                    @endif
                    <input type="file" name="vpl_fondo" class="form-control" value="{{ old('vpl_fondo') }}" accept="image/*">

                    @error('vpl_fondo')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-between">

            <button type="button" class="btn btn-danger" data-id="{{ $plantilla->vpl_id }}" data-url="{{ route('voucher_plantillas.delete', $plantilla->vpl_id) }}" id="btn_eliminar">
                Eliminar
            </button>

            <div>
                <a href="{{ route('voucher_plantillas.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-success" id="btn_guardar">
                    Actualizar
                </button>
                {{-- <a href="{{ route('voucher_plantillas.builder', $plantilla->vpl_id) }}" class="btn btn-outline-success">Ir al builder</a> --}}
            </div>
        </div>
    </form>
</div>
@endsection