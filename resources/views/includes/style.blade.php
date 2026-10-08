    <!-- Custom fonts for this template-->
    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">


    <!-- Custom Pages CSS (If any) -->
    <style>
        .header {
            background: #fde8f0;
            color: #c2185b;
            padding: 20px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            border-radius: 8px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        .container {
           /* padding: 20px; */
        }

        /* === GLOBAL MOBILE FIXES === */
        /* Pastikan main-content tidak overflow di mobile */
        .main-content {
            width: 100%;
            overflow-x: hidden;
        }
        /* Card header tombol & judul agar tidak terpotong di mobile */
        .card-header.d-flex {
            flex-wrap: wrap;
            gap: 8px;
        }
        /* Nav tabs horizontal scroll di mobile */
        .nav-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .nav-tabs::-webkit-scrollbar { display: none; }
        .nav-tabs .nav-link {
            white-space: nowrap;
        }
        /* Header banner responsive */
        .card.bg-primary .card-body {
            flex-wrap: wrap;
            gap: 8px;
        }
        /* Container-xl tidak lebih dari 100% di mobile */
        .container-xl {
            max-width: 100%;
        }
        /* Pastikan semua gambar tidak overflow */
        img {
            max-width: 100%;
            height: auto;
        }

        /* === DASHBOARD STYLES === */
        .alert-box {
            padding: 15px 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .alert-icon {
            font-size: 24px;
        }

        .alert-content h3 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .alert-content p {
            font-size: 14px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            padding: 25px;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-title {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .stat-icon {
            font-size: 28px;
            color: #dddfeb;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-subtitle {
            font-size: 13px;
        }

        .charts-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .chart-card h2,
        .recent-table h2 {
            font-size: 18px;
            color: #2d2d2d;
            margin-bottom: 20px;
            font-weight: 700;
        }

        /* Fix table di .recent-table agar scrollable di mobile */
        .recent-table {
            overflow-x: auto;
        }
        .recent-table table {
            width: 100%;
            min-width: 600px;
            border-collapse: collapse;
        }
        .recent-table table th,
        .recent-table table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e3e6f0;
            white-space: nowrap;
        }
        .recent-table table thead {
            background: #f8f9fc;
        }
        .recent-table table tr:hover {
            background: #f8f9fc;
        }
        .action-btn {
            background: #4e73df;
            color: white;
            padding: 5px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
            display: inline-block;
        }
        .action-btn:hover {
            background: #375dca;
            color: white;
        }

        /* === RESPONSIVE: Tablet (max 1024px) === */
        @media (max-width: 1024px) {
            .charts-section {
                grid-template-columns: 1fr !important;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }

        /* === RESPONSIVE: Mobile (max 768px) === */
        @media (max-width: 768px) {
            .charts-section {
                grid-template-columns: 1fr !important;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 12px !important;
            }
            .stat-card {
                padding: 16px !important;
            }
            .stat-value {
                font-size: 24px !important;
            }
            .header h1 {
                font-size: 18px !important;
            }
            .container, .container-xl {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }
            /* Alert box stack vertically */
            .alert-box {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            /* Chart card padding reduction */
            .chart-card {
                padding: 16px !important;
            }
            /* Recent table title */
            .recent-table h2 {
                font-size: 16px;
            }
        }

        /* === RESPONSIVE: Small Mobile (max 480px) === */
        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr !important;
            }
            .stat-card {
                padding: 14px !important;
            }
        }

        /* === GLOBAL: Cegah horizontal scroll ===  */
        body {
            overflow-x: hidden !important;
        }

        /* === PADDING: kompensasi topbar mobile sticky ===
           Topbar 56px, jadi konten tidak tertutup */
        @media (max-width: 767.98px) {
            /* Pastikan konten dimulai setelah topbar */
            .main-content > div:first-child {
                /* tidak perlu margin-top karena topbar di luar wrapper */
            }
            /* Kurangi padding besar di card banner */
            .card.bg-primary .card-body.py-5 {
                padding-top: 20px !important;
                padding-bottom: 20px !important;
            }
            /* Tombol kembali di header halaman detail ortu */
            .card.bg-primary .card-body .btn {
                font-size: 13px;
                padding: 5px 10px;
            }
            /* Container padding di mobile */
            .container-xl.mt-4 {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }
        }

        /* === TEMA POSYANDU (Soft Pink Light UI) === */
        body {
            background-color: #fde8f0 !important;
        }

        /* Area konten utama – samakan background dengan body (override SB Admin) */
        html body #wrapper #content-wrapper,
        html body #wrapper #content-wrapper #content,
        html body .main-content,
        #content-wrapper,
        #content {
            background-color: #fde8f0 !important;
        }

        /* Semua card bawaan Bootstrap juga pink */
        html body .card,
        .card {
            background-color: #fde8f0 !important;
            border-color: rgba(200, 100, 140, 0.15) !important;
        }

        /* Sidebar / Navbar – samakan dengan warna background halaman */
        .sidebar.bg-gradient-primary,
        .navbar-nav.bg-gradient-primary {
            background: #fde8f0 !important;
            background-color: #fde8f0 !important;
            background-image: none !important;
        }

        /* Teks sidebar (icon, link, heading) jadi hitam/gelap */
        .navbar-nav.bg-gradient-primary .nav-link,
        .navbar-nav.bg-gradient-primary .nav-link span,
        .navbar-nav.bg-gradient-primary .nav-link i,
        .navbar-nav.bg-gradient-primary .sidebar-brand-text,
        .navbar-nav.bg-gradient-primary .sidebar-brand-icon,
        .navbar-nav.bg-gradient-primary .sidebar-heading,
        .navbar-nav.bg-gradient-primary div,
        .navbar-nav.bg-gradient-primary p {
            color: #2d2d2d !important;
            opacity: 1 !important;
        }
        .navbar-nav.bg-gradient-primary .sidebar-divider {
            border-top-color: rgba(0,0,0,0.15) !important;
        }
        .navbar-nav.bg-gradient-primary .nav-item.active .nav-link {
            background-color: rgba(0,0,0,0.08) !important;
            color: #1a1a1a !important;
            border-radius: 8px;
        }

        /* Banner Dashboard – samakan dengan background halaman */
        html body .card.bg-primary,
        .card.bg-primary {
            background-color: #fde8f0 !important;
            border-radius: 0 0 15px 15px !important;
            box-shadow: 0 2px 8px rgba(200, 100, 140, 0.1) !important;
            border: none !important;
        }
        /* Teks di banner jadi hitam */
        .card.bg-primary h4,
        .card.bg-primary p {
            color: #2d2d2d !important;
            text-shadow: none !important;
        }

        /* Card Statistik: tetap colorful tapi soft */
        .stat-card {
            border-radius: 16px !important;
            border-left: none !important;
            border-bottom: 5px solid rgba(0,0,0,0.08);
        }
        .stat-card:nth-child(1) { background-color: #f48fb1; } /* Pink Medium */
        .stat-card:nth-child(2) { background-color: #f9a8d4; } /* Pink Muda */
        .stat-card:nth-child(3) { background-color: #fbc2eb; } /* Pink Sangat Muda */
        .stat-card:nth-child(4) { background-color: #f06292; } /* Pink Agak Tua */

        /* Teks di stat card jadi hitam */
        .stat-card .stat-title,
        .stat-card .stat-subtitle,
        .stat-card .stat-value {
            color: #2d2d2d !important;
        }

        /* Card Grafik & Tabel: putih bersih di atas bg pink */
        .chart-card, .recent-table {
            background: #fff !important;
            border-radius: 16px !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(200, 100, 140, 0.1) !important;
        }

        /* Alert Stunting: warna TEGAS merah/kuning – penting & mendesak */
        .alert-box {
            background:  #e53e3e!important;
            border-left: 6px solid  #e53e3e!important;
            border-radius: 12px !important;
            box-shadow: 0 4px 20px rgba(229, 62, 62, 0.25) !important;
            animation: pulse-alert 2s ease-in-out infinite;
        }
        @keyframes pulse-alert {
            0%   { box-shadow: 0 4px 20px rgba(229, 62, 62, 0.25); }
            50%  { box-shadow: 0 4px 28px rgba(229, 62, 62, 0.55); }
            100% { box-shadow: 0 4px 20px rgba(229, 62, 62, 0.25); }
        }
        .alert-content h3 {
            color: #fff3cd !important;
            font-weight: 700 !important;
            font-size: 16px !important;
        }
        .alert-content p {
            color: #744210 !important;
            font-weight: 500 !important;
        }

        /* Mobile topbar seragam */
        .mobile-topbar {
            background: #f8c8da !important;
        }
        .mobile-topbar-brand,
        .mobile-topbar-user {
            color: #2d2d2d !important;
        }
        .mobile-topbar-toggle {
            color: #2d2d2d !important;
        }
        /* Card Data Anak Ortu - background tegas & font lebih hitam */
        .card {
            background-color: #ffffff !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12) !important;
        }
        .card:not(.bg-primary) {
    background-color: #fde8f0  !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12) !important;
    border-radius: 16px !important;
}
        .card h5 {
            font-weight: 700 !important;
            color: #1a1a1a !important;
        }
        .card .text-muted {
            color: #555555 !important;
            font-weight: 500 !important;
        }
    </style>
