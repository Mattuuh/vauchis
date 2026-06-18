@extends('layouts.app')

@section('content')

<main class="vs-page">

    @include('partials.navbar')

    <section class="vs-payment-result">
        <div class="vs-payment-result__container">

            <div class="vs-payment-result__badge">
                <i class="bi bi-check-lg"></i>
            </div>

            <span class="vs-payment-result__label">
                Pago confirmado
            </span>

            <h1>
                ¡Tu voucher ya está listo!
            </h1>

            <p>
                Recibimos tu pago correctamente. En los próximos minutos
                podrás visualizar tu voucher y compartirlo con quien quieras.
            </p>

            <div class="vs-payment-summary">

                <div class="vs-payment-summary__item">
                    <span>Estado</span>
                    <strong>Aprobado</strong>
                </div>

                <div class="vs-payment-summary__item">
                    <span>Fecha</span>
                    <strong>{{ now()->format('d/m/Y H:i') }}</strong>
                </div>

                {{-- Si tienes el payment id --}}
                {{-- <div class="vs-payment-summary__item">
                    <span>Operación</span>
                    <strong>{{ $paymentId }}</strong>
                </div> --}}

            </div>

            <div class="vs-payment-result__actions">
                <a href="{{ route('home') }}" class="btn btn-primary">
                    Seguir explorando
                </a>

                <a href="#" class="btn btn-outline-primary">
                    Ver mis vouchers
                </a>
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
</style>
@endpush