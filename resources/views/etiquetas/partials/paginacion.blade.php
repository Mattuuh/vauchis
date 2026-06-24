
@for($i = 1; $i <= $etiquetas->lastPage(); $i++)
    <button onclick="carga_etiquetas({{ $i }})" class="btn commerce-page-btn {{ $i == $etiquetas->currentPage() ? 'active' : '' }}">
        {{ $i }}
    </button>
@endfor