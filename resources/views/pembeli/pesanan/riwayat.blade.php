@extends('layouts.dashboard')

@section('title', 'Riwayat Pesanan')
@section('subtitle', 'Lihat riwayat pesanan Anda')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800">Riwayat Pesanan Saya</h2>
        <p class="text-gray-600 mt-2">Daftar semua pesanan yang pernah Anda buat</p>
    </div>

    <!-- Filter Status -->
    <div class="bg-white p-4 rounded-lg shadow-md">
        <div class="flex gap-2 overflow-x-auto">
            <a href="{{ route('pembeli.pesanan.riwayat') }}" 
               class="px-4 py-2 {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} rounded-lg whitespace-nowrap transition-colors">
                Semua
            </a>
            <a href="{{ route('pembeli.pesanan.riwayat', ['status' => 'pending']) }}" 
               class="px-4 py-2 {{ request('status') == 'pending' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} rounded-lg whitespace-nowrap transition-colors">
                Menunggu
            </a>
            <a href="{{ route('pembeli.pesanan.riwayat', ['status' => 'selesai']) }}" 
               class="px-4 py-2 {{ request('status') == 'selesai' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} rounded-lg whitespace-nowrap transition-colors">
                Selesai
            </a>
            <a href="{{ route('pembeli.pesanan.riwayat', ['status' => 'dibatalkan']) }}" 
               class="px-4 py-2 {{ request('status') == 'dibatalkan' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }} rounded-lg whitespace-nowrap transition-colors">
                Dibatalkan
            </a>
        </div>
    </div>

    <!-- Orders List -->
    @if(isset($pesanan) && $pesanan->count() > 0)
    <div class="space-y-4">
        @foreach($pesanan as $item)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Order Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                    <div>
                        <h3 class="font-semibold text-gray-800">Pesanan #{{ $item->no_transaksi }}</h3>
                        <p class="text-sm text-gray-600">{{ $item->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            @if($item->status === 'selesai') bg-green-100 text-green-800
                            @elseif($item->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            @if($item->status === 'selesai')
                                Selesai
                            @elseif($item->status === 'pending')
                                Menunggu Pembayaran
                            @else
                                Dibatalkan
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="px-6 py-4">
                <div class="space-y-3">
                    @if($item->details && $item->details->count() > 0)
                        @foreach($item->details as $detail)
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gray-100 rounded flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $detail->barang->nama_barang ?? 'Produk' }}</h4>
                                <p class="text-sm text-gray-600">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-center py-4">Detail pesanan tidak tersedia</p>
                    @endif
                </div>

                <!-- Total -->
                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                    <span class="font-semibold text-gray-800">Total Pembayaran:</span>
                    <span class="text-xl font-bold text-blue-600">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Order Actions -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end gap-2">
                <a href="#" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm">Detail</a>
                @if($item->status === 'selesai')
                <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Beli Lagi</a>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($pesanan->hasPages())
    <div class="bg-white p-4 rounded-lg shadow-md">
        {{ $pesanan->links() }}
    </div>
    @endif
    @else
    <div class="bg-white p-12 rounded-lg shadow-md text-center">
        <svg class="w-20 h-20 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
        </svg>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Pesanan</h3>
        <p class="text-gray-600 mb-4">Anda belum pernah melakukan pesanan.</p>
        <a href="{{ route('pembeli.pesanan.index') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Mulai Belanja
        </a>
    </div>
    @endif
</div>
@endsection
