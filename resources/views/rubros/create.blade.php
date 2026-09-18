@extends('layouts.app')

@section('title', 'Nuevo rubro')

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
}

.subrubros-selected-box {
    background: #fbfcff;
}

.subrubros-empty-text {
    color: #8a94a6;
}

.subrubro-option,
.subrubro-selected {
    border-radius: 999px;
    padding: 8px 12px;
    font-weight: 600;
}

.subrubro-option {
    border: 1px solid #d7e4ff;
    background: #eef4ff;
    color: #2f6fed;
    cursor: pointer;
}

.subrubro-option.is-disabled {
    opacity: 0.4;
    pointer-events: none;
}

.subrubro-selected {
    background: #2f6fed;
    color: #fff;
    display: flex;
    gap: 8px;
    align-items: center;
}

.subrubro-remove-btn, .subrubro-nuevo-remove-btn {
    background: none;
    border: none;
    color: #fff;
    cursor: pointer;
}
</style>
@endpush

@section('content')

@include('partials.navbar')

<main class="container">
    
    <span class="vch-dot vch-dot--pink-left"></span>
    <span class="vch-dot vch-dot--blue-left"></span>
    <span class="vch-dot vch-dot--yellow"></span>
    <span class="vch-dot vch-dot--blue"></span>
    <span class="vch-dot vch-dot--green"></span>
    <span class="vch-dot vch-dot--pink"></span>
    <span class="vch-dot vch-dot--blue-small"></span>

    <section class="vch-hero">
        <div class="vch-hero__content">
            <h1 class="vch-title">Nuevo rubro</h1>
            <p class="vch-subtitle">Categorías que agrupan entidades según su tipo de actividad, facilitando su organización y búsqueda.</p>
        </div>
    </section>

    <form method="POST" action="{{ route('admin.rubros.store') }}" id="form_main">
        @csrf
        <div class="vch-card p-3 mb-3">
            <h6 class="fw-bold mb-3">Datos del rubro</h6>
            <div class="row g-3">
                <!-- NOMBRE -->
                {{-- <div class="col-12">
                    <label class="form-label required-label">Codigo:</label>
                    <input type="text" name="f_codigo" class="form-control field-required" value="{{ old('f_codigo') }}" placeholder="" required>
                </div> --}}

                <div class="col-12">
                    <label class="form-label required-label">Nombre publico:</label>
                    <input type="text" name="f_nombre" class="form-control field-required" value="{{ old('f_nombre') }}" placeholder="">
                </div>

                <div class="col-12">
                    <label class="form-label required-label">Categoría:</label>
                    <select name="f_categoria" class="form-select">
                        <option value="">Selecciona una categoria</option>
                        @foreach($categorias as $id => $nombre)
                            <option value="{{ $id }}">{{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- <div class="col-12">
                    <label class="form-label required-label">Descripcion corta:</label>
                    <input type="text" name="f_descripcion_corta" class="form-control field-required" value="{{ old('f_descripcion_corta') }}" placeholder="Descripcion para el publico">
                </div> --}}

                <div class="col-12">
                    <label class="form-label required-label">Descripcion interna:</label>
                    <input type="text" name="f_descripcion" class="form-control field-required" value="{{ old('f_descripcion') }}" placeholder="Descripcion precisa que no verá el publico pero servirá para la busqueda">
                </div>

                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="f_publico" id="f_publico" value="1" {{ old('f_publico', 1) ? 'checked' : '' }}>
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
            </div>

            {{-- DISPONIBLES --}}
            <div>
                <label class="form-label fw-semibold">Subrubros disponibles</label>
                <div class="subrubros-available-box">
                    @foreach($subrubrosDisponibles as $subrubro)
                        <button type="button" class="subrubro-option" data-id="{{ $subrubro->sub_id }}" data-name="{{ $subrubro->sub_nombre }}" onclick="addSubrubroExistente(this)">
                            {{ $subrubro->sub_nombre }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- BOTONES -->
        <div class="d-flex justify-content-between form-actions">
            <a href="{{ route('admin.rubros.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success" id="btn_guardar">Guardar</button>
        </div>
    </form>
</main>

<script>
    let subrubrosExistentes = @json(old('subrubros', $subrubrosSeleccionados ?? []));
    let subrubrosNuevos = @json(old('subrubros_nuevos', []));

    function renderSubrubros() {
        const $box = $('#selected-subrubros');
        const $hiddenExistentes = $('#subrubros-hidden-inputs');
        const $hiddenNuevos = $('#subrubros-nuevos-hidden-inputs');

        $box.empty();
        $hiddenExistentes.empty();
        $hiddenNuevos.empty();

        if (subrubrosExistentes.length === 0 && subrubrosNuevos.length === 0) {
            $box.html(
                '<span class="subrubros-empty-text">No hay subrubros seleccionados.</span>'
            );

            return;
        }

        // EXISTENTES
        $.each(subrubrosExistentes, function(index, item) {
            const $chip = $(`
                <span class="subrubro-selected" data-tipo="existente" data-id="${item.id}">
                    <span class="subrubro-order"></span>
                    <span class="subrubro-name">${item.name}</span>
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
                    <span class="subrubro-name">${nombre}</span>
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
        activarSortable();
        actualizarOrden();
    }


    // AGREGAR SUBRUBRO EXISTENTE
    $(document).on('click', '.subrubro-option', function() {
        const id = Number($(this).data('id'));
        const name = $(this).data('name');

        const existe = subrubrosExistentes.some(function(item) {
            return item.id === id;
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
        $input.val('');

        renderSubrubros();
    }


    // ELIMINAR NUEVO SUBRUBRO
    $(document).on('click', '.subrubro-nuevo-remove-btn', function() {
        const index = Number($(this).data('index'));
        subrubrosNuevos.splice(index, 1);

        renderSubrubros();
    });


    // ACTUALIZAR BOTONES DISPONIBLES
    function actualizarDisponibles() {
        $('.subrubro-option').each(function() {
            const $btn = $(this);
            const id = Number($btn.data('id'));

            const seleccionado = subrubrosExistentes.some(function(item) {
                return item.id === id;
            });

            $btn.toggleClass('is-disabled', seleccionado);
        });
    }

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
        renderSubrubros();
    });
</script>
@endsection
