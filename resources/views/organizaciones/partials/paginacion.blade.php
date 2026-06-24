
@for($i = 1; $i <= $organizaciones->lastPage(); $i++)
    <button onclick="carga_organizaciones({{ $i }})" class="btn commerce-page-btn {{ $i == $organizaciones->currentPage() ? 'active' : '' }}">
        {{ $i }}
    </button>
@endfor