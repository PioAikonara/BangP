@extends('layouts.dashboard')

@section('title', 'Daftar Transaksi')
@section('subtitle', 'Kelola transaksi pembeli')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Daftar Transaksi</h2>
            <p class="text-gray-600 mt-1">Kelola transaksi dari pembeli</p>
        </div>
    </div>

    <!-- Filter Status -->
    <div class="bg-white p-4 rounded-lg shadow-md">
        <div class="flex gap-2 overflow-x-auto">
            <a href="{{ route('kasir.transaksi.index') }}" 
               class="px-4 py-2 {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} rounded-lg whitespace-nowrap transition-colors">
                Semua Transaksi
            </a>
            <a href="{{ route('kasir.transaksi.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 {{ request('status') == 'pending' ? 'bg-yellow-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} rounded-lg whitespace-nowrap transition-colors relative">
                Menunggu Pembayaran
                @if(isset($pendingCount) && $pendingCount > 0)
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center">
                    {{ $pendingCount }}
                </span>
                @endif
            </a>
            <a href="{{ route('kasir.transaksi.index', ['status' => 'selesai']) }}" 
               class="px-4 py-2 {{ request('status') == 'selesai' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} rounded-lg whitespace-nowrap transition-colors">
                Selesai
            </a>
            <a href="{{ route('kasir.transaksi.index', ['status' => 'dibatalkan']) }}" 
               class="px-4 py-2 {{ request('status') == 'dibatalkan' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} rounded-lg whitespace-nowrap transition-colors">
                Dibatalkan
            </a>
        </div>
    </div>

    <!-- Transactions List -->
    @if(isset($transaksi) && $transaksi->count() > 0)
    <div class="space-y-4">
        @foreach($transaksi as $item)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Transaction Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $item->kode_transaksi }}</h3>
                        <p class="text-sm text-gray-600">
                            Pembeli: {{ $item->member->user->name ?? 'Umum' }}
                            | {{ $item->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            @if($item->status === 'selesai') bg-green-100 text-green-800
                            @elseif($item->status === 'pending') bg-yellow-100 text-yellow-800 animate-pulse
                            @else bg-red-100 text-red-800 @endif">
                            @if($item->status === 'selesai')
                                ✓ Selesai
                            @elseif($item->status === 'pending')
                                ⏳ Menunggu
                            @else
                                ✗ Dibatalkan
                            @endif
                        </span>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                            {{ ucfirst($item->metode_pembayaran ?? 'Tunai') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Transaction Items -->
            <div class="px-6 py-4">
                <div class="space-y-3">
                    @if($item->details && $item->details->count() > 0)
                        @foreach($item->details as $detail)
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $detail->barang->nama_barang ?? 'Produk' }}</h4>
                                <p class="text-sm text-gray-600">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-center py-2">Detail transaksi tidak tersedia</p>
                    @endif
                </div>

                <!-- Total -->
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="flex justify-between items-center text-lg">
                        <span class="font-semibold text-gray-800">Total Pembayaran:</span>
                        <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Transaction Actions -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end gap-2">
                @if($item->status === 'pending')
                <form action="{{ route('kasir.transaksi.status', $item->id) }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="status" value="selesai">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-semibold transition-colors">
                        ✓ Setujui & Selesaikan
                    </button>
                </form>
                <form action="{{ route('kasir.transaksi.status', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin membatalkan transaksi ini?')">
                    @csrf
                    <input type="hidden" name="status" value="dibatalkan">
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm font-semibold transition-colors">
                        ✗ Batalkan
                    </button>
                </form>
                @endif
                <a href="{{ route('kasir.transaksi.show', $item->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm font-semibold transition-colors">
                    Detail
                </a>
                @if($item->status === 'selesai')
                <a href="{{ route('kasir.transaksi.print', $item->id) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-semibold transition-colors">
                    🖨 Cetak
                </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($transaksi->hasPages())
    <div class="bg-white p-4 rounded-lg shadow-md">
        {{ $transaksi->links() }}
    </div>
    @endif
    @else
    <div class="bg-white p-12 rounded-lg shadow-md text-center">
        <svg class="w-20 h-20 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Transaksi</h3>
        <p class="text-gray-600">Belum ada transaksi yang perlu diproses.</p>
    </div>
    @endif
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-bounce">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    {{ session('error') }}
</div>
@endif
@endsection
