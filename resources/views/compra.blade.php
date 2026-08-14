@extends('layouts.app')

@push('styles')
<style>
    :root {
        --vp-bg: #f1f2fb;
        --vp-blue: #0967f2;
        --vp-blue-dark: #073d96;
        --vp-green: #49b98a;
        --vp-text: #101114;
        --vp-muted: #7f8188;
        --vp-line: #17191d;
        --vp-white: #ffffff;
    }

    * { box-sizing: border-box; }

    body { background: var(--vp-bg); }

    .vp-page {
        min-height: 100vh;
        background: var(--vp-bg);
        color: var(--vp-text);
        font-family: Montserrat, sans-serif;
        padding-bottom: 116px;
    }

    .vp-mobile-header { display: none; }

    .vp-shell {
        width: min(1120px, calc(100% - 80px));
        margin: 0 auto;
        padding: 16vh 0 48px;
    }

    .vp-title-row {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 34px;
    }

    .vp-back {
        border: 0;
        background: transparent;
        color: #111;
        font-size: 34px;
        line-height: 1;
        text-decoration: none;
        padding: 0;
    }

    .vp-title {
        margin: 0;
        font-size: 37px;
        line-height: 1.1;
        font-weight: 400;
        letter-spacing: -.7px;
    }

    .vp-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.02fr) minmax(440px, .98fr);
        gap: 62px;
        align-items: start;
    }

    .vp-section-title {
        margin: 0 0 12px;
        font-size: 15px;
        font-weight: 700;
    }

    .vp-login-card {
        border: 1.5px solid var(--vp-blue-dark);
        border-radius: 999px;
        min-height: 72px;
        padding: 10px 24px 10px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        background: #fff;
        margin-bottom: 24px;
    }

    .vp-login-info {
        display: flex;
        align-items: center;
        gap: 16px;
        min-width: 0;
    }

    .vp-login-icon {
        width: 54px;
        height: 54px;
        /* border: 2px solid var(--vp-blue-dark); */
        border-radius: 50%;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        font-size: 24px;
    }

    .vp-login-copy strong,
    .vp-login-copy span { display: block; }

    .vp-login-copy strong {
        color: var(--vp-blue-dark);
        font-size: 15px;
        margin-bottom: 3px;
    }

    .vp-login-copy span {
        color: #6c8dcc;
        font-size: 13px;
    }

    .vp-login-button {
        min-width: 168px;
        border: 0;
        border-radius: 999px;
        padding: 12px 24px;
        background: var(--vp-blue-dark);
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
    }

    .vp-field { margin-bottom: 18px; }

    .vp-field label {
        display: block;
        margin: 0 0 7px 6px;
        font-size: 14px;
        line-height: 1.25;
    }

    .vp-field input,
    .vp-field select {
        width: 100%;
        height: 40px;
        border: 1.25px solid #16181b;
        border-radius: 14px;
        background: transparent;
        padding: 0 17px;
        font: inherit;
        font-size: 15px;
        outline: none;
    }

    .vp-field input::placeholder { color: #b8bac1; }

    .vp-field input:focus,
    .vp-field select:focus {
        border-color: var(--vp-blue);
        box-shadow: 0 0 0 3px rgba(9,103,242,.12);
    }

    .vp-phone {
        display: grid;
        grid-template-columns: 102px 1fr;
        border: 1.25px solid #16181b;
        border-radius: 14px;
        overflow: hidden;
        height: 40px;
    }

    .vp-phone select,
    .vp-phone input {
        height: 100%;
        border: 0;
        border-radius: 0;
        background: transparent;
    }

    .vp-phone select { border-right: 1px solid #bfc2c9; }

    .vp-summary-card {
        overflow: hidden;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 4px 8px rgba(16, 24, 40, .18);
        margin-bottom: 20px;
    }

    .vp-summary-top {
        /* background: var(--vp-green); */
        min-height: 146px;
        display: grid;
        grid-template-columns: 118px 1fr;
        align-items: center;
        padding: 22px 30px;
        color: #fff;
    }

    .vp-brand-logo {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        object-fit: cover;
        background: #0a7346;
    }

    .vp-brand-name {
        font-size: 16px;
        margin-bottom: 2px;
        font-weight: 700;
    }

    .vp-brand-subtitle {
        font-size: 14px;
        opacity: .9;
        margin-bottom: 7px;
    }

    .vp-price {
        font-size: clamp(48px, 5vw, 68px);
        font-weight: 500;
        line-height: 1;
        letter-spacing: -2px;
        text-align: center;
    }

    .vp-summary-bottom {
        padding: 13px 30px 16px;
        background: #fff;
    }

    .vp-summary-bottom p { margin: 0; }

    .vp-recipient {
        font-size: 15px;
        line-height: 1.3;
        text-transform: uppercase;
        margin-bottom: 10px !important;
        font-family: 'Montserrat', sans-serif;
    }

    .vp-message {
        font-size: 13px;
        color: #5a5c63;
        line-height: 1.35;
    }

    .vp-terms { padding: 0 30px; }

    .vp-terms h2 {
        margin: 0 0 10px;
        font-size: 15px;
        font-weight: 700;
    }

    .vp-terms ul {
        margin: 0 0 16px;
        padding-left: 18px;
    }

    .vp-terms li {
        margin: 0 0 8px;
        padding-left: 2px;
        font-size: 14px;
        line-height: 1.35;
    }

    .vp-terms li b {
        font-weight: 800;
    }

    .vp-check-row {
        display: flex;
        align-items: center;
        gap: 11px;
        min-height: 42px;
        padding: 3px 0 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
    }

    .vp-check-row input {
        width: 21px;
        height: 21px;
        accent-color: var(--vp-blue);
    }

    .vp-chevron { margin-left: auto; font-size: 24px; }

    .vp-payment {
        border-top: 1px solid #1c1d20;
        margin-top: 6px;
        padding: 22px 30px 0;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .vp-payment img {
        width: 78px;
        height: auto;
        object-fit: contain;
    }

    .vp-payment strong,
    .vp-payment span { display: block; }

    .vp-payment strong { font-size: 14px; margin-bottom: 3px; }
    .vp-payment span { font-size: 13px; color: #5f6168; line-height: 1.25; }

    .vp-action-bar {
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 30;
        height: 112px;
        border-top: 1px solid #94979d;
        background: #fff;
    }

    .vp-action-inner {
        width: min(1120px, calc(100% - 80px));
        height: 100%;
        margin: 0 auto;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
    }

    .vp-action {
        min-width: 310px;
        height: 42px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 28px;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .vp-action-secondary {
        border: 1.5px solid var(--vp-blue-dark);
        color: var(--vp-blue-dark);
        background: #fff;
    }

    .vp-action-primary {
        border: 1.5px solid var(--vp-blue);
        color: #fff;
        background: var(--vp-blue);
    }

    .vp-error-message {
        display: block;
        color: #d92d20;
        margin: 5px 0 0 6px;
        font-size: 12px;
    }

    .is-invalid { border-color: #d92d20 !important; }

    @media (max-width: 768px) {
        body { background: #fff; }

        .vp-page {
            padding-bottom: 0;
            background: var(--vp-bg);
        }

        .vp-desktop-navbar { display: none; }

        .vp-mobile-header {
            position: sticky;
            top: 0;
            z-index: 40;
            height: 78px;
            padding: 0 23px;
            background: #fff;
            box-shadow: 0 2px 7px rgba(20, 24, 33, .16);
            display: grid;
            grid-template-columns: 40px 1fr 40px;
            align-items: center;
        }

        .vp-mobile-header a,
        .vp-mobile-header button {
            border: 0;
            background: transparent;
            color: #111;
            font-size: 27px;
            text-decoration: none;
            padding: 0;
        }

        .vp-mobile-header h1 {
            margin: 0;
            text-align: center;
            font-size: 20px;
            font-weight: 700;
        }

        .vp-shell {
            width: 100%;
            margin: 0;
            padding: 24px 0 30px;
        }

        .vp-title-row { display: none; }

        .vp-grid {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .vp-right { order: 1; }
        .vp-left { order: 2; padding: 32px 28px 48px; }

        .vp-summary-card {
            margin: 0 28px 24px;
            border-radius: 16px;
        }

        .vp-summary-top {
            grid-template-columns: 74px 1fr;
            padding: 22px 24px;
            min-height: 184px;
        }

        .vp-brand-logo { width: 58px; height: 58px; }
        .vp-brand-name { font-size: 16px; }
        .vp-brand-subtitle { font-size: 14px; }
        .vp-price { font-size: 56px; grid-column: 1 / -1; margin-top: 10px; }

        .vp-summary-bottom { padding: 18px 40px 18px; }
        .vp-recipient { font-size: 14px; }
        .vp-message { font-size: 13px; }

        .vp-terms {
            background: #fff;
            padding: 24px 30px 0;
        }

        .vp-terms h2 { font-size: 16px; }
        .vp-terms li { font-size: 14px; }

        .vp-check-row {
            margin-top: 20px;
            font-size: 16px;
        }

        .vp-payment {
            padding: 20px 8px 30px;
            margin: 18px 0 0;
        }

        .vp-payment img { width: 82px; }

        .vp-section-title { margin-bottom: 14px; }

        .vp-login-card {
            min-height: 82px;
            padding: 11px 26px;
            justify-content: flex-start;
        }

        .vp-login-button { display: none; }

        .vp-login-card { cursor: pointer; }

        .vp-login-card:active {
            transform: scale(0.98);
            opacity: 0.9;
            background-color: #07378C;
        }

        .vp-field { margin-bottom: 22px; }
        .vp-field input,
        .vp-field select,
        .vp-phone { height: 42px; }

        .vp-action-bar {
            position: static;
            height: auto;
            border: 0;
            background: transparent;
            padding: 0 28px 44px;
        }

        .vp-action-inner {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .vp-action { width: 100%; min-width: 0; height: 46px; }
        .vp-action-primary { order: 1; }
        .vp-action-secondary { order: 2; }
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
    $dat_voucher = session('voucher');
    // dd($voucher);

    $monto = data_get($valores ?? null, 'vmv_monto_fijo')
        ?? data_get($voucher ?? null, 'vou_monto_fijo')
        ?? 175000;

    $entidadNombre = data_get($entidad ?? null, 'ent_nombre_fantasia')
        ?? data_get($entidad ?? null, 'ent_nombre')
        ?? 'Cumbres Outdoor';

    $logoPath = data_get($entidad ?? null, 'logoPrincipal.ef_img_path')
        ?? data_get($entidad ?? null, 'logo.ef_img_path');

    $logoEntidad = $logoPath
        ? asset('storage/' . $logoPath)
        : asset('images/logo-entidad-default.png');

    $para = old('para', data_get($dat_voucher ?? null, 'para', 'Flor'));
    $de = old('de', data_get($dat_voucher ?? null, 'de', 'Some M., Gabi T. & Santi'));
    $mensaje = old('mensaje', data_get($dat_voucher ?? null, 'mensaje', 'Querida Flor, espero que pases un cumple hermoso. Te queremos mucho.'));

    $volverUrl = $volverUrl ?? url()->previous();
    $editarUrl = route('vouchers.precompra', ['voucher' => $voucher->vou_id, 'modalidadCampo' => $valores->vmv_id]);
    // $actionUrl = $actionUrl ?? route('checkout.voucher', [
    $actionUrl = $actionUrl ?? route('vouchers.postcompra', [
        'voucher' => data_get($voucher ?? null, 'vou_id'),
        'modalidadCampo' => data_get($valores ?? null, 'vmv_id'),
    ]);

    $fecha_actual_raw = new DateTime();
    $fecha_actual = $fecha_actual_raw->format('d/m/Y');
    $fecha_vto_raw = new DateTime();
    $dias_vigencia = $voucher->vou_vigencia_dias!='' ? $voucher->vou_vigencia_dias : 0;
    $fecha_vto_raw->modify("+$dias_vigencia days");
    $fecha_vto = $fecha_vto_raw ? $fecha_vto_raw->format('d/m/Y') : '01/01/99';

    $direcciones_label='';
    if ($sucursales->isNotEmpty()) {
        foreach ($sucursales as $sucursal) {
            $direcciones_label .= strtoupper($sucursal->ed_direccion)." o ";
        }
        $direcciones_label=rtrim($direcciones_label,' o ');
    }
    $direcciones_label=rtrim($direcciones_label,' o ');

    $condiciones = $condiciones ?? [
        // 'Canjeable por productos o servicios del local <b>[según modalidad del voucher]</b>',
        'Canjeable por productos o servicios del local',
        'Válido para canjear desde <b>'. $fecha_actual .'</b> hasta <b>'. $fecha_vto .'</b>',
        '<b>No reembolsable</b> ni canjeable por dinero',
        'Se canjea en <b>'. $direcciones_label .'</b>',
        'Retiro a cargo del portador del voucher y a acordar con el vendedor',
        'Envío no incluído',
        'Uso único',
    ];
@endphp

<div class="vp-desktop-navbar">
    @include('partials.navbar')
</div>

<header class="vp-mobile-header">
    <a href="{{ $volverUrl }}" aria-label="Volver">‹</a>
    <h1>¡Último paso!</h1>
    <a href="{{ $editarUrl }}" aria-label="Cerrar">×</a>
</header>

<main class="vp-page">
    <form id="vp-form" action="{{ $actionUrl }}" method="POST" novalidate>
        @csrf

        <input type="hidden" name="monto" value="{{ $monto }}">
        <input type="hidden" name="para" value="{{ $para }}">
        <input type="hidden" name="de" value="{{ $de }}">
        <input type="hidden" name="mensaje" value="{{ $mensaje }}">

        <div class="vp-shell">
            <div class="vp-title-row">
                <a href="{{ $volverUrl }}" class="vp-back" aria-label="Volver">‹</a>
                <h1 class="vp-title">¡Último paso!</h1>
            </div>

            <div class="vp-grid">
                <section class="vp-left">
                    <h2 class="vp-section-title">Datos del comprador</h2>

                    <div class="vp-login-card" data-url="{{ $loginUrl ?? route('login') }}">
                        <div class="vp-login-info">
                            <div class="vp-login-icon"><img src="{{ asset('images/icono-Perfil.png') }}" alt="Usuario"></div>
                            <div class="vp-login-copy">
                                <strong>Inicia sesión</strong>
                                <span>Iniciá sesión y comprá más rápido</span>
                            </div>
                        </div>
                        <a href="{{ $loginUrl ?? route('login') }}" class="vp-login-button">Iniciar sesión</a>
                    </div>

                    <div class="vp-field">
                        <label for="nombre">1. Nombre completo*</label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Escribe tu nombre completo" required>
                    </div>

                    <div class="vp-field">
                        <label for="email">2. Email*</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="@gmail.com" required>
                    </div>

                    <div class="vp-field">
                        <label for="email_confirmation">Confirma tu email*</label>
                        <input type="email" id="email_confirmation" name="email_confirmation" value="{{ old('email_confirmation') }}" placeholder="@gmail.com" required>
                    </div>

                    <div class="vp-field">
                        <label for="telefono">3. Celular <span style="font-weight:400">(opcional)</span></label>
                        <div class="vp-phone">
                            <select id="codigo_pais" name="codigo_pais" aria-label="Código de país">
                                <option value="+54">AR +54</option>
                            </select>
                            <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="Número de Teléfono">
                        </div>
                    </div>
                </section>

                <section class="vp-right">
                    <article class="vp-summary-card">
                        <div class="vp-summary-top" style="background: {{ $entidad->ent_color_fondo ?? '#49b889' }};">
                            <img src="{{ $logoEntidad }}" alt="{{ $entidadNombre }}" class="vp-brand-logo">
                            <div>
                                <div class="vp-brand-name">{{ $entidadNombre }}</div>
                                <div class="vp-brand-subtitle">VALE POR</div>
                            </div>
                            <div class="vp-price">${{ number_format($monto, 0, ',', '.') }}</div>
                        </div>
                        <div class="vp-summary-bottom">
                            <p class="vp-recipient">PARA: {{ $para }}<br>DE: {{ $de }}</p>
                            <p class="vp-message">{{ $mensaje }}</p>
                        </div>
                    </article>

                    <div class="vp-terms">
                        <h2>Condiciones de uso</h2>
                        <ul>
                            @foreach ($condiciones as $condicion)
                                <li>{!! $condicion !!}</li>
                            @endforeach
                        </ul>

                        <label class="vp-check-row" for="acepta_terminos">
                            <input type="checkbox" id="acepta_terminos" name="acepta_terminos" value="1" required>
                            <span>Acepto los términos y condiciones</span>
                            <span class="vp-chevron">⌄</span>
                        </label>

                        <div class="vp-payment">
                            <img src="{{ $medioPagoImagen ?? asset('images/MercadoPago.png') }}" alt="Mercado Pago">
                            <div>
                                <strong>Medios de pago</strong>
                                <span>Se te redireccionará a la plataforma de Mercado Pago para completar el pago</span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="vp-action-bar">
            <div class="vp-action-inner">
                <a href="{{ $editarUrl }}" class="vp-action vp-action-secondary">Editar mensaje</a>
                <div class="vs-checkout-total">TOTAL ${{ number_format($valores->vmv_monto_fijo, 0, ',', '.') }}ARS</div>
                <button type="submit" class="vp-action vp-action-primary">Confirmar y pagar</button>
            </div>
        </div>
    </form>
</main>
@endsection

@push('scripts')
<script>
$(function () {
    if (!$.fn.validate) return;

    $('#vp-form').validate({
        rules: {
            nombre: { required: true, maxlength: 120 },
            email: { required: true, email: true },
            email_confirmation: { required: true, email: true, equalTo: '#email' },
            acepta_terminos: { required: true }
        },
        messages: {
            nombre: { required: 'Ingresá tu nombre completo.' },
            email: {
                required: 'Ingresá tu email.',
                email: 'Ingresá un email válido.'
            },
            email_confirmation: {
                required: 'Confirmá tu email.',
                email: 'Ingresá un email válido.',
                equalTo: 'Los emails no coinciden.'
            },
            acepta_terminos: {
                required: 'Debés aceptar los términos y condiciones.'
            }
        },
        errorElement: 'small',
        errorPlacement: function (error, element) {
            error.addClass('vp-error-message');
            if (element.attr('name') === 'acepta_terminos') {
                error.insertAfter(element.closest('.vp-check-row'));
                return;
            }
            if (element.closest('.vp-phone').length) {
                error.insertAfter(element.closest('.vp-phone'));
                return;
            }
            error.insertAfter(element);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        }
    });

    $(document).on('click', '.vp-login-card', function (e) {

        if (window.innerWidth <= 768) {
            e.preventDefault();

            const url = $(this).data('url');

            if (url) {
                window.location.href = url;
            }
        }

    });

});
</script>
@endpush
