
@for($i = 1; $i <= $entidades->lastPage(); $i++)
    <button onclick="carga_entidades({{ $i }})" class="btn commerce-page-btn {{ $i == $entidades->currentPage() ? 'active' : '' }}">
        {{ $i }}
    </button>
@endfor