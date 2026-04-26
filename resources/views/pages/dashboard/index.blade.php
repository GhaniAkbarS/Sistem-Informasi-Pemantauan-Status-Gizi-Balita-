    <x-app-layout>
    <div class="main-content">
        <!-- Basic Card Example -->
        <div class="card mb-4 bg-primary text-white rounded-0 border-0">
            <div class="card-body py-5 d-flex justify-content-between align-items-center">
                <div class="px-3">
                    <h4 class="m-0 font-weight-bold">Data Pemeriksaan</h4>
                    <p class="m-0" style="opacity: 0.8;">RW 03, Kelurahan Sidomulyo Timur</p>
                </div>

            </div>
        </div>

        <div class="container">
            <!-- Alert Notifikasi Stunting -->
            <div class="alert-box">

                <div class="alert-content">
                    <h3>Perhatian: Terdeteksi Kasus Berisiko Stunting</h3>
                    <p>3 balita memerlukan perhatian khusus dan rujukan ke Puskesmas</p>
                </div>
            </div>

            <!-- PERUBAHAN: Menampilkan angka yang benar-benar berasal dari database (dinamis) -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total Balita Terdaftar</span>
                    </div>
                    <div class="stat-value">{{ $totalBalita }}</div>
                    <div class="stat-subtitle">Total balita aktif di sistem</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Pemeriksaan Bulan Ini</span>
                    </div>
                    <div class="stat-value">{{ $pemeriksaanBulanIni }}</div>
                    <div class="stat-subtitle">Diperiksa pada bulan ini</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Status Gizi Normal</span>
                    </div>
                    <div class="stat-value">{{ $giziNormal }}</div>
                    <div class="stat-subtitle">Berdasarkan riwayat periksa</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Perlu Rujukan</span>
                    </div>
                    <div class="stat-value">{{ $perluRujukan }}</div>
                    <div class="stat-subtitle">Stunting / Sangat Pendek</div>
                </div>
            </div>
            <!-- AKHIR PERUBAHAN -->

            <!-- Grafik dan Breakdown -->
            <div class="charts-section">
                <div class="chart-card">
                    <h2>Tren Pemeriksaan 6 Bulan Terakhir</h2>
                    <!-- PERUBAHAN: Menghapus placeholder teks dan menggantinya dengan elemen canvas untuk menampilkan grafik Chart.js -->
                    <div class="chart-area" style="height: 300px;">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                    <!-- AKHIR PERUBAHAN -->
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
                <h2>Pemeriksaan Terbaru</h2>
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
                        @forelse($recentExaminations as $periksa)
                        <tr>
                            <td><strong>{{ $periksa->balita->nama ?? 'N/A' }}</strong></td>
                            <td>{{ $periksa->umur_bulan }} bulan</td>
                            <td>{{ \Carbon\Carbon::parse($periksa->tanggal_periksa)->format('d M Y') }}</td>
                            <td>{{ $periksa->berat_badan }}kg / {{ $periksa->tinggi_badan }}cm</td>
                            <td>-</td>
                            <td>
                                @php
                                    $badgeClass = 'badge-secondary';
                                    if(in_array($periksa->status_gizi, ['Stunting', 'Sangat Pendek'])) $badgeClass = 'badge-danger';
                                    elseif($periksa->status_gizi == 'Gizi Kurang') $badgeClass = 'badge-warning';
                                    elseif($periksa->status_gizi == 'Gizi Normal') $badgeClass = 'badge-success';
                                    elseif($periksa->status_gizi == 'Gizi Lebih') $badgeClass = 'badge-primary';
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $periksa->status_gizi }}</span>
                            </td>
                            <td><a href="{{ route('periksa.edit', $periksa->id) }}" class="action-btn">Detail</a></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada pemeriksaan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- PERUBAHAN: Memindahkan directive push ke dalam komponen x-app-layout agar dikenali oleh Laravel Blade -->
@push('after-script')
<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["Jun", "Jul", "Agt", "Sep", "Okt", "Nov"],
    datasets: [{
      label: "Total Pemeriksaan",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [58, 61, 65, 67, 63, 62], // Mensuplai data sesuai dengan teks dari placeholder sebelumnya
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + ': ' + tooltipItem.yLabel;
        }
      }
    }
  }
});
</script>
@endpush
<!-- AKHIR PERUBAHAN -->
</x-app-layout>
