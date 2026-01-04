<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Halaman utama tetap ke Login
Route::get('/', function () {
    return view('auth.login');
});

// Middleware auth.custom untuk memisahkan 3 Role
Route::middleware('auth.custom:kasir')->group(function () {
    Route::get('/kasir', function () {
        return view('kasir.index');
    })->name('kasir.index');
});

Route::middleware('auth.custom:dapur')->group(function () {
    Route::get('/dapur', function () {
        return view('dapur.index');
    })->name('dapur.index');
});

Route::middleware('auth.custom:owner')->group(function () {
    Route::get('/owner', function () {
        return view('owner.index');
    })->name('owner.index');
});

// Pastikan menyertakan file auth.php dari Breeze untuk proses Login/Logout
require __DIR__.'/auth.php';