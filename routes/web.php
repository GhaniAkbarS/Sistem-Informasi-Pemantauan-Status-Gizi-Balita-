<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BalitaController;

Route::get('/', function () {
    // Check if user is logged in (simplified for dummy)
    if (!session()->has('user')) {
        return redirect('/login');
    }
    $totalBalita = \App\Models\Balita::count();
return view('pages/dashboard/index', compact('totalBalita'));
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('login.post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'doRegister'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/balita/create', [BalitaController::class, 'create'])->name('balita.create');
Route::post('/balita/store', [BalitaController::class, 'store'])->name('balita.store');
Route::get('/balita', [BalitaController::class, 'index'])->name('balita.index'); // Menambahkan route ini karena sebelumnya error "Route [balita.index] not defined" saat dipanggil di view/controller.