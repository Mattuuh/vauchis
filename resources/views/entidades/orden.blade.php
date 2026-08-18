@extends('layouts.app')

@section('title', 'Rubros')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/commerces/index.css') }}">

<style>
.item {
    transition:
        background-color .15s ease,
        box-shadow .15s ease;
}

.item.ui-sortable-helper {
    background: #ffffff;
    box-shadow: 0 8px 24px rgba(30, 55, 100, .12);
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
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function () {
    $('#lista-items').sortable({
        axis: 'y',
        handle: '.btn-drag',
        cursor: 'grabbing',
        tolerance: 'pointer'
    });

    $('#lista-items').disableSelection();

    $('#btn-guardar-orden').on('click', function () {

        let orden = [];

        $('#lista-items .item').each(function () {
            orden.push($(this).data('id'));
        });

        $.ajax({
            url: "{{ route('admin.entidades.guardar_orden') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
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
            <h1 class="commerce-title">Ordenar entidades</h1>
            <p class="commerce-subtitle">Arrastrá los registros para modificar el orden de visualización.</p>
        </div>
    </section>

    <section class="commerce-list-section">
        <div class="container">
            <div class="commerce-card">
                <div class="commerce-table-wrap">
                    <table class="commerce-table">
                        <thead>
                            <tr class="commerce-table-head">
                                <th style="width: 50px">ID</th>
                                <th>MARCA</th>
                                <th>TIPO</th>
                                <th>CANT. DOMICILIOS</th>
                                <th>VOUCHERS VINCULADOS</th>
                                <th>FECHA DE ALTA</th>
                                <th>ESTADO</th>
                                <th>ORDENAR</th>
                            </tr>
                        </thead>

                        <tbody id="lista-items">
                            @foreach($entidades as $entidad)
                                <tr class="commerce-row item" data-id="{{ $entidad->ent_id }}">
                                    <td class="commerce-col" data-label="ID">
                                        <span class="commerce-mobile-label">ID</span>
                                        <span>{{ $entidad->ent_id }}</span>
                                    </td>

                                    <td class="commerce-col commerce-col--brand" data-label="Marca">
                                        <span class="commerce-mobile-label">Marca</span>

                                        <div class="commerce-brand">
                                            <div class="commerce-brand__text">
                                                <h3>{{ $entidad->ent_nombre_fantasia }}</h3>
                                                <p>{{ $entidad->category }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="commerce-col" data-label="Tipo">
                                        <span class="commerce-mobile-label">Tipo</span>
                                        <span>{{ $entidad->tipo_entidad->tipo_ent_nombre }}</span>
                                    </td>

                                    <td class="commerce-col text-center" data-label="Domicilios">
                                        <span class="commerce-mobile-label">Domicilios</span>
                                        <span class="commerce-badge-count">{{ $entidad->domicilios_count }}</span>
                                    </td>

                                    <td class="commerce-col text-center" data-label="Vouchers">
                                        <span class="commerce-mobile-label">Vouchers</span>
                                        <span class="commerce-badge-count">{{ $entidad->vouchers_activos_count }}</span>
                                    </td>

                                    <td class="commerce-col text-center" data-label="Fecha de alta">
                                        <span class="commerce-mobile-label">Fecha de alta</span>
                                        <span>{{ $entidad->ent_fecha_alta->format('d/m/Y') }}</span>
                                    </td>

                                    <td class="commerce-col text-center" data-label="Estado">
                                        <span class="commerce-mobile-label">Estado</span>
                                        @php
                                            $estado = estado($entidad->ent_estado);
                                        @endphp
                                        <span class="commerce-status {{ $estado['class'] }}" title="{{ $estado['text'] }}"><i class="bi bi-{{ $estado['icon'] }}"></i></span>
                                    </td>

                                    <td class="commerce-col text-center" data-label="Ordenar">
                                        <span class="commerce-mobile-label">Ordenar</span>
                                        <span class="btn-drag" title="Arrastrar para ordenar"><i class="bi bi-grip-vertical"></i></span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.entidades.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="button" id="btn-guardar-orden" class="btn btn-success">Guardar orden</button>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
