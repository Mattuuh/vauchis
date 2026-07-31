@extends('layouts.app')

@section('title', 'Editar tipo de modalidad')

@section('content')

@include('partials.navbar')

<div class="container">

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
            <h1 class="vch-title">Editar tipo de modalidad</h1>
            <p class="vch-subtitle">Modifica los datos del tipo de modalidad seleccionado.</p>
        </div>
    </section>

    <form method="POST" action="{{ route('admin.tipos_modalidades.update', $tipo->tipo_mod_id) }}" id="form_main">
        @csrf
        @method('PUT')

        <div class="vch-card p-3 mb-3">

            <h6 class="fw-bold mb-3">Datos del tipo de modalidad</h6>

            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label required-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control field-required" value="{{ old('nombre', $tipo->tipo_mod_nombre) }}" placeholder="Ej: Empresa, Persona, ONG..." required>

                    @error('nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="3" placeholder="Notas internas o descripción opcional...">{{ old('observaciones', $tipo->tipo_mod_observacion) }}</textarea>

                    @error('observaciones')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-between form-actions">
            <button type="button" class="btn btn-danger" data-id="{{ $tipo->tipo_mod_id }}" data-url="{{ route('admin.tipos_modalidades.delete', $tipo->tipo_mod_id) }}" id="btn_eliminar">
                Eliminar
            </button>

            <div>
                <a href="{{ route('admin.tipos_modalidades.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success" id="btn_actualizar">Actualizar</button>
            </div>

        </div>

    </form>
</div>
@endsection