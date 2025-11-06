@extends('layouts.dashboard')

@section('title', 'Belanja Produk')
@section('subtitle', 'Pilih produk yang Anda inginkan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Produk</h2>
        <p class="text-gray-600 mt-2">Pilih produk dan tambahkan ke keranjang belanja Anda</p>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white p-4 rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Cari produk..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Semua Kategori</option>
                    <option>Makanan</option>
                    <option>Minuman</option>
                    <option>Kebutuhan Rumah</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    @if($barang->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        @foreach($barang as $item)
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <!-- Product Image -->
            <div class="aspect-square bg-gray-100 flex items-center justify-center relative p-3">
                @if($item->diskon > 0)
                <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded z-10">
                    -{{ $item->diskon }}%
                </div>
                @endif
                @if($item->gambar)
                    <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->nama_barang }}" class="max-w-full max-h-full object-contain">
                @else
                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                @endif
                @if($item->stok < 10)
                <div class="absolute bottom-2 left-2 bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded z-10">
                    Stok Terbatas
                </div>
                @endif
            </div>
            
            <!-- Product Info -->
            <div class="p-4">
                <h4 class="font-semibold text-sm text-gray-800 mb-2 line-clamp-2 min-h-[40px]">{{ $item->nama_barang }}</h4>
                
                <!-- Price -->
                <div class="mb-2">
                    @if($item->diskon > 0)
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs text-gray-500 line-through">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-blue-600 font-bold text-lg">Rp {{ number_format($item->harga_setelah_diskon, 0, ',', '.') }}</p>
                    @else
                    <p class="text-blue-600 font-bold text-lg">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</p>
                    @endif
                </div>

                <!-- Stock Info -->
                <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                    <span>Stok: {{ $item->stok }}</span>
                    @if($item->expired_at)
                    <span>Exp: {{ $item->expired_at->format('d/m/Y') }}</span>
                    @endif
                </div>

                <!-- Add to Cart Button -->
                <form action="{{ route('pembeli.pesanan.tambah-keranjang') }}" method="POST">
                    @csrf
                    <input type="hidden" name="barang_id" value="{{ $item->id }}">
                    <div class="flex items-center gap-2 mb-2">
                        <input type="number" name="jumlah" value="1" min="1" max="{{ $item->stok }}" 
                            class="w-16 px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-xs text-gray-500">pcs</span>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white text-sm py-2 rounded hover:bg-blue-700 transition-colors duration-300 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Tambah
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="bg-white p-4 rounded-lg shadow-md">
        {{ $barang->links() }}
    </div>
    @else
    <div class="bg-white p-12 rounded-lg shadow-md text-center">
        <svg class="w-20 h-20 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Produk Tersedia</h3>
        <p class="text-gray-600">Maaf, saat ini belum ada produk yang tersedia untuk dibeli.</p>
    </div>
    @endif
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
    {{ session('error') }}
</div>
@endif
@endsection
