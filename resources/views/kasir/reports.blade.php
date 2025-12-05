@extends('layouts.kasir')

@section('title', 'Laporan Penjualan - POSKigo')

@section('content')
<h1 class="mt-4">Laporan Penjualan Harian</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('kasir.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan Penjualan</li>
</ol>

<!-- Filter Tanggal -->
<div class="card mb-4 shadow">
    <div class="card-header">
        <i class="fas fa-calendar me-1"></i> Filter Tanggal
    </div>
    <div class="card-body">
        <form action="{{ route('kasir.reports') }}" method="GET">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Pilih Tanggal</label>
                    <input type="date" name="date" class="form-control" value="{{ $date }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Lihat Laporan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row">
    <div class="col-md-3">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <h6>Total Penjualan</h6>
                <h4>Rp {{ number_format($totalSales, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <h6>Total Transaksi</h6>
                <h4>{{ $totalTransactions }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white mb-4">
            <div class="card-body">
                <h6>Total Cash Diterima</h6>
                <h4>Rp {{ number_format($totalCash, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                <h6>Total Diskon</h6>
                <h4>Rp {{ number_format($totalDiscount, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
</div>

<!-- Barang Terlaris -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-trophy me-1"></i> Barang Terlaris Hari Ini
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Terjual</th>
                    <th>Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topItems as $index => $saleItem)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $saleItem->item->name }}</td>
                    <td>{{ $saleItem->total_qty }}</td>
                    <td>Rp {{ number_format($saleItem->total_sales, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Detail Transaksi -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-1"></i> Detail Transaksi</span>
        <button onclick="window.print()" class="btn btn-sm btn-primary">
            <i class="fas fa-print me-1"></i> Cetak Laporan
        </button>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Waktu</th>
                    <th>Pelanggan</th>
                    <th>Barang</th>
                    <th>Subtotal</th>
                    <th>Pajak</th>
                    <th>Diskon</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td><a href="{{ route('kasir.sales.show', $sale->id) }}">#{{ $sale->id }}</a></td>
                    <td>{{ $sale->created_at->format('H:i') }}</td>
                    <td>{{ $sale->customer ? $sale->customer->name : 'Umum' }}</td>
                    <td>
                        <small>
                            @foreach($sale->saleItems as $item)
                                {{ $item->item ? $item->item->name : '[Item dihapus]' }} ({{ $item->quantity }}x)<br>
                            @endforeach
                        </small>
                    </td>
                    <td>Rp {{ number_format($sale->subtotal ?? $sale->total_amount, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($sale->tax_amount ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($sale->discount_amount ?? 0, 0, ',', '.') }}</td>
                    <td><strong>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</strong></td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada transaksi untuk tanggal ini</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($sales->count() > 0)
            <tfoot>
                <tr class="table-info">
                    <th colspan="4" class="text-end">TOTAL:</th>
                    <th>Rp {{ number_format($sales->sum('subtotal'), 0, ',', '.') }}</th>
                    <th>Rp {{ number_format($totalTax, 0, ',', '.') }}</th>
                    <th>Rp {{ number_format($totalDiscount, 0, ',', '.') }}</th>
                    <th>Rp {{ number_format($totalSales, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

<style>
    @media print {
        .btn, .breadcrumb, .card-header button, form {
            display: none !important;
        }
        .card {
            border: 1px solid #000;
            box-shadow: none;
        }
    }
</style>
@endsection
