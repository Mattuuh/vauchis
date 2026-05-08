{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')

@include('partials.navbar')

<section class="hero-section py-5 py-lg-6">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-12 col-lg-6 order-2 order-lg-1 text-center text-lg-start">
                <h1 class="hero-title mb-3">
                    Los mejores vouchers<br>
                    en un solo lugar
                </h1>

                <p class="hero-text mb-4">
                    Compra y regala vouchers de marcas, negocios y ONGs locales
                    de forma fácil y rápida.
                </p>

                <a href="#" class="btn btn-success btn-lg px-4" id="btn_explorar">Explora Vauchis</a>
            </div>

            <div class="col-12 col-lg-6 order-1 order-lg-2 text-center">
                <img src="{{ asset('images/hero-vauchis.png') }}"
                     alt="Hero Vauchis"
                     class="img-fluid hero-image">
            </div>
        </div>
    </div>
</section>

<section id="como-funciona" class="py-5 bg-white" style="display: none;">
    <div class="container text-center">
        <h2 class="section-title">¿Cómo funciona Vauchis?</h2>
        <p class="section-subtitle">Sigue estos simples pasos para regalar vouchers fácilmente</p>

        <div class="row g-4 mt-2">
            <div class="col-12 col-md-4">
                <div class="card info-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <img src="{{ asset('images/elige_voucher.png') }}" alt="Elige un voucher" class="info-icon mb-3">
                        <h4 class="fw-bold text-primary">Elige un voucher</h4>
                        <p class="text-muted mb-0">
                            Explora nuestra selección de vouchers y elige el regalo perfecto.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card info-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <img src="{{ asset('images/envia_regalo.png') }}" alt="Envía tu regalo" class="info-icon mb-3">
                        <h4 class="fw-bold text-primary">Envía tu regalo</h4>
                        <p class="text-muted mb-0">
                            Envía un voucher de forma fácil y rápida al destinatario que elijas.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card info-card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <img src="{{ asset('images/disfruta_regalo.png') }}" alt="Disfruta el regalo" class="info-icon mb-3">
                        <h4 class="fw-bold text-primary">Disfruta el regalo</h4>
                        <p class="text-muted mb-0">
                            El destinatario recibe el voucher y podrá usarlo y disfrutar el regalo deseado.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 category-section">
    <div class="container text-center">
        <h2 class="section-title">Categorías principales</h2>
        <p class="section-subtitle">Descubre y regala vouchers por categorías</p>

        <div class="row g-4 mt-2">
            @foreach ($categories as $category)
                <div class="col-12 col-md-4">
                    <div class="card category-card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            {{-- <img src="{{ asset('storage/' . $category->image) }}"
                                 alt="{{ $category->name }}"
                                 class="category-img mb-3"> --}}
                            <img src="{{ $category->image 
                                ? asset('images/' . $category->image) 
                                : 'https://via.placeholder.com/150' }}"
                                alt="{{ $category->name }}"
                                class="category-img mb-3">

                            <h4 class="fw-bold mb-2" style="color: {{ $category->color ?? '#1f4ed8' }}">
                                {{ $category->name }}
                            </h4>

                            <p class="text-muted mb-0">
                                {{ $category->description }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="marcas" class="py-5 bg-white">
    <div class="container text-center">
        <h2 class="section-title">Destacados</h2>
        <p class="section-subtitle">Marcas que te encantarán</p>

        @php
            $groupedBrands = $featuredBrands->chunk(3);
        @endphp

        @if ($featuredBrands->count() <= 3)
            <div class="row g-3 justify-content-center mt-2">
                @foreach ($featuredBrands as $brand)
                    <div class="col-12 col-md-4">
                        <div class="brand-box h-100 d-flex flex-column align-items-center justify-content-center bg-white shadow-sm rounded-3 p-3 text-center">
                            <img src="{{ $brand->logo 
                                ? asset('storage/' . $brand->logo) 
                                : 'https://via.placeholder.com/120x60?text=Logo' }}"
                                alt="{{ $brand->name }}"
                                class="img-fluid brand-logo">

                            <h4 class="fw-bold mt-2">
                                {{ $brand->name }}
                            </h4>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div id="featuredBrandsCarousel" class="carousel slide mt-3" data-bs-ride="false">
                <div class="carousel-inner">
                    @foreach ($groupedBrands as $index => $group)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="row g-3 justify-content-center">
                                @foreach ($group as $brand)
                                    <div class="col-12 col-md-4">
                                        <div class="brand-box h-100 d-flex flex-column align-items-center justify-content-center bg-white shadow-sm rounded-3 p-3 text-center">
                                            <img src="{{ $brand->logo 
                                                ? asset('storage/' . $brand->logo) 
                                                : 'https://via.placeholder.com/120x60?text=Logo' }}"
                                                alt="{{ $brand->name }}"
                                                class="img-fluid brand-logo">

                                            <h4 class="fw-bold mt-2">
                                                {{ $brand->name }}
                                            </h4>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev featured-brand-carousel-control" type="button" data-bs-target="#featuredBrandsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <button class="carousel-control-next featured-brand-carousel-control" type="button" data-bs-target="#featuredBrandsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        @endif
    </div>
