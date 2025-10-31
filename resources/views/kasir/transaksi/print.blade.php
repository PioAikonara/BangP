<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi #{{ $transaksi->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            padding: 20px;
            background: white;
        }
        
        .struk {
            max-width: 300px;
            margin: 0 auto;
            background: white;
        }
        
        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        
        .store-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .store-info {
            font-size: 11px;
            margin-bottom: 2px;
        }
        
        .transaction-info {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #000;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        
        .label {
            font-weight: bold;
        }
        
        .items {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #000;
        }
        
        .item {
            margin-bottom: 8px;
        }
        
        .item-name {
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .item-details {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }
        
        .totals {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #000;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        
        .grand-total {
            font-size: 14px;
            font-weight: bold;
            margin-top: 5px;
            padding-top: 5px;
            border-top: 1px solid #000;
        }
        
        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 10px;
        }
        
        .footer p {
            margin-bottom: 3px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .status-pending {
            background: #FEF3C7;
            color: #92400E;
        }
        
        .status-selesai {
            background: #D1FAE5;
            color: #065F46;
        }
        
        .status-dibatalkan {
            background: #FEE2E2;
            color: #991B1B;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
            
            @page {
                margin: 0;
                size: 80mm auto;
            }
        }
        
        .print-button {
            text-align: center;
            margin: 20px 0;
        }
        
        .btn-print {
            background: #3B82F6;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
        
        .btn-print:hover {
            background: #2563EB;
        }
    </style>
</head>
<body>
    <div class="print-button no-print">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Struk</button>
        <button class="btn-print" style="background: #6B7280; margin-left: 10px;" onclick="window.close()">✕ Tutup</button>
    </div>

    <div class="struk">
        <!-- Header Toko -->
        <div class="header">
            <div class="store-name">{{ $setting->nama_toko ?? 'BangP Store' }}</div>
            <div class="store-info">{{ $setting->alamat_toko ?? 'Jl. Raya No. 123' }}</div>
            <div class="store-info">Telp: {{ $setting->telepon ?? '0812-3456-7890' }}</div>
        </div>

        <!-- Info Transaksi -->
        <div class="transaction-info">
            <div class="info-row">
                <span class="label">No. Transaksi</span>
                <span>#{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-row">
                <span class="label">Tanggal</span>
                <span>{{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="label">Kasir</span>
                <span>{{ $transaksi->kasir->name ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Member</span>
                <span>{{ $transaksi->member->user->name ?? 'Umum' }}</span>
            </div>
            @if($transaksi->member)
            <div class="info-row">
                <span class="label">No. Member</span>
                <span>{{ $transaksi->member->kode_member }}</span>
            </div>
            @endif
            <div class="info-row">
                <span class="label">Status</span>
                <span class="status-badge status-{{ $transaksi->status }}">
                    {{ strtoupper($transaksi->status) }}
                </span>
            </div>
        </div>

        <!-- Daftar Barang -->
        <div class="items">
            @foreach($transaksi->details as $detail)
            <div class="item">
                <div class="item-name">{{ $detail->barang->nama_barang ?? 'Produk' }}</div>
                <div class="item-details">
                    <span>{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</span>
                    <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Total -->
        <div class="totals">
            <div class="total-row">
                <span class="label">Subtotal</span>
                <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
            @if($transaksi->member)
            <div class="total-row">
                <span class="label">Diskon Member ({{ $transaksi->member->diskon }}%)</span>
                <span>- Rp {{ number_format($transaksi->total_harga * $transaksi->member->diskon / 100, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="total-row grand-total">
                <span>TOTAL BAYAR</span>
                <span>Rp {{ number_format($transaksi->total_harga - ($transaksi->member ? ($transaksi->total_harga * $transaksi->member->diskon / 100) : 0), 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>Barang yang sudah dibeli tidak dapat dikembalikan</p>
            <p>kecuali ada perjanjian tertulis</p>
            <p style="margin-top: 10px;">================================</p>
            <p style="margin-top: 5px;">{{ $setting->nama_toko ?? 'BangP Store' }}</p>
            <p>Dicetak: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>

    <script>
        // Auto print on load (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
