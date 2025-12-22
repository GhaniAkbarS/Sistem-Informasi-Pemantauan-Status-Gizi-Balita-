<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    // Check if user is logged in (simplified for dummy)
    if (!session()->has('user')) {
        return redirect('/login');
    }
    return view('pages/dashboard/index');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('login.post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'doRegister'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');