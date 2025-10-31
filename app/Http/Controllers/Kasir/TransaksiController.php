<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Member;
use App\Models\Setting;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['details.barang', 'member.user']);
        
        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $transaksi = $query->latest()->paginate(10);
        
        // Hitung jumlah transaksi pending untuk notifikasi
        $pendingCount = Transaksi::where('status', 'pending')->count();
        
        return view('kasir.transaksi.index', compact('transaksi', 'pendingCount'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'metode_pembayaran' => 'required|in:tunai,transfer,qris',
            'diskon_transaksi' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);
        
        DB::beginTransaction();
        try {
            $totalHarga = 0;
            $totalKeuntungan = 0;
            
            // Hitung total dan keuntungan
            foreach ($validated['items'] as $item) {
                $barang = Barang::findOrFail($item['barang_id']);
                
                // Cek stok
                if ($barang->stok < $item['jumlah']) {
                    throw new \Exception("Stok barang {$barang->nama_barang} tidak mencukupi");
                }
                
                $hargaJual = $barang->harga_setelah_diskon;
                $subtotal = $hargaJual * $item['jumlah'];
                $keuntungan = ($hargaJual - $barang->harga_beli) * $item['jumlah'];
                
                $totalHarga += $subtotal;
                $totalKeuntungan += $keuntungan;
            }
            
            // Create transaksi
            $transaksi = Transaksi::create([
                'kasir_id' => auth()->id(),
                'member_id' => $validated['member_id'],
                'total_harga' => $totalHarga,
                'diskon' => $validated['diskon_transaksi'] ?? 0,
                'keuntungan' => $totalKeuntungan,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'status' => 'selesai',
            ]);
            
            // Create details dan kurangi stok
            foreach ($validated['items'] as $item) {
                $barang = Barang::findOrFail($item['barang_id']);
                $hargaJual = $barang->harga_setelah_diskon;
                
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $barang->id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $hargaJual,
                    'subtotal' => $hargaJual * $item['jumlah'],
                ]);
                
                // Kurangi stok
                $barang->decrement('stok', $item['jumlah']);
            }
            
            DB::commit();
            
            return redirect()->route('kasir.transaksi.show', $transaksi)
                ->with('success', 'Transaksi berhasil disimpan');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['details.barang', 'member']);
        return view('kasir.transaksi.show', compact('transaksi'));
    }
    
    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,selesai,dibatalkan',
        ]);
        
        DB::beginTransaction();
        try {
            // Update status transaksi
            $transaksi->update([
                'status' => $validated['status']
            ]);
            
            // Jika disetujui (selesai), kurangi stok barang
            if ($validated['status'] === 'selesai') {
                foreach ($transaksi->details as $detail) {
                    $barang = $detail->barang;
                    if ($barang) {
                        if ($barang->stok < $detail->jumlah) {
                            throw new \Exception("Stok barang {$barang->nama_barang} tidak mencukupi");
                        }
                        $barang->decrement('stok', $detail->jumlah);
                    }
                }
                
                DB::commit();
                return redirect()->route('kasir.transaksi.index')
                    ->with('success', 'Transaksi berhasil disetujui dan diselesaikan');
            }
            
            // Jika dibatalkan
            if ($validated['status'] === 'dibatalkan') {
                DB::commit();
                return redirect()->route('kasir.transaksi.index')
                    ->with('success', 'Transaksi berhasil dibatalkan');
            }
            
            DB::commit();
            return back()->with('success', 'Status transaksi berhasil diupdate');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function print(Transaksi $transaksi)
    {
        $transaksi->load(['details.barang', 'member.user', 'kasir']);
        $setting = Setting::first();
        
        return view('kasir.transaksi.print', compact('transaksi', 'setting'));
    }
    
    public function riwayat()
    {
        $transaksi = Transaksi::with(['member', 'details'])
            ->where('kasir_id', auth()->id())
            ->latest()
            ->paginate(20);
        
        return view('kasir.transaksi.riwayat', compact('transaksi'));
    }
    
    public function hapusExpired()
    {
        $barangExpired = Barang::expired()->get();
        
        foreach ($barangExpired as $barang) {
            $barang->delete();
        }
        
        return back()->with('success', count($barangExpired) . ' barang expired berhasil dihapus');
    }
}
