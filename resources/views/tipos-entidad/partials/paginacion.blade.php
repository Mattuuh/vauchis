
@for($i = 1; $i <= $tipos_entidad->lastPage(); $i++)
    <button onclick="carga_tipos_entidad({{ $i }})" class="btn commerce-page-btn {{ $i == $tipos_entidad->currentPage() ? 'active' : '' }}">
        {{ $i }}
    </button>
@endfor