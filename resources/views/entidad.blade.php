@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/vauchis-brand-profile.css') }}">
@endpush

@section('content')

<main class="vp-brand-page">
    @include('partials.navbar')

    {{-- Tu navbar ya va en el layout o partial --}}

    @php
        $heroVoucher = $vouchers->first();
        $heroVoucherImage = $heroVoucher && $heroVoucher->imagenes->isNotEmpty()
            ? $heroVoucher->imagenes->first()->vf_img_path
            : null;

        $logo = $entidad->logo
            ? asset('storage/' . $entidad->logo)
            : asset('images/default-brand.png');

        $heroImage = $heroVoucherImage
            ? asset('storage/' . $heroVoucherImage)
            : $logo;

        $fixedAmounts = $fixedAmounts ?? [];
        $productVouchers = $productVouchers ?? $vouchers ?? [];

        $totalVouchers = $vouchers->count();
        $precioDesde = $vouchers->isNotEmpty() ? $vouchers->min('vou_monto_fijo') : null;
    @endphp

    <section class="vp-brand-hero">
        @if (isset($heroImage))
            <img src="{{ asset($heroImage) }}" alt="{{ $entidad->nombre ?? 'Comercio' }}">
        @endif
    </section>

    <section class="vp-brand-info">
        <div class="vp-brand-shell vp-brand-info__inner">

            <div class="vp-brand-main">
                <div class="vp-brand-logo">
                    @if($logo)
                        <img src="{{ asset($logo) }}" alt="{{ $entidad->nombre ?? 'Comercio' }}">
                    @else
                        <span>{{ strtoupper(substr($entidad->nombre ?? 'V', 0, 1)) }}</span>
                    @endif
                </div>

                <div>
                    @if(!empty($brand->recommended))
                        <span class="vp-brand-badge">★ Recomendado</span>
                    @endif

                    <h1>{{ $entidad->nombre ?? 'Nombre del comercio' }}</h1>

                    <p class="vp-brand-category">
                        {{ $entidad->type ?? 'Comercio' }}
                        @if(!empty($entidad->category))
                            | {{ $entidad->category }}
                        @endif
                    </p>

                    @if(!empty($precioDesde))
                        <p class="vp-brand-price">
                            Desde ${{ number_format($precioDesde, 0, ',', '.') }}
                        </p>
                    @endif
                </div>
            </div>

            @foreach ($domicilios as $domicilio)
                @if(!empty($domicilio->org_id)) 
                    <div class="vp-brand-shopping">
                        <span>Parte de:</span>{{ $domicilio->organizacion->org_nombre }}
                    </div>
                @endif
            @endforeach

            @foreach ($domicilios as $domicilio)
                @if(!empty($domicilio->org_id)) 
                    <div class="vp-brand-meta">
                        @if(!empty($domicilio->ed_direccion))
                            <span>{{ $domicilio->ed_direccion }}</span>
                        @endif
                    </div>
                @endif
            @endforeach

            {{-- <div class="vp-brand-meta">
                @if(!empty($entidad->ent_direccion))
                    <span>{{ $entidad->ent_direccion }}</span>
                @endif

                @if(!empty($entidad->schedule))
                    <span>{{ $entidad->schedule }}</span>
                @endif
            </div> --}}

        </div>
    </section>

    <section class="vp-brand-content">
        <div class="vp-brand-shell">

            <article class="vp-voucher-box vp-voucher-box--green">
                {{-- <div class="vp-gift-icon">🎁</div> --}}
                <img src="{{ asset('images/perfildemarca-reglao-verde.png') }}" alt="" class="vp-gift-icon">

                <div class="vp-voucher-box__content">
                    <h2>Monto fijo</h2>
                    <p>Opciones del comercio</p>

                    <div class="vp-fixed-options">
                        @foreach($fixedAmounts as $amount)
                            <a href="{{ route('checkout.voucher', $amount->vou_id ?? $amount->id) }}">
                                ${{ number_format($amount->amount ?? $amount->vou_monto_fijo, 0, ',', '.') }}
                            </a>
                        @endforeach
                        <a href="#">
                            ${{ number_format(25000, 0, ',', '.') }}
                        </a>
                        <a href="#">
                            ${{ number_format(50000, 0, ',', '.') }}
                        </a>
                        <a href="#">
                            ${{ number_format(120000, 0, ',', '.') }}
                        </a>
                    </div>
                </div>
            </article>

            <article class="vp-voucher-box vp-voucher-box--blue">
                {{-- <div class="vp-gift-icon">🎁</div> --}}
                <img src="{{ asset('images/perfildemarca-regalo-azul.png') }}" alt="" class="vp-gift-icon">

                <div class="vp-voucher-box__content">
                    <h2>Monto a elección</h2>
                    <p>Elige el monto que quieras regalar</p>

                    <form action="" method="POST" class="vp-custom-form">
                        @csrf
                        <input type="text" name="amount" min="1" placeholder="Ingresa el monto que quieras regalar">
                    </form>
                </div>
            </article>

            <section class="vp-products-section">
                <h2>Vouchers seleccionados por el comercio</h2>
                {{-- <p>Regala vouchers de productos específicos seleccionados por el comercio</p> --}}

                <div class="vp-products-wrap">
                    {{-- <button class="vp-products-arrow vp-products-arrow--left" type="button">‹</button> --}}
                    <img class="vp-products-arrow vp-products-arrow--left" src="{{ asset('images/icono-bt-izquierda.png') }}" alt="Fecha izquierda">

                    <div class="vp-products-grid">
                        @foreach($productVouchers as $voucher)
                            @php
                                $image = $voucher->image
                                    ?? $voucher->imagenes->first()->vf_img_path
                                    ?? 'images/default-voucher.png';

                                $price = $voucher->price
                                    ?? $voucher->vou_monto_fijo
                                    ?? 0;
                            @endphp

                            <a href="{{ route('vouchers.comprar', $voucher->vou_id ?? $voucher->id) }}" class="vp-product-card">
                                <div class="vp-product-image">
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $voucher->vou_nombre ?? $voucher->name }}">
                                </div>

                                <h3>{{ $voucher->vou_nombre ?? $voucher->name }}</h3>
                                <p>${{ number_format($price, 0, ',', '.') }}</p>
                            </a>
                        @endforeach
                    </div>

                    {{-- <button class="vp-products-arrow vp-products-arrow--right" type="button">›</button> --}}
                    <img class="vp-products-arrow vp-products-arrow--right" src="{{ asset('images/icono-bt-derecha.png') }}" alt="Fecha derecha">
                </div>
            </section>

        </div>
    </section>

    {{-- Tu footer ya va en el layout o partial --}}

