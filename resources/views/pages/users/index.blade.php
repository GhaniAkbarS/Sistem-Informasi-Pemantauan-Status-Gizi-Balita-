<x-app-layout>
<div class="main-content">

    {{-- Header Card --}}
    <div class="card mb-4 bg-primary text-white rounded-0 border-0">
        <div class="card-body py-5 d-flex justify-content-between align-items-center">
            <div class="px-3">
                <h4 class="m-0 font-weight-bold">Manajemen User Posyandu</h4>
                <p class="m-0" style="opacity: 0.8;">Daftar petugas dan pengguna di {{ session('posyandu_nama') }}</p>
            </div>
        </div>
    </div>

    <div class="container">

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        {{-- Alert Error --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        {{-- Tabel User --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-users mr-2"></i>Daftar Pengguna
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">#</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Tanggal Bergabung</th>
                                <th class="text-center" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                            <tr>
                                <td class="align-middle">{{ $index + 1 }}</td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4e73df&color=fff&size=36"
                                             class="rounded-circle mr-3" width="36" height="36" alt="Avatar">
                                        <span class="font-weight-bold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="align-middle text-muted">{{ $user->username }}</td>
                                <td class="align-middle">
                                    @if($user->role == 'admin')
                                        <span class="badge badge-primary px-2 py-1">Admin Posyandu</span>
                                    @elseif($user->role == 'kader')
                                        <span class="badge badge-success px-2 py-1">Petugas / Kader</span>
                                    @else
                                        <span class="badge badge-warning px-2 py-1">Orang Tua</span>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="align-middle text-center">
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus user ini? Akun tidak bisa login lagi.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-users fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                                    Tidak ada user lain di posyandu ini.
                                </td>
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
