@extends('layouts.app')

@php
    /*
     |--------------------------------------------------------------------------
     | Variables con valores de respaldo
     |--------------------------------------------------------------------------
     | Podés enviar estas variables desde el controlador o adaptar los nombres
     | a las propiedades reales de tus modelos.
     */
    // dd(session());
    $voucher_id = data_get($voucher ?? null, 'vou_id', data_get($voucher ?? null, 'vou_id', '00056970'));
    $mca_id = data_get($valores ?? null, 'mca_id', data_get($valores ?? null, 'mca_id', '00056970'));
    $vmv_id = data_get($valores ?? null, 'vmv_id', data_get($valores ?? null, 'vmv_id', '00056970'));

    $montoVoucher = data_get($valores ?? null, 'vmv_monto_fijo', data_get($voucher ?? null, 'vou_monto_fijo', 175000));
    $codigoVoucher = data_get($voucher ?? null, 'vou_codigo', data_get($voucher ?? null, 'vou_id', '00056970'));
    $nombreVoucher = data_get($voucher ?? null, 'vou_nombre', 'Voucher Cumbres');
    $nombreEntidad = data_get($entidad ?? null, 'ent_nombre_fantasia', data_get($entidad ?? null, 'ent_nombre', 'Cumbres'));
    $descripcionEntidad = data_get($entidad ?? null, 'ent_descripcion_corta', 'Parte de: Alto Noa Shopping');

    $nombreDe = old('de', session('voucher.de', request('de', 'Sole m., Gabi T. & Santi')));
    $nombrePara = old('para', session('voucher.para', request('para', 'Flor')));
    $mensajeVoucher = old('mensaje', session('voucher.mensaje', request('mensaje', 'Querida Flor, espero que pases un cumple hermoso. Te queremos mucho.')));

    // session([
    //     'voucher' => [
    //         'vou_id' => $voucher_id,
    //         'mca_id' => $mca_id,
    //         'vmv_id' => $vmv_id,
    //         'monto' => $montoVoucher,
    //         'de' => $nombreDe,
    //         'para' => $nombrePara,
    //         'mensaje' => $mensajeVoucher,
    //     ]
    // ]);


    $fecha_actual_raw = new DateTime();
    $fecha_actual = $fecha_actual_raw->format('d/m/y');
    $fechaVencimientoRaw = new DateTime();
    $dias_vigencia = $voucher->vou_vigencia_dias!='' ? $voucher->vou_vigencia_dias : 0;
    $fechaVencimientoRaw->modify("+$dias_vigencia days");
    try {
        $fechaVencimiento = $fechaVencimientoRaw
            ? $fechaVencimientoRaw->format('d/m/y')
            : '01/01/99';
    } catch (\Throwable $e) {
        $fechaVencimiento = '01/01/99';
    }

    $imagenPrincipal = isset($voucher) && isset($imagenes)
        ? $imagenes->first()
        : null;

    $bannerEntidadRelacion = data_get($entidad ?? null, 'imagenPrincipal');
    $imagenVoucher = data_get($bannerEntidadRelacion, 'ef_img_path')
        ? asset('storage/' . data_get($bannerEntidadRelacion, 'ef_img_path'))
        : asset('images/default-voucher.png');

    $imagen_voucher_vou = data_get($imagenPrincipal, 'vf_img_path')
        ? asset('storage/' . data_get($imagenPrincipal, 'vf_img_path'))
        : asset('images/default-voucher.png');

    $logoEntidadRelacion = data_get($entidad ?? null, 'logoPrincipal');
    $logoEntidad = data_get($logoEntidadRelacion, 'ef_img_path')
        ? asset('storage/' . data_get($logoEntidadRelacion, 'ef_img_path'))
        : null;

    $qrImagen = $qrImagen ?? data_get($voucher ?? null, 'qr_url');

    // $sucursales = collect($sucursales ?? data_get($entidad ?? null, 'sucursales', []));
    // if ($sucursales->isEmpty()) {
    //     $sucursales = collect([
    //         (object) ['direccion' => 'Av. del Bicentenario de la Batalla de Salta 702, Salta'],
    //         (object) ['direccion' => 'Balcarce 127, Salta'],
    //         (object) ['direccion' => 'La Comarca, San Lorenzo Chico, Villa San Lorenzo, Salta'],
    //     ]);
    // }

    $volverUrl = route('vouchers.precompra', ['voucher' => $voucher->vou_id, 'modalidadCampo' => $valores->vmv_id]);
    $editarUrl = route('vouchers.precompra', ['voucher' => $voucher->vou_id, 'modalidadCampo' => $valores->vmv_id]);
    $continuarUrl = $continuarUrl ?? route('vouchers.compra', [
        'voucher' => data_get($voucher ?? null, 'vou_id'),
        'modalidadCampo' => data_get($valores ?? null, 'vmv_id'),
    ]);


    // $voucher = session('voucher');
    // dd($voucher);

    $telefono = $sucursal_telefono->ed_telefono1 ?? '3871234567';

    $direcciones_label='';
    if ($sucursales->isNotEmpty()) {
        foreach($sucursales as $sucursal) {
            $direccion = $sucursal->ed_direccion;
            $direcciones_label .= strtoupper($direccion)." o ";
        }

        $direcciones_label=rtrim($direcciones_label,' o ');
    }

    $condiciones = '';
    if (trim($voucher->vou_modalidad_condiciones) !== '') {
        $items = explode('#|# ', $voucher->vou_modalidad_condiciones);
        $condiciones = '<ul>';

        foreach ($items as $item) {
            $item = trim($item);

            // Evitar elementos vacíos
            if ($item === '') {
                continue;
            }

            // Reemplazar variables
            $item = str_replace('<<FECHA_INICIO>>',"<b>$fecha_actual</b>",$item);
            $item = str_replace('<<FECHA_FIN>>',"<b>$fechaVencimiento</b>",$item);
            $item = str_replace('<<SUCURSALES>>',"<b>$direcciones_label</b>",$item);

            $condiciones .= '<li>' . $item . '</li>';
        }

        $condiciones .= '</ul>';
    }

