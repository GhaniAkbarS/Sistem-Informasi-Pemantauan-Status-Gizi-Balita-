
<x-app-layout>
    
    <div class="main-content">
        <!-- Basic Card Example -->
        <div class="card mb-4 bg-primary text-white rounded-0 border-0">
            <div class="card-body py-5 d-flex justify-content-between align-items-center">
                <div class="px-3">
                    <h4 class="m-0 font-weight-bold">Data Pemeriksaan</h4>
                    <p class="m-0" style="opacity: 0.8;">{{ session('posyandu_nama') }}</p>
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
                    <form class="card" action="{{ route('periksa.store') }}" method="post">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">Form Data Pemeriksaan</h3>
                        </div>
                        <div class="card-body">
                            <div class="row row-cards">
                                <!-- Baris 1: Nama & Tanggal -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Anak</label>
                                        <!-- Placeholder select, nanti bisa diisi data dari controller -->
                                        <select class="form-select" name="balita_id">
                                            <option value="">Pilih Nama Anak</option>
                                            @foreach ($balitas as $balita)
                                                <option value="{{ $balita->id }}">{{ $balita->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @include('pages.periksa.riwayat_anak')
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Pemeriksaan</label>
                                        <input type="date" class="form-control" name="tgl_periksa" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>

                                <!-- Baris 2: Data Fisik -->
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Berat Badan (kg)</label>
                                        <input type="number" step="0.01" class="form-control" name="berat_badan" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Tinggi Badan (cm)</label>
                                        <input type="number" step="0.01" class="form-control" name="tinggi_badan" placeholder="0.00">
                                    </div>
                                </div>
                                    
                                <!-- Baris 3: Catatan -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Catatan Tambahan</label>
                                        <textarea class="form-control" name="catatan" rows="3" placeholder="Tulis catatan hasil pemeriksaan jika ada..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('periksa.index') }}" class="btn btn-link link-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                Simpan Pemeriksaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@push('after-script')
<script>
document.querySelector('select[name="balita_id"]').addEventListener('change', function () {
    const balitaId = this.value;
    const container = document.getElementById('riwayat-container');

    if (!balitaId) {
        container.style.display = 'none';
        return;
    }

    fetch(`/periksa/riwayat-anak/${balitaId}`)
        .then(res => res.json())
        .then(data => {
            const fmt = (tgl) => tgl
                ? new Date(tgl).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })
                : '-';

            const statusBadge = (status) => {
                const color = status === 'Gizi Baik' ? 'success'
                    : (status === 'Stunting' || status === 'Gizi Buruk') ? 'danger'
                    : 'warning';
                return `<span class="badge bg-${color}">${status ?? '-'}</span>`;
            };

            // Render Pemeriksaan
            document.getElementById('badge-periksa').textContent = data.periksa.length;
            document.getElementById('list-periksa').innerHTML = data.periksa.length
                ? data.periksa.map(p => `
                    <tr>
                        <td>${fmt(p.tanggal)}</td>
                        <td>${p.berat_badan ?? '-'}</td>
                        <td>${p.tinggi_badan ?? '-'}</td>
                        <td>${statusBadge(p.status_gizi)}</td>
                    </tr>`).join('')
                : `<tr><td colspan="4" class="text-center text-muted py-3">Belum ada data pemeriksaan</td></tr>`;

            // Render Imunisasi
            document.getElementById('badge-imunisasi').textContent = data.imunisasi.length;
            document.getElementById('list-imunisasi').innerHTML = data.imunisasi.length
                ? data.imunisasi.map(i => `
                    <tr>
                        <td>${fmt(i.tanggal)}</td>
                        <td>${i.nama_vaksin ?? '-'}</td>
                        <td>${i.keterangan ?? '-'}</td>
                    </tr>`).join('')
                : `<tr><td colspan="3" class="text-center text-muted py-3">Belum ada data imunisasi</td></tr>`;

            // Render Vitamin A
            document.getElementById('badge-vitamin').textContent = data.vitamin_a.length;
            document.getElementById('list-vitamin').innerHTML = data.vitamin_a.length
                ? data.vitamin_a.map(v => `
                    <tr>
                        <td>${fmt(v.tanggal)}</td>
                        <td>${v.jenis_kapsul ? 'Kapsul ' + v.jenis_kapsul : '-'}</td>
                    </tr>`).join('')
                : `<tr><td colspan="2" class="text-center text-muted py-3">Belum ada data vitamin A</td></tr>`;

            container.style.display = 'block';
        });
});
</script>
@endpush

</x-app-layout>
