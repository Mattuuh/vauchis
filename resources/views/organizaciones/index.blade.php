@extends('layouts.app')

@section('title', 'Organizaciones')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/commerces/index.css') }}">
@endpush

@push('scripts')
<script>
$(document).ready(function () {
    function cargar_organizaciones(page = 1, orderby = '')
    {
        let dataString =
            $('#formftro').serialize()+'&page='+page+'&orderby=' + orderby;

        $.ajax({
            type: 'GET',
            url: '/organizacion/listado',
            data: dataString,
            beforeSend: function() {
                $('#box-espere').show();
            },
            complete: function() {
                $('#box-espere').hide();
            },
            success: function(response) {
                $('#box_body').html(response.body);
                $('#box_foot').html(response.foot);

                $('#f_organismo_totales').html(response.kregtotal);
            }
        });
    }

    // cargar_organizaciones($('#pag').val(), $('#ob').val());

    $('#btn_filtro').on('click', function () {
        cargar_organizaciones($('#pag').val(), $('#ob').val());
    });

	$(document).on("keypress", function(e) {
		// Detecta tecla Enter
		if (e.which === 13) {
			e.preventDefault(); // evita comportamiento por defecto
			$("#btn_filtro").click(); // simula click en el botón
		}
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
            <h1 class="commerce-title">Organizaciones</h1>

            <p class="commerce-subtitle">
                Las organizaciones agrupan y gestionan múltiples entidades dentro de la plataforma.
            </p>
        </div>
    </section>

    <section class="commerce-list-section">
        <div class="container">
            <div class="commerce-card">
                <div class="commerce-toolbar">
                    <div class="commerce-toolbar__left">
                        <form action="" id="formftro">
                            <div class="commerce-search">
                                <i class="bi bi-search"></i>
                                <input type="text" class="form-control" name="buscar" id="buscar" placeholder="Buscar organizacion...">
                            </div>
                        </form>

                        {{-- <button class="btn commerce-filter-btn" type="button"><i class="bi bi-funnel"></i>Filtro<i class="bi bi-chevron-down ms-1"></i></button> --}}
                    </div>

                    <div class="commerce-toolbar__right">
                        <button type="button" id="btn_filtro" class="btn commerce-filter-btn">Mostrar</button>
                        <a href="{{ route('organizacion.create') }}" class="btn commerce-new-btn"><i class="bi bi-plus-lg"></i>Nueva organizacion</a>
                    </div>
                </div>

                <div class="commerce-table-wrap">
                    <table class="commerce-table">
                        <thead>
                            <tr class="commerce-table-head">
                                <th style="width: 40px">ID</th>
                                <th style="width: 160px">NOMBRE</th>
                                <th style="width: 60px" class="text-center">FECHA DE ALTA</th>
                                <th style="width: 60px" class="text-center">ESTADO</th>
                                <th style="width: 60px">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="box_body">
                            @foreach($organizaciones as $organizacion)
                                <tr class="commerce-row">

                                    <td class="commerce-col" data-label="ID">
                                        <span class="commerce-mobile-label">ID</span>
                                        <span>{{ $organizacion['org_id'] }}</span>
                                    </td>

                                    <td class="commerce-col" data-label="Nombre">
                                        <span class="commerce-mobile-label">Nombre</span>
                                        <span>{{ $organizacion['org_nombre'] }}</span>
                                    </td>

                                    <td class="commerce-col text-center" data-label="Fecha de alta">
                                        <span class="commerce-mobile-label">Fecha de alta</span>
                                        <span>{{ $organizacion['org_fecha_alta']->format('d/m/Y') }}</span>
                                    </td>

                                    <td class="commerce-col text-center" data-label="Estado">
                                        <span class="commerce-mobile-label">Estado</span>

                                        @php
                                            $estado = estado($organizacion['org_estado']);
                                        @endphp

                                        <span class="commerce-status {{ $estado['class'] }}" title="{{ $estado['text'] }}">
                                            <i class="bi bi-{{ $estado['icon'] }}"></i>
                                        </span>
                                    </td>

                                    <td class="commerce-col commerce-col--actions" data-label="Acciones">
                                        <span class="commerce-mobile-label">Acciones</span>
                                        <a href="{{ route('organizacion.edit', $organizacion->org_id) }}" class="btn commerce-edit-btn" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="commerce-footer">
                    <div class="commerce-footer__text">
                        Mostrando 1 a {{ $organizaciones->count() }} de {{ $organizaciones->count() }} registros
                    </div>

                    <div class="commerce-pagination" id="box_foot">
                        <button class="btn commerce-page-arrow" disabled>
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="btn commerce-page-btn active">1</button>
                        <button class="btn commerce-page-btn">2</button>
                        <button class="btn commerce-page-btn">3</button>
                        <button class="btn commerce-page-arrow">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
