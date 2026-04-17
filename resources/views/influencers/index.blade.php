@extends('layouts.app')

@section('title', 'Influencers')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/commerces/index.css') }}">
@endpush


@section('content')

@include('partials.navbar')

<main class="commerce-page">
    <section class="commerce-hero">
        <div class="commerce-hero__content">
            <h1 class="commerce-title">Influencers</h1>

            <p class="commerce-subtitle">
                Consulta y administra todos los tipos de entidad disponibles en la plataforma Vauchis.
            </p>
        </div>

        <span class="commerce-hero-wave commerce-hero-wave--one"></span>
        <span class="commerce-hero-wave commerce-hero-wave--two"></span>

        <span class="commerce-dot commerce-dot--pink-left"></span>
        <span class="commerce-dot commerce-dot--blue-left"></span>
        <span class="commerce-dot commerce-dot--yellow"></span>
        <span class="commerce-dot commerce-dot--blue"></span>
        <span class="commerce-dot commerce-dot--green"></span>
        <span class="commerce-dot commerce-dot--pink"></span>
        <span class="commerce-dot commerce-dot--blue-small"></span>
    </section>

    <section class="commerce-list-section">
        <div class="container">
            <div class="commerce-card">
                <div class="commerce-toolbar">
                    <div class="commerce-toolbar__left">
                        <div class="commerce-search">
                            <i class="bi bi-search"></i>
                            <input type="text" class="form-control" placeholder="Buscar influencer...">
                        </div>

                        <button class="btn commerce-filter-btn" type="button">
                            <i class="bi bi-funnel"></i>
                            Filtro
                            <i class="bi bi-chevron-down ms-1"></i>
                        </button>
                    </div>

                    <div class="commerce-toolbar__right">
                        <a href="{{ route('influencers.create') }}" class="btn commerce-new-btn">
                            <i class="bi bi-plus-lg"></i>
                            Nuevo influencer
                        </a>
                    </div>
                </div>

                <div class="commerce-table-wrap">
                    <table class="commerce-table">
                        <thead>
                            <tr class="commerce-table-head">
                                <th style="width: 40px">ID</th>
                                <th style="width: 160px">NOMBRE FANTASIA</th>
                                <th style="width: 60px">FECHA DE ALTA</th>
                                <th style="width: 80px">REDES</th>
                                <th style="width: 60px">ESTADO</th>
                                <th style="width: 60px">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($influencers as $influencer)
                                <tr class="commerce-row">

                                    <td class="commerce-col" data-label="ID">
                                        <span class="commerce-mobile-label">ID</span>
                                        <span>{{ $influencer['inf_id'] }}</span>
                                    </td>

                                    <td class="commerce-col" data-label="Nombre">
                                        <span class="commerce-mobile-label">Nombre</span>
                                        <span>{{ $influencer['inf_nombre_fantasia'] }}</span>
                                    </td>

                                    <td class="commerce-col" data-label="Fecha de alta">
                                        <span class="commerce-mobile-label">Fecha de alta</span>
                                        <span>{{ $influencer['inf_fecha_alta']->format('d/m/Y') }}</span>
                                    </td>

                                    <td class="commerce-col" data-label="Redes">
                                        <span class="commerce-mobile-label">Redes</span>
                                        <span><i class="bi bi-instagram"></i> {{ $influencer[''] }}</span>
                                        <span><i class="bi bi-facebook"></i> {{ $influencer[''] }}</span>
                                        <span><i class="bi bi-tiktok"></i> {{ $influencer[''] }}</span>
                                        <span><i class="bi bi-twitter-x"></i> {{ $influencer[''] }}</span>
                                        <span><i class="bi bi-whatsapp"></i> {{ $influencer[''] }}</span>
                                    </td>

                                    <td class="commerce-col" data-label="Estado">
                                        <span class="commerce-mobile-label">Estado</span>

                                        @php
                                            $statusClass = match($influencer['inf_estado']) {
                                                'activo' => 'is-active',
                                                'pendiente' => 'is-pending',
                                                'inactivo' => 'is-inactive',
                                                default => 'is-active',
                                            };
                                        @endphp

                                        <span class="commerce-status {{ $statusClass }}">
                                            <i class="bi bi-circle-fill"></i>
                                            {{ ucfirst($influencer['inf_estado']) }}
                                        </span>
                                    </td>

                                    <td class="commerce-col commerce-col--actions" data-label="Acciones">
                                        <span class="commerce-mobile-label">Acciones</span>
                                        <a href="{{ route('influencers.edit', $influencer->inf_id) }}" class="btn commerce-edit-btn">
                                            <i class="bi bi-pencil"></i>
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="commerce-footer">
                    <div class="commerce-footer__text">
                        Mostrando 1 a {{ $influencers->count() }} de 25 registros
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
