<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #003399;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <i class="fas fa-school"></i>
        </div>
        <div class="sidebar-brand-text mx-3">DepEd Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link " href="#">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>


    <!-- Nav Item - Registrations -->
    <li class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
        <a class="nav-link " href="{{ route('products.index') }}">
            <i class="fas fa-users"></i>
            <span>Products</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('sales.*') ? 'active' : '' }}">
        <a class="nav-link " href="{{ route('sales.index') }}">
            <i class="fas fa-users"></i>
            <span>Sales</span>
        </a>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
