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

        <td class="commerce-col text-center" data-label="Estado">
            <span class="commerce-mobile-label">Estado</span>

            @php
                $estado = estado($influencer['inf_estado']);
            @endphp

            <span class="commerce-status {{ $estado['class'] }}" title="{{ $estado['text'] }}">
                <i class="bi bi-{{ $estado['icon'] }}"></i>
            </span>
        </td>

        <td class="commerce-col commerce-col--actions" data-label="Acciones">
            <span class="commerce-mobile-label">Acciones</span>
            <a href="{{ route('influencers.edit', $influencer->inf_id) }}" class="btn commerce-edit-btn" title="Editar">
                <i class="bi bi-pencil"></i>
            </a>
        </td>
    </tr>
@endforeach