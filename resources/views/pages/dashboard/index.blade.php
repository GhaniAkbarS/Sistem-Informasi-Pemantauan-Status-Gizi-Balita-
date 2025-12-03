<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Posyandu Cendrawasih</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            display: flex;
            min-height: 100vh;
        }

        .navbar {
            width: 260px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #ffffff;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            z-index: 1000;
        }

        .navbar-container {
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 0 20px;
            width: 100%;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 700;
            color: #667eea;
            text-decoration: none;
            margin-bottom: 30px;
            padding: 0 10px;
        }

        .navbar-brand-icon {
            font-size: 28px;
        }

        .navbar-menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
            list-style: none;
            width: 100%;
        }

        .navbar-item {
            position: relative;
            width: 100%;
        }

        .navbar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: #4b5563;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s;
            width: 100%;
        }

        .navbar-link:hover {
            background: #f3f4f6;
            color: #667eea;
        }

        .navbar-link.active {
            background: #ede9fe;
            color: #667eea;
            font-weight: 600;
        }

        .navbar-link-icon {
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .navbar-right {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            border-top: 1px solid #f3f4f6;
            padding-top: 20px;
            width: 100%;
        }

        .navbar-notification {
            position: relative;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .navbar-notification:hover {
            background: #f3f4f6;
        }

        .notification-badge {
            position: absolute;
            top: 4px;
            left: 20px;
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 5px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s;
            width: 100%;
        }

        .navbar-user:hover {
            background: #f3f4f6;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 12px;
            color: #6b7280;
        }

        .navbar-toggle {
            display: none;
        }

        .main-content {
            flex: 1;
            margin-left: 260px;
            width: calc(100% - 260px);
            display: flex;
            flex-direction: column;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
        }

        .header-info {
            text-align: right;
            font-size: 14px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
        }

        .alert-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .alert-icon {
            font-size: 24px;
        }

        .alert-content h3 {
            color: #856404;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .alert-content p {
            color: #856404;
            font-size: 14px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
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
            color: #6b7280;
            font-weight: 500;
        }

        .stat-icon {
            font-size: 28px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .stat-subtitle {
            font-size: 13px;
            color: #9ca3af;
        }

        .stat-trend {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
        }

        .trend-up {
            background: #d1fae5;
            color: #065f46;
        }

        .trend-down {
            background: #fee2e2;
            color: #991b1b;
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

        .chart-card h2 {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .chart-placeholder {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            height: 300px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            font-size: 14px;
        }

        .status-breakdown {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .status-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .status-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .status-label {
            flex: 1;
            font-size: 14px;
            color: #4b5563;
        }

        .status-count {
            font-weight: 700;
            font-size: 16px;
            color: #1f2937;
        }

        .status-percentage {
            font-size: 12px;
            color: #9ca3af;
            min-width: 45px;
            text-align: right;
        }

        .recent-table {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .recent-table h2 {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 20px;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f9fafb;
        }

        th {
            padding: 12px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 2px solid #e5e7eb;
        }

        td {
            padding: 12px;
            font-size: 14px;
            border-bottom: 1px solid #f3f4f6;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-normal {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-btn {
            padding: 6px 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .action-btn:hover {
            background: #5568d3;
        }

        @media (max-width: 1024px) {
            .charts-section {
                grid-template-columns: 1fr;
            }

            .navbar-menu {
                display: none;
                position: absolute;
                top: 70px;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 10px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }

            .navbar-menu.active {
                display: flex;
            }

            .navbar-toggle {
                display: block;
            }

            .navbar-right {
                gap: 10px;
            }

            .user-info {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 20px 15px;
            }

            .navbar-container {
                padding: 0 15px;
            }

            .header {
                padding: 20px 15px;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .header-info {
                text-align: left;
            }
        }
    </style>
</head>
<body>
    
    <!-- Navbar -->
    @include('layout.nav-layout')

    <div class="main-content">
        <div class="header">
            <div class="header-content">
                <div>
                    <h1>📊 Dashboard Posyandu Cendrawasih</h1>
                    <p style="font-size: 14px; opacity: 0.9; margin-top: 5px;">RW 03, Kelurahan Sidomulyo Timur</p>
                </div>
                <div class="header-info">
                    <p><strong>Kader:</strong> Ibu Siti Aminah</p>
                    <p style="opacity: 0.9;">Senin, 1 Desember 2025</p>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Alert Notifikasi Stunting -->
            <div class="alert-box">
                <div class="alert-icon">⚠️</div>
                <div class="alert-content">
                    <h3>Perhatian: Terdeteksi Kasus Berisiko Stunting</h3>
                    <p>3 balita memerlukan perhatian khusus dan rujukan ke Puskesmas Simpang Tiga</p>
                </div>
            </div>

            <!-- Statistik Utama -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total Balita Terdaftar</span>
                        <span class="stat-icon">👶</span>
                    </div>
                    <div class="stat-value">87</div>
                    <div class="stat-subtitle">Balita aktif per November 2025</div>
                    <span class="stat-trend trend-up">↑ +5 bulan ini</span>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Pemeriksaan Bulan Ini</span>
                        <span class="stat-icon">📋</span>
                    </div>
                    <div class="stat-value">62</div>
                    <div class="stat-subtitle">Dari 87 balita (71%)</div>
                    <span class="stat-trend trend-down">↓ -8% vs bulan lalu</span>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Status Gizi Normal</span>
                        <span class="stat-icon">✅</span>
                    </div>
                    <div class="stat-value">68</div>
                    <div class="stat-subtitle">78% dari total balita</div>
                    <span class="stat-trend trend-up">↑ +2% vs bulan lalu</span>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Perlu Rujukan</span>
                        <span class="stat-icon">🏥</span>
                    </div>
                    <div class="stat-value">3</div>
                    <div class="stat-subtitle">Risiko tinggi stunting</div>
                    <span class="stat-trend trend-down" style="background: #d1fae5; color: #065f46;">↓ -1 dari bulan lalu</span>
                </div>
            </div>

            <!-- Grafik dan Breakdown -->
            <div class="charts-section">
                <div class="chart-card">
                    <h2>📈 Tren Pemeriksaan 6 Bulan Terakhir</h2>
                    <div class="chart-placeholder">
                        [Grafik Garis: Jun: 58 | Jul: 61 | Agt: 65 | Sep: 67 | Okt: 63 | Nov: 62]
                    </div>
                </div>

                <div class="chart-card">
                    <h2>🎯 Distribusi Status Gizi</h2>
                    <div class="status-breakdown">
                        <div class="status-item">
                            <div class="status-color" style="background: #10b981;"></div>
                            <span class="status-label">Normal</span>
                            <span class="status-count">68</span>
                            <span class="status-percentage">78%</span>
                        </div>
                        <div class="status-item">
                            <div class="status-color" style="background: #f59e0b;"></div>
                            <span class="status-label">Pendek (Berisiko)</span>
                            <span class="status-count">16</span>
                            <span class="status-percentage">18%</span>
                        </div>
                        <div class="status-item">
                            <div class="status-color" style="background: #ef4444;"></div>
                            <span class="status-label">Sangat Pendek (Stunting)</span>
                            <span class="status-count">3</span>
                            <span class="status-percentage">3%</span>
                        </div>
                        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                            <p style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">
                                <strong>Catatan:</strong> 19 balita (22%) memerlukan pemantauan intensif
                            </p>
                            <p style="font-size: 12px; color: #9ca3af;">
                                Data per 1 Desember 2025
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Pemeriksaan Terbaru -->
            <div class="recent-table">
                <h2>📝 Pemeriksaan Terbaru (7 Hari Terakhir)</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Balita</th>
                            <th>Umur</th>
                            <th>Tanggal Periksa</th>
                            <th>BB/TB</th>
                            <th>Z-Score</th>
                            <th>Status Gizi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Ahmad Fauzan</strong></td>
                            <td>18 bulan</td>
                            <td>28 Nov 2025</td>
                            <td>9.2kg / 76cm</td>
                            <td>-2.8</td>
                            <td><span class="badge badge-danger">Sangat Pendek</span></td>
                            <td><button class="action-btn">Rujuk</button></td>
                        </tr>
                        <tr>
                            <td><strong>Siti Nurhaliza</strong></td>
                            <td>24 bulan</td>
                            <td>28 Nov 2025</td>
                            <td>10.8kg / 82cm</td>
                            <td>-1.2</td>
                            <td><span class="badge badge-normal">Normal</span></td>
                            <td><button class="action-btn">Detail</button></td>
                        </tr>
                        <tr>
                            <td><strong>Budi Santoso</strong></td>
                            <td>30 bulan</td>
                            <td>27 Nov 2025</td>
                            <td>11.5kg / 86cm</td>
                            <td>-2.3</td>
                            <td><span class="badge badge-warning">Pendek</span></td>
                            <td><button class="action-btn">Detail</button></td>
                        </tr>
                        <tr>
                            <td><strong>Dewi Lestari</strong></td>
                            <td>12 bulan</td>
                            <td>26 Nov 2025</td>
                            <td>8.9kg / 72cm</td>
                            <td>-0.8</td>
                            <td><span class="badge badge-normal">Normal</span></td>
                            <td><button class="action-btn">Detail</button></td>
                        </tr>
                        <tr>
                            <td><strong>Riko Prasetyo</strong></td>
                            <td>36 bulan</td>
                            <td>25 Nov 2025</td>
                            <td>12.1kg / 88cm</td>
                            <td>-2.6</td>
                            <td><span class="badge badge-danger">Sangat Pendek</span></td>
                            <td><button class="action-btn">Rujuk</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('navbarMenu');
            menu.classList.toggle('active');
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('navbarMenu');
            const toggle = document.querySelector('.navbar-toggle');

            if (!menu.contains(event.target) && !toggle.contains(event.target)) {
                menu.classList.remove('active');
            }
        });
    </script>
</body>
</html>
