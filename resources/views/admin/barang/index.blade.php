@extends('layouts.dashboard')

@section('title', 'Data Barang')
@section('subtitle', 'Kelola data barang/produk')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Daftar Barang</h3>
            <p class="text-sm text-gray-600">Total: {{ $barang->total() }} produk</p>
        </div>
        <a href="{{ route('admin.barang.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Barang
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-md p-4">
        <form method="GET" action="{{ route('admin.barang.index') }}" class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang..." 
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <select name="kategori" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Kategori</option>
                <option value="Sembako" {{ request('kategori') == 'Sembako' ? 'selected' : '' }}>Sembako</option>
                <option value="Minuman" {{ request('kategori') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                <option value="Makanan" {{ request('kategori') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="Toiletries" {{ request('kategori') == 'Toiletries' ? 'selected' : '' }}>Toiletries</option>
                <option value="Protein" {{ request('kategori') == 'Protein' ? 'selected' : '' }}>Protein</option>
                <option value="Pembersih" {{ request('kategori') == 'Pembersih' ? 'selected' : '' }}>Pembersih</option>
            </select>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Cari
            </button>
            @if(request('search') || request('kategori'))
                <a href="{{ route('admin.barang.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
        @forelse($barang as $index => $item)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-all duration-200 overflow-hidden group flex flex-col">
            <!-- Image -->
            <div class="relative bg-gray-50 h-32 flex items-center justify-center overflow-hidden p-2 flex-shrink-0">
                @if($item->gambar)
                    <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->nama_barang }}" class="max-w-full max-h-full object-contain group-hover:scale-105 transition-transform duration-200">
                @else
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                @endif
                
                <!-- Diskon Badge -->
                @if($item->diskon > 0)
                    <div class="absolute top-1 right-1 bg-red-500 text-white px-1.5 py-0.5 rounded text-[10px] font-bold z-10">
                        -{{ $item->diskon }}%
                    </div>
                @endif
                
                <!-- Stok Badge -->
                <div class="absolute bottom-1 left-1 z-10">
                    @if($item->stok < 10)
                        <span class="px-1.5 py-0.5 text-[10px] font-semibold rounded bg-red-500 text-white">
                            {{ $item->stok }}
                        </span>
                    @elseif($item->stok < 50)
                        <span class="px-1.5 py-0.5 text-[10px] font-semibold rounded bg-yellow-500 text-white">
                            {{ $item->stok }}
                        </span>
                    @else
                        <span class="px-1.5 py-0.5 text-[10px] font-semibold rounded bg-green-500 text-white">
                            {{ $item->stok }}
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Content -->
            <div class="p-2 flex-1 flex flex-col">
                <!-- Kategori -->
                <span class="inline-block px-2 py-0.5 text-[10px] font-medium rounded-full bg-blue-100 text-blue-700 mb-1 w-fit">
                    {{ $item->kategori }}
                </span>
                
                <!-- Nama Barang -->
                <h3 class="font-semibold text-gray-900 text-xs mb-1 line-clamp-2 min-h-[32px]">
                    {{ $item->nama_barang }}
                </h3>
                
                <!-- Harga -->
                <div class="mb-1.5 flex-grow">
                    @if($item->diskon > 0)
                        <div class="text-[10px] text-gray-400 line-through">
                            Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                        </div>
                        <div class="text-sm font-bold text-blue-600">
                            Rp {{ number_format($item->harga_setelah_diskon, 0, ',', '.') }}
                        </div>
                    @else
                        <div class="text-sm font-bold text-gray-900">
                            Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                        </div>
                    @endif
                </div>
                
                <!-- Info -->
                <div class="text-[10px] text-gray-500 mb-2 space-y-0.5">
                    <div class="truncate">Modal: Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</div>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mr-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="truncate">
                            @if($item->expired_at)
                                {{ \Carbon\Carbon::parse($item->expired_at)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </span>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex gap-1 mt-auto">
                    <a href="{{ route('admin.barang.edit', $item->id) }}" 
                        class="flex-1 px-2 py-1.5 bg-blue-600 text-white text-[10px] rounded hover:bg-blue-700 transition-colors flex items-center justify-center">
                        <svg class="w-3 h-3 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.barang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?')" class="flex-shrink-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1.5 bg-red-600 text-white text-[10px] rounded hover:bg-red-700 transition-colors flex items-center justify-center h-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="col-span-full bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="w-20 h-20 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-xl font-medium text-gray-700 mb-2">Belum ada data barang</p>
            <p class="text-gray-500 mb-6">Klik tombol "Tambah Barang" untuk menambah produk baru</p>
            <a href="{{ route('admin.barang.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Barang Pertama
            </a>
        </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    @if($barang->hasPages())
    <div class="bg-white rounded-lg shadow-md p-4">
        {{ $barang->links() }}
    </div>
    @endif
</div>
@endsection
