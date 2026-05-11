<x-app-layout>
    <div class="main-content">
        <div class="card mb-4 bg-primary text-white rounded-0 border-0">
            <div class="card-body py-4 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="m-0 font-weight-bold">{{ $anak->nama }}</h4>
                    <p class="m-0" style="opacity:0.8">
                        {{ $anak->jk == 'L' ? 'Laki-laki' : 'Perempuan' }} •
                        {{ \Carbon\Carbon::parse($anak->tgl_lahir)->diffInMonths(now()) }} bulan
                    </p>
                </div>
                <a href="{{ route('ortu.dashboard') }}" class="btn btn-light btn-sm">← Kembali</a>
            </div>
        </div>

        <div class="container-xl mt-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Pemeriksaan</h3>
                </div>
                
                {{-- Tambah ini sebelum div card riwayat pemeriksaan --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Grafik Pertumbuhan</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="grafikPertumbuhan" height="100"></canvas>
                    </div>
                </div>

                {{-- Tambah script ini sebelum </x-app-layout> --}}
                @push('after-script')
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const ctx = document.getElementById('grafikPertumbuhan').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($chartLabels) !!},
                            datasets: [
                                {
                                    label: 'Berat Badan (kg)',
                                    data: {!! json_encode($chartBB) !!},
                                    borderColor: '#4e73df',
                                    backgroundColor: 'rgba(78,115,223,0.1)',
                                    tension: 0.3,
                                    fill: true,
                                },
                                {
                                    label: 'Tinggi Badan (cm)',
                                    data: {!! json_encode($chartTB) !!},
                                    borderColor: '#1cc88a',
                                    backgroundColor: 'rgba(28,200,138,0.1)',
                                    tension: 0.3,
                                    fill: true,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { position: 'top' } },
                            scales: { y: { beginAtZero: false } }
                        }
                    });
                </script>
                @endpush


                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Umur</th>
                                <th>Berat Badan</th>
                                <th>Tinggi Badan</th>
                                <th>Status Gizi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $periksa)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($periksa->tanggal_periksa)->format('d M Y') }}</td>
                                <td>{{ $periksa->umur_bulan }} bulan</td>
                                <td>{{ $periksa->berat_badan }} kg</td>
                                <td>{{ $periksa->tinggi_badan }} cm</td>
                                <td>
                                    @php
                                        $badge = match($periksa->status_gizi) {
                                            'Gizi Normal' => 'bg-success',
                                            'Gizi Kurang' => 'bg-warning',
                                            'Stunting'    => 'bg-danger',
                                            'Gizi Lebih'  => 'bg-primary',
                                            default       => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ $periksa->status_gizi }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data pemeriksaan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Status Imunisasi</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Vaksin</th>
                                    <th>Tanggal Diberikan</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($anak->imunisasi as $imun)
                                <tr>
                                    <td><span class="badge bg-success">{{ $imun->nama_vaksin }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($imun->tanggal_pemberian)->format('d M Y') }}</td>
                                    <td>{{ $imun->keterangan ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data imunisasi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Riwayat Vitamin A</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis Kapsul</th>
                                    <th>Bulan/Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($anak->vitaminA as $vit)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($vit->tanggal_pemberian)->format('d M Y') }}</td>
                                    <td><span class="badge {{ str_contains($vit->jenis_kapsul, 'Biru') ? 'bg-primary' : 'bg-danger' }}">
                                        {{ $vit->jenis_kapsul }}
                                    </span></td>
                                    <td>{{ $vit->bulan_pemberian }} {{ $vit->tahun_pemberian }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data vitamin A</td>
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
