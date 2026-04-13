<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-baby"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIP Gizi Balita</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu Utama
    </div>

    <!-- Nav Item - Data Balita -->
    <li class="nav-item {{ request()->routeIs('balita.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('balita.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Balita</span></a>
    </li>

    <!-- Nav Item - Pemeriksaan -->
    <li class="nav-item {{ request()->routeIs('periksa.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('periksa.index') }}">
            <i class="fas fa-fw fa-stethoscope"></i>
            <span>Pemeriksaan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Lainnya
    </div>

    <!-- Nav Item - Laporan -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('laporan.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Laporan</span></a>
    </li>

    <!-- Nav Item - Rujukan -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-hospital"></i>
            <span>Rujukan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Divider -->

    <div class="text-center px-3 py-3 mt-auto" style="color: #fff;">
        <p class="m-0" style="font-size: 0.85rem; font-weight: 600; letter-spacing: 0.5px;">
            <i class="fas fa-user-circle mr-1"></i> {{ ucfirst(session('user')) }}
        </p>
        <p class="m-0" style="font-size: 0.75rem; opacity: 0.75;">
            <i class="fas fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
        </p>
    </div>

</ul>
