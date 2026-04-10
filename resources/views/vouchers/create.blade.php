<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Voucher</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('css/vouchers/create.css') }}">
</head>
<body>
    <div class="voucher-page">
        <div class="container-fluid px-0">
            <div class="voucher-shell">

                <nav class="navbar navbar-expand-lg bg-white py-3 shadow-sm sticky-top">
                    <div class="container">
                        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                            <img src="{{ asset('images/logo-vauchis.jpg') }}" alt="Vauchis" height="40">
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="mainNavbar">
                            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                                <li class="nav-item"><a class="nav-link fw-semibold" href="#">Inicio</a></li>
                                <li class="nav-item"><a class="nav-link fw-semibold" href="#como-funciona">Cómo funciona</a></li>
                                <li class="nav-item"><a class="nav-link fw-semibold" href="#marcas">Marcas</a></li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Admin
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('commerces.index') }}">
                                                Comercios
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{-- {{ route('vouchers.index') }} --}}">
                                                Vouchers
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="btn btn-primary px-4 rounded-pill">Ingresar</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <section class="voucher-hero">

                    <h1 class="voucher-title">Crear Voucher</h1>

                    <p class="voucher-subtitle">
                        Completa los siguientes campos para crear un nuevo voucher
                        dentro de la plataforma Vauchis.
                    </p>

                    <span class="voucher-hero-wave voucher-hero-wave--one"></span>
                    <span class="voucher-hero-wave voucher-hero-wave--two"></span>

                    <span class="voucher-dot voucher-dot--yellow"></span>
                    <span class="voucher-dot voucher-dot--green"></span>
                    <span class="voucher-dot voucher-dot--pink"></span>
                    <span class="voucher-dot voucher-dot--blue"></span>

                    <span class="voucher-dot voucher-dot--left-pink"></span>
                    <span class="voucher-dot voucher-dot--left-blue"></span>
                    <span class="voucher-dot voucher-dot--right-blue"></span>
                </section>

                <section class="voucher-form-section">
                    <div class="voucher-card">
                        <form action="{{ route('vouchers.store') }}" method="POST" class="voucher-form">
                            @csrf

                            <div class="mb-4">
                                <label class="voucher-label" for="commerce_id">Comercio</label>
                                <div class="voucher-field voucher-field--icon">
                                    <i class="bi bi-search"></i>
                                    <select id="commerce_id" name="commerce_id" class="form-select voucher-control">
                                        <option value="">Selecciona el comercio</option>
                                        @foreach(($commerces ?? []) as $commerce)
                                            <option value="{{ $commerce->id }}">{{ $commerce->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="voucher-label" for="category_id">Categoría de voucher <span>*</span></label>
                                    <div class="voucher-field voucher-field--icon">
                                        <i class="bi bi-briefcase-fill voucher-icon-blue"></i>
                                        <select id="category_id" name="category_id" class="form-select voucher-control">
                                            <option value="">Selecciona la categoría de voucher</option>
                                            @foreach(($categories ?? []) as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="voucher-label" for="influencer_id">Influencer (opcional)</label>
                                    <select id="influencer_id" name="influencer_id" class="form-select voucher-control">
                                        <option value="">Selecciona un influencer</option>
                                        @foreach(($influencers ?? []) as $influencer)
                                            <option value="{{ $influencer->id }}">{{ $influencer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="voucher-label" for="name">Nombre del voucher <span>*</span></label>
                                    <input type="text" id="name" name="name" class="form-control voucher-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="voucher-label" for="short_description">Descripción <span>*</span></label>
                                    <input type="text" id="short_description" name="short_description" class="form-control voucher-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="voucher-label" for="type">Tipo o modalidad <span>*</span></label>
                                    <div class="voucher-field voucher-field--icon">
                                        <i class="bi bi-globe-americas voucher-icon-green"></i>
                                        <select id="type" name="type" class="form-select voucher-control">
                                            <option value="">Selecciona la modalidad del voucher</option>
                                            <option value="fisico">Físico</option>
                                            <option value="digital">Digital</option>
                                            <option value="codigo">Código</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="voucher-label" for="fixed_amount_top">Monto fijo <span>*</span></label>
                                    <div class="input-group voucher-money-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" min="0" id="fixed_amount_top" name="fixed_amount_top" value="0.00" class="form-control voucher-control">
                                        <span class="input-group-text">USD</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="voucher-label" for="fixed_amount">Monto fijo <span>*</span></label>
                                    <div class="input-group voucher-money-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" min="0" id="fixed_amount" name="fixed_amount" value="0.00" class="form-control voucher-control">
                                        <span class="input-group-text">USD</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="voucher-label" for="promo_price">Precio promocional <span>*</span></label>
                                    <div class="input-group voucher-money-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" min="0" id="promo_price" name="promo_price" value="0.00" class="form-control voucher-control">
                                        <span class="input-group-text">USD</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="voucher-label" for="currency">Moneda <span>*</span></label>
                                    <div class="voucher-field voucher-field--icon">
                                        <span class="voucher-currency-icon"></span>
                                        <select id="currency" name="currency" class="form-select voucher-control">
                                            <option value="MXN">MXN</option>
                                            <option value="USD">USD</option>
                                            <option value="ARS">ARS</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 d-flex align-items-center">
                                    <div class="form-check voucher-check mt-md-4 pt-md-2">
                                        <input class="form-check-input" type="checkbox" id="allow_customization" name="allow_customization" value="1">
                                        <label class="form-check-label" for="allow_customization">
                                            Permite personalización
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="voucher-label" for="stock">Stock</label>
                                    <input type="number" min="0" id="stock" name="stock" value="0" class="form-control voucher-stock-input">
                                </div>

                                <div class="col-md-6">
                                    <label class="voucher-label" for="start_date">Fecha de inicio <span>*</span></label>
                                    <input type="text" id="start_date" name="start_date" placeholder="dd/mm/yyyy" class="form-control voucher-date-input">
                                </div>

                                <div class="col-12">
                                    <div class="voucher-featured-row">
                                        <span class="voucher-label mb-0">Destacado</span>
                                        <div class="form-check form-switch voucher-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="featured" name="featured" value="1">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <textarea id="description" name="description" rows="4" class="form-control voucher-textarea" placeholder="Descripción&#10;Incluye una descripción detallada del voucher."></textarea>
                                </div>

                                <div class="col-12">
                                    <textarea id="terms" name="terms" rows="4" class="form-control voucher-textarea" placeholder="Términos y condiciones&#10;Incluye aqui los terminos y condiciones para este voucher (opcional)."></textarea>
                                </div>
                            </div>

                            <div class="voucher-actions">
                                <a href="{{ url()->previous() }}" class="btn voucher-btn-cancel">Cancelar</a>
                                <button type="submit" class="btn voucher-btn-submit">Crear Voucher</button>
                            </div>
                        </form>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>