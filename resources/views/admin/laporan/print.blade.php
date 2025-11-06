<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Print</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            font-size: 28px;
            color: #2563eb;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .header h2 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 12px;
            color: #666;
        }
        
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .info-box {
            flex: 1;
        }
        
        .info-box h3 {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        
        .info-box p {
            font-size: 14px;
            color: #333;
            font-weight: bold;
        }
        
        .summary-section {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .summary-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            color: white;
        }
        
        .summary-card.blue {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        }
        
        .summary-card.green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .summary-card.purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        }
        
        .summary-card.orange {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        
        .summary-card h4 {
            font-size: 11px;
            margin-bottom: 8px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .summary-card p {
            font-size: 20px;
            font-weight: bold;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background: white;
        }
        
        table thead {
            background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
            color: white;
        }
        
        table thead th {
            padding: 12px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        table tbody td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 12px;
        }
        
        table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
        }
        
        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
        }
        
        .signature-box {
            text-align: center;
            width: 200px;
        }
        
        .signature-box p {
            font-size: 12px;
            color: #666;
            margin-bottom: 60px;
        }
        
        .signature-box .name {
            font-weight: bold;
            font-size: 14px;
            color: #333;
            border-top: 2px solid #333;
            padding-top: 5px;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .font-bold {
            font-weight: bold;
        }
        
        .text-success {
            color: #059669;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .summary-section {
                page-break-inside: avoid;
            }
            
            table {
                page-break-inside: auto;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BangP Store</h1>
        <h2>Laporan Penjualan</h2>
        <p>Jl. Contoh No. 123, Kota, Indonesia | Telp: (021) 1234-5678 | Email: info@bangp.com</p>
    </div>

    <div class="info-section">
        <div class="info-box">
            <h3>Periode Laporan</h3>
            <p>{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        </div>
        <div class="info-box text-right">
            <h3>Tanggal Cetak</h3>
            <p>{{ now()->format('d M Y H:i:s') }} WIB</p>
        </div>
    </div>

    <div class="summary-section">
        <div class="summary-card blue">
            <h4>Total Transaksi</h4>
            <p>{{ number_format($totalTransaksi) }}</p>
        </div>
        <div class="summary-card green">
            <h4>Total Penjualan</h4>
            <p>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
        </div>
        <div class="summary-card purple">
            <h4>Total Diskon</h4>
            <p>Rp {{ number_format($totalDiskon, 0, ',', '.') }}</p>
        </div>
        <div class="summary-card orange">
            <h4>Total Keuntungan</h4>
            <p>Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Kode</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 12%;">Kasir</th>
                <th style="width: 12%;">Member</th>
                <th style="width: 13%;">Total</th>
                <th style="width: 10%;">Diskon</th>
                <th style="width: 13%;">Keuntungan</th>
                <th style="width: 5%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $index => $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="font-bold">{{ $item->kode_transaksi }}</td>
                <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                <td>{{ $item->kasir->name ?? '-' }}</td>
                <td>{{ $item->member->nama_member ?? 'Non-Member' }}</td>
                <td class="text-right font-bold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->diskon, 0, ',', '.') }}</td>
                <td class="text-right font-bold text-success">Rp {{ number_format($item->keuntungan, 0, ',', '.') }}</td>
                <td class="text-center">
                    @if($item->status == 'selesai')
                        <span class="badge badge-success">Selesai</span>
                    @elseif($item->status == 'pending')
                        <span class="badge badge-warning">Pending</span>
                    @else
                        <span class="badge badge-danger">Batal</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center" style="padding: 40px;">
                    Tidak ada data transaksi
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Mengetahui,<br>Manager</p>
            <div class="name">( _________________ )</div>
        </div>
        <div class="signature-box">
            <p>Dicetak Oleh,<br>Admin</p>
            <div class="name">( {{ auth()->user()->name }} )</div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
