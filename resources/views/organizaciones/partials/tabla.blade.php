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