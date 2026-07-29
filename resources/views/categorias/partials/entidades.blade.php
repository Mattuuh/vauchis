@if ($entidades->isNotEmpty())

<div class="vo-grid">
    @foreach ($entidades as $entidad)
        @php
            $image = optional($entidad->imagenPrincipal)->ef_img_path;
            $imageUrl = $image 
                ? asset('storage/' . $image) 
                : asset('images/default-voucher.png');

            $commerceName = $entidad->ent_nombre_fantasia ?? 'Comercio';

            $price = $entidad->vou_monto_fijo ?? 10000;
        @endphp

        <article class="vo-card">
            <a href="{{ route('vouchers.entidad', $entidad->ent_id) }}" class="vo-card-link">
                <div class="vo-card-image">
                    <img src="{{ $imageUrl }}" alt="{{ $entidad->ent_nombre_fantasia }}">
                </div>

                <div class="vo-card-body">
                    <div>
                        <h3>{{ $commerceName }}</h3>
                        <p>{{ $entidad->vou_nombre }}</p>
                    </div>

                    <span class="vo-price">
                        desde ${{ number_format($price, 0, ',', '.') }}
                    </span>
                </div>
            </a>
        </article>
    @endforeach
</div>

@else

    <div class="alert alert-info mb-0">
        No hay entidades disponibles para este rubro.
    </div>

@endif