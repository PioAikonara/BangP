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
        $kasirId = auth()->id();
        
        // Transaksi hari ini oleh kasir ini
        $transaksiHariIni = Transaksi::where('kasir_id', $kasirId)
            ->today()
            ->selesai()
            ->count();
        
        $penjualanHariIni = Transaksi::where('kasir_id', $kasirId)
            ->today()
            ->selesai()
            ->sum('total_harga');
        
        // Transaksi terbaru kasir ini
        $transaksiTerbaru = Transaksi::with(['member', 'details.barang'])
            ->where('kasir_id', $kasirId)
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
