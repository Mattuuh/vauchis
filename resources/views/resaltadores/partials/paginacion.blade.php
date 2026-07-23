
@for($i = 1; $i <= $resaltadores->lastPage(); $i++)
    <button onclick="carga_resaltadores({{ $i }})" class="btn commerce-page-btn {{ $i == $resaltadores->currentPage() ? 'active' : '' }}">
        {{ $i }}
    </button>
@endfor