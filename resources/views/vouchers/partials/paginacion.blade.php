
@for($i = 1; $i <= $vouchers->lastPage(); $i++)
    <button onclick="carga_vouchers({{ $i }})" class="btn commerce-page-btn {{ $i == $vouchers->currentPage() ? 'active' : '' }}">
        {{ $i }}
    </button>
@endfor