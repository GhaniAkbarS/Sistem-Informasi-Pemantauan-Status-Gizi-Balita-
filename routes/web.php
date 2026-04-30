<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\PeriksaController;
use App\Http\Controllers\LaporanController;
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

// ─── Route Terproteksi (Harus login + punya posyandu) ─────────────────────────
Route::middleware(['auth', 'checkPosyandu'])->group(function () {

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
                                ->where('status_gizi', 'Normal')->count();

        $perluRujukan = \App\Models\Periksa::whereHas('balita', function($q) use ($posyanduId) {
                                    $q->where('posyandu_id', $posyanduId);
                                })
                                ->whereIn('status_gizi', ['Sangat Pendek', 'Buruk', 'Stunting'])->count();

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
            'recentExaminations'
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

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
});
