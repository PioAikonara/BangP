@extends('layouts.dashboard')

@section('title', 'Dasbor Pembeli')
@section('subtitle', 'Selamat datang di toko kami!')

@section('content')
<div class="space-y-6">
    <!-- Header Welcome -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-lg shadow-md text-white">
        <h2 class="text-2xl font-semibold">Selamat Datang di Market!</h2>
        <p class="mt-2">Dapatkan promo dan penawaran menarik khusus untuk Anda</p>
    </div>

    <!-- Promo & Program Section -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Promo & Program</h3>
            <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Lihat Semua</a>
        </div>

        <!-- Promo Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <!-- Hot Promo Card -->
            <div class="rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:scale-105 overflow-hidden">
                <img src="https://placehold.co/300x200/ff6b35/white?text=HOT+PROMO" alt="Hot Promo" class="w-full h-full object-cover">
            </div>

            <!-- Promo JSM Card -->
            <div class="rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:scale-105 overflow-hidden">
                <img src="https://placehold.co/300x200/4a90e2/white?text=PROMO+JSM" alt="Promo JSM" class="w-full h-full object-cover">
            </div>

            <!-- PSM Card -->
            <div class="rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:scale-105 overflow-hidden">
                <img src="https://placehold.co/300x200/50c9ce/white?text=PSM" alt="PSM" class="w-full h-full object-cover">
            </div>

            <!-- Promo Serba Card -->
            <div class="rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:scale-105 overflow-hidden">
                <img src="https://placehold.co/300x200/d32f2f/white?text=PROMO+SERBA" alt="Promo Serba" class="w-full h-full object-cover">
            </div>

            <!-- Member Only Card -->
            <div class="rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:scale-105 overflow-hidden">
                <img src="https://placehold.co/300x200/e91e63/white?text=MEMBER+ONLY" alt="Member Only" class="w-full h-full object-cover">
            </div>
        </div>
    </div>

    <!-- Produk Terbaru Section -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Produk Terbaru</h3>
            <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Lihat Semua</a>
        </div>

        @if(isset($barangTerbaru) && $barangTerbaru->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            @foreach($barangTerbaru as $barang)
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="aspect-square bg-gray-100 flex items-center justify-center">
                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div class="p-3">
                    <h4 class="font-semibold text-sm text-gray-800 mb-1 line-clamp-2">{{ $barang->nama_barang }}</h4>
                    @if($barang->diskon > 0)
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs text-gray-500 line-through">Rp {{ number_format($barang->harga, 0, ',', '.') }}</span>
                        <span class="bg-red-500 text-white text-xs px-1 rounded">{{ $barang->diskon }}%</span>
                    </div>
                    <p class="text-blue-600 font-bold text-sm">Rp {{ number_format($barang->harga_setelah_diskon, 0, ',', '.') }}</p>
                    @else
                    <p class="text-blue-600 font-bold text-sm">Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                    @endif
                    <p class="text-xs text-gray-500 mt-1">Stok: {{ $barang->stok }}</p>
                    <button class="mt-2 w-full bg-blue-600 text-white text-xs py-2 rounded hover:bg-blue-700 transition-colors duration-300">
                        Tambah ke Keranjang
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 text-gray-500">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p>Belum ada produk tersedia</p>
        </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('pembeli.pesanan.index') }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full mr-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Pesanan Saya</h4>
                    <p class="text-sm text-gray-600">Lihat status pesanan</p>
                </div>
            </div>
        </a>

        <a href="{{ route('pembeli.pesanan.keranjang') }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-full mr-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Keranjang</h4>
                    <p class="text-sm text-gray-600">Lihat keranjang belanja</p>
                </div>
            </div>
        </a>

        <a href="{{ route('pembeli.pesanan.riwayat') }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center">
                <div class="bg-yellow-100 p-3 rounded-full mr-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Riwayat</h4>
                    <p class="text-sm text-gray-600">Lihat riwayat pembelian</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
