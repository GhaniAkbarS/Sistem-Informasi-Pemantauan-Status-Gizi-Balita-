<x-app-layout>
    <div class="main-content">
        <!-- Header Card -->
        <div class="card mb-4 bg-primary text-white rounded-0 border-0">
            <div class="card-body py-5 d-flex justify-content-between align-items-center">
                <div class="px-3">
                    <h4 class="m-0 font-weight-bold">Input Data Balita</h4>
                    <p class="m-0" style="opacity: 0.8;">RW 03, Kelurahan Sidomulyo Timur</p>
                </div>
                <div class="text-right px-3">
                    <p class="m-0"><strong>Kader:</strong> {{ ucfirst(session('user')) }}</p>
                    <p class="m-0" style="opacity: 0.8;">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="container-xl mt-4">
            <div class="row row-cards">
                <div class="col-12">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form class="card" action="{{ route('balita.store') }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">Form Data Balita</h3>
                        </div>
                        <div class="card-body">
                            <div class="row row-cards">
                                <!-- Nama Balita -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap Balita</label>
                                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama lengkap balita" required>
                                    </div>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control" required>
                                    </div>
                                </div>

                                <!-- Umur (Bulan) -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="umur" class="form-label">Umur (Bulan)</label>
                                        <input type="number" id="umur" name="umur" class="form-control" placeholder="Terisi otomatis" required>
                                        <small class="form-hint text-muted">*Dihitung otomatis per hari ini</small>
                                    </div>
                                </div>

                                <!-- Nama Orang Tua -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="nama_ortu" class="form-label">Nama Orang Tua (Ibu/Ayah)</label>
                                        <input type="text" id="nama_ortu" name="nama_ortu" class="form-control" placeholder="Masukkan nama orang tua" required>
                                    </div>
                                </div>

                                <!-- Tinggi Badan -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                                        <input type="number" step="0.1" id="tinggi_badan" name="tinggi_badan" class="form-control" placeholder="Contoh: 85.5" required>
                                    </div>
                                </div>

                                <!-- Berat Badan -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                                        <input type="number" step="0.1" id="berat_badan" name="berat_badan" class="form-control" placeholder="Contoh: 10.5" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer text-end">
                            <a href="{{ route('balita.index') ?? '#' }}" class="btn btn-link link-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tglLahirInput = document.getElementById('tgl_lahir');
            const umurInput = document.getElementById('umur');

            function hitungUmur() {
                const nilaiTanggal = tglLahirInput.value;
                if (!nilaiTanggal) return; // Jangan hitung jika kosong

                const tglLahir = new Date(nilaiTanggal);
                const today = new Date();
                
                if (isNaN(tglLahir.getTime())) return;

                let months = (today.getFullYear() - tglLahir.getFullYear()) * 12;
                months -= tglLahir.getMonth();
                months += today.getMonth();

                // Koreksi jika tanggal hari ini belum melewati tanggal lahir di bulan ini
                if (today.getDate() < tglLahir.getDate()) {
                    months--;
                }

                // Pastikan tidak negatif
                if (months < 0) months = 0;

                umurInput.value = months;
            }

            // Dengarkan berbagai jenis event agar lebih responsif
            tglLahirInput.addEventListener('change', hitungUmur);
            tglLahirInput.addEventListener('input', hitungUmur);
            tglLahirInput.addEventListener('keyup', hitungUmur);
        });
    </script>
</x-app-layout>