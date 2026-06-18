{{-- resources/views/objetos/index.blade.php --}}
@extends('layouts.app')

@section('content')
<main class="vo-page">

    @include('partials.navbar')

    <section class="vo-hero">
        <div class="vo-shell">
            <div class="vo-hero-content">
                <h1>{{ $categoria->nombre }}</h1>

                <form method="GET" action="{{ route('vouchers.buscar') }}" class="vo-search" id="vo-search-form">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" id="vo-search-input" value="{{ request('search') }}" placeholder="Negocio, servicio, categoría..." autocomplete="off">
                </form>
            </div>
        </div>

        <button class="vh-help-btn" type="button" aria-label="Ayuda"><img src="{{ asset('images/boton-ayuda.svg') }}" alt="" class=""></button>
    </section>

    <nav class="vo-subnavbar">
        <div class="vo-shell vo-subnavbar-inner">
            @foreach ($rubros ?? [] as $rubro)
                <a href="" class="vo-subnavbar-link {{ request('category') == $rubro->rub_id ? 'active' : '' }}">
                    {{ $rubro->rub_nombre }}
                </a>
            @endforeach
        </div>
    </nav>

    <section class="vo-content">
        <div class="vo-shell vo-layout">

            <aside class="vo-filters">
                <button class="vo-filter-pill">
                    <i class="bi bi-sliders"></i>
                    Filtros
                </button>

                <a href="#" class="vo-filter-pill">
                    Entre $10.000 y $40.000
                    <span>×</span>
                </a>

                <a href="#" class="vo-filter-pill">
                    Destacados
                    <span>×</span>
                </a>
            </aside>

            @include('partials.voucher-grid', ['vouchers' => $vouchers])

        </div>
    </section>

    @include('partials.footer')

</main>
@endsection

@push('styles')
    <style>
        /* Objetos */

        .vo-page {
            background: #f8f8f8;
            min-height: 100vh;
        }

        .vo-shell {
            width: min(1180px, calc(100% - 48px));
            margin: 0 auto;
        }

        .vo-hero {
            background: #003b8f;
            min-height: 250px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .vo-hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: url("../images/hero-objetos-bg.png") right center / contain no-repeat;
            opacity: .18;
            pointer-events: none;
        }

        .vo-hero-content {
            position: relative;
            z-index: 1;
            padding-top: 88px;
            display: flex;
            align-items: center;
            gap: 34px;
        }

        .vo-hero h1 {
            margin: 0;
            font-size: 34px;
            font-weight: 800;
            color: rgba(255,255,255,.35);
        }

        .vo-search {
            width: min(580px, 100%);
            height: 42px;
            background: #fff;
            border-radius: 999px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,.08);
        }

        .vo-search i {
            color: #0b3d88;
            font-size: 14px;
        }

        .vo-search input {
            border: 0;
            outline: 0;
            width: 100%;
            font-size: 13px;
            color: #23324a;
        }

        .vo-search input::placeholder {
            color: #b1b8c3;
        }

        .vo-content {
            padding: 24px 0 56px;
        }

        .vo-layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 38px;
            align-items: start;
        }

        .vo-filters {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .vo-filter-pill {
            min-height: 30px;
            border: 1.5px solid #0b6fc6;
            border-radius: 999px;
            background: #fff;
            color: #0b6fc6;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 6px 18px;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
        }

        .vo-filter-pill span {
            margin-left: auto;
            font-size: 16px;
            line-height: 1;
        }

        .vo-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px 28px;
        }

        .vo-card {
            background: #fff;
            border-radius: 9px;
            overflow: hidden;
            box-shadow: 0 2px 7px rgba(0,0,0,.18);
        }

        .vo-card-link {
            color: inherit;
            text-decoration: none;
            display: block;
        }

        .vo-card-image {
            height: 116px;
            position: relative;
            background: #eef2f6;
            overflow: hidden;
        }

        .vo-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .vo-badge {
            position: absolute;
            top: 7px;
            left: 9px;
            border-radius: 999px;
            padding: 3px 9px;
            font-size: 10px;
            font-weight: 800;
            line-height: 1;
        }

        .vo-badge--green {
            background: #d6f3df;
            color: #098141;
        }

        .vo-badge--blue {
            background: #dce7ff;
            color: #2456a6;
        }

        .vo-badge--yellow {
            background: #fff0bc;
            color: #ad7b00;
        }

        .vo-badge--pink {
            background: #ffe5f0;
            color: #d43d7c;
        }

        .vo-card-body {
            min-height: 62px;
            padding: 12px 14px;
            display: flex;
            justify-content: space-between;
            gap: 12px;
        }

        .vo-card-body h3 {
            margin: 0 0 4px;
            font-size: 13px;
            font-weight: 800;
            color: #1b2738;
        }

        .vo-card-body p {
            margin: 0;
            font-size: 11px;
            color: #4c5665;
        }

        .vo-price {
            align-self: flex-end;
            white-space: nowrap;
            font-size: 10px;
            color: #4c5665;
            font-weight: 600;
        }

        .vo-empty {
            grid-column: 1 / -1;
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            text-align: center;
            color: #536070;
            font-weight: 600;
        }

        @media (max-width: 991px) {
            .vo-hero-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 18px;
                padding-top: 56px;
            }

            .vo-layout {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .vo-filters {
                flex-direction: row;
                overflow-x: auto;
                padding-bottom: 4px;
            }

            .vo-filter-pill {
                flex: 0 0 auto;
            }
        }

        @media (max-width: 680px) {
            .vo-shell {
                width: min(100% - 28px, 1180px);
            }

            .vo-hero {
                min-height: 300px;
            }

            .vo-hero-content {
                padding-top: 44px;
            }

            .vo-hero h1 {
                font-size: 30px;
            }

            .vo-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .vo-card-image {
                height: 130px;
            }
        }

