{{-- @if (session('auth.tu_id')==1) --}}
@if (session('auth.tu_id')==1)
    
<nav class="navbar navbar-expand-lg bg-white py-3 shadow-sm commerce-navbar">
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
                        <li><a class="dropdown-item" href="{{ route('admin.entidades.index') }}">Entidades</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.tipos-entidad.index') }}">Tipos de Entidad</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.rubros.index') }}">Rubros</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.resaltadores.index') }}">Resaltadores</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Vouchers
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.vouchers.index') }}">Vouchers</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.modalidades.index') }}">Modalidades</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.tipos_modalidades.index') }}">Tipos de Modalidades</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.etiquetas.index') }}">Etiquetas</a></li>
                        {{-- <li><a class="dropdown-item" href="{{ route('voucher_emisiones.index') }}">Emision</a></li> --}}
                        {{-- <li><a class="dropdown-item" href="{{ route('admin.voucher_plantillas.index') }}">Plantillas</a></li> --}}
                        {{-- <li><a class="dropdown-item" href="{{ route('admin.biblioteca_fondos.create') }}">Fondos</a></li> --}}
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Organizaciones
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.organizacion.index') }}">Organizaciones</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Influencers
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.influencers.index') }}">Influencers</a></li>
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
                            <a class="dropdown-item" href="{{ route('admin.vouchers.index') }}"><i class="bi bi-pencil-square me-2"></i>Editar perfil</a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li class="px-2 pb-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit" class="btn btn-danger w-100 rounded-pill"><i class="bi bi-box-arrow-right me-2"></i>Salir</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

@elseif (session('auth.tu_id')==2)

<nav class="v-navbar is-scrolled" id="vNavbar">
    <div class="v-navbar__shell">

        <div class="v-navbar__top">
            <a href="{{ route('home') }}" class="v-navbar__logo">
                <img src="{{ asset('images/logo-1.png') }}" alt="Vauchis">
            </a>

            {{-- Acciones --}}
            <div class="v-navbar__actions">

                {{-- Usuario --}}
                <div class="dropdown">
                    <a href="#" class="v-navbar__icon dropdown-toggle" id="mobileUserDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('images/icono-Perfil.png') }}" alt="Usuario">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 commerce-user-dropdown">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-semibold">{{ session('auth.nombre') }}</div>
                            <small class="text-muted">{{ session('auth.email') }}</small>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('usuarios.vouchers', session('auth.usuario_id')) }}">
                                <i class="bi bi-pencil-square me-2"></i>Mis vouchers
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="">
                                <i class="bi bi-person me-2"></i>Editar perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-heart me-2"></i>Favoritos
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
                    <img src="{{ asset('images/icono-Ayuda.png') }}" alt="Ayuda">
                </a>
            </div>
        </div>

        <div class="v-navbar__search">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Buscá tu vauchis...">
        </div>

        <ul class="v-navbar__menu">
            <li>
                <a href="{{ route('categorias', 1) }}" class="v-menu-item item-objetos {{ isset($categoria->id) ? (1 == $categoria->id ? 'active' : '') : '' }}">
                    {{-- <img src="{{ asset('images/bt-objetos-1.png') }}" alt=""> --}}
                    <span class="icono"></span>
                    Objetos
                </a>
            </li>

            <li>
                <a href="{{ route('categorias', 2) }}" class="v-menu-item item-experiencias {{ isset($categoria->id) ? (2 == $categoria->id ? 'active' : '') : '' }}">
                    {{-- <img src="{{ asset('images/bt-experiencias-1.png') }}" alt=""> --}}
                    <span class="icono"></span>
                    Experiencias
                </a>
            </li>

            <li>
                <a href="{{ route('categorias', 3) }}" class="v-menu-item item-concausa {{ isset($categoria->id) ? (3 == $categoria->id ? 'active' : '') : '' }}">
                    {{-- <img src="{{ asset('images/bt-concausa-1.png') }}" alt=""> --}}
                    <span class="icono"></span>
                    Con causa
                </a>
            </li>
        </ul>

        <div class="v-navbar__note">
            ¡Elegí que regalar!
            <img src="{{ asset('images/decoracion-flecha.svg') }}" alt="" class="" width="55" height="53">
        </div>

    </div>
</nav>

@else

