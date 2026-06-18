{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')

<main class="vs-page vh-page">
    @include('partials.navbar')

    <section class="vh-hero">

        <div class="vh-mobile-hero">
            <img src="{{ asset('images/regalitos-hero-vauchis.png') }}" alt="" class="vh-mobile-hero-img">

            <h1>¡Elegí qué regalar!</h1>

            <p>
                Encontrá tus negocios favoritos y regalá<br>
                vouchers personalizados
            </p>
        </div>

        <div class="vh-mobile-categories">
            @foreach ($categories as $category)
                @php
                    $img_category = $category->image ? asset('images/'.$category->image) : '';
                @endphp

                <a href="{{ isset($category->id) ? route('vouchers.categoria', $category->id) : '#' }}"
                class="vh-mobile-category-card vh-mobile-category-card--{{ $loop->index + 1 }}">
                    <strong>{{ $category->name }}</strong>

                    @if($img_category)
                        <img src="{{ $img_category }}" alt="{{ $category->name }}">
                    @endif
                </a>
            @endforeach
        </div>

        <form action="{{ route('vouchers.buscar') }}" method="GET" class="vh-mobile-search">
            <span class="vh-mobile-search__icon">⌕</span>
            <input type="text" name="search" placeholder="Negocio, servicio, categoría..." value="{{ request('search') }}">
        </form>

        <button class="vh-help-btn vh-help-btn--mobile" type="button" aria-label="Ayuda">
            <img src="{{ asset('images/boton-ayuda.svg') }}" alt="">
        </button>

        <div class="vh-shell vh-hero__inner">

            <div class="vh-hero__copy">
                <h1>
                    El placer de regalar,<br>
                    <span>simplificado</span>
                </h1>

                <p>
                    Comprá y enviá regalos personalizados<br>
                    de la manera más simple.
                </p>

                <div class="vh-hero-categories">
                    <div class="vh-category-label">
                        ¡Elegí <br>que regalar! <br>
                        <img src="{{ asset('images/decoracion-flecha.svg') }}" alt="" class="">
                    </div>

                    <div class="vh-category-stack" id="objetos">
                        @foreach ($categories as $category)
                            @php
                                $img_category = $category->image ? asset('images/'.$category->image) : '';
                            @endphp

                            <a href="{{ isset($category->id) ? route('vouchers.categoria', $category->id) : '#' }}" class="vh-category-card vh-category-card--{{ $loop->index + 1 }}">
                                <strong>{{ $category->name }}</strong>

                                @if($img_category)
                                    <img src="{{ $img_category }}" alt="{{ $category->name }}">
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="vh-gift-preview" aria-hidden="true">
                <img src="{{ asset('images/ilustracion-hero.svg') }}" alt="" class="vh-gifts-img">
            </div>

            {{-- <button class="vh-help-btn" type="button" aria-label="Ayuda"><img src="{{ asset('images/boton-ayuda.svg') }}" alt="" class=""></button> --}}

        </div>
    </section>

    <section class="vh-featured" id="negocios">
        <div class="vh-shell">
            <div class="vh-section-title vh-section-title--light">
                <span></span>
                <h2>Los negocios <strong>más elegidos</strong></h2>
            </div>

            <div class="vh-slider-wrap">
                <button class="vh-slider-btn vh-slider-btn--left" type="button" aria-label="Anterior">‹</button>
                <div class="vh-carousel-viewport" data-carousel="brands">
                    <div class="vh-card-row vh-card-row--brands">
                    @foreach ($featuredBrands as $brand)
                        @php
                            $brandImage = $brand->image ?? $brand->logo ?? null;
                            $imgSrc = $brandImage ? asset('storage/' . $brandImage) : $brandFallbackImages[$loop->index % count($brandFallbackImages)];
                        @endphp
                        <article class="vh-business-card entidades" data-url="{{ isset($brand->id) ? route('vouchers.entidad', $brand->id) : '#' }}">
                            <img src="{{ $imgSrc }}" alt="{{ $brand->name }}">
                            <span class="vs-badge vh-card-badge">★ Recomendado</span>
                            <div class="vh-business-card__caption">
                                <div>
                                    <h3>{{ $brand->name }}</h3>
                                    <p>{{ $brand->description ?? 'Una experiencia para regalar y disfrutar' }}</p>
                                </div>
                                <small>desde ${{ $brand->min_amount ?? $brand->min_price ?? '10.000' }}</small>
                            </div>
                        </article>
                    @endforeach
                    </div>
                </div>
                <button class="vh-slider-btn vh-slider-btn--right" type="button" aria-label="Siguiente">›</button>
            </div>
        </div>
    </section>

    <section class="vh-organizations">
        <div class="vh-shell">
            <div class="vh-section-title">
                <span></span>
                <h2>Encontrá todo <strong>en un solo lugar</strong></h2>
            </div>

            <div class="vh-logo-carousel-wrap">
                <div class="vh-carousel-viewport" data-carousel="organizations">
                    <div class="vh-logo-carousel">
                @foreach ($organizations as $organization)
                    <a href="#" class="vh-logo-bubble">
                        @if (!empty($organization->logo))
                            <img src="{{ asset('storage/' . $organization->logo) }}" alt="{{ $organization->name }}">
                        @else
                            <strong>{{ $organization->name }}</strong>
                        @endif
                    </a>
                @endforeach
                    </div>
                </div>
                <button class="vh-round-next" type="button" aria-label="Siguiente">→</button>
            </div>
        </div>
    </section>

    <section class="vh-inspiration" id="experiencias">
        <div class="vh-shell">
            <div class="vh-section-title">
                <span></span>
                <h2>Inspirate <strong>en recomendaciones</strong></h2>
            </div>

            <div class="vh-influencer-carousel-wrap">
                <div class="vh-carousel-viewport" data-carousel="influencers">
                    <div class="vh-card-row vh-card-row--influencers">
                @foreach ($influencers as $influencer)
                    @php
                        $imgSrc = !empty($influencer->photo) ? asset('storage/' . $influencer->photo) : $influencerFallbackImages[$loop->index % count($influencerFallbackImages)];
                    @endphp
                    <article class="vh-influencer-card">
                        <img class="vh-influencer-card__cover" src="{{ $imgSrc }}" alt="{{ $influencer->name }}">
                        <div class="vh-influencer-card__body">
                            <img src="{{ $imgSrc }}" alt="" class="vh-avatar">
                            <div>
                                <h3>{{ $influencer->name }}</h3>
                                <p>{{ $influencer->user_name ?? '@' . \Illuminate\Support\Str::slug($influencer->name ?? 'influencer') }}</p>
                                <small>{{ $influencer->description }}</small>
                            </div>
                        </div>
                    </article>
                @endforeach
                    </div>
                </div>
                <button class="vh-round-next vh-round-next--inspiration" type="button" aria-label="Siguiente">→</button>
            </div>
        </div>
    </section>

    <section class="vh-explore" id="causa">
        <div class="vh-shell">
            <div class="vh-section-heading">
                <span class="vh-section-heading__line"></span>
                <h2>Sigue explorando</h2>
            </div>

            <div class="vh-slider-wrap">
                <button class="vh-slider-btn vh-slider-btn--left" type="button" aria-label="Anterior">‹</button>

                <div class="vh-carousel-viewport" data-carousel="explore">
                    <div class="vh-explore-grid">
                    @foreach ($featuredBrands as $brand)
                        @php
                            $brandImage = $brand->image ?? $brand->logo ?? null;
                            $imgSrc = $brandImage
                                ? asset('storage/' . $brandImage)
                                : $brandFallbackImages[$loop->index % count($brandFallbackImages)];

                            $badge = $loop->first ? 'Destacado' : ($loop->iteration === 2 ? 'Con causa' : '');
                        @endphp

                        <article
                            class="vh-business-card entidades"
                            data-url="{{ isset($brand->id) ? route('vouchers.entidad', $brand->id) : '#' }}"
                        >
                            <div class="vh-business-card__image">
                                <img src="{{ $imgSrc }}" alt="{{ $brand->name }}">

                                @if($badge)
                                    <span class="vh-card-badge {{ $loop->first ? 'vh-card-badge--pink' : 'vh-card-badge--green' }}">
                                        {{ $badge }}
                                    </span>
                                @endif
                            </div>

                            <div class="vh-business-card__caption">
                                <div>
                                    <h3>{{ $brand->name }}</h3>
                                    <p>{{ $brand->description ?? 'Una experiencia para regalar y disfrutar' }}</p>
                                </div>

                                <small>
                                    desde ${{ $brand->min_amount ?? $brand->min_price ?? '10.000' }}
                                </small>
                            </div>
                        </article>
                    @endforeach
                    </div>
                </div>

                <button class="vh-slider-btn vh-slider-btn--right" type="button" aria-label="Siguiente">›</button>
            </div>
        </div>
    </section>

    <section class="vh-collections">
        <div class="vh-shell">
            <div class="vh-section-heading">
                <span class="vh-section-heading__line"></span>
                <h2>Colecciones</h2>
            </div>

            <div class="vh-collections-grid">
                @foreach ($collections as $collection)
                    @php
                        $imgSrc = !empty($collection->photo) ? asset('images/' . $collection->photo) : '';
                    @endphp

                    <a href="#" class="vh-collection-card">
                        <img src="{{ $imgSrc }}" alt="{{ $collection->name }}">

                        <span class="vh-collection-card__overlay"></span>

                        <strong>
                            {{ $collection->name }}
                        </strong>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="vh-final-banner">
        <div class="vh-shell vh-final-banner__inner">

            <div class="vh-final-banner__image">
                <img src="{{ asset('images/liustracion-banner.svg') }}" alt="Vauchis">
            </div>

            <div class="vh-final-banner__copy">
                <h2>
                    Una forma<br>
                    distinta <em>(y fácil)</em><br>
                    de regalar
                </h2>

                <a href="#negocios" class="vh-final-banner__btn">
                    Explorá Vauchis
                </a>
            </div>

        </div>
    </section>

    @include('partials.footer')
</main>
@endsection

@push('styles')
<style>
    /* =========================================================
   VAUCHIS HOME - CSS UNIFICADO
   Basado en el CSS compartido y ajustes para igualar el PDF
   ========================================================= */

/* =========================
   BASE
========================= */

.vh-page{
    overflow: hidden;
    background: var(--color-white);
    color: var(--color-primary-dark);
    font-family: var(--font-main);
}

.vh-shell{
    width: min(100% - 128px, 1310px);
    margin-inline: auto;
}

a{
    text-decoration: none;
}

/* =========================
   HERO
========================= */

.vh-hero {
    position: relative;
    min-height: 590px;
    background: #f4f5f7;
    overflow: hidden;
}

.vh-mobile-hero {
    display: none;
}

.vh-hero__inner {
    position: relative;
    min-height: 590px;
}

.vh-hero__copy {
    position: absolute;
    top: 155px;
    left: 105px;
    width: 420px;
    z-index: 3;
}

.vh-hero__copy h1 {
    margin: 0 0 14px;
    color: #07378C;
    font-family: Montserrat, sans-serif;
    font-size: 34px;
    line-height: 1.08;
    font-weight: 800;
    font-style: italic;
    letter-spacing: -0.03em;
}

.vh-hero__copy h1 span {
    color: #0065FA;
}

.vh-hero__copy > p {
    margin: 0;
    color: #666;
    font-family: Montserrat, sans-serif;
    font-size: 16px;
    line-height: 1.15;
    font-weight: 400;
}

.vh-gift-preview {
    position: absolute;
    top: 58px;
    right: 130px;
    width: 405px;
    z-index: 2;
}

.vh-gifts-img {
    width: 100%;
    height: auto;
    display: block;
}

.vh-hero-categories {
    position: absolute;
    top: 265px;
    left: 55px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
}

.vh-category-label {
    width: 130px;
    margin-bottom: 132px;
    color: #2a62c7;
    font-family: Montserrat, sans-serif;
    font-size: 24px;
    line-height: 1.08;
    font-weight: 400;
}

.vh-category-label img {
    display: block;
    width: 72px;
    margin-top: 14px;
    margin-left: 2px;
}

.vh-category-stack {
    display: flex;
    gap: 14px;
}

.vh-category-card {
    position: relative;
    width: 134px;
    height: 134px;
    padding: 0;
    display: block;
    overflow: hidden;
    border-radius: 13px;
    text-decoration: none;
    box-shadow: 0 5px 12px rgba(0,0,0,.18);
}

.vh-category-card:hover {
    color: #fff;
    transform: translateY(-2px);
}

.vh-category-card strong {
    position: absolute;
    top: 13px;
    left: 0;
    width: 100%;
    z-index: 2;
    text-align: center;
    color: #fff;
    font-family: Montserrat, sans-serif;
    font-size: 15px;
    line-height: 1.05;
    font-weight: 700;
}

.vh-category-card img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: cover;
}

