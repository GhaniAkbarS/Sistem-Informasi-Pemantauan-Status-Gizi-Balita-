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
            <i class="fas fa-user-circle mr-1"></i> {{ ucfirst(Auth::user()->name ?? 'User') }}
        </p>
        <p class="m-0" style="font-size: 0.75rem; opacity: 0.75;">
            <i class="fas fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
        </p>
        <a class="nav-link text-danger" href="{{ route('logout') }}" 
       onclick="event.preventDefault(); if(confirm('Apakah anda yakin ingin keluar?')) { window.location.href = '{{ route('logout') }}'; }">
        <span class="nav-link-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                <path d="M9 12h12l-3 -3" />
                <path d="M18 15l3 -3" />
            </svg>
        </span>
        <span class="nav-link-title">Keluar / Logout</span>
    </a>
    </div>
    

</ul>
