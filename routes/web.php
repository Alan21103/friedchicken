<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DapurController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/**
 * Halaman Utama & Autentikasi
 */
Route::get('/', function () {
    return view('auth.login');
});

// Middleware auth.custom untuk memisahkan 3 Role
Route::middleware('auth.custom:kasir')->group(function () {
    Route::get('/kasir', function () {
        return view('kasir.index');
    })->name('kasir.index');
});

// DAPUR //

// Grouping Route Dapur (Gunakan Controller agar data dummy muncul)
Route::middleware('auth.custom:dapur')->group(function () {
    // Arahkan ke Controller, bukan ke view langsung
    Route::get('/dapur', [DapurController::class, 'index'])->name('dapur.index');
    Route::get('/dapur/stok', [DapurController::class, 'stok'])->name('dapur.stok');
});

/**
 * Grup Route Khusus Owner
 */
Route::middleware('auth.custom:owner')->group(function () {
    
    // Redirect /owner langsung ke Kelola Menu
    Route::get('/owner', function () {
        return redirect()->route('owner.menu.index');
    })->name('owner.index');

    Route::prefix('owner')->name('owner.')->group(function() {
        
        /**
         * 1. KELOLA MENU
         */
        Route::get('/menu', function () {
            return view('owner.menu.kelolamenu');
        })->name('menu.index');

        /**
         * 2. KELOLA KATEGORI
         */
        Route::get('/kategori', function () { 
            return view('owner.kategori.index'); 
        })->name('kategori.index');

        /**
         * 3. KELOLA PREDIKAT
         */
        // List Predikat
        Route::get('/predikat', function () { 
            return view('owner.predikat.predikat'); 
        })->name('predikat.index');

        // Tambah Predikat
        Route::get('/predikat/tambah', function () { 
            return view('owner.predikat.create-predikat'); 
        })->name('predikat.create');

        // Edit Predikat (Menerima parameter ID) - ROUTE BARU
        Route::get('/predikat/{id}/edit', function ($id) {
            return view('owner.predikat.edit-predikat', ['id' => $id]);
        })->name('predikat.edit');

        /**
         * 4. KELOLA PAJAK & SERVICE FEE
         */
        Route::get('/pajak', function () { 
            return view('owner.pajak.pajak'); 
        })->name('pajak.pajak');

        /**
         * 5. LAPORAN PENJUALAN
         */
        Route::get('/laporan', function () { 
            return "Halaman Laporan Penjualan sedang dalam pengembangan"; 
        })->name('laporan.index');

    });
});

require __DIR__.'/auth.php';