</section>

<section class="py-5 organization-section">
    <div class="container text-center">
        <h2 class="section-title">Organizaciones</h2>
        <p class="section-subtitle">Descubre organizaciones y las marcas que ofrecen</p>

        @php
            $groupedOrganizations = $organizations->chunk(3);
        @endphp

        @if ($organizations->count() <= 3)
            <div class="row g-4 mt-2">
                @foreach ($organizations as $organization)
                    <div class="col-12 col-lg-4">
                        <div class="card organization-card border-0 shadow-sm h-100">
                            <div class="card-body p-4 text-start">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img src="{{ $organization->logo 
                                        ? asset('storage/' . $organization->logo) 
                                        : 'https://via.placeholder.com/80' }}"
                                        alt="{{ $organization->name }}"
                                        class="organization-logo">

                                    <h5 class="mb-0 fw-bold">{{ $organization->name }}</h5>
                                </div>

                                <div class="d-flex flex-wrap gap-2 mb-4">
                                    @foreach ($organization->brands->take(4) as $brand)
                                        <img src="{{ $brand->logo 
                                            ? asset('storage/' . $brand->logo) 
                                            : 'https://via.placeholder.com/120x60?text=Logo' }}"
                                            alt="{{ $brand->name }}"
                                            class="img-fluid brand-logo">
                                    @endforeach
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-outline-primary btn-sm flex-fill">Ver más</a>
                                    <a href="#" class="btn btn-primary btn-sm flex-fill">Ver vouchers</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div id="organizationsCarousel" class="carousel slide mt-3" data-bs-ride="false">
                <div class="carousel-inner">
                    @foreach ($groupedOrganizations as $index => $group)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="row g-4">
                                @foreach ($group as $organization)
                                    <div class="col-12 col-lg-4">
                                        <div class="card organization-card border-0 shadow-sm h-100">
                                            <div class="card-body p-4 text-start">
                                                <div class="d-flex align-items-center gap-3 mb-3">
                                                    <img src="{{ $organization->logo 
                                                        ? asset('storage/' . $organization->logo) 
                                                        : 'https://via.placeholder.com/80' }}"
                                                        alt="{{ $organization->name }}"
                                                        class="organization-logo">

                                                    <h5 class="mb-0 fw-bold">{{ $organization->name }}</h5>
                                                </div>

                                                <div class="d-flex flex-wrap gap-2 mb-4">
                                                    @foreach ($organization->brands->take(4) as $brand)
                                                        <img src="{{ $brand->logo 
                                                            ? asset('storage/' . $brand->logo) 
                                                            : 'https://via.placeholder.com/120x60?text=Logo' }}"
                                                            alt="{{ $brand->name }}"
                                                            class="img-fluid brand-logo">
                                                    @endforeach
                                                </div>

                                                <div class="d-flex gap-2">
                                                    <a href="#" class="btn btn-outline-primary btn-sm flex-fill">Ver más</a>
                                                    <a href="#" class="btn btn-primary btn-sm flex-fill">Ver vouchers</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev organization-carousel-control" type="button" data-bs-target="#organizationsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <button class="carousel-control-next organization-carousel-control" type="button" data-bs-target="#organizationsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        @endif
    </div>
