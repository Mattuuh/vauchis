
@for($i = 1; $i <= $tipos->lastPage(); $i++)
    <button onclick="carga_tipos_modalidad({{ $i }})" class="btn commerce-page-btn {{ $i == $tipos->currentPage() ? 'active' : '' }}">
        {{ $i }}
    </button>
@endfor