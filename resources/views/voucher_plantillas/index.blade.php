@extends('layouts.app')

@section('title', 'Plantillas de vouchers')

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
            <h1 class="commerce-title">Plantillas de vouchers</h1>
            <p class="commerce-subtitle">Las plantillas definen el diseño visual y la disposición de los datos en los vouchers.</p>
        </div>
    </section>

    <section class="commerce-list-section">
        <div class="container">
            <div class="commerce-card">
                <div class="commerce-toolbar">
                    <div class="commerce-toolbar__left">
                        <div class="commerce-search">
                            <i class="bi bi-search"></i>
                            <input type="text" class="form-control" placeholder="Buscar plantilla...">
                        </div>

                        <button class="btn commerce-filter-btn" type="button">
                            <i class="bi bi-funnel"></i>
                            Filtro
                            <i class="bi bi-chevron-down ms-1"></i>
                        </button>
                    </div>

                    <div class="commerce-toolbar__right">
                        <a href="{{ route('voucher_plantillas.create') }}" class="btn commerce-new-btn">
                            <i class="bi bi-plus-lg"></i>
                            Nueva plantilla
                        </a>
                    </div>
                </div>

                <div class="commerce-table-wrap">
                    <table class="commerce-table">
                        <thead>
                            <tr class="commerce-table-head">
                                <th style="width: 40px">ID</th>
                                <th style="width: 130px">NOMBRE</th>
                                <th style="width: 80px">DIMENSIONES</th>
                                <th style="width: 110px">FONDO</th>
                                <th style="width: 60px">FECHA DE ALTA</th>
                                <th style="width: 60px" class="text-center">ESTADO</th>
                                <th style="width: 110px">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plantillas as $plantilla)
                                <tr class="commerce-row">
                                    <td class="commerce-col" data-label="ID">
                                        <span class="commerce-mobile-label">ID</span>
                                        <span>{{ $plantilla['vpl_id'] }}</span>
                                    </td>

                                    <td class="commerce-col" data-label="Nombre">
                                        <span class="commerce-mobile-label">Nombre</span>
                                        <span>{{ $plantilla['vpl_nombre'] }}</span>
                                    </td>

                                    <td class="commerce-col" data-label="Dimensiones">
                                        <span class="commerce-mobile-label">Dimensiones</span>
                                        <span>{{ $plantilla['vpl_ancho'] }} x {{ $plantilla['vpl_alto'] }}</span>
                                    </td>

                                    <td class="commerce-col" data-label="Fondo">
                                        <span class="commerce-mobile-label">Fondo</span>
                                        @if($plantilla['vpl_fondo_path'])
                                            <img src="{{ asset($plantilla['vpl_fondo_path']) }}" alt="" style="height:60px;border-radius:6px;">
                                        @else
                                            <span class="text-muted">Sin fondo</span>
                                        @endif
                                    </td>

                                    <td class="commerce-col text-center" data-label="Fecha de alta">
                                        <span class="commerce-mobile-label">Fecha de alta</span>
                                        <span>{{ $plantilla['vpl_fecha_alta']->format('d/m/Y') }}</span>
                                    </td>

                                    <td class="commerce-col text-center" data-label="Estado">
                                        <span class="commerce-mobile-label">Estado</span>

                                        @php
                                            $estado = estado($plantilla['vpl_estado']);
                                        @endphp

                                        <span class="commerce-status {{ $estado['class'] }}" title="{{ $estado['text'] }}">
                                            <i class="bi bi-{{ $estado['icon'] }}"></i>
                                        </span>
                                    </td>

                                    <td class="commerce-col commerce-col--actions" data-label="Acciones">
                                        <span class="commerce-mobile-label">Acciones</span>
                                        <a href="{{ route('voucher_plantillas.edit', $plantilla['vpl_id']) }}" class="btn commerce-edit-btn" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('voucher_plantillas.builder', $plantilla['vpl_id']) }}" class="btn commerce-edit-btn" title="Builder">
                                            <i class="bi bi-gear"></i>
                                        </a>
                                        <a href="{{ route('voucher_plantillas.preview', $plantilla['vpl_id']) }}" class="btn commerce-edit-btn" target="_blank" title="Preview">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="commerce-footer">
                    <div class="commerce-footer__text">
                        Mostrando 1 a {{ $plantillas->count() }} de 25 registros
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