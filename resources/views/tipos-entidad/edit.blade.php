@extends('layouts.app')

@section('title', 'Editar tipo de entidad')

@section('content')

<main class="vs-page">
    @include('partials.navbar')

    <section class="vs-section-lg">
        <div class="vs-container">
            <header class="vs-mb-xl">
                <h1 class="vs-title-xl">Editar tipo de entidad</h1>
                <p class="vs-text vs-text-muted">
                    Modifica los datos del tipo de entidad seleccionado.
                </p>
            </header>

            <form method="POST" action="{{ route('tipos-entidad.update', $tipo->tipo_ent_id) }}" id="form_main">
                @csrf
                @method('PUT')

                <div class="vs-card vs-mb-md">
                    <div class="vs-card-body vs-p-lg">
                        <h2 class="vs-title-card vs-mb-md">Datos del tipo de entidad</h2>

                        <div class="vs-grid">
                            <div class="vs-form-group">
                                <label class="vs-label" for="nombre">Nombre</label>
                                <input
                                    type="text"
                                    name="nombre"
                                    id="nombre"
                                    class="vs-input @error('nombre') is-error @enderror"
                                    value="{{ old('nombre', $tipo->tipo_ent_nombre) }}"
                                    placeholder="Ej: Empresa, Persona, ONG..."
                                    required
                                >

                                @error('nombre')
                                    <div class="vs-help is-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="vs-form-group">
                                <label class="vs-label" for="observaciones">Observaciones</label>
                                <textarea
                                    name="observaciones"
                                    id="observaciones"
                                    class="vs-textarea @error('observaciones') is-error @enderror"
                                    rows="3"
                                    placeholder="Notas internas o descripción opcional..."
                                >{{ old('observaciones', $tipo->tipo_ent_observacion) }}</textarea>

                                @error('observaciones')
                                    <div class="vs-help is-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="vs-d-flex vs-justify-between vs-align-center vs-gap-sm" style="flex-wrap: wrap;">
                    <button
                        type="button"
                        class="vs-btn"
                        style="background: var(--color-accent-pink); color: var(--text-inverse);"
                        data-id="{{ $tipo->tipo_ent_id }}"
                        data-url="{{ route('tipos-entidad.delete', $tipo->tipo_ent_id) }}"
                        id="btn_eliminar"
                    >
                        Eliminar
                    </button>

                    <div class="vs-d-flex vs-align-center vs-gap-sm" style="flex-wrap: wrap;">
                        <a href="{{ route('tipos-entidad.index') }}" class="vs-btn vs-btn-secondary">
                            Cancelar
                        </a>

                        <button type="submit" class="vs-btn vs-btn-success" id="btn_actualizar">
                            Actualizar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>

@endsection