</main>

@include('partials.footer')

@endsection

@push('styles')
    <style>
.vp-brand-page {
    background: #f7f7f7;
    color: #07378C;
    font-family: Montserrat, Arial, sans-serif;
}

.vp-brand-shell {
    width: min(100%, 1060px);
    margin: 0 auto;
    padding: 0 24px;
}

.vp-brand-hero {
    height: 265px;
    overflow: hidden;
    background-color: #07378C;
}

.vp-brand-hero img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.vp-brand-info {
    background: #07378C;
    color: #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,.18);
}

.vp-brand-info__inner {
    position: relative;
    min-height: 165px;
    padding-top: 24px;
    padding-bottom: 28px;
}

.vp-brand-main {
    display: flex;
    align-items: center;
    gap: 22px;
}

.vp-brand-logo {
    width: 118px;
    height: 118px;
    border-radius: 50%;
    background: #fff;
    border: 3px solid #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.vp-brand-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.vp-brand-logo span {
    color: #083f98;
    font-size: 44px;
    font-weight: 800;
}

.vp-brand-badge {
    display: inline-block;
    background: #fff7da;
    color: #083f98;
    font-size: 12px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 10px;
    margin-bottom: 4px;
}

.vp-brand-main h1 {
    margin: 0;
    font-size: 35px;
    line-height: 24px;
    letter-spacing: 0%;
    font-weight: 700;
    font-family: Montserrat, sans-serif;
}

.vp-brand-category,
.vp-brand-price {
    margin: 5px 0 0;
    font-size: 17px;
    line-height: 24px;
    letter-spacing: 0%;
    font-family: Montserrat, sans-serif;
}

.vp-brand-shopping {
    position: absolute;
    top: 34px;
    right: 24px;
    background: #fff;
    color: #000000;
    border-radius: 7px;
    padding: 11px 20px;
    line-height: 24px;
    /* font-size: 14px; */
    font-weight: 500;
    font-family: Montserrat, sans-serif;
    box-shadow: 0 3px 6px rgba(0,0,0,.15);
}

.vp-brand-shopping span {
    margin-right: 6px;
}

