<div class="vo-grid">
    @forelse ($vouchers as $voucher)
        @php
            $image = optional($voucher->imagenes->first())->vf_img_path;
            $imageUrl = $image 
                ? asset('storage/' . $image) 
                : asset('images/default-voucher.png');

            $commerceName = $voucher->entidad->ent_nombre_fantasia ?? 'Comercio';

            $price = $voucher->vou_monto_fijo ?? 0;
        @endphp

        <article class="vo-card">
            <a href="{{ route('vouchers.comprar', $voucher->vou_id) }}" class="vo-card-link">
                <div class="vo-card-image">
                    <img src="{{ $imageUrl }}" alt="{{ $voucher->vou_nombre }}">
                </div>

                <div class="vo-card-body">
                    <div>
                        <h3>{{ $commerceName }}</h3>
                        <p>{{ $voucher->vou_nombre }}</p>
                    </div>

                    <span class="vo-price">
                        desde ${{ number_format($price, 0, ',', '.') }}
                    </span>
                </div>
            </a>
        </article>
    @empty
        <div class="vo-empty">
            No encontramos vouchers disponibles.
        </div>
    @endforelse
</div>

{{-- <div class="vo-pagination">
    {{ $vouchers->links() }}
</div> --}}