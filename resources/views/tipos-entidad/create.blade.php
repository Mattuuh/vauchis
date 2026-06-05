@extends('layouts.app')

@section('title', 'Nuevo tipo de entidad')

@section('content')

<main class="vs-page">
    @include('partials.navbar')

    <section class="vs-section-lg">
        <div class="vs-container">
            <header class="vs-mb-xl">
                <h1 class="vs-title-xl">Nuevo tipo de entidad</h1>
                <p class="vs-text vs-text-muted">
                    Permiten categorizar las entidades por tipo de actividad, como restaurantes, comercios, ONGs, entre otros.
                </p>
            </header>

            <form method="POST" action="{{ route('tipos-entidad.store') }}" id="form_main">
                @csrf

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
                                    value="{{ old('nombre') }}"
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
                                >{{ old('observaciones') }}</textarea>

                                @error('observaciones')
                                    <div class="vs-help is-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="vs-d-flex vs-justify-between vs-align-center vs-gap-sm">
                    <a href="{{ route('tipos-entidad.index') }}" class="vs-btn vs-btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="vs-btn vs-btn-success">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>

@endsection
