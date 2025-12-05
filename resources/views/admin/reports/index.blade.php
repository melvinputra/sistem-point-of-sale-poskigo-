@extends('layouts.admin')

@section('title', 'Laporan Penjualan - POSKigo')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .breadcrumb-modern {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        margin-bottom: 0;
    }

    .breadcrumb-modern .breadcrumb-item a {
        color: #5a8e2a;
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-modern .breadcrumb-item.active {
        color: #1a1a1a;
        font-weight: 600;
    }

    .card-modern {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-header-modern {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        padding: 1.25rem 1.5rem;
        border: none;
    }

    .btn-export {
        border-radius: 12px;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .btn-excel {
        background: linear-gradient(135deg, #6BCF7F 0%, #4CAF50 100%);
        color: white;
    }

    .btn-pdf {
        background: linear-gradient(135deg, #FF6B6B 0%, #EE5A6F 100%);
        color: white;
    }

    .summary-card {
        border: none;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .summary-value {
        font-size: 2rem;
        font-weight: 700;
        margin: 0.5rem 0;
    }

    .summary-label {
        font-size: 0.9rem;
        opacity: 0.9;
        font-weight: 500;
    }

    .table-modern tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.2s ease;
    }

    .table-modern tbody tr:hover {
        background: #f8f9fa;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="mb-2" style="color: #1a1a1a; font-weight: 700;">Laporan Penjualan</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-modern">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Laporan Penjualan</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Filter -->
<div class="card card-modern">
    <div class="card-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0" style="color: #1a1a1a; font-weight: 600;">
                <i class="fas fa-filter me-2"></i>Filter Laporan
            </h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.reports.export-excel', ['start_date' => $startDate, 'end_date' => $endDate, 'customer_id' => $customerId, 'item_id' => $itemId, 'category_id' => $categoryId]) }}" 
                   class="btn btn-export btn-excel">
                    <i class="fas fa-file-excel me-2"></i>Export Excel
                </a>
                <a href="{{ route('admin.reports.export-pdf', ['start_date' => $startDate, 'end_date' => $endDate, 'customer_id' => $customerId, 'item_id' => $itemId, 'category_id' => $categoryId]) }}" 
                   class="btn btn-export btn-pdf">
                    <i class="fas fa-file-pdf me-2"></i>Export PDF
                </a>
            </div>
        </div>
    </div>
    <div class="card-body" style="padding: 2rem;">
        <form action="{{ route('admin.reports.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" style="font-weight: 600; color: #1a1a1a;">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" style="border-radius: 10px; border: 1px solid #dee2e6; padding: 0.75rem;">
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-weight: 600; color: #1a1a1a;">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" style="border-radius: 10px; border: 1px solid #dee2e6; padding: 0.75rem;">
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-weight: 600; color: #1a1a1a;">Pelanggan</label>
                    <select name="customer_id" class="form-select" style="border-radius: 10px; border: 1px solid #dee2e6; padding: 0.75rem;">
                        <option value="">-- Semua Pelanggan --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $customerId == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-weight: 600; color: #1a1a1a;">Produk</label>
                    <select name="item_id" class="form-select" style="border-radius: 10px; border: 1px solid #dee2e6; padding: 0.75rem;">
                        <option value="">-- Semua Produk --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ $itemId == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" style="font-weight: 600; color: #1a1a1a;">Kategori</label>
                    <select name="category_id" class="form-select" style="border-radius: 10px; border: 1px solid #dee2e6; padding: 0.75rem;">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-9 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-export" style="background: #1a1a1a; color: white;">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-export" style="background: #6c757d; color: white;">
                        <i class="fas fa-redo me-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row">
    <div class="col-md-6">
        <div class="summary-card" style="background: linear-gradient(135deg, #6BCF7F 0%, #4CAF50 100%); color: white;">
            <div class="summary-label">Total Penjualan</div>
            <div class="summary-value">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
            <i class="fas fa-chart-line" style="position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); font-size: 3rem; opacity: 0.2;"></i>
        </div>
    </div>
    <div class="col-md-6">
        <div class="summary-card" style="background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%); color: white;">
            <div class="summary-label">Total Transaksi</div>
            <div class="summary-value">{{ number_format($totalTransactions) }}</div>
            <i class="fas fa-receipt" style="position: absolute; right: 2rem; top: 50%; transform: translateY(-50%); font-size: 3rem; opacity: 0.2;"></i>
        </div>
    </div>
</div>


<!-- Top Items -->
<div class="card card-modern">
    <div class="card-header-modern">
        <h5 class="mb-0" style="color: #1a1a1a; font-weight: 600;">
            <i class="fas fa-trophy me-2"></i>Barang Terlaris
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">No</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Nama Barang</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Jumlah Terjual</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topItems as $index => $saleItem)
                    <tr>
                        <td style="padding: 1rem 1.5rem;">
                            @if($index < 3)
                                <span class="badge" style="background: linear-gradient(135deg, #FFD93D 0%, #FFC107 100%); color: #1a1a1a; border-radius: 8px; padding: 0.4rem 0.8rem;">
                                    <i class="fas fa-trophy me-1"></i>{{ $index + 1 }}
                                </span>
                            @else
                                <span class="badge" style="background: #6c757d; color: white; border-radius: 8px; padding: 0.4rem 0.8rem;">
                                    {{ $index + 1 }}
                                </span>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a;">{{ $saleItem->item->name }}</td>
                        <td style="padding: 1rem 1.5rem;">
                            <span class="badge" style="background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%); color: white; border-radius: 8px; padding: 0.4rem 0.8rem;">
                                {{ $saleItem->total_qty }} Unit
                            </span>
                        </td>
                        <td style="padding: 1rem 1.5rem; font-weight: 700; color: #5a8e2a;">
                            Rp {{ number_format($saleItem->total_sales, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="fas fa-box-open fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                            <p class="mb-0">Tidak ada data</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Top Cashiers -->
<div class="card card-modern">
    <div class="card-header-modern">
        <h5 class="mb-0" style="color: #1a1a1a; font-weight: 600;">
            <i class="fas fa-user-tie me-2"></i>Kasir Terbaik
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern mb-0">
                <thead>
                    <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">No</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Nama Kasir</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Jumlah Transaksi</th>
                        <th style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a; border: none; border-bottom: 2px solid #dee2e6;">Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topCashiers as $index => $cashier)
                    <tr>
                        <td style="padding: 1rem 1.5rem;">
                            @if($index < 3)
                                <span class="badge" style="background: linear-gradient(135deg, #FFD93D 0%, #FFC107 100%); color: #1a1a1a; border-radius: 8px; padding: 0.4rem 0.8rem;">
                                    <i class="fas fa-star me-1"></i>{{ $index + 1 }}
                                </span>
                            @else
                                <span class="badge" style="background: #6c757d; color: white; border-radius: 8px; padding: 0.4rem 0.8rem;">
                                    {{ $index + 1 }}
                                </span>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.5rem; font-weight: 600; color: #1a1a1a;">
                            <i class="fas fa-user-circle me-2" style="color: #5a8e2a;"></i>{{ $cashier->user->name }}
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            <span class="badge" style="background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%); color: #1a1a1a; border-radius: 8px; padding: 0.4rem 0.8rem;">
                                {{ $cashier->total_transactions }} Transaksi
                            </span>
                        </td>
                        <td style="padding: 1rem 1.5rem; font-weight: 700; color: #5a8e2a;">
                            Rp {{ number_format($cashier->total_sales, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="fas fa-user-slash fa-3x mb-3 d-block" style="opacity: 0.3;"></i>
                            <p class="mb-0">Tidak ada data</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
