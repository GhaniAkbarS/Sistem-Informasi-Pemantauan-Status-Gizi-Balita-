<x-app-layout>
    <div class="main-content">
        <div class="card mb-4 bg-primary text-white rounded-0 border-0">
            <div class="card-body py-5 px-4">
                <h4 class="m-0 font-weight-bold">Input Vitamin A</h4>
                <p class="m-0" style="opacity:0.8">{{ session('posyandu_nama') }}</p>
            </div>
        </div>

        <div class="container-xl mt-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form class="card" action="{{ route('vitamina.store') }}" method="POST">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">Form Pemberian Vitamin A</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Anak</label>
                            <select name="balita_id" class="form-select @error('balita_id') is-invalid @enderror" required>
                                <option value="">Pilih Anak</option>
                                @foreach($balitas as $balita)
                                    <option value="{{ $balita->id }}" {{ old('balita_id') == $balita->id ? 'selected' : '' }}>{{ $balita->nama }}</option>
                                @endforeach
                            </select>
                            @error('balita_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kapsul</label>
                            <select name="jenis_kapsul" class="form-select @error('jenis_kapsul') is-invalid @enderror" required>
                                <option value="">Pilih Kapsul</option>
                                <option value="Biru (100.000 IU)" {{ old('jenis_kapsul') == 'Biru (100.000 IU)' ? 'selected' : '' }}>Biru (100.000 IU) — Usia 6-11 bulan</option>
                                <option value="Merah (200.000 IU)" {{ old('jenis_kapsul') == 'Merah (200.000 IU)' ? 'selected' : '' }}>Merah (200.000 IU) — Usia 12-59 bulan</option>
                            </select>
                            @error('jenis_kapsul')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Bulan Pemberian</label>
                            <select name="bulan_pemberian" class="form-select @error('bulan_pemberian') is-invalid @enderror" required>
                                <option value="">Pilih Bulan</option>
                                <option value="Februari" {{ old('bulan_pemberian') == 'Februari' ? 'selected' : '' }}>Februari</option>
                                <option value="Agustus"  {{ old('bulan_pemberian') == 'Agustus'  ? 'selected' : '' }}>Agustus</option>
                            </select>
                            @error('bulan_pemberian')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="tahun_pemberian"
                                class="form-control @error('tahun_pemberian') is-invalid @enderror"
                                value="{{ old('tahun_pemberian', date('Y')) }}"
                                placeholder="Contoh: 2025" min="1900" max="2100" required>
                            @error('tahun_pemberian')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tanggal Pemberian</label>
                            <input type="date" name="tanggal_pemberian"
                                class="form-control @error('tanggal_pemberian') is-invalid @enderror"
                                value="{{ old('tanggal_pemberian', date('Y-m-d')) }}" required>
                            @error('tanggal_pemberian')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Simpan Vitamin A</button>
                </div>
            </form>
        </div>
    </div>
    @push('after-script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('form').addEventListener('submit', function (e) {
                let isValid = true;

                const fields = [
                    { name: 'balita_id',         label: 'Nama Anak'          },
                    { name: 'jenis_kapsul',      label: 'Jenis Kapsul'       },
                    { name: 'bulan_pemberian',   label: 'Bulan Pemberian'    },
                    { name: 'tahun_pemberian',   label: 'Tahun Pemberian'    },
                    { name: 'tanggal_pemberian', label: 'Tanggal Pemberian'  },
                ];

                fields.forEach(function (field) {
                    const input   = document.querySelector(`[name="${field.name}"]`);
                    const errorId = 'error-' + field.name;
                    const oldErr  = document.getElementById(errorId);
                    if (oldErr) oldErr.remove();
                    input.classList.remove('is-invalid');

                    // Cek kosong
                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add('is-invalid');
                        const div = document.createElement('div');
                        div.id = errorId;
                        div.className = 'invalid-feedback d-block';
                        div.textContent = field.label + ' tidak boleh kosong.';
                        input.closest('.mb-3').appendChild(div);
                        return;
                    }

                    // Cek khusus: tahun harus tepat 4 digit
                    if (field.name === 'tahun_pemberian' && !/^\d{4}$/.test(input.value.trim())) {
                        isValid = false;
                        input.classList.add('is-invalid');
                        const div = document.createElement('div');
                        div.id = errorId;
                        div.className = 'invalid-feedback d-block';
                        div.textContent = 'Tahun pemberian harus 4 digit (contoh: 2025).';
                        input.closest('.mb-3').appendChild(div);
                    }
                });

                if (!isValid) e.preventDefault();
            });

            // Hapus error saat user mengisi
            document.querySelectorAll('select, input').forEach(function (el) {
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
    @endpush
</x-app-layout>

