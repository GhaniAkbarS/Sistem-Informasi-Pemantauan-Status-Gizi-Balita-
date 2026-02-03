<nav class="navbar">
    <div class="navbar-container">
        <a href="{{ route('dashboard.index') }}" class="navbar-brand {{ request()->is('dashboard.index') ? 'active' : '' }}">

            <span>SIP Gizi Balita</span>
        </a>

        <div class="navbar-toggle" onclick="toggleMenu()">☰</div>

        <ul class="navbar-menu" id="navbarMenu">
            <li class="navbar-item">
                <a href="{{ route('dashboard.index') }}" class="navbar-link {{ request()->is('dashboard.index') ? 'active' : '' }}">                    
                    Dashboard
                </a>
            </li>
            <li class="navbar-item">
                <a href="{{ route('balita.index') }}" class="navbar-link {{ request()->is('balita.index') ? 'active' : '' }}">
                    Data Balita
                </a>
            </li>
            <li class="navbar-item">
                <a href="{{ route('periksa.index') }}" class="navbar-link {{ request()->is('periksa.index') ? 'active' : '' }}">

                    Pemeriksaan
                </a>
            </li>
            <li class="navbar-item">
                <a href="#" class="navbar-link">

                    Laporan
                </a>
            </li>
            <li class="navbar-item">
                <a href="#" class="navbar-link">

                    Rujukan
                </a>
            </li>
        </ul>

        <div class="navbar-right">
            <div class="navbar-notification">
                <span class="notification-badge">3</span>
            </div>

            <div class="navbar-user">
                <div class="user-avatar">US</div>
                <div class="user-info">
                    <p><strong>Kader:</strong> {{ ucfirst(session('user')) }}</p>
                    <p style="opacity: 0.9;">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</nav>
