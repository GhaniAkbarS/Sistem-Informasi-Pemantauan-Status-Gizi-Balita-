<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\PeriksaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\ImunisasiController;
use App\Http\Controllers\VitaminAController;
use Carbon\Carbon;

// ─── Route Publik (Hanya untuk tamu/belum login) ─────────────────────────
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'doLogin'])->name('login.post');
    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::post('/register', [UserController::class, 'doRegister'])->name('register.post');
});

// Logout harus bisa diakses saat sudah login
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Manajemen User (Hanya untuk Admin)
Route::middleware(['checkRole:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'userIndex'])->name('users.index');
    Route::delete('/users/{id}', [UserController::class, 'userDestroy'])->name('users.destroy');
});

//Role orang tua
Route::middleware(['auth', 'checkRole:orang_tua'])->group(function () {
    Route::get('/portal', [OrangTuaController::class, 'index'])->name('ortu.dashboard');
    Route::get('/portal/anak/{id}', [OrangTuaController::class, 'show'])->name('ortu.show');
});


// ─── Route Terproteksi (Harus login + punya posyandu) ─────────────────────────
Route::middleware(['auth', 'checkPosyandu'])->group(function () {

    Route::get('/imunisasi/create', [ImunisasiController::class, 'create'])->name('imunisasi.create');
    Route::post('/imunisasi/store', [ImunisasiController::class, 'store'])->name('imunisasi.store');
    Route::get('/vitamin-a/create', [VitaminAController::class, 'create'])->name('vitamina.create');
    Route::post('/vitamin-a/store', [VitaminAController::class, 'store'])->name('vitamina.store');

    // Dashboard
    Route::get('/', function () {
        $posyanduId = session('posyandu_id');
        $bulanIni   = Carbon::now()->month;
        $tahunIni   = Carbon::now()->year;

        $totalBalita = \App\Models\Balita::where('posyandu_id', $posyanduId)->count();

        $pemeriksaanBulanIni = \App\Models\Periksa::whereHas('balita', function($q) use ($posyanduId) {
                                    $q->where('posyandu_id', $posyanduId);
                                })
                                ->whereMonth('tanggal_periksa', $bulanIni)
                                ->whereYear('tanggal_periksa', $tahunIni)
                                ->count();

        $giziNormal = \App\Models\Periksa::whereHas('balita', function($q) use ($posyanduId) {
                                    $q->where('posyandu_id', $posyanduId);
                                })
                                ->where('status_gizi', 'Gizi Baik')->count();

        $perluRujukan = \App\Models\Periksa::whereHas('balita', function($q) use ($posyanduId) {
                                    $q->where('posyandu_id', $posyanduId);
                                })
                                ->whereIn('status_gizi', ['Stunting', 'Gizi Kurang'])->count();

        // Distribusi status gizi
        $distribusi = \App\Models\Periksa::whereHas('balita', function($q) use ($posyanduId) {
                            $q->where('posyandu_id', $posyanduId);
                        })
                        ->selectRaw('status_gizi, COUNT(*) as total')
                        ->groupBy('status_gizi')
                        ->pluck('total', 'status_gizi');

        $distNormal   = $distribusi['Gizi Baik'] ?? 0;
        $distKurang   = $distribusi['Gizi Kurang'] ?? 0;
        $distLebih    = $distribusi['Gizi Lebih']  ?? 0;
        $distStunting = $distribusi['Stunting']    ?? 0;
        $totalDist    = $distNormal + $distKurang + $distLebih + $distStunting;

        // Tren pemeriksaan 6 bulan terakhir
        $trenLabels = [];
        $trenData   = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan        = Carbon::now()->subMonths($i);
            $trenLabels[] = $bulan->locale('id')->translatedFormat('M Y');
            $trenData[]   = \App\Models\Periksa::whereHas('balita', function($q) use ($posyanduId) {
                                $q->where('posyandu_id', $posyanduId);
                            })
                            ->whereMonth('tanggal_periksa', $bulan->month)
                            ->whereYear('tanggal_periksa', $bulan->year)
                            ->count();
        }


                                $recentExaminations = \App\Models\Periksa::with('balita')
                                ->whereHas('balita', function($q) use ($posyanduId) {
                                    $q->where('posyandu_id', $posyanduId);
                                })
                                ->where('tanggal_periksa', '>=', Carbon::now()->subDays(7))
                                ->orderBy('tanggal_periksa', 'desc')
                                ->get();

        return view('pages.dashboard.index', compact(
            'totalBalita',
            'pemeriksaanBulanIni',
            'giziNormal',
            'perluRujukan',
            'recentExaminations',
            'distNormal', 
            'distKurang', 
            'distLebih', 
            'distStunting', 
            'totalDist',
            'trenLabels', 
            'trenData'
        ));
    })->name('dashboard.index');

    // Balita
    Route::get('/balita', [BalitaController::class, 'index'])->name('balita.index');
    Route::get('/balita/create', [BalitaController::class, 'create'])->name('balita.create');
    Route::post('/balita/store', [BalitaController::class, 'store'])->name('balita.store');
    Route::get('/balita/{id}/edit', [BalitaController::class, 'edit'])->name('balita.edit');
    Route::put('/balita/{id}', [BalitaController::class, 'update'])->name('balita.update');
    Route::delete('/balita/{id}', [BalitaController::class, 'destroy'])->name('balita.destroy');

    // Periksa
    Route::get('/periksa', [PeriksaController::class, 'index'])->name('periksa.index');
    Route::get('/periksa/create', [PeriksaController::class, 'create'])->name('periksa.create');
    Route::post('/periksa/store', [PeriksaController::class, 'store'])->name('periksa.store');
    Route::get('/periksa/{id}/edit', [PeriksaController::class, 'edit'])->name('periksa.edit');
    Route::put('/periksa/{id}', [PeriksaController::class, 'update'])->name('periksa.update');
    Route::delete('/periksa/{id}', [PeriksaController::class, 'destroy'])->name('periksa.destroy');

    // Imunisasi & Vitamin A index
    Route::get('/imunisasi', [ImunisasiController::class, 'index'])->name('imunisasi.index');
    Route::get('/vitamin-a', [VitaminAController::class, 'index'])->name('vitamina.index');
    
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
    // Laporan cetak tambahan
    Route::get('/laporan/cetak/balita',    [LaporanController::class, 'cetakBalita'])->name('laporan.cetak.balita');
    Route::get('/laporan/cetak/imunisasi', [LaporanController::class, 'cetakImunisasi'])->name('laporan.cetak.imunisasi');
    Route::get('/laporan/cetak/vitamina',  [LaporanController::class, 'cetakVitaminA'])->name('laporan.cetak.vitamina');

});
