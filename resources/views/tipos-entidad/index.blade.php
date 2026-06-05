@extends('layouts.app')

@section('title', 'Tipos de entidad')

@section('content')

<main class="vs-page">
    @include('partials.navbar')

    <section class="vs-section-lg vs-bg-primary-dark">
        <div class="vs-container">
            <h1 class="vs-title-xl" style="color: var(--text-inverse);">Tipos de entidades</h1>
            <p class="vs-text" style="max-width: 620px; color: rgba(253,253,254,.82);">
                Clasifican las entidades según su rubro o actividad.
            </p>
        </div>
    </section>

    <section class="vs-section">
        <div class="vs-container">
            <div class="vs-card">
                <div class="vs-card-body">
                    <div class="vs-d-flex vs-align-center vs-justify-between vs-gap-md vs-mb-md" style="flex-wrap: wrap;">
                        <div class="vs-d-flex vs-align-center vs-gap-sm" style="flex: 1 1 420px; flex-wrap: wrap;">
                            <div style="position: relative; flex: 1 1 280px; max-width: 420px;">
                                <i class="bi bi-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                                <input
                                    type="text"
                                    class="vs-input"
                                    placeholder="Buscar tipo de entidad..."
                                    style="padding-left: 40px; border-radius: var(--radius-pill);"
                                >
                            </div>

                            <button class="vs-btn vs-btn-secondary" type="button">
                                <i class="bi bi-funnel"></i>
                                Filtro
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        </div>

                        <a href="{{ route('tipos-entidad.create') }}" class="vs-btn vs-btn-primary">
                            <i class="bi bi-plus-lg"></i>
                            Nuevo tipo de entidad
                        </a>
                    </div>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; min-width: 760px;">
                            <thead>
                                <tr style="border-bottom: 1px solid rgba(162,162,161,.25);">
                                    <th class="vs-ui-text" style="width: 70px; padding: 14px 12px; text-align: left; color: var(--text-muted);">ID</th>
                                    <th class="vs-ui-text" style="padding: 14px 12px; text-align: left; color: var(--text-muted);">NOMBRE</th>
                                    <th class="vs-ui-text" style="width: 180px; padding: 14px 12px; text-align: center; color: var(--text-muted);">FECHA DE ALTA</th>
                                    <th class="vs-ui-text" style="width: 120px; padding: 14px 12px; text-align: center; color: var(--text-muted);">ESTADO</th>
                                    <th class="vs-ui-text" style="width: 120px; padding: 14px 12px; text-align: center; color: var(--text-muted);">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tipos as $tipo)
                                    <tr style="border-bottom: 1px solid rgba(162,162,161,.18);">
                                        <td class="vs-text-sm" data-label="ID" style="padding: 14px 12px;">
                                            {{ $tipo['tipo_ent_id'] }}
                                        </td>

                                        <td class="vs-text-sm" data-label="Nombre" style="padding: 14px 12px; font-weight: 600; color: var(--text-main);">
                                            {{ $tipo['tipo_ent_nombre'] }}
                                        </td>

                                        <td class="vs-text-sm vs-text-center" data-label="Fecha de alta" style="padding: 14px 12px;">
                                            {{ $tipo['tipo_ent_fecha_alta']->format('d/m/Y') }}
                                        </td>

                                        <td class="vs-text-center" data-label="Estado" style="padding: 14px 12px;">
                                            @php
                                                $estado = estado($tipo['tipo_ent_estado']);

                                                $estadoClass = match ($tipo['tipo_ent_estado']) {
                                                    1, '1', true => 'vs-badge-success',
                                                    default => 'vs-badge-pink',
                                                };
                                            @endphp

                                            <span class="vs-badge {{ $estadoClass }}" title="{{ $estado['text'] }}">
                                                <i class="bi bi-{{ $estado['icon'] }}"></i>
                                                {{ $estado['text'] }}
                                            </span>
                                        </td>

                                        <td class="vs-text-center" data-label="Acciones" style="padding: 14px 12px;">
                                            <a href="{{ route('tipos-entidad.edit', $tipo->tipo_ent_id) }}" class="vs-btn vs-btn-secondary vs-btn-icon" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="vs-d-flex vs-align-center vs-justify-between vs-gap-md vs-mt-md" style="flex-wrap: wrap;">
                        <div class="vs-text-sm vs-text-muted">
                            Mostrando 1 a {{ $tipos->count() }} de {{ method_exists($tipos, 'total') ? $tipos->total() : $tipos->count() }} registros
                        </div>

                        @if(method_exists($tipos, 'links'))
                            <div>
                                {{ $tipos->links() }}
                            </div>
                        @else
                            <div class="vs-d-flex vs-align-center vs-gap-xs">
                                <button class="vs-btn vs-btn-secondary vs-btn-icon" disabled>
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button class="vs-btn vs-btn-primary vs-btn-icon">1</button>
                                <button class="vs-btn vs-btn-secondary vs-btn-icon">2</button>
                                <button class="vs-btn vs-btn-secondary vs-btn-icon">3</button>
                                <button class="vs-btn vs-btn-secondary vs-btn-icon">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
