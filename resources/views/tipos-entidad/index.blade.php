@extends('layouts.app')

@section('title', 'Tipos de entidad')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/commerces/index.css') }}">
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
            <h1 class="commerce-title">Tipos de entidades</h1>
            <p class="commerce-subtitle">Clasifican las entidades según su rubro o actividad.</p>
        </div>
    </section>

    <section class="commerce-list-section">
        <div class="container">
            <div class="commerce-card">
                <div class="commerce-toolbar">
                    <div class="commerce-toolbar__left">
                        <div class="commerce-search">
                            <i class="bi bi-search"></i>
                            <input type="text" class="form-control" placeholder="Buscar tipo de entidad...">
                        </div>

                        <button class="btn commerce-filter-btn" type="button">
                            <i class="bi bi-funnel"></i>
                            Filtro
                            <i class="bi bi-chevron-down ms-1"></i>
                        </button>
                    </div>

                    <div class="commerce-toolbar__right">
                        <a href="{{ route('tipos-entidad.create') }}" class="btn commerce-new-btn">
                            <i class="bi bi-plus-lg"></i>
                            Nuevo tipo de entidad
                        </a>
                    </div>
                </div>

                <div class="commerce-table-wrap">
                    <table class="commerce-table">
                        <thead>
                            <tr class="commerce-table-head">
                                <th style="width: 50px">ID</th>
                                <th style="width: 160px">NOMBRE</th>
                                <th style="width: 70px">FECHA DE ALTA</th>
                                <th style="width: 60px">ESTADO</th>
                                <th style="width: 60px">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tipos as $tipo)
                                <tr class="commerce-row">

                                    <td class="commerce-col" data-label="ID">
                                        <span class="commerce-mobile-label">ID</span>
                                        <span>{{ $tipo['tipo_ent_id'] }}</span>
                                    </td>

                                    <td class="commerce-col" data-label="Nombre">
                                        <span class="commerce-mobile-label">Nombre</span>
                                        <span>{{ $tipo['tipo_ent_nombre'] }}</span>
                                    </td>

                                    <td class="commerce-col text-center" data-label="Fecha de alta">
                                        <span class="commerce-mobile-label">Fecha de alta</span>
                                        <span>{{ $tipo['tipo_ent_fecha_alta']->format('d/m/Y') }}</span>
                                    </td>

                                    <td class="commerce-col text-center" data-label="Estado">
                                        <span class="commerce-mobile-label">Estado</span>

                                        @php
                                            $estado = estado($tipo['tipo_ent_estado']);
                                        @endphp

                                        <span class="commerce-status {{ $estado['class'] }}" title="{{ $estado['text'] }}">
                                            <i class="bi bi-{{ $estado['icon'] }}"></i>
                                        </span>
                                    </td>

                                    <td class="commerce-col commerce-col--actions" data-label="Acciones">
                                        <span class="commerce-mobile-label">Acciones</span>
                                        <a href="{{ route('tipos-entidad.edit', $tipo->tipo_ent_id) }}" class="btn commerce-edit-btn" title="Editar">
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
                        Mostrando 1 a {{ $tipos->count() }} de 25 registros
                    </div>

                    <div class="commerce-pagination">
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
