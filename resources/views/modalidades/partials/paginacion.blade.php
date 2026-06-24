
@for($i = 1; $i <= $modalidades->lastPage(); $i++)
    <button onclick="carga_modalidades({{ $i }})" class="btn commerce-page-btn {{ $i == $modalidades->currentPage() ? 'active' : '' }}">
        {{ $i }}
    </button>
@endfor