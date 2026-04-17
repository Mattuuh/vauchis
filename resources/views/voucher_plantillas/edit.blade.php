@extends('layouts.app')

@section('title', 'Editar Plantilla')

@section('content')

@include('partials.navbar')

<div class="container py-4">
    <h1 class="mb-4">Editar plantilla</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('voucher_plantillas.update', $plantilla->vpl_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="vpl_nombre" class="form-control" value="{{ old('vpl_nombre', $plantilla->vpl_nombre) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="vpl_descripcion" class="form-control" rows="3">{{ old('vpl_descripcion', $plantilla->vpl_descripcion) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Ancho</label>
                        <input type="number" name="vpl_ancho" class="form-control" value="{{ old('vpl_ancho', $plantilla->vpl_ancho) }}" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Alto</label>
                        <input type="number" name="vpl_alto" class="form-control" value="{{ old('vpl_alto', $plantilla->vpl_alto) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen de fondo</label>
                    <input type="file" name="vpl_fondo" class="form-control" accept="image/*">
                </div>

                @if($plantilla->vpl_fondo_path)
                    <div class="mb-3">
                        <img src="{{ asset($plantilla->vpl_fondo_path) }}" alt="" style="max-height:180px;border-radius:8px;">
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="{{ route('voucher_plantillas.builder', $plantilla->vpl_id) }}" class="btn btn-outline-success">Ir al builder</a>
            </form>
        </div>
    </div>
</div>
@endsection