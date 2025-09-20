<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #003399;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-store"></i>
        </div>
        <div class="sidebar-brand-text mx-3">POSLite</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Products -->
    <li class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('products.index') }}">
            <i class="fas fa-box"></i>
            <span>Products</span>
        </a>
    </li>

    <!-- Nav Item - POS -->
    <li class="nav-item {{ request()->routeIs('pos.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pos.index') }}">
            <i class="fas fa-cash-register"></i>
            <span>POS</span>
        </a>
    </li>

    <!-- Nav Item - Sales -->
    <li class="nav-item {{ request()->routeIs('sales.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('sales.index') }}">
            <i class="fas fa-receipt"></i>
            <span>Sales</span>
        </a>
    </li>

    <!-- Nav Item - Cashiers -->
    <li class="nav-item {{ request()->routeIs('cashiers.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('cashiers.index') }}">
            <i class="fas fa-user-tie"></i>
            <span>Cashiers</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
