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
        $startDate = Carbon::parse($request->get('tanggal_awal', today()->startOfMonth()))->startOfDay();
        $endDate = Carbon::parse($request->get('tanggal_akhir', today()))->endOfDay();
        $status = $request->get('status', '');
        
        $query = Transaksi::with(['kasir', 'member', 'details.barang'])
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        // Filter by status if provided
        if ($status) {
            $query->where('status', $status);
        }
        
        $transaksi = $query->latest()->paginate(20);
        
        // Summary calculations
        $summaryQuery = Transaksi::whereBetween('created_at', [$startDate, $endDate]);
        if ($status) {
            $summaryQuery->where('status', $status);
        }
        
        $totalTransaksi = $summaryQuery->count();
        $totalPenjualan = $summaryQuery->sum('total_harga');
        $totalDiskon = $summaryQuery->sum('diskon');
        $totalKeuntungan = $summaryQuery->sum('keuntungan');
        
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
    
    public function print(Request $request)
    {
        $startDate = Carbon::parse($request->get('tanggal_awal', today()->startOfMonth()))->startOfDay();
        $endDate = Carbon::parse($request->get('tanggal_akhir', today()))->endOfDay();
        $status = $request->get('status', '');
        
        $query = Transaksi::with(['kasir', 'member', 'details.barang'])
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $transaksi = $query->latest()->get();
        
        $totalTransaksi = $transaksi->count();
        $totalPenjualan = $transaksi->sum('total_harga');
        $totalDiskon = $transaksi->sum('diskon');
        $totalKeuntungan = $transaksi->sum('keuntungan');
        
        return view('admin.laporan.print', compact(
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
