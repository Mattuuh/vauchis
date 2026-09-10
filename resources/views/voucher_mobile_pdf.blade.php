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
    $codigoVoucher = data_get($voucher ?? null, 'vd_codigo', data_get($voucher ?? null, 'vou_id', '00056970'));
    $nombreVoucher = data_get($voucher ?? null, 'vou_nombre', 'Voucher Cumbres');
    $nombreEntidad = data_get($entidad ?? null, 'ent_nombre_fantasia', data_get($entidad ?? null, 'ent_nombre', 'Cumbres'));
    $descripcionEntidad = data_get($entidad ?? null, 'ent_descripcion_corta', 'Parte de: Alto Noa Shopping');

    $nombreDe = old('de', session('voucher.de', request('de', 'Sole m., Gabi T. & Santi')));
    $nombrePara = old('para', session('voucher.para', request('para', 'Flor')));
    $mensajeVoucher = old('mensaje', session('voucher.mensaje', request('mensaje', 'Querida Flor, espero que pases un cumple hermoso. Te queremos mucho.')));


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

    $imagenPrincipal = isset($voucher) && isset($voucher->imagenes)
        ? $voucher->imagenes->first()
        : null;

    $bannerEntidadRelacion = data_get($entidad ?? null, 'imagenPrincipal');
    $imagenVoucher = data_get($bannerEntidadRelacion, 'ef_img_path')
        ? asset('storage/' . data_get($bannerEntidadRelacion, 'ef_img_path'))
        : asset('images/default-voucher.png');
    $imagenVoucher_raw = data_get($bannerEntidadRelacion, 'ef_img_path');

    $logoEntidadRelacion = data_get($entidad ?? null, 'logoPrincipal');
    $logoEntidad = data_get($logoEntidadRelacion, 'ef_img_path')
        ? asset('storage/' . data_get($logoEntidadRelacion, 'ef_img_path'))
        : null;
    $logoEntidad_raw = data_get($logoEntidadRelacion, 'ef_img_path');

    $qrImagen = $qrImagen ?? data_get($voucher ?? null, 'qr_url');

    /*
    |--------------------------------------------------------------------------
    | IMÁGENES LOCALES
    |--------------------------------------------------------------------------
    |
    | Para imágenes almacenadas dentro de /public usamos file://.
    | Esto evita depender de que APP_URL sea accesible desde Chromium.
    |
    */

    $pdfImage = function ($path) {
        return 'file://' . str_replace('\\', '/', public_path($path));
    };

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

    $logoVauchis = imagenBase64(public_path('images/logo-2.png'));
    $logoEntidad = imagenBase64(storage_path('app/public/' . $logoEntidad_raw));
    $imagenVoucher = imagenBase64(storage_path('app/public/' . $imagenVoucher_raw));
    $wpplogo = imagenBase64(public_path('images/icono-wpp.png'));
    $ilustracion_1 = imagenBase64(public_path('images/ilustracion_Nro1.svg'));
    $ilustracion_2 = imagenBase64(public_path('images/ilustracion_Nro2.svg'));
    $ilustracion_3 = imagenBase64(public_path('images/ilustracion_Nro3.svg'));
    $regalitos = imagenBase64(public_path('images/Regalitos.svg'));
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Voucher {{ $entidad->ent_nombre_fantasia ?? '' }} - {{-- {{ str_pad((string) $codigoVoucher, 8, '0', STR_PAD_LEFT) }} --}}</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Grape+Nuts&family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --vp-green: #49b889;
        --vp-blue: #416fb6;
        --vp-action: #0968f7;
        --vp-cream: #f8f4e9;
    }

    @page {
        size: 60mm 310mm;
        margin: 0;
    }

    * {
        box-sizing: border-box;
    }

    html,
    body {
        /* width: 375px; */
        width: 100% !important;
        margin: 0;
        padding: 0;
        background: #fff;
        font-family: 'Montserrat', Arial, sans-serif;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    body {
        overflow: visible;
    }

    /* 375px -> 60mm. Mantiene una referencia mobile comoda para maquetar. */
    .pdf-sheet {
        width: 355px;
        /* margin: 0; */
        margin: 10px auto;
        overflow: hidden;
        border: 5px solid rgba(0, 0, 0, 0.12);
        border-radius: 18px;
        /* padding: 0; */
        zoom: .6047;
        background: #fff;
    }

    /* .vp-stage,
    .vp-voucher {
        width: 375px;
        margin: 0;
        padding: 0;
    } */

    .vp-stage {
        /* overflow: visible;
        box-shadow: none;
        border-radius: 0; */

        width: 100%;
        margin: 0;
        overflow: hidden;
        border-radius: 18px;
    }

    .vp-voucher {
        /* overflow: hidden;
        background: #fff;
        border-radius: 0; */

        width: 100%;
        overflow: hidden;
        border-radius: 18px;
        background: #fff;
    }

    /* =========================================================
       BLOQUE PRINCIPAL / COLOR DEL COMERCIO
       ========================================================= */
.vp-green-section {
    position: relative;
    width: 100%;
        padding: 38px 14px 32px;
    overflow: hidden;
}

.vp-green-section::before,
.vp-green-section::after {
    content: '';
    position: absolute;
    width: 150px;
    height: 150px;
        border: 8px solid rgba(255,255,255,.12);
    border-radius: 48% 52% 50% 50%;
    transform: rotate(25deg);
        pointer-events: none;
}

.vp-green-section::before {
        top: -92px;
        left: 14px;
}

.vp-green-section::after {
        right: -95px;
    bottom: 20px;
}

.vp-voucher-topline {
    position: relative;
    z-index: 2;
        height: 44px;
    display: flex;
    align-items: center;
    justify-content: space-between;
        padding: 0 18px;
    color: #fff;
    border-radius: 13px 13px 0 0;
}

.vp-code {
        font-size: 10px;
        font-weight: 500;
}

.vp-brand {
        display: flex;
    align-items: center;
        justify-content: flex-end;
}

.vp-brand img {
    display: block;
        width: 118px;
        height: auto;
        max-height: 34px;
        object-fit: contain;
}

    /* =========================================================
       REGALO: MENSAJE + VALOR + IMAGEN
       ========================================================= */
.vp-gift-card {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
        width: 100%;
    overflow: hidden;
}

.vp-message-panel {
        min-height: 205px;
        padding: 22px 28px 20px;
    background: #f8f5eb;
        border-bottom: 3px dashed #222;
        border-radius: 0 0 14px 14px;
}

.vp-hand-label {
    display: block;
        margin: 0 0 2px;
        color: #555;
    font-family: 'Grape Nuts', cursive;
        font-size: 19px;
        line-height: 1;
        letter-spacing: .08em;
    text-transform: uppercase;
}

.vp-hand-value {
        margin: 0 0 8px;
        padding: 0 5px 4px;
    border-bottom: 1px solid #777;
    font-family: 'Grape Nuts', cursive;
        font-size: 29px;
    font-weight: 500;
    font-style: italic;
        line-height: 1.05;
    text-align: center;
    overflow-wrap: anywhere;
}

.vp-hand-message {
        margin: 18px 0 0;
    font-family: 'Grape Nuts', cursive;
        font-size: 22px;
    font-style: italic;
        line-height: 1.18;
    text-align: center;
    overflow-wrap: anywhere;
}

.vp-value-panel {
        width: 100%;
    overflow: hidden;
    background: #fff;
        border-radius: 14px;
}

.vp-value-copy {
    position: relative;
        min-height: 132px;
        padding: 26px 28px 18px;
        background: var(--vp-cream);
}

.vp-value-eyebrow {
    margin: 0;
        font-size: 10px;
    line-height: 1.2;
    text-transform: uppercase;
        font-weight: 400;
}

.vp-value-eyebrow span {
    font-weight: 800;
}

.vp-value-amount {
        margin: 18px 0 0;
        font-size: 44px;
    font-weight: 700;
    line-height: 1;
        letter-spacing: -.035em;
    text-align: center;
}

.vp-title {
        margin: 17px 0 0;
        font-size: 23px;
    font-weight: 700;
        line-height: 1.1;
    text-align: center;
}

.vp-subtitle {
        margin: 8px auto 0;
        max-width: 290px;
        font-size: 13px;
    font-weight: 400;
        line-height: 1.25;
    text-align: center;
}

.vp-recommendation {
    position: absolute;
        top: 25px;
    right: 14px;
        min-width: 100px;
        padding: 8px;
    border-radius: 5px;
    background: #fff1c9;
    color: #b77717;
    font-size: 7px;
    font-weight: 600;
    text-align: center;
    text-transform: uppercase;
}

.vp-value-image {
    width: 100%;
    height: 185px;
    overflow: hidden;
}

.vp-value-image img {
        display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

    /* =========================================================
       COMERCIO / SUCURSALES / WHATSAPP
       ========================================================= */
.vp-commerce-row {
    position: relative;
    z-index: 2;
    width: 100%;
        padding: 26px 24px 28px;
}

.vp-commerce {
    display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
    color: #fff;
}

.vp-commerce-logo {
        flex: 0 0 70px;
        width: 70px;
        height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border: 3px solid #fff;
    border-radius: 50%;
    color: #fff;
        font-size: 10px;
    font-weight: 700;
    text-align: center;
}

.vp-commerce-logo img {
        display: block;
    width: 100%;
    height: 100%;
    object-fit: contain;
    background: #fff;
}

.vp-commerce-info {
    flex: 1;
    min-width: 0;
}

.vp-commerce-label {
    display: block;
        margin-bottom: 3px;
        font-size: 10px;
        line-height: 1.15;
    font-weight: 400;
    text-transform: uppercase;
}

.vp-commerce-name {
    display: block;
        font-size: 21px;
        line-height: 1.05;
    font-weight: 700;
        overflow-wrap: anywhere;
}

.vp-addresses {
    width: 100%;
        margin: 0 0 24px;
        padding: 0 6px;
    list-style: none;
    color: #fff;
}

.vp-addresses li {
    display: flex;
    align-items: flex-start;
        gap: 9px;
        margin: 0 0 10px;
        font-size: 11px;
        line-height: 1.35;
}

.vp-addresses li:last-child {
    margin-bottom: 0;
}

.vp-addresses li i {
    flex: 0 0 auto;
        font-size: 15px;
    line-height: 1;
    margin-top: 1px;
}

.vp-addresses li span {
    flex: 1;
    min-width: 0;
        overflow-wrap: anywhere;
    }

    .vp-whatsapp {
        width: 100%;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
        padding: 0 18px;
        border-radius: 999px;
        background: #fff;
        color: #111;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
    }

    .vp-whatsapp img {
        flex: 0 0 auto;
        width: 31px;
        height: 31px;
        object-fit: contain;
}

    /* =========================================================
       COMO CANJEAR / CONDICIONES
       ========================================================= */
.vp-blue-section {
    position: relative;
        width: 100%;
    min-height: 0;
        padding: 38px 34px 0;
    overflow: hidden;
    background: var(--vp-blue);
    color: #fff;
}

.vp-blue-section::before {
        content: '';
    position: absolute;
        left: 20%;
        bottom: 35px;
        width: 85%;
        height: 55%;
        background-image: url('/images/ilustración-estrella-voucher.svg');
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
        opacity: .22;
    pointer-events: none;
}

.vp-how,
.vp-conditions {
    position: relative;
    z-index: 2;
}

.vp-how-title {
        margin: 0 0 25px;
        font-size: 31px;
        font-weight: 300;
        line-height: .92;
        letter-spacing: -.02em;
}

.vp-how-title strong {
    display: block;
        font-size: 32px;
        font-weight: 800;
}

.vp-steps {
    margin: 0;
    padding: 0;
    list-style: none;
}

.vp-steps li {
    display: flex;
    align-items: center;
        gap: 9px;
        margin-bottom: 8px;
        font-size: 11px;
        line-height: 1.25;
}

    .vp-steps li img {
        flex: 0 0 23px;
        width: 23px;
        height: 23px;
        object-fit: contain;
}

    .vp-conditions {
    display: flex;
        flex-direction: column;
        margin-top: 38px;
}

.vp-conditions h3 {
        order: 1;
        margin: 0 0 13px;
        font-size: 30px;
        font-weight: 800;
        line-height: 1;
        text-transform: none;
}

.vp-conditions ul {
        order: 2;
    margin: 0;
        padding-left: 14px;
        font-size: 10.5px;
        line-height: 1.42;
}

    .vp-conditions li {
        margin-bottom: 3px;
        overflow-wrap: anywhere;
}

.vp-validity {
    order: 3;
    position: relative;
    left: -34px;
    width: calc(100% + 68px);
        min-height: 42px;
        margin: 28px 0 0;
        padding: 8px 12px;
    display: flex;
    align-items: center;
    justify-content: center;
        background: var(--vp-action);
        font-size: 9px;
        font-weight: 600;
        line-height: 1.25;
    text-align: center;
    text-transform: uppercase;
}

    /* =========================================================
       QR + COMUNIDAD
       ========================================================= */
.vp-white-section {
    width: 100%;
        min-height: 430px;
        padding: 22px 16px 34px;
    display: flex;
    flex-direction: column;
    align-items: center;
    background: #fff;
}

.vp-qr {
    width: 145px;
    /* height: 145px; */
    min-height: 180px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.vp-qr svg,
.vp-qr img {
    display: block;
    width: 145px !important;
    height: 145px !important;
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
    line-height: 1.05;
    text-transform: uppercase;
}

.vp-qr-info > span:last-child {
    font-size: 14px;
    font-weight: 400;
    line-height: 1.08;
    text-transform: uppercase;
    overflow-wrap: anywhere;
}

.vp-community {
    width: 100%;
        margin-top: 34px;
    display: grid;
        grid-template-columns: 1fr 96px;
    grid-template-areas:
            'text gifts'
            'link link';
    align-items: center;
    column-gap: 10px;
        row-gap: 30px;
}

.vp-community-text {
    grid-area: text;
    font-size: 27px;
        line-height: .98;
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

.vp-gifts-mark {
    grid-area: gifts;
    display: flex;
    align-items: center;
    justify-content: center;
}

.vp-gifts-mark img {
    display: block;
        width: 94px;
    height: auto;
}

.vp-community-link {
    grid-area: link;
    justify-self: center;
        width: 126px;
        height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #1670ff;
    border-radius: 999px;
    color: #1670ff;
    font-size: 10px;
        font-weight: 500;
    text-decoration: none;
}
</style>

</head>

<body>

<div class="pdf-sheet">
<div class="vp-stage">
    <article class="vp-voucher">
        <section class="vp-green-section" style="background: {{ $entidad->ent_color_fondo ?? '#49b889' }};">
            <div class="vp-voucher-topline">
                <span class="vp-code">{{ str_pad((string) $codigoVoucher, 8, '0', STR_PAD_LEFT) }}</span>
                <span class="vp-brand">
                    {{-- <img src="{{ asset('images/logo-2.png') }}" alt="Vauchis" class="v-footer__logo"> --}}
                    <img src="{{ $logoVauchis }}" alt="Vauchis" class="v-footer__logo">
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

                    <div class="vp-commerce-info">
                        <span class="vp-commerce-label">Canjeá tu Vauchis en:</span>
                        <strong class="vp-commerce-name">{{ $nombreEntidad }}</strong>
                    </div>
                </div>

                <ul class="vp-addresses">
                    @if ($sucursales->isNotEmpty())
                        @foreach($sucursales as $sucursal)
                            @php
                                $direccion = $sucursal->ed_direccion;
                            @endphp

                            @if($direccion)
                                <li><i class="bi bi-geo-alt"></i><span>{{ $direccion }}</span></li>
                            @endif
                        @endforeach
                    @endif
                </ul>

                <a href="{{ $telefono != '' ? 'https://wa.me/549' . preg_replace('/\D+/', '', $telefono) : '#' }}" class="vp-whatsapp" target="_blank" rel="noopener">
                    <img src="{{ $wpplogo }}" alt="Whatsapp">
                    <span>Contacta al vendedor</span>
                </a>
            </div>
        </section>

        <section class="vp-blue-section">
            <div class="vp-how">
                <h2 class="vp-how-title">Cómo canjear <strong>tu Vauchis</strong></h2>
                <ol class="vp-steps">
                    {{-- <li><img src="{{ asset('images/ilustracion_Nro1.svg') }}" alt="1" class=""><span>Presentá tu voucher al vendedor</span></li> --}}
                    {{-- <li><img src="{{ asset('images/ilustracion_Nro2.svg') }}" alt="2" class=""><span>{{ $modalidad->mod_texto_canje ?? 'Elegí el producto que más te guste' }}</span></li> --}}
                    {{-- <li><img src="{{ asset('images/ilustracion_Nro3.svg') }}" alt="3" class=""><strong>¡Listo, ya es tuyo!</strong></li> --}}
                    <li><img src="{{ $ilustracion_1 }}" alt="1" class=""><span>Presentá tu voucher al vendedor</span></li>
                    <li><img src="{{ $ilustracion_2 }}" alt="2" class=""><span>{{ $modalidad->mod_texto_canje ?? 'Elegí el producto que más te guste' }}</span></li>
                    <li><img src="{{ $ilustracion_3 }}" alt="3" class=""><strong>¡Listo, ya es tuyo!</strong></li>
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
                    {{-- <img src="{{ asset('images/Regalitos.svg') }}" alt="Vauchis"> --}}
                    <img src="{{ $regalitos }}" alt="Vauchis">
                </div>

            </div>

        </section>
    </article>
</div>
</div>

</body>
</html>