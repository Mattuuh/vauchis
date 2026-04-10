@extends('layouts.app')

@section('title', 'Entidades')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/commerces/index.css') }}">
@endpush

@section('content')

@include('partials.navbar')

<main class="commerce-page">
    <section class="commerce-hero">
        <div class="commerce-hero__content">
            <h1 class="commerce-title">Entidades</h1>

            <p class="commerce-subtitle">
                Consulta y administra todas las entidades disponibles
                <br>
                en la plataforma Vauchis.
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
                            <input type="text" class="form-control" placeholder="Buscar marca...">
                        </div>

                        <button class="btn commerce-filter-btn" type="button">
                            <i class="bi bi-funnel"></i>
                            Filtro
                            <i class="bi bi-chevron-down ms-1"></i>
                        </button>
                    </div>

                    <div class="commerce-toolbar__right">
                        <a href="{{ route('comercios.create') }}" class="btn commerce-new-btn">
                            <i class="bi bi-plus-lg"></i>
                            Nueva marca
                        </a>
                    </div>
                </div>

                <div class="commerce-table-wrap">
                    <div class="commerce-table-head d-none d-lg-grid">
                        <div>MARCA</div>
                        <div>EMAIL</div>
                        <div>FECHA DE ALTA</div>
                        <div>VOUCHERS VINCULADOS</div>
                        <div>ESTADO</div>
                        <div>ACCIONES</div>
                    </div>

                    @foreach($commerces as $commerce)
                        <div class="commerce-row">
                            <div class="commerce-col commerce-col--brand">
                                <div class="commerce-brand">
                                    <div class="commerce-brand__logo">
                                        <img src="{{ $commerce['logo'] }}" alt="{{ $commerce['name'] }}">
                                    </div>
                                    <div class="commerce-brand__text">
                                        <h3>{{ $commerce['name'] }}</h3>
                                        <p>{{ $commerce['category'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="commerce-col" data-label="Email">
                                <span class="commerce-mobile-label">Email</span>
                                <span>{{ $commerce['email'] }}</span>
                            </div>

                            <div class="commerce-col" data-label="Fecha de alta">
                                <span class="commerce-mobile-label">Fecha de alta</span>
                                <span>{{ $commerce['created_at'] }}</span>
                            </div>

                            <div class="commerce-col" data-label="Vouchers">
                                <span class="commerce-mobile-label">Vouchers</span>
                                <span class="commerce-badge-count">{{ $commerce['vouchers_count'] }}</span>
                            </div>

                            <div class="commerce-col" data-label="Estado">
                                <span class="commerce-mobile-label">Estado</span>

                                @php
                                    $statusClass = match($commerce['status']) {
                                        'activo' => 'is-active',
                                        'pendiente' => 'is-pending',
                                        'inactivo' => 'is-inactive',
                                        default => 'is-active',
                                    };
                                @endphp

                                <span class="commerce-status {{ $statusClass }}">
                                    <i class="bi bi-circle-fill"></i>
                                    {{ ucfirst($commerce['status']) }}
                                </span>
                            </div>

                            <div class="commerce-col commerce-col--actions" data-label="Acciones">
                                <span class="commerce-mobile-label">Acciones</span>
                                <a href="#" class="btn commerce-edit-btn">
                                    <i class="bi bi-pencil"></i>
                                    Editar
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="commerce-footer">
                    <div class="commerce-footer__text">
                        Mostrando 1 a {{ $commerces->count() }} de 25 marcas
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