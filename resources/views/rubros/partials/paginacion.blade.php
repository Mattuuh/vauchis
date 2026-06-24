
@for($i = 1; $i <= $rubros->lastPage(); $i++)
    <button onclick="carga_rubros({{ $i }})" class="btn commerce-page-btn {{ $i == $rubros->currentPage() ? 'active' : '' }}">
        {{ $i }}
    </button>
@endfor