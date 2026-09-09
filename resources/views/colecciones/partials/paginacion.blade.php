
@for($i = 1; $i <= $colecciones->lastPage(); $i++)
    <button onclick="carga_colecciones({{ $i }})" class="btn commerce-page-btn {{ $i == $colecciones->currentPage() ? 'active' : '' }}">
        {{ $i }}
    </button>
@endfor