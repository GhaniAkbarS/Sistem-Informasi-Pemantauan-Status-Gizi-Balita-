<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\PeriksaController;
use App\Http\Controllers\LaporanController;

// mengambil data asli dari database untuk card statistik dashboard
use Carbon\Carbon;

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }
    
    // Ambil parameter bulan dan tahun saat ini
    $bulanIni = Carbon::now()->month;
    $tahunIni = Carbon::now()->year;

    // 1. Total Balita
    $totalBalita = \App\Models\Balita::count();
    
    // 2. Pemeriksaan Bulan Ini
    $pemeriksaanBulanIni = \App\Models\Periksa::whereMonth('tanggal_periksa', $bulanIni)
                                  ->whereYear('tanggal_periksa', $tahunIni)
                                  ->count();
                                  
    // 3. Status Gizi Normal
    $giziNormal = \App\Models\Periksa::where('status_gizi', 'Normal')->count();
    
    // 4. Perlu Rujukan (Misalkan yang statusnya Sangat Pendek, dll)
    $perluRujukan = \App\Models\Periksa::whereIn('status_gizi', ['Sangat Pendek', 'Buruk', 'Stunting'])->count();

    return view('pages.dashboard.index', compact(
        'totalBalita', 
        'pemeriksaanBulanIni', 
        'giziNormal', 
        'perluRujukan'
    ));
})->name('dashboard.index');


Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'doLogin'])->name('login.post');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'doRegister'])->name('register.post');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/balita/create', [BalitaController::class, 'create'])->name('balita.create');
Route::post('/balita/store', [BalitaController::class, 'store'])->name('balita.store');
Route::get('/balita', [BalitaController::class, 'index'])->name('balita.index');
Route::get('/balita/{id}/edit', [BalitaController::class, 'edit'])->name('balita.edit');
Route::put('/balita/{id}', [BalitaController::class, 'update'])->name('balita.update');
Route::delete('/balita/{id}', [BalitaController::class, 'destroy'])->name('balita.destroy');

Route::get('/periksa', [PeriksaController::class, 'index'])->name('periksa.index');
Route::get('/periksa/create', [PeriksaController::class, 'create'])->name('periksa.create');
Route::post('/periksa/store', [PeriksaController::class, 'store'])->name('periksa.store');
Route::get('/periksa/{id}/edit', [PeriksaController::class, 'edit'])->name('periksa.edit');
Route::put('/periksa/{id}', [PeriksaController::class, 'update'])->name('periksa.update');
Route::delete('/periksa/{id}', [PeriksaController::class, 'destroy'])->name('periksa.destroy');

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');