@php
    $orangTua = auth()->user()?->role === 'orang_tua';
    $menuUtama = $orangTua
        ? [
            ['ortu.dashboard', 'Portal Anak', 'home', 'ortu.dashboard'],
        ]
        : [
            ['dashboard.index', 'Dashboard', 'dashboard', 'dashboard.index'],
            ['balita.index', 'Data Balita', 'users', 'balita.*'],
            ['ortu.create', 'Kelola Orang Tua', 'user-group', 'ortu.create'],
            ['periksa.index', 'Pemeriksaan', 'stethoscope', 'periksa.*'],
            ['imunisasi.index', 'Imunisasi', 'vaccine', 'imunisasi.*'],
            ['vitamina.index', 'Vitamin A', 'pill', 'vitamina.*'],
        ];
@endphp
<aside class="sip-sidebar" id="sip-sidebar" aria-label="Navigasi utama">
    <div class="sip-sidebar-inner">
        <a class="sip-brand" href="{{ route($orangTua ? 'ortu.dashboard' : 'dashboard.index') }}">
            <span class="sip-brand-mark" data-sip-icon="heart"></span>
            <span>SIP Gizi Balita<small>Pemantauan Posyandu</small></span>
        </a>

        <div class="sip-nav-group">
            <div class="sip-nav-heading">Menu Utama</div>
            <nav class="sip-nav" aria-label="Menu utama">
                @foreach($menuUtama as [$routeName, $label, $icon, $active])
                    <a class="sip-nav-link {{ request()->routeIs($active) ? 'active' : '' }}"
                       @if(request()->routeIs($active)) aria-current="page" @endif
                       href="{{ route($routeName) }}">
                        <span data-sip-icon="{{ $icon }}"></span><span>{{ $label }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        @unless($orangTua)
            <div class="sip-nav-group">
                <div class="sip-nav-heading">Lainnya</div>
                <nav class="sip-nav" aria-label="Menu lainnya">
                    <a class="sip-nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
                       href="{{ route('laporan.index') }}"><span data-sip-icon="report"></span><span>Laporan</span></a>
                    @if(auth()->user()?->role === 'admin')
                        <a class="sip-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                           href="{{ route('users.index') }}"><span data-sip-icon="settings"></span><span>Manajemen User</span></a>
                    @endif
                </nav>
            </div>
        @endunless

        <div class="sip-sidebar-footer">
            <div class="sip-profile-name">{{ ucfirst(auth()->user()?->name ?? 'Pengguna') }}</div>
            <a href="{{ route('akun.password.edit') }}">Ganti Password</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar?')">Keluar / Logout</button>
            </form>
        </div>
    </div>
</aside>
