<x-app-layout>
    <div class="main-content">
        <div class="card mb-4 bg-primary text-white rounded-0 border-0">
            <div class="card-body py-5 d-flex justify-content-between align-items-center">
                <div class="px-3">
                    <h4 class="m-0 font-weight-bold">Edit Data Pemeriksaan</h4>
                    <p class="m-0" style="opacity: 0.8;">{{ session('posyandu_nama') }}</p>
                </div>
            </div>
        </div>

        <div class="container-xl mt-4">
            <form class="card" action="{{ route('periksa.update', $periksa->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-header">
                    <h3 class="card-title">Form Edit Pemeriksaan</h3>
                </div>
                <div class="card-body">
                    <div class="row row-cards">
                        <div class="col-md-12 mb-3">
                            <input type="hidden" name="balita_id" value="{{ $periksa->balita_id }}">
                            <label class="form-label">Nama Lengkap Balita</label>
                            <input type="text" class="form-control" value="{{ $periksa->balita->nama }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Periksa</label>
                            <input type="date" name="tgl_periksa" class="form-control"
                                value="{{ old('tgl_periksa', \Carbon\Carbon::parse($periksa->tanggal_periksa)->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tinggi Badan (cm)</label>
                            <input type="number" step="0.1" name="tinggi_badan" class="form-control" value="{{ old('tinggi_badan', $periksa->tinggi_badan) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Berat Badan (kg)</label>
                            <input type="number" step="0.1" name="berat_badan" class="form-control" value="{{ old('berat_badan', $periksa->berat_badan) }}" required>                        
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('periksa.index') }}" class="btn btn-link link-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary ms-auto">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');

        form.addEventListener('submit', function (e) {
                let isValid = true;

                const fields = [
                    { name: 'tgl_periksa',  label: 'Tanggal Periksa' },
                    { name: 'tinggi_badan', label: 'Tinggi Badan'     },
                    { name: 'berat_badan',  label: 'Berat Badan'      },
                ];

                fields.forEach(function (field) {
                    const input   = document.querySelector(`[name="${field.name}"]`);
                    const errorId = 'error-' + field.name;
                    const oldErr  = document.getElementById(errorId);
                    if (oldErr) oldErr.remove();
                    input.classList.remove('is-invalid');

                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add('is-invalid');

                        const div = document.createElement('div');
                        div.id        = errorId;
                        div.className = 'invalid-feedback d-block';
                        div.textContent = field.label + ' tidak boleh kosong.';
                        input.closest('.mb-3').appendChild(div);
                    }
                });

                if (!isValid) e.preventDefault();
            });

            // Hapus error saat user mengisi
            document.querySelectorAll('input[name="tgl_periksa"], input[name="tinggi_badan"], input[name="berat_badan"]').forEach(function (el) {
                ['change', 'input'].forEach(function (evt) {
                    el.addEventListener(evt, function () {
                        this.classList.remove('is-invalid');
                        const err = document.getElementById('error-' + this.name);
                        if (err) err.remove();
                    });
                });
            });
        });
    </script>

</x-app-layout>
