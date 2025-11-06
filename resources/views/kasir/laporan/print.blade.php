<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .header p {
            font-size: 12px;
            color: #666;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info td {
            padding: 5px;
        }
        .info td:first-child {
            width: 150px;
            font-weight: bold;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .summary-box {
            border: 2px solid #333;
            padding: 15px;
            width: 48%;
            text-align: center;
        }
        .summary-box h3 {
            font-size: 14px;
            margin-bottom: 10px;
            color: #666;
        }
        .summary-box .value {
            font-size: 20px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #f0f0f0;
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
        }
        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-row {
            font-weight: bold;
            background-color: #e0e0e0 !important;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN PENJUALAN</h1>
        <h2>BANGP</h2>
        <p>Alamat: Jl. BangP No. 123, Jakarta</p>
        <p>Telp: (021) 12345678 | Email: info@bangp.com</p>
    </div>

    <!-- Info Periode -->
    <div class="info">
        <table>
            <tr>
                <td>Periode</td>
                <td>: {{ \Carbon\Carbon::parse($tanggal_awal)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: {{ now()->format('d F Y H:i:s') }}</td>
            </tr>
            <tr>
                <td>Dicetak Oleh</td>
                <td>: {{ auth()->user()->name }}</td>
            </tr>
        </table>
    </div>

    <!-- Summary -->
    <div class="summary">
        <div class="summary-box">
            <h3>Total Transaksi</h3>
            <div class="value">{{ $totalTransaksi }}</div>
        </div>
        <div class="summary-box">
            <h3>Total Penjualan</h3>
            <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Daftar Transaksi -->
    <h3 style="margin-bottom: 10px;">DAFTAR TRANSAKSI</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Member</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $index => $t)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $t->kode_transaksi }}</td>
                <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $t->member->nama_member ?? 'Umum' }}</td>
                <td style="text-align: right;">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                <td>{{ ucfirst($t->metode_pembayaran) }}</td>
                <td style="text-align: center;">{{ ucfirst($t->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">Tidak ada transaksi pada periode ini</td>
            </tr>
            @endforelse
            
            @if($transaksi->count() > 0)
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">TOTAL:</td>
                <td style="text-align: right;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- Signature -->
    <div class="signature">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <div class="signature-line">
                <p>( _________________ )</p>
                <p>Manager</p>
            </div>
        </div>
        <div class="signature-box">
            <p>Kasir,</p>
            <div class="signature-line">
                <p>( {{ auth()->user()->name }} )</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        <p>Laporan ini dicetak otomatis oleh sistem</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
