    <x-app-layout>
    <div class="main-content">
        <div class="header">
            <div class="header-content">
                <div>
                    <h1>Dashboard Posyandu Cendrawasih</h1>
                    <p style="font-size: 14px; opacity: 0.9; margin-top: 5px;">RW 03, Kelurahan Sidomulyo Timur</p>
                </div>
                <div class="header-info">
                    <p><strong>Kader:</strong> {{ ucfirst(session('user')) }}</p>
                    <p style="opacity: 0.9;">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Alert Notifikasi Stunting -->
            <div class="alert-box">

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

                    </div>
                    <div class="stat-value">{{$totalBalita}}</div>
                    <div class="stat-subtitle">Balita aktif per November 2025</div>
                    <span class="stat-trend trend-up">↑ +5 bulan ini</span>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Pemeriksaan Bulan Ini</span>

                    </div>
                    <div class="stat-value">62</div>
                    <div class="stat-subtitle">Dari 87 balita (71%)</div>
                    <span class="stat-trend trend-down">↓ -8% vs bulan lalu</span>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Status Gizi Normal</span>

                    </div>
                    <div class="stat-value">68</div>
                    <div class="stat-subtitle">78% dari total balita</div>
                    <span class="stat-trend trend-up">↑ +2% vs bulan lalu</span>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Perlu Rujukan</span>

                    </div>
                    <div class="stat-value">3</div>
                    <div class="stat-subtitle">Risiko tinggi stunting</div>
                    <span class="stat-trend trend-down" style="background: #d1fae5; color: #065f46;">↓ -1 dari bulan lalu</span>
                </div>
            </div>

            <!-- Grafik dan Breakdown -->
            <div class="charts-section">
                <div class="chart-card">
                    <h2>Tren Pemeriksaan 6 Bulan Terakhir</h2>
                    <div class="chart-placeholder">
                        [Grafik Garis: Jun: 58 | Jul: 61 | Agt: 65 | Sep: 67 | Okt: 63 | Nov: 62]
                    </div>
                </div>

                <div class="chart-card">
                    <h2>Distribusi Status Gizi</h2>
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
                <h2>Pemeriksaan Terbaru (7 Hari Terakhir)</h2>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
