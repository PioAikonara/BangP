@extends('layouts.dashboard')

@section('title', 'Tambah Barang')
@section('subtitle', 'Tambah data barang baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nama Barang -->
                <div class="md:col-span-2">
                    <label for="nama_barang" class="block text-sm font-medium text-gray-700 mb-2">Nama Barang <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_barang') border-red-500 @enderror">
                    @error('nama_barang')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" id="kategori" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kategori') border-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        <option value="Sembako" {{ old('kategori') == 'Sembako' ? 'selected' : '' }}>Sembako</option>
                        <option value="Minuman" {{ old('kategori') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                        <option value="Makanan" {{ old('kategori') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                        <option value="Toiletries" {{ old('kategori') == 'Toiletries' ? 'selected' : '' }}>Toiletries</option>
                        <option value="Protein" {{ old('kategori') == 'Protein' ? 'selected' : '' }}>Protein</option>
                        <option value="Pembersih" {{ old('kategori') == 'Pembersih' ? 'selected' : '' }}>Pembersih</option>
                    </select>
                    @error('kategori')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" id="stok" value="{{ old('stok') }}" required min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stok') border-red-500 @enderror">
                    @error('stok')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Beli -->
                <div>
                    <label for="harga_beli" class="block text-sm font-medium text-gray-700 mb-2">Harga Beli <span class="text-red-500">*</span></label>
                    <input type="number" name="harga_beli" id="harga_beli" value="{{ old('harga_beli') }}" required min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('harga_beli') border-red-500 @enderror">
                    @error('harga_beli')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Jual -->
                <div>
                    <label for="harga_jual" class="block text-sm font-medium text-gray-700 mb-2">Harga Jual <span class="text-red-500">*</span></label>
                    <input type="number" name="harga_jual" id="harga_jual" value="{{ old('harga_jual') }}" required min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('harga_jual') border-red-500 @enderror">
                    @error('harga_jual')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Diskon -->
                <div>
                    <label for="diskon" class="block text-sm font-medium text-gray-700 mb-2">Diskon (%)</label>
                    <input type="number" name="diskon" id="diskon" value="{{ old('diskon', 0) }}" min="0" max="100"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('diskon') border-red-500 @enderror">
                    @error('diskon')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Expired -->
                <div>
                    <label for="expired_at" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Expired</label>
                    <input type="date" name="expired_at" id="expired_at" value="{{ old('expired_at') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('expired_at') border-red-500 @enderror">
                    @error('expired_at')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ada tanggal kadaluarsa</p>
                </div>

                <!-- Gambar -->
                <div class="md:col-span-2">
                    <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                    <input type="file" name="gambar" id="gambar" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gambar') border-red-500 @enderror">
                    @error('gambar')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG (Max 2MB)</p>
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.barang.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-300">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
