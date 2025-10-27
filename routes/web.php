<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\BarangController as AdminBarangController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboard;
use App\Http\Controllers\Kasir\TransaksiController;
use App\Http\Controllers\Kasir\MemberController;
use App\Http\Controllers\Pembeli\DashboardController as PembeliDashboard;
use App\Http\Controllers\Pembeli\PesananController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Redirect dashboard based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isKasir()) {
        return redirect()->route('kasir.dashboard');
    } elseif ($user->isPembeli()) {
        return redirect()->route('pembeli.dashboard');
    }
    
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // Pegawai Management
    Route::resource('pegawai', PegawaiController::class);
    
    // Barang Management
    Route::resource('barang', AdminBarangController::class);
    
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/harian', [LaporanController::class, 'harian'])->name('laporan.harian');
});

// Kasir Routes
Route::middleware(['auth', 'role:kasir,admin'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', [KasirDashboard::class, 'index'])->name('dashboard');
    
    // Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi-riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');
    Route::delete('/barang/expired', [TransaksiController::class, 'hapusExpired'])->name('barang.hapus-expired');
    
    // Member Management
    Route::resource('member', MemberController::class);
});

// Pembeli Routes
Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/dashboard', [PembeliDashboard::class, 'index'])->name('dashboard');
    
    // Pesanan Online
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/keranjang', [PesananController::class, 'keranjang'])->name('pesanan.keranjang');
    Route::post('/keranjang/tambah', [PesananController::class, 'tambahKeranjang'])->name('pesanan.tambah-keranjang');
    Route::delete('/keranjang/{index}', [PesananController::class, 'hapusKeranjang'])->name('pesanan.hapus-keranjang');
    Route::post('/checkout', [PesananController::class, 'checkout'])->name('pesanan.checkout');
    Route::get('/riwayat', [PesananController::class, 'riwayat'])->name('pesanan.riwayat');
});

// Profile Routes (all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
