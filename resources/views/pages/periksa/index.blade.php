<x-app-layout>
    <div class="main-content">
        <!-- Perubahan: Update struktur tabel menggunakan class Tabler, perbaiki dropdown, dan hapus custom CSS/JS -->
        <div class="header">
            <div class="header-content">
                <div>
                    <h1>Data Pemeriksaan</h1>
                    <p style="font-size: 14px; opacity: 0.9; margin-top: 5px;">RW 03, Kelurahan Sidomulyo Timur</p>
                </div>
                <div class="header-info">
                    <p><strong>Kader:</strong> {{ ucfirst(session('user')) }}</p>
                    <p style="opacity: 0.9;">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="container-xl mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Pemeriksaan</h3>
                        <div class="card-actions">
                            <a href="{{ route('periksa.create') }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                Tambah Data
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success m-3" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
</x-app-layout>