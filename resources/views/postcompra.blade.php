@extends('layouts.app')

@push('styles')
<style>
    :root {
        --pc-bg: #f1f3fb;
        --pc-blue: #063e9b;
        --pc-green: #4bb88d;
        --pc-text: #121212;
        --pc-muted: #b7b7bd;
        --pc-border: #0f4cad;
    }

    * { box-sizing: border-box; }

    body {
        background: var(--pc-bg);
    }

    .pc-page {
        min-height: 100vh;
        background: var(--pc-bg);
        color: var(--pc-text);
        font-family: Montserrat, sans-serif;
    }

    .pc-desktop-nav {
        display: block;
    }

    .pc-mobile-header {
        display: none;
    }

    .pc-main {
        max-width: 1220px;
        margin: 0 auto;
        padding: 16vh 32px 90px;
    }

    .pc-title-row {
        display: flex;
        align-items: center;
        gap: 22px;
        margin-bottom: 6px;
    }

    .pc-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        color: #111;
        text-decoration: none;
    }

    .pc-title {
        margin: 0;
        font-size: 34px;
        font-weight: 400;
        line-height: 1;
    }

    .pc-content {
        width: min(560px, 100%);
        margin: 0 auto;
        text-align: center;
    }

    .pc-status-icon {
        width: 118px;
        height: 118px;
        margin: 6px auto 36px;
        border-radius: 50%;
        background: var(--pc-green);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 66px;
        font-weight: 500;
    }

    .pc-confirm-title {
        margin: 0;
        font-size: 36px;
        font-weight: 400;
        line-height: 1.2;
    }

    .pc-confirm-subtitle {
        margin: 0 0 45px;
        color: var(--pc-muted);
        font-size: 16px;
    }

    .pc-gift-image {
        width: 205px;
        height: 160px;
        margin: 0 auto 24px;
        border-radius: 14px;
        overflow: hidden;
        /* background: var(--pc-green); */
        box-shadow: 0 8px 20px rgba(0, 0, 0, .06);
    }

    .pc-gift-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .pc-actions {
        display: flex;
        align-items: flex-start;
        justify-content: center;
        gap: 34px;
        margin-bottom: 42px;
    }

    .pc-action {
        width: 74px;
        color: var(--pc-blue);
        text-decoration: none;
        border: 0;
        background: transparent;
        padding: 0;
        cursor: pointer;
        font: inherit;
    }

    .pc-action-circle {
        width: 58px;
        height: 58px;
        margin: 0 auto 10px;
        border-radius: 50%;
        border: 1.6px solid var(--pc-blue);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .pc-action-circle svg {
        width: 29px;
        height: 29px;
        stroke: currentColor;
    }

    .pc-action-label {
        display: block;
        font-size: 14px;
        white-space: nowrap;
        transform: translateX(-8px);
    }

    .pc-login {
        width: 100%;
        min-height: 72px;
        border: 1.7px solid var(--pc-blue);
        border-radius: 999px;
        padding: 10px 18px 10px 26px;
        display: flex;
        align-items: center;
        text-decoration: none;
        color: var(--pc-blue);
        margin-bottom: 60px;
        background: transparent;
    }

    .pc-login-icon {
        flex: 0 0 46px;
        /* width: 46px;
        height: 46px;
        border: 1.5px solid var(--pc-blue);
        border-radius: 50%; */
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
    }

    /* .pc-login-icon img {
        width: 29px;
        height: 29px;
        stroke: currentColor;
    } */

    .pc-login-copy {
        min-width: 0;
        text-align: left;
        line-height: 1.2;
    }

    .pc-login-copy strong,
    .pc-login-copy span {
        display: block;
    }

    .pc-login-copy strong {
        font-size: 14px;
    }

    .pc-login-copy span {
        color: #4a75c4;
        font-size: 13px;
    }

    .pc-login-button {
        margin-left: auto;
        min-width: 165px;
        border-radius: 999px;
        background: var(--pc-blue);
        color: #fff;
        padding: 13px 24px;
        font-weight: 600;
        text-align: center;
    }

    .pc-notice {
        width: 100%;
        padding: 14px 20px;
        border: 1px solid var(--pc-border);
        background: #dbe6fb;
        color: #4167ac;
        border-radius: 5px;
        font-size: 13px;
        line-height: 1.25;
        margin-bottom: 38px;
    }

    .pc-help {
        display: inline-block;
        color: var(--pc-blue);
        font-weight: 700;
        text-decoration: underline;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .pc-desktop-nav { display: none; }

        .pc-mobile-header {
            height: 82px;
            padding: 0 22px;
            background: #fff;
            display: grid;
            grid-template-columns: 40px 1fr 40px;
            align-items: center;
            box-shadow: 0 3px 8px rgba(0, 0, 0, .22);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .pc-mobile-header a,
        .pc-mobile-header button {
            width: 34px;
            height: 34px;
            border: 0;
            background: transparent;
            color: #111;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            text-decoration: none;
            cursor: pointer;
        }

        .pc-mobile-header h1 {
            margin: 0;
            text-align: center;
            font-size: 22px;
            font-weight: 700;
        }

        .pc-main {
            padding: 44px 28px 78px;
        }

        .pc-title-row { display: none; }

        .pc-content {
            width: 100%;
        }

        .pc-status-icon {
            width: 52px;
            height: 52px;
            margin: 0 auto 8px;
            font-size: 30px;
        }

        .pc-confirm-title {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .pc-confirm-subtitle {
            margin-bottom: 38px;
            font-size: 14px;
        }

        .pc-gift-image {
            width: 235px;
            height: 185px;
            margin-bottom: 30px;
            border-radius: 14px;
        }

        .pc-actions {
            gap: 32px;
            margin-bottom: 48px;
        }

        .pc-action {
            width: 76px;
        }

        .pc-action-circle {
            width: 68px;
            height: 68px;
            margin-bottom: 12px;
        }

        .pc-action-circle svg {
            width: 31px;
            height: 31px;
        }

        .pc-action-label {
            font-size: 14px;
            transform: none;
        }

        .pc-login {
            min-height: 82px;
            padding: 13px 24px;
            margin-bottom: 28px;
        }

        .pc-login-icon {
            flex-basis: 52px;
            width: 52px;
            height: 52px;
            margin-right: 14px;
        }

        .pc-login-copy strong {
            font-size: 15px;
        }

        .pc-login-copy span {
            font-size: 13px;
        }

        .pc-login-button {
            display: none;
        }

        .pc-notice {
            padding: 13px 10px;
            margin-bottom: 22px;
            font-size: 12px;
        }

        .pc-help {
            font-size: 13px;
        }
    }

    @media (max-width: 390px) {
        .pc-main { padding-inline: 20px; }
        .pc-actions { gap: 18px; }
        .pc-gift-image { width: 220px; height: 174px; }
    }

@media (max-width: 768px) {
    .v-mobile-navbar {
        display: none;
    }
}
</style>
@endpush

@section('content')
@php
    $nombreDe = old('de', session('voucher.de', request('de', 'Sole m., Gabi T. & Santi')));
    $mensajeVoucher = old('mensaje', session('voucher.mensaje', request('mensaje', 'Querida Flor, espero que pases un cumple hermoso. Te queremos mucho.')));

    $destinatario = data_get($datos ?? null, 'para')
        ?? session('voucher.para')
        ?? '[Nombre destinatario]';

    $voucherNombre = data_get($voucher ?? null, 'vou_nombre')
        ?? data_get($voucher ?? null, 'nombre')
        ?? 'Voucher';

    $imagenPostcompra = data_get($voucher ?? null, 'imagen_postcompra')
        ?? data_get($voucher ?? null, 'imagenRegalo')
        ?? asset('images/voucher-regalo-verde.png');

    $descargaUrl = $descargaUrl ?? '#';
    $emailUrl = $emailUrl ?? '#';
    $loginUrl = $loginUrl ?? route('login');
    $ayudaUrl = $ayudaUrl ?? '#';
    $volverUrl = $volverUrl ?? url('/');
    $cerrarUrl = $cerrarUrl ?? url('/');
    $emailComprador = data_get($comprador ?? null, 'email') ?? session('checkout_email');
@endphp

<div class="pc-page">
    <div class="pc-desktop-nav">
        @include('partials.navbar')
    </div>

    <header class="pc-mobile-header">
        <a href="{{ $volverUrl }}" aria-label="Volver">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
        </a>
        <h1>¡Listo!</h1>
        <a href="{{ $cerrarUrl }}" aria-label="Cerrar">
            <svg viewBox="0 0 24 24" width="23" height="23" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M6 6l12 12M18 6L6 18"/>
            </svg>
        </a>
    </header>

    <main class="pc-main">
        <div class="pc-title-row">
            <a href="{{ $volverUrl }}" class="pc-back" aria-label="Volver">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </a>
            <h1 class="pc-title">¡Listo!</h1>
        </div>

        <section class="pc-content" aria-labelledby="pc-confirm-title">
            <div class="pc-status-icon" aria-hidden="true">✓</div>

            <h2 class="pc-confirm-title" id="pc-confirm-title">Pago confirmado</h2>
            <p class="pc-confirm-subtitle">
                Tu voucher para {{ $destinatario }} ya está listo
            </p>

            <div class="pc-gift-image" style="background: {{ $entidad->ent_color_fondo ?? '#49b889' }};">
                <img src="{{ $imagenPostcompra }}" alt="{{ $voucherNombre }}">
            </div>

            <div class="pc-actions">
                <a class="pc-action" href="{{ $descargaUrl }}" download>
                    <span class="pc-action-circle">
                        <i class="bi bi-download"></i>
                    </span>
                    <span class="pc-action-label">Descargar</span>
                </a>

                <a class="pc-action" href="{{ $emailUrl }}">
                    <span class="pc-action-circle">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <span class="pc-action-label">Enviar por mail</span>
                </a>

                <button type="button" class="pc-action" id="pc-share-button" data-share-title="{{ $voucherNombre }}" data-share-text="Tu voucher para {{ $destinatario }} ya está listo" data-share-url="{{ $descargaUrl }}">
                    <span class="pc-action-circle">
                        <i class="bi bi-upload"></i>
                    </span>
                    <span class="pc-action-label">Compartir</span>
                </button>
            </div>

            <a href="{{ $loginUrl }}" class="pc-login">
                <span class="pc-login-icon">
                    <img src="{{ asset('images/icono-Perfil.png') }}" alt="Usuario">
                </span>
                <span class="pc-login-copy">
                    <strong>Inicia sesión</strong>
                    <span>Iniciá sesión y comprá más rápido</span>
                </span>
                <span class="pc-login-button">Iniciar sesión</span>
            </a>

            <div class="pc-notice">
                Te enviamos el voucher a tu correo.
                Si no aparece, revisá spam — a veces se esconde ahí.
            </div>

            <a href="{{ $ayudaUrl }}" class="pc-help">¿Necesitás ayuda?</a>
        </section>
    </main>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const shareButton = document.getElementById('pc-share-button');

    if (!shareButton) return;

    shareButton.addEventListener('click', async function () {
        const shareData = {
            title: shareButton.dataset.shareTitle || document.title,
            text: shareButton.dataset.shareText || '',
            url: shareButton.dataset.shareUrl || window.location.href
        };

        if (navigator.share) {
            try {
                await navigator.share(shareData);
                return;
            } catch (error) {
                if (error.name === 'AbortError') return;
            }
        }

        try {
            await navigator.clipboard.writeText(shareData.url);
            const original = shareButton.querySelector('.pc-action-label').textContent;
            shareButton.querySelector('.pc-action-label').textContent = 'Copiado';
            setTimeout(function () {
                shareButton.querySelector('.pc-action-label').textContent = original;
            }, 1600);
        } catch (error) {
            window.prompt('Copiá este enlace:', shareData.url);
        }
    });
});
</script>
@endpush