@endphp

@push('styles')
<style>
    :root {
        --vp-green: #49b889;
        --vp-green-dark: #36a779;
        --vp-blue: #416fb6;
        --vp-action: #0968f7;
        --vp-cream: #f8f4e9;
        --vp-page: #f2f3fb;
        --vp-text: #111;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        background: var(--vp-page);
    }

    .vp-page {
        min-height: 100vh;
        padding-bottom: 94px;
        background: var(--vp-page);
        color: var(--vp-text);
        font-family: Montserrat, sans-serif;
    }

    .vp-mobile-header {
        display: none;
    }

    .vp-shell {
        width: min(1260px, calc(100% - 96px));
        margin: 0 auto;
        padding: 16vh 0 40px;
    }

    .vp-page-title {
        display: flex;
        align-items: center;
        gap: 18px;
        margin: 0 0 58px;
        /* font-size: 31px; */
        /* font-weight: 400; */
        /* line-height: 1.2; */

        font-family: 'Montserrat', sans-serif;
        font-weight: 300;
        font-size: 34px;
        line-height: 1.2;
        letter-spacing: 0;
    }

    .vp-back,
    .vp-close {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border: 0;
        background: transparent;
        color: #111;
        text-decoration: none;
    }

    .vp-back svg,
    .vp-close svg {
        width: 22px;
        height: 22px;
    }

    .vp-stage {
        width: 720px;
        /* max-height: calc(100vh - 270px); */
        margin: 0 auto;
        overflow-y: auto;
        border-radius: 26px;
        box-shadow: 0 8px 16px rgba(29, 37, 56, .18);
        scrollbar-width: thin;
        scrollbar-color: rgba(0, 0, 0, .25) transparent;
    }

    .vp-voucher {
        overflow: hidden;
        background: #fff;
        border-radius: 26px;
    }

    .vp-green-section {
        position: relative;
        padding: 55px 28px 54px;
        overflow: hidden;
        /* background: var(--vp-green); */
    }

    .vp-green-section::before,
    .vp-green-section::after {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        border: 8px solid rgba(255,255,255,.13);
        border-radius: 48% 52% 50% 50%;
        transform: rotate(25deg);
    }

    .vp-green-section::before { top: -105px; left: 22px; }
    .vp-green-section::after { right: -96px; bottom: 20px; }

    .vp-voucher-topline {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        /* margin-bottom: 18px; */
        padding-left: 15px;
        padding-right: 15px;
        color: #fff;
        box-shadow: 0 3px 4px rgba(0,0,0,.22);
        border-radius: 13px 13px 0 0;
    }

    .vp-code {
        font-size: 12px;
        font-weight: 600;
    }

    .vp-brand {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 33px;
        font-weight: 700;
        letter-spacing: -.04em;
    }

    .vp-brand svg {
        width: 31px;
        height: 31px;
    }

    .vp-gift-card {
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: 1fr 1.08fr;
        min-height: 245px;
        /* max-height: 50vh; */
        overflow: hidden;
        border-radius: 0 0 13px 13px;
        background: var(--vp-cream);
        box-shadow: 0 3px 4px rgba(0,0,0,.22);
    }

    .vp-message-panel {
        padding: 31px 30px 25px;
        border-right: 3px dashed #111;
        background: #f8f5eb;
    }

    .vp-hand-label {
        display: block;
        margin-bottom: 5px;
        color: #454545;
        font-family: 'Grape Nuts', cursive;
        font-size: 13px;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .vp-hand-value {
        margin: 0 0 12px;
        padding: 0 4px 4px;
        border-bottom: 1px solid #777;
        font-family: 'Grape Nuts', cursive;
        font-size: 24px;
        font-weight: 500;
        font-style: italic;
        text-align: center;
        line-height: 1.15;
    }

    .vp-hand-message {
        margin: 27px 0 0;
        font-family: 'Grape Nuts', cursive;
        font-size: 16px;
        font-style: italic;
        line-height: 1.4;
        text-align: center;
    }

    .vp-value-panel {
        display: flex;
        flex-direction: column;
        background: #fff;
    }

    .vp-value-copy {
        position: relative;
        flex: 0 0 140px;
        padding: 34px 34px 15px;
        background: var(--vp-cream);
    }

    .vp-value-eyebrow {
        margin: 0;
        font-size: 12px;
        line-height: 1.2;
        text-transform: uppercase;
        font-weight: 300;
    }

    .vp-value-eyebrow span {
        font-weight: 800;
    }

    .vp-value-amount {
        margin: 16px 0 0;
        font-size: 53px;
        font-weight: 700;
        line-height: 1;
        letter-spacing: -.04em;
        text-align: center;
    }

    .vp-title {
        margin: 16px 0 0;
        font-size: 24px;
        font-weight: 700;
        line-height: 1;
        letter-spacing: -.04em;
        text-align: center;
    }

    .vp-subtitle {
        margin: 16px 0 0;
        font-size: 16px;
        font-weight: 400;
        line-height: 1;
        letter-spacing: -.04em;
        text-align: center;
    }

    .vp-recommendation {
        position: absolute;
        top: 28px;
        right: 14px;
        min-width: 116px;
        padding: 10px;
        border-radius: 5px;
        background: #fff1c9;
        color: #b77717;
        font-size: 7px;
        font-weight: 600;
        text-align: center;
        text-transform: uppercase;
        box-shadow: 0 2px 5px rgba(0,0,0,.08);
    }

    .vp-value-image {
        flex: 1;
        min-height: 105px;
    }

    .vp-value-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .vp-commerce-row {
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 28px;
        align-items: center;
        padding: 42px 38px 30px;
    }

    .vp-commerce {
        display: flex;
        align-items: center;
        gap: 18px;
        color: #fff;
    }

    .vp-commerce-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 82px;
        width: 82px;
        height: 82px;
        overflow: hidden;
        border: 3px solid #fff;
        border-radius: 50%;
        background: #12723c;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
    }

    .vp-commerce-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #fff;
    }

    .vp-commerce-label {
        display: block;
        margin-bottom: 5px;
        font-size: 11px;
        text-transform: uppercase;
    }

    .vp-commerce-name {
        display: block;
        font-size: 22px;
        font-weight: 700;
    }

    .vp-commerce-description {
        display: block;
        margin-top: 2px;
        font-size: 13px;
    }

    .vp-whatsapp {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        min-width: 235px;
        height: 49px;
        padding: 0 24px;
        border-radius: 999px;
        background: #fff;
        color: #111;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 3px 5px rgba(0,0,0,.12);
    }

    .vp-whatsapp svg {
        width: 29px;
        height: 29px;
        color: #35bd7c;
    }

    .vp-addresses {
        position: relative;
        z-index: 2;
        width: 60%;
        margin: 0 auto;
        padding: 0;
        list-style: none;
        color: #fff;
    }

    .vp-addresses li {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin: 0 0 10px;
        font-size: 11px;
        line-height: 1.4;
    }

    .vp-addresses svg {
        flex: 0 0 18px;
        width: 18px;
        height: 18px;
    }

    .vp-blue-section {
        position: relative;
        display: grid;
        grid-template-columns: .9fr 1.1fr;
        gap: 30px;
        min-height: 305px;
        padding: 47px 55px 44px;
        overflow: hidden;
        background: var(--vp-blue);
        color: #fff;
    }

    .vp-blue-section::before {
        content: "";
        position: absolute;
        top: 30%;
        /* inset: 0; */
        background-image: url("/images/ilustración-estrella-voucher.svg");
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        opacity: .80;
        pointer-events: none;
        width: 80%;
        height: 80%;
    }

    .vp-how,
    .vp-conditions {
        position: relative;
        z-index: 2;
    }

    .vp-how-title {
        margin: 0 0 27px;
        font-size: 29px;
        font-weight: 300;
        line-height: .98;
    }

    .vp-how-title strong {
        display: block;
        font-size: 30px;
        font-weight: 700;
    }

    .vp-steps {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .vp-steps li {
        display: flex;
        gap: 11px;
        align-items: center;
        margin-bottom: 15px;
        font-size: 12px;
    }

    .vp-step-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 26px;
        width: 26px;
        height: 26px;
        border: 1px solid #fff;
        border-radius: 50%;
        font-size: 15px;
    }

    .vp-validity {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 42px;
        margin-bottom: 25px;
        border-radius: 5px;
        background: var(--vp-action);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .vp-conditions h3 {
        margin: 0 0 17px;
        font-size: 18px;
        text-transform: uppercase;
    }

    .vp-conditions ul {
        margin: 0;
        padding-left: 13px;
        font-size: 10px;
        line-height: 1.55;
    }

    /* =========================================================
   SECCIÓN BLANCA
   ========================================================= */

    .vp-white-section {
        width: 100%;
        min-height: 385px;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 25px 75px 42px;
        background: #fff;
    }


    /* =========================================================
    QR
    ========================================================= */

    .vp-qr-column {
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .vp-qr-card {
        width: 550px;
        min-height: 170px;
        display: flex;
        align-items: center;
        gap: 28px;
        padding: 12px 14px;
        background: #fff;
        box-shadow:
            0 3px 3px rgba(0, 0, 0, 0.20),
            0 1px 2px rgba(0, 0, 0, 0.08);
    }


    /* QR */

    .vp-qr {
        width: 145px;
        height: 145px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .vp-qr img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }


    /* Información */

    .vp-qr-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        font-family: Montserrat, Arial, sans-serif;
        color: #111;
        line-height: 1.05;
    }

    .vp-qr-info span,
    .vp-qr-info strong {
        display: block;
    }

    .vp-voucher-code {
        margin-bottom: 16px;
        font-size: 14px;
        font-weight: 600;
    }

    .vp-qr-info strong {
        margin-bottom: 2px;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .vp-qr-info > span:last-child {
        font-size: 14px;
        font-weight: 400;
        text-transform: uppercase;
    }


    /* =========================================================
    COMUNIDAD
    ========================================================= */

    .vp-community {
        width: 100%;
        max-width: 550px;
        margin-top: 20px;
        display: grid;
        grid-template-columns:
            minmax(150px, 1fr)
            minmax(185px, 1fr)
            minmax(100px, .75fr);
        align-items: center;
        column-gap: 25px;
    }


    /* Texto */

    .vp-community-text {
        display: flex;
        flex-direction: column;

        font-family: Montserrat, Arial, sans-serif;

        font-size: 27px;
        line-height: 1.1;

        color: #0768f7;
    }

    .vp-community-text span,
    .vp-community-text strong {
        display: block;
    }

    .vp-community-text strong {
        font-weight: 700;
        font-style: italic;
    }


    /* Botón vauchis.com */

    .vp-community-link {
        width: 188px;
        height: 44px;

        display: flex;
        align-items: center;
        justify-content: center;

        justify-self: center;

        border: 1.5px solid #1670ff;
        border-radius: 999px;

        color: #1670ff;

        font-family: Montserrat, Arial, sans-serif;
        font-size: 19px;
        font-weight: 400;

        text-decoration: none;

        transition:
            background-color .2s ease,
            color .2s ease;
    }

    .vp-community-link strong {
        font-weight: 700;
    }

    .vp-community-link:hover {
        background: #1670ff;
        color: #fff;
    }


    /* Regalitos */

    .vp-gifts-mark {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .vp-gifts-mark img {
        display: block;

        width: 110px;
        max-width: 100%;

        height: auto;
    }

    .vp-bottom-bar {
        position: fixed;
        z-index: 50;
        left: 0;
        right: 0;
        bottom: 0;
        min-height: 94px;
        border-top: 2px solid rgba(0,0,0,.23);
        background: #fff;
    }

    .vp-bottom-inner {
        width: min(1260px, calc(100% - 96px));
        min-height: 94px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
    }

    .vp-action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 310px;
        height: 42px;
        border: 1.5px solid var(--vp-action);
        border-radius: 999px;
        background: #fff;
        color: #06489f;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }

    .vp-action-button--primary {
        background: var(--vp-action);
        color: #fff;
    }

    @media (max-width: 991.98px) {
        body {
            background: #fff;
        }

        .vp-desktop-navbar,
        .vp-page-title {
            display: none !important;
        }

        .vp-page {
            padding: 0;
            background: #fff;
        }

        .vp-mobile-header {
            position: sticky;
            top: 0;
            z-index: 100;
            display: grid;
            grid-template-columns: 42px 1fr 42px;
            align-items: center;
            height: 82px;
            padding: 0 12px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,.22);
        }

        .vp-mobile-header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            text-align: center;
        }

        .vp-shell {
            width: 100%;
            padding: 0;
        }

        .vp-stage {
            width: 100%;
            max-height: none;
            overflow: visible;
            margin: 0;
            border-radius: 0;
            box-shadow: none;
        }

        .vp-voucher {
            border-radius: 0;
        }

        .vp-green-section {
            padding: 46px 14px 34px;
        }

        /* .vp-voucher-topline {
            margin: 0 10px 18px;
        } */

        .vp-brand {
            font-size: 28px;
        }

        .vp-gift-card {
            display: flex;
            flex-direction: column;
            border-radius: 0;
            box-shadow: none;
            background: transparent;
        }

        .vp-message-panel {
            min-height: 208px;
            padding: 26px 28px 24px;
            border-right: 0;
            border-bottom: 3px dashed #111;
            border-radius: 0 0 15px 15px;
        }

        .vp-hand-value {
            font-size: 21px;
        }

        .vp-hand-message {
            margin-top: 25px;
            font-size: 14px;
        }

        .vp-value-panel {
            overflow: hidden;
            border-radius: 15px;
        }

        .vp-value-copy {
            flex-basis: auto;
            min-height: 158px;
            padding: 35px 28px 20px;
        }

        .vp-value-amount {
            margin-top: 25px;
            font-size: 49px;
        }

        .vp-value-image {
            height: 185px;
        }

        .vp-commerce-row {
            display: block;
            padding: 34px 18px 20px;
        }

        .vp-commerce {
            margin-bottom: 32px;
        }

        .vp-commerce-logo {
            flex-basis: 70px;
            width: 70px;
            height: 70px;
        }

        .vp-commerce-name {
            font-size: 18px;
        }

        .vp-whatsapp {
            width: 100%;
            min-width: 0;
            height: 55px;
            font-size: 14px;
        }

        .vp-addresses {
            width: 100%;
            padding: 0 20px;
        }

        .vp-addresses li {
            font-size: 11px;
        }

        .vp-blue-section {
            display: block;
            min-height: 0;
            padding: 42px 34px 0;
        }

        .vp-how-title {
            font-size: 25px;
        }

        .vp-how-title strong {
            font-size: 27px;
        }

        .vp-steps li {
            font-size: 11px;
            margin-bottom: 9px;
        }

        .vp-conditions {
            margin-top: 48px;
        }

        .vp-conditions h3 {
            font-size: 24px;
            text-transform: none;
        }

        .vp-conditions ul {
            font-size: 10px;
            line-height: 1.65;
        }

        .vp-validity {
            position: relative;
            left: -34px;
            width: calc(100% + 68px);
            height: 52px;
            margin: 45px 0 0;
            border-radius: 0;
            order: 3;
        }

        .vp-conditions {
            display: flex;
            flex-direction: column;
        }

        .vp-conditions h3 { order: 1; }
        .vp-conditions ul { order: 2; }
        .vp-conditions .vp-validity { order: 3; }

        .vp-white-section {
            width: 100%;
            min-height: 350px;
            padding: 20px 15px 15px;
            display: flex;
            flex-direction: column;
            align-items: center;

            background: #fff;
        }

        /* =========================
        TARJETA QR
        ========================= */

        .vp-qr-column {
            width: 100%;

            display: flex;
            justify-content: center;
        }

        .vp-qr-card {
            width: 110px;
            min-height: 165px;

            padding: 10px 10px 12px;

            display: flex;
            flex-direction: column;
            align-items: flex-start;

            gap: 6px;

            background: #fff;

            box-shadow:
                0 2px 2px rgba(0, 0, 0, .18),
                0 1px 2px rgba(0, 0, 0, .08);
        }

        .vp-qr {
            width: 65px;
            height: 65px;

            margin: 0 auto;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vp-qr img {
            width: 65px;
            height: 65px;

            object-fit: contain;
        }

        .vp-qr-info {
            width: 100%;

            display: flex;
            flex-direction: column;

            align-items: flex-start;

            font-family: Montserrat, Arial, sans-serif;

            color: #111;

            line-height: 1.05;
        }

        .vp-voucher-code,
        .vp-qr-info > span:first-child {
            margin-bottom: 5px;

            font-size: 9px;
            font-weight: 600;
        }

        .vp-qr-info strong {
            margin-bottom: 1px;

            font-size: 10px;
            line-height: 1.05;

            font-weight: 700;

            text-transform: uppercase;
        }

        .vp-qr-info > span:last-child {
            font-size: 10px;
            line-height: 1.05;

            font-weight: 400;

            text-transform: uppercase;
        }


        /* =========================
        COMUNIDAD
        ========================= */

        .vp-community {
            width: 100%;

            margin-top: 22px;

            display: grid;

            grid-template-columns: 1fr 85px;
            grid-template-areas:
                "text gifts"
                "link link";

            align-items: center;

            column-gap: 10px;
            row-gap: 14px;
        }

        .vp-community-text {
            grid-area: text;

            justify-self: start;

            display: flex;
            flex-direction: column;

            font-family: Montserrat, Arial, sans-serif;

            font-size: 27px;
            line-height: 1.08;

            color: #0768f7;

            text-align: left;
        }

        .vp-community-text span,
        .vp-community-text strong {
            display: block;
        }

        .vp-community-text strong {
            font-weight: 700;
            font-style: italic;
        }


        /* =========================
        REGALITOS
        ========================= */

        .vp-gifts-mark {
            grid-area: gifts;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vp-gifts-mark img {
            width: 98px;
            height: auto;

            display: block;
        }


        /* =========================
        BOTÓN
        ========================= */

        .vp-community-link {
            grid-area: link;

            justify-self: center;

            width: 102px;
            height: 24px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 0;

            border: 1px solid #1670ff;
            border-radius: 999px;

            color: #1670ff;

            font-family: Montserrat, Arial, sans-serif;

            font-size: 10px;
            font-weight: 600;

            text-decoration: none;
        }
    }

    @media (max-width: 420px) {
        .vp-value-amount {
            font-size: 44px;
        }

        .vp-recommendation {
            right: 8px;
            min-width: 93px;
        }

        .vp-commerce-description {
            font-size: 11px;
        }
    }

@media (max-width: 768px) {
    .v-mobile-navbar {
        display: none;
    }
}

.vp-bottom-bar {
    transition: transform 0.3s ease;
    transform: translateY(0);
}

.vp-bottom-bar.is-hidden {
    transform: translateY(100%);
}
</style>
@endpush

@section('content')
<div class="vp-desktop-navbar">
    @include('partials.navbar')
</div>

<main class="vp-page">
    <header class="vp-mobile-header">
        <a href="{{ $volverUrl }}" class="vp-back" aria-label="Volver">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M15 18l-6-6 6-6"/></svg>
        </a>
        <h1>Así se va a ver tu regalo</h1>
        <a href="{{ $volverUrl }}" class="vp-close" aria-label="Cerrar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 6l12 12M18 6L6 18"/></svg>
        </a>
    </header>

    <div class="vp-shell">
        <h1 class="vp-page-title">
            <a href="{{ $volverUrl }}" class="vp-back" aria-label="Volver">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M15 18l-6-6 6-6"/></svg>
            </a>
            Así se va a ver tu regalo
        </h1>

        <div class="vp-stage">
            <article class="vp-voucher">
                <section class="vp-green-section" style="background: {{ $entidad->ent_color_fondo ?? '#49b889' }};">
                    <div class="vp-voucher-topline">
                        <span class="vp-code">{{ str_pad((string) $codigoVoucher, 8, '0', STR_PAD_LEFT) }}</span>
                        <span class="vp-brand">
                            <img src="{{ asset('images/logo-2.png') }}" alt="Vauchis" class="v-footer__logo">
                        </span>
                    </div>

                    <div class="vp-gift-card">
                        <div class="vp-message-panel">
                            <span class="vp-hand-label">Para</span>
                            <p class="vp-hand-value">{{ $nombrePara }}</p>
                            <span class="vp-hand-label">De</span>
                            <p class="vp-hand-value">{{ $nombreDe }}</p>
                            <p class="vp-hand-message">{{ $mensajeVoucher }}</p>
                        </div>

                        <div class="vp-value-panel">
                            @if ($modalidad->tipo_mod_id==1 || $modalidad->tipo_mod_id==2)
                            <div class="vp-value-copy">
                                <p class="vp-value-eyebrow">Voucher {{ $entidad->ent_nombre_fantasia }}<br><span>Vale por:</span></p>

                                {{-- @if ($influencer>0)
                                    <div class="vp-recommendation">★ Recomendado por<br>@visitsalta_</div>
                                @endif --}}

                                <p class="vp-value-amount">${{ number_format((float) $montoVoucher, 0, ',', '.') }}</p>
                            </div>
                            <div class="vp-value-image">
                                <img src="{{ $imagenVoucher }}" alt="{{ $nombreVoucher }}">
                            </div>

                            @else

                            <div class="vp-value-copy">
                                <p class="vp-value-eyebrow">Voucher {{ $entidad->ent_nombre_fantasia }}</p>

                                {{-- @if ($influencer>0)
                                    <div class="vp-recommendation">★ Recomendado por<br>@visitsalta_</div>
                                @endif --}}

                                <p class="vp-title">{{ $nombreVoucher }}</p>
                                <p class="vp-subtitle">{{ $voucher->vou_descripcion }}</p>
                            </div>
                            <div class="vp-value-image">
                                <img src="{{ $imagen_voucher_vou }}" alt="{{ $nombreVoucher }}">
                            </div>
                            @endif
                            
                        </div>
                    </div>

                    <div class="vp-commerce-row">
                        <div class="vp-commerce">
                            <div class="vp-commerce-logo">
                                @if($logoEntidad)
                                    <img src="{{ $logoEntidad }}" alt="{{ $nombreEntidad }}">
                                @else
                                    {{ $nombreEntidad }}
                                @endif
                            </div>
                            <div>
                                <span class="vp-commerce-label">Canjeá tu Vauchis en:</span>
                                <strong class="vp-commerce-name">{{ $nombreEntidad }}</strong>
                                <span class="vp-commerce-description">{{ $descripcionEntidad }}</span>
                            </div>
                        </div>

                        <a href="{{ $telefono!='' ? 'https://wa.me/549' . preg_replace('/\D+/', '', $telefono) : '#' }}" class="vp-whatsapp" target="_blank" rel="noopener">
                            <img src="{{ asset('images/icono-wpp.png') }}" alt="Whatsapp">
                            Contacta al vendedor
                        </a>
                    </div>

                    <ul class="vp-addresses">
                        @if ($sucursales->isNotEmpty())
                            @foreach($sucursales as $sucursal)
                                @php
                                    $direccion = $sucursal->ed_direccion;
                                @endphp
                                @if($direccion)
                                    <li>
                                        <i class="bi bi-geo-alt"></i>
                                        <span>{{ $direccion }}</span>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            
                        @endif
                        
                    </ul>
                </section>

                <section class="vp-blue-section">
                    <div class="vp-how">
                        <h2 class="vp-how-title">Cómo canjear <strong>tu Vauchis</strong></h2>
                        <ol class="vp-steps">
                            <li><img src="{{ asset('images/ilustracion_Nro1.svg') }}" alt="1" class=""><span>Presentá tu voucher al vendedor</span></li>
                            <li><img src="{{ asset('images/ilustracion_Nro2.svg') }}" alt="2" class=""><span>{{ $modalidad->mod_texto_canje ?? 'Elegí el producto que más te guste' }}</span></li>
                            <li><img src="{{ asset('images/ilustracion_Nro3.svg') }}" alt="3" class=""><strong>¡Listo, ya es tuyo!</strong></li>
                        </ol>
                    </div>

                    <div class="vp-conditions">
                        <div class="vp-validity">Válido desde {{ $fecha_actual }} hasta {{ $fechaVencimiento }}</div>
                        <h3>Tené en cuenta</h3>
                        @if ($condiciones!='')
                            {!! $condiciones !!}
                        @else
                            <ul>
                                <li>Canjeable por productos o servicios del local según modalidad del voucher.</li>
                                <li>Válido para canjear desde <strong>{{ $fecha_actual }}</strong> hasta el <strong>{{ $fechaVencimiento }}</strong>.</li>
                                <li><strong>No reembolsable</strong> ni canjeable por dinero.</li>
                                <li>Se canjea en <b>{{ $direcciones_label }}</b></li>
                                <li>Retiro a cargo del portador del voucher y a acordar con el vendedor.</li>
                                <li>Envío no incluido.</li>
                                <li>Uso único.</li>
                            </ul>
                        @endif
                    </div>
                </section>

                <section class="vp-white-section">

                    {{-- TARJETA QR --}}
                    <div class="vp-qr-column">
                        <div class="vp-qr-card">

                            <div class="vp-qr">
                                @if($qrImagen)
                                    {{-- <img src="{{ $qrImagen }}" alt="Código QR del voucher"> --}}
                                    {!! $qrImagen !!}
                                @endif
                            </div>

                            <div class="vp-qr-info">
                                <span class="vp-voucher-code">
                                    {{ str_pad((string) $codigoVoucher, 8, '0', STR_PAD_LEFT) }}
                                </span>

                                <strong>
                                    Voucher {{ $entidad->ent_nombre_fantasia }}<br>
                                    Vale por:
                                </strong>

                                <span>
                                    @if ($modalidad->tipo_mod_id == 1 || $modalidad->tipo_mod_id == 2)
                                        ${{ number_format((float) $montoVoucher, 0, ',', '.') }}
                                    @else
                                        {{ $nombreVoucher }}
                                    @endif
                                </span>
                            </div>

                        </div>
                    </div>


                    {{-- COMUNIDAD --}}
                    <div class="vp-community">

                        <div class="vp-community-text">
                            <span>Uníte a la</span>
                            <strong>comunidad</strong>
                            <span>de regalos</span>
                        </div>

                        <a class="vp-community-link" href="{{ url('/') }}">
                            <strong>vauchis.</strong>com
                        </a>

                        <div class="vp-gifts-mark" aria-hidden="true">
                            <img
                                src="{{ asset('images/Regalitos.svg') }}"
                                alt="Vauchis"
                            >
                        </div>

                    </div>

                </section>
            </article>
        </div>
    </div>
</main>

<div class="vp-bottom-bar">
    <div class="vp-bottom-inner">
        <a href="{{ $editarUrl }}" class="vp-action-button">Editar mensaje</a>

        @if($continuarUrl !== '#')
            <a href="{{ $continuarUrl }}" class="vp-action-button vp-action-button--primary">Continuar</a>
        @else
            <button type="button" class="vp-action-button vp-action-button--primary" id="btn-continuar-voucher">Continuar</button>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const continueButton = document.getElementById('btn-continuar-voucher');

    if (continueButton) {
        continueButton.addEventListener('click', function () {
            const form = document.getElementById('form-vista-previa');

            if (form) {
                form.submit();
                return;
            }

            console.warn('Definí $continuarUrl o agregá un formulario con id="form-vista-previa".');
        });
    }
});
</script>

<script>
$(function () {
    let lastScrollTop = $(window).scrollTop();

    $(window).on('scroll', function () {
        const currentScrollTop = $(this).scrollTop();

        if (currentScrollTop > lastScrollTop) {
            // Scroll hacia abajo
            $('.vp-bottom-bar').addClass('is-hidden');
        } else {
            // Scroll hacia arriba
            $('.vp-bottom-bar').removeClass('is-hidden');
        }

        lastScrollTop = Math.max(currentScrollTop, 0);
    });
});
</script>
@endpush
