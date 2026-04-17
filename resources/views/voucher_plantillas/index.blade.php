@extends('layouts.app')

@section('title', 'Plantillas de vouchers')

@section('content')

@include('partials.navbar')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Plantillas de vouchers</h1>
        <a href="{{ route('voucher_plantillas.create') }}" class="btn btn-primary">
            Nueva plantilla
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Dimensiones</th>
                        <th>Fondo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plantillas as $plantilla)
                        <tr>
                            <td>{{ $plantilla->vpl_id }}</td>
                            <td>{{ $plantilla->vpl_nombre }}</td>
                            <td>{{ $plantilla->vpl_ancho }} x {{ $plantilla->vpl_alto }}</td>
                            <td>
                                @if($plantilla->vpl_fondo_path)
                                    <img src="{{ asset($plantilla->vpl_fondo_path) }}" alt="" style="height:60px;border-radius:6px;">
                                @else
                                    <span class="text-muted">Sin fondo</span>
                                @endif
                            </td>
                            <td class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('voucher_plantillas.edit', $plantilla->vpl_id) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                                <a href="{{ route('voucher_plantillas.builder', $plantilla->vpl_id) }}" class="btn btn-sm btn-outline-primary">Builder</a>
                                <a href="{{ route('voucher_plantillas.preview', $plantilla->vpl_id) }}" class="btn btn-sm btn-outline-success" target="_blank">Preview</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No hay plantillas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection