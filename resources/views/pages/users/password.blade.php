<x-app-layout>
    <div class="container-xl py-4">
        <div class="card mx-auto" style="max-width: 540px">
            <div class="card-header"><h1 class="card-title">Ganti Password</h1></div>
            <form method="POST" action="{{ route('akun.password.update') }}">
                @csrf @method('PUT')
                <div class="card-body">
                    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
                    <div class="mb-3">
                        <label class="form-label" for="current_password">Password saat ini</label>
                        <input id="current_password" type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" autocomplete="current-password" required>
                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password baru (minimal 12 karakter)</label>
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation">Ulangi password baru</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" autocomplete="new-password" required>
                    </div>
                </div>
                <div class="card-footer text-end"><button class="btn btn-primary" type="submit">Simpan Password</button></div>
            </form>
        </div>
    </div>
</x-app-layout>
