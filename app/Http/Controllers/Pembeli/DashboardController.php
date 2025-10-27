<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Member;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $barangTerbaru = Barang::active()
            ->where('stok', '>', 0)
            ->latest()
            ->take(12)
            ->get();
        
        $member = Member::where('user_id', auth()->id())->first();
        
        $pesananSaya = [];
        if ($member) {
            $pesananSaya = Transaksi::with(['details.barang'])
                ->where('member_id', $member->id)
                ->where('status', 'pending')
                ->latest()
                ->get();
        }
        
        return view('pembeli.dashboard', compact('barangTerbaru', 'member', 'pesananSaya'));
    }
}
