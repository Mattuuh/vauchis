
@foreach($vouchers as $voucher)
    <tr class="commerce-row">

        <td class="commerce-col" data-label="ID">
            <span class="commerce-mobile-label">ID</span>
            <span>{{ $voucher['vou_id'] }}</span>
        </td>

        <td class="commerce-col commerce-col--brand" data-label="Nombre">
            <span class="commerce-mobile-label">Nombre</span>

            <div class="commerce-brand">
                <div class="commerce-brand__text">
                    <h3>{{ $voucher['vou_nombre'] }}</h3>
                    <p>{{ $voucher['category'] }}</p>
                </div>
            </div>
        </td>

        <td class="commerce-col" data-label="Categoria">
            <span class="commerce-mobile-label">Categoria</span>
            <span>{{ $voucher->categoria->cv_nombre ?? 'Sin categoría' }}</span>
        </td>

        <td class="commerce-col" data-label="Modalidad">
            <span class="commerce-mobile-label">Modalidad</span>
            <span>{{ $voucher->modalidad->mod_codigo ?? 'Sin modalidad' }}</span>
        </td>

        <td class="commerce-col" data-label="Fecha de alta">
            <span class="commerce-mobile-label">Fecha de alta</span>
            <span>{{ $voucher['vou_fecha_alta']->format('d/m/Y') }}</span>
        </td>

        <td class="commerce-col" data-label="Stock">
            <span class="commerce-mobile-label">Stock</span>
            <span class="commerce-badge-count">{{ $voucher['vou_stock'] }}</span>
        </td>

        <td class="commerce-col text-center" data-label="Estado">
            <span class="commerce-mobile-label">Estado</span>

            @php
                $estado = estado($voucher['vou_estado']);
            @endphp

            <span class="commerce-status {{ $estado['class'] }}" title="{{ $estado['text'] }}">
                <i class="bi bi-{{ $estado['icon'] }}"></i>
            </span>
        </td>

        <td class="commerce-col commerce-col--actions" data-label="Acciones">
            <span class="commerce-mobile-label">Acciones</span>
            <a href="{{ route('vouchers.edit', $voucher->vou_id) }}" class="btn commerce-edit-btn">
                <i class="bi bi-pencil"></i>
            </a>
        </td>
    </tr>
@endforeach