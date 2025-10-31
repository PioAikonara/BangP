@extends('layouts.dashboard')

@section('title', 'Edit Member')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Member</h1>
        <a href="{{ route('kasir.member.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2.5 px-5 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <!-- Card Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 max-w-3xl">
        <div class="p-6">
                    <form action="{{ route('kasir.member.update', $member) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Kode Member
                            </label>
                            <input type="text" value="{{ $member->kode_member }}" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-500" 
                                disabled>
                            <p class="text-gray-500 text-xs mt-1">Kode member tidak dapat diubah</p>
                        </div>

                        <div class="mb-5">
                            <label for="nama_member" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Member <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_member" id="nama_member" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('nama_member') border-red-500 @enderror" 
                                value="{{ old('nama_member', $member->nama_member) }}" 
                                placeholder="Masukkan nama member"
                                required>
                            @error('nama_member')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="no_hp" class="block text-sm font-semibold text-gray-700 mb-2">
                                No. HP <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="no_hp" id="no_hp" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('no_hp') border-red-500 @enderror" 
                                value="{{ old('no_hp', $member->no_hp) }}" 
                                placeholder="08123456789"
                                required>
                            @error('no_hp')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat
                            </label>
                            <textarea name="alamat" id="alamat" rows="3"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('alamat') border-red-500 @enderror"
                                placeholder="Masukkan alamat lengkap (opsional)">{{ old('alamat', $member->alamat) }}</textarea>
                            @error('alamat')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('kasir.member.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2.5 px-6 rounded-lg transition duration-200">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg transition duration-200 shadow-sm">
                                <i class="fas fa-save mr-2"></i>Update
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
