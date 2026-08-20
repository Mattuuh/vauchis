@extends('layouts.app')

@section('title', 'Nueva modalidad')

@push('validation')
<script>
$(document).ready(function () {
    $('#form_main').validate({
        submitHandler: function(form){

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se va a crear el registro",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5cb85c',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, crear',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    // Loader opcional
                    Swal.fire({
                        title: 'Procesando...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    form.submit();
                }
            });
        },
        rules: {
            f_codigo: {
                required: true,
            },
            f_nombre: {
                required: true,
            },
            f_tipo_mod_id: {
                required: true,
            },
            f_codigo: {
                required: true,
            },
            f_descripcion: {
                required: false,
            },
        },
        messages: {
        },

        errorElement: 'small',

        errorPlacement: function(error, element) {
            error.addClass('vs-error-message');
            error.insertAfter(element);
        },

        highlight: function(element) {
            $(element)
                .addClass('is-invalid')
                .removeClass('is-valid');
        },

        unhighlight: function(element) {
            $(element)
                .removeClass('is-invalid')
                .addClass('is-valid');
        }
    });
});
</script>
@endpush

@section('content')
@include('partials.navbar')

@php
    $oldCampos = old('campos', []);
@endphp

<div class="container">

    {{-- <div class="vch-hero-wave vch-hero-wave--one"></div> --}}
    
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

    <form method="POST" action="{{ route('admin.modalidades.store') }}" id="form_main">
        @csrf

        {{-- DATOS DE LA MODALIDAD --}}
        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-3">Datos de la modalidad</h6>

            <div class="row g-3">
                {{-- <div class="col-12 col-md-6">
                    <label class="form-label required-label">Código</label>
                    <input type="text" name="f_codigo" id="f_codigo" class="form-control field-required" value="{{ old('f_codigo') }}" placeholder="Ej: PORCENTAJE" required>
                    <div class="form-text">Se recomienda usar mayúsculas y guiones bajos.</div>

                    @error('f_codigo')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div> --}}

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Nombre</label>
                    <input type="text" name="f_nombre" class="form-control field-required" value="{{ old('f_nombre') }}" placeholder="Ej: Descuento porcentual" required>

                    @error('f_nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Tipo de modalidad:</label>
                    <select name="f_tipo_mod_id" id="f_tipo_mod_id" class="form-select field-required">
                        <option value="">Selecciona el tipo</option>
                        @foreach($tipos_modalidades as $tipo)
                            <option value="{{ $tipo['tipo_mod_id'] }}" {{ old('f_tipo_mod_id') == $tipo['tipo_mod_id'] ? 'selected' : '' }}>
                                {{ $tipo['tipo_mod_nombre'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('f_tipo_mod_id')
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

                <div class="col-12">
                    <label class="form-label">Texto de canje</label>
                    <input name="f_texto_canje" class="form-control" placeholder="Texto que se vera en el paso 2 (dos) en el voucher" value="{{ old('f_texto_canje', 'Elegí el producto que más te guste') }}">

                    @error('f_texto_canje')
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
                    <p class="text-muted small mb-0">Define qué datos deberá completar un voucher de esta modalidad.</p>
                </div>
                <input type="hidden" name="campo_index" id="campo_index" value="{{ count($oldCampos) ? count($oldCampos) : 0 }}">
                <button type="button" class="btn btn-primary btn-sm" id="btn-agregar-campo">+ Agregar campo</button>
            </div>

            <div id="campos-container">
                @if(count($oldCampos))
                    @foreach($oldCampos as $i => $campo)
                        <div class="campo-dinamico-item border rounded p-3 mb-3 position-relative" data-index="{{ $i }}">
                            <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 btn-eliminar-campo">×</button>

                            <div class="row g-3">
                                {{-- <div class="col-12 col-md-6">
                                    <label class="form-label required-label">Leyenda del campo</label>
                                    <input type="text" name="campos[{{ $i }}][nombre]" class="form-control field-required" value="{{ $campo['nombre'] ?? '' }}" placeholder="Ej: Porcentaje" required>
                                </div> --}}

                                {{-- <div class="col-12 col-md-6">
                                    <label class="form-label">Texto de guía</label>
                                    <input type="text" name="campos[{{ $i }}][placeholder]" class="form-control" value="{{ $campo['placeholder'] ?? '' }}" placeholder="Ej: Ingresá el porcentaje">
                                </div> --}}

                                <div class="col-12 col-md-6">
                                    <label class="form-label required-label">Tipo de dato del campo</label>
                                    <select name="campos[{{ $i }}][tipo]" id="f_tipo_campo-__INDEX__" class="form-select field-required campo-tipo" required>
                                        <option value="">Seleccionar una opci&oacute;n</option>
                                        <option value="number" {{ (($campo['tipo'] ?? '') == 'number') ? 'selected' : '' }}>Número</option>
                                        <option value="button" {{ (($campo['tipo'] ?? '') == 'button') ? 'selected' : '' }}>Boton</option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label d-block">Comportamiento</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="radio" name="campos[{{ $i }}][monto_fijo]" value="1" {{ !isset($campo['monto_fijo']) || !empty($campo['monto_fijo']) ? 'checked' : '' }}>
                                        <label class="form-check-label">Monto fijo</label>
                                        <input class="form-check-input" type="radio" name="campos[{{ $i }}][monto_variable]" value="1" {{ !isset($campo['monto_variable']) || !empty($campo['monto_variable']) ? 'checked' : '' }}>
                                        <label class="form-check-label">Monto variable</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label class="form-label d-block">Activo</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="campos[{{ $i }}][estado]" value="1" {{ !isset($campo['estado']) || !empty($campo['estado']) ? 'checked' : '' }}>
                                        <label class="form-check-label">Sí</label>
                                    </div>
                                </div>

                                {{-- <div class="col-12 campo-opciones-wrapper" style="{{ (($campo['tipo'] ?? '') === 'select') ? '' : 'display:none;' }}">
                                    <label class="form-label">Opciones</label>
                                    <textarea name="campos[{{ $i }}][opciones]" class="form-control" rows="2" placeholder="Ej: Rojo,Azul,Verde">{{ $campo['opciones'] ?? '' }}</textarea>
                                    <div class="form-text">Separá las opciones por coma.</div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Texto de ayuda (se muestra abajo de cada campo)</label>
                                    <input type="text" name="campos[{{ $i }}][ayuda]" class="form-control" value="{{ $campo['ayuda'] ?? '' }}" placeholder="Ej: Valor entre 1 y 100">
                                </div> --}}
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
            <a href="{{ route('admin.modalidades.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </div>
    </form>
</div>

{{-- TEMPLATE --}}
<template id="campo-template">
    <div class="campo-dinamico-item border rounded p-3 mb-3 position-relative" data-index="__INDEX__">
        <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2 btn-eliminar-campo">×</button>

        <div class="row g-3">
            {{-- <div class="col-12 col-md-6">
                <label class="form-label required-label">Leyenda del campo</label>
                <input type="text" name="campos[__INDEX__][nombre]" class="form-control field-required" placeholder="Ej: Porcentaje" required>
            </div> --}}

            {{-- <div class="col-12 col-md-6">
                <label class="form-label">Texto de guía</label>
                <input type="text" name="campos[__INDEX__][placeholder]" class="form-control" placeholder="Ej: Ingresá el porcentaje">
            </div> --}}

            <div class="col-12 col-md-6">
                <label class="form-label required-label">Tipo de campo</label>
                <select name="campos[__INDEX__][tipo]" id="f_tipo_campo-__INDEX__" class="form-select field-required campo-tipo f_tipo_campo" required>
                    <option value="">Seleccionar una opci&oacute;n</option>
                    {{-- <option value="text">Texto</option> --}}
                    {{-- <option value="textarea">Texto expandible</option> --}}
                    <option value="number">Número</option>
                    <option value="button">Boton</option>
                    {{-- <option value="boolean">Sí / No</option> --}}
                    {{-- <option value="select">Seleccionable</option> --}}
                </select>
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label">Orden</label>
                <input type="text" name="campos[__INDEX__][orden]" class="form-control" min="1" value="1">
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label d-block">Tipo de monto</label>
                <div class="form-check form-switch mt-2">
                    <input class="" type="radio" name="campos[__INDEX__][tipo_monto]" value="FIJ" id="monto_fijo-__INDEX__">
                    <label class="form-check-label" for="monto_fijo-__INDEX__" id="label_monto_fijo-__INDEX__">Monto fijo</label>
                    <input class="" type="radio" name="campos[__INDEX__][tipo_monto]" value="VAR" id="monto_variable-__INDEX__">
                    <label class="form-check-label" for="monto_variable-__INDEX__" id="label_monto_variable-__INDEX__">Monto variable</label>
                </div>
            </div>

            {{-- <div class="col-12 col-md-4">
                <label class="form-label d-block">Publico</label>
                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" name="campos[__INDEX__][estado]" value="1" checked>
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
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
    let campoIndex = Number($('#campo_index').val());

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
            const tipo_mod = Number($('#f_tipo_mod_id').val());
            let campoIndex = Number($('#campo_index').val());

            if (tipo_mod!='') {

                if (tipo_mod===3) {
                    if (campoIndex>=1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Solo puede seleccionar un campo!'
                        });

                        return;
                    }
                }

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

                if (tipo_mod===2) {
                    // 
                    $('.f_tipo_campo option[value="button"]').attr('hidden', true);

                    $('#label_monto_fijo-'+campoIndex).css('display', 'none');
                    $('#monto_fijo-'+campoIndex).css('display', 'none');
                    $('#monto_fijo-'+campoIndex).removeAttr('checked');

                    $('#label_monto_variable-'+campoIndex).css('display', '');
                    $('#monto_variable-'+campoIndex).css('display', '');
                    $('#monto_variable-'+campoIndex).attr('checked', 'checked');
                } else {
                    // 
                    $('.f_tipo_campo option[value="number"]').attr('hidden', true);

                    $('#label_monto_fijo-'+campoIndex).css('display', '');
                    $('#monto_fijo-'+campoIndex).css('display', '');
                    $('#monto_fijo-'+campoIndex).attr('checked', 'checked');

                    $('#label_monto_variable-'+campoIndex).css('display', 'none');
                    $('#monto_variable-'+campoIndex).css('display', 'none');
                    $('#monto_variable-'+campoIndex).removeAttr('checked');
                }

                campoIndex++;
                $('#campo_index').val(campoIndex);

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Debe seleccionar un tipo de modalidad!'
                });

                return;
            }
            
        });
    });
