@extends('layouts.app')

@section('title', 'Canjear voucher')

@push('styles')
<style>
    .vc-page {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        /* Espacio para navbar desktop + separación visual */
        padding: 7.5em 20px 50px;
        background: #f7f8fb;
        font-family: 'Montserrat', sans-serif;
        box-sizing: border-box;
    }

    .vc-card {
        width: 100%;
        max-width: 520px;
        background: #fff;
        border-radius: 18px;
        padding: 32px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, .08);
        text-align: center;
    }

    .vc-icon {
        width: 74px;
        height: 74px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eaf8f1;
        color: #49b889;
        font-size: 34px;
    }

    .vc-title {
        font-size: 26px;
        font-weight: 800;
        color: #07378C;
        margin-bottom: 8px;
    }

    .vc-subtitle {
        font-size: 14px;
        color: #717171;
        margin-bottom: 26px;
    }

    .vc-info {
        text-align: left;
        background: #f8f9fb;
        border-radius: 14px;
        padding: 20px;
        margin-bottom: 24px;
    }

    .vc-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        padding: 10px 0;
        border-bottom: 1px solid #e7e7e7;
    }

    .vc-row:last-child {
        border-bottom: 0;
    }

    .vc-label {
        font-size: 13px;
        font-weight: 600;
        color: #777;
    }

    .vc-value {
        font-size: 14px;
        font-weight: 700;
        color: #222;
        text-align: right;
    }

    .vc-btn {
        width: 100%;
        border: 0;
        border-radius: 999px;
        background: #07378C;
        color: #fff;
        padding: 14px 20px;
        font-size: 16px;
        font-weight: 700;
        transition: .2s ease;
    }

    .vc-btn:hover {
        opacity: .92;
    }

    .vc-status {
        padding: 14px 16px;
        border-radius: 12px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .vc-status.success {
        background: #e9f8f0;
        color: #24845c;
    }

    .vc-status.warning {
        background: #fff4dd;
        color: #996b00;
    }

    @media (max-width: 576px) {
        .vc-page {
            min-height: 100dvh;

            /*
            * Espacio para navbar mobile.
            * Ajustá 90px si tu navbar tiene otra altura.
            */
            padding-top: 7em;

            align-items: flex-start;
        }

        .vc-card {
            padding: 24px 18px;
            border-radius: 16px;
        }

        .vc-title {
            font-size: 22px;
        }

        .vc-row {
            flex-direction: column;
            gap: 4px;
        }

        .vc-value {
            text-align: left;
        }
    }
</style>
@endpush

@section('content')

@include('partials.navbar')

<div class="vc-page">

    <div class="vc-card">

        <div class="vc-icon"><i class="bi bi-gift"></i></div>

        <h1 class="vc-title">Canjear voucher</h1>

        <p class="vc-subtitle">
            Verificá los datos antes de confirmar el canje.
        </p>

        @if(session('success'))
            <div class="vc-status success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="vc-status warning">
                {{ session('warning') }}
            </div>
        @endif

        <div class="vc-info">

            <div class="vc-row">
                <span class="vc-label">Voucher</span>

                <span class="vc-value">
                    {{ $voucher->vou_nombre }}
                </span>
            </div>

            <div class="vc-row">
                <span class="vc-label">Comercio</span>

                <span class="vc-value">
                    {{ $voucher->ent_nombre_fantasia }}
                </span>
            </div>

            <div class="vc-row">
                <span class="vc-label">Beneficiario</span>

                <span class="vc-value">
                    {{ $voucher->vd_variante_nombre_para }}
                </span>
            </div>

            <div class="vc-row">
                <span class="vc-label">Código</span>

                <span class="vc-value">
                    {{ str_pad($voucher->vd_codigo, 8, '0', STR_PAD_LEFT) }}
                </span>
            </div>

            @if(!empty($voucher->vd_monto_total))
                <div class="vc-row">
                    <span class="vc-label">Valor</span>

                    <span class="vc-value">
                        $ {{ number_format($voucher->vd_monto_total, 2, ',', '.') }}
                    </span>
                </div>
            @endif

        </div>

        @if($voucher->vd_estado2 !== 'CA')
            <form method="POST" action="{{ route('voucher.canjear.confirmar', $voucher->vd_id) }}">
                @csrf

                <button type="submit" class="vc-btn" onclick="return confirm('¿Confirmás el canje de este voucher?')">
                    Confirmar canje
                </button>
            </form>
        @else
            <div class="vc-status success"><i class="bi bi-check-circle-fill"></i>Voucher ya canjeado</div>
        @endif

    </div>

</div>

@endsection