
@for($i = 1; $i <= $influencers->lastPage(); $i++)
    <button onclick="carga_influencers({{ $i }})" class="btn commerce-page-btn {{ $i == $influencers->currentPage() ? 'active' : '' }}">
        {{ $i }}
    </button>
@endfor