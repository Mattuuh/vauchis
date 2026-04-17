@extends('layouts.app')

@section('title', 'Editar rubro')

@push('styles')
<style>
    .subrubros-selected-box,
    .subrubros-available-box {
        border: 1px solid #d9e1ec;
        border-radius: 12px;
        background: #fff;
        padding: 14px;
        min-height: 56px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: flex-start;
    }

    .subrubros-selected-box {
        background: #fbfcff;
    }

    .subrubros-empty-text {
        color: #8a94a6;
        font-size: 0.95rem;
    }

    .subrubro-option,
    .subrubro-selected {
        border-radius: 999px;
        font-size: 0.92rem;
        font-weight: 600;
        padding: 8px 12px;
        line-height: 1;
        transition: all 0.2s ease;
    }

    .subrubro-option {
        border: 1px solid #d7e4ff;
        background: #eef4ff;
        color: #2f6fed;
        cursor: pointer;
    }

    .subrubro-option:hover {
        background: #e3edff;
        border-color: #bdd3ff;
    }

    .subrubro-option.is-disabled {
        opacity: 0.45;
        cursor: not-allowed;
        pointer-events: none;
    }

    .subrubro-selected {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #cfe0ff;
        background: #2f6fed;
        color: #fff;
    }

    .subrubro-remove-btn {
        border: none;
        background: transparent;
        color: #fff;
        font-size: 1rem;
        line-height: 1;
        padding: 0;
        cursor: pointer;
        opacity: 0.9;
    }

    .subrubro-remove-btn:hover {
        opacity: 1;
    }
</style>
@endpush

@section('content')

@include('partials.navbar')

