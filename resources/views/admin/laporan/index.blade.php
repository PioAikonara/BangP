@extends('layouts.dashboard')

@section('title', 'Laporan Penjualan')
@section('subtitle', 'Laporan transaksi dan penjualan')

@section('content')
<div class="space-y-6">
    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Laporan</h3>
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="tanggal_awal" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" id="tanggal_awal" value="{{ request('tanggal_awal', date('Y-m-01')) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ request('tanggal_akhir', date('Y-m-d')) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    @if(isset($totalTransaksi))
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <p class="text-sm text-gray-600 mb-1">Total Transaksi</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalTransaksi }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <p class="text-sm text-gray-600 mb-1">Total Penjualan</p>
            <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <p class="text-sm text-gray-600 mb-1">Total Diskon</p>
            <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalDiskon, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <p class="text-sm text-gray-600 mb-1">Total Keuntungan</p>
            <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</p>
        </div>
    </div>
    @endif

    <!-- Transactions Table -->
    @if(isset($transaksi))
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Transaksi</h3>
                <div class="flex space-x-2">
                    <button onclick="window.print()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print
                    </button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kasir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diskon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keuntungan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transaksi as $index => $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $item->kode_transaksi }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->kasir->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->member->nama_member ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            Rp {{ number_format($item->diskon, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                            Rp {{ number_format($item->keuntungan, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($item->status == 'selesai')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Selesai
                                </span>
                            @elseif($item->status == 'pending')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Batal
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                            Tidak ada data transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    window.addEventListener('beforeprint', function() {
        document.querySelector('aside').style.display = 'none';
        document.querySelector('nav').style.display = 'none';
    });
    
    window.addEventListener('afterprint', function() {
        document.querySelector('aside').style.display = 'block';
        document.querySelector('nav').style.display = 'block';
    });
</script>
@endpush
@endsection
