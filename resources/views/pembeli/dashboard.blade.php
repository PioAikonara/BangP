@extends('layouts.dashboard')

@section('title', 'Dasbor Pembeli')
@section('subtitle', 'Selamat datang di toko kami!')

@section('content')
<div class="space-y-6">
    <!-- Header Welcome -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-lg shadow-md text-white">
        <h1 class="text-2xl font-bold mb-2">🎉 Selamat Datang!</h1>
        <p class="text-blue-50">Temukan berbagai promo menarik dan produk berkualitas</p>
    </div>

    <!-- Promo & Program Section -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">🎁 Promo & Program</h2>
            <a href="#" class="text-blue-600 hover:text-blue-700 font-medium text-sm">Lihat Semua →</a>
        </div>
        
        <!-- Promo Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <!-- Hot Promo -->
            <div class="rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:scale-105 overflow-hidden bg-gradient-to-br from-red-500 to-orange-500 p-6 flex items-center justify-center">
                <div class="text-center text-white">
                    <div class="text-4xl mb-2">🔥</div>
                    <h3 class="font-bold text-lg">HOT PROMO</h3>
                    <p class="text-sm mt-1 opacity-90">Diskon s/d 50%</p>
                </div>
            </div>

            <!-- Promo JSM -->
            <div class="rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:scale-105 overflow-hidden bg-gradient-to-br from-yellow-400 to-orange-500 p-6 flex items-center justify-center">
                <div class="text-center text-white">
                    <div class="text-4xl mb-2">⭐</div>
                    <h3 class="font-bold text-lg">PROMO JSM</h3>
                    <p class="text-sm mt-1 opacity-90">Jum'at - Minggu</p>
                </div>
            </div>

            <!-- PSM -->
            <div class="rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:scale-105 overflow-hidden bg-gradient-to-br from-purple-500 to-pink-500 p-6 flex items-center justify-center">
                <div class="text-center text-white">
                    <div class="text-4xl mb-2">🎉</div>
                    <h3 class="font-bold text-lg">PSM</h3>
                    <p class="text-sm mt-1 opacity-90">Promo Spesial Member</p>
                </div>
            </div>

            <!-- Promo Serba -->
            <div class="rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:scale-105 overflow-hidden bg-gradient-to-br from-green-500 to-teal-500 p-6 flex items-center justify-center">
                <div class="text-center text-white">
                    <div class="text-4xl mb-2">💰</div>
                    <h3 class="font-bold text-lg">PROMO SERBA</h3>
                    <p class="text-sm mt-1 opacity-90">Hemat Banget!</p>
                </div>
            </div>

            <!-- Member Only -->
            <div class="rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:scale-105 overflow-hidden bg-gradient-to-br from-blue-500 to-indigo-600 p-6 flex items-center justify-center">
                <div class="text-center text-white">
                    <div class="text-4xl mb-2">👑</div>
                    <h3 class="font-bold text-lg">MEMBER ONLY</h3>
                    <p class="text-sm mt-1 opacity-90">Eksklusif Member</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Kategori Section -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">📂 Kategori</h2>
            <a href="#" class="text-blue-600 hover:text-blue-700 font-medium text-sm">Lihat Semua →</a>
        </div>
        
        <!-- Kategori Grid -->
        <div class="grid grid-cols-3 md:grid-cols-6 lg:grid-cols-8 gap-4">
            <!-- Bakery -->
            <div class="flex flex-col items-center p-4 rounded-xl bg-purple-100 hover:bg-purple-200 transition-all cursor-pointer">
                <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-2">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-gray-700">Bakery</span>
            </div>

            <!-- Burger -->
            <div class="flex flex-col items-center p-4 rounded-xl bg-gray-100 hover:bg-gray-200 transition-all cursor-pointer">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mb-2 shadow-sm">
                    <span class="text-2xl">🍔</span>
                </div>
                <span class="text-xs font-semibold text-gray-700">Burger</span>
            </div>

            <!-- Beverage -->
            <div class="flex flex-col items-center p-4 rounded-xl bg-gray-100 hover:bg-gray-200 transition-all cursor-pointer">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mb-2 shadow-sm">
                    <span class="text-2xl">🥤</span>
                </div>
                <span class="text-xs font-semibold text-gray-700">Minuman</span>
            </div>

            <!-- Chicken -->
            <div class="flex flex-col items-center p-4 rounded-xl bg-gray-100 hover:bg-gray-200 transition-all cursor-pointer">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mb-2 shadow-sm">
                    <span class="text-2xl">🍗</span>
                </div>
                <span class="text-xs font-semibold text-gray-700">Ayam</span>
            </div>

            <!-- Pizza -->
            <div class="flex flex-col items-center p-4 rounded-xl bg-gray-100 hover:bg-gray-200 transition-all cursor-pointer">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mb-2 shadow-sm">
                    <span class="text-2xl">🍕</span>
                </div>
                <span class="text-xs font-semibold text-gray-700">Pizza</span>
            </div>

            <!-- Seafood -->
            <div class="flex flex-col items-center p-4 rounded-xl bg-gray-100 hover:bg-gray-200 transition-all cursor-pointer">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mb-2 shadow-sm">
                    <span class="text-2xl">🦐</span>
                </div>
                <span class="text-xs font-semibold text-gray-700">Seafood</span>
            </div>

            <!-- Snack -->
            <div class="flex flex-col items-center p-4 rounded-xl bg-gray-100 hover:bg-gray-200 transition-all cursor-pointer">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mb-2 shadow-sm">
                    <span class="text-2xl">🍿</span>
                </div>
                <span class="text-xs font-semibold text-gray-700">Snack</span>
            </div>

            <!-- Dessert -->
            <div class="flex flex-col items-center p-4 rounded-xl bg-gray-100 hover:bg-gray-200 transition-all cursor-pointer">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mb-2 shadow-sm">
                    <span class="text-2xl">🍰</span>
                </div>
                <span class="text-xs font-semibold text-gray-700">Dessert</span>
            </div>
        </div>
    </div>

    <!-- Produk Terbaru Section -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-800 mb-4">🛒 Produk Terbaru</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($barangTerbaru as $barang)
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="aspect-square bg-gray-100 flex items-center justify-center p-3">
                    @if($barang->gambar)
                        <img src="{{ Storage::url($barang->gambar) }}" alt="{{ $barang->nama_barang }}" class="max-w-full max-h-full object-contain">
                    @else
                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    @endif
                </div>
                <div class="p-3">
                    <h3 class="font-semibold text-sm text-gray-800 mb-1 truncate">{{ $barang->nama_barang }}</h3>
                    <div class="flex items-center justify-between mb-2">
                        @if($barang->diskon > 0)
                        <div>
                            <p class="text-xs text-gray-400 line-through">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</p>
                            <p class="text-sm font-bold text-blue-600">Rp {{ number_format($barang->harga_setelah_diskon, 0, ',', '.') }}</p>
                        </div>
                        @else
                        <p class="text-sm font-bold text-gray-800">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</p>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mb-2">Stok: {{ $barang->stok }}</p>
                    <form action="{{ route('pembeli.pesanan.tambah-keranjang') }}" method="POST">
                        @csrf
                        <input type="hidden" name="barang_id" value="{{ $barang->id }}">
                        <input type="hidden" name="jumlah" value="1">
                        <button type="submit" class="w-full bg-blue-600 text-white text-xs py-2 rounded hover:bg-blue-700 transition-colors">
                            + Keranjang
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-8 text-gray-500">
                Belum ada produk tersedia
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection