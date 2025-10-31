<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan - POSKigo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #1e88e5;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #1e88e5;
            margin: 0;
        }
        .info {
            margin-bottom: 15px;
        }
        .info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #1e88e5;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        table td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .summary {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .summary h3 {
            color: #1e88e5;
            margin-top: 0;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN</h1>
        <p>POSKigo - Point of Sale System</p>
    </div>

    <div class="info">
        <p><strong>Periode:</strong> {{ date('d F Y', strtotime($startDate)) }} - {{ date('d F Y', strtotime($endDate)) }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ date('d F Y H:i') }}</p>
        <p><strong>Total Transaksi:</strong> {{ $totalTransactions }} transaksi</p>
        <p><strong>Total Penjualan:</strong> Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
    </div>

    <h3 style="color: #1e88e5;">Daftar Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 10%;">ID</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 15%;">Kasir</th>
                <th style="width: 15%;">Pelanggan</th>
                <th style="width: 15%;">Subtotal</th>
                <th style="width: 10%;">Pajak</th>
                <th style="width: 15%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($sales as $sale)
            <tr>
                <td>{{ $no++ }}</td>
                <td>#{{ $sale->id }}</td>
                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $sale->user->name }}</td>
                <td>{{ $sale->customer ? $sale->customer->name : 'Umum' }}</td>
                <td>Rp {{ number_format($sale->subtotal ?? ($sale->total_amount - ($sale->tax_amount ?? 0)), 0, ',', '.') }}</td>
                <td>Rp {{ number_format($sale->tax_amount ?? 0, 0, ',', '.') }}</td>
                <td><strong>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h3>10 Barang Terlaris</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Total Terjual</th>
                    <th>Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($topItems as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->item->name }}</td>
                    <td>{{ $item->total_qty }} pcs</td>
                    <td>Rp {{ number_format($item->total_sales, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Dokumen ini digenerate otomatis oleh sistem POSKigo</p>
        <p>&copy; {{ date('Y') }} POSKigo - All Rights Reserved</p>
    </div>
</body>
</html>
