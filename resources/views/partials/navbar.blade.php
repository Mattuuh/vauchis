{{-- @if (session('auth.tu_id')==1) --}}
@if (session('auth.tu_id')==1)
    
<nav class="navbar navbar-expand-lg bg-white py-3 shadow-sm sticky-top commerce-navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('images/logo-1.png') }}" alt="Vauchis" height="40">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                <li class="nav-item">
                    <a class="nav-link fw-semibold" href="{{ route('home') }}">Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Entidades
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="{{ route('entidades.index') }}">Entidades</a></li>
                        <li><a class="dropdown-item" href="{{ route('tipos-entidad.index') }}">Tipos de Entidad</a></li>
                        <li><a class="dropdown-item" href="{{ route('rubros.index') }}">Rubros</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Vouchers
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="{{ route('vouchers.index') }}">Vouchers</a></li>
                        <li><a class="dropdown-item" href="{{ route('modalidades.index') }}">Modalidades</a></li>
                        <li><a class="dropdown-item" href="{{ route('etiquetas.index') }}">Etiquetas</a></li>
                        {{-- <li><a class="dropdown-item" href="{{ route('voucher_emisiones.index') }}">Emision</a></li> --}}
                        <li><a class="dropdown-item" href="{{ route('voucher_plantillas.index') }}">Plantillas</a></li>
                        <li><a class="dropdown-item" href="{{ route('biblioteca_fondos.create') }}">Fondos</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Organizaciones
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="{{ route('organizacion.index') }}">Organizaciones</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Influencers
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="{{ route('influencers.index') }}">Influencers</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 commerce-user-menu" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-fill"></i> {{ session('auth.nombre') }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 commerce-user-dropdown">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-semibold">{{ session('auth.nombre') }}</div>
                            <small class="text-muted">{{ session('auth.email') }}</small>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('vouchers.index') }}"><i class="bi bi-pencil-square me-2"></i>Editar perfil</a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li class="px-2 pb-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit" class="btn btn-danger w-100 rounded-pill">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Salir
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

@elseif (session('auth.tu_id')==2)

<nav class="v-navbar">
    <div class="container">

        <button class="v-navbar__toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
            <i class="bi bi-list"></i>
        </button>

        <a href="{{ route('home') }}" class="v-navbar__logo">
            <img src="{{ asset('images/logo-1.png') }}" alt="Vauchis">
        </a>

        <div class="v-navbar__search">
            <input type="text" class="v-form-control" placeholder="Buscá tu vauchis...">
        </div>

        <ul class="v-navbar__menu">
            <li>
                <a {{-- href="{{ route('objetos.index') }}" --}}>Objetos</a>
            </li>

            <li>
                <a {{-- href="{{ route('experiencias.index') }}" --}}>Experiencias</a>
            </li>

            <li>
                <a {{-- href="{{ route('causa.index') }}" --}}>Regalá con causa</a>
            </li>
        </ul>

        <div class="v-navbar__actions">

            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 commerce-user-menu"
                href="#"
                id="adminDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                    <i class="bi bi-person-fill"></i>
                    {{ session('auth.nombre') }}
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow border-0 commerce-user-dropdown"
                    aria-labelledby="adminDropdown">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-semibold">{{ session('auth.nombre') }}</div>
                        <small class="text-muted">{{ session('auth.email') }}</small>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ route('vouchers.index') }}">
                            <i class="bi bi-pencil-square me-2"></i>Editar perfil
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ route('modalidades.index') }}">
                            <i class="bi bi-ticket-perforated me-2"></i>Mis vouchers
                        </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li class="px-2 pb-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100 rounded-pill">
                                <i class="bi bi-box-arrow-right me-2"></i>Salir
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            <a href="#" class="v-navbar__icon">
                <i class="bi bi-question"></i>
            </a>

        </div>

    </div>
</nav>

@else

<nav class="v-navbar">
    <div class="container">

        <button class="v-navbar__toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
            <i class="bi bi-list"></i>
        </button>

        <a href="{{ route('home') }}" class="v-navbar__logo">
            <img src="{{ asset('images/logo-1.png') }}" alt="Vauchis">
        </a>

        <div class="v-navbar__search">
            <input type="text" class="v-form-control" placeholder="Buscá tu vauchis...">
        </div>

        <ul class="v-navbar__menu">
            <li>
                <a {{-- href="{{ route('objetos.index') }}" --}}>Objetos</a>
            </li>

            <li>
                <a {{-- href="{{ route('experiencias.index') }}" --}}>Experiencias</a>
            </li>

            <li>
                <a {{-- href="{{ route('causa.index') }}" --}}>Regalá con causa</a>
            </li>
        </ul>

        <div class="v-navbar__actions">
            <a href="{{ route('login') }}" class="v-navbar__icon">
                {{-- <i class="bi bi-person-circle"></i> --}}
                <i class="bi bi-person-fill"></i>
            </a>

            <a href="#" class="v-navbar__icon">
                <i class="bi bi-question"></i>
            </a>
        </div>

    </div>
</nav>
@endif

<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">

    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menú</h5>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas">
        </button>
    </div>

    <div class="offcanvas-body">

        <ul class="list-unstyled mb-4">
            <li class="mb-3">
                <a href="#" class="text-decoration-none">Objetos</a>
            </li>

            <li class="mb-3">
                <a href="#" class="text-decoration-none">Experiencias</a>
            </li>

            <li class="mb-3">
                <a href="#" class="text-decoration-none">Regalá con causa</a>
            </li>
        </ul>

        @if(session('auth'))
            <hr>

            <div class="mb-3">
                <strong>{{ session('auth.nombre') }}</strong><br>
                <small>{{ session('auth.email') }}</small>
            </div>

            <a href="{{ route('vouchers.index') }}"
               class="btn btn-outline-primary w-100 mb-2">
                Editar perfil
            </a>

            <a href="{{ route('modalidades.index') }}"
               class="btn btn-outline-primary w-100 mb-2">
                Mis vouchers
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="btn btn-danger w-100">
                    Salir
                </button>
            </form>
        @else
            <hr>
            <a href="{{ route('login') }}" class="v-navbar__icon">
                {{-- <i class="bi bi-person-circle"></i> --}}
                <i class="bi bi-person-fill"></i>
            </a>
        @endif

    </div>
</div>