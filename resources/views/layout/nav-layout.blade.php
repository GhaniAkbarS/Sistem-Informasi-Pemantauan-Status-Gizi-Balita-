<nav class="navbar">
    <div class="navbar-container">
        <a href="#" class="navbar-brand">

            <span>SIP Gizi Balita</span>
        </a>

        <div class="navbar-toggle" onclick="toggleMenu()">☰</div>

        <ul class="navbar-menu" id="navbarMenu">
            <li class="navbar-item">
                <a href="#" class="navbar-link active">

                    Dashboard
                </a>
            </li>
            <li class="navbar-item">
                <a href="{{ route('balita.create') }}" class="navbar-link">

                    Data Balita
                </a>
            </li>
            <li class="navbar-item">
                <a href="" class="navbar-link">

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
                <div class="user-avatar">SA</div>
                <div class="user-info">
                    <div class="user-name">Ibu Siti Aminah</div>
                    <div class="user-role">Kader Posyandu</div>
                </div>
            </div>
        </div>
    </div>
</nav>
