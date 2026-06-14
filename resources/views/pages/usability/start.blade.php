<!DOCTYPE html>
<html lang="id">
<head>
    @include('includes.meta')
    <!-- Custom fonts for this template-->
    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800" rel="stylesheet">
    <!-- SB Admin 2 -->
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <title>Mulai Sesi Usability Testing</title>
    <style>
        body {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .usability-card {
            max-width: 540px;
            width: 100%;
        }
        .skenario-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.6rem 0;
            border-bottom: 1px solid #eaecf4;
            font-size: 0.875rem;
        }
        .skenario-item:last-child { border-bottom: none; }
        .skenario-num {
            background: #4e73df;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            flex-shrink: 0;
        }
    </style>
</head>
<body>
    <div class="usability-card">
        <div class="card o-hidden border-0 shadow-lg">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">

                            <div class="text-center mb-4">
                                <i class="fas fa-flask fa-3x text-primary mb-3"></i>
                                <h1 class="h3 text-gray-900 font-weight-bold">Usability Testing</h1>
                                <p class="text-gray-500 small">Sistem Informasi Pemantauan Gizi Balita — Posyandu</p>
                            </div>

                            <form method="POST" action="{{ route('usability.doStart') }}">
                                @csrf

                                <div class="form-group">
                                    <label class="small font-weight-bold text-gray-700">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="nama_penguji"
                                           class="form-control form-control-user"
                                           placeholder="Contoh: Budi Santoso"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label class="small font-weight-bold text-gray-700">Peran / Jabatan <span class="text-danger">*</span></label>
                                    <select name="peran" class="form-control" required>
                                        <option value="">-- Pilih peran --</option>
                                        <option value="kader">Kader Posyandu</option>
                                        <option value="admin">Admin / Bidan</option>
                                        <option value="mahasiswa">Mahasiswa (Uji Coba)</option>
                                    </select>
                                </div>

                                <!-- Daftar Skenario -->
                                <div class="card bg-light border-left-primary mb-4">
                                    <div class="card-body py-3 px-4">
                                        <p class="text-xs font-weight-bold text-primary text-uppercase mb-2">
                                            <i class="fas fa-list-ol mr-1"></i> Skenario yang Akan Diuji
                                        </p>
                                        @foreach($skenarios as $no => $nama)
                                            <div class="skenario-item">
                                                <span class="skenario-num">{{ $no }}</span>
                                                <span class="text-gray-700">{{ $nama }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    <i class="fas fa-play mr-2"></i> Mulai Sesi Pengujian
                                </button>
                            </form>

                            <hr>
                            <p class="text-center text-gray-400 small mb-0">
                                <i class="fas fa-info-circle mr-1"></i>
                                Sistem akan otomatis mencatat semua interaksi selama pengujian berlangsung
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('sb-admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sb-admin/js/sb-admin-2.min.js') }}"></script>
</body>
</html>
