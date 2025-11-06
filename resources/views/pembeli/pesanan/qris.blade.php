@extends('layouts.dashboard')

@section('title', 'Pembayaran QRIS')
@section('subtitle', 'Scan QR Code untuk menyelesaikan pembayaran')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Success Icon -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Terima kasih</h2>
            <p class="text-gray-600">Pesanan Anda telah diterima.</p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Order number:</span>
                    <span class="font-bold text-gray-800">{{ $transaksi->kode_transaksi }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Date</span>
                    <span class="font-semibold text-gray-800">{{ $transaksi->created_at->format('d F Y') }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Total</span>
                    <span class="font-bold text-gray-800">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Instructions -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 mb-6">
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                <p class="text-sm text-gray-700 text-center">
                    <span class="font-semibold">Total yang harus dibayar:</span>
                </p>
                <p class="text-3xl font-bold text-blue-600 text-center mt-2">
                    Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
            <h3 class="font-bold text-gray-800 text-center mb-4 uppercase tracking-wide">Informasi Pembayaran QRIS</h3>
            
            <div class="flex justify-center mb-6">
                <div class="bg-white p-4 rounded-lg border-4 border-gray-800">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode('BangP Store|' . $transaksi->kode_transaksi . '|' . $transaksi->total_harga) }}" 
                         alt="QR Code QRIS" 
                         class="w-64 h-64">
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 space-y-3">
                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3">1</div>
                    <p class="text-sm text-gray-700">Buka aplikasi mobile banking atau e-wallet Anda (GoPay, OVO, Dana, ShopeePay, dll)</p>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3">2</div>
                    <p class="text-sm text-gray-700">Pilih menu "Scan QR" atau "Bayar dengan QRIS"</p>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3">3</div>
                    <p class="text-sm text-gray-700">Scan QR Code di atas atau <strong>tunjukkan QR Code ini ke kasir</strong></p>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mr-3">4</div>
                    <p class="text-sm text-gray-700">Kasir akan mengkonfirmasi pembayaran Anda</p>
                </div>
            </div>

            <div class="mt-6 bg-orange-50 border-l-4 border-orange-400 p-4 rounded">
                <p class="text-sm text-orange-800">
                    <strong>Catatan:</strong> Tunjukkan halaman ini ke kasir saat melakukan pembayaran di toko. 
                    Kasir akan membantu Anda menyelesaikan transaksi.
                </p>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h3 class="font-bold text-gray-800 mb-4">Detail Pesanan</h3>
            <div class="space-y-3">
                @foreach($transaksi->details as $detail)
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">{{ $detail->barang->nama_barang }}</p>
                        <p class="text-xs text-gray-500">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</p>
                    </div>
                    <p class="font-semibold text-gray-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <div class="grid grid-cols-2 gap-3">
                <form action="{{ route('pembeli.pesanan.bayar-tunai', $transaksi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membayar tunai di kasir?')">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition-colors duration-300 font-semibold flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Bayar Tunai
                    </button>
                </form>
                <a href="{{ route('pembeli.pesanan.riwayat') }}" 
                   class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg hover:bg-blue-700 transition-colors duration-300 font-semibold">
                    Lihat Riwayat
                </a>
            </div>
            <a href="{{ route('pembeli.dashboard') }}" 
               class="block w-full bg-gray-100 text-gray-700 text-center py-3 rounded-lg hover:bg-gray-200 transition-colors duration-300 font-semibold">
                Kembali ke Beranda
            </a>
        </div>

        <!-- Help Text -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Butuh bantuan? 
                <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">Hubungi Customer Service</a>
            </p>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Nominal berhasil disalin!');
    }, function(err) {
        console.error('Gagal menyalin: ', err);
    });
}

// Auto refresh status setiap 30 detik
setInterval(function() {
    fetch('{{ route('pembeli.pesanan.riwayat') }}')
        .then(() => {
            // Check if payment is confirmed
            location.reload();
        });
}, 30000);
</script>
@endsection
