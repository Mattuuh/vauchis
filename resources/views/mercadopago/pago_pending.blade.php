@extends('layouts.app')

@section('content')

<main class="vs-page">

    @include('partials.navbar')

    <section class="v-checkout-result">
        <div class="container">
            <div class="v-result-card v-result-card--pending">
                <div class="v-result-icon">
                    <i class="bi bi-clock-fill"></i>
                </div>

                <h1>Pago pendiente</h1>

                <p>
                    Tu pago está siendo procesado. Te avisaremos cuando se confirme la operación.
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