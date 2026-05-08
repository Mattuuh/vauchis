@extends('layouts.app')

@section('title', 'Nueva modalidad')

@section('content')
@include('partials.navbar')

@php
    $oldCampos = old('campos', []);
@endphp

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
            <h1 class="vch-title">Nueva modalidad para vouchers</h1>
            <p class="vch-subtitle">Configuran cómo funciona un voucher, incluyendo su tipo, condiciones y forma de uso.</p>
        </div>
    </section>

    <form method="POST" action="{{ route('modalidades.store') }}">
        @csrf

        {{-- DATOS DE LA MODALIDAD --}}
        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-3">Datos de la modalidad</h6>

            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Código</label>
                    <input type="text" name="f_codigo" id="f_codigo" class="form-control field-required" value="{{ old('f_codigo') }}" placeholder="Ej: PORCENTAJE" required>
                    <div class="form-text">Se recomienda usar mayúsculas y guiones bajos.</div>

                    @error('f_codigo')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Nombre</label>
                    <input type="text" name="f_nombre" class="form-control field-required" value="{{ old('f_nombre') }}" placeholder="Ej: Descuento porcentual" required>

                    @error('f_nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea name="f_descripcion" class="form-control" rows="3" placeholder="Descripción interna de la modalidad...">{{ old('f_descripcion') }}</textarea>

                    @error('f_descripcion')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- CAMPOS DINÁMICOS --}}
        <div class="vch-card p-3 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold mb-1">Campos dinámicos</h6>
                    <p class="text-muted small mb-0">
                        Define qué datos deberá completar un voucher de esta modalidad.
                    </p>
                </div>

                <button type="button" class="btn btn-primary btn-sm" id="btn-agregar-campo">
                    + Agregar campo
                </button>
            </div>

            <div id="campos-container">
                @if(count($oldCampos))
                    @foreach($oldCampos as $i => $campo)
                        <div class="campo-dinamico-item border rounded p-3 mb-3 position-relative" data-index="{{ $i }}">
                            <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 btn-eliminar-campo">
                                ×
                            </button>

                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label required-label">Leyenda del campo</label>
                                    <input type="text" name="campos[{{ $i }}][nombre]" class="form-control field-required" value="{{ $campo['nombre'] ?? '' }}" placeholder="Ej: Porcentaje" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Texto de guía</label>
                                    <input type="text" name="campos[{{ $i }}][placeholder]" class="form-control" value="{{ $campo['placeholder'] ?? '' }}" placeholder="Ej: Ingresá el porcentaje">
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label required-label">Tipo de dato del campo</label>
                                    <select name="campos[{{ $i }}][tipo]" class="form-select field-required campo-tipo" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="text" {{ (($campo['tipo'] ?? '') == 'text') ? 'selected' : '' }}>Texto</option>
                                        <option value="textarea" {{ (($campo['tipo'] ?? '') == 'textarea') ? 'selected' : '' }}>Texto expandible</option>
                                        <option value="number" {{ (($campo['tipo'] ?? '') == 'number') ? 'selected' : '' }}>Número</option>
                                        {{-- <option value="decimal" {{ (($campo['tipo'] ?? '') == 'decimal') ? 'selected' : '' }}>Decimal</option> --}}
                                        {{-- <option value="money" {{ (($campo['tipo'] ?? '') == 'money') ? 'selected' : '' }}>Moneda</option> --}}
                                        <option value="boolean" {{ (($campo['tipo'] ?? '') == 'boolean') ? 'selected' : '' }}>Sí / No</option>
                                        <option value="select" {{ (($campo['tipo'] ?? '') == 'select') ? 'selected' : '' }}>Seleccionable</option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label d-block">Activo</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="campos[{{ $i }}][estado]" value="1" {{ !isset($campo['estado']) || !empty($campo['estado']) ? 'checked' : '' }}>
                                        <label class="form-check-label">Sí</label>
                                    </div>
                                </div>

                                <div class="col-12 campo-opciones-wrapper" style="{{ (($campo['tipo'] ?? '') === 'select') ? '' : 'display:none;' }}">
                                    <label class="form-label">Opciones</label>
                                    <textarea name="campos[{{ $i }}][opciones]" class="form-control" rows="2" placeholder="Ej: Rojo,Azul,Verde">{{ $campo['opciones'] ?? '' }}</textarea>
                                    <div class="form-text">Separá las opciones por coma.</div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Texto de ayuda (se muestra abajo de cada campo)</label>
                                    <input type="text" name="campos[{{ $i }}][ayuda]" class="form-control" value="{{ $campo['ayuda'] ?? '' }}" placeholder="Ej: Valor entre 1 y 100">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div id="campos-empty-state" class="text-muted small">
                        Todavía no agregaste campos dinámicos para esta modalidad.
                    </div>
                @endif
            </div>

            @error('campos')
                <div class="text-required mt-2">{{ $message }}</div>
            @enderror
        </div>

        {{-- BOTONES --}}
        <div class="d-flex justify-content-between form-actions">
            <a href="{{ route('modalidades.index') }}" class="btn btn-outline-secondary">
                Cancelar
            </a>

            <button type="submit" class="btn btn-success">
                Guardar
            </button>
        </div>
    </form>
</div>