<div class="container py-3">
    <section class="vch-hero">
        <div class="vch-hero__content">
            <h1 class="vch-title">Editar rubro</h1>
            <p class="vch-subtitle">Modifica los datos del rubro seleccionado.</p>

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

    <form method="POST" action="{{ route('rubros.update', $rubro->rub_id) }}">
        @csrf
        @method('PUT')

        <div class="card card-custom p-3 mb-3">
            <h6 class="fw-bold mb-3">Datos del rubro</h6>

            <div class="row g-3">

                {{-- <div class="col-12">
                    <label class="form-label required-label">Codigo:</label>
                    <input
                        type="text"
                        name="f_codigo"
                        class="form-control field-required"
                        value="{{ old('f_codigo', $rubro->rub_codigo) }}"
                        required
                    >

                    @error('f_codigo')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div> --}}

                <div class="col-12">
                    <label class="form-label required-label">Nombre publico:</label>
                    <input
                        type="text"
                        name="f_nombre"
                        class="form-control field-required"
                        value="{{ old('f_nombre', $rubro->rub_nombre) }}"
                        required
                    >

                    @error('f_nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Descripcion corta:</label>
                    <input type="text" name="f_descripcion_corta" class="form-control field-required" value="{{ old('f_descripcion_corta', $rubro->rub_descripcion_corta) }}" placeholder="Descripcion para el publico">

                    @error('f_descripcion_corta')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Descripcion interna:</label>
                    <input type="text" name="f_descripcion" class="form-control field-required" value="{{ old('f_descripcion', $rubro->rub_descripcion) }}" placeholder="Descripcion precisa que no verá el publico pero servirá para la busqueda">

                    @error('f_descripcion')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>
        <div class="card card-custom p-3 mb-3">
            <h6 class="fw-bold mb-2">Subrubros</h6>

            <p class="text-muted small mb-3">
                Seleccioná subrubros existentes o creá nuevos para este rubro.
            </p>

            {{-- NUEVO SUBRUBRO --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Nuevo subrubro</label>
                <div class="d-flex gap-2">
                    <input type="text" id="nuevo-subrubro-input" class="form-control" placeholder="Ej: Café de especialidad">
                    <button type="button" class="btn btn-primary" onclick="agregarNuevoSubrubro()">
                        Agregar
                    </button>
                </div>
            </div>

            {{-- SELECCIONADOS --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Subrubros seleccionados</label>
                <div id="selected-subrubros" class="subrubros-selected-box">
                    <span class="subrubros-empty-text">No hay subrubros seleccionados.</span>
                </div>

                {{-- EXISTENTES --}}
                <div id="subrubros-hidden-inputs"></div>

                {{-- NUEVOS --}}
                <div id="subrubros-nuevos-hidden-inputs"></div>
            </div>

            {{-- DISPONIBLES --}}
            <div>
                <label class="form-label fw-semibold">Subrubros disponibles</label>
                <div class="subrubros-available-box">
                    @foreach($subrubrosDisponibles as $subrubro)
                        <button
                            type="button"
                            class="subrubro-option"
                            data-id="{{ $subrubro->sub_id }}"
                            data-name="{{ $subrubro->sub_nombre }}"
                            onclick="addSubrubroExistente(this)"
                        >
                            {{ $subrubro->sub_nombre }}
                        </button>
                    @endforeach
                </div>
            </div>

            @error('subrubros')
                <div class="text-required mt-2">{{ $message }}</div>
            @enderror

            @error('subrubros_nuevos')
                <div class="text-required mt-2">{{ $message }}</div>
            @enderror
        </div>

        

        <!-- BOTONES -->
        <div class="d-flex justify-content-between">

            <button type="button" class="btn btn-danger" data-id="{{ $rubro->rub_id }}" data-url="{{ route('rubros.delete', $rubro->rub_id) }}" id="btn_eliminar">
                Eliminar
            </button>

            <div>
                <a href="{{ route('rubros.index') }}" class="btn btn-outline-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-success" id="btn_guardar">
                    Actualizar
                </button>
            </div>

        </div>
    </form>
</div>

<script>
    let subrubrosExistentes = @json(old('subrubros', $subrubrosSeleccionados ?? []));
    let subrubrosNuevos = @json(old('subrubros_nuevos', []));

    function renderSubrubros() {
        const box = document.getElementById('selected-subrubros');
        const hiddenExistentes = document.getElementById('subrubros-hidden-inputs');
        const hiddenNuevos = document.getElementById('subrubros-nuevos-hidden-inputs');

        box.innerHTML = '';
        hiddenExistentes.innerHTML = '';
        hiddenNuevos.innerHTML = '';

        if (subrubrosExistentes.length === 0 && subrubrosNuevos.length === 0) {
            box.innerHTML = '<span class="subrubros-empty-text">No hay subrubros seleccionados.</span>';
        }

        // EXISTENTES
        subrubrosExistentes.forEach(item => {
            const chip = document.createElement('span');
            chip.className = 'subrubro-selected';
            chip.innerHTML = `
                ${item.name}
                <button type="button" class="subrubro-remove-btn" onclick="removeExistente(${item.id})">&times;</button>
            `;
            box.appendChild(chip);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'subrubros[]';
            input.value = item.id;
            hiddenExistentes.appendChild(input);
        });

        // NUEVOS
        subrubrosNuevos.forEach((nombre, index) => {
            const chip = document.createElement('span');
            chip.className = 'subrubro-selected';
            chip.innerHTML = `
                ${nombre}
                <button type="button" class="subrubro-remove-btn" onclick="removeNuevo(${index})">&times;</button>
            `;
            box.appendChild(chip);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'subrubros_nuevos[]';
            input.value = nombre;
            hiddenNuevos.appendChild(input);
        });

        actualizarDisponibles();
    }

    function addSubrubroExistente(button) {
        const id = Number(button.dataset.id);
        const name = button.dataset.name;

        if (subrubrosExistentes.some(s => s.id === id)) return;

        subrubrosExistentes.push({ id, name });
        renderSubrubros();
    }

    function removeExistente(id) {
        subrubrosExistentes = subrubrosExistentes.filter(s => s.id !== id);
        renderSubrubros();
    }

    function agregarNuevoSubrubro() {
        const input = document.getElementById('nuevo-subrubro-input');
        const nombre = input.value.trim();

        if (!nombre) return;

        if (subrubrosNuevos.includes(nombre)) return;

        subrubrosNuevos.push(nombre);
        input.value = '';

        renderSubrubros();
    }

    function removeNuevo(index) {
        subrubrosNuevos.splice(index, 1);
        renderSubrubros();
    }

    function actualizarDisponibles() {
        const botones = document.querySelectorAll('.subrubro-option');

        botones.forEach(btn => {
            const id = Number(btn.dataset.id);

            const seleccionado = subrubrosExistentes.some(s => s.id === id);

            btn.classList.toggle('is-disabled', seleccionado);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        renderSubrubros();
    });
</script>

<script>
$(document).on('click', '#btn_eliminar', function (e) {
    e.preventDefault();

    let url = $(this).data('url');

    Swal.fire({
        title: '¿Eliminar rubro?',
        text: "Esta acción lo desactivará",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            $.post(url, {
                _token: "{{ csrf_token() }}"
            }).done(function () {
                window.location.href = "{{ route('rubros.index') }}";
            });

        }
    });
});
</script>
@endsection