@extends('layouts.app')

@section('title', 'Rubros')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/commerces/index.css') }}">

<style>
.rubro-item {
    transition:
        background-color .15s ease,
        box-shadow .15s ease;
}

.rubro-item.ui-sortable-helper {
    background: #ffffff;
    box-shadow: 0 8px 24px rgba(30, 55, 100, .12);
}

.rubro-placeholder {
    height: 70px;
    background: #f3f6ff;
    border: 2px dashed #4c7cf3;
}

.btn-drag {
    width: 42px;
    height: 38px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border: 1px solid #d5def1;
    border-radius: 10px;

    background: #ffffff;
    color: #58709e;

    font-size: 22px;

    cursor: grab;
}

.btn-drag:hover {
    background: #f5f8ff;
    color: #3f70e8;
}

.btn-drag:active {
    cursor: grabbing;
}

.commerce-order-actions {
    display: flex;
    justify-content: flex-end;
    padding: 20px;
}

.commerce-table-wrap {
    overflow-x: hidden;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function () {
    $('#lista-rubros').sortable({
        axis: 'y',
        handle: '.btn-drag',
        cursor: 'grabbing',
        tolerance: 'pointer'
    });

    $('#lista-rubros').disableSelection();

    // CAMBIO DE CATEGORÍA
    $('#f_categoria').on('change', function () {
        let categoriaId = $(this).val();
        cargarRubros(categoriaId);
    });

    $('#btn-guardar-orden').on('click', function () {

        let orden = [];

        $('#lista-rubros .rubro-item').each(function () {
            orden.push($(this).data('id'));
        });

        $.ajax({
            url: "{{ route('admin.rubros.guardar_orden') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                categoria_id: $('#f_categoria').val(),
                orden: orden
            },
            beforeSend: function () {
                $('#btn-guardar-orden').prop('disabled', true).text('Guardando...');
            },
            success: function (response) {
                $('#btn-guardar-orden').prop('disabled', false).text('Guardar orden');

                Swal.fire({
                    title: 'Operacion exitosa!',
                    text: "Orden guardado correctamente",
                    icon: 'success',
                    confirmButtonColor: '#5cb85c',
                    confirmButtonText: 'Entendido'
                });
            },
            error: function () {
                $('#btn-guardar-orden').prop('disabled', false).text('Guardar orden');

                Swal.fire({
                    title: 'Error',
                    text: "Ocurrió un error al guardar el orden",
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Entendido'
                });
            }
        });

    });

    function cargarRubros(categoriaId) {
        if (!categoriaId) {
            $('#lista-rubros').html('');
            return;
        }

        $.ajax({
            url: "{{ route('admin.rubros.por_categoria') }}",
            type: "GET",
            data: {
                categoria_id: categoriaId
            },
            beforeSend: function () {
                $('#lista-rubros').html(`
                    <tr>
                        <td colspan="6" class="text-center py-4">Cargando...</td>
                    </tr>
                `);
            },
            success: function (response) {
                let html = '';

                if (response.rubros.length === 0) {
                    html = `
                    <tr>
                        <td colspan="6" class="text-center py-4">No hay rubros para esta categoría.</td>
                    </tr>
                    `;

                } else {
                    $.each(response.rubros, function (index, rubro) {
                        html += `
                        <tr class="commerce-row rubro-item" data-id="${rubro.rub_id}">
                            <td class="commerce-col" data-label="ID">
                                <span class="commerce-mobile-label">ID</span>
                                <span>${rubro.rub_id}</span>
                            </td>
                            <td class="commerce-col" data-label="Nombre">
                                <span class="commerce-mobile-label">Nombre</span>
                                <span>${rubro.rub_nombre}</span>
                            </td>
                            <td class="commerce-col" data-label="Categoria">
                                <span class="commerce-mobile-label">Categoria</span>
                                <span>${rubro.categoria ?? ''}</span>
                            </td>
                            <td class="commerce-col text-center" data-label="Fecha de alta">
                                <span class="commerce-mobile-label">Fecha de alta</span>
                                <span>${rubro.fecha_alta}</span>
                            </td>
                            <td class="commerce-col text-center" data-label="Estado">
                                <span class="commerce-mobile-label">Estado</span>
                                <span class="commerce-status ${rubro.estado_class}" title="${rubro.estado_text}">
                                    <i class="bi bi-${rubro.estado_icon}"></i>
                                </span>
                            </td>
                            <td class="commerce-col text-center" data-label="Ordenar">
                                <span class="commerce-mobile-label">Ordenar</span>
                                <span class="btn-drag" title="Arrastrar para ordenar">
                                    <i class="bi bi-grip-vertical"></i>
                                </span>
                            </td>
                        </tr>
                        `;
                    });

                }

                $('#lista-rubros').html(html);

                // Como cambió el contenido del tbody,
                // refrescamos sortable
                $('#lista-rubros').sortable('refresh');
            },
            error: function () {
                $('#lista-rubros').html(`
                <tr>
                    <td colspan="6" class="text-center py-4 text-danger">
                        Error al cargar los rubros.
                    </td>
                </tr>
                `);
            }
        });
    }
});
</script>
@endpush


@section('content')

@include('partials.navbar')

<main class="commerce-page">
    <span class="commerce-hero-wave commerce-hero-wave--one"></span>
    <span class="commerce-hero-wave commerce-hero-wave--two"></span>

    <span class="commerce-dot commerce-dot--pink-left"></span>
    <span class="commerce-dot commerce-dot--blue-left"></span>
    <span class="commerce-dot commerce-dot--yellow"></span>
    <span class="commerce-dot commerce-dot--blue"></span>
    <span class="commerce-dot commerce-dot--green"></span>
    <span class="commerce-dot commerce-dot--pink"></span>
    <span class="commerce-dot commerce-dot--blue-small"></span>

    <section class="commerce-hero">
        <div class="commerce-hero__content">
            <h1 class="commerce-title">Ordenar rubros</h1>
            <p class="commerce-subtitle">Arrastrá los registros para modificar el orden de visualización.</p>
        </div>
    </section>

    <section class="commerce-list-section">
        <div class="container">
            <div class="commerce-card">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="f_categoria" class="form-label">Categoría</label>
                        <select id="f_categoria" class="form-select">
                            <option value="" selected>Selecciona una categoria</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->cv_id }}">{{ $categoria->cv_nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="commerce-table-wrap">
                    <table class="commerce-table">
                        <thead>
                            <tr class="commerce-table-head">
                                <th style="width: 40px">ID</th>
                                <th style="width: 140px">NOMBRE</th>
                                <th style="width: 60px">CATEGORIA</th>
                                <th style="width: 60px">FECHA DE ALTA</th>
                                <th style="width: 60px" class="text-center">ESTADO</th>
                                <th style="width: 60px" class="text-center">ORDENAR</th>
                            </tr>
                        </thead>

                        <tbody id="lista-rubros">
                            <tr>
                                <td colspan="6" class="text-center py-4">No hay rubros para esta categoría.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.rubros.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="button" id="btn-guardar-orden" class="btn btn-success">Guardar orden</button>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
