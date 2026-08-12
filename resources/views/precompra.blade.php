@extends('layouts.app')

@push('styles')
<style>
    :root {
        --vs-blue: #0868f7;
        --vs-green: #49b889;
        --vs-page-bg: #f1f2fa;
        --vs-text: #111111;
        --vs-muted: #777777;
    }

    .vs-gift-page {
        min-height: calc(100vh - 148px);
        background: var(--vs-page-bg);
        padding-bottom: 96px;
        font-family: Montserrat, sans-serif;
    }

    .vs-gift-shell {
        width: min(1280px, calc(100% - 96px));
        margin: 0 auto;
        padding: 16vh 0 70px;
    }

    .vs-mobile-header {
        display: none;
    }

    .vs-gift-title {
        display: flex;
        align-items: center;
        gap: 24px;
        margin: 0 0 48px;
        font-size: 34px;
        font-weight: 400;
        color: var(--vs-text);
    }

    .vs-back-link,
    .vs-close-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #111;
        text-decoration: none;
    }

    .vs-back-link svg,
    .vs-close-link svg {
        width: 24px;
        height: 24px;
    }

    .vs-gift-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.08fr) minmax(440px, .92fr);
        gap: 68px;
        align-items: start;
    }

    .vs-gift-form {
        padding-top: 2px;
    }

    .vs-gift-field {
        margin-bottom: 24px;
    }

    .vs-gift-field label {
        display: block;
        margin: 0 0 4px 8px;
        color: var(--vs-text);
        font-size: 16px;
        font-weight: 500;
    }

    .vs-gift-field input {
        display: block;
        width: 100%;
        height: 42px;
        padding: 0 18px;
        border: 1.5px solid #111;
        border-radius: 16px;
        background: transparent;
        color: #222;
        font: inherit;
        font-size: 15px;
        outline: none;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .vs-gift-field input::placeholder {
        color: #464646;
        opacity: 1;
    }

    .vs-gift-field input:focus {
        border-color: var(--vs-blue);
        box-shadow: 0 0 0 3px rgba(8, 104, 247, .12);
    }

    .vs-gift-help {
        display: block;
        margin: 6px 0 0 8px;
        color: #565656;
        font-size: 12px;
        line-height: 1.35;
    }

    .vs-summary-card {
        display: grid;
        grid-template-columns: 210px 1fr;
        align-items: center;
        min-height: 264px;
        padding: 34px 44px;
        border-radius: 17px;
        background: #fff;
        box-shadow: 0 4px 3px rgba(0, 0, 0, .26);
    }

    .vs-summary-image {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 0;
    }

    .vs-summary-image img {
        display: block;
        width: 180px;
        max-width: 100%;
        height: 180px;
        object-fit: contain;
    }

    .vs-summary-info {
        padding-left: 18px;
    }

    .vs-summary-title {
        margin: 0 0 12px;
        color: var(--vs-green);
        font-size: 22px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .vs-summary-name,
    .vs-summary-price {
        display: block;
        color: var(--vs-green);
        font-size: 16px;
        line-height: 1.45;
    }

    .vs-summary-price {
        font-weight: 700;
    }

    .vs-summary-validity {
        display: block;
        margin-top: 14px;
        color: #aaa;
        font-size: 16px;
    }

    .vs-checkout-bottom {
        position: fixed;
        z-index: 30;
        left: 0;
        right: 0;
        bottom: 0;
        min-height: 96px;
        border-top: 2px solid rgba(0, 0, 0, .27);
        background: #fff;
    }

    .vs-checkout-bottom-inner {
        width: min(1280px, calc(100% - 96px));
        min-height: 96px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 34px;
    }

    .vs-checkout-total {
        color: #262626;
        font-size: 14px;
        white-space: nowrap;
    }

    .vs-checkout-button {
        width: 390px;
        height: 44px;
        border: 0;
        border-radius: 999px;
        background: #aaa;
        color: #fff;
        font-family: inherit;
        font-size: 16px;
        font-weight: 600;
        /* cursor: pointer; */
        transition: background .2s ease, transform .2s ease;
    }

    .vs-checkout-button.btn-habilitado {
        background: var(--vs-blue);
        transform: translateY(-1px);
    }

    .vs-error-message {
        display: block;
        margin: 5px 8px 0;
        color: #dc3545;
        font-size: 12px;
    }

    .vs-gift-field input.is-invalid {
        border-color: #dc3545;
    }

    @media (max-width: 991.98px) {
        body {
            background: var(--vs-page-bg);
        }

        .vs-gift-page {
            min-height: 100vh;
            padding: 0;
        }

        .vs-gift-page + footer,
        .vs-gift-page ~ footer,
        .vs-checkout-page-footer {
            display: none !important;
        }

        .vs-desktop-navbar {
            display: none;
        }

        .vs-mobile-header {
            position: sticky;
            top: 0;
            z-index: 40;
            display: grid;
            grid-template-columns: 44px 1fr 44px;
            align-items: center;
            height: 92px;
            padding: 0 18px;
            background: #fff;
            box-shadow: 0 3px 7px rgba(0, 0, 0, .15);
        }

        .vs-mobile-header h1 {
            margin: 0;
            text-align: center;
            color: #111;
            font-size: 20px;
            font-weight: 700;
        }

        .vs-gift-shell {
            width: 100%;
            padding: 18px 27px 120px;
        }

        .vs-gift-title {
            display: none;
        }

        .vs-gift-layout {
            display: flex;
            flex-direction: column;
            gap: 34px;
        }

        .vs-summary-card {
            order: 1;
            width: 100%;
            min-height: 154px;
            grid-template-columns: 106px 1fr;
            padding: 18px 20px;
            border-radius: 16px;
        }

        .vs-summary-image img {
            width: 96px;
            height: 96px;
        }

        .vs-summary-info {
            padding-left: 14px;
        }

        .vs-summary-title {
            margin-bottom: 2px;
            font-size: 14px;
            letter-spacing: .03em;
        }

        .vs-summary-name,
        .vs-summary-price,
        .vs-summary-validity {
            font-size: 15px;
            line-height: 1.45;
        }

        .vs-summary-validity {
            margin-top: 4px;
        }

        .vs-gift-form {
            order: 2;
            width: 100%;
            padding-top: 0;
        }

        .vs-gift-field {
            margin-bottom: 26px;
        }

        .vs-gift-field label {
            margin-left: 7px;
            font-size: 15px;
        }

        .vs-gift-field input {
            height: 41px;
            border-radius: 15px;
            font-size: 14px;
        }

        .vs-gift-help {
            margin-left: 7px;
            font-size: 11px;
        }

        .vs-checkout-bottom {
            position: static;
            min-height: 0;
            border: 0;
            background: transparent;
        }

        .vs-checkout-bottom-inner {
            position: fixed;
            z-index: 35;
            left: 27px;
            right: 27px;
            bottom: 28px;
            width: auto;
            min-height: 0;
            display: block;
        }

        .vs-checkout-total {
            display: none;
        }

        .vs-checkout-button {
            width: 100%;
            height: 45px;
            background: var(--vs-blue);
            font-size: 16px;
        }
    }

    @media (max-width: 420px) {
        .vs-gift-shell {
            padding-right: 20px;
            padding-left: 20px;
        }

        .vs-summary-card {
            grid-template-columns: 92px 1fr;
            padding: 16px;
        }

        .vs-summary-image img {
            width: 84px;
            height: 84px;
        }

        .vs-summary-info {
            padding-left: 10px;
        }

        .vs-checkout-bottom-inner {
            left: 20px;
            right: 20px;
        }
    }

@media (max-width: 768px) {
    .v-mobile-navbar {
        display: none;
    }
}
</style>
@endpush

@push('validation')
<script>
$(function () {
    $('#form').validate({
        rules: {
            de: {
                required: true,
                number: false,
                digits: false
            },
            para: {
                required: true,
                number: false
            },
            mensaje: {
                required: true,
                number: false,
                maxlength: 255
            }
        },
        messages: {
            de: {
                required: 'Ingresá el nombre de quien regala'
            },
            para: {
                required: 'Ingresá el nombre del destinatario'
            },
            mensaje: {
                required: 'Ingresá un mensaje para acompañar el regalo',
                maxlength: 'El mensaje no puede superar los 255 caracteres'
            }
        },
        errorElement: 'small',
        errorPlacement: function (error, element) {
            error.addClass('vs-error-message');
            error.insertAfter(element);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });
});
</script>
@endpush

@section('content')

<main class="vs-gift-page">
    @include('partials.navbar')

    <header class="vs-mobile-header">
        <a href="{{ url()->previous() }}" class="vs-back-link" aria-label="Volver">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
        </a>

        <h1>Completá tu regalo</h1>

        <a href="{{ url()->previous() }}" class="vs-close-link" aria-label="Cerrar">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true">
                <path d="M6 6l12 12M18 6L6 18"/>
            </svg>
        </a>
    </header>

    @php
        if ($modalidad->tipo_mod_id==1) {
            $imagenVoucher = asset('images/perfildemarca-reglao-verde.png');

        } elseif ($modalidad->tipo_mod_id==2) {
            $imagenVoucher = asset('images/perfildemarca-regalo-azul.png');

        } else {
            $imagenPrincipal = $voucher->imagenes->first();
            $imagenVoucher = $imagenPrincipal && $imagenPrincipal->vf_img_path
                ? asset('storage/' . $imagenPrincipal->vf_img_path)
                : asset('images/default-voucher.png');
        }

        // $fechaVencimiento = data_get($voucher, 'vou_fecha_vencimiento');
        $fechaVencimientoRaw = new DateTime();
        $dias_vigencia = $voucher->vou_vigencia_dias!='' ? $voucher->vou_vigencia_dias : 0;
        $fechaVencimientoRaw->modify("+$dias_vigencia days");
    @endphp

    <form id="form" action="{{ route('vouchers.vista_previa', ['voucher' => $voucher->vou_id, 'modalidadCampo' => $valores->vmv_id]) }}" method="GET">
        @csrf

        <input type="hidden" id="stock" value="{{ $voucher->vou_stock ?? 0 }}">
        <input type="hidden" id="monto" name="monto" value="{{ $valores->vmv_monto_fijo }}">
        <input type="hidden" name="cantidad" id="cantidad" value="1" data-precio="{{ $valores->vmv_monto_fijo }}">

        <div class="vs-gift-shell">
            <h1 class="vs-gift-title">
                <a href="{{ url()->previous() }}" class="vs-back-link" aria-label="Volver">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15 18l-6-6 6-6"/>
                    </svg>
                </a>
                Completá tu regalo
            </h1>

            <div class="vs-gift-layout">
                <div class="vs-gift-form">
                    <div class="vs-gift-field">
                        <label for="de">1. DE:</label>
                        <input type="text" class="c_input" name="de" id="de" value="{{ old('de') }}" placeholder="Nombre (de quién regala)" autocomplete="name">
                        <small class="vs-gift-help">Ingresa el/los nombre/s que quieras que aparezcan en el voucher</small>
                    </div>

                    <div class="vs-gift-field">
                        <label for="para">2. PARA:</label>
                        <input type="text" class="c_input" name="para" id="para" value="{{ old('para') }}" placeholder="Nombre (a quién le regala)" autocomplete="off">
                        <small class="vs-gift-help">Ingresa el nombre del destinatario</small>
                    </div>

                    <div class="vs-gift-field">
                        <label for="mensaje">3. MENSAJE PERSONALIZADO</label>
                        <input type="text" class="c_input" name="mensaje" id="mensaje" value="{{ old('mensaje') }}" maxlength="255" placeholder="Escribí un mensaje para acompañar el regalo" autocomplete="off">
                    </div>
                </div>

                <aside class="vs-summary-card">
                    <div class="vs-summary-image">
                        <img src="{{ $imagenVoucher }}" alt="{{ $voucher->vou_nombre }}">
                    </div>

                    <div class="vs-summary-info">
                        <h2 class="vs-summary-title">Resumen de compra</h2>
                        <span class="vs-summary-name">Voucher {{ $entidad->ent_nombre_fantasia }}</span>
                        <strong class="vs-summary-price">${{ number_format($valores->vmv_monto_fijo, 0, ',', '.') }}</strong>

                        @if ($fechaVencimientoRaw)
                            <span class="vs-summary-validity">
                                Válido hasta {{ $fechaVencimientoRaw->format('d/m/y') }}
                            </span>
                        @endif
                    </div>
                </aside>
            </div>
        </div>

        <div class="vs-checkout-bottom">
            <div class="vs-checkout-bottom-inner">
                <div class="vs-checkout-total">TOTAL ${{ number_format($valores->vmv_monto_fijo, 0, ',', '.') }}ARS</div>
                <button type="submit" class="vs-checkout-button" id="btn_pagar" disabled>Continuar a la vista previa</button>
            </div>
        </div>
    </form>
</main>

<script id="valores-json" type="application/json">
{!! $valores !!}
</script>

@endsection

@push('scripts')
<script>
$(function () {
    const valores = JSON.parse(document.getElementById('valores-json').textContent || '{}');

    $('#form').on('submit', function () {
        $('#monto').val(valores.vmv_monto_fijo);
    });

    $('.c_input').on('blur',function () {
        // 
        if ($('#form').valid()) {
            // $('#btn_pagar').removeClass('btn-deshabilitado');
            $('#btn_pagar').addClass('btn-habilitado');
            $('#btn_pagar').removeAttr('disabled');
            console.log('validado')
        } else {
            $('#btn_pagar').removeClass('btn-habilitado');
            // $('#btn_pagar').addClass('btn-deshabilitado');
            $('#btn_pagar').attr('disabled', 'disabled');
        }
    });
});
</script>
@endpush
