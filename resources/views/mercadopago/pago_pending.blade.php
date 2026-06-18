@extends('layouts.app')

@section('content')

<main class="vs-page">

    @include('partials.navbar')

    <section class="vs-payment-result vs-payment-result--pending">
        <div class="vs-payment-result__container">

            <div class="vs-payment-result__badge vs-payment-result__badge--pending">
                <i class="bi bi-clock-history"></i>
            </div>

            <span class="vs-payment-result__label vs-payment-result__label--pending">
                Pago en proceso
            </span>

            <h1>Estamos verificando tu pago</h1>

            <p>
                Tu operación fue registrada correctamente y se encuentra en revisión.
                Te notificaremos cuando el pago sea confirmado y tu voucher esté disponible.
            </p>

            <div class="vs-payment-summary">

                <div class="vs-payment-summary__item">
                    <span>Estado</span>
                    <strong>Pendiente</strong>
                </div>

                <div class="vs-payment-summary__item">
                    <span>Fecha</span>
                    <strong>{{ now()->format('d/m/Y H:i') }}</strong>
                </div>

                {{-- Opcional --}}
                {{-- <div class="vs-payment-summary__item">
                    <span>Referencia</span>
                    <strong>{{ $paymentId }}</strong>
                </div> --}}

            </div>

            <div class="vs-payment-result__actions">
                <a href="{{ route('home') }}" class="btn btn-primary">
                    Volver al inicio
                </a>

                <a href="{{-- {{ route('mis.vouchers') }} --}}" class="btn btn-outline-primary">
                    Ver mis vouchers
                </a>
            </div>

            <div class="vs-payment-help">
                <i class="bi bi-info-circle"></i>

                <div>
                    <strong>¿Qué significa esto?</strong>
                    <p>
                        Algunos medios de pago pueden tardar unos minutos u horas en confirmar la operación.
                    </p>
                </div>
            </div>

        </div>
    </section>

    @include('partials.footer')

</main>

@endsection

@push('styles')
<style>
    .vs-payment-result{
        padding: 90px 0;
        background:
            radial-gradient(circle at top right,
            rgba(7,55,140,.08),
            transparent 35%),
            #f7f9fc;
    }

    .vs-payment-result__container{
        max-width: 760px;
        margin: 0 auto;
        background: #fff;
        border-radius: 28px;
        padding: 50px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0,0,0,.08);
    }

    .vs-payment-result__badge{
        width: 90px;
        height: 90px;
        margin: 0 auto 24px;
        border-radius: 50%;
        background: #e9f9ef;
        color: #22c55e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
    }

    .vs-payment-result__label{
        display: inline-block;
        padding: 8px 16px;
        border-radius: 50px;
        background: #eef4ff;
        color: #07378C;
        font-weight: 600;
        margin-bottom: 18px;
    }

    .vs-payment-result h1{
        font-size: 42px;
        font-weight: 800;
        color: #07378C;
        margin-bottom: 16px;
    }

    .vs-payment-result p{
        font-size: 18px;
        color: #6b7280;
        max-width: 520px;
        margin: 0 auto 32px;
    }

    .vs-payment-summary{
        display: grid;
        grid-template-columns: repeat(auto-fit,minmax(180px,1fr));
        gap: 16px;
        margin-bottom: 36px;
    }

    .vs-payment-summary__item{
        background: #f8fafc;
        border-radius: 18px;
        padding: 18px;
    }

    .vs-payment-summary__item span{
        display: block;
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 6px;
    }

    .vs-payment-summary__item strong{
        color: #07378C;
        font-size: 17px;
    }

    .vs-payment-result__actions{
        display: flex;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .vs-payment-result--pending{
        background:
            radial-gradient(circle at top right,
            rgba(245,158,11,.10),
            transparent 35%),
            #f7f9fc;
    }

    .vs-payment-result__badge--pending{
        background: #fff7e6;
        color: #f59e0b;
    }

    .vs-payment-result__label--pending{
        background: #fff7e6;
        color: #b45309;
    }

    .vs-payment-help{
        margin-top: 32px;
        padding: 20px 24px;
        border-radius: 18px;
        background: #f8fafc;
        display: flex;
        gap: 16px;
        align-items: flex-start;
        text-align: left;
    }

    .vs-payment-help i{
        font-size: 24px;
        color: #f59e0b;
        flex-shrink: 0;
    }

    .vs-payment-help strong{
        display: block;
        color: #07378C;
        margin-bottom: 4px;
    }

    .vs-payment-help p{
        margin: 0;
        font-size: 14px;
        color: #64748b;
        max-width: 100%;
    }
</style>
@endpush