@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Emitir voucher #{{ $voucher->vou_id }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('voucher_emisiones.store', $voucher->vou_id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Plantilla</label>
                    <select name="vpl_id" class="form-select" required>
                        <option value="">Seleccionar...</option>
                        @foreach($plantillas as $plantilla)
                            <option value="{{ $plantilla->vpl_id }}">
                                {{ $plantilla->vpl_nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="generar_pdf" id="generar_pdf" class="form-check-input" value="1" checked>
                    <label for="generar_pdf" class="form-check-label">Generar PDF</label>
                </div>

                <button type="submit" class="btn btn-primary">Emitir voucher</button>
            </form>
        </div>
    </div>
</div>
@endsection