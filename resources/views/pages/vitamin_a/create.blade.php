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
                            <select name="balita_id" class="form-select" required>
                                <option value="">Pilih Anak</option>
                                @foreach($balitas as $balita)
                                    <option value="{{ $balita->id }}">{{ $balita->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kapsul</label>
                            <select name="jenis_kapsul" class="form-select" required>
                                <option value="">Pilih Kapsul</option>
                                <option value="Biru (100.000 IU)">Biru (100.000 IU) — Usia 6-11 bulan</option>
                                <option value="Merah (200.000 IU)">Merah (200.000 IU) — Usia 12-59 bulan</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Bulan Pemberian</label>
                            <select name="bulan_pemberian" class="form-select" required>
                                <option value="">Pilih Bulan</option>
                                <option value="Februari">Februari</option>
                                <option value="Agustus">Agustus</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="tahun_pemberian" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tanggal Pemberian</label>
                            <input type="date" name="tanggal_pemberian" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Simpan Vitamin A</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
