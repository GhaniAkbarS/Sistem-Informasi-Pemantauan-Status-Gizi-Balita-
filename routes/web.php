<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\PeriksaController;

Route::get('/', function () {
    if (!session()->has('user')) {
        return redirect('/login');
    }
    $totalBalita = \App\Models\Balita::count();
return view('pages/dashboard/index', compact('totalBalita'));
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
