@extends('layouts.dashboard')

@section('title', 'Keranjang Belanja')
@section('subtitle', 'Periksa item Anda sebelum checkout')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Keranjang Belanja</h2>
                <p class="text-gray-600 mt-1">Periksa produk sebelum melakukan pembayaran</p>
            </div>
            <a href="{{ route('pembeli.pesanan.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                ← Lanjut Belanja
            </a>
        </div>
    </div>

    @if(empty($keranjang) || count($keranjang) == 0)
        <!-- Empty Cart -->
        <div class="bg-white p-12 rounded-lg shadow-md text-center">
            <svg class="w-20 h-20 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Keranjang Anda Kosong</h3>
            <p class="text-gray-600 mb-6">Belum ada produk yang ditambahkan ke keranjang.</p>
            <a href="{{ route('pembeli.pesanan.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($keranjang as $index => $item)
                @php
                    $barang = \App\Models\Barang::find($item['barang_id']);
                @endphp
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4 flex gap-4">
                        <!-- Product Image -->
                        <div class="w-24 h-24 bg-gray-100 rounded flex items-center justify-center flex-shrink-0">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>

                        <!-- Product Info -->
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800 mb-1">{{ $barang->nama_barang ?? 'Produk' }}</h4>
                            <p class="text-blue-600 font-bold text-lg mb-2">
                                Rp {{ number_format($barang->harga_setelah_diskon ?? 0, 0, ',', '.') }}
                            </p>
                            
                            <!-- Quantity Controls -->
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-600">Jumlah:</span>
                                <div class="flex items-center border border-gray-300 rounded">
                                    <button class="px-3 py-1 hover:bg-gray-100" onclick="updateQuantity({{ $index }}, -1)">-</button>
                                    <span class="px-4 py-1 border-x border-gray-300">{{ $item['jumlah'] }}</span>
                                    <button class="px-3 py-1 hover:bg-gray-100" onclick="updateQuantity({{ $index }}, 1)">+</button>
                                </div>
                                <span class="text-sm text-gray-500">Stok: {{ $barang->stok ?? 0 }}</span>
                            </div>
                        </div>

                        <!-- Subtotal & Remove -->
                        <div class="text-right flex flex-col justify-between">
                            <p class="font-bold text-gray-800 text-lg">
                                Rp {{ number_format(($barang->harga_setelah_diskon ?? 0) * $item['jumlah'], 0, ',', '.') }}
                            </p>
                            <form action="{{ route('pembeli.pesanan.hapus-keranjang', $index) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Belanja</h3>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-gray-600">
                            <span>Total Item</span>
                            <span>{{ count($keranjang) }} produk</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Diskon</span>
                            <span class="text-green-600">- Rp 0</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-800">Total Pembayaran</span>
                            <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('pembeli.pesanan.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors duration-300 font-semibold">
                            Checkout Sekarang
                        </button>
                    </form>

                    <a href="{{ route('pembeli.pesanan.index') }}" class="block text-center mt-3 text-blue-600 hover:text-blue-800 text-sm">
                        Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
    {{ session('error') }}
</div>
@endif
@endsection
