<!-- Side Navigation -->
<aside class="sidebar">
    <div class="d-flex align-items-center gap-3 mb-5 px-1">
        <div class="brand-icon">
            <i class="fa-solid fa-shop"></i>
        </div>
        <div>
            <h6 class="mb-0 fw-bold text-primary">Oxapremios POS</h6>
            <small class="text-muted" style="font-size: 12px;">Terminal #01</small>
        </div>
    </div>
    <nav class="flex-grow-1">
        <a class="nav-link py-2 {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
            <i class="fa-solid fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>
        <a class="nav-link py-2 {{ request()->routeIs('pos') ? 'active' : '' }}" href="{{ route('pos') }}">
            <i class="fa-solid fa-cash-register"></i>
            <span>POS</span>
        </a>
        @if(auth()->check() && auth()->user()->role_id == 3)
            <a class="nav-link py-2 {{ request()->routeIs('reports') ? 'active' : '' }}"
            href="{{ route('reports') }}">
                <i class="fa-solid fa-chart-line"></i>
                <span>Reportes</span>
            </a>
        @endif
    </nav>
    <div class="border-top pt-3">
        <!-- <a class="nav-link py-2" href="#">
            <i class="fa-solid fa-circle-user"></i>
            <span>Perfil</span>
        </a> -->
        <a 
            class="nav-link text-danger py-2"
            href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

            <i class="fa-solid fa-right-from-bracket"></i>

            <span>Cerrar sesión</span>

        </a>

        <form 
            id="logout-form"
            action="{{ route('logout') }}"
            method="POST"
            class="d-none">

            @csrf

        </form>
    </div>
</aside>