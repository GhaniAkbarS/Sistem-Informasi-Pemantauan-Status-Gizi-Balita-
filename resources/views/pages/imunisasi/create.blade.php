<x-app-layout>
    <div class="main-content">
        <div class="card mb-4 bg-primary text-white rounded-0 border-0">
            <div class="card-body py-5 px-4">
                <h4 class="m-0 font-weight-bold">Input Imunisasi</h4>
                <p class="m-0" style="opacity:0.8">{{ session('posyandu_nama') }}</p>
            </div>
        </div>

        <div class="container-xl mt-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form class="card" action="{{ route('imunisasi.store') }}" method="POST">
                @csrf
                <div class="card-header">
                    <h3 class="card-title">Form Data Imunisasi</h3>
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
                            <label class="form-label">Nama Vaksin</label>
                            <select name="nama_vaksin" class="form-select" required>
                                <option value="">Pilih Vaksin</option>
                                @foreach(['HB0','BCG','Polio 1','DPT-HB-Hib 1','Polio 2','DPT-HB-Hib 2','Polio 3','DPT-HB-Hib 3','Polio 4','IPV','Campak/MR','DPT-HB-Hib 4','Campak/MR Lanjutan'] as $vaksin)
                                    <option value="{{ $vaksin }}">{{ $vaksin }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Pemberian</label>
                            <input type="date" name="tanggal_pemberian" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Keterangan (opsional)</label>
                            <input type="text" name="keterangan" class="form-control" placeholder="Misal: reaksi ringan, dll">
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Simpan Imunisasi</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