.vp-brand-meta {
    display: flex;
    gap: 18px;
    margin-top: 24px;
    font-size: 15px;
    font-weight: 500;
}

.vp-brand-meta span + span::before {
    content: "";
    display: inline-block;
    width: 5px;
    height: 5px;
    background: #fff;
    border-radius: 50%;
    margin-right: 18px;
    vertical-align: middle;
}

.vp-brand-content {
    padding: 28px 0 70px;
}

.vp-voucher-box {
    max-width: 780px;
    min-height: 165px;
    margin: 0 auto 18px;
    background: #e9e9e9;
    border-radius: 9px;
    display: grid;
    grid-template-columns: 230px 1fr;
    align-items: center;
    padding: 22px 34px;
    box-shadow: 0 3px 6px rgba(0,0,0,.20);
}

.vp-gift-icon {
    font-size: 92px;
    line-height: 1;
}

.vp-voucher-box h2 {
    margin: 0;
    font-size: 28px;
    font-weight: 500;
}

.vp-voucher-box p {
    margin: 3px 0 16px;
    font-size: 16px;
    font-weight: 700;
}

.vp-voucher-box--green,
.vp-voucher-box--green h2,
.vp-voucher-box--green p {
    color: #35B156;
}

.vp-voucher-box--blue,
.vp-voucher-box--blue h2,
.vp-voucher-box--blue p {
    color: #0065FA;
}

.vp-fixed-options {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.vp-fixed-options a {
    min-width: 125px;
    text-align: center;
    border: 1.5px solid #35B156;
    color: #35B156;
    background: transparent;
    border-radius: 18px;
    padding: 7px 18px;
    text-decoration: none;
    font-weight: 700;
}

.vp-custom-form input {
    width: min(100%, 430px);
    height: 34px;
    border: 1.5px solid #0065FA;
    border-radius: 10px;
    background: transparent;
    padding: 0 16px;
    color: #06307d;
    outline: none;
}

.vp-custom-form input::placeholder {
    color: #4e85ca;
}

.vp-products-section {
    max-width: 880px;
    margin: 35px auto 0;
}

.vp-products-section h2 {
    /* margin: 0; */
    margin-bottom: 30px;
    font-size: 27px;
    font-weight: 500;
    color: #07378C;
}

.vp-products-section p {
    margin: 2px 0 30px;
    color: #000000;
    font-weight: 600;
}

.vp-products-wrap {
    position: relative;
}

.vp-products-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 26px;
}

.vp-product-card {
    color: #000000;
    font-weight: 400;
    text-decoration: none;
}

.vp-product-image {
    height: 215px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 3px 6px rgba(0,0,0,.18);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 18px;
    margin-bottom: 12px;
}

.vp-product-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.vp-product-card h3 {
    margin: 0;
    font-size: 15px;
    line-height: 1.15;
    font-weight: 500;
}

.vp-product-card strong {
    display: block;
    margin-top: 3px;
    font-size: 15px;
    font-weight: 900;
}

.vp-products-arrow {
    position: absolute;
    top: 88px;
    width: 31px;
    height: 31px;
    border-radius: 50%;
    border: 1px solid #07378C;
    background: transparent;
    /* color: #06307d; */
    font-size: 25px;
    line-height: 1;
    cursor: pointer;
    z-index: 2;
}

.vp-products-arrow--left {
    left: -42px;
}

.vp-products-arrow--right {
    right: -42px;
}

@media (max-width: 768px) {
    .vp-brand-hero {
        height: 190px;
    }

    .vp-brand-info__inner {
        padding-top: 20px;
    }

    .vp-brand-main {
        align-items: flex-start;
    }

    .vp-brand-logo {
        width: 86px;
        height: 86px;
        flex: 0 0 86px;
    }

    .vp-brand-main h1 {
        font-size: 27px;
    }

    .vp-brand-shopping {
        position: static;
        display: inline-block;
        margin-top: 18px;
    }

    .vp-brand-meta {
        flex-direction: column;
        gap: 8px;
    }

    .vp-brand-meta span + span::before {
        display: none;
    }

    .vp-voucher-box {
        grid-template-columns: 1fr;
        text-align: center;
        padding: 24px 18px;
    }

    .vp-gift-icon {
        font-size: 70px;
        margin-bottom: 10px;
    }

    .vp-fixed-options {
        justify-content: center;
    }

    .vp-products-grid {
        grid-template-columns: 1fr;
    }

    .vp-products-arrow {
        display: none;
    }
}
    </style>
@endpush