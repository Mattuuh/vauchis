@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/vauchis-brand-profile.css') }}">
@endpush

@section('content')

<main class="vp-brand-page">
    @include('partials.navbar')

    @php
        $heroVoucher = $vouchers->first();
        $heroVoucherImage = $heroVoucher && $heroVoucher->imagenes->isNotEmpty() ? $heroVoucher->imagenes->first()->vf_img_path : null;

        $logo = $influencer->logoPrincipal?->if_img_path ? asset('storage/' . $influencer->logoPrincipal->if_img_path) : '#';

        $heroImage = $influencer->imagenPrincipal?->if_img_path ? asset('storage/' . $influencer->imagenPrincipal->if_img_path) : false;

        $resaltador = $influencer->resaltador_entidad;

        $fixedAmounts = $fixedAmounts ?? [];
        $productVouchers = $productVouchers ?? $vouchers ?? [];

        $totalVouchers = $vouchers->count();
        $precioDesde = $vouchers->isNotEmpty() ? $vouchers->min('vou_monto_fijo') : null;
    @endphp

    @if ($heroImage)
    <section class="vp-brand-hero">
        <img src="{{ asset($heroImage) }}" alt="{{ $influencer->inf_nombre_fantasia ?? 'Comercio' }}">
    </section>
    @else
    <section class="vp-brand-hero" style="height: 12vh !important; {{ $influencer->inf_color_fondo!='' ? 'background: '.$influencer->inf_color_fondo.' !important' : '' }}"></section>
    @endif

    <section class="vp-brand-info" style="{{ $influencer->inf_color_fondo!='' ? 'background: '.$influencer->inf_color_fondo.' !important' : '' }}">
        <div class="vp-brand-shell vp-brand-info__inner">

            <div class="vp-brand-main">
                @if($logo)
                <div class="vp-brand-logo">
                    <img src="{{ asset($logo) }}" alt="{{ $influencer->inf_nombre_fantasia ?? 'Comercio' }}">
                </div>
                @else
                <div class="vp-brand-logo" style="{{ $influencer->inf_color_fondo!='' ? 'background: '.$influencer->inf_color_fondo.' !important; border: none !important;' : '' }}"></div>
                @endif

                <div>
                    @if ($resaltador)
                        <span class="vp-brand-badge" style="{{ $resaltador->resal_color_fondo!='' ? 'background: '.$resaltador->resal_color_fondo.' !important;' : '' }} {{ $resaltador->resal_color!='' ? 'color: '.$resaltador->resal_color.' !important' : '' }}">
                            ★ {{ $resaltador->resal_nombre }}
                        </span>
                    @endif

                    <h1>{{ $influencer->inf_nombre_fantasia ?? 'Nombre del comercio' }}</h1>

                    <p class="vp-brand-category">
                        {{ $influencer->inf_descripcion_publica ?? 'Comercio' }}
                    </p>

                    @if(!empty($precioDesde))
                        <p class="vp-brand-price">
                            Desde ${{ number_format($precioDesde, 0, ',', '.') }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- <div class="vp-brand-meta">
            @foreach ($entidades as $entidad)
                @if(!empty($entidad->ent_nombre_fantasia))
                    <span>{{ $entidad->ent_nombre_fantasia }}</span>
                @endif
            @endforeach
            </div> --}}

        </div>
    </section>

    <section class="vp-brand-content">
        {{-- <div class="vp-brand-shell">
            @foreach($vouchers_fijos as $voucher)
            <article class="vp-voucher-box vp-voucher-box--green">
                    @php
                        $image = $voucher->image ?? $voucher->imagenes->first()->vf_img_path ?? 'images/default-voucher.png';
                    @endphp
                    <img src="{{ asset('images/perfildemarca-reglao-verde.png') }}" alt="{{ $voucher->vou_nombre ?? $voucher->name }}" class="vp-gift-icon">

                    <div class="vp-voucher-box__content">
                        <h2>Monto fijo</h2>
                        <p>Opciones del comercio</p>

                        <div class="vp-fixed-options">
                            @foreach($voucher->modalidadValores as $campo)
                                <button type="button" class="voucher-monto-btn" data-monto="{{ $campo->vmv_monto_fijo }}" data-url="{{ route('vouchers.precompra', ['voucher' => $voucher->vou_id, 'modalidadCampo' => $campo->vmv_id]) }}">${{ number_format($campo->vmv_monto_fijo, 0, ',', '.') }}</button>
                            @endforeach
                        </div>
                    </div>
            </article>
            @endforeach

            @foreach($vouchers_eleccion as $voucher)
                @php
                    $image = $voucher->image ?? $voucher->imagenes->first()->vf_img_path ?? 'images/default-voucher.png';
                @endphp
                <article class="vp-voucher-box vp-voucher-box--blue">
                    <img src="{{ asset('images/perfildemarca-regalo-azul.png') }}" alt="" class="vp-gift-icon">

                    <div class="vp-voucher-box__content">
                        <h2>Monto a elección</h2>
                        <p>Elige el monto que quieras regalar</p>

                        <div class="vp-custom-form">
                        @foreach($voucher->modalidadValores as $campo)
                            <input type="text" name="amount" class="voucher-monto-input" min="{{ $campo->vmv_monto_minimo }}" max="{{ $campo->vmv_monto_maximo }}" placeholder="Ingresa el monto que quieras regalar" data-url="{{ route('vouchers.precompra', ['voucher' => $voucher->vou_id, 'modalidadCampo' => $campo->vmv_id]) }}">
                            <small class="vp-amount-help">Podes ingresar monto superior a <b>${{ number_format($campo->vmv_monto_minimo,2,',','.') }}</b> y menor a <b>${{ number_format($campo->vmv_monto_maximo,2,',','.') }}</b>.</small>
                        @endforeach
                        </div>
                    </div>
                </article>
            @endforeach --}}

            <section class="vp-products-section">
                <h2>Vouchers sugeridos</h2>
                {{-- <p>Regala vouchers de productos específicos seleccionados por el comercio</p> --}}

                <div class="vp-products-wrap">
                    {{-- <button class="vp-products-arrow vp-products-arrow--left" type="button">‹</button> --}}
                    <img class="vp-products-arrow vp-products-arrow--left" src="{{ asset('images/chevron-left.png') }}" alt="Fecha izquierda">

                    <div class="vp-products-grid">
                        @foreach($productVouchers as $voucher)
                            @php
                                $image = $voucher->image ?? $voucher->imagenes->first()->vf_img_path ?? 'images/default-voucher.png';
                            @endphp
                            @foreach($voucher->modalidadValores as $campo)

                                <a href="{{ route('vouchers.precompra', ['voucher' => $voucher->vou_id, 'modalidadCampo' => $campo->vmv_id]) }}" class="vp-product-card">
                                    <div class="vp-product-image">
                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $voucher->vou_nombre }}">
                                    </div>

                                    <div class="vp-product-info">
                                        <h3 class="vp-product-title">{{ $voucher->vou_nombre }}</h3>

                                        <div class="vp-product-footer">
                                            <p class="vp-product-description">
                                                {{ $voucher->vou_descripcion ?? 'Voucher válido por cualquier producto de un precio similar' }}
                                            </p>
                                            <span class="vp-product-price">
                                                ${{ number_format($campo->vmv_monto_fijo ?? 0, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endforeach
                    </div>

                    {{-- <button class="vp-products-arrow vp-products-arrow--right" type="button">›</button> --}}
                    <img class="vp-products-arrow vp-products-arrow--right" src="{{ asset('images/chevron-right.png') }}" alt="Fecha derecha">
                </div>
            </section>

        </div>
    </section>

    <form id="form-precompra" action="#" method="GET">
        <input type="hidden" name="monto" id="monto-seleccionado">
    </form>

    <div id="resumen-compra" class="resumen-compra">
        <div class="resumen-compra__contenido">
            <div class="resumen-compra__subtotal">
                <span>Subtotal</span>
                <strong id="subtotal-texto">$0</strong>
            </div>
            <button type="button" id="btn-continuar" class="resumen-compra__continuar">Continuar</button>
        </div>
    </div>

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
    font-weight: 800;
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
    flex-wrap: wrap;
    gap: 5px;
    margin-top: 24px;
    /* font-size: 10px; */
    font-weight: 400;
    margin-left: 14%;
}

.vp-brand-meta span {
    display: inline-flex;
    align-items: center;
    margin-right: 5px;
    padding: 8px 10px;
    border: 1px solid rgba(255,255,255,.85);
    border-radius: 4px;
    color: #fff;
    line-height: 1;
    white-space: nowrap;
}

.vp-brand-content {
    padding: 28px 0 70px;
}

.vp-voucher-box {
    max-width: 780px;
    min-height: 165px;
    margin: 0 auto 18px;
    background: #FFFFFF;
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
    color: #49B384;
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
    border: 1.5px solid #49B384;
    color: #49B384;
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
    border-radius: 15px;
    background: transparent;
    padding: 0 16px;
    color: #06307d;
    outline: none;
}

.vp-custom-form input::placeholder {
    color: #4e85ca;
}

.vp-custom-form small {
    display: block;
    margin-top: 5px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.35;
    color: #0065FA;
    letter-spacing: -0.1px;
    max-width: 430px;
}

.vp-amount-help b {
    font-weight: 600;
}

.vp-products-section {
    max-width: 880px;
    margin: 60px auto 0;
}

.vp-products-section h2 {
    /* margin: 0; */
    margin-bottom: 30px;
    font-size: 18px;
    font-weight: 500;
    color: #07378C;
}

/* .vp-products-section p {
    margin: 2px 0 30px;
    color: #000000;
    font-weight: 600;
} */

.vp-products-wrap {
    position: relative;
}

.vp-products-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 26px;
}

.vp-product-card {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 430px;
    background: #fff;
    color: #000;
    text-decoration: none;
    border-radius: 18px;
    overflow: hidden;
    box-shadow:
        0 2px 4px rgba(0, 0, 0, .12),
        0 4px 8px rgba(0, 0, 0, .10);
}

.vp-product-card:hover {
    color: #000;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow:
        0 3px 5px rgba(0, 0, 0, .12),
        0 7px 12px rgba(0, 0, 0, .14);
}

.vp-product-image {
    width: 100%;
    height: 340px;
    flex-shrink: 0;
    overflow: hidden;
    padding: 0;
    margin: 0;
    background: #eee;
    border-radius: 0;
    box-shadow: none;
}

.vp-product-image img {
    display: block;
    width: 100%;
    height: 100%;
    max-width: none;
    max-height: none;
    object-fit: cover;
    object-position: center;
}

.vp-product-info {
    height: 90px;
    display: flex;
    flex-direction: column;
    padding: 15px 16px 13px;
    background: #fff;
}

.vp-product-title {
    margin: 0 !important;
    font-size: 16px !important;
    line-height: 18px !important;
    font-weight: 600 !important;
    color: #111;
}

.vp-product-footer {
    flex: 1;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 15px;
    min-width: 0;
}

.vp-product-description {
    flex: 1;
    margin: 0 !important;
    font-size: 13px;
    line-height: 14px;
    font-weight: 400;
    color: #333;
    max-width: 70%;
}

.vp-product-price {
    margin-left: auto;
    font-size: 12px;
    line-height: 14px;
    font-weight: 400;
    white-space: nowrap;
    color: #333;
}

.vp-products-arrow {
    position: absolute;
    top: 45%;
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
    left: -5%;
}

.vp-products-arrow--right {
    right: -5%;
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
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;

        gap: 5px;

        width: 100%;

        overflow-x: auto;
        overflow-y: hidden;

        margin-top: 18px;
        padding-bottom: 4px;

        -webkit-overflow-scrolling: touch;

        scrollbar-width: none;
    }

    .vp-brand-meta::-webkit-scrollbar {
        display: none;
    }

    .vp-brand-meta span {
        flex: 0 0 auto;
        padding: 8px 10px;
        border: 1px solid rgba(255,255,255,.85);
        border-radius: 4px;
        color: #fff;
        font-size: 16px;
        font-weight: 400;
        line-height: 1;
        white-space: nowrap;
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

@media (max-width: 768px) {
    .vp-voucher-box {
        width: 100%;
        max-width: none;
        min-height: 0;
        margin: 0 0 18px;
        display: grid;
        grid-template-columns: 92px 1fr;
        grid-template-rows: auto auto;
        column-gap: 4px;
        row-gap: 12px;
        align-items: center;
        padding: 14px 10px 12px;
        background: #fff;
        border-radius: 9px;
        box-shadow: 0 3px 6px rgba(0,0,0,.20);
        text-align: left;
    }

    .vp-gift-icon {
        grid-column: 1;
        grid-row: 1;
        width: 88px;
        height: 88px;
        object-fit: contain;
        font-size: initial;
        line-height: normal;
        align-self: center;
        justify-self: center;
    }

    .vp-voucher-box__content {
        display: contents;
    }

    .vp-voucher-box h2 {
        grid-column: 2;
        grid-row: 1;
        align-self: center;
        margin: -16px 0 0;
        font-size: 23px;
        line-height: 1.1;
        font-weight: 400;
    }

    .vp-voucher-box p {
        grid-column: 2;
        grid-row: 1;
        align-self: center;
        margin: 30px 0 0;
        font-size: 15px;
        line-height: 1.15;
        font-weight: 600;
    }

    .vp-fixed-options {
        grid-column: 1 / -1;
        grid-row: 2;
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
        align-items: center;
        gap: 5px;
        width: 100%;
        margin: 0;
    }

    .voucher-monto-btn {
        flex: 1 1 0;
        min-width: 0;
        height: 42px;
        padding: 0 10px;
        border: 1px solid #24b864;
        border-radius: 999px;
        background: #fff;
        color: #24b864;
        font-size: 16px;
        line-height: 1;
        font-weight: 700;
        white-space: nowrap;
    }

    .vp-voucher-box--blue {
        width: 100%;
        max-width: none;
        min-height: 0;
        display: grid;
        grid-template-columns: 92px 1fr;
        grid-template-rows: 95px auto;
        column-gap: 6px;
        row-gap: 14px;
        align-items: center;
        padding: 10px 10px 14px;
        margin: 0 0 18px;
        background: #fff;
        border-radius: 9px;
        box-shadow: 0 3px 6px rgba(0,0,0,.20);
    }

    /* Hace que los hijos internos participen del grid principal */
    .vp-voucher-box--blue .vp-voucher-box__content {
        display: contents;
    }

    .vp-voucher-box--blue .vp-gift-icon {
        grid-column: 1;
        grid-row: 1;
        width: 92px;
        height: 92px;
        object-fit: contain;
        justify-self: start;
        align-self: center;
    }

    .vp-voucher-box--blue h2 {
        grid-column: 2;
        grid-row: 1;
        align-self: center;
        margin: -25px 0 0 0;
        padding: 0;
        font-size: 22px;
        line-height: 1.05;
        font-weight: 400;
        text-align: left;
        color: #0065FA;
    }

    .vp-voucher-box--blue p {
        grid-column: 2;
        grid-row: 1;
        align-self: center;
        margin: 31px 0 0 0;
        padding: 0;
        font-size: 15px;
        line-height: 1.15;
        font-weight: 600;
        text-align: left;
        color: #0065FA;
    }

    .vp-voucher-box--blue .vp-custom-form {
        grid-column: 1 / -1;
        grid-row: 2;
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .vp-custom-form small {
        margin-top: 6px;
        font-size: 12px;
        line-height: 1.4;
        max-width: 100%;
    }

    .vp-voucher-box--blue .voucher-monto-input {
        display: block;
        width: 100%;
        height: 48px;
        box-sizing: border-box;
        padding: 0 18px;
        border: 1px solid #0065FA;
        border-radius: 16px;
        background: #fff;
        color: #0065FA;
        font-size: 15px;
        font-weight: 400;
        outline: none;
    }

    .vp-voucher-box--blue .voucher-monto-input::placeholder {
        color: #4a86ff;
        opacity: 1;
    }



    .vp-products-grid {
        display: flex;
        flex-wrap: nowrap;
        gap: 8px;
        /* width: 100%; */
        overflow-x: auto;
        overflow-y: hidden;
        /* Escapa del padding del padre */
        width: calc(100% + 20px);
        margin-right: -20px;
        padding: 4px 0 12px 0;

        scroll-snap-type: x proximity;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .vp-products-grid::-webkit-scrollbar {
        display: none;
    }

    .vp-product-card {
        position: relative;
        flex: 0 0 44%;
        width: 44%;
        max-width: 44%;
        height: 280px;
        display: block;
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
        scroll-snap-align: start;
        box-shadow:
            0 2px 4px rgba(0, 0, 0, .18),
            0 4px 8px rgba(0, 0, 0, .14);
    }

    .vp-product-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 0;
        border-radius: 0;
        box-shadow: none;
        overflow: hidden;
    }

    .vp-product-image img {
        width: 100%;
        height: 100%;
        max-width: none;
        max-height: none;
        object-fit: cover;
        object-position: center;
        display: block;
    }

    .vp-product-card::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 48%;
        background: linear-gradient(
            to top,
            rgba(0, 0, 0, .88) 0%,
            rgba(0, 0, 0, .60) 35%,
            rgba(0, 0, 0, .18) 72%,
            rgba(0, 0, 0, 0) 100%
        );
        pointer-events: none;
        z-index: 1;
    }

    .vp-product-info {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: auto;
        padding: 0 14px 15px;
        background: transparent;
        color: #fff;
        z-index: 2;
        display: flex;
        flex-direction: column;
    }

    .vp-product-title {
        margin: 0 0 4px !important;
        font-size: 14px !important;
        line-height: 16px !important;
        font-weight: 600 !important;
        color: #fff !important;
    }

    .vp-product-footer {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 2px;
        margin: 0;
    }

    .vp-product-price {
        order: 1;
        margin: 0;
        font-size: 13px;
        line-height: 15px;
        font-weight: 400;
        color: #fff;
        white-space: nowrap;
    }

    .vp-product-description {
        order: 2;
        margin: 0 !important;
        max-width: 100%;
        font-size: 9px;
        line-height: 11px;
        font-weight: 400;
        color: rgba(255,255,255,.90);
    }
}

.voucher-montos {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.voucher-monto-btn {
    min-width: 86px;
    padding: 8px 18px;
    border: 1px solid #49B384;
    border-radius: 30px;
    background: #ffffff;
    color: #49B384;
    font-family: "Montserrat", sans-serif;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition:
        background-color 0.2s ease,
        color 0.2s ease,
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.voucher-monto-btn:hover {
    background: #eefaf2;
    transform: translateY(-1px);
}

.voucher-monto-btn.is-selected {
    background: #49B384;
    color: #ffffff;
    box-shadow: 0 5px 12px rgba(53, 177, 86, 0.25);
}

/* Barra inferior */

.resumen-compra {
    position: fixed;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1050;

    padding: 16px 30px;
    background: #123f91;

    transform: translateY(100%);
    opacity: 0;
    visibility: hidden;

    transition:
        transform 0.3s ease,
        opacity 0.3s ease,
        visibility 0.3s ease;
}

.resumen-compra.is-visible {
    transform: translateY(0);
    opacity: 1;
    visibility: visible;
}

.resumen-compra__contenido {
    width: 100%;
    max-width: 1280px;
    min-height: 72px;
    margin: 0 auto;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
}

.resumen-compra__subtotal {
    display: flex;
    flex-direction: column;
    color: #ffffff;
}

.resumen-compra__subtotal span {
    margin-bottom: 2px;
    font-size: 12px;
    font-weight: 400;
    text-transform: uppercase;
}

.resumen-compra__subtotal strong {
    font-size: 24px;
    line-height: 1;
    font-weight: 600;
}

.resumen-compra__continuar {
    min-width: 180px;
    padding: 14px 30px;
    border: 0;
    border-radius: 30px;
    background: #0875ff;
    color: #ffffff;
    font-family: "Montserrat", sans-serif;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition:
        background-color 0.2s ease,
        transform 0.2s ease;
}

.resumen-compra__continuar:hover {
    background: #0064dd;
    transform: translateY(-1px);
}

/*
 * Evita que la barra tape el contenido cuando está visible.
 * Esta clase se agregará al body mediante JavaScript.
 */
body.resumen-compra-visible {
    padding-bottom: 105px;
}

@media (max-width: 576px) {
    .resumen-compra {
        padding: 14px 18px;
    }

    .resumen-compra__contenido {
        min-height: 65px;
        gap: 15px;
    }

    .resumen-compra__subtotal strong {
        font-size: 21px;
    }

    .resumen-compra__continuar {
        min-width: 135px;
        padding: 12px 22px;
    }
}
    </style>
@endpush

@push('scripts')
<script>
$(document).ready(function () {
    const resumenCompra = $('#resumen-compra');
    const subtotalTexto = $('#subtotal-texto');
    const montoSeleccionado = $('#monto-seleccionado');
    const formPrecompra = $('#form-precompra');

    function formatearMoneda(valor) {
        return new Intl.NumberFormat('es-AR', {
            style: 'currency',
            currency: 'ARS',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(valor);
    }


    $(document).on('click', '.voucher-monto-btn', function () {

        const botonSeleccionado = $(this);

        // Si ya estaba seleccionado, deseleccionar
        if (botonSeleccionado.hasClass('is-selected')) {

            botonSeleccionado
                .removeClass('is-selected')
                .attr('aria-pressed', 'false');

            $('#monto-seleccionado').val('');
            $('#subtotal-texto').text('$0');

            formPrecompra.attr('action', '#');
            $('#resumen-compra').removeClass('is-visible');
            $('body').removeClass('resumen-compra-visible');

            return;
        }

        const monto = Number(botonSeleccionado.data('monto'));
        const url = botonSeleccionado.data('url');

        if (!Number.isFinite(monto) || monto <= 0) {
            return;
        }

        // Quitar selección anterior
        $('.voucher-monto-btn')
            .removeClass('is-selected')
            .attr('aria-pressed', 'false');

        // Marcar el nuevo botón
        botonSeleccionado
            .addClass('is-selected')
            .attr('aria-pressed', 'true');

        $('#monto-seleccionado').val(monto);
        $('#subtotal-texto').text(formatearMoneda(monto));

        formPrecompra.attr('action', url);
        $('#resumen-compra').addClass('is-visible');
        $('body').addClass('resumen-compra-visible');
    });

    $(document).on('input', '.voucher-monto-input', function () {

        const input = $(this);

        const minimo = Number(input.attr('min'));
        const maximo = Number(input.attr('max'));
        const url = input.data('url');

        input.rules('add', {
            required: true,
            number: true,
            min: Number(input.attr('min')),
            max: Number(input.attr('max')),
            messages: {
                min: 'El monto mínimo es $' + formatearMoneda(input.attr('min')),
                max: 'El monto máximo es $' + formatearMoneda(input.attr('max'))
            }
        });

        // Eliminar puntos y reemplazar coma por punto si hiciera falta
        let valor = input.val()
            .replace(/\./g, '')
            .replace(',', '.');

        valor = Number(valor);

        // Si el usuario selecciona un monto manual,
        // deseleccionamos cualquier botón.
        $('.voucher-monto-btn')
            .removeClass('is-selected')
            .attr('aria-pressed', 'false');

        if (!Number.isFinite(valor) || valor < minimo || valor > maximo) {

            $('#monto-seleccionado').val('');
            $('#subtotal-texto').text('$0');

            formPrecompra.attr('action', '#');
            $('#resumen-compra').removeClass('is-visible');
            $('body').removeClass('resumen-compra-visible');

            return;
        }

        $('#monto-seleccionado').val(valor);
        $('#subtotal-texto').text(formatearMoneda(valor));

        formPrecompra.attr('action', url);
        $('#resumen-compra').addClass('is-visible');
        $('body').addClass('resumen-compra-visible');

    });

    $('#btn-continuar').on('click', function () {
        const monto = montoSeleccionado.val();

        if (!monto) {
            return;
        }

        formPrecompra.trigger('submit');
    });
});
</script>
@endpush