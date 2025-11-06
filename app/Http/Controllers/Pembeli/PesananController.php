<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Member;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function index()
    {
        $barang = Barang::active()->where('stok', '>', 0)->paginate(20);
        return view('pembeli.pesanan.index', compact('barang'));
    }
    
    public function keranjang()
    {
        $keranjang = session()->get('keranjang', []);
        $total = 0;
        
        foreach ($keranjang as $item) {
            $barang = Barang::find($item['barang_id']);
            if ($barang) {
                $total += $barang->harga_setelah_diskon * $item['jumlah'];
            }
        }
        
        return view('pembeli.pesanan.keranjang', compact('keranjang', 'total'));
    }
    
    public function tambahKeranjang(Request $request)
    {
        $validated = $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
        ]);
        
        $barang = Barang::findOrFail($validated['barang_id']);
        
        if ($barang->stok < $validated['jumlah']) {
            return back()->with('error', 'Stok tidak mencukupi');
        }
        
        $keranjang = session()->get('keranjang', []);
        $keranjang[] = [
            'barang_id' => $barang->id,
            'jumlah' => $validated['jumlah'],
        ];
        
        session()->put('keranjang', $keranjang);
        
        return back()->with('success', 'Barang ditambahkan ke keranjang');
    }
    
    public function hapusKeranjang($index)
    {
        $keranjang = session()->get('keranjang', []);
        unset($keranjang[$index]);
        session()->put('keranjang', array_values($keranjang));
        
        return back()->with('success', 'Barang dihapus dari keranjang');
    }
    
    public function checkout(Request $request)
    {
        $keranjang = session()->get('keranjang', []);
        
        if (empty($keranjang)) {
            return back()->with('error', 'Keranjang kosong');
        }
        
        $member = Member::where('user_id', auth()->id())->first();
        
        if (!$member) {
            return back()->with('error', 'Anda harus menjadi member terlebih dahulu');
        }
        
        $metodePembayaran = $request->input('metode_pembayaran', 'tunai');
        
        DB::beginTransaction();
        try {
            $totalHarga = 0;
            
            // Hitung total
            foreach ($keranjang as $item) {
                $barang = Barang::findOrFail($item['barang_id']);
                
                if ($barang->stok < $item['jumlah']) {
                    throw new \Exception("Stok barang {$barang->nama_barang} tidak mencukupi");
                }
                
                $hargaJual = $barang->harga_setelah_diskon;
                $subtotal = $hargaJual * $item['jumlah'];
                $totalHarga += $subtotal;
            }
            
            // Create transaksi
            $status = ($metodePembayaran == 'qris') ? 'pending' : 'selesai';
            
            $transaksi = Transaksi::create([
                'kasir_id' => 1, // Admin default untuk online order
                'member_id' => $member->id,
                'total_harga' => $totalHarga,
                'diskon' => 0,
                'keuntungan' => 0,
                'metode_pembayaran' => $metodePembayaran,
                'status' => $status,
            ]);
            
            // Create details
            foreach ($keranjang as $item) {
                $barang = Barang::findOrFail($item['barang_id']);
                $hargaJual = $barang->harga_setelah_diskon;
                
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $barang->id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $hargaJual,
                    'subtotal' => $hargaJual * $item['jumlah'],
                ]);
                
                // Kurangi stok hanya jika tunai (langsung selesai)
                if ($metodePembayaran == 'tunai') {
                    $barang->decrement('stok', $item['jumlah']);
                }
            }
            
            DB::commit();
            
            // Kosongkan keranjang
            session()->forget('keranjang');
            
            // Redirect ke halaman QRIS jika metode QRIS
            if ($metodePembayaran == 'qris') {
                return redirect()->route('pembeli.pesanan.qris', $transaksi->id);
            }
            
            return redirect()->route('pembeli.pesanan.riwayat')
                ->with('success', 'Pesanan berhasil dibuat. Silakan ambil di toko.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
    
    public function qris($transaksiId)
    {
        $transaksi = Transaksi::with(['details.barang', 'member'])
            ->where('id', $transaksiId)
            ->where('member_id', Member::where('user_id', auth()->id())->first()->id)
            ->firstOrFail();
        
        if ($transaksi->status != 'pending') {
            return redirect()->route('pembeli.pesanan.riwayat')
                ->with('error', 'Transaksi ini sudah dibayar atau dibatalkan');
        }
        
        return view('pembeli.pesanan.qris', compact('transaksi'));
    }
    
    public function bayarTunai($transaksiId)
    {
        $member = Member::where('user_id', auth()->id())->first();
        
        $transaksi = Transaksi::with(['details.barang'])
            ->where('id', $transaksiId)
            ->where('member_id', $member->id)
            ->firstOrFail();
        
        if ($transaksi->status != 'pending') {
            return redirect()->route('pembeli.pesanan.riwayat')
                ->with('error', 'Transaksi ini sudah dibayar atau dibatalkan');
        }
        
        DB::beginTransaction();
        try {
            // Update status transaksi
            $transaksi->update([
                'status' => 'selesai',
                'metode_pembayaran' => 'tunai'
            ]);
            
            // Kurangi stok barang
            foreach ($transaksi->details as $detail) {
                $detail->barang->decrement('stok', $detail->jumlah);
            }
            
            DB::commit();
            
            return redirect()->route('pembeli.pesanan.riwayat')
                ->with('success', 'Pembayaran berhasil! Silakan ambil pesanan di kasir.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function riwayat(Request $request)
    {
        $member = Member::where('user_id', auth()->id())->first();
        
        if (!$member) {
            $pesanan = collect();
        } else {
            $query = Transaksi::with(['details.barang'])
                ->where('member_id', $member->id);
            
            // Filter berdasarkan status jika ada
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }
            
            $pesanan = $query->latest()->paginate(10);
        }
        
        return view('pembeli.pesanan.riwayat', compact('pesanan'));
    }
}
