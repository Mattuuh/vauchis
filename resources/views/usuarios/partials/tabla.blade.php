@foreach($vouchers as $voucher)
    <tr>
        <td data-label="Código">
            <span class="mv-code">{{ $voucher->vd_codigo }}</span>
        </td>
        <td data-label="Voucher">
            <div class="mv-voucher-name">{{ $voucher->voucher->vou_nombre }}</div>
        </td>
        <td data-label="Fecha de compra">
            <span class="mv-date">{{ $voucher->vd_fecha_compra!='' ? $voucher->vd_fecha_compra->format('d/m/Y') : '' }}</span>
        </td>
        <td data-label="Fecha de vencimiento">
            <span class="mv-date">{{ $voucher->rub_fecha_vencimiento!='' ? $voucher->rub_fecha_vencimiento->format('d/m/Y') : '' }}</span>
        </td>
        <td class="text-center" data-label="Estado de canje">
            @php
                $estado = estado($voucher->vd_estado_3);
            @endphp

            <span class="mv-status {{ $estado['class'] }}" title="{{ $estado['text'] }}">
                <i class="bi bi-{{ $estado['icon'] }}"></i>
            </span>
        </td>
        <td class="text-center" data-label="PDF">
            <button type="button" class="mv-pdf-btn" title="Descargar voucher">
                <i class="bi bi-file-earmark-pdf"></i>
            </button>
        </td>
    </tr>
@endforeach