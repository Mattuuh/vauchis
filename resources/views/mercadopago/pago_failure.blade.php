@extends('layouts.app')

@section('content')

<main class="vs-page">

    @include('partials.navbar')

    <section class="v-checkout-result">
        <div class="container">
            <div class="v-result-card v-result-card--failure">
                <div class="v-result-icon">
                    <i class="bi bi-x-circle-fill"></i>
                </div>

                <h1>No pudimos procesar el pago</h1>

                <p>
                    La operación fue rechazada o cancelada. Podés intentar nuevamente.
                </p>

                {{-- @if($paymentId)
                    <div class="v-result-info">
                        <strong>ID de pago:</strong> {{ $paymentId }}
                    </div>
                @endif --}}

                <div class="v-result-actions">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary rounded-pill px-4">
                        Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')

</main>

@endsection