</section>

<section class="py-5 organization-section bg-white">
    <div class="container text-center">
        <h2 class="section-title">Coleccionables</h2>
        <p class="section-subtitle">Descubre oportunidades</p>

        <div class="row g-4 mt-2">
            @foreach ($collections as $collection)
                <div class="col-12 col-lg-4">
                    <div class="card influencer-card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 text-start">
                                {{-- <img src="{{ asset('storage/' . $influencer->photo) }}"
                                     alt="{{ $influencer->name }}"
                                     class="influencer-photo"> --}}
                                <img src="{{ $collection->photo 
                                    ? asset('images/' . $collection->photo) 
                                    : 'https://i.pravatar.cc/150?img=' . $loop->index }}"
                                    class="influencer-photo">

                                <div>
                                    <h5 class="mb-1 fw-bold">{{ $collection->name }}</h5>
                                    <p class="text-muted small mb-2">
                                        {{ $collection->description }}
                                    </p>
                                    <a href="#" class="btn btn-primary btn-sm">Ver voucher</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container text-center">
        <h2 class="section-title">Influencers</h2>
        <p class="section-subtitle">Descubre recomendaciones de quienes más te inspiran</p>

        <div class="row g-4 mt-2">
            @foreach ($influencers as $influencer)
                <div class="col-12 col-lg-4">
                    <div class="card influencer-card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 text-start">
                                {{-- <img src="{{ asset('storage/' . $influencer->photo) }}"
                                     alt="{{ $influencer->name }}"
                                     class="influencer-photo"> --}}
                                <img src="{{ $influencer->photo 
                                    ? asset('storage/' . $influencer->photo) 
                                    : 'https://i.pravatar.cc/150?img=' . $loop->index }}"
                                    class="influencer-photo">

                                <div>
                                    <h5 class="mb-1 fw-bold">{{ $influencer->name }}</h5>
                                    <p class="text-muted small mb-2">
                                        {{ $influencer->description }}
                                    </p>
                                    <a href="#" class="btn btn-primary btn-sm">Ver voucher</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<footer class="footer-vauchis text-white pt-5 pb-4">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-12 col-lg-5">
                <h3 class="mb-3">Recibe nuestras novedades</h3>
                <ul class="list-unstyled mb-0">
                    <li><a href="#" class="footer-link">Cómo funciona</a></li>
                    <li><a href="#" class="footer-link">Marcas</a></li>
                    <li><a href="#" class="footer-link">Contacto</a></li>
                </ul>
            </div>

            <div class="col-12 col-lg-7">
                <form class="row g-2">
                    <div class="col-12 col-md-8">
                        <input type="email" class="form-control form-control-lg" placeholder="Tu correo electrónico">
                    </div>
                    <div class="col-12 col-md-4">
                        <button class="btn btn-danger btn-lg w-100">Suscribirme</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top border-light-subtle">
            <small>2026 © Vauchis | Todos los derechos reservados | Políticas de privacidad</small>

            <div class="d-flex gap-3 mt-3 mt-md-0">
                <a href="#" class="footer-link">Facebook</a>
                <a href="#" class="footer-link">LinkedIn</a>
                <a href="#" class="footer-link">Email</a>
            </div>
        </div>
    </div>
</footer>
@endsection

@push('scripts')
<script>
    $('#btn_explorar').on('click', function () {
        $('#como-funciona').slideDown();

        $('html, body').animate({
            scrollTop: $('#como-funciona').offset().top
        }, 600);
    });
</script>
@endpush