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
                required: true,
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

                    @error('f_nombre')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
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
                    @error('f_ent_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Sucursal:</label>
                    {{-- <select name="f_ed_id[]" id="f_ed_id" class="form-select field-required" multiple size="2">
                        <option value="">Selecciona la sucursal</option>
                    </select> --}}
                    <div id="f_domicilios"></div>
                    @error('f_ed_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
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
                    @error('f_inf_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
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
                    @error('f_cv_id')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label required-label">Fecha de inicio:</label>
                        <input type="text" name="f_fecha_ini_lab" id="f_fecha_ini_lab" class="form-control field-required" value="{{ old('f_fecha_ini_lab') }}" placeholder="dd/mm/yyyy">
                        <input type="hidden" name="f_fecha_ini" id="f_fecha_ini" value="{{ old('f_fecha_ini') }}">

                        @error('f_fecha_ini')
                            <div class="text-required">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label required-label">Fecha de fin:</label>
                        <input type="text" name="f_fecha_fin_lab" id="f_fecha_fin_lab" class="form-control field-required" value="{{ old('f_fecha_fin_lab') }}" placeholder="dd/mm/yyyy">
                        <input type="hidden" name="f_fecha_fin" id="f_fecha_fin" value="{{ old('f_fecha_fin') }}">

                        @error('f_fecha_fin')
                            <div class="text-required">{{ $message }}</div>
                        @enderror
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

                    @error('f_vigencia')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Stock:</label>
                    <input type="text" name="stock" class="form-control field-required" value="{{ old('stock') }}" placeholder="0">

                    @error('stock')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Porcentaje comisi&oacute;n:</label>
                    <input type="text" name="f_comision" class="form-control field-required" value="{{ old('f_comision') }}" placeholder="0">

                    @error('f_comision')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
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
                    <textarea id="description" name="description" rows="4" class="form-control voucher-textarea" placeholder="Descripción&#10;Incluye una descripción detallada del voucher.">{{ old('description') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Términos y condiciones:</label>
                    <textarea id="terms" name="terms" rows="4" class="form-control voucher-textarea" placeholder="Términos y condiciones&#10;Incluye aquí los términos y condiciones para este voucher (opcional).">{{ old('terms') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Observaciones internas</label>
                    <textarea name="observaciones" class="form-control" rows="3" placeholder="Notas internas o descripción opcional...">{{ old('observaciones') }}</textarea>

                    @error('observaciones')
                        <div class="text-required">{{ $message }}</div>
                    @enderror
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
                        <option value="{{ $modalidad->mod_id }}" {{ old('f_mod_id') == $modalidad->mod_id ? 'selected' : '' }}>
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
                <p id="f_mod_condiciones"></p>
                <input type="hidden" name="f_condiciones" name="f_condiciones" value="">
                <textarea id="f_condiciones_adi" name="f_condiciones_adi" class="form-control voucher-textarea" placeholder="">***</textarea>
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
                        <div class="col-sm-8">
                            <input type="file" name="imagenes[]" accept="image/*" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <select name="f_tipo_archivo_id[]" id="f_tipo_archivo_id" class="form-select field-required">
                                <option value="">Selecciona el tipo de archivo</option>
                                @foreach($tipos_archivos as $tipo)
                                    <option value="{{ $tipo['tipo_archivo_id'] }}" {{ old('f_tipo_archivo_id') == $tipo['tipo_archivo_id'] ? 'selected' : '' }}>
                                        {{ $tipo['tipo_archivo_nombre'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1 d-flex align-items-center"></div>
                    </div>

                </div>
            </div>
            <button type="button" id="add-logo" class="btn btn-primary btn-block">Agregar otro logo</button>
        </div>

        {{-- RUBROS Y SUBRUBROS (tienen que ser variables y uno por sucursal seleccionada) --}}
        {{-- <div class="vch-card p-3 mb-3 card-custom rubros-card">
            <h6 class="fw-bold mb-2">Rubros y subrubros</h6>
            <p class="text-muted small mb-3">
                Seleccioná uno o más rubros para esta sucursal y luego elegí los subrubros correspondientes.
            </p>

            <div class="mb-3">
                <label class="form-label fw-semibold">Rubros disponibles</label>
                <div class="rubros-available-box">
                    @foreach($rubros as $id => $nombre)
                        <button type="button" class="rubro-option" data-id="{{ $id }}" data-name="{{ $nombre }}" onclick="addRubroFromOption(this)">
                            {{ $nombre }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Rubros seleccionados</label>
                <div class="rubros-selected-box selected-rubros">
                    <span class="rubros-empty-text">No hay rubros seleccionados.</span>
                </div>
                <div class="rubros-hidden-inputs"></div>
            </div>

            <div>
                <label class="form-label fw-semibold">Subrubros disponibles</label>
                <div class="subrubros-available-box">
                    @foreach($subrubros as $subrubro)
                        <button type="button" class="subrubro-option" data-id="{{ $subrubro['sub_id'] }}" data-rub-id="{{ $subrubro['rub_id'] }}" data-name="{{ $subrubro['sub_nombre'] }}" onclick="addSubrubroFromOption(this)">
                            {{ $subrubro['sub_nombre'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label fw-semibold">Subrubros seleccionados</label>
                <div class="subrubros-selected-box selected-subrubros">
                    <span class="subrubros-empty-text">No hay subrubros seleccionados.</span>
                </div>
                <div class="subrubros-hidden-inputs"></div>
            </div>
        </div> --}}

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
@endsection

@push('scripts')
<script>
    const sucursales = @json($sucursales);

    $(document).on('change', '#f_ent_id', function () {
        const ent_id = $(this).val();
        const sucursalSelect = $('#f_domicilios');
        let txt_canje='';

        // sucursalSelect.html('<option value="">Selecciona la sucursal</option>');
        sucursalSelect.html('');
        let str = '';

        $.each(sucursales, function (_, sucursal) {
            if (String(sucursal.ent_id) === String(ent_id)) {
                txt_canje = sucursal.ed_canje==0 ? ' - NO RECIBE CANJE' : ' - RECIBE CANJE';
                direccion = sucursal.ed_direccion+txt_canje;
                // sucursalSelect.append(
                //     $('<option>', {
                //         value: sucursal.ed_id,
                //         text: sucursal.ed_direccion+txt_canje
                //     })
                // );
                str += '<input type="checkbox" name="f_ed_id[]" id="f_ed_id-'+sucursal.ed_id+'" value="'+sucursal.ed_id+'"> <label for="f_ed_id-'+sucursal.ed_id+'">'+direccion+'</label><br>';
            }
        });
        // console.log(str)
        sucursalSelect.html(str);
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

        // if (campo.mca_tipo === 'textarea') {
        //     html = `
        //         <textarea
        //             name="modalidad_valores[${campo.mca_codigo}]"
        //             class="form-control"
        //             rows="3"
        //             placeholder="${escapeHtml(campo.mca_placeholder || '')}"
        //             ${campo.mca_requerido ? 'required' : ''}
        //         >${escapeHtml(value)}</textarea>
        //     `;
        // } else if (campo.mca_tipo === 'select') {
        //     const opciones = (campo.mca_opciones || '')
        //         .split(',')
        //         .map(item => item.trim())
        //         .filter(item => item !== '');

        //     html = `
        //         <select
        //             name="modalidad_valores[${campo.mca_codigo}]"
        //             class="form-select"
        //             ${campo.mca_requerido ? 'required' : ''}
        //         >
        //             <option value="">Seleccionar...</option>
        //             ${opciones.map(opcion => `
        //                 <option value="${escapeHtml(opcion)}" ${value == opcion ? 'selected' : ''}>
        //                     ${escapeHtml(opcion)}
        //                 </option>
        //             `).join('')}
        //         </select>
        //     `;
        // } else if (campo.mca_tipo === 'boolean') {
        //     html = `
        //         <div class="form-check form-switch mt-2">
        //             <input
        //                 class="form-check-input"
        //                 type="checkbox"
        //                 name="modalidad_valores[${campo.mca_codigo}]"
        //                 value="1"
        //                 ${checked ? 'checked' : ''}
        //             >
        //             <label class="form-check-label">Sí</label>
        //         </div>
        //     `;
        // } else {
        //     let inputType = 'text';

        //     if (campo.mca_tipo === 'number') inputType = 'number';
        //     if (campo.mca_tipo === 'decimal' || campo.mca_tipo === 'money') inputType = 'number';

        //     const step = (campo.mca_tipo === 'decimal' || campo.mca_tipo === 'money') ? 'step="0.01"' : '';

        //     html = `
        //         <input
        //             type="${inputType}"
        //             name="modalidad_valores[${campo.mca_codigo}]"
        //             class="form-control"
        //             value="${escapeHtml(value)}"
        //             placeholder="${escapeHtml(campo.mca_placeholder || '')}"
        //             ${step}
        //             ${campo.mca_requerido ? 'required' : ''}
        //         >
        //     `;
        // }

        if (campo.mca_tipo === 'number') {
            let inputType = 'number';

            if (campo.mca_tipo_numero=='VAR') {
                html = `
                    <div class="col-12 col-md-6">
                        <label class="form-label required-label">Monto minimo</label>
                        <input type="text" name="modalidad_valores[${campo.mca_id}][monto_minimo]" class="form-control" placeholder="1.01" min="1" value="1">
                        <div class="form-text">Monto minimo a introducir por el cliente</div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label required-label">Monto maximo</label>
                        <input type="text" name="modalidad_valores[${campo.mca_id}][monto_maximo]" class="form-control" placeholder="10.01" min="10" value="10">
                        <div class="form-text">Monto maximo a introducir por el cliente</div>
                    </div>
                `;
            } else if (campo.mca_tipo_numero=='FIJ') {
                html = `
                    <div class="col-12 col-md-6">
                        <label class="form-label required-label">Monto total</label>
                        <input type="text" name="modalidad_valores[${campo.mca_id}][monto_total]" class="form-control" placeholder="1.01" min="1" value="1">
                        <div class="form-text">Monto total a pagar por el cliente</div>
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
                    <input type="text" name="modalidad_valores[${campo.mca_id}][monto_total]" class="form-control" placeholder="1.01" min="1" value="1">
                    <div class="form-text">Monto a seleccionar para pagar por el cliente</div>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label required-label">Stock para boton #${campo.mca_orden}</label>
                    <input type="text" name="modalidad_valores[${campo.mca_id}][stock]" class="form-control" placeholder="1.01" min="1" value="1">
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
            condiciones_modalidades(this.value)
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

                    fpFechaIni[0].set("maxDate", fecha);

                    let fechaIniSeleccionada = fpFechaIni[0].selectedDates[0];
                    if (fechaIniSeleccionada && fechaIniSeleccionada > fecha) {
                        fpFechaIni[0].clear();
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
                    fpFechaFin[0].set("minDate", fecha);

                    // Si la fecha fin actual quedó inválida, la limpiamos
                    let fechaFinSeleccionada = fpFechaFin[0].selectedDates[0];
                    if (fechaFinSeleccionada && fechaFinSeleccionada < fecha) {
                        fpFechaFin[0].clear();
                        $("#f_fecha_fin").val("");
                    }
                } else {
                    $("#f_fecha_ini").val("");
                    fpFechaFin[0].set("minDate", null);
                }
            }
        });

        $('#add-logo').on('click', function () {

            let html = `
                <div class="row logo-item mb-2">
                    <div class="col-sm-8">
                        <input type="file" name="imagenes[]" accept="image/*" class="form-control">
                    </div>
                    <div class="col-sm-3">
                        <select name="f_tipo_archivo_id[]" id="f_tipo_archivo_id" class="form-select field-required">
                            <option value="">Selecciona el tipo de archivo</option>
                            @foreach($tipos_archivos as $tipo)
                                <option value="{{ $tipo['tipo_archivo_id'] }}" {{ old('f_tipo_archivo_id') == $tipo['tipo_archivo_id'] ? 'selected' : '' }}>
                                    {{ $tipo['tipo_archivo_nombre'] }}
                                </option>
                            @endforeach
                        </select>
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
    });
</script>

{{-- <script>
function getSucursalIndex(sucursal) {
    return sucursal.getAttribute('data-index');
}

function updateAvailableRubrosState(sucursal) {
    const selectedRubros = getSelectedRubros(sucursal);
    const buttons = sucursal.querySelectorAll('.rubro-option');

    buttons.forEach(button => {
        const id = Number(button.dataset.id);
        const isSelected = selectedRubros.some(rubro => rubro.id === id);
        button.classList.toggle('is-disabled', isSelected);
    });
}

function updateAvailableSubrubrosState(sucursal) {
    const selectedRubros = getSelectedRubros(sucursal).map(item => item.id);
    const selectedSubrubros = getSelectedSubrubros(sucursal);
    const buttons = sucursal.querySelectorAll('.subrubro-option');

    buttons.forEach(button => {
        const subId = Number(button.dataset.id);
        const rubId = Number(button.dataset.rubId);
        const isSelected = selectedSubrubros.some(sub => sub.id === subId);
        const rubroHabilitado = selectedRubros.includes(rubId);

        button.classList.toggle('is-disabled', isSelected || !rubroHabilitado);
    });
}

function getSelectedRubros(sucursal) {
    return JSON.parse(sucursal.dataset.selectedRubros || '[]');
}

function setSelectedRubros(sucursal, data) {
    sucursal.dataset.selectedRubros = JSON.stringify(data);
}

function getSelectedSubrubros(sucursal) {
    return JSON.parse(sucursal.dataset.selectedSubrubros || '[]');
}

function setSelectedSubrubros(sucursal, data) {
    sucursal.dataset.selectedSubrubros = JSON.stringify(data);
}

function renderSelectedRubros(sucursal) {
    const index = getSucursalIndex(sucursal);
    const selectedBox = sucursal.querySelector('.selected-rubros');
    const hiddenInputs = sucursal.querySelector('.rubros-hidden-inputs');
    const selectedRubros = getSelectedRubros(sucursal);

    selectedBox.innerHTML = '';
    hiddenInputs.innerHTML = '';

    if (selectedRubros.length === 0) {
        selectedBox.innerHTML = '<span class="rubros-empty-text">No hay rubros seleccionados.</span>';
    } else {
        selectedRubros.forEach(rubro => {
            const chip = document.createElement('span');
            chip.className = 'rubro-selected';
            chip.innerHTML = `
                <span>${rubro.name}</span>
                <button type="button" class="rubro-remove-btn" onclick="removeRubro(this, ${rubro.id})">&times;</button>
            `;
            selectedBox.appendChild(chip);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `sucursales[${index}][rubros][]`;
            input.value = rubro.id;
            hiddenInputs.appendChild(input);
        });
    }

    sanitizeSubrubrosByRubros(sucursal);
    updateAvailableRubrosState(sucursal);
    updateAvailableSubrubrosState(sucursal);
}

function renderSelectedSubrubros(sucursal) {
    const index = getSucursalIndex(sucursal);
    const selectedBox = sucursal.querySelector('.selected-subrubros');
    const hiddenInputs = sucursal.querySelector('.subrubros-hidden-inputs');
    const selectedSubrubros = getSelectedSubrubros(sucursal);

    selectedBox.innerHTML = '';
    hiddenInputs.innerHTML = '';

    if (selectedSubrubros.length === 0) {
        selectedBox.innerHTML = '<span class="subrubros-empty-text">No hay subrubros seleccionados.</span>';
    } else {
        selectedSubrubros.forEach(subrubro => {
            const chip = document.createElement('span');
            chip.className = 'subrubro-selected';
            chip.innerHTML = `
                <span>${subrubro.name}</span>
                <button type="button" class="subrubro-remove-btn" onclick="removeSubrubro(this, ${subrubro.id})">&times;</button>
            `;
            selectedBox.appendChild(chip);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `sucursales[${index}][subrubros][]`;
            input.value = subrubro.id;
            hiddenInputs.appendChild(input);
        });
    }

    updateAvailableSubrubrosState(sucursal);
}

function sanitizeSubrubrosByRubros(sucursal) {
    const selectedRubros = getSelectedRubros(sucursal).map(item => item.id);
    let selectedSubrubros = getSelectedSubrubros(sucursal);

    selectedSubrubros = selectedSubrubros.filter(subrubro =>
        selectedRubros.includes(Number(subrubro.rub_id))
    );

    setSelectedSubrubros(sucursal, selectedSubrubros);
    renderSelectedSubrubros(sucursal);
}

function addRubroFromOption(button) {
    const sucursal = button.closest('.sucursal');
    const selectedRubros = getSelectedRubros(sucursal);
    const id = Number(button.dataset.id);
    const name = button.dataset.name;

    if (selectedRubros.some(rubro => rubro.id === id)) {
        return;
    }

    selectedRubros.push({ id, name });
    setSelectedRubros(sucursal, selectedRubros);
    renderSelectedRubros(sucursal);
}

function removeRubro(button, rubroId) {
    const sucursal = button.closest('.sucursal');
    let selectedRubros = getSelectedRubros(sucursal);

    selectedRubros = selectedRubros.filter(rubro => rubro.id !== rubroId);
    setSelectedRubros(sucursal, selectedRubros);
    renderSelectedRubros(sucursal);
}

function addSubrubroFromOption(button) {
    const sucursal = button.closest('.sucursal');
    const selectedSubrubros = getSelectedSubrubros(sucursal);
    const selectedRubros = getSelectedRubros(sucursal).map(item => item.id);

    const id = Number(button.dataset.id);
    const name = button.dataset.name;
    const rubId = Number(button.dataset.rubId);

    if (!selectedRubros.includes(rubId)) {
        return;
    }

    if (selectedSubrubros.some(subrubro => subrubro.id === id)) {
        return;
    }

    selectedSubrubros.push({ id, name, rub_id: rubId });
    setSelectedSubrubros(sucursal, selectedSubrubros);
    renderSelectedSubrubros(sucursal);
}

function removeSubrubro(button, subrubroId) {
    const sucursal = button.closest('.sucursal');
    let selectedSubrubros = getSelectedSubrubros(sucursal);

    selectedSubrubros = selectedSubrubros.filter(subrubro => subrubro.id !== subrubroId);
    setSelectedSubrubros(sucursal, selectedSubrubros);
    renderSelectedSubrubros(sucursal);
}

function initSucursalState(sucursal) {
    if (!sucursal.dataset.selectedRubros) {
        setSelectedRubros(sucursal, []);
    }

    if (!sucursal.dataset.selectedSubrubros) {
        setSelectedSubrubros(sucursal, []);
    }

    renderSelectedRubros(sucursal);
    renderSelectedSubrubros(sucursal);
}
</script> --}}
@endpush