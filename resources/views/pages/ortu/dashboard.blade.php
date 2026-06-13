<x-app-layout>
    <div class="main-content">
        <div class="card mb-4 bg-primary text-white rounded-0 border-0">
            <div class="card-body py-4 px-4">
                <h4 class="m-0 font-weight-bold">Portal Orang Tua</h4>
                <p class="m-0" style="opacity:0.8">Selamat datang, {{ Auth::user()->name }}</p>

            </div>
        </div>

        <div class="container-xl mt-4">
            <h5 class="mb-3">Data Anak Anda</h5>

            @forelse($anakDaftar as $anak)
            <div class="card mb-3">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="mb-1">{{ $anak->nama }}</h5>
                        <small class="text-muted">
                            {{ $anak->jk == 'L' ? 'Laki-laki' : 'Perempuan' }} •
                            {{ \Carbon\Carbon::parse($anak->tgl_lahir)->diffInMonths(now()) }} bulan
                        </small>
                    </div>
                    <a href="{{ route('ortu.show', $anak->id) }}" class="btn btn-primary btn-sm">
                        Lihat Perkembangan
                    </a>
                </div>
            </div>
            @empty
            <div class="alert alert-info">
                Data anak Anda belum tersedia. Silakan hubungi kader posyandu.
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