.vh-category-card--1 { background: #07378C; }
.vh-category-card--2 { background: #49B384; }
.vh-category-card--3 { background: #E51281; }


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

    .vh-mobile-categories {
        display: none;
    }

    .vh-mobile-search {
        display: none;
    }

@media (max-width: 768px) {
    .vh-hero {
        min-height: auto;
        padding: 8px 20px 34px;
        background: #fff;
        overflow: hidden;
    }

    .vh-hero__inner {
        display: none;
    }

    .vh-mobile-hero {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .vh-mobile-hero-img {
        width: 260px;
        max-width: 90%;
        margin-bottom: 18px;
    }

    .vh-mobile-hero h1 {
        margin: 0 0 16px;
        color: #07378C;
        font-size: 40px;
        line-height: 1;
        font-weight: 800;
        font-style: normal;
        letter-spacing: -1px;
    }

    .vh-mobile-hero p {
        margin: 0;
        color: #07378C;
        font-size: 17px;
        line-height: 1.45;
        font-weight: 400;
    }

    .vh-mobile-categories {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        overflow-y: hidden;
        padding: 30px 0 68px;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
    }

    .vh-mobile-categories::-webkit-scrollbar {
        display: none;
    }

    .vh-mobile-category-card {
        position: relative;
        flex: 0 0 218px;
        width: 218px;
        height: 202px;
        border-radius: 10px;
        overflow: hidden;
        scroll-snap-align: center;
        box-shadow: 0 3px 6px rgba(0,0,0,.28);
    }

    .vh-mobile-category-card strong {
        position: absolute;
        top: 35px;
        left: 0;
        width: 100%;
        padding: 0 18px;
        z-index: 2;
        color: #fff;
        font-family: Montserrat, sans-serif;
        font-size: 22px;
        line-height: 1.15;
        font-weight: 800;
        text-align: center;
    }

    .vh-mobile-category-card img {
        position: absolute;
        left: 50%;
        bottom: 18px;
        width: 150px;
        height: 120px;
        object-fit: contain;
        transform: translateX(-50%);
        opacity: .42;
        mix-blend-mode: screen;
    }

    .vh-mobile-category-card--1 { background: #07378C; }
    .vh-mobile-category-card--2 { background: #49B384; }
    .vh-mobile-category-card--3 { background: #F20888; }

    .vh-mobile-search {
        width: calc(100% - 80px);
        height: 60px;
        margin: 0 auto;
        border: 1.5px solid #07378C;
        border-radius: 999px;
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 0 30px;
        background: #fff;
    }

    .vh-mobile-search__icon {
        color: #111;
        font-size: 38px;
        line-height: 1;
        transform: rotate(-20deg);
    }

    .vh-mobile-search input {
        width: 100%;
        border: 0;
        outline: none;
        background: transparent;
        color: #333;
        font-family: Montserrat, sans-serif;
        font-size: 18px;
        font-style: italic;
    }

    .vh-mobile-search input::placeholder {
        color: #9b9b9b;
    }

    .vh-help-btn {
        display: none;
    }

    .vh-help-btn--mobile {
        display: flex;
        position: fixed;
        right: 30px;
        bottom: 22px;
        width: 96px;
        height: 96px;
        padding: 0;
        border: 0;
        border-radius: 50%;
        background: #07378C;
        z-index: 9999;
        box-shadow: 0 4px 10px rgba(0,0,0,.25);
    }

    .vh-help-btn--mobile img {
        width: 100%;
        height: 100%;
        display: block;
    }
}

@media (min-width: 769px) {
    .vh-hero {
        min-height: 590px;
    }

    .vh-hero__copy {
        top: 95px;
        left: 108px;
        width: 430px;
    }

    .vh-hero__copy h1 {
        font-size: 34px;
        line-height: 1.05;
    }

    .vh-hero__copy > p {
        font-size: 16px;
        line-height: 1.15;
    }

    .vh-gift-preview {
        top: -15px;
        right: 125px;
        width: 410px;
    }

    .vh-hero-categories {
        position: absolute;
        top: 295px;
        left: 85px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }

    .vh-category-label {
        width: 130px;
        margin-top: -65px;
        margin-bottom: 0;
        font-size: 24px;
        line-height: 1.08;
    }

    .vh-category-label img {
        width: 130px;
        margin-top: -5px;
        margin-left: 2px;
    }

    .vh-category-stack {
        gap: 13px;
    }

    .vh-category-card {
        width: 134px;
        height: 134px;
        border-radius: 13px;
    }


    .vh-category-card strong {
        position: absolute;
        top: 12px;
        left: 0;
        width: 100%;
        padding: 0 10px;
        z-index: 3;
        text-align: center;
        font-size: 14px;
        line-height: 1.15;
        font-weight: 700;
    }

    .vh-category-card img {
        position: absolute;
        left: 50%;
        bottom: 8px;
        transform: translateX(-50%);
        width: 108px;
        height: 98px;
        object-fit: contain;
        opacity: .22;
        mix-blend-mode: screen;
        z-index: 1;
    }
}

/* =========================
   TITULOS DE SECCION
========================= */

.vh-section-title,
.vh-section-heading{
    display: flex;
    align-items: center;
    gap: 12px;
}

.vh-section-title span,
.vh-section-heading__line{
    display: inline-block;
    width: 25px;
    height: 3px;
    background: #07378C;
}

.vh-section-title h2,
.vh-section-heading h2{
    margin: 0;
    color: #07378C;
    font-size: 15px;
    line-height: 1;
    font-weight: 400;
    text-transform: uppercase;
    letter-spacing: .05em;
}

.vh-section-title h2 strong,
.vh-section-heading h2 strong{
    font-weight: 800;
}

.vh-section-title--light span{
    background: #FDFDFE;
}

.vh-section-title--light h2,
.vh-section-title--light h2 strong{
    color: #FDFDFE;
}

/* =========================
   COMPONENTES COMPARTIDOS
========================= */

.vh-slider-wrap{
    position: relative;
}

.vh-card-row{
    display: grid;
    gap: 36px;
}

.vh-card-row--brands{
    grid-template-columns: repeat(3, 1fr);
}

.vh-slider-btn{
    position: absolute;
    z-index: 5;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    cursor: pointer;
}

.vh-round-next{
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 1px solid #07378C;
    background: transparent;
    color: #07378C;
    font-size: 28px;
    line-height: 1;
}

/* =========================
   NEGOCIOS MAS ELEGIDOS
========================= */

.vh-featured{
    position: relative;
    z-index: 1;
    background: linear-gradient(180deg, #3C66AD 0%, #07378C 100%);
    padding: 78px 0 96px;
    overflow: visible;
}

.vh-featured::before{
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,.04);
    pointer-events: none;
}

.vh-featured .vh-shell{
    position: relative;
    max-width: 750px;
    margin: 0 auto;
}

.vh-featured .vh-section-title{
    margin-bottom: 58px;
}

.vh-featured .vh-card-row--brands{
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.vh-featured .vh-business-card{
    position: relative;
    width: 255px;
    height: 178px;
    border-radius: 8px;
    overflow: hidden;
    background: #FDFDFE;
    box-shadow: 0 4px 16px rgba(0,0,0,.12);
    cursor: pointer;
}

.vh-featured .vh-business-card > img{
    width: 100%;
    height: 121px;
    object-fit: cover;
    display: block;
}

.vh-featured .vh-card-badge{
    position: absolute;
    top: 20px;
    left: 10px;
    z-index: 2;
    height: 18px;
    min-width: 78px;
    padding: 0 9px;
    border-radius: 4px;
    background: #FDFDFE;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #9B5A00;
    font-size: 8px;
    line-height: 1;
    font-weight: 700;
}

.vh-featured .vh-business-card__caption{
    height: 57px;
    padding: 8px 10px 9px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 8px;
    background: #FDFDFE;
}

.vh-featured .vh-business-card__caption h3{
    margin: 0 0 7px;
    color: #111111;
    font-size: 11px;
    line-height: 1;
    font-weight: 700;
}

.vh-featured .vh-business-card__caption p{
    margin: 0;
    max-width: 145px;
    color: #111111;
    font-size: 9px;
    line-height: 1.2;
    font-weight: 300;
}

.vh-featured .vh-business-card__caption small{
    align-self: flex-end;
    white-space: nowrap;
    color: #111111;
    font-size: 8px;
    line-height: 1;
    font-weight: 300;
}

.vh-featured .vh-slider-btn{
    top: 63px;
    width: 27px;
    height: 27px;
    border: 2px solid #FDFDFE;
    background: transparent;
    color: #FDFDFE;
    font-size: 32px;
    line-height: 20px;
    font-weight: 200;
}

.vh-featured .vh-slider-btn--left{ left: -38px; }
.vh-featured .vh-slider-btn--right{ right: -38px; }

/* =========================
   ORGANIZACIONES
========================= */

.vh-organizations{
    background: linear-gradient(120deg, #fffaf0 0%, #f7fdff 45%, #eaf3ff 100%);
    padding: 58px 0 70px;
    overflow: hidden;
}

.vh-organizations .vh-shell{
    max-width: 1066px;
    margin: 0 auto;
}

.vh-organizations .vh-section-title{
    margin-bottom: 44px;
}

.vh-logo-carousel{
    position: relative;
    display: flex;
    align-items: center;
    gap: 48px;
    width: max-content;
}

.vh-logo-bubble{
    width: 220px;
    height: 220px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
    flex: 0 0 226px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    color: #07378C;
}

.vh-logo-bubble img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.vh-logo-bubble strong{
    color: #07378C;
    font-size: 22px;
    text-align: center;
}

.vh-logo-carousel .vh-round-next{
    right: -70px;
    bottom: -28px;
}

/* =========================
   INSPIRATE EN RECOMENDACIONES
========================= */

.vh-inspiration{
    background: linear-gradient(120deg, #fffaf0 0%, #f4fbff 55%, #eaf3ff 100%);
    padding: 28px 0 88px;
    overflow: hidden;
}

.vh-inspiration .vh-shell{
    max-width: 1066px;
    margin: 0 auto;
}

.vh-inspiration .vh-section-title{
    gap: 14px;
    margin-bottom: 34px;
}

.vh-inspiration .vh-section-title span{
    width: 32px;
    height: 2px;
}

.vh-inspiration .vh-section-title h2{
    font-size: 15px;
    letter-spacing: .08em;
}

.vh-card-row--influencers{
    position: relative;
    display: flex;
    gap: 22px;
    width: max-content;
}

.vh-influencer-card{
    width: 206px;
    height: 362px;
    border-radius: 8px;
    overflow: hidden;
    background: #FDFDFE;
    box-shadow: 0 10px 24px rgba(0,0,0,.18);
}

.vh-influencer-card__cover{
    width: 100%;
    height: 278px;
    object-fit: cover;
    display: block;
}

.vh-influencer-card__body{
    height: 84px;
    padding: 18px 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    background: #FDFDFE;
}

.vh-avatar{
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 2px solid #0065FA;
    object-fit: cover;
    flex-shrink: 0;
}

.vh-influencer-card__body h3{
    margin: 0;
    color: #111111;
    font-size: 11px;
    line-height: 1;
    font-weight: 700;
}

.vh-influencer-card__body p{
    margin: 2px 0;
    color: #0065FA;
    font-size: 10px;
    line-height: 1;
    font-weight: 500;
}

.vh-influencer-card__body small{
    color: #111111;
    font-size: 9px;
    line-height: 1;
    font-weight: 300;
}

.vh-round-next--inspiration{
    right: 48px;
    bottom: -64px;
}

/* =========================
   SIGUE EXPLORANDO
========================= */

.vh-explore{
    background: #EAF3FF;
    padding: 66px 0 76px;
    overflow: hidden;
}

.vh-explore .vh-shell{
    max-width: 1066px;
    margin: 0 auto;
}

.vh-explore .vh-section-heading{
    margin-bottom: 132px;
}

.vh-explore-grid{
    display: grid;
    grid-template-columns: repeat(3, 344px);
    gap: 32px;
}

.vh-explore .vh-business-card{
    position: relative;
    height: 240px;
    border-radius: 13px;
    overflow: hidden;
    background: #FDFDFE;
    box-shadow: 0 4px 16px rgba(0,0,0,.08);
    cursor: pointer;
}

.vh-business-card__image{
    position: relative;
    height: 168px;
    overflow: hidden;
}

.vh-business-card__image img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.vh-explore .vh-card-badge{
    position: absolute;
    top: 25px;
    left: 14px;
    z-index: 2;
    min-width: 86px;
    height: 19px;
    padding: 0 14px;
    border-radius: 4px;
    background: #FDFDFE;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    line-height: 1;
    font-weight: 700;
}

.vh-card-badge--pink{
    color: #E51281;
}

.vh-card-badge--green{
    color: #168451;
}

.vh-card-badge--green::before{
    content: '♥';
    margin-right: 7px;
    color: #49B384;
    font-size: 10px;
}

.vh-explore .vh-business-card__caption{
    height: 72px;
    padding: 11px 14px 13px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
}

.vh-explore .vh-business-card__caption h3{
    margin: 0 0 8px;
    color: #111111;
    font-size: 14px;
    line-height: 1;
    font-weight: 700;
}

.vh-explore .vh-business-card__caption p{
    margin: 0;
    max-width: 190px;
    color: #111111;
    font-size: 12px;
    line-height: 1.25;
    font-weight: 300;
}

.vh-explore .vh-business-card__caption small{
    align-self: flex-end;
    white-space: nowrap;
    color: #111111;
    font-size: 12px;
    line-height: 1;
    font-weight: 300;
}

.vh-explore .vh-slider-btn{
    top: 122px;
    width: 38px;
    height: 38px;
    border: 2px solid rgba(255,255,255,.95);
    background: rgba(255,255,255,.25);
    color: #FDFDFE;
    font-size: 42px;
    line-height: 1;
    font-weight: 200;
}

.vh-explore .vh-slider-btn--left{ left: -22px; }
.vh-explore .vh-slider-btn--right{ right: -22px; }

/* =========================
   COLECCIONES
========================= */

.vh-collections{
    background: #FDFDFE;
    padding: 82px 0 106px;
}

.vh-collections .vh-shell{
    max-width: 1066px;
    margin: 0 auto;
}

.vh-collections .vh-section-heading{
    margin-bottom: 48px;
}

.vh-collections .vh-section-heading h2{
    font-size: 18px;
    font-weight: 700;
    letter-spacing: .03em;
}

.vh-collections-grid{
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 32px;
}

.vh-collection-card{
    position: relative;
    display: block;
    height: 340px;
    border-radius: 12px;
    overflow: hidden;
    text-decoration: none;
    box-shadow: none;
    color: #FDFDFE;
}

.vh-collection-card:hover{
    color: #FDFDFE;
}

.vh-collection-card img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.vh-collection-card__overlay{
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.22);
    z-index: 1;
}

.vh-collection-card strong{
    position: absolute;
    inset: 0;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    color: #FDFDFE;
    font-size: 22px;
    line-height: 1.1;
    font-weight: 700;
    text-align: center;
}


/* =========================
   AJUSTES DE CARRUSELES E IMAGENES
========================= */

.vh-carousel-viewport{
    overflow: hidden;
    width: 100%;
}

.vh-featured .vh-card-row--brands{
    display: flex;
    gap: 24px;
    transition: transform .35s ease;
    will-change: transform;
}

.vh-featured .vh-business-card{
    flex: 0 0 255px;
}

.vh-logo-carousel-wrap,
.vh-influencer-carousel-wrap{
    position: relative;
}

.vh-logo-carousel{
    transition: transform .35s ease;
    will-change: transform;
}

.vh-card-row--influencers{
    transition: transform .35s ease;
    will-change: transform;
}

.vh-influencer-card{
    flex: 0 0 206px;
}

.vh-explore-grid{
    display: flex;
    gap: 32px;
    transition: transform .35s ease;
    will-change: transform;
}

.vh-explore .vh-business-card{
    flex: 0 0 344px;
}

.vh-featured .vh-card-row--brands,
.vh-logo-carousel,
.vh-card-row--influencers,
.vh-explore-grid{
    transform: translateX(0);
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 1100px){
    .vh-shell{
        width: min(100% - 32px, 960px);
    }

    .vh-hero__copy{
        padding-left: 0;
    }

    .vh-gift-preview{
        padding-right: 0;
    }

    .vh-card-row--brands,
    .vh-card-row--collections,
    .vh-collections-grid{
        grid-template-columns: repeat(2, 1fr);
    }

    .vh-card-row--influencers,
    .vh-logo-carousel{
        grid-template-columns: repeat(2, 1fr);
    }

    .vh-logo-carousel{
        display: grid;
        width: auto;
    }

    .vh-featured .vh-slider-btn--left,
    .vh-explore .vh-slider-btn--left{
        left: 8px;
    }

    .vh-featured .vh-slider-btn--right,
    .vh-explore .vh-slider-btn--right{
        right: 8px;
    }
}

@media (max-width: 991px){
    .vh-explore{
        padding: 48px 0 60px;
    }

    .vh-explore .vh-shell,
    .vh-collections .vh-shell{
        padding: 0 24px;
    }

    .vh-explore .vh-section-heading{
        margin-bottom: 48px;
    }

    .vh-explore-grid,
    .vh-collections-grid{
        grid-template-columns: 1fr;
        gap: 24px;
    }

    .vh-explore .vh-business-card{
        height: 240px;
    }

    .vh-collections{
        padding: 56px 0 72px;
    }

    .vh-collection-card{
        height: 280px;
    }

    .vh-explore .vh-slider-btn{
        display: none;
    }
}

@media (max-width: 768px) {

    .vh-category-stack {
        position: relative;
        z-index: 5;
        display: flex;
        flex-direction: row;
        gap: 10px;
        width: 100%;
        margin-top: 36px;
        padding: 0 0 16px 20px;
        overflow-x: auto;
        overflow-y: visible;
        scroll-snap-type: x mandatory;
    }

    .vh-category-stack::-webkit-scrollbar {
        display: none;
    }

    .vh-category-card {
        flex: 0 0 185px;
        width: 185px;
        height: 165px;
        border-radius: 10px;
        scroll-snap-align: start;
        overflow: hidden;
    }

    .vh-category-card strong {
        position: relative;
        z-index: 2;
        display: block;
        padding-top: 26px;
        font-size: 22px;
        line-height: 1.05;
        text-align: center;
        color: #fff;
    }

    .vh-category-card img {
        position: absolute;
        left: 50%;
        bottom: 12px;
        transform: translateX(-50%);
        max-width: 110px;
        max-height: 95px;
        object-fit: contain;
    }

    .vh-hero {
        padding-bottom: 34px;
        overflow: hidden;
    }
}


@media (max-width: 768px) {

    .vh-collections {
        padding: 42px 0;
        background: #fff;
        overflow: hidden;
    }

    .vh-collections .vh-shell {
        padding-left: 34px;
        padding-right: 0;
    }

    .vh-section-heading {
        margin-bottom: 58px;
    }

    .vh-section-heading h2 {
        font-size: 22px;
        letter-spacing: .08em;
        color: #003d9c;
    }

    .vh-section-heading__line {
        width: 40px;
        height: 4px;
        background: #003d9c;
    }

    .vh-collections-grid {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        overflow-y: hidden;
        scroll-snap-type: x mandatory;
        padding-bottom: 8px;
        padding-right: 34px;
    }

    .vh-collections-grid::-webkit-scrollbar {
        display: none;
    }

    .vh-collection-card {
        flex: 0 0 340px;
        height: 340px;
        border-radius: 14px;
        overflow: hidden;
        scroll-snap-align: start;
    }

    .vh-collection-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .vh-collection-card strong {
        font-size: 24px;
        line-height: 1.05;
        max-width: 180px;
        text-align: center;
    }
}



@media (max-width: 768px) {

    .vh-organizations {
        padding: 42px 0 64px;
        background: #f7fbff;
    }

    .vh-organizations .vh-section-title {
        margin-bottom: 34px;
    }

    .vh-logo-carousel {
        display: flex;
        gap: 22px;
        width: max-content;
        padding: 0 32px 10px 22px;
    }

    .vh-carousel-viewport {
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .vh-carousel-viewport::-webkit-scrollbar {
        display: none;
    }

    .vh-logo-bubble {
        flex: 0 0 175px;
        width: 175px;
        height: 175px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        box-shadow: 0 8px 18px rgba(15, 23, 42, .12);
    }

    .vh-logo-bubble img {
        max-width: 120px;
        max-height: 120px;
        object-fit: contain;
    }

    .vh-round-next {
        display: none;
    }
}

/* =========================
   BANNER FINAL
========================= */

.vh-final-banner {
    position: relative;
    background: #3f6fb3;
    padding: 76px 0 62px;
    overflow: hidden;
}

.vh-final-banner::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image: url("../images/patron-regalos.png");
    background-repeat: no-repeat;
    background-position: right center;
    background-size: contain;
    opacity: .16;
    pointer-events: none;
}

.vh-final-banner__inner {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
}

.vh-final-banner__image img {
    width: 430px;
    max-width: 100%;
    display: block;
}

.vh-final-banner__copy {
    color: #fff;
}

.vh-final-banner__copy h2 {
    margin: 0 0 26px;
    color: #fff;
    font-family: Montserrat, sans-serif;
    font-size: 44px;
    line-height: 1.18;
    font-weight: 800;
}

.vh-final-banner__copy h2 em {
    font-weight: 300;
    font-style: italic;
}

.vh-final-banner__btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 188px;
    height: 42px;
    padding: 0 28px;
    border-radius: 999px;
    background: #0065fa;
    color: #fff;
    font-family: Montserrat, sans-serif;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
}

.vh-final-banner__btn:hover {
    color: #fff;
    background: #0057d8;
}

/* Mobile */
@media (max-width: 768px) {
    .vh-final-banner {
        padding: 48px 0;
        text-align: center;
    }

    .vh-final-banner__inner {
        grid-template-columns: 1fr;
        gap: 28px;
    }

    .vh-final-banner__image img {
        width: 310px;
        margin: 0 auto;
    }

    .vh-final-banner__copy h2 {
        font-size: 32px;
    }
}

</style>

@endpush

@push('scripts')
<script>
    $(function () {
        $('#btn_explorar').on('click', function (event) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: $('#negocios').offset().top
            }, 600);
        });

        $('.entidades').on('click', function () {
            const url = $(this).data('url');
            if (url && url !== '#') {
                window.location = url;
            }
        });

        function setupCarousel($wrap, trackSelector, prevSelector, nextSelector, visibleItems) {
            const $track = $wrap.find(trackSelector).first();
            const $items = $track.children();
            let index = 0;

            if (!$track.length || $items.length <= visibleItems) {
                $wrap.find(prevSelector + ', ' + nextSelector).hide();
                return;
            }

            function itemStep() {
                const el = $items.get(0);
                if (!el) return 0;
                const gap = parseFloat(getComputedStyle($track.get(0)).columnGap || getComputedStyle($track.get(0)).gap || 0);
                return el.getBoundingClientRect().width + gap;
            }

            function update() {
                const max = Math.max(0, $items.length - visibleItems);
                index = Math.max(0, Math.min(index, max));
                $track.css('transform', 'translateX(' + (-index * itemStep()) + 'px)');
                $wrap.find(prevSelector).prop('disabled', index === 0);
                $wrap.find(nextSelector).prop('disabled', index === max);
            }

            $wrap.find(nextSelector).on('click', function () {
                index++;
                update();
            });

            $wrap.find(prevSelector).on('click', function () {
                index--;
                update();
            });

            $(window).on('resize', update);
            update();
        }

        setupCarousel($('.vh-featured .vh-slider-wrap'), '.vh-card-row--brands', '.vh-slider-btn--left', '.vh-slider-btn--right', 3);
        setupCarousel($('.vh-organizations .vh-logo-carousel-wrap'), '.vh-logo-carousel', '.vh-round-next', '.vh-round-next', 3);
        setupCarousel($('.vh-inspiration .vh-influencer-carousel-wrap'), '.vh-card-row--influencers', '.vh-round-next--inspiration', '.vh-round-next--inspiration', 4);
        setupCarousel($('.vh-explore .vh-slider-wrap'), '.vh-explore-grid', '.vh-slider-btn--left', '.vh-slider-btn--right', 3);
    });
</script>
@endpush
