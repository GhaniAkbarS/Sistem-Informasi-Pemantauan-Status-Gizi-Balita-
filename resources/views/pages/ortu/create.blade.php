<x-app-layout>
    <div class="main-content">
        <div class="card mb-4 bg-primary text-white rounded-0 border-0">
            <div class="card-body py-5 d-flex justify-content-between align-items-center">
                <div class="px-3">
                    <h4 class="m-0 font-weight-bold">Daftarkan Akun Orang Tua</h4>
                    <p class="m-0" style="opacity: 0.8;">{{ session('posyandu_nama') }}</p>
                </div>
                <div class="text-right px-3">
                    <p class="m-0"><strong>Kader:</strong> {{ ucfirst(session('user')) }}</p>
                    <p class="m-0" style="opacity: 0.8;">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="container-xl mt-4">
            <div class="row justify-content-center">
                <div class="col-md-6">

                    {{-- Notifikasi Berhasil --}}
                    @if(session('success_ortu'))
                        @php $info = session('success_ortu'); @endphp
                        <div class="alert alert-success">
                            <h4 class="alert-title">Akun berhasil dibuat!</h4>
                            <p class="mb-1">Sampaikan info login berikut kepada orang tua:</p>
                            <ul class="mb-0">
                                <li><strong>Nama:</strong> {{ $info['name'] }}</li>
                                <li><strong>Username:</strong> <code>{{ $info['username'] }}</code></li>
                                <li><strong>Password:</strong> <code>{{ $info['password'] }}</code></li>
                            </ul>
                        </div>
                    @endif

                    <form class="card" action="{{ route('ortu.store') }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title">Form Pendaftaran Orang Tua</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap Orang Tua</label>
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Contoh: Siti Aminah"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-hint text-muted">
                                    Username akan dibuat otomatis. Password default: <strong>posyandu123</strong>
                                </small>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('balita.index') }}" class="btn btn-link link-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                                </svg>
                                Buat Akun
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
