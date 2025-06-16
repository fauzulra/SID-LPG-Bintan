<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-text mx-2 "><img src="{{ asset('img/bintan.png') }}" width="20" height="20" class="d-inline-block align-items-center mb-1 mr-1" > SID LPG Bintan</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item {{ Request::is('penerima*') ? 'active' : '' }}">
        <a class="nav-link" href="/penerima">
            <i class="fas fa-fw fa-user"></i>
            <span>Data Penerima Subsidi</span></a>
    </li>
    <li class="nav-item {{ Request::is('stok*') ? 'active' : '' }} ">
        <a class="nav-link" href="/stok">
            <i class="fas fa-fw fa-warehouse"></i>
            <span>Data Stok Subsidi</span></a>
    </li>
    <li class="nav-item {{ Request::is('penjualan*') ? 'active' : '' }} ">
        <a class="nav-link" href="/penjualan">
            <i class="fas fa-fw fa-dollar-sign"></i>
            <span>Data Penjualan Subsidi</span></a>
    </li>
    @if (Auth::user()->hasRole('admin'))
        <li class="nav-item {{ Request::is('distributor*') ? 'active' : '' }} ">
            <a class="nav-link" href="{{ route('distributor.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Data Distributor</span></a>
        </li>
    @endif
</ul>