@extends('layouts.app')

@section('title', 'Nuevo tipo de entidad')


@section('content')

@include('partials.navbar')

<div class="container py-3">
    <section class="vch-hero">
        <div class="vch-hero__content">
            <h1 class="vch-title">Nuevo tipo de entidad</h1>
            <p class="vch-subtitle">Consulta y administra los tipos de entidad disponibles en la plataforma.</p>

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

    <form method="POST" action="{{ route('tipos-entidad.store') }}">
        @csrf

        <!-- CARD -->
        <div class="card card-custom p-3 mb-3">

            <h6 class="fw-bold mb-3">Datos del tipo de entidad</h6>

            <div class="row g-3">

                <!-- NOMBRE -->
                <div class="col-12">
                    <label class="form-label required-label">Nombre</label>
                    <input 
                        type="text" 
                        name="nombre" 
                        class="form-control field-required"
                        value="{{ old('nombre') }}"
                        placeholder="Ej: Empresa, Persona, ONG..."
                        required
                    >

                    @error('nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <!-- OBSERVACIONES -->
                <div class="col-12">
                    <label class="form-label">Observaciones</label>
                    <textarea 
                        name="observaciones" 
                        class="form-control" 
                        rows="3"
                        placeholder="Notas internas o descripción opcional..."
                    >{{ old('observaciones') }}</textarea>

                    @error('observaciones')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('tipos-entidad.index') }}" class="btn btn-outline-secondary">
                Cancelar
            </a>

            <button type="submit" class="btn btn-success">
                Guardar
            </button>
        </div>

    </form>

</div>
@endsection
