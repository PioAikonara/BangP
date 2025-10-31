<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Transaksi hari ini (semua kasir untuk kasir bisa lihat semua)
        $transaksiHariIni = Transaksi::whereDate('created_at', today())->count();
        
        // Total penjualan hari ini
        $penjualanHariIni = Transaksi::whereDate('created_at', today())
            ->where('status', 'selesai')
            ->sum('total_harga');
        
        // Transaksi terbaru
        $transaksiTerbaru = Transaksi::with(['member.user', 'kasir'])
            ->latest()
            ->take(10)
            ->get();
        
        // Barang stok menipis
        $stokMenupis = Barang::where('stok', '<', 10)
            ->active()
            ->get();
        
        // Barang akan expired
        $akanExpired = Barang::whereNotNull('expired_at')
            ->where('expired_at', '>=', now())
            ->where('expired_at', '<=', now()->addDays(30))
            ->get();
        
        return view('kasir.dashboard', compact(
            'transaksiHariIni',
            'penjualanHariIni',
            'transaksiTerbaru',
            'stokMenupis',
            'akanExpired'
        ));
    }
}
