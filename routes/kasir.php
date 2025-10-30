<?php

use App\Http\Controllers\Kasir\DashboardController;
use App\Http\Controllers\Kasir\TransaksiController;
use App\Http\Controllers\Kasir\MemberController;
use App\Http\Controllers\Kasir\LaporanController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:kasir,admin'])->prefix('kasir')->name('kasir.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Transaksi
    Route::resource('transaksi', TransaksiController::class);
    Route::get('transaksi/{transaksi}/print', [TransaksiController::class, 'print'])->name('transaksi.print');
    Route::post('transaksi/{transaksi}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.status');
    
    // Member
    Route::resource('member', MemberController::class);

    // Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/print', [LaporanController::class, 'print'])->name('laporan.print');
});