{{-- TEMPLATE --}}
<template id="campo-template">
    <div class="campo-dinamico-item border rounded p-3 mb-3 position-relative" data-index="__INDEX__">
        <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 btn-eliminar-campo">
            ×
        </button>

        <div class="row g-3">
            {{-- <div class="col-12 col-md-4">
                <label class="form-label required-label">Código</label>
                <input type="text" name="campos[__INDEX__][codigo]" class="form-control field-required campo-codigo" placeholder="Ej: porcentaje" required>
            </div> --}}

            <div class="col-12 col-md-6">
                <label class="form-label required-label">Leyenda del campo</label>
                <input type="text" name="campos[__INDEX__][nombre]" class="form-control field-required" placeholder="Ej: Porcentaje" required>
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label">Texto de guía</label>
                <input type="text" name="campos[__INDEX__][placeholder]" class="form-control" placeholder="Ej: Ingresá el porcentaje">
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label required-label">Tipo de dato del campo</label>
                <select name="campos[__INDEX__][tipo]" class="form-select field-required campo-tipo" required>
                    <option value="">Seleccionar...</option>
                    <option value="text">Texto</option>
                    <option value="textarea">Texto expandible</option>
                    <option value="number">Número</option>
                    {{-- <option value="decimal">Decimal</option> --}}
                    {{-- <option value="money">Moneda</option> --}}
                    <option value="boolean">Sí / No</option>
                    <option value="select">Seleccionable</option>
                </select>
            </div>

            {{-- <div class="col-12 col-md-6">
                <label class="form-label required-label">Leyenda del campo</label>
                <input type="text" name="campos[__INDEX__][label]" class="form-control field-required" placeholder="Ej: Porcentaje de descuento" required>
            </div> --}}

            {{-- <div class="col-12 col-md-4">
                <label class="form-label">Orden</label>
                <input type="number" name="campos[__INDEX__][orden]" class="form-control" min="1" value="1">
            </div> --}}

            {{-- <div class="col-12 col-md-4">
                <label class="form-label d-block">Requerido</label>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="campos[__INDEX__][requerido]" value="1">
                    <label class="form-check-label">Sí</label>
                </div>
            </div> --}}

            <div class="col-12 col-md-4">
                <label class="form-label d-block">Activo</label>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="campos[__INDEX__][estado]" value="1" checked>
                    <label class="form-check-label">Sí</label>
                </div>
            </div>

            <div class="col-12 campo-opciones-wrapper" style="display:none;">
                <label class="form-label">Opciones</label>
                <textarea name="campos[__INDEX__][opciones]" class="form-control" rows="2" placeholder="Ej: Rojo,Azul,Verde"></textarea>
                <div class="form-text">Separá las opciones por coma.</div>
            </div>

            <div class="col-12">
                <label class="form-label">Texto de ayuda (se muestra abajo de cada campo)</label>
                <input type="text" name="campos[__INDEX__][ayuda]" class="form-control" placeholder="Ej: Valor entre 1 y 100">
            </div>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
    let campoIndex = {{ count($oldCampos) ? count($oldCampos) : 0 }};

    function normalizarCodigo(valor) {
        return valor
            .toUpperCase()
            .replace(/\s+/g, '_')
            .replace(/[^A-Z0-9_]/g, '');
    }

    function toggleOpciones(wrapper) {
        const selectTipo = wrapper.querySelector('.campo-tipo');
        const opcionesWrapper = wrapper.querySelector('.campo-opciones-wrapper');

        if (!selectTipo || !opcionesWrapper) return;

        opcionesWrapper.style.display = (selectTipo.value === 'select') ? '' : 'none';
    }

    function bindCampoEvents(campoItem) {
        const btnEliminar = campoItem.querySelector('.btn-eliminar-campo');
        const selectTipo = campoItem.querySelector('.campo-tipo');
        const inputCodigo = campoItem.querySelector('.campo-codigo');

        if (btnEliminar) {
            btnEliminar.addEventListener('click', function () {
                campoItem.remove();

                const container = document.getElementById('campos-container');
                if (!container.querySelector('.campo-dinamico-item')) {
                    container.innerHTML = '<div id="campos-empty-state" class="text-muted small">Todavía no agregaste campos dinámicos para esta modalidad.</div>';
                }
            });
        }

        if (selectTipo) {
            selectTipo.addEventListener('change', function () {
                toggleOpciones(campoItem);
            });
        }

        if (inputCodigo) {
            inputCodigo.addEventListener('input', function () {
                this.value = this.value
                    .toLowerCase()
                    .replace(/\s+/g, '_')
                    .replace(/[^a-z0-9_]/g, '');
            });
        }

        toggleOpciones(campoItem);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const btnAgregarCampo = document.getElementById('btn-agregar-campo');
        const camposContainer = document.getElementById('campos-container');
        const campoTemplate = document.getElementById('campo-template');
        const inputCodigoModalidad = document.getElementById('f_codigo');

        if (inputCodigoModalidad) {
            inputCodigoModalidad.addEventListener('input', function () {
                this.value = normalizarCodigo(this.value);
            });
        }

        document.querySelectorAll('.campo-dinamico-item').forEach(function(item) {
            bindCampoEvents(item);
        });

        btnAgregarCampo.addEventListener('click', function () {
            const emptyState = document.getElementById('campos-empty-state');
            if (emptyState) {
                emptyState.remove();
            }

            let html = campoTemplate.innerHTML.replaceAll('__INDEX__', campoIndex);
            camposContainer.insertAdjacentHTML('beforeend', html);

            const nuevoCampo = camposContainer.querySelector('.campo-dinamico-item[data-index="' + campoIndex + '"]');
            if (nuevoCampo) {
                const ordenInput = nuevoCampo.querySelector('input[name="campos[' + campoIndex + '][orden]"]');
                if (ordenInput) {
                    ordenInput.value = campoIndex + 1;
                }

                bindCampoEvents(nuevoCampo);
            }

            campoIndex++;
        });
    });
</script>
@endpush