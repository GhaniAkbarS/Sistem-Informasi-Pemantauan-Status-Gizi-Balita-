<x-app-layout>
    <div class="main-content">
        {{-- Header Banner --}}
        <div class="card mb-4 bg-primary text-white rounded-0 border-0">
            <div class="card-body py-5 d-flex justify-content-between align-items-center">
                <div class="px-3">
                    <h4 class="m-0 font-weight-bold">Laporan</h4>
                    <p class="m-0" style="opacity: 0.8;">RW 03, Kelurahan Sidomulyo Timur</p>
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
                    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <h3 class="card-title mb-0">Laporan Hasil Pemeriksaan</h3>

                        {{-- Filter Bulan/Tahun + Tombol Aksi --}}
                        <form method="GET" action="{{ route('laporan.index') }}" class="d-flex align-items-center gap-2 flex-wrap">
                            <select name="bulan" class="form-select form-select-sm" style="width: auto;">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($m)->locale('id')->translatedFormat('F') }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="tahun" class="form-select form-select-sm" style="width: auto;">
                                @foreach($tahunList as $t)
                                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                                @if($tahunList->isEmpty())
                                    <option value="{{ now()->year }}" selected>{{ now()->year }}</option>
                                @endif
                            </select>

                            <button type="submit" class="btn btn-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7"/><line x1="21" y1="21" x2="15" y2="15"/></svg>
                                Filter
                            </button>

                            <a href="{{ route('laporan.cetak', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                               target="_blank"
                               class="btn btn-danger btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"/><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"/><rect x="7" y="13" width="10" height="8" rx="2"/></svg>
                                Cetak PDF
                            </a>
                        </form>
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
                                    <th class="w-1">No.</th>
                                    <th>Nama Anak</th>
                                    <th>Tgl Periksa</th>
                                    <th>Umur</th>
                                    <th>BB (kg)</th>
                                    <th>TB (cm)</th>
                                    <th>IMT</th>
                                    <th>Status Gizi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($periksas as $index => $periksa)
                                <tr>
                                    <td><span class="text-secondary">{{ $index + 1 }}</span></td>
                                    <td>{{ $periksa->balita->nama ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($periksa->tanggal_periksa)->format('d/m/Y') }}</td>
                                    <td>{{ $periksa->umur_bulan }} Bulan</td>
                                    <td>{{ $periksa->berat_badan }}</td>
                                    <td>{{ $periksa->tinggi_badan }}</td>
                                    <td>
                                        @php
                                            $tb_m = $periksa->tinggi_badan / 100;
                                            $imt = $tb_m > 0 ? $periksa->berat_badan / ($tb_m * $tb_m) : 0;
                                        @endphp
                                        {{ number_format($imt, 1) }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $periksa->status_gizi == 'Gizi Normal' ? 'bg-success' : ($periksa->status_gizi == 'Stunting' ? 'bg-danger' : 'bg-warning') }} me-1"></span>
                                        {{ $periksa->status_gizi }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center p-4 text-muted">
                                        Tidak ada data pemeriksaan untuk bulan/tahun yang dipilih.
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