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

    .subrubro-remove-btn, .subrubro-nuevo-remove-btn, .subrubro-edit-btn {
        border: none;
        background: transparent;
        color: #fff;
        font-size: 1rem;
        line-height: 1;
        padding: 0;
        cursor: pointer;
        opacity: 0.9;
    }

    .subrubro-remove-btn:hover, .subrubro-nuevo-remove-btn:hover, .subrubro-edit-btn:hover {
        opacity: 1;
    }

    .subrubro-available-item { display: inline-flex; align-items: center; gap: 4px; border: 1px solid #d7e4ff; background: #eef4ff; border-radius: 999px; padding-right: 9px; }
    .subrubro-available-item .subrubro-option { border: 0; background: transparent; }
    .subrubro-available-item .subrubro-edit-btn { color: #2f6fed; padding: 5px; }
    .subrubro-edit-btn { display: inline-flex; align-items: center; justify-content: center; border: 0; background: transparent; cursor: pointer; }
    .subrubro-available-item .subrubro-option.is-disabled { pointer-events: none; }
</style>
@endpush

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
                text: "Se va a actualizar el registro",
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
            f_categoria: {
                required: true,
            },
            f_descripcion_corta: {
                required: false,
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

<main class="container">

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
            <h1 class="vch-title">Editar rubro</h1>
            <p class="vch-subtitle">Modifica los datos del rubro seleccionado.</p>
        </div>
    </section>

    <form method="POST" action="{{ route('admin.rubros.update', $rubro->rub_id) }}" id="form_main">
        @csrf
        @method('PUT')

        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-3">Datos del rubro</h6>

            <div class="row g-3">
                {{-- <div class="col-12">
                    <label class="form-label required-label">Codigo:</label>
                    <input type="text" name="f_codigo" class="form-control field-required" value="{{ old('f_codigo', $rubro->rub_codigo) }}">
                </div> --}}
                <div class="col-12">
                    <label class="form-label required-label">Nombre publico:</label>
                    <input type="text" name="f_nombre" class="form-control field-required" value="{{ old('f_nombre', $rubro->rub_nombre) }}">
                </div>
                <div class="col-12">
                    <label class="form-label required-label">Categoría:</label>
                    <select name="f_categoria" class="form-select">
                        <option value="">Selecciona una categoria</option>
                        @foreach($categorias as $id => $nombre)
                            <option value="{{ $id }}" {{ $rubro->cv_id==$id ? 'selected' : '' }}>{{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="col-12">
                    <label class="form-label required-label">Descripcion corta:</label>
                    <input type="text" name="f_descripcion_corta" class="form-control field-required" value="{{ old('f_descripcion_corta', $rubro->rub_descripcion_corta) }}" placeholder="Descripcion para el publico">
                </div> --}}
                <div class="col-12">
                    <label class="form-label required-label">Descripcion interna:</label>
                    <input type="text" name="f_descripcion" class="form-control field-required" value="{{ old('f_descripcion', $rubro->rub_descripcion) }}" placeholder="Descripcion precisa que no verá el publico pero servirá para la busqueda">
                </div>
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="f_publico" id="f_publico" value="1" {{ old('f_publico', $rubro->rub_publico) ? 'checked' : '' }}>
                        <label class="form-check-label" for="f_publico">Publico</label>
                    </div>
                </div>

            </div>
        </div>
        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-2">Subrubros</h6>

            <p class="text-muted small mb-3">
                Seleccioná subrubros existentes o creá nuevos para este rubro.
            </p>

            {{-- NUEVO SUBRUBRO --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Nuevo subrubro</label>
                <div class="d-flex gap-2">
                    <input type="text" id="nuevo-subrubro-input" class="form-control" placeholder="Ej: Café de especialidad">
                    <button type="button" class="btn btn-primary" onclick="agregarNuevoSubrubro()">Agregar</button>
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
                {{-- ORDEN --}}
                <div id="subrubros-orden-hidden-inputs"></div>
                <div id="subrubros-editados-hidden-inputs"></div>
            </div>

            {{-- DISPONIBLES --}}
            <div>
                <label class="form-label fw-semibold">Subrubros disponibles</label>
                <div class="subrubros-available-box">
                    @foreach($subrubrosDisponibles as $subrubro)
                        <span class="subrubro-available-item" data-id="{{ $subrubro->sub_id }}">
                            <button type="button" class="subrubro-option" data-id="{{ $subrubro->sub_id }}" data-name="{{ $subrubro->sub_nombre }}">{{ $subrubro->sub_nombre }}</button>
                            <button type="button" class="subrubro-edit-btn" data-tipo="existente" data-id="{{ $subrubro->sub_id }}" data-publico="{{ (int) $subrubro->sub_publico }}" aria-label="Editar subrubro" title="Editar subrubro"><i class="bi bi-pencil"></i><span class="visually-hidden">Editar</span></button>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-between form-actions">
            <button type="button" class="btn btn-danger" data-id="{{ $rubro->rub_id }}" data-url="{{ route('admin.rubros.delete', $rubro->rub_id) }}" id="btn_eliminar">Bloquear</button>
            <div>
                <a href="{{ route('admin.rubros.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success" id="btn_actualizar">Actualizar</button>
            </div>
        </div>
    </form>
    <div class="modal fade" id="modalEditarSubrubro" tabindex="-1" aria-labelledby="tituloEditarSubrubro" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloEditarSubrubro">Editar subrubro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <label for="editar-subrubro-nombre" class="form-label">Nombre del subrubro</label>
                    <input type="text" class="form-control" id="editar-subrubro-nombre" maxlength="255" autocomplete="off">
                    <div class="invalid-feedback">Ingresá un nombre válido.</div>
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="editar-subrubro-publico" value="1">
                        <label class="form-check-label" for="editar-subrubro-publico">Público</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="guardar-edicion-subrubro">Guardar cambio</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    let subrubrosExistentes = @json(old('subrubros', $subrubrosSeleccionados ?? []));
    let subrubrosNuevos = @json(old('subrubros_nuevos', []));
    let subrubrosEditados = @json(old('subrubros_editados', []));
    let subrubrosPublico = @json(old('subrubros_publico', []));
    let subrubrosNuevosPublico = @json(old('subrubros_nuevos_publico', []));
    const publicoInicial = {{ Illuminate\Support\Js::from(
        collect($subrubrosDisponibles)
            ->mapWithKeys(fn($s) => [
                $s->sub_id => (int) $s->sub_publico
            ])
            ->all()
    ) }};

    const publicoSeleccionados = {{ Illuminate\Support\Js::from(
        collect($subrubrosSeleccionados ?? [])
            ->mapWithKeys(fn($s) => [
                data_get($s, 'id') => (int) data_get($s, 'publico', 0)
            ])
            ->all()
    ) }};

    let edicionActual = null;
    const iconoLapiz = '<i class="bi bi-pencil"></i>';
    function nombreExistente(id) {
        const editado = subrubrosEditados[id];
        if (editado !== undefined) return editado;
        const item = subrubrosExistentes.find(x => Number(x.id) === Number(id));
        return item ? item.name : $('.subrubro-option').filter(function(){ return Number($(this).attr('data-id')) === Number(id); }).attr('data-name');
    }
    function escaparTexto(valor) { return $('<div>').text(valor ?? '').html(); }
    function actualizarEdicionesOcultas() {
        const box = $('#subrubros-editados-hidden-inputs').empty();
        Object.entries(subrubrosPublico).forEach(([id, valor]) => {
            $('<input>', {type:'hidden', name:`subrubros_publico[${id}]`, value:valor}).appendTo(box);
        });
        Object.entries(subrubrosEditados).forEach(([id, nombre]) => {
            $('<input>', {type:'hidden', name:`subrubros_editados[${id}]`, value:nombre}).appendTo(box);
        });
    }

    function renderSubrubros() {
        const $box = $('#selected-subrubros');
        const $hiddenExistentes = $('#subrubros-hidden-inputs');
        const $hiddenNuevos = $('#subrubros-nuevos-hidden-inputs');

        $box.empty();
        $hiddenExistentes.empty();
        $hiddenNuevos.empty();
        // Estado público de cada subrubro nuevo, sincronizado por índice.
        subrubrosNuevos.forEach((nombre, index) => {
            $('<input>', {type:'hidden', name:`subrubros_nuevos_publico[${index}]`, value:subrubrosNuevosPublico[index] ?? 1}).appendTo($hiddenNuevos);
        });

        if (subrubrosExistentes.length === 0 && subrubrosNuevos.length === 0) {
            $box.html(
                '<span class="subrubros-empty-text">No hay subrubros seleccionados.</span>'
            );

            actualizarDisponibles();
            actualizarEdicionesOcultas();
            actualizarOrden();
            return;
        }

        // EXISTENTES
        $.each(subrubrosExistentes, function(index, item) {
            const $chip = $(`
                <span class="subrubro-selected" data-tipo="existente" data-id="${item.id}">
                    <span class="subrubro-order"></span>
                    <span class="subrubro-name">${escaparTexto(nombreExistente(item.id))}</span>
                    <button type="button" class="subrubro-edit-btn" data-tipo="existente" data-id="${item.id}" title="Editar" aria-label="Editar subrubro">${iconoLapiz}</button>
                    <button type="button" class="subrubro-remove-btn" data-id="${item.id}">&times;</button>
                </span>
            `);

            $box.append($chip);

            $('<input>', {
                type: 'hidden',
                name: 'subrubros[]',
                value: item.id
            }).appendTo($hiddenExistentes);
        });

        // NUEVOS
        $.each(subrubrosNuevos, function(index, nombre) {
            const $chip = $(`
                <span class="subrubro-selected" data-tipo="nuevo" data-index="${index}">
                    <span class="subrubro-order"></span>
                    <span class="subrubro-name">${escaparTexto(nombre)}</span>
                    <button type="button" class="subrubro-edit-btn" data-tipo="nuevo" data-index="${index}" title="Editar" aria-label="Editar subrubro">${iconoLapiz}</button>
                    <button type="button" class="subrubro-nuevo-remove-btn" data-index="${index}">&times;</button>
                </span>
            `);

            $box.append($chip);

            $('<input>', {
                type: 'hidden',
                name: 'subrubros_nuevos[]',
                value: nombre
            }).appendTo($hiddenNuevos);
        });

        actualizarDisponibles();
        actualizarEdicionesOcultas();
        activarSortable();
        actualizarOrden();
    }


    // AGREGAR SUBRUBRO EXISTENTE
    $(document).on('click', '.subrubro-option', function() {
        const id = Number($(this).data('id'));
        const name = nombreExistente(id);

        const existe = subrubrosExistentes.some(function(item) {
            return Number(item.id) === id;
        });

        if (existe) {
            return;
        }

        subrubrosExistentes.push({
            id: id,
            name: name
        });

        renderSubrubros();
    });


    // ELIMINAR SUBRUBRO EXISTENTE
    $(document).on('click', '.subrubro-remove-btn', function() {
        const id = Number($(this).data('id'));

        subrubrosExistentes = subrubrosExistentes.filter(function(item) {
            return item.id !== id;
        });

        renderSubrubros();
    });


    // AGREGAR NUEVO SUBRUBRO
    function agregarNuevoSubrubro() {
        const $input = $('#nuevo-subrubro-input');
        const nombre = $input.val().trim();

        if (!nombre) {
            return;
        }

        if (subrubrosNuevos.includes(nombre)) {
            return;
        }

        subrubrosNuevos.push(nombre);
        subrubrosNuevosPublico.push(1);
        $input.val('');

        renderSubrubros();
    }


    // ELIMINAR NUEVO SUBRUBRO
    $(document).on('click', '.subrubro-nuevo-remove-btn', function() {
        const index = Number($(this).data('index'));
        subrubrosNuevos.splice(index, 1);
        subrubrosNuevosPublico.splice(index, 1);

        renderSubrubros();
    });


    // ACTUALIZAR BOTONES DISPONIBLES
    function actualizarDisponibles() {
        $('.subrubro-option').each(function() {
            const $btn = $(this);
            const id = Number($btn.data('id'));

            const seleccionado = subrubrosExistentes.some(function(item) {
                return Number(item.id) === id;
            });

            $btn.toggleClass('is-disabled', seleccionado);
            $btn.text(nombreExistente(id));
        });
    }

    // EDICIÓN DESDE SELECCIONADOS O DISPONIBLES
    $(document).on('click', '.subrubro-edit-btn', function(e) {
        e.preventDefault(); e.stopPropagation();
        const $btn = $(this);
        const tipo = $btn.attr('data-tipo');
        const id = tipo === 'nuevo' ? Number($btn.attr('data-index')) : Number($btn.attr('data-id'));
        edicionActual = {tipo, id};
        const nombre = tipo === 'nuevo' ? subrubrosNuevos[id] : nombreExistente(id);
        $('#editar-subrubro-nombre').val(nombre).removeClass('is-invalid');
        const publico = tipo === 'nuevo'
            ? (subrubrosNuevosPublico[id] ?? 1)
            : (subrubrosPublico[id] ?? publicoInicial[id] ?? publicoSeleccionados[id] ?? 0);
        $('#editar-subrubro-publico').prop('checked', Number(publico) === 1);
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditarSubrubro')).show();
    });

    $('#guardar-edicion-subrubro').on('click', function() {
        if (!edicionActual) return;
        const nombre = $('#editar-subrubro-nombre').val().trim();
        const publico = $('#editar-subrubro-publico').is(':checked') ? 1 : 0;
        if (!nombre) { $('#editar-subrubro-nombre').addClass('is-invalid').focus(); return; }
        if (edicionActual.tipo === 'nuevo') {
            subrubrosNuevos[edicionActual.id] = nombre;
            subrubrosNuevosPublico[edicionActual.id] = publico;
        } else {
            subrubrosEditados[edicionActual.id] = nombre;
            subrubrosPublico[edicionActual.id] = publico;
            subrubrosExistentes.forEach(item => {
                if (Number(item.id) === edicionActual.id) item.name = nombre;
            });
        }
        bootstrap.Modal.getInstance(document.getElementById('modalEditarSubrubro')).hide();
        edicionActual = null;
        renderSubrubros();
    });
    $('#editar-subrubro-nombre').on('keydown', function(e) {
        if (e.key === 'Enter') { e.preventDefault(); $('#guardar-edicion-subrubro').trigger('click'); }
    });
    // ACTIVAR ORDEN
    function activarSortable() {
        $('#selected-subrubros').sortable({
            items: '.subrubro-selected',
            cursor: 'move',
            tolerance: 'pointer',
            placeholder: 'subrubro-placeholder',
            update: function() {
                actualizarOrden();
            }
        });
    }

    // ACTUALIZAR ORDEN
    function actualizarOrden() {
        const $boxOrden = $('#subrubros-orden-hidden-inputs');
        $boxOrden.empty();

        $('#selected-subrubros .subrubro-selected').each(function(index) {
            const $item = $(this);
            const tipo = $item.data('tipo');

            // Mostrar número visual
            $item.find('.subrubro-order').text(index + 1);

            let valor = '';
            if (tipo === 'existente') {
                valor = 'existente:' + $item.data('id');
            } else {
                const nombre = $item.find('.subrubro-name').text().trim();
                valor = 'nuevo:' + nombre;
            }

            $('<input>', {
                type: 'hidden',
                name: 'subrubros_orden[]',
                value: valor
            }).appendTo($boxOrden);
        });
    }

    // AL CARGAR LA PÁGINA
    $(function() {
        $('.subrubro-available-item .subrubro-edit-btn').html(iconoLapiz);
        renderSubrubros();
    });
</script>

<script>
$(document).on('click', '#btn_eliminar', function (e) {
    e.preventDefault();

    let url = $(this).data('url');

    Swal.fire({
        title: 'Bloquear rubro?',
        text: "Esta acción lo desactivará",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5cb85c',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            $.post(url, {
                _token: "{{ csrf_token() }}"
            }).done(function () {
                window.location.href = "{{ route('admin.rubros.index') }}";
            });

        }
    });
});
</script>
@endsection