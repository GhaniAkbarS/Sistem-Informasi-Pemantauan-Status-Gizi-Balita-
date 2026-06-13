<!DOCTYPE html>
<html lang="id">
<head>
    @include('includes.meta')
    <script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "x55p88e9py");
    </script>
    @stack('before-style')
    @include('includes.style')
    @stack('after-style')
    <style>
        /* ============================================================
           MOBILE RESPONSIVE — SB Admin 2 Fix
           Root cause: #wrapper pakai display:flex sehingga sidebar
           mendorong konten ke kanan meski sudah position:fixed.
           Fix: ubah #wrapper ke display:block di mobile.
        ============================================================ */

        /* ── Topbar hanya muncul di mobile ── */
        .mobile-topbar {
            display: none;
            align-items: center;
            height: 56px;
            padding: 0 16px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 500;
            width: 100%;
            box-sizing: border-box;
        }
        .mobile-topbar-toggle {
            background: none;
            border: none;
            padding: 8px 10px;
            cursor: pointer;
            border-radius: 6px;
            color: #4e73df;
            font-size: 22px;
            line-height: 1;
        }
        .mobile-topbar-brand {
            margin-left: 10px;
            font-weight: 700;
            color: #4e73df;
            font-size: 16px;
            flex: 1;
        }
        .mobile-topbar-user {
            font-size: 12px;
            color: #6b7280;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 120px;
        }

        /* ── Overlay gelap saat sidebar terbuka ── */
        #sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.55);
            z-index: 1040;
        }
        #sidebar-overlay.active { display: block; }

        /* ── Breakpoint mobile: < 768px ── */
        @media (max-width: 767.98px) {

            /* Tampilkan topbar mobile */
            .mobile-topbar { display: flex !important; }

            /* Ubah #wrapper dari flex ke block:
               ini kunci utama agar sidebar tidak mendorong konten */
            #wrapper {
                display: block !important;
                overflow-x: hidden !important;
            }

            /* Sembunyikan sidebar di luar layar sebelah kiri */
            #wrapper .navbar-nav.sidebar {
                position: fixed !important;
                top: 0 !important;
                left: -260px !important;
                width: 250px !important;
                height: 100vh !important;
                z-index: 1050 !important;
                transition: left 0.28s ease !important;
                overflow-y: auto !important;
                overflow-x: hidden !important;
                display: flex !important;
                flex-direction: column !important;
            }

            /* Tampilkan sidebar saat kelas ini ditambahkan */
            #wrapper .navbar-nav.sidebar.sidebar-mobile-open {
                left: 0 !important;
                box-shadow: 4px 0 20px rgba(0,0,0,0.25) !important;
            }

            /* Content wrapper: full width, tanpa margin kiri */
            #content-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                min-width: 0 !important;
            }
        }
    </style>
</head>
<body>
    <!-- Overlay sidebar (di luar #wrapper) -->
    <div id="sidebar-overlay" onclick="closeMobileSidebar()"></div>

    <!-- Topbar Mobile (di luar #wrapper agar tidak terpengaruh flexbox) -->
    <div class="mobile-topbar">
        <button class="mobile-topbar-toggle" onclick="toggleMobileSidebar()" aria-label="Buka Menu">
            <i class="fas fa-bars"></i>
        </button>
        <span class="mobile-topbar-brand">SIP Gizi Balita</span>
        <span class="mobile-topbar-user">
            <i class="fas fa-user-circle mr-1"></i>
            {{ ucfirst(Auth::user()->name ?? 'User') }}
        </span>
    </div>

    <div id="wrapper">
        <x-nav-layout></x-nav-layout>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                {{ $slot }}
            </div>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    @stack('before-script')
    @include('includes.script')
    @stack('after-script')

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.querySelector('#wrapper .navbar-nav.sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (!sidebar) return;
            const isOpen = sidebar.classList.contains('sidebar-mobile-open');
            if (isOpen) {
                sidebar.classList.remove('sidebar-mobile-open');
                overlay.classList.remove('active');
            } else {
                sidebar.classList.add('sidebar-mobile-open');
                overlay.classList.add('active');
            }
        }

        function closeMobileSidebar() {
            const sidebar = document.querySelector('#wrapper .navbar-nav.sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar) sidebar.classList.remove('sidebar-mobile-open');
            if (overlay) overlay.classList.remove('active');
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Tutup sidebar otomatis saat link diklik di mobile
            const navLinks = document.querySelectorAll('#wrapper .navbar-nav.sidebar .nav-link');
            navLinks.forEach(function (link) {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 767) closeMobileSidebar();
                });
            });

            // Reset saat resize ke desktop
            window.addEventListener('resize', function () {
                if (window.innerWidth > 767) {
                    closeMobileSidebar();
                }
            });
        });
    </script>
</body>
</html>
