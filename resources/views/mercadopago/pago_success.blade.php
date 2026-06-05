@extends('layouts.app')

@section('content')

<main class="vs-page">

    @include('partials.navbar')

    <section class="v-checkout-result">
        <div class="container">
            <div class="v-result-card v-result-card--success">
                <div class="v-result-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                <h1>¡Pago aprobado!</h1>

                <p>
                    Tu compra se realizó correctamente. En breve podrás ver el detalle de tu voucher.
                </p>

                {{-- @if($paymentId)
                    <div class="v-result-info">
                        <strong>ID de pago:</strong> {{ $paymentId }}
                    </div>
                @endif --}}

                <div class="v-result-actions">
                    <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4">
                        Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')

</main>

@endsection