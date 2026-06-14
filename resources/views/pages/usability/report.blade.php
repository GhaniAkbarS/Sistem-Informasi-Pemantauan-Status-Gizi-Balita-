<!DOCTYPE html>
<html lang="id">
<head>
    @include('includes.meta')
    <!-- Custom fonts for this template-->
    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800" rel="stylesheet">
    <!-- SB Admin 2 -->
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <!-- Chart.js -->
    <script src="{{ asset('sb-admin/vendor/chart.js/Chart.min.js') }}"></script>
    <title>Laporan Usability - {{ $sesi->nama_penguji }}</title>
    <style>
        body { background-color: #f8f9fc; }
        .score-circle {
            width: 140px; height: 140px;
            border-radius: 50%;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            font-size: 2.5rem; font-weight: 800;
            color: white; margin: 0 auto 1rem;
        }
        .score-good   { background: linear-gradient(135deg, #1cc88a, #17a673); }
        .score-medium { background: linear-gradient(135deg, #f6c23e, #dda20a); }
        .score-bad    { background: linear-gradient(135deg, #e74a3b, #be2617); }
        .score-label  { font-size: 0.75rem; opacity: 0.85; margin-top: 2px; }
        .nav-path {
            display: flex; flex-wrap: wrap;
            gap: 0.35rem; align-items: center;
        }
        .nav-node {
            background: #eaecf4; color: #4e73df;
            padding: 0.2rem 0.65rem; border-radius: 20px;
            font-size: 0.78rem; font-weight: 600;
        }
        .nav-arrow { color: #b7b9cc; font-size: 0.8rem; }
        @media print {
            .btn-print, .no-print { display: none !important; }
            body { background: white; }
        }
    </style>
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column" style="margin-left: 0;">
        <div id="content">

            <!-- TopBar / Header -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <div class="container-fluid">
                    <div>
                        <h5 class="mb-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-bar mr-2"></i>Laporan Usability Testing
                        </h5>
                        <small class="text-gray-500">{{ $sesi->nama_penguji }} &mdash; {{ $sesi->mulai_at->format('d M Y') }}</small>
                    </div>
                    <button class="btn btn-primary btn-sm ml-auto btn-print" onclick="window.print()">
                        <i class="fas fa-print mr-1"></i> Cetak / Simpan PDF
                    </button>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid">

                <!-- Skor Utama -->
                @php
                    $scoreClass = $usabilityScore >= 70 ? 'score-good' : ($usabilityScore >= 40 ? 'score-medium' : 'score-bad');
                    $scoreKet   = $usabilityScore >= 70 ? 'Mudah Digunakan' : ($usabilityScore >= 40 ? 'Cukup Mudah' : 'Perlu Perbaikan');
                @endphp
                <div class="card shadow mb-4">
                    <div class="card-body text-center py-4">
                        <div class="score-circle {{ $scoreClass }}">
                            <span>{{ $usabilityScore }}</span>
                            <span class="score-label">/100</span>
                        </div>
                        <h4 class="font-weight-bold text-gray-800 mb-1">Skor Usability: {{ $scoreKet }}</h4>
                        <p class="text-gray-500 small mb-0">Berdasarkan Task Completion Rate, Error Rate, dan Navigasi</p>
                    </div>
                </div>

                <!-- Metrik Ringkasan -->
                <div class="row">
                    <!-- Task Completion Rate -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Task Completion Rate</div>
                                        <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $completionRate }}%</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Error Rate -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Error Rate</div>
                                        <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $errorRate }}%</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Navigasi Balik -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Navigasi Kembali (Back)</div>
                                        <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $totalBack }}x</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-undo fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Total Durasi -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Durasi Sesi</div>
                                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                                            {{ $sesi->durasi_detik ? gmdate("i:s", $sesi->durasi_detik) : '-' }}
                                        </div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Halaman Dikunjungi -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Halaman Dikunjungi</div>
                                        <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $totalPages }}</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-file-alt fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Total Error -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Error / Klik Salah</div>
                                        <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $totalError }}</div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-times-circle fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Grafik -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-chart-bar mr-1"></i> Grafik Ringkasan Aktivitas
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="chartActivity" height="120"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Donut Task Completion -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-tasks mr-1"></i> Task Completion
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-pie pt-2 pb-2">
                                    <canvas id="chartCompletion"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <span class="mr-2"><i class="fas fa-circle text-success"></i> Selesai</span>
                                    <span class="mr-2"><i class="fas fa-circle text-danger"></i> Tidak Selesai</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Penguji -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-user mr-1"></i> Informasi Penguji
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <small class="text-gray-500">Nama</small>
                                <p class="font-weight-bold mb-2">{{ $sesi->nama_penguji }}</p>
                            </div>
                            <div class="col-md-3">
                                <small class="text-gray-500">Peran</small>
                                <p class="font-weight-bold mb-2">{{ ucfirst($sesi->peran) }}</p>
                            </div>
                            <div class="col-md-3">
                                <small class="text-gray-500">Mulai</small>
                                <p class="font-weight-bold mb-2">{{ $sesi->mulai_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="col-md-3">
                                <small class="text-gray-500">Selesai</small>
                                <p class="font-weight-bold mb-2">{{ $sesi->selesai_at ? $sesi->selesai_at->format('d M Y, H:i') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hasil per Skenario -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-list-check mr-1"></i> Hasil per Skenario
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($taskResults->count())
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Skenario</th>
                                        <th>Status</th>
                                        <th>Durasi</th>
                                        <th>Jumlah Error</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($taskResults->sortBy('task_number') as $task)
                                    <tr>
                                        <td>{{ $task->task_number }}</td>
                                        <td>{{ $task->task_name }}</td>
                                        <td>
                                            @if($task->berhasil)
                                                <span class="badge badge-success">✓ Berhasil</span>
                                            @else
                                                <span class="badge badge-danger">✗ Tidak Berhasil</span>
                                            @endif
                                        </td>
                                        <td>{{ $task->durasi_detik ? gmdate("i:s", $task->durasi_detik) . ' mnt' : '-' }}</td>
                                        <td>{{ $task->jumlah_error }}x</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <p class="text-gray-500 small mb-0">Belum ada data skenario yang diselesaikan.</p>
                        @endif
                    </div>
                </div>

                <!-- Navigation Path -->
                @if(count($navPath))
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-route mr-1"></i> Jalur Navigasi Penguji
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="nav-path">
                            @foreach($navPath as $page)
                                <span class="nav-node">{{ $page }}</span>
                                @if(!$loop->last)
                                    <span class="nav-arrow">→</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

            </div>
            <!-- End Main Content -->
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="{{ asset('sb-admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('sb-admin/js/sb-admin-2.min.js') }}"></script>

<script>
// Set default font agar sesuai SB Admin
Chart.defaults.global.defaultFontFamily = 'Nunito, -apple-system, system-ui, sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Bar Chart - Ringkasan Aktivitas
var ctx1 = document.getElementById('chartActivity');
new Chart(ctx1, {
    type: 'horizontalBar',
    data: {
        labels: ['Halaman Dikunjungi', 'Total Klik', 'Error', 'Navigasi Balik'],
        datasets: [{
            label: 'Jumlah',
            data: [{{ $totalPages }}, {{ $totalClicks }}, {{ $totalError }}, {{ $totalBack }}],
            backgroundColor: ['#4e73df', '#1cc88a', '#e74a3b', '#f6c23e'],
            borderColor: ['#3a5fc8', '#17a673', '#be2617', '#dda20a'],
            borderWidth: 1,
        }]
    },
    options: {
        maintainAspectRatio: false,
        legend: { display: false },
        tooltips: {
            backgroundColor: 'rgb(255,255,255)',
            bodyFontColor: '#858796',
            borderColor: '#dddfeb',
            borderWidth: 1,
        },
        scales: {
            xAxes: [{ ticks: { beginAtZero: true, precision: 0 } }]
        }
    }
});

// Pie Chart - Task Completion
var ctx2 = document.getElementById('chartCompletion');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Selesai', 'Tidak Selesai'],
        datasets: [{
            data: [{{ $completionRate }}, {{ 100 - $completionRate }}],
            backgroundColor: ['#1cc88a', '#e74a3b'],
            hoverBackgroundColor: ['#17a673', '#be2617'],
            hoverBorderColor: 'rgba(234, 236, 244, 1)',
        }]
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: 'rgb(255,255,255)',
            bodyFontColor: '#858796',
            borderColor: '#dddfeb',
            borderWidth: 1,
        },
        legend: { display: false },
        cutoutPercentage: 80,
    }
});
</script>
</body>
</html>
