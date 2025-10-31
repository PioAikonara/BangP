@extends('layouts.dashboard')

@section('title', 'Detail Member')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Member</h1>
        <div class="space-x-2">
            <a href="{{ route('kasir.member.edit', $member) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2.5 px-5 rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('kasir.member.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2.5 px-5 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Informasi Member -->
        <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Informasi Member</h3>
                            
                            <div class="mb-4 text-center">
                                <div class="bg-gradient-to-br from-blue-500 to-purple-600 text-white rounded-lg p-6 mb-4">
                                    <i class="fas fa-id-card text-4xl mb-2"></i>
                                    <p class="text-sm font-semibold">{{ $member->kode_member }}</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="text-xs text-gray-500 uppercase">Nama</label>
                                    <p class="text-gray-900 font-semibold">{{ $member->nama_member }}</p>
                                </div>

                                <div>
                                    <label class="text-xs text-gray-500 uppercase">No. HP</label>
                                    <p class="text-gray-900">{{ $member->no_hp }}</p>
                                </div>

                                <div>
                                    <label class="text-xs text-gray-500 uppercase">Alamat</label>
                                    <p class="text-gray-900">{{ $member->alamat ?? '-' }}</p>
                                </div>

                                <div>
                                    <label class="text-xs text-gray-500 uppercase">Diskon</label>
                                    <p class="text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $member->diskon }}%
                                        </span>
                                    </p>
                                </div>

                                @if($member->user)
                                <div>
                                    <label class="text-xs text-gray-500 uppercase">Email Akun</label>
                                    <p class="text-gray-900">{{ $member->user->email }}</p>
                                </div>
                                @endif

                                <div>
                                    <label class="text-xs text-gray-500 uppercase">Terdaftar</label>
                                    <p class="text-gray-900">{{ $member->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Statistik</h3>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Total Transaksi</span>
                                    <span class="font-bold text-blue-600">{{ $member->transaksi->count() }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Total Belanja</span>
                                    <span class="font-bold text-green-600">Rp {{ number_format($member->transaksi->sum('total_harga'), 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Transaksi -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Riwayat Transaksi</h3>
                            
                            @if($member->transaksi->count() > 0)
                                <div class="space-y-4">
                                    @foreach($member->transaksi->sortByDesc('created_at') as $transaksi)
                                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <p class="font-semibold text-gray-900">Transaksi #{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</p>
                                                    <p class="text-sm text-gray-500">{{ $transaksi->created_at->format('d M Y, H:i') }}</p>
                                                </div>
                                                <div>
                                                    @if($transaksi->status === 'pending')
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Pending
                                                        </span>
                                                    @elseif($transaksi->status === 'selesai')
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                            Selesai
                                                        </span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                            Dibatalkan
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="border-t pt-2 mt-2">
                                                <div class="flex justify-between items-center">
                                                    <div>
                                                        <p class="text-sm text-gray-600">{{ $transaksi->details->count() }} item</p>
                                                        <p class="text-sm text-gray-600">Kasir: {{ $transaksi->kasir->name ?? 'N/A' }}</p>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="text-lg font-bold text-gray-900">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                                                        <a href="{{ route('kasir.transaksi.show', $transaksi) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                                            Lihat Detail →
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-receipt text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-500">Belum ada riwayat transaksi</p>
                                </div>
                            @endif
                        </div>
                    </div>
        </div>
    </div>
</div>
@endsection
