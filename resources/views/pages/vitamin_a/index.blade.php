<x-app-layout>
    <div class="main-content">
        <div class="card mb-4 bg-primary text-white rounded-0 border-0">
            <div class="card-body py-5 d-flex justify-content-between align-items-center">
                <div class="px-3">
                    <h4 class="m-0 font-weight-bold">Data Vitamin A</h4>
                    <p class="m-0" style="opacity: 0.8;">{{ session('posyandu_nama') }}</p>
                </div>
                <div class="text-right px-3">
                    <p class="m-0"><strong>Kader:</strong> {{ ucfirst(session('user')) }}</p>
                    <p class="m-0" style="opacity: 0.8;">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="container-xl mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Daftar Pemberian Vitamin A</h3>
                        <a href="{{ route('vitamina.create') }}" class="btn btn-primary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                            Tambah Data
                        </a>
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success m-3">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th class="w-1">No.</th>
                                    <th>Nama Anak</th>
                                    <th>Jenis Kapsul</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Tanggal Pemberian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vitamins as $index => $item)
                                <tr>
                                    <td><span class="text-secondary">{{ $index + 1 }}</span></td>
                                    <td>{{ $item->balita->nama ?? '-' }}</td>
                                    <td>{{ $item->jenis_kapsul }}</td>
                                    <td>{{ $item->bulan_pemberian }}</td>
                                    <td>{{ $item->tahun_pemberian }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pemberian)->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center p-4 text-muted">Belum ada data vitamin A.</td>
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
