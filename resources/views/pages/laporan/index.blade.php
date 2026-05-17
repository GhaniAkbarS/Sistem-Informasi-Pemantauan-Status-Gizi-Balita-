<x-app-layout>
<div class="main-content">

    {{-- Header Banner --}}
    <div class="card mb-4 bg-primary text-white rounded-0 border-0">
        <div class="card-body py-5 d-flex justify-content-between align-items-center">
            <div class="px-3">
                <h4 class="m-0 font-weight-bold">Laporan</h4>
                <p class="m-0" style="opacity:0.8;">{{ session('posyandu_nama') }}</p>
            </div>
            <div class="text-right px-3">
                <p class="m-0"><strong>Kader:</strong> {{ ucfirst(auth()->user()->name) }}</p>
                <p class="m-0" style="opacity:0.8;">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
    </div>

    <div class="container-xl mt-4">

        {{-- Filter Bulan & Tahun (global) --}}
        <div class="card mb-4">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('laporan.index') }}" class="d-flex align-items-center flex-wrap gap-2">
                    <span class="fw-bold me-1">Filter:</span>

                    <select name="bulan" class="form-select form-select-sm" style="width:auto;">
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->locale('id')->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>

                    <select name="tahun" class="form-select form-select-sm" style="width:auto;">
                        @forelse($tahunList as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @empty
                            <option value="{{ now()->year }}" selected>{{ now()->year }}</option>
                        @endforelse
                    </select>

                    <button type="submit" class="btn btn-primary btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7"/><line x1="21" y1="21" x2="15" y2="15"/></svg>
                        Terapkan Filter
                    </button>
                </form>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs mb-0" id="laporanTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab-periksa" data-bs-toggle="tab" href="#periksa" role="tab">
                    📋 Pemeriksaan Gizi
                    <span class="badge bg-primary ms-1">{{ $periksas->count() }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-balita" data-bs-toggle="tab" href="#balita" role="tab">
                    👶 Data Balita & Ortu
                    <span class="badge bg-success ms-1">{{ $balitas->count() }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-imunisasi" data-bs-toggle="tab" href="#imunisasi" role="tab">
                    💉 Imunisasi
                    <span class="badge bg-warning ms-1">{{ $imunisasis->count() }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-vitamina" data-bs-toggle="tab" href="#vitamina" role="tab">
                    🟠 Vitamin A
                    <span class="badge bg-danger ms-1">{{ $vitamins->count() }}</span>
                </a>
            </li>
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content card border-top-0 rounded-top-0" id="laporanTabContent">

            {{-- ══ TAB 1: PEMERIKSAAN GIZI ══ --}}
            <div class="tab-pane fade show active p-0" id="periksa" role="tabpanel">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Hasil Pemeriksaan — {{ \Carbon\Carbon::create()->month($bulan)->locale('id')->translatedFormat('F') }} {{ $tahun }}</span>
                    <a href="{{ route('laporan.cetak', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                       target="_blank" class="btn btn-danger btn-sm">
                        🖨️ Cetak PDF
                    </a>
                </div>
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
                            @forelse($periksas as $i => $p)
                            @php
                                $tb_m = $p->tinggi_badan / 100;
                                $imt  = $tb_m > 0 ? $p->berat_badan / ($tb_m * $tb_m) : 0;
                                $badgeColor = match($p->status_gizi) {
                                    'Gizi Normal' => 'bg-success',
                                    'Stunting'    => 'bg-danger',
                                    'Gizi Kurang' => 'bg-warning',
                                    'Gizi Lebih'  => 'bg-orange',
                                    default       => 'bg-secondary'
                                };
                            @endphp
                            <tr>
                                <td><span class="text-secondary">{{ $i+1 }}</span></td>
                                <td>{{ $p->balita->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_periksa)->format('d/m/Y') }}</td>
                                <td>{{ $p->umur_bulan }} Bln</td>
                                <td>{{ $p->berat_badan }}</td>
                                <td>{{ $p->tinggi_badan }}</td>
                                <td>{{ number_format($imt, 1) }}</td>
                                <td>
                                    <span class="badge {{ $badgeColor }} me-1"></span>
                                    {{ $p->status_gizi }}
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center p-4 text-muted">Tidak ada data pemeriksaan untuk periode ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ══ TAB 2: DATA BALITA & ORTU ══ --}}
            <div class="tab-pane fade p-0" id="balita" role="tabpanel">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Data Seluruh Balita Terdaftar</span>
                    <a href="{{ route('laporan.cetak.balita') }}"
                       target="_blank" class="btn btn-success btn-sm">
                        🖨️ Cetak PDF
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th class="w-1">No.</th>
                                <th>Nama Anak</th>
                                <th>JK</th>
                                <th>Tgl Lahir</th>
                                <th>Umur (Bln)</th>
                                <th>Nama Orang Tua</th>
                                <th>BB (kg)</th>
                                <th>TB (cm)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($balitas as $i => $b)
                            <tr>
                                <td><span class="text-secondary">{{ $i+1 }}</span></td>
                                <td>{{ $b->nama }}</td>
                                <td>{{ $b->jk }}</td>
                                <td>{{ \Carbon\Carbon::parse($b->tgl_lahir)->format('d/m/Y') }}</td>
                                <td>{{ $b->umur }}</td>
                                <td>{{ $b->nama_ortu }}</td>
                                <td>{{ $b->berat_badan }}</td>
                                <td>{{ $b->tinggi_badan }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center p-4 text-muted">Belum ada data balita.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ══ TAB 3: IMUNISASI ══ --}}
            <div class="tab-pane fade p-0" id="imunisasi" role="tabpanel">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Data Imunisasi Tahun {{ $tahun }}</span>
                    <a href="{{ route('laporan.cetak.imunisasi', ['tahun' => $tahun]) }}"
                       target="_blank" class="btn btn-warning btn-sm">
                        🖨️ Cetak PDF
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th class="w-1">No.</th>
                                <th>Nama Anak</th>
                                <th>Nama Vaksin</th>
                                <th>Tanggal Pemberian</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($imunisasis as $i => $item)
                            <tr>
                                <td><span class="text-secondary">{{ $i+1 }}</span></td>
                                <td>{{ $item->balita->nama ?? '-' }}</td>
                                <td>{{ $item->nama_vaksin }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_pemberian)->format('d/m/Y') }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center p-4 text-muted">Tidak ada data imunisasi untuk tahun ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ══ TAB 4: VITAMIN A ══ --}}
            <div class="tab-pane fade p-0" id="vitamina" role="tabpanel">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Data Pemberian Vitamin A Tahun {{ $tahun }}</span>
                    <a href="{{ route('laporan.cetak.vitamina', ['tahun' => $tahun]) }}"
                       target="_blank" class="btn btn-danger btn-sm">
                        🖨️ Cetak PDF
                    </a>
                </div>
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
                            @forelse($vitamins as $i => $item)
                            <tr>
                                <td><span class="text-secondary">{{ $i+1 }}</span></td>
                                <td>{{ $item->balita->nama ?? '-' }}</td>
                                <td>{{ $item->jenis_kapsul }}</td>
                                <td>{{ $item->bulan_pemberian }}</td>
                                <td>{{ $item->tahun_pemberian }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_pemberian)->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center p-4 text-muted">Tidak ada data vitamin A untuk tahun ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>{{-- end tab-content --}}
    </div>{{-- end container-xl --}}
</div>{{-- end main-content --}}
</x-app-layout>
