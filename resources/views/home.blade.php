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

        <div class="vh-shell vh-hero__inner">
            <div class="vh-hero__copy">
                <p class="vh-kicker">Elegí qué regalar</p>
                <h1>El placer de regalar,<br><span style="color: #0065FA;">simplificado</span></h1>
                <p>Comprá y enviá regalos personalizados de la manera más simple.</p>
                <a href="#negocios" class="vs-btn vs-btn-primary vh-primary-btn" id="btn_explorar">Explorá Vauchis</a>
            </div>

            <div class="vh-gift-preview" aria-hidden="true">
                <div class="vh-gift-card">

                    <div class="vh-gift-lines">
                        <div class="vh-line">
                            <span>DE</span>
                            <i></i>
                        </div>

                        <div class="vh-line">
                            <span>PARA</span>
                            <i></i>
                        </div>
                    </div>

                    <img src="{{ asset('images/regalitos-hero-vauchis.png') }}" alt="" class="vh-gifts-img">
                </div>
            </div>
        </div>

        <div class="vh-category-stack" id="objetos">
            @foreach ($categories as $category)
                <a href="#" class="vh-category-card vh-category-card--{{ $loop->index + 1 }}">
                    <strong style="font-family: Montserrat; font-size: 16px;">{{ $category->name }}</strong>
                    @php
                        $img_category = $category->image ? asset('images/'.$category->image) : '';
                    @endphp
                    <img src="{{ $img_category }}" alt="{{ $category->name }}">
                </a>
            @endforeach
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

