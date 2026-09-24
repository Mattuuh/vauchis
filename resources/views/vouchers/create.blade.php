@extends('layouts.app')

@section('title', 'Nuevo voucher')

@push('validation')
<script>
$(document).ready(function () {
    $('#form_main').validate({
        submitHandler: function(form){

            // if ($('[name="subrubros_nuevos[]"]').length == 0) {
            //     Swal.fire({
            //         title: 'Error',
            //         text: "Debe ingresar al menos 1 (uno) subrubro",
            //         icon: 'error',
            //         confirmButtonColor: '#d33',
            //         confirmButtonText: 'Entendido'
            //     });

            //     return false;
            // }

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se va a crear el registro",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5cb85c',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
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
            f_nombre: {
                required: true,
            },
            f_ent_id: {
                required: true,
            },
            f_ed_id: {
                required: true,
            },
            com_documento: {
                required: true,
                number: true,
                digits: true,
                minlength: 6
            },
            f_inf_id: {
                required: true,
            },
            f_cv_id: {
                required: true,
            },
            f_fecha_ini_lab: {
                required: true,
            },
            f_fecha_fin_lab: {
                required: true,
            },
            f_vigencia: {
                required: true,
            },
            stock: {
                required: false,
            },
            f_comision: {
                required: true,
            },
            description: {
                required: false,
            },
            terms: {
                required: false,
            },
            observaciones: {
                required: false,
            },
            f_mod_id: {
                required: true,
            },
            "imagenes[]": {
                required: false,
            },
            "f_tipo_archivo_id[]": {
                required: false,
            },
            // "sucursales[][cd_ciudad]": {
            //     required: true,
            // },
            // "sucursales[][cd_descripcion_publica]": {
            //     required: true,
            // },
            // "sucursales[][cd_descripcion_interna]": {
            //     required: true,
            // },
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

@push('styles')
<link rel="stylesheet" href="{{ asset('css/vouchers/vouchers.css') }}">

<style>
.voucher-rubro {
    border: 1px solid #dee2e6;
    border-radius: 7px;
    padding: 10px 12px;
}

.voucher-rubro-header {
    margin-bottom: 8px;
}

.voucher-rubro-check {
    display: inline-flex;
    align-items: center;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
}

.voucher-subrubros {
    display: flex;
    flex-wrap: wrap;
    gap: 7px 14px;
    padding-left: 25px;
}

.voucher-subrubro {
    display: inline-flex;
    align-items: center;
    font-size: 13px;
    cursor: pointer;
    transition: opacity .2s ease;
}

.voucher-subrubro.disabled {
    opacity: .4;
    cursor: default;
}

.variable-condicion {
    color: #0867ed;
    font-weight: 700;
    background: rgba(8, 103, 237, .10);
    padding: 2px 5px;
    border-radius: 4px;
}
</style>
@endpush

@section('content')

@include('partials.navbar')

<div class="container">

    
    <span class="vch-dot vch-dot--pink-left"></span>
    <span class="vch-dot vch-dot--blue-left"></span>
    <span class="vch-dot vch-dot--yellow"></span>
    <span class="vch-dot vch-dot--blue"></span>
    <span class="vch-dot vch-dot--green"></span>
    <span class="vch-dot vch-dot--pink"></span>
    <span class="vch-dot vch-dot--blue-small"></span>

    <section class="vch-hero">
        <div class="vch-hero__content">
            <h1 class="vch-title">Nuevo voucher</h1>
            <p class="commerce-subtitle">Son productos digitales que el usuario compra para canjear en una entidad bajo condiciones acordadas.</p>
        </div>
    </section>

    <form method="POST" action="{{ route('admin.vouchers.store') }}" enctype="multipart/form-data" id="form_main">
        @csrf

        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-3">Datos del voucher</h6>

            <div class="row g-4">

                <div class="col-12">
                    <label class="form-label required-label">Nombre público:</label>
                    <input type="text" name="f_nombre" class="form-control field-required" value="{{ old('f_nombre') }}" placeholder="Nombre público">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Entidad:</label>
                    <select name="f_ent_id" id="f_ent_id" class="form-select field-required">
                        <option value="">Selecciona la entidad</option>
                        @foreach($entidades as $entidad)
                            <option value="{{ $entidad['ent_id'] }}" {{ old('f_ent_id') == $entidad['ent_id'] ? 'selected' : '' }}>
                                {{ $entidad['ent_nombre_fantasia'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Sucursal:</label>
                    <div id="f_domicilios"></div>
                </div>

                <div class="col-12 col-md-12">
                    <label class="form-label required-label">Telefono de contacto:</label>
                    <div id="f_telefonos"></div>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Influencer:</label>
                    <select name="f_inf_id" class="form-select field-required">
                        <option value="">Selecciona el influencer</option>
                        <option value="0">Sin influencer vinculado</option>
                        @foreach($influencers as $id => $nombre)
                            <option value="{{ $id }}" {{ old('f_inf_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Categoría:</label>
                    <select name="f_cv_id" class="form-select field-required">
                        <option value="">Selecciona la categoría</option>
                        @foreach($categorias as $id => $nombre)
                            <option value="{{ $id }}" {{ old('f_cv_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Colecci&oacute;n:</label>
                    <select name="f_colecc_id" class="form-select field-required">
                        <option value="">Selecciona la colecci&oacute;n</option>
                        <option value="0" {{ old('f_colecc_id') == 0 ? 'selected' : '' }}>Sin colecci&oacute;n vinculado</option>
                        @foreach($colecciones as $id => $nombre)
                            <option value="{{ $id }}" {{ old('f_colecc_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label required-label">Fecha de inicio:</label>
                        <input type="text" name="f_fecha_ini_lab" id="f_fecha_ini_lab" class="form-control field-required" value="{{ old('f_fecha_ini_lab') }}" placeholder="dd/mm/yyyy">
                        <input type="hidden" name="f_fecha_ini" id="f_fecha_ini" value="{{ old('f_fecha_ini') }}">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label required-label">Fecha de fin:</label>
                        <input type="text" name="f_fecha_fin_lab" id="f_fecha_fin_lab" class="form-control field-required" value="{{ old('f_fecha_fin_lab') }}" placeholder="dd/mm/yyyy">
                        <input type="hidden" name="f_fecha_fin" id="f_fecha_fin" value="{{ old('f_fecha_fin') }}">
                    </div>
                </div>

                {{-- <div class="col-12 col-md-6">
                    <label class="form-label required-label">Monto total:</label>
                    <input type="text" name="f_monto_total" class="form-control field-required" value="0" placeholder="1.01">

                    @error('f_monto_total')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div> --}}

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Vigencia post compra (d&iacute;as):</label>
                    <input type="text" name="f_vigencia" class="form-control field-required" value="{{ old('f_vigencia') }}" placeholder="0">
                </div>

                {{-- <div class="col-12 col-md-6">
                    <label class="form-label required-label">Stock:</label>
                    <input type="text" name="stock" class="form-control field-required" value="{{ old('stock') }}" placeholder="0">
                </div> --}}

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Porcentaje comisi&oacute;n:</label>
                    <input type="text" name="f_comision" class="form-control field-required" value="{{ old('f_comision') }}" placeholder="0">
                </div>

                {{-- <div class="col-12 col-md-6">
                    <label class="form-label required-label">Permite personalización</label>
                    <select name="f_permite_personalizacion" class="form-select field-required">
                        <option value="0" {{ old('f_permite_personalizacion') === '0' ? 'selected' : '' }}>NO</option>
                        <option value="1" {{ old('f_permite_personalizacion') === '1' ? 'selected' : '' }}>SI</option>
                    </select>
                    @error('f_permite_personalizacion')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div> --}}

                <div class="col-12">
                    <label class="form-label required-label">Descripción:</label>
                    <textarea id="description" name="description" rows="2" class="form-control voucher-textarea" placeholder="Descripción&#10;Incluye una descripción detallada del voucher.">{{ old('description') }}</textarea>
                </div>

                {{-- <div class="col-12">
                    <label class="form-label">Términos y condiciones:</label>
                    <textarea id="terms" name="terms" rows="4" class="form-control voucher-textarea" placeholder="Términos y condiciones&#10;Incluye aquí los términos y condiciones para este voucher (opcional).">{{ old('terms') }}</textarea>
                </div> --}}

                <div class="col-12">
                    <label class="form-label">Observaciones internas</label>
                    <textarea name="observaciones" class="form-control" rows="2" placeholder="Notas internas o descripción opcional...">{{ old('observaciones') }}</textarea>
                </div>
            </div>
        </div>

        {{-- CAMPOS DINÁMICOS DE MODALIDAD --}}
        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-2">Configuración de la modalidad</h6>

            <div class="col-12 col-md-6">
                <label class="form-label required-label">Modalidad:</label>
                <select name="f_mod_id" id="f_mod_id" class="form-select field-required">
                    <option value="">Selecciona la modalidad</option>
                    @foreach($modalidades as $modalidad)
                        <option value="{{ $modalidad->mod_id }}" {{ old('f_mod_id') == $modalidad->mod_id ? 'selected' : '' }} data-condiciones="{{ $modalidad->mod_condiciones }}">
                            {{ $modalidad->mod_nombre }}
                        </option>
                    @endforeach
                </select>
                @error('f_mod_id')
                    <div class="text-required">{{ $message }}</div>
                @enderror
            </div>

            <p class="text-muted small mb-3">
                Al seleccionar una modalidad, se mostrarán aquí los campos específicos que debe completar este voucher.
            </p>

            <div id="modalidad-campos-container">
                <div id="modalidad-empty-state" class="text-muted small">
                    Seleccioná una modalidad para completar su configuración específica.
                </div>
            </div>

            <div class="col-12">
                <label class="form-label">Condiciones:</label>
                <textarea id="vou_modalidad_condiciones" name="vou_modalidad_condiciones" class="form-control" rows="4" placeholder="Condición 1;; Condición 2;; Condición 3"></textarea>
                <p class="text-muted small mb-3">
                    Separá cada condición utilizando <strong>;;</strong> (doble punto y coma).
                </p>
                <div id="preview-condiciones" class="mt-3"></div>
            </div>
        </div>

        {{-- ETIQUETAS --}}
        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-2">Etiquetas</h6>

            <p class="text-muted small mb-3">
                Seleccioná etiquetas existentes o creá nuevas para este voucher.
            </p>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nueva etiqueta</label>
                <div class="d-flex gap-2">
                    <input type="text" id="nueva-etiqueta-input" class="form-control" placeholder="Ej: Promoción, Regalo, Gourmet">
                    <button type="button" class="btn btn-primary" onclick="agregarNuevaEtiqueta()">
                        Agregar
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Etiquetas seleccionadas</label>
                <div id="selected-etiquetas" class="d-flex flex-wrap gap-2"></div>
            </div>

            <div>
                <label class="form-label fw-semibold">Etiquetas disponibles</label>
                <div class="chips-box">
                    @foreach($etiquetasDisponibles as $etiqueta)
                        <button
                            type="button"
                            class="chip-option"
                            data-id="{{ $etiqueta->eti_id }}"
                            data-name="{{ $etiqueta->eti_nombre }}"
                            onclick="addEtiquetaExistente(this)"
                        >
                            {{ $etiqueta->eti_nombre }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ARCHIVOS --}}
        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-2">Imagenes</h6>

            <div class="col-12">
                <label class="form-label required-label">Imagen/es</label>
                <div id="logos-container">
                    <div class="row logo-item mb-2">
                        <div class="col-sm-11">
                            <input type="file" name="imagenes[]" accept="image/*" class="form-control">
                        </div>
                        {{-- <div class="col-sm-3">
                            <select name="f_tipo_archivo_id[]" id="f_tipo_archivo_id" class="form-select field-required">
                                <option value="">Selecciona el tipo de archivo</option>
                                @foreach($tipos_archivos as $tipo)
                                    <option value="{{ $tipo['tipo_archivo_id'] }}" {{ old('f_tipo_archivo_id') == $tipo['tipo_archivo_id'] ? 'selected' : '' }}>
                                        {{ $tipo['tipo_archivo_nombre'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-sm-1 d-flex align-items-center"></div>
                    </div>

                </div>
            </div>
            <button type="button" id="add-logo" class="btn btn-primary btn-block">Agregar otra imagen</button>
        </div>

        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-2">Rubros y subrubros</h6>
            <div class="col-12">
                <div id="sucursales-rubros-container" class="mt-4"></div>
            </div>
        </div>
        <br>

        <div class="d-flex justify-content-between form-actions">
            <a href="{{ route('admin.vouchers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success" id="btn_guardar">Guardar</button>
        </div>
        <br>
    </form>
</div>

<script id="modalidades-campos-json" type="application/json">
{!! $modalidadesCamposJson !!}
</script>
<script>
    const rubros = @json($rubros);
    const subrubros = @json($subrubros);

    const URL_SUCURSAL_RUBROS = "{{ route('admin.entidades.rubros_sucursales', ':id') }}";
</script>
@endsection

@push('scripts')
<script>
    const sucursales = @json($sucursales);

    $(document).on('change', '#f_ent_id', function () {
        const ent_id = $(this).val();
        const sucursalSelect = $('#f_domicilios');
        let txt_canje='';

        sucursalSelect.html('');
        // La entidad cambió, por lo tanto eliminamos
        // los bloques de las sucursales anteriores.
        $('#sucursales-rubros-container').empty();

        let str = '';

        $.each(sucursales, function (_, sucursal) {
            if (String(sucursal.ent_id) === String(ent_id)) {
                txt_canje = sucursal.ed_canje==0 ? ' - NO RECIBE CANJE' : ' - RECIBE CANJE';
                direccion = sucursal.ed_direccion+txt_canje;

                str += '<input type="checkbox" name="f_ed_id[]" id="f_ed_id-'+sucursal.ed_id+'" value="'+sucursal.ed_id+'" class="f_ed_id"> <label for="f_ed_id-'+sucursal.ed_id+'">'+direccion+'</label><br>';
            }
        });
        sucursalSelect.html(str);

        $('#f_telefonos').html('');
    });

    $(document).on('change', 'input[name="f_ed_id[]"]', function () {
        let telefonosHtml = '';

        // Recorremos solamente las sucursales seleccionadas
        $('input[name="f_ed_id[]"]:checked').each(function () {
            const ed_id = $(this).val();

            // Buscamos la sucursal dentro del array
            const sucursal = sucursales.find(function (item) {
                return String(item.ed_id) === String(ed_id);
            });

            // Verificamos que exista y tenga teléfono
            if (sucursal && sucursal.ed_telefono1) {
                telefonosHtml += `
                <div>
                    <input type="radio" name="f_telefono" id="f_telefono-${sucursal.ed_id}" value="${sucursal.ed_id}">
                    <label for="f_telefono-${sucursal.ed_id}">${sucursal.ed_telefono1} - ${sucursal.ed_direccion}</label>
                </div>
                `;
            }
        });

        $('#f_telefonos').html(telefonosHtml);
    });
</script>

<script>
    const modalidadesCampos = JSON.parse(document.getElementById('modalidades-campos-json').textContent || '{}');

    function addBanner() {
        const wrapper = document.getElementById('banners-wrapper');
        const div = document.createElement('div');
        div.className = 'banner-item mb-2';
        div.innerHTML = `
            <div class="row g-2 align-items-center">
                <div class="col-md-10">
                    <input type="file" name="banners[]" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger w-100" onclick="this.closest('.banner-item').remove()">Quitar</button>
                </div>
            </div>
        `;
        wrapper.appendChild(div);
    }

    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        return String(text)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function renderCampoInput(campo, oldValues = {}) {
        const value = oldValues[campo.mca_codigo] ?? '';
        const checked = oldValues[campo.mca_codigo] == 1 || oldValues[campo.mca_codigo] === '1';

        let html = '';

        if (campo.mca_tipo === 'number') {
            let inputType = 'number';

            if (campo.mca_tipo_numero=='VAR') {
                html = `
                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Monto minimo</label>
                    <input type="text" name="modalidad_valores[${campo.mca_id}][monto_minimo]" class="form-control mod_montos" placeholder="1" min="1" value="1">
                    <div class="form-text">Monto minimo a introducir por el cliente</div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Monto maximo</label>
                    <input type="text" name="modalidad_valores[${campo.mca_id}][monto_maximo]" class="form-control mod_montos" placeholder="10" min="10" value="10">
                    <div class="form-text">Monto maximo a introducir por el cliente</div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Stock</label>
                    <input type="text" name="modalidad_valores[${campo.mca_id}][stock]" class="form-control mod_stock" placeholder="1" min="1" value="1">
                    <div class="form-text">Stock de vouchers para este boton</div>
                </div>
                `;
            } else if (campo.mca_tipo_numero=='FIJ') {
                html = `
                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Monto total</label>
                    <input type="text" name="modalidad_valores[${campo.mca_id}][monto_total]" class="form-control mod_montos" placeholder="1" min="1" value="1">
                    <div class="form-text">Monto total a pagar por el cliente</div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Stock</label>
                    <input type="text" name="modalidad_valores[${campo.mca_id}][stock]" class="form-control mod_stock" placeholder="1" min="1" value="1">
                    <div class="form-text">Stock de vouchers para este boton</div>
                </div>
                `;
            }
            else {
                html = ``;
            }
        } else if (campo.mca_tipo === 'button') {
            html = `
                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Monto para boton #${campo.mca_orden}</label>
                    <input type="text" name="modalidad_valores[${campo.mca_id}][monto_total]" class="form-control mod_montos" placeholder="1" min="1" value="1">
                    <div class="form-text">Monto a seleccionar para pagar por el cliente</div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Stock para boton #${campo.mca_orden}</label>
                    <input type="text" name="modalidad_valores[${campo.mca_id}][stock]" class="form-control mod_stock" placeholder="1" min="1" value="1">
                    <div class="form-text">Stock de vouchers para este boton</div>
                </div>
            `;
        }

        return html;
    }

    function renderModalidadCampos(modalidadId) {
        const container = document.getElementById('modalidad-campos-container');
        const oldValues = @json(old('modalidad_valores', []));

        if (!modalidadId || !modalidadesCampos[modalidadId] || !modalidadesCampos[modalidadId].length) {
            container.innerHTML = `
                <div id="modalidad-empty-state" class="text-muted small">
                    Esta modalidad no tiene campos configurados.
                </div>
            `;
            return;
        }

        const campos = modalidadesCampos[modalidadId];

        container.innerHTML = `
            <div class="row g-3">
                ${campos.map(campo => renderCampoInput(campo, oldValues)).join('')}
            </div>
        `;


        $('.mod_montos').each(function () {
            $(this).rules('remove');
        });

        $('.mod_stock').each(function () {
            $(this).rules('remove');
        });

        $('.mod_montos').each(function () {
            $(this).rules('add', {
                required: true,
                digits: true,
                min: 1,
                messages: {
                    required: 'Este campo es obligatorio.',
                    digits: 'Ingrese únicamente números enteros.'
                }
            });
        });

        $('.mod_stock').each(function () {
            $(this).rules('add', {
                required: true,
                digits: true,
                min: 0,
                messages: {
                    required: 'Este campo es obligatorio.',
                    digits: 'Ingrese únicamente números enteros.'
                }
            });
        });
    }

    function addEtiquetaExistente(button) {
        const id = button.dataset.id;
        const name = button.dataset.name;
        const container = document.getElementById('selected-etiquetas');

        if (document.getElementById('tag-selected-' + id)) {
            return;
        }

        const badge = document.createElement('div');
        badge.className = 'badge bg-primary d-flex align-items-center gap-2';
        badge.id = 'tag-selected-' + id;
        badge.innerHTML = `
            <span>${name}</span>
            <button type="button" class="btn-close btn-close-white btn-sm" aria-label="Quitar"></button>
            <input type="hidden" name="etiquetas[]" value="${id}">
        `;

        badge.querySelector('button').addEventListener('click', function () {
            badge.remove();
        });

        container.appendChild(badge);
    }

    function agregarNuevaEtiqueta() {
        const input = document.getElementById('nueva-etiqueta-input');
        const nombre = input.value.trim();
        const container = document.getElementById('selected-etiquetas');

        if (!nombre) return;

        const uniqueId = 'new-' + Date.now();

        const badge = document.createElement('div');
        badge.className = 'badge bg-success d-flex align-items-center gap-2';
        badge.id = 'tag-selected-' + uniqueId;
        badge.innerHTML = `
            <span>${nombre}</span>
            <button type="button" class="btn-close btn-close-white btn-sm" aria-label="Quitar"></button>
            <input type="hidden" name="etiquetas_nuevas[]" value="${nombre}">
        `;

        badge.querySelector('button').addEventListener('click', function () {
            badge.remove();
        });

        container.appendChild(badge);
        input.value = '';
    }

    function condiciones_modalidades(mod_id) {
        // 
        let dataString = 'mod_id='+mod_id;
        $.ajax({
            type: 'GET',
            url: '/admin/vouchers/tipos_modalidades',
            data: dataString,
            beforeSend: function() {},
            complete: function() {},
            success: function(response) {
                $('#f_mod_condiciones').html(response.body);
                $('#f_condiciones').val(response.body);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modalidadSelect = document.getElementById('f_mod_id');

        modalidadSelect.addEventListener('change', function () {
            renderModalidadCampos(this.value);
            // condiciones_modalidades(this.value)
        });

        if (modalidadSelect.value) {
            renderModalidadCampos(modalidadSelect.value);
        }
    });
</script>

<script>
$(document).ready(function () {
    let fpFechaFin = $("#f_fecha_fin_lab").flatpickr({
        dateFormat: "d/m/Y",
        altInput: false,
        locale: "es",
        onChange: function (selectedDates) {
            let fecha = selectedDates[0];

            if (fecha) {
                let yyyy = fecha.getFullYear();
                let mm = String(fecha.getMonth() + 1).padStart(2, '0');
                let dd = String(fecha.getDate()).padStart(2, '0');

                $("#f_fecha_fin").val(`${yyyy}-${mm}-${dd}`);

                fpFechaIni.set("maxDate", fecha);

                let fechaIniSeleccionada = fpFechaIni.selectedDates[0];
                if (fechaIniSeleccionada && fechaIniSeleccionada > fecha) {
                    fpFechaIni.clear();
                    $("#f_fecha_ini").val("");
                }
            } else {
                $("#f_fecha_fin").val("");
            }
        }
    });

    let fpFechaIni = $("#f_fecha_ini_lab").flatpickr({
        dateFormat: "d/m/Y",
        altInput: false,
        locale: "es",
        onChange: function (selectedDates) {
            let fecha = selectedDates[0];

            if (fecha) {
                let yyyy = fecha.getFullYear();
                let mm = String(fecha.getMonth() + 1).padStart(2, '0');
                let dd = String(fecha.getDate()).padStart(2, '0');

                $("#f_fecha_ini").val(`${yyyy}-${mm}-${dd}`);

                // La fecha fin no puede ser menor a la fecha inicio
                fpFechaFin.set("minDate", fecha);

                // Si la fecha fin actual quedó inválida, la limpiamos
                let fechaFinSeleccionada = fpFechaFin.selectedDates[0];
                if (fechaFinSeleccionada && fechaFinSeleccionada < fecha) {
                    fpFechaFin.clear();
                    $("#f_fecha_fin").val("");
                }
            } else {
                $("#f_fecha_ini").val("");
                fpFechaFin.set("minDate", null);
            }
        }
    });

    $('#add-logo').on('click', function () {

        let html = `
            <div class="row logo-item mb-2">
                <div class="col-sm-11">
                    <input type="file" name="imagenes[]" accept="image/*" class="form-control">
                </div>
                <div class="col-sm-1 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-logo">X</button>
                </div>
            </div>
        `;

        $('#logos-container').append(html);
    });

    $(document).on('click', '.remove-logo', function () {
        $(this).closest('.logo-item').remove();
    });

    $(document).on('change', '#f_mod_id', function () {
        let condiciones = $(this).find('option:selected').data('condiciones') || '';
        condiciones = $.trim(condiciones);

        if (condiciones !== '') {

            let items = condiciones
                .split('#|#')
                .map(item => $.trim(item))
                .filter(item => item !== '');

            let html = '';

            $.each(items, function(index, item) {
                item = item.replace(/<<FECHA_INICIO>>/g, '<<FECHA_ACTUAL>>');
                item = item.replace(/<<FECHA_FIN>>/g, '<<FECHA_VENCIMIENTO>>');
                item = item.replace(/<<SUCURSALES>>/g, '<<SUCURSALES>>');

                html += item + ';;';
            });

            $('#vou_modalidad_condiciones').val(html);

            actualizar_preview_condiciones()

        } else {
            $('#vou_modalidad_condiciones').html('');
        }

    });

    function actualizar_preview_condiciones() {
        let texto = $('#vou_modalidad_condiciones').val();

        // Escapar HTML
        texto = $('<div>').text(texto).html();

        // Resaltar variables
        texto = texto.replace(/&lt;&lt;FECHA_ACTUAL&gt;&gt;/g, '<span class="variable-condicion">FECHA ACTUAL</span>');
        texto = texto.replace(/&lt;&lt;FECHA_VENCIMIENTO&gt;&gt;/g, '<span class="variable-condicion">FECHA VENCIMIENTO</span>');
        texto = texto.replace(/&lt;&lt;SUCURSALES&gt;&gt;/g, '<span class="variable-condicion">SUCURSALES</span>');

        // Separar condiciones
        let condiciones = texto.split(';;');

        let html = '<ul>';
        condiciones.forEach(function (condicion) {
            condicion = condicion.trim();

            if (condicion !== '') {
                html += '<li>' + condicion + '</li>';
            }
        });
        html += '</ul>';

        $('#preview-condiciones').html(html);
    }

    $('#vou_modalidad_condiciones').on('input', function () {
        actualizar_preview_condiciones();
    });

    if ($('#vou_modalidad_condiciones').val()!='') {
        actualizar_preview_condiciones();
    }

});
</script>

<script>
$(document).on('change', '.f_ed_id', function () {
    const edId = Number($(this).val());

    if ($(this).is(':checked')) {
        cargarRubrosSucursal(edId);
    } else {
        eliminarBloqueSucursal(edId);
    }

});

function cargarRubrosSucursal(edId) {

    // Si ya existe, no volver a cargar
    if ($(`.sucursal[data-ed-id="${edId}"]`).length) {
        return;
    }

    let url = `{{ route('admin.entidades.rubros_sucursales', ':edId') }}`;
    url = url.replace(':edId', edId);

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        beforeSend: function () {},
        success: function (response) {
            agregarBloqueSucursal(edId, response.rubros, response.subrubros);
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            $(`#f_ed_id-${edId}`).prop('checked', false);
        }
    });
}

function agregarBloqueSucursal(edId, rubrosSeleccionados = [], subrubrosSeleccionados = []) {

    if ($(`.sucursal[data-ed-id="${edId}"]`).length) {
        return;
    }

    const sucursal = sucursales.find(
        item => Number(item.ed_id) === Number(edId)
    );

    if (!sucursal) {
        return;
    }

    rubrosSeleccionados = normalizarRubros(rubrosSeleccionados);

    subrubrosSeleccionados = normalizarSubrubros(subrubrosSeleccionados);

    const html = `
    <div class="sucursal mb-4" data-ed-id="${sucursal.ed_id}" data-selected-rubros='${jsonToAttribute(rubrosSeleccionados)}' data-selected-subrubros='${jsonToAttribute(subrubrosSeleccionados)}'>

        <input type="hidden" name="sucursales[${sucursal.ed_id}][ed_id]" value="${sucursal.ed_id}">
        <div class="card card-custom p-3 mb-3 rubros-card">

            <h6 class="fw-bold mb-2">${escapeHtml(sucursal.ed_direccion)}</h6>
            <p class="text-muted small mb-3">
                Seleccioná los rubros y subrubros asociados a esta sucursal.
            </p>
            <div class="mb-3">
                <label class="form-label fw-semibold">Rubros disponibles</label>
                <div class="rubros-available-box">
                    ${generarRubrosDisponibles()}
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Rubros seleccionados</label>
                <div class="rubros-selected-box selected-rubros"></div>
                <div class="rubros-hidden-inputs"></div>
            </div>
            <div>
                <label class="form-label fw-semibold">Subrubros disponibles</label>
                <div class="subrubros-available-box">
                    ${generarSubrubrosDisponibles()}
                </div>
            </div>
            <div class="mt-3">
                <label class="form-label fw-semibold">Subrubros seleccionados</label>
                <div class="subrubros-selected-box selected-subrubros"></div>
                <div class="subrubros-hidden-inputs"></div>
            </div>
        </div>
    </div>
    `;

    $('#sucursales-rubros-container').append(html);

    const $sucursal =$(`.sucursal[data-ed-id="${edId}"]`);

    renderSucursal($sucursal);
}

function generarRubrosDisponibles() {

    let html = '';

    $.each(rubros, function (id, nombre) {

        html += `
            <button
                type="button"
                class="rubro-option"
                data-id="${id}"
                data-name="${escapeHtml(nombre)}"
            >
                ${escapeHtml(nombre)}
            </button>
        `;
    });

    return html;
}

function generarSubrubrosDisponibles() {

    let html = '';

    $.each(subrubros, function (_, subrubro) {

        html += `
            <button
                type="button"
                class="subrubro-option"
                data-id="${subrubro.sub_id}"
                data-rub-id="${subrubro.rub_id}"
                data-name="${escapeHtml(subrubro.sub_nombre)}"
            >
                ${escapeHtml(subrubro.sub_nombre)}
            </button>
        `;
    });

    return html;
}

function getSelectedRubros($sucursal) {

    let data = $sucursal.attr('data-selected-rubros');

    if (!data) {
        return [];
    }

    try {
        return JSON.parse(data);
    } catch (e) {
        return [];
    }
}

function setSelectedRubros($sucursal, data) {

    $sucursal.attr(
        'data-selected-rubros',
        JSON.stringify(data)
    );
}

function getSelectedSubrubros($sucursal) {

    let data = $sucursal.attr('data-selected-subrubros');

    if (!data) {
        return [];
    }

    try {
        return JSON.parse(data);
    } catch (e) {
        return [];
    }
}

function setSelectedSubrubros($sucursal, data) {

    $sucursal.attr(
        'data-selected-subrubros',
        JSON.stringify(data)
    );
}

function jsonToAttribute(data) {

    return escapeHtml(JSON.stringify(data));
}

$(document).on('click', '.rubro-option', function () {

    const $button = $(this);

    if ($button.hasClass('is-disabled')) {
        return;
    }

    const $sucursal = $button.closest('.sucursal');

    const id = Number($button.data('id'));
    const name = $button.data('name');

    let seleccionados = getSelectedRubros($sucursal);

    if (
        seleccionados.some(
            rubro => Number(rubro.id) === id
        )
    ) {
        return;
    }

    seleccionados.push({
        id: id,
        name: name
    });

    setSelectedRubros(
        $sucursal,
        seleccionados
    );

    renderSucursal($sucursal);
});

$(document).on('click', '.rubro-remove-btn', function () {

    const $sucursal = $(this).closest('.sucursal');

    const rubroId = Number(
        $(this).data('id')
    );

    let rubrosSeleccionados =
        getSelectedRubros($sucursal);

    rubrosSeleccionados =
        rubrosSeleccionados.filter(
            rubro => Number(rubro.id) !== rubroId
        );

    setSelectedRubros(
        $sucursal,
        rubrosSeleccionados
    );

    /*
     * Si eliminamos un rubro también eliminamos
     * automáticamente sus subrubros.
     */
    let subrubrosSeleccionados =
        getSelectedSubrubros($sucursal);

    subrubrosSeleccionados =
        subrubrosSeleccionados.filter(
            sub => Number(sub.rub_id) !== rubroId
        );

    setSelectedSubrubros(
        $sucursal,
        subrubrosSeleccionados
    );

    renderSucursal($sucursal);
});

$(document).on('click', '.subrubro-option', function () {

    const $button = $(this);

    if ($button.hasClass('is-disabled')) {
        return;
    }

    const $sucursal = $button.closest('.sucursal');

    const id = Number($button.data('id'));
    const rubId = Number($button.data('rub-id'));
    const name = $button.data('name');

    const rubrosSeleccionados =
        getSelectedRubros($sucursal);

    /*
     * El subrubro solamente se puede seleccionar
     * si su rubro está seleccionado.
     */
    const existeRubro =
        rubrosSeleccionados.some(
            rubro => Number(rubro.id) === rubId
        );

    if (!existeRubro) {
        return;
    }

    let subrubrosSeleccionados =
        getSelectedSubrubros($sucursal);

    if (
        subrubrosSeleccionados.some(
            sub => Number(sub.id) === id
        )
    ) {
        return;
    }

    subrubrosSeleccionados.push({
        id: id,
        name: name,
        rub_id: rubId
    });

    setSelectedSubrubros(
        $sucursal,
        subrubrosSeleccionados
    );

    renderSucursal($sucursal);
});

$(document).on('click', '.subrubro-remove-btn', function () {

    const $sucursal = $(this).closest('.sucursal');

    const subrubroId = Number(
        $(this).data('id')
    );

    let seleccionados =
        getSelectedSubrubros($sucursal);

    seleccionados =
        seleccionados.filter(
            sub => Number(sub.id) !== subrubroId
        );

    setSelectedSubrubros(
        $sucursal,
        seleccionados
    );

    renderSucursal($sucursal);
});

function renderSelectedRubros($sucursal) {

    const edId = $sucursal.data('ed-id');

    const $selectedBox =
        $sucursal.find('.selected-rubros');

    const $hiddenInputs =
        $sucursal.find('.rubros-hidden-inputs');

    const seleccionados =
        getSelectedRubros($sucursal);

    $selectedBox.empty();
    $hiddenInputs.empty();

    if (!seleccionados.length) {

        $selectedBox.html(`
            <span class="rubros-empty-text">
                No hay rubros seleccionados.
            </span>
        `);

        return;
    }

    $.each(seleccionados, function (_, rubro) {

        $selectedBox.append(`
            <span class="rubro-selected">

                <span>
                    ${escapeHtml(rubro.name)}
                </span>

                <button
                    type="button"
                    class="rubro-remove-btn"
                    data-id="${rubro.id}"
                >
                    &times;
                </button>

            </span>
        `);

        $hiddenInputs.append(`
            <input
                type="hidden"
                name="sucursales[${edId}][rubros][]"
                value="${rubro.id}"
            >
        `);
    });
}

function renderSelectedSubrubros($sucursal) {

    const edId = $sucursal.data('ed-id');

    const $selectedBox =
        $sucursal.find('.selected-subrubros');

    const $hiddenInputs =
        $sucursal.find('.subrubros-hidden-inputs');

    const seleccionados =
        getSelectedSubrubros($sucursal);

    $selectedBox.empty();
    $hiddenInputs.empty();

    if (!seleccionados.length) {

        $selectedBox.html(`
            <span class="subrubros-empty-text">
                No hay subrubros seleccionados.
            </span>
        `);

        return;
    }

    $.each(seleccionados, function (_, subrubro) {

        $selectedBox.append(`
            <span class="subrubro-selected">

                <span>
                    ${escapeHtml(subrubro.name)}
                </span>

                <button
                    type="button"
                    class="subrubro-remove-btn"
                    data-id="${subrubro.id}"
                >
                    &times;
                </button>

            </span>
        `);

        $hiddenInputs.append(`
            <input
                type="hidden"
                name="sucursales[${edId}][subrubros][]"
                value="${subrubro.id}"
            >
        `);
    });
}

function updateAvailableRubrosState($sucursal) {

    const seleccionados =
        getSelectedRubros($sucursal)
            .map(rubro => Number(rubro.id));

    $sucursal.find('.rubro-option').each(function () {

        const id = Number($(this).data('id'));

        $(this).toggleClass(
            'is-disabled',
            seleccionados.includes(id)
        );
    });
}

function updateAvailableSubrubrosState($sucursal) {

    const rubrosSeleccionados =
        getSelectedRubros($sucursal)
            .map(rubro => Number(rubro.id));

    const subrubrosSeleccionados =
        getSelectedSubrubros($sucursal)
            .map(sub => Number(sub.id));

    $sucursal.find('.subrubro-option').each(function () {

        const $button = $(this);

        const subId =
            Number($button.data('id'));

        const rubId =
            Number($button.data('rub-id'));

        const seleccionado =
            subrubrosSeleccionados.includes(subId);

        const rubroHabilitado =
            rubrosSeleccionados.includes(rubId);

        $button.toggleClass(
            'is-disabled',
            seleccionado || !rubroHabilitado
        );
    });
}

function renderSucursal($sucursal) {

    sanitizarSubrubros($sucursal);

    renderSelectedRubros($sucursal);

    renderSelectedSubrubros($sucursal);

    updateAvailableRubrosState($sucursal);

    updateAvailableSubrubrosState($sucursal);
}

function sanitizarSubrubros($sucursal) {

    const rubrosSeleccionados =
        getSelectedRubros($sucursal)
            .map(rubro => Number(rubro.id));

    let subrubrosSeleccionados =
        getSelectedSubrubros($sucursal);

    subrubrosSeleccionados =
        subrubrosSeleccionados.filter(function (sub) {

            return rubrosSeleccionados.includes(
                Number(sub.rub_id)
            );
        });

    setSelectedSubrubros(
        $sucursal,
        subrubrosSeleccionados
    );
}

function eliminarBloqueSucursal(edId) {

    $(`.sucursal[data-ed-id="${edId}"]`).remove();
}

function normalizarRubros(items) {
    return $.map(items, function (item) {

        return {
            id: Number(item.rub_id),
            name: item.rub_nombre
        };
    });
}

function normalizarSubrubros(items) {
    return $.map(items, function (item) {

        return {
            id: Number(item.sub_id),
            rub_id: Number(item.rub_id),
            name: item.sub_nombre
        };
    });
}
</script>

@endpush