<nav class="v-navbar is-scrolled" id="vNavbar">
    <div class="v-navbar__shell">

        <div class="v-navbar__top">
            <a href="{{ route('home') }}" class="v-navbar__logo">
                <img src="{{ asset('images/logo-1.png') }}" alt="Vauchis">
            </a>

            <div class="v-navbar__actions">
                <a href="{{ route('login') }}" class="v-navbar__icon">
                    <img src="{{ asset('images/icono-Perfil.png') }}" alt="Usuario">
                    {{-- <i class="bi bi-person"></i> --}}
                </a>

                <a href="#" class="v-navbar__icon">
                    <img src="{{ asset('images/icono-Ayuda.png') }}" alt="Ayuda">
                    {{-- <i class="bi bi-question"></i> --}}
                </a>
            </div>
        </div>

        <div class="v-navbar__search">
            {{-- <img src="{{ asset('images/icon-search.png') }}" alt="Buscar"> --}}
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Buscá tu vauchis...">
        </div>

        <ul class="v-navbar__menu">
            <li>
                <a href="{{ route('categorias', 1) }}" class="v-menu-item item-objetos {{ isset($categoria->id) ? (1 == $categoria->id ? 'active' : '') : '' }}">
                    {{-- <img src="{{ asset('images/bt-objetos-1.png') }}" alt=""> --}}
                    <span class="icono"></span>
                    Objetos
                </a>
            </li>

            <li>
                <a href="{{ route('categorias', 2) }}" class="v-menu-item item-experiencias {{ isset($categoria->id) ? (2 == $categoria->id ? 'active' : '') : '' }}">
                    {{-- <img src="{{ asset('images/bt-experiencias-1.png') }}" alt=""> --}}
                    <span class="icono"></span>
                    Experiencias
                </a>
            </li>

            <li>
                <a href="{{ route('categorias', 3) }}" class="v-menu-item item-concausa {{ isset($categoria->id) ? (3 == $categoria->id ? 'active' : '') : '' }}">
                    {{-- <img src="{{ asset('images/bt-concausa-1.png') }}" alt=""> --}}
                    <span class="icono"></span>
                    Con causa
                </a>
            </li>
        </ul>

        <div class="v-navbar__note">
            ¡Elegí que regalar!
            <img src="{{ asset('images/decoracion-flecha.svg') }}" alt="" class="" width="55" height="53">
        </div>

    </div>
</nav>
@endif


@if (session('auth.tu_id') == 1)

    {{-- NAVBAR ADMIN MOBILE --}}
    <nav class="v-mobile-navbar">
        <button type="button" class="v-mobile-navbar__btn" data-bs-toggle="offcanvas" data-bs-target="#vMobileAdminMenu">
            <i class="bi bi-list"></i>
        </button>

        <a href="{{ route('home') }}" class="v-mobile-navbar__logo">
            <img src="{{ asset('images/logo-1.png') }}" alt="Vauchis">
        </a>

        {{-- <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="v-mobile-navbar__btn">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </form> --}}
        <button type="button" class="v-mobile-navbar__btn"></button>
    </nav>

    <div class="offcanvas offcanvas-start v-mobile-panel" tabindex="-1" id="vMobileAdminMenu">
        <div class="v-mobile-panel__header">
            <img src="{{ asset('images/logo-1.png') }}" alt="Vauchis">
            <button type="button" data-bs-dismiss="offcanvas">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="v-mobile-panel__body">
            <h3>Administrador</h3>

            <a href="{{ route('home') }}"><i class="bi bi-house-door"></i>Inicio</a>

            <a href="{{ route('admin.entidades.index') }}"><i class="bi bi-shop"></i>Entidades</a>

            <a href="{{ route('admin.tipos-entidad.index') }}"><i class="bi bi-tags"></i>Tipos de Entidad</a>

            <a href="{{ route('admin.rubros.index') }}"><i class="bi bi-grid"></i>Rubros</a>

            <a href="{{ route('admin.vouchers.index') }}"><i class="bi bi-ticket-perforated"></i>Vouchers</a>

            <a href="{{ route('admin.modalidades.index') }}"><i class="bi bi-sliders"></i>Modalidades</a>

            <a href="{{ route('admin.tipos_modalidades.index') }}"><i class="bi bi-sliders"></i>Tipos de Modalidades</a>

            <a href="{{ route('admin.etiquetas.index') }}"><i class="bi bi-bookmark"></i>Etiquetas</a>

            {{-- <a href="{{ route('admin.voucher_plantillas.index') }}"><i class="bi bi-file-earmark-richtext"></i>Plantillas</a> --}}

            {{-- <a href="{{ route('admin.biblioteca_fondos.create') }}"><i class="bi bi-image"></i>Fondos</a> --}}

            <a href="{{ route('admin.organizacion.index') }}"><i class="bi bi-people"></i>Organizaciones</a>

            <a href="{{ route('admin.influencers.index') }}"><i class="bi bi-person-video3"></i>Influencers</a>

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-danger w-100 rounded-pill">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Salir
                </button>
            </form>
        </div>
    </div>

@else
<nav class="v-mobile-navbar">
    <button type="button" class="v-mobile-navbar__btn" data-bs-toggle="offcanvas" data-bs-target="#vMobileMenu"><i class="bi bi-list"></i></button>
    <a href="{{ route('home') }}" class="v-mobile-navbar__logo"><img src="{{ asset('images/logo-1.png') }}" alt="Vauchis"></a>
    <button type="button" class="v-mobile-navbar__btn" data-bs-toggle="offcanvas" data-bs-target="#vMobileSearch"><i class="bi bi-search"></i></button>
