@extends('layouts.app')

@section('content')

<main class="vs-page vh-page">
    @include('partials.navbar')

    @php
        $heroVoucher = $vouchers->first();
        $heroVoucherImage = $heroVoucher && $heroVoucher->imagenes->isNotEmpty()
            ? $heroVoucher->imagenes->first()->vf_img_path
            : null;

        $logoEntidad = $entidad->logo
            ? asset('storage/' . $entidad->logo)
            : asset('images/default-brand.png');

        $heroImage = $heroVoucherImage
            ? asset('storage/' . $heroVoucherImage)
            : $logoEntidad;

        $totalVouchers = $vouchers->count();
        $precioDesde = $vouchers->isNotEmpty() ? $vouchers->min('vou_monto_fijo') : null;
    @endphp

    <section class="ve-hero">
        <div class="vs-container">

            {{-- <div class="vs-text-link ve-hero__breadcrumb">
                Vouchers &gt; Entidad &gt; {{ $entidad->nombre }}
            </div> --}}

            <div class="ve-hero__banner">
                <div class="ve-hero__overlay"></div>

                <div class="ve-hero__content">
                    <div class="ve-hero__logo-card">
                        <img src="{{ $logoEntidad }}" alt="{{ $entidad->nombre }}">
                    </div>

                    <div class="ve-hero__info">
                        <span class="vs-eyebrow ve-hero__eyebrow">Entidad</span>

                        <h1 class="ve-hero__title">
                            {{ $entidad->nombre }}
                        </h1>

                        <p class="ve-hero__text">
                            Conocé las propuestas disponibles para canjear en esta entidad.
                        </p>

                        <div class="ve-hero__badges">
                            <span>{{ $totalVouchers }} {{ $totalVouchers === 1 ? 'voucher disponible' : 'vouchers disponibles' }}</span>

                            @if (!is_null($precioDesde))
                                <span>Desde ${{ number_format($precioDesde, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="vs-section-lg">
        <div class="vs-container">

            <div class="vs-section-heading vs-mb-md">
                <span class="vs-section-line"></span>
                <h2 class="vs-title-lg">Vouchers disponibles</h2>
            </div>

            @if ($vouchers->isNotEmpty())
                <div class="vs-grid vs-grid-3 vs-gap-md">
                    @foreach ($vouchers as $voucher)
                        @php
                            $imagenPrincipal = $voucher->imagenes->first();
                        @endphp

                        <article class="vs-card vs-voucher-card">
                            <div class="vs-card-image vs-voucher-card__image">
                                <img
                                    src="{{ $imagenPrincipal && $imagenPrincipal->vf_img_path != '' ? asset('storage/' . $imagenPrincipal->vf_img_path) : asset('images/default-voucher.png') }}"
                                    alt="{{ $voucher->vou_nombre }}"
                                >
                            </div>

                            <div class="vs-card-body vs-voucher-card__body">
                                <div class="vs-badge-list vs-mb-xs">
                                    <span class="vs-badge vs-badge-primary">Voucher</span>
                                </div>

                                <h3 class="vs-card-title">
                                    {{ $voucher->vou_nombre }}
                                </h3>

                                <p class="vs-card-text vs-mb-sm">
                                    {{ $voucher->vou_descripcion }}
                                </p>

                                <div class="vs-voucher-card__footer">
                                    <p class="vs-card-price">
                                        <strong>${{ number_format($voucher->vou_monto_fijo, 0, ',', '.') }}</strong>
                                    </p>

                                    <a href="{{ route('vouchers.comprar', $voucher->vou_id) }}" class="vs-btn vs-btn-primary">
                                        Comprar
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="vs-highlight vs-text-center">
                    <h2 class="vs-title-lg">No hay vouchers disponibles</h2>
                    <p class="vs-text vs-text-muted">
                        Esta entidad todavía no tiene vouchers publicados.
                    </p>
                </div>
            @endif

        </div>
    </section>
</main>

@include('partials.footer')

<style>
    .ve-hero {
        padding: 52px 0 34px;
        background: linear-gradient(180deg, #eef5ff 0%, #ffffff 100%);
    }

    .ve-hero__breadcrumb {
        margin-bottom: 18px;
    }

    .ve-hero__banner {
        position: relative;
        min-height: 390px;
        overflow: hidden;
        border-radius: 34px;
        box-shadow: 0 24px 65px rgba(28, 63, 119, .16);
        background: #1f3f78;
    }

    .ve-hero__cover {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: .34;
        filter: saturate(1.05);
    }

    .ve-hero__overlay {
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 78% 20%, rgba(255, 255, 255, .22), transparent 30%),
            linear-gradient(90deg, rgba(24, 61, 124, .96) 0%, rgba(37, 89, 169, .84) 50%, rgba(18, 46, 94, .70) 100%);
    }

    .ve-hero__content {
        position: relative;
        z-index: 2;
        min-height: 390px;
        display: flex;
        align-items: flex-end;
        gap: 24px;
        padding: 44px;
    }

    .ve-hero__logo-card {
        width: 132px;
        height: 132px;
        flex: 0 0 132px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 18px;
        border-radius: 26px;
        background: #ffffff;
        box-shadow: 0 20px 45px rgba(0, 0, 0, .18);
    }

    .ve-hero__logo-card img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .ve-hero__info {
        max-width: 680px;
        color: #ffffff;
    }

    .ve-hero__eyebrow {
        color: rgba(255, 255, 255, .82);
    }

    .ve-hero__title {
        margin: 8px 0 10px;
        font-size: clamp(2.4rem, 5vw, 4.7rem);
        line-height: .95;
        font-weight: 900;
        letter-spacing: -.05em;
        color: #ffffff;
    }

    .ve-hero__text {
        max-width: 560px;
        margin: 0 0 20px;
        font-size: 1.08rem;
        color: rgba(255, 255, 255, .82);
    }

    .ve-hero__badges {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .ve-hero__badges span {
        display: inline-flex;
        align-items: center;
        min-height: 38px;
        padding: 8px 16px;
        border: 1px solid rgba(255, 255, 255, .32);
        border-radius: 999px;
        background: rgba(255, 255, 255, .15);
        color: #ffffff;
        font-size: .93rem;
        font-weight: 700;
        backdrop-filter: blur(8px);
    }

    .vs-voucher-card__footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding-top: 16px;
        margin-top: auto;
        border-top: 1px solid rgba(17, 24, 39, .08);
    }

    .vs-voucher-card__body {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    @media (max-width: 768px) {
        .ve-hero {
            padding-top: 28px;
        }

        .ve-hero__banner,
        .ve-hero__content {
            min-height: 430px;
        }

        .ve-hero__content {
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-end;
            padding: 28px;
        }

        .ve-hero__logo-card {
            width: 104px;
            height: 104px;
            flex-basis: 104px;
            border-radius: 22px;
        }
    }
    .vs-voucher-card {
    display: flex;
    flex-direction: column;
    height: 100%;
    overflow: hidden;
}

.vs-voucher-card__image {
    height: 235px;
    flex-shrink: 0;
}

.vs-voucher-card__image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.vs-voucher-card__body {
    display: flex;
    flex-direction: column;
    flex: 1;
    padding: 1rem;
}

.vs-card-text {
    margin-bottom: 1rem;
}

.vs-voucher-card__footer {
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}

.vs-card-price {
    margin: 0;
}
</style>

@endsection
