@extends('layouts.app')

@section('title', 'Nueva plantilla')

@section('content')

@include('partials.navbar')

<div class="container py-4">
    <h1 class="mb-4">Nueva plantilla</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('voucher_plantillas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="vpl_nombre" class="form-control" value="{{ old('vpl_nombre') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="vpl_descripcion" class="form-control" rows="3">{{ old('vpl_descripcion') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Ancho</label>
                        <input type="number" name="vpl_ancho" class="form-control" value="{{ old('vpl_ancho', 1080) }}" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Alto</label>
                        <input type="number" name="vpl_alto" class="form-control" value="{{ old('vpl_alto', 1350) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen de fondo</label>
                    <input type="file" name="vpl_fondo" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary">Crear plantilla</button>
                <a href="{{ route('voucher_plantillas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection