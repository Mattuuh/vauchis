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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <style>

        /* =========================================================
   AJUSTES EXCLUSIVOS PARA GENERAR EL PDF
   ========================================================= */

@page {
    /*
     * 8in = 768px
     * 55in ≈ 5280px
     *
     * Luego podemos ajustar esta altura según el contenido real.
     */
    size: 8in 55in;
    margin: 0;
}

html,
body {
    width: 768px !important;

    /*
     * IMPORTANTE:
     * ya no fijamos 1024px de alto
     */
    height: auto !important;
    min-height: 0 !important;

    margin: 0 !important;
    padding: 0 !important;

    background: #ffffff !important;

    /*
     * No ocultar el contenido vertical
     */
    overflow: visible !important;

    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
}


/*
 * Hoja física del PDF
 */
.pdf-sheet {
    width: 768px;

    /*
     * Ya no usamos 1024px.
     */
    height: auto;
    min-height: 0;

    display: flex;

    justify-content: center;
    align-items: flex-start;

    padding-top: 15px;

    /*
     * Fundamental para que no corte el voucher
     */
    overflow: visible;

    background: #ffffff;
}


/*
 * Mantenemos exactamente la misma escala
 * que ya utilizabas.
 */
.pdf-scale {
    width: 720px;

    zoom: 0.63;
}


/*
 * Anulamos comportamientos propios de la vista web.
 */
.pdf-scale .vp-stage {
    margin: 0 auto;

    overflow: visible;

    scrollbar-width: none;
}

.pdf-scale .vp-stage::-webkit-scrollbar {
    display: none;
}


/*
 * Conservamos el borde redondeado del voucher.
 */
.pdf-scale .vp-voucher {
    overflow: hidden;
}
    </style>
</head>

<body>

<div class="pdf-sheet">
<div class="pdf-scale">
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
                    <img src="{{ $wpplogo }}" alt="Whatsapp">Contacta al vendedor
                </a>
            </div>

            <ul class="vp-addresses">
                @php
                    $direcciones_label='';
                @endphp
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
                @endif
                
            </ul>
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
</div>

</body>
</html>