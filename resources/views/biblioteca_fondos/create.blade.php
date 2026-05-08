@extends('layouts.app')

@section('title', 'Nuevo fondo')

@section('content')

@include('partials.navbar')

@section('content')
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
            <h1 class="vch-title">Registrar imagen en biblioteca</h1>
            <p class="vch-subtitle">-</p>
        </div>
    </section>

    @if($errors->any())
        <div class="alert alert-danger">
            Revisá los campos del formulario.
        </div>
    @endif

    <form action="{{ route('biblioteca_fondos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card p-4">
            <div class="mb-3">
                <label class="form-label">Nombre de la imagen</label>
                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" placeholder="Ej: Logo Marathon">

                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Imagen</label>
                <input type="file" name="imagen" id="imagen" class="form-control @error('imagen') is-invalid @enderror" accept="image/*" required>

                @error('imagen')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3" id="preview-container" style="display:none;">
                <label class="form-label">Vista previa</label>
                <div class="border rounded p-2" style="width: 260px;">
                    <img id="preview" src="" class="img-fluid rounded">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Guardar imagen
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('imagen').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');
        const container = document.getElementById('preview-container');

        if (file) {
            preview.src = URL.createObjectURL(file);
            container.style.display = 'block';
        } else {
            preview.src = '';
            container.style.display = 'none';
        }
    });
</script>
@endsection