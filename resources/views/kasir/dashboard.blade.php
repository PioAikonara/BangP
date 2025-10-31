@extends('layouts.dashboard')

@section('title', 'Dashboard Kasir')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Transaksi Hari Ini -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm text-gray-500 mb-1 font-medium">Transaksi Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $transaksiHariIni }}</p>
                </div>
                <div class="bg-blue-500 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Penjualan -->
        <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-md p-6 text-white hover:shadow-lg transition duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm text-green-50 mb-1 font-medium">Total Penjualan</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stok Menipis -->
        <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-xl shadow-md p-6 text-white hover:shadow-lg transition duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm text-orange-50 mb-1 font-medium">Stok Menipis</p>
                    <p class="text-3xl font-bold">{{ $stokMenupis->count() }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Akan Kedaluwarsa -->
        <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl shadow-md p-6 text-white hover:shadow-lg transition duration-200">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm text-purple-50 mb-1 font-medium">Akan Kedaluwarsa</p>
                    <p class="text-3xl font-bold">{{ $akanExpired->count() }}</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="bg-white rounded-xl shadow-md mb-6">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Daftar Transaksi Terbaru</h3>
            <div class="rounded-lg overflow-hidden border border-gray-200">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NOMOR</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">PELANGGAN</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">TOTAL BAYAR</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">STATUS</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">TANGGAL</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($transaksiTerbaru as $transaksi)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 text-sm text-gray-700">#{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $transaksi->member?->nama_member ?? 'Umum' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($transaksi->status === 'selesai') bg-green-100 text-green-800
                                    @elseif($transaksi->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($transaksi->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Belum ada transaksi hari ini
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Stok Menipis dan Akan Kedaluwarsa -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Stok Menipis -->
        <div class="bg-white rounded-xl shadow-md">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Barang Stok Menipis</h3>
                <div class="rounded-lg overflow-hidden border border-gray-200">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NAMA BARANG</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">SISA STOK</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse($stokMenupis as $barang)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $barang->nama_barang }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $barang->stok }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                        Semua stok dalam jumlah aman
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Akan Kedaluwarsa -->
        <div class="bg-white rounded-xl shadow-md">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Barang Mendekati Kedaluwarsa</h3>
                <div class="rounded-lg overflow-hidden border border-gray-200">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NAMA BARANG</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">TANGGAL KEDALUWARSA</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse($akanExpired as $barang)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $barang->nama_barang }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $barang->expired_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Tidak ada barang yang mendekati kedaluwarsa
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection