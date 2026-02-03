<x-app-layout>
    <div class="main-content">
        <!-- Perubahan: Update struktur tabel menggunakan class Tabler, perbaiki dropdown, dan hapus custom CSS/JS -->
        <div class="header">
            <div class="header-content">
                <div>
                    <h1>Data Balita</h1>
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
                        <h3 class="card-title">Daftar Balita</h3>
                        <div class="card-actions">
                            <a href="{{ route('balita.create') }}" class="btn btn-primary">
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

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th class="w-1">No</th>
                                    <th>Nama Balita</th>
                                    <th>Tgl Lahir</th>
                                    <th>Umur (Bln)</th>
                                    <th>Nama Ortu</th>
                                    <th>BB (kg)</th>
                                    <th>TB (cm)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($balitas as $index => $balita)
                                <tr>
                                    <td><span class="text-secondary">{{ $index + 1 }}</span></td>
                                    <td>{{ $balita->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($balita->tgl_lahir)->format('d/m/Y') }}</td>
                                    <td>{{ $balita->umur }}</td>
                                    <td>{{ $balita->nama_ortu }}</td>
                                    <td>{{ $balita->berat_badan }}</td>
                                    <td>{{ $balita->tinggi_badan }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                                Aksi
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('balita.edit', $balita->id) }}">
                                                    Edit
                                                </a>
                                                <form action="{{ route('balita.destroy', $balita->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE') <!-- @method('DELETE') harus diluar button delete -->
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center p-4 text-muted">
                                        Belum ada data balita. Silakan tambah data baru.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>