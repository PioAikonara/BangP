<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_awal', now()->startOfMonth()->format('Y-m-d'));
        $tanggal_akhir = $request->input('tanggal_akhir', now()->format('Y-m-d'));
        
        // Laporan Transaksi
        $transaksi = Transaksi::with(['kasir', 'member'])
            ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->where('status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Summary
        $totalTransaksi = $transaksi->count();
        $totalPendapatan = $transaksi->sum('total_bayar');
        $totalItem = $transaksi->sum(function ($t) {
            return $t->details->sum('jumlah');
        });
        
        // Barang Terlaris
        $barangTerlaris = DB::table('transaksi_detail')
            ->join('transaksi', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
            ->join('barang', 'transaksi_detail.barang_id', '=', 'barang.id')
            ->whereBetween('transaksi.created_at', [$tanggal_awal, $tanggal_akhir])
            ->where('transaksi.status', 'selesai')
            ->select('barang.nama_barang', DB::raw('SUM(transaksi_detail.jumlah) as total_terjual'))
            ->groupBy('barang.id', 'barang.nama_barang')
            ->orderBy('total_terjual', 'desc')
            ->limit(10)
            ->get();
        
        return view('kasir.laporan.index', compact(
            'transaksi',
            'tanggal_awal',
            'tanggal_akhir',
            'totalTransaksi',
            'totalPendapatan',
            'totalItem',
            'barangTerlaris'
        ));
    }
    
    public function print(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_awal', now()->startOfMonth()->format('Y-m-d'));
        $tanggal_akhir = $request->input('tanggal_akhir', now()->format('Y-m-d'));
        
        $transaksi = Transaksi::with(['kasir', 'member', 'details.barang'])
            ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
            ->where('status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalTransaksi = $transaksi->count();
        $totalPendapatan = $transaksi->sum('total_bayar');
        $totalItem = $transaksi->sum(function ($t) {
            return $t->details->sum('jumlah');
        });
        
        return view('kasir.laporan.print', compact(
            'transaksi',
            'tanggal_awal',
            'tanggal_akhir',
            'totalTransaksi',
            'totalPendapatan',
            'totalItem'
        ));
    }
}
