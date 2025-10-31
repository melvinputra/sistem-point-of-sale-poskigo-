@extends('layouts.kasir')

@section('title', 'Dashboard Kasir - POSKigo')

@section('content')
<h1 class="mt-4">Dashboard Kasir</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
</ol>

<!-- Statistics Cards -->
<div class="row">
    <div class="col-xl-6 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small">Penjualan Hari Ini</div>
                        <div class="h2 mb-0">Rp {{ number_format($todaySales, 0, ',', '.') }}</div>
                    </div>
                    <i class="fas fa-dollar-sign fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="small">Transaksi Hari Ini</div>
                        <div class="h2 mb-0">{{ $todayTransactions }}</div>
                    </div>
                    <i class="fas fa-receipt fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-bolt me-1"></i> Aksi Cepat
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('kasir.sales.create') }}" class="btn btn-lg btn-primary w-100">
                            <i class="fas fa-cash-register fa-2x d-block mb-2"></i>
                            Transaksi Baru
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('kasir.customers.create') }}" class="btn btn-lg btn-success w-100">
                            <i class="fas fa-user-plus fa-2x d-block mb-2"></i>
                            Daftar Pelanggan
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('kasir.sales.index') }}" class="btn btn-lg btn-info w-100">
                            <i class="fas fa-history fa-2x d-block mb-2"></i>
                            Riwayat Transaksi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Sales -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Transaksi Terbaru
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentSales as $sale)
                <tr>
                    <td>#{{ $sale->id }}</td>
                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $sale->customer ? $sale->customer->name : 'Umum' }}</td>
                    <td>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('kasir.sales.show', $sale->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
