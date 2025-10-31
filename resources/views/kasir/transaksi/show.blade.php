@extends('layouts.dashboard')

@section('title', 'Detail Transaksi')
@section('subtitle', 'Informasi lengkap transaksi')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('kasir.transaksi.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Transaksi
        </a>
    </div>

    <!-- Transaction Header Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 text-white">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold">{{ $transaksi->kode_transaksi }}</h2>
                    <p class="text-blue-100 mt-1">{{ $transaksi->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
                <div class="flex flex-col items-start md:items-end gap-2">
                    <span class="px-4 py-2 rounded-full text-sm font-semibold
                        @if($transaksi->status === 'selesai') bg-green-500
                        @elseif($transaksi->status === 'pending') bg-yellow-500
                        @else bg-red-500 @endif">
                        @if($transaksi->status === 'selesai')
                            ✓ Transaksi Selesai
                        @elseif($transaksi->status === 'pending')
                            ⏳ Menunggu Pembayaran
                        @else
                            ✗ Transaksi Dibatalkan
                        @endif
                    </span>
                    <span class="px-4 py-2 bg-white text-blue-600 rounded-full text-sm font-semibold">
                        {{ ucfirst($transaksi->metode_pembayaran ?? 'Tunai') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Customer & Cashier Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-gray-50">
            <!-- Customer Info -->
            <div class="bg-white p-4 rounded-lg border border-gray-200">
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Informasi Pembeli</h3>
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $transaksi->member->user->name ?? 'Pelanggan Umum' }}</p>
                            <p class="text-sm text-gray-600">{{ $transaksi->member->user->email ?? '-' }}</p>
                        </div>
                    </div>
                    @if($transaksi->member)
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <p class="text-sm text-gray-600">No. Telepon: {{ $transaksi->member->no_telp ?? '-' }}</p>
                        <p class="text-sm text-gray-600">Alamat: {{ $transaksi->member->alamat ?? '-' }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Cashier Info -->
            <div class="bg-white p-4 rounded-lg border border-gray-200">
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Informasi Kasir</h3>
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $transaksi->kasir->name ?? 'Admin' }}</p>
                            <p class="text-sm text-gray-600">{{ $transaksi->kasir->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Items -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Detail Produk</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if($transaksi->details && $transaksi->details->count() > 0)
                        @foreach($transaksi->details as $index => $detail)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $detail->barang->nama_barang ?? 'Produk' }}</p>
                                        <p class="text-xs text-gray-500">Kode: {{ $detail->barang->kode_barang ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">
                                    {{ $detail->jumlah }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 text-right">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada detail produk
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="px-6 py-4 bg-gray-50 border-t-2 border-gray-200">
            <div class="max-w-sm ml-auto space-y-2">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Subtotal:</span>
                    <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
                @if($transaksi->diskon > 0)
                <div class="flex justify-between text-sm text-green-600">
                    <span>Diskon:</span>
                    <span>- Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t border-gray-300">
                    <span>Total Pembayaran:</span>
                    <span class="text-blue-600">Rp {{ number_format($transaksi->total_harga - $transaksi->diskon, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex flex-wrap gap-3 justify-end">
            @if($transaksi->status === 'pending')
                <form action="{{ route('kasir.transaksi.status', $transaksi->id) }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="status" value="selesai">
                    <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Setujui & Selesaikan Transaksi
                    </button>
                </form>
                <form action="{{ route('kasir.transaksi.status', $transaksi->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin membatalkan transaksi ini?')">
                    @csrf
                    <input type="hidden" name="status" value="dibatalkan">
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batalkan Transaksi
                    </button>
                </form>
            @endif
            @if($transaksi->status === 'selesai')
                <a href="{{ route('kasir.transaksi.print', $transaksi->id) }}" target="_blank" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Struk
                </a>
            @endif
            <a href="{{ route('kasir.transaksi.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold transition-colors">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
