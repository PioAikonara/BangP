<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date', today()->startOfMonth());
        $endDate = $request->get('end_date', today());
        
        $transaksi = Transaksi::with(['kasir', 'member', 'details.barang'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selesai()
            ->latest()
            ->paginate(20);
        
        $totalTransaksi = Transaksi::whereBetween('created_at', [$startDate, $endDate])->selesai()->count();
        $totalPenjualan = Transaksi::whereBetween('created_at', [$startDate, $endDate])->selesai()->sum('total_harga');
        $totalDiskon = Transaksi::whereBetween('created_at', [$startDate, $endDate])->selesai()->sum('diskon');
        $totalKeuntungan = Transaksi::whereBetween('created_at', [$startDate, $endDate])->selesai()->sum('keuntungan');
        
        return view('admin.laporan.index', compact(
            'transaksi',
            'startDate',
            'endDate',
            'totalTransaksi',
            'totalPenjualan',
            'totalDiskon',
            'totalKeuntungan'
        ));
    }
    
    public function harian(Request $request)
    {
        $tanggal = $request->get('tanggal', today());
        
        $transaksi = Transaksi::with(['kasir', 'member', 'details.barang'])
            ->whereDate('created_at', $tanggal)
            ->selesai()
            ->latest()
            ->get();
        
        $totalPenjualan = $transaksi->sum('total_harga');
        $totalKeuntungan = $transaksi->sum('keuntungan');
        
        return view('admin.laporan.harian', compact('transaksi', 'tanggal', 'totalPenjualan', 'totalKeuntungan'));
    }
}