</nav>
<div class="offcanvas offcanvas-start v-mobile-panel" tabindex="-1" id="vMobileMenu">
    <div class="v-mobile-panel__header">
        <img src="{{ asset('images/logo-1.png') }}" alt="Vauchis">
        <button type="button" data-bs-dismiss="offcanvas">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="v-mobile-panel__body">
        <h3>Menú</h3>

        {{-- OBJETOS --}}
        <div class="v-mobile-menu-item">
            <div class="v-mobile-menu-row">
                <a href="{{ route('categorias', 1) }}" class="v-mobile-category-link">
                    <img src="{{ asset('images/bt-objetos-1.png') }}" alt="">
                    <span>Objetos</span>
                </a>
                <button type="button" class="v-mobile-menu-toggle" data-bs-toggle="collapse" data-bs-target="#menuObjetos" aria-expanded="false" aria-controls="menuObjetos">
                    <i class="bi bi-chevron-down"></i>
                </button>
            </div>
            <div class="collapse v-mobile-submenu" id="menuObjetos">
                @foreach($rubros->where('cv_id', 1)->sortBy('rub_orden') as $rubro)
                    <a href="#" class="v-mobile-submenu-link {{ request('rubro') == $rubro->rub_id ? 'active' : '' }}" data-categoria="{{ $rubro->cv_id }}" data-rubro-id="{{ $rubro->rub_id }}" data-url="{{ route('categorias.rubros.entidades', ['categoria' => 1, 'rubro' => $rubro->rub_id ]) }}">
                        {{ $rubro->rub_nombre }}
                    </a>
                @endforeach
            </div>
        </div>
        {{-- EXPERIENCIAS --}}
        <div class="v-mobile-menu-item">
            <div class="v-mobile-menu-row">
                <a href="{{ route('categorias', 2) }}" class="v-mobile-category-link">
                    <img src="{{ asset('images/bt-experiencias-1.png') }}" alt="">
                    <span>Experiencias</span>
                </a>
                <button type="button" class="v-mobile-menu-toggle" data-bs-toggle="collapse" data-bs-target="#menuExperiencias" aria-expanded="false" aria-controls="menuExperiencias">
                    <i class="bi bi-chevron-down"></i>
                </button>
            </div>
            <div class="collapse v-mobile-submenu" id="menuExperiencias">
                @foreach($rubros->where('cv_id', 2)->sortBy('rub_orden') as $rubro)
                    <a href="#" class="v-mobile-submenu-link {{ request('rubro') == $rubro->rub_id ? 'active' : '' }}" data-categoria="{{ $rubro->cv_id }}" data-rubro-id="{{ $rubro->rub_id }}" data-url="{{ route('categorias.rubros.entidades', ['categoria' => 1, 'rubro' => $rubro->rub_id ]) }}">
                        {{ $rubro->rub_nombre }}
                    </a>
                @endforeach
            </div>
        </div>
        {{-- CON CAUSA --}}
        <div class="v-mobile-menu-item">
            <div class="v-mobile-menu-row">
                <a href="{{ route('categorias', 3) }}" class="v-mobile-category-link">
                    <img src="{{ asset('images/bt-concausa-1.png') }}" alt="">
                    <span>Con causa</span>
                </a>
                <button type="button" class="v-mobile-menu-toggle" data-bs-toggle="collapse" data-bs-target="#menuConCausa" aria-expanded="false" aria-controls="menuConCausa">
                    <i class="bi bi-chevron-down"></i>
                </button>
            </div>
            <div class="collapse v-mobile-submenu" id="menuConCausa">
                @foreach($rubros->where('cv_id', 3)->sortBy('rub_orden') as $rubro)
                    <a href="#" class="v-mobile-submenu-link {{ request('rubro') == $rubro->rub_id ? 'active' : '' }}" data-categoria="{{ $rubro->cv_id }}" data-rubro-id="{{ $rubro->rub_id }}" data-url="{{ route('categorias.rubros.entidades', ['categoria' => 1, 'rubro' => $rubro->rub_id ]) }}">
                        {{ $rubro->rub_nombre }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- ACCIONES DEL MENÚ --}}
        <div class="v-mobile-menu-actions">
            <a href="{{ route('login') }}" class="v-mobile-action-link">
                <img src="{{ asset('images/icono-Perfil.png') }}" alt="">
                <span>Usuario</span>
            </a>
            <a href="#" class="v-mobile-action-link">
                <img src="{{ asset('images/icono-Ayuda.png') }}" alt="">
                <span>Ayuda</span>
            </a>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end v-search-panel" tabindex="-1" id="vMobileSearch">
    <div class="v-search-panel__top">
        <div class="v-search-panel__input">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Buscar..." autofocus>
        </div>

        <button type="button" data-bs-dismiss="offcanvas">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="v-search-panel__results">
        <a href="#">Hoyts Salta</a>
        <a href="#">Hotelería</a>
        <a href="#">Hotel Salta</a>
    </div>
</div>
@endif