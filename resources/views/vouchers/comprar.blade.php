@extends('layouts.app')

@push('styles')
    <style>
        .vs-checkout-page {
    background: #f7f8fb;
    min-height: 100vh;
}

.vs-checkout-section {
    padding: 56px 0;
}

.vs-checkout-card {
    max-width: 980px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 0.95fr 1.05fr;
    background: #fff;
    border-radius: 26px;
    overflow: hidden;
    box-shadow: 0 18px 45px rgba(15, 23, 42, 0.1);
}

.vs-checkout-image {
    min-height: 520px;
    background: #eef1f5;
}

.vs-checkout-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.vs-checkout-content {
    padding: 42px;
}

.vs-checkout-badge {
    display: inline-flex;
    padding: 7px 14px;
    border-radius: 999px;
    background: #006eff;
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 18px;
}

.vs-checkout-title {
    font-size: 38px;
    line-height: 1.1;
    font-weight: 800;
    color: #101828;
    margin-bottom: 12px;
}

.vs-checkout-description {
    color: #667085;
    font-size: 16px;
    margin-bottom: 22px;
}

.vs-checkout-commerce {
    background: #f4f7fb;
    border-radius: 16px;
    padding: 16px 18px;
    margin-bottom: 24px;
}

.vs-checkout-commerce span {
    display: block;
    font-size: 13px;
    color: #667085;
    margin-bottom: 4px;
}

.vs-checkout-commerce strong {
    font-size: 16px;
    color: #101828;
}

.vs-checkout-divider {
    height: 1px;
    background: #e5e7eb;
    margin-bottom: 24px;
}

.vs-checkout-field {
    margin-bottom: 22px;
}

.vs-checkout-field label {
    display: block;
    font-weight: 700;
    color: #101828;
    margin-bottom: 8px;
}

.vs-checkout-field input {
    width: 100%;
    height: 48px;
    border: 1px solid #d0d5dd;
    border-radius: 14px;
    padding: 0 16px;
    font-size: 16px;
    outline: none;
}

.vs-checkout-field input:focus {
    border-color: #006eff;
    box-shadow: 0 0 0 4px rgba(0, 110, 255, 0.12);
}

.vs-checkout-row,
.vs-checkout-total {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.vs-checkout-row {
    font-size: 16px;
    color: #344054;
    margin-bottom: 18px;
}

.vs-checkout-total {
    padding: 22px 0;
    font-size: 26px;
    font-weight: 800;
    color: #101828;
}

.vs-checkout-button {
    width: 100%;
    border: none;
    border-radius: 999px;
    padding: 16px 24px;
    background: #17945b;
    color: #fff;
    font-size: 22px;
    font-weight: 700;
    transition: 0.2s ease;
}

.vs-checkout-button:hover {
    background: #117a4a;
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .vs-checkout-card {
        grid-template-columns: 1fr;
    }

    .vs-checkout-image {
        min-height: 300px;
    }

    .vs-checkout-content {
        padding: 28px;
    }

    .vs-checkout-title {
        font-size: 30px;
    }
}
    </style>
@endpush

@push('validation')
<script>
$(document).ready(function () {
    $('#form').validate({
        rules: {
            cantidad: {
                required: true,
                number: true,
                min: 1,
                max: parseInt($('#stock').val()),
            }
        },
        messages: {
            cantidad: {
                required: 'El campo es requerido',
                // min: 'Debe tener al menos 3 caracteres',
                // max: 'Debe tener al menos 3 caracteres'
            },
        },

        errorElement: 'small',

        errorPlacement: function(error, element) {
            error.addClass('vs-error-message');
            error.insertAfter(element);
        },

        highlight: function(element) {
            $(element)
                .addClass('is-invalid')
                .removeClass('is-valid');
        },

        unhighlight: function(element) {
            $(element)
                .removeClass('is-invalid')
                .addClass('is-valid');
        }
    });
});
</script>
@endpush

@section('content')

@include('partials.navbar')
<main class="vs-page vs-checkout-page">

    <section class="vs-checkout-section">
        <div class="container">
            <div class="vs-checkout-card">

                <div class="vs-checkout-image">
                    @php
                        $imagenPrincipal = $voucher->imagenes->first();
                        $imagenVoucher = $imagenPrincipal && $imagenPrincipal->vf_img_path
                            ? asset('storage/' . $imagenPrincipal->vf_img_path)
                            : asset('images/default-voucher.png');
                    @endphp

                    <img src="{{ $imagenVoucher }}" alt="{{ $voucher->vou_nombre }}">
                </div>

                <div class="vs-checkout-content">
                    <form id="form" action="{{ route('checkout.voucher', $voucher->vou_id) }}" method="POST">
                        @csrf

                        <span class="vs-checkout-badge">Voucher</span>

                        <h1 class="vs-checkout-title">{{ $voucher->vou_nombre }}</h1>

                        <p class="vs-checkout-description">{{ $voucher->vou_descripcion }}</p>

                        <div class="vs-checkout-commerce">
                            <span>Comercio</span>
                            <strong>{{ $entidad->ent_nombre_fantasia }}</strong>
                        </div>

                        <div class="vs-checkout-divider"></div>

                        <div class="vs-checkout-field">
                            <label for="cantidad">Cantidad</label>
                            <input type="hidden" id="stock" value="{{ $voucher->vou_stock ?? 0 }}">
                            <input type="text" name="cantidad" id="cantidad" value="1" min="1" data-precio="{{ $voucher->vou_monto_fijo }}">
                        </div>

                        <div class="vs-checkout-row">
                            <span>Precio unitario</span>
                            <strong>${{ number_format($voucher->vou_monto_fijo, 0, ',', '.') }}</strong>
                        </div>

                        <div class="vs-checkout-total">
                            <span>Total</span>
                            <strong id="total">${{ number_format($voucher->vou_monto_fijo, 0, ',', '.') }}</strong>
                        </div>

                        <button type="submit" class="vs-checkout-button">Pagar</button>
                    </form>
                </div>

            </div>
        </div>
    </section>

</main>

@include('partials.footer')

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cantidadInput = document.getElementById('cantidad');
        const totalSpan = document.getElementById('total');

        function actualizarTotal() {
            const precio = parseFloat(cantidadInput.dataset.precio);
            const cantidad = parseInt(cantidadInput.value) || 1;
            const total = precio * cantidad;

            totalSpan.textContent = '$' + total.toLocaleString('es-AR');
        }

        cantidadInput.addEventListener('input', actualizarTotal);
    });
</script>
@endpush