.vh-hero{
    position: relative;
    min-height: 300px;
    background:
        radial-gradient(circle at 20% 72%, rgba(0, 101, 250, .12), transparent 24%),
        radial-gradient(circle at 72% 38%, rgba(73, 179, 132, .10), transparent 22%),
        linear-gradient(180deg, #FDFDFE 0%, #F9FCFF 100%);
}

.vh-hero__inner{
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    min-height: 260px;
    padding-top: 16px;
}

.vh-hero__copy{
    padding-left: 88px;
    transform: translateY(-6px);
}

.vh-kicker{
    margin: 0 0 6px;
    color: var(--color-primary-dark);
    font-size: 13px;
    font-weight: 400;
    letter-spacing: .23em;
    text-transform: uppercase;
}

.vh-hero h1{
    margin: 0 0 5px;
    color: var(--color-primary-dark);
    font-size: 44px;
    line-height: .90;
    font-style: italic;
    font-weight: 800;
    letter-spacing: -.035em;
}

.vh-hero__copy p:not(.vh-kicker){
    width: 430px;
    margin: 0 0 10px;
    color: rgba(7, 55, 140, .75);
    font-size: 14px;
    line-height: 1.25;
    font-weight: 300;
}

.vh-primary-btn{
    min-height: 26px;
    padding: 0 22px;
    font-size: 12px;
    box-shadow: 0 3px 8px rgba(0, 101, 250, .24);
}

.vh-gift-preview{
    display: flex;
    justify-content: center;
    padding-right: 90px;
}

.vh-gift-card{
    width:320px;
    height:180px;
    position:relative;
    border:1px solid #8ca9e8;
    border-radius:18px;
    transform:rotate(7deg);
    background:rgba(255,255,255,.35);
}

.vh-gift-card span{
    display: block;
    color: rgba(7, 55, 140, .38);
    font-size: 14px;
    letter-spacing: .2em;
}

.vh-gift-card em{
    display: block;
    width: 120px;
    height: 2px;
    margin-top: 22px;
    background: rgba(7, 55, 140, .16);
}

.vh-gift-lines{
    position:absolute;
    left:28px;
    top:48px;
    z-index:1;
}

.vh-gifts{
    display: flex;
    align-items: flex-end;
    justify-content: center;
    gap: 2px;
    margin-top: -38px;
    font-style: normal;
}

.vh-gift{
    font-style: normal;
    line-height: 1;
    filter: saturate(1.1);
}

.vh-gift--blue{ font-size: 60px; }
.vh-gift--green{ font-size: 44px; }
.vh-gift--pink{ font-size: 82px; }

.vh-category-stack{
    position: absolute;
    z-index: 5;
    left: 50%;
    bottom: -32px;
    transform: translateX(-50%);
    display: grid;
    grid-template-columns: repeat(3, 174px);
    gap: 24px;
}

.vh-category-card{
    height: 82px;
    padding: 13px 18px;
    border-radius: 14px;
    color: white;
    box-shadow: 0 8px 18px rgba(0,0,0,.16);
}

.vh-category-card:hover{
    color: white;
    transform: translateY(-2px);
}

.vh-category-card strong{
    display: block;
    font-size: 15px;
    font-weight: 800;
}

.vh-category-card small{
    display: block;
    margin-top: 3px;
    font-size: 10px;
    opacity: .75;
}

.vh-category-card--1{ background: #07378C; }
.vh-category-card--2{ background: #49B384; }
.vh-category-card--3{ background: #E51281; }

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

.vh-category-card{
    position: relative;
    overflow: visible;
}

.vh-category-card img{
    position: absolute;
    right: 14px;
    bottom: -72px;
    width: 104px;
    height: 104px;
    object-fit: contain;
    pointer-events: none;
}

.vh-category-card--2 img{
    bottom: -82px;
    width: 112px;
    height: 112px;
}

.vh-category-card--3 img{
    bottom: -98px;
    width: 120px;
    height: 120px;
}

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
   CATEGORIAS SOBRE HERO
   Ajuste visual segun referencia
========================= */

.vh-category-stack{
    bottom: -25px;
    grid-template-columns: repeat(3, 100px);
    gap: 20px;
    align-items: end;
}

.vh-category-card{
    position: relative;
    width: 100px;
    height: 100px;
    padding: 9px 10px;
    border-radius: 10px;
    overflow: hidden;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    text-align: center;
    box-shadow: 0 8px 18px rgba(0,0,0,.16);
}

.vh-category-card strong{
    position: relative;
    z-index: 2;
    max-width: 84px;
    color: #fff;
    font-size: 13px;
    line-height: 1.12;
    font-weight: 800;
}

.vh-category-card img,
.vh-category-card--2 img,
.vh-category-card--3 img{
    position: absolute;
    z-index: 1;
    left: 50%;
    right: auto;
    bottom: 5px;
    width: 88px;
    height: 78px;
    transform: translateX(-50%);
    object-fit: contain;
    opacity: .45;
    pointer-events: none;
}

.vh-category-card--2 img{
    width: 90px;
    height: 82px;
    bottom: 8px;
    transform: translateX(-50%) rotate(-8deg);
}

.vh-category-card--3 img{
    width: 96px;
    height: 88px;
    bottom: -1px;
    opacity: .35;
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






/* =========================================================
   HERO FINAL - referencia desktop
   Pegar al final para pisar reglas anteriores
========================================================= */
@media (min-width: 769px){
    .vh-hero{
        position: relative;
        z-index: 3;
        height: 399px;
        min-height: 399px;
        padding: 0;
        overflow: visible;
        background:
            radial-gradient(circle at 22% 74%, rgba(0, 101, 250, .11), transparent 25%),
            radial-gradient(circle at 73% 38%, rgba(73, 179, 132, .09), transparent 23%),
            linear-gradient(180deg, #FDFDFE 0%, #F8FCFF 100%);
    }

    .vh-hero__inner{
        width: min(100% - 128px, 1310px);
        margin-inline: auto;
        height: 300px;
        min-height: 300px;
        padding: 0;
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        gap: 36px;
    }

    .vh-hero__copy{
        width: 420px;
        padding-left: 34px;
        padding-top: 18px;
        transform: none;
    }

    .vh-kicker{
        margin: 0 0 9px;
        color: #07378C;
        font-size: 11px;
        line-height: 1;
        font-weight: 500;
        letter-spacing: .24em;
        text-transform: uppercase;
    }

    .vh-hero h1{
        width: 380px;
        margin: 0 0 10px;
        color: #07378C;
        font-size: 30px;
        line-height: .92;
        font-style: italic;
        font-weight: 800;
        letter-spacing: -.035em;
    }

    .vh-hero__copy p:not(.vh-kicker){
        width: 330px;
        margin: 0 0 15px;
        color: rgba(7, 55, 140, .72);
        font-size: 10px;
        line-height: 1.25;
        font-weight: 300;
    }

    .vh-primary-btn{
        min-height: 30px;
        padding: 0 22px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 10px rgba(0, 101, 250, .24);
    }

    .vh-gift-preview{
        display: flex;
        justify-content: flex-start;
        align-items: center;
        padding: 0 0 0 34px;
        margin: 0;
    }

    .vh-gift-card{
        position: relative;
        width: 280px;
        height: 165px;
        padding: 40px 28px;
        border: 1px solid rgba(7, 55, 140, .35);
        border-radius: 16px;
        background: rgba(253, 253, 254, .62);
        transform: rotate(7deg);
        box-shadow: 0 22px 60px rgba(7, 55, 140, .07);
        overflow: hidden;
    }

    .vh-gift-card span{
        display: inline-block;
        width: 38px;
        margin: 0;
        color: rgba(7, 55, 140, .42);
        font-size: 10px;
        line-height: 1;
        letter-spacing: .22em;
        font-style: normal;
        vertical-align: middle;
    }

    .vh-gift-card em{
        display: inline-block;
        width: 92px;
        height: 1px;
        margin: 0;
        background: rgba(7, 55, 140, .24);
        vertical-align: middle;
    }

    .vh-gift-card__to{
        display: inline-block;
        margin-top: 24px !important;
    }

    .vh-gifts-img{
        position:absolute;
        right:22px;
        bottom:18px;

        width:145px;
        height:auto;

        z-index:2;

        transform:rotate(-7deg);
    }

    .vh-line{
        display:flex;
        align-items:center;
        margin-bottom:22px;
    }

    .vh-line span{
        width:40px;
        color:#7b9ad5;
        font-size:11px;
        letter-spacing:2px;
    }

    .vh-line i{
        width:95px;
        height:1px;
        background:#8ca9e8;
        display:block;
    }

    .vh-category-stack{
        position: absolute;
        z-index: 50;
        left: 50%;
        bottom: -34px;
        transform: translateX(-50%);
        display: flex;
        align-items: flex-start;
        justify-content: center;
        gap: 20px;
        width: auto;
    }

    .vh-category-card{
        position: relative;
        flex: 0 0 auto;
        width: 100px;
        height: 100px;
        padding: 0;
        border-radius: 10px;
        overflow: hidden;
        display: block;
        text-align: center;
        box-shadow: 0 8px 18px rgba(0,0,0,.16);
    }

    .vh-category-card strong{
        position: absolute;
        z-index: 3;
        top: 9px;
        left: 50%;
        width: 86px;
        max-width: 86px;
        transform: translateX(-50%);
        display: block;
        padding: 0;
        margin: 0;
        color: #fff;
        font-size: 13px;
        line-height: 1.05;
        font-weight: 800;
        text-align: center;
        letter-spacing: -.01em;
    }

    .vh-category-card img,
    .vh-category-card--2 img,
    .vh-category-card--3 img{
        position: absolute;
        z-index: 2;
        left: 50%;
        right: auto;
        bottom: 7px;
        width: 88px;
        height: 76px;
        max-width: none;
        max-height: none;
        transform: translateX(-50%);
        object-fit: contain;
        opacity: .45;
        pointer-events: none;
    }

    .vh-category-card--2 img{
        width: 92px;
        height: 82px;
        bottom: 7px;
        transform: translateX(-50%) rotate(-8deg);
        opacity: .45;
    }

    .vh-category-card--3 img{
        width: 94px;
        height: 84px;
        bottom: 0;
        opacity: .36;
    }

    .vh-featured{
        position: relative;
        z-index: 1;
        margin-top: 0;
        padding-top: 78px;
    }
}

.vh-mobile-hero {
    display: none;
}

@media (max-width: 768px) {
    .vh-hero__inner,
    .vh-gift-preview {
        display: none !important;
    }

    .vh-hero {
        min-height: auto;
        padding: 8px 20px 34px;
        background: #fff;
        overflow: hidden;
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
        opacity: 1;
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
