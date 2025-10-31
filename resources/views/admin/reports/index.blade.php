@extends('layouts.admin')

@section('title', 'Laporan Penjualan - POSKigo')

@section('content')
<h1 class="mt-4">Laporan Penjualan</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Laporan Penjualan</li>
</ol>

<!-- Filter -->
<div class="card mb-4 shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-filter me-1"></i> Filter Laporan</span>
        <div>
            <a href="{{ route('admin.reports.export-excel', ['start_date' => $startDate, 'end_date' => $endDate, 'customer_id' => $customerId, 'item_id' => $itemId, 'category_id' => $categoryId]) }}" 
               class="btn btn-success btn-sm me-2">
                <i class="fas fa-file-excel me-1"></i> Export Excel
            </a>
            <a href="{{ route('admin.reports.export-pdf', ['start_date' => $startDate, 'end_date' => $endDate, 'customer_id' => $customerId, 'item_id' => $itemId, 'category_id' => $categoryId]) }}" 
               class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf me-1"></i> Export PDF
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.reports.index') }}" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pelanggan</label>
                    <select name="customer_id" class="form-select">
                        <option value="">-- Semua Pelanggan --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $customerId == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Produk</label>
                    <select name="item_id" class="form-select">
                        <option value="">-- Semua Produk --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ $itemId == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-9">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row">
    <div class="col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <h5>Total Penjualan</h5>
                <h2>Rp {{ number_format($totalSales, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <h5>Total Transaksi</h5>
                <h2>{{ $totalTransactions }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Top Items -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-trophy me-1"></i> Barang Terlaris
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

<!-- Top Cashiers -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-user-tie me-1"></i> Kasir Terbaik
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kasir</th>
                    <th>Jumlah Transaksi</th>
                    <th>Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topCashiers as $index => $cashier)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $cashier->user->name }}</td>
                    <td>{{ $cashier->total_transactions }}</td>
                    <td>Rp {{ number_format($cashier->total_sales, 0, ',', '.') }}</td>
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
@endsection