</script>

<script>
$(document).ready(function () {
    // 
    $('#f_tipo_mod_id').on('change', function () {
        $('#campo_index').val(0);

        const html = `
        <div id="campos-empty-state" class="text-muted small">
            Todavía no agregaste campos dinámicos para esta modalidad.
        </div>
        `;

        $('#campos-container').html(html);

    });

    $(document).on('change','.f_tipo_campo', function () {
        const rid = $(this).attr('id').split('-')[1];
        const val = $(this).val();

        if (val==='number') {
            $('#label_monto_fijo-'+rid).css('display', 'none');
            $('#monto_fijo-'+rid).css('display', 'none');
            $('#monto_fijo-'+rid).removeAttr('checked');

            $('#label_monto_variable-'+rid).css('display', '');
            $('#monto_variable-'+rid).css('display', '');
            $('#monto_variable-'+rid).attr('checked', 'checked');
        } else if (val==='button') {
            $('#label_monto_fijo-'+rid).css('display', '');
            $('#monto_fijo-'+rid).css('display', '');
            $('#monto_fijo-'+rid).attr('checked', 'checked');

            $('#label_monto_variable-'+rid).css('display', 'none');
            $('#monto_variable-'+rid).css('display', 'none');
            $('#monto_variable-'+rid).removeAttr('checked');

        } else {
            $('#label_monto_fijo-'+rid).css('display', '');
            $('#monto_fijo-'+rid).css('display', '');
            $('#monto_fijo-'+rid).removeAttr('checked');

            $('#label_monto_variable-'+rid).css('display', '');
            $('#monto_variable-'+rid).css('display', '');
            $('#monto_variable-'+rid).removeAttr('checked');
        }
    });
});
</script>
@endpush