.vo-hero {
    background: #003b8f;
    min-height: 260px;
    color: #fff;
    position: relative;
    overflow: hidden;
}

.vo-hero::after {
    content: "";
    position: absolute;
    inset: 0;
    background: url("../images/hero-objetos-bg.png") right center / contain no-repeat;
    opacity: .22;
    pointer-events: none;
}

.vo-hero-content {
    position: relative;
    z-index: 2;
    min-height: 260px;
    display: flex;
    align-items: center;
    gap: 44px;
}

.vo-hero h1 {
    margin: 0;
    font-size: 42px;
    font-weight: 800;
    color: rgba(255, 255, 255, .28);
}

.vo-search {
    width: min(620px, 100%);
    height: 56px;
    background: #fff;
    border-radius: 999px;
    display: flex;
    align-items: center;
    padding: 0 24px;
    gap: 14px;
    box-shadow: 0 8px 18px rgba(0, 0, 0, .10);
}

.vo-search i {
    color: #1f2937;
    font-size: 17px;
}

.vo-search input {
    width: 100%;
    border: 0;
    outline: 0;
    font-size: 14px;
    color: #1f2937;
    background: transparent;
}

.vo-search input::placeholder {
    color: #a7a7a7;
    font-style: italic;
}

/* Subnavbar sticky */

.vo-subnavbar {
    position: sticky;
    top: 0;
    z-index: 90;
    background: #003b8f;
    border-top: 1px solid rgba(255, 255, 255, .08);
    box-shadow: 0 6px 14px rgba(0, 0, 0, .14);
}

.vo-subnavbar-inner {
    min-height: 58px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    overflow-x: auto;
    scrollbar-width: none;
}

.vo-subnavbar-inner::-webkit-scrollbar {
    display: none;
}

.vo-subnavbar-link {
    flex: 0 0 auto;
    color: #fff;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    white-space: nowrap;
    opacity: .95;
    padding: 20px 0;
    position: relative;
}

.vo-subnavbar-link:hover,
.vo-subnavbar-link.active {
    color: #fff;
    opacity: 1;
}

.vo-subnavbar-link.active::after {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    bottom: 12px;
    height: 3px;
    border-radius: 999px;
    background: #fff;
}

@media (max-width: 768px) {
    .vo-hero {
        min-height: 230px;
    }

    .vo-hero-content {
        min-height: 230px;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        gap: 20px;
    }

    .vo-hero h1 {
        font-size: 34px;
    }

    .vo-search {
        height: 50px;
    }

    .vo-subnavbar-inner {
        justify-content: flex-start;
        gap: 28px;
    }
}


/* Bolsa de fondo */
.vo-hero::before {
    content: "";
    position: absolute;
    top: -100px;
    right: 80px;
    width: 600px;
    height: 600px;

    /* background-image: url("../images/ic-objetos.svg"); */
    background-image: url("../{{ $categoria->logo }}");
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;

    opacity: .18;
    pointer-events: none;
    z-index: 1;
}

.vo-shell,
.vo-hero-content {
    position: relative;
    z-index: 2;
}

    .vh-help-btn {
        position: fixed;
        right: 40px;
        bottom: 40px;
        width: 64px;
        height: 64px;
        border: none;
        border-radius: 50%;
        background: #07378C;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(0,0,0,.25);
    }

    .vh-help-btn img {
        width: 100%;
        height: 100%;
        display: block;
    }

    #vo-voucher-results.is-loading {
        opacity: .45;
        pointer-events: none;
    }
    </style>
@endpush


@push('scripts')
<script>
// $(function () {
//     let timer = null;

//     $('#vo-search-input').on('keyup', function () {
//         clearTimeout(timer);

//         timer = setTimeout(function () {
//             fetchVouchers();
//         }, 350);
//     });

//     $(document).on('click', '.vo-pagination a', function (e) {
//         e.preventDefault();

//         let url = $(this).attr('href');

//         fetchVouchers(url);
//     });

//     function fetchVouchers(url = null) {
//         let search = $('#vo-search-input').val();

//         let currentUrl = new URL(url || "{{ route('vouchers.buscar') }}", window.location.origin);

//         currentUrl.searchParams.set('search', search);

//         const params = new URLSearchParams(window.location.search);

//         ['category', 'min', 'max', 'destacado'].forEach(function (param) {
//             if (params.has(param) && !currentUrl.searchParams.has(param)) {
//                 currentUrl.searchParams.set(param, params.get(param));
//             }
//         });

//         $.ajax({
//             url: currentUrl.toString(),
//             type: 'GET',
//             beforeSend: function () {
//                 $('#vo-voucher-results').addClass('is-loading');
//             },
//             success: function (response) {
//                 console.log(response)
//                 $('#vo-voucher-results').html(response);

//                 window.history.pushState({}, '', currentUrl.toString());
//             },
//             complete: function () {
//                 $('#vo-voucher-results').removeClass('is-loading');
//             }
//         });
//     }
// });
</script>
@endpush