<x-app-layout>
    <div class="main-content">
        <div class="card mb-4 bg-primary text-white rounded-0 border-0">
            <div class="card-body py-5 d-flex justify-content-between align-items-center">
                <div class="px-3">
                    <h4 class="m-0 font-weight-bold">Edit Data Balita</h4>
                    <p class="m-0" style="opacity: 0.8;">{{ session('posyandu_nama') }}</p>
                </div>
            </div>
        </div>

        <div class="container-xl mt-4">
            <form class="card" action="{{ route('balita.update', $balita->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-header">
                    <h3 class="card-title">Form Edit Balita</h3>
                </div>
                <div class="card-body">
                    <div class="row row-cards">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nama Lengkap Balita</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $balita->nama) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jk" class="form-select" required>
                                <option value="L" {{ $balita->jk == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $balita->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" class="form-control" value="{{ old('tgl_lahir', $balita->tgl_lahir) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Umur (Bulan)</label>
                            <input type="number" id="umur" name="umur" class="form-control" value="{{ old('umur', $balita->umur) }}" required>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label d-block">Pilih Akun Orang Tua</label>
                            <select name="user_id" class="custom-select w-100">
                                <option value="">-- Pilih Orang Tua --</option>
                                @foreach($orangTuas as $ortu)
                                    <option value="{{ $ortu->id }}" {{ $balita->user_id == $ortu->id ? 'selected' : '' }}>
                                        {{ $ortu->name }} ({{ $ortu->username }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-hint text-muted">
                                Orang tua belum terdaftar? <a href="{{ route('ortu.create') }}">Daftarkan di sini</a>
                            </small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tinggi Badan (cm)</label>
                            <input type="number" step="0.1" name="tinggi_badan" class="form-control" value="{{ old('tinggi_badan', $balita->tinggi_badan) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Berat Badan (kg)</label>
                            <input type="number" step="0.1" name="berat_badan" class="form-control" value="{{ old('berat_badan', $balita->berat_badan) }}" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('balita.index') }}" class="btn btn-link link-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary ms-auto">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
