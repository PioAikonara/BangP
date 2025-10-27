<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPegawai = User::where('role', 'kasir')->count();
        $totalBarang = Barang::count();
        $totalStok = Barang::sum('stok');
        
        // Transaksi hari ini
        $transaksiHariIni = Transaksi::today()->selesai()->count();
        $penjualanHariIni = Transaksi::today()->selesai()->sum('total_harga');
        $keuntunganHariIni = Transaksi::today()->selesai()->sum('keuntungan');
        
        // Transaksi terbaru
        $transaksiTerbaru = Transaksi::with(['kasir', 'member'])
            ->latest()
            ->take(10)
            ->get();
        
        // Barang stok menipis (< 10)
        $stokMenupis = Barang::where('stok', '<', 10)
            ->active()
            ->get();
        
        // Barang akan expired (dalam 30 hari)
        $akanExpired = Barang::whereNotNull('expired_at')
            ->where('expired_at', '>=', now())
            ->where('expired_at', '<=', now()->addDays(30))
            ->get();
        
        return view('admin.dashboard', compact(
            'totalPegawai',
            'totalBarang',
            'totalStok',
            'transaksiHariIni',
            'penjualanHariIni',
            'keuntunganHariIni',
            'transaksiTerbaru',
            'stokMenupis',
            'akanExpired'
        ));
    }
}
