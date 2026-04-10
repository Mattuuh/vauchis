<nav class="navbar navbar-expand-lg bg-white py-3 shadow-sm sticky-top commerce-navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('images/logo-vauchis.jpg') }}" alt="Vauchis" height="40">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ route('home') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="#como-funciona">Cómo funciona</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ route('commerces.index') }}">Marcas</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Admin
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="{{ route('commerces.index') }}">Entidades</a></li>
                        <li><a class="dropdown-item" href="{{ route('vouchers.create') }}">Vouchers</a></li>
                        <li><a class="dropdown-item" href="{{ route('tipos-entidad.index') }}">Tipos de Entidad</a></li>
                        <li><a class="dropdown-item" href="{{ route('organizacion.index') }}">Organizaciones</a></li>
                        <li><a class="dropdown-item" href="{{ route('influencers.index') }}">Influencers</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('login') }}" class="btn btn-primary px-4 rounded-pill commerce-navbar-btn">
                        Ingresar
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>