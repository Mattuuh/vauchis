@foreach($entidades as $entidad)
    {{-- @php
        dd($entidad);
    @endphp --}}
        <tr class="commerce-row">

            <td class="commerce-col" data-label="ID">
                <span class="commerce-mobile-label">ID</span>
                <span>{{ $entidad['ent_id'] }}</span>
            </td>

            <td class="commerce-col commerce-col--brand" data-label="Marca">
                <span class="commerce-mobile-label">Marca</span>

                <div class="commerce-brand">
                    {{-- <div class="commerce-brand__logo">
                        <img src="{{ $entidad['logo'] }}" alt="{{ $entidad['ent_nombre_fantasia'] }}">
                    </div> --}}
                    <div class="commerce-brand__text">
                        <h3>{{ $entidad['ent_nombre_fantasia'] }}</h3>
                        <p>{{ $entidad['category'] }}</p>
                    </div>
                </div>
            </td>

            <td class="commerce-col" data-label="Tipo">
                <span class="commerce-mobile-label">Tipo</span>
                <span>{{ $entidad['tipo_entidad']['tipo_ent_nombre'] }}</span>
            </td>

            <td class="commerce-col text-center" data-label="Domicilios">
                <span class="commerce-mobile-label">Domicilios</span>
                <span class="commerce-badge-count">{{ $entidad['domicilios_count'] }}</span>
            </td>

            <td class="commerce-col text-center" data-label="Vouchers">
                <span class="commerce-mobile-label">Vouchers</span>
                <span class="commerce-badge-count">{{ $entidad['vouchers_activos_count'] }}</span>
            </td>

            <td class="commerce-col text-center" data-label="Fecha de alta">
                <span class="commerce-mobile-label">Fecha de alta</span>
                <span>{{ $entidad['ent_fecha_alta']->format('d/m/Y') }}</span>
            </td>

            <td class="commerce-col text-center" data-label="Estado">
                <span class="commerce-mobile-label">Estado</span>

                @php
                    $estado = estado($entidad['ent_estado']);
                @endphp

                <span class="commerce-status {{ $estado['class'] }}" title="{{ $estado['text'] }}">
                    <i class="bi bi-{{ $estado['icon'] }}"></i>
                </span>
            </td>

            <td class="commerce-col commerce-col--actions" data-label="Acciones">
                <span class="commerce-mobile-label">Acciones</span>
                <a href="{{ route('entidades.edit', $entidad->ent_id) }}" class="btn commerce-edit-btn">
                    <i class="bi bi-pencil"></i>
                </a>
            </td>
        </tr>
    @endforeach