@extends('layouts.kasir')

@section('title', 'Riwayat Transaksi - POSKigo')

@section('content')
<h1 class="mt-4">Riwayat Transaksi</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('kasir.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Riwayat Transaksi</li>
</ol>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-table me-1"></i>
            Daftar Transaksi Penjualan
        </div>
        <a href="{{ route('kasir.sales.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Transaksi Baru
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total Belanja</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td>#{{ $sale->id }}</td>
                        <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($sale->customer)
                                <strong>{{ $sale->customer->name }}</strong><br>
                                <small class="text-muted">{{ $sale->customer->phone }}</small>
                            @else
                                <span class="badge bg-secondary">Umum</span>
                            @endif
                        </td>
                        <td>
                            <strong class="text-primary">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</strong>
                        </td>
                        <td>
                            <a href="{{ route('kasir.sales.show', $sale->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada transaksi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sales->count() > 0)
        <div class="mt-3">
            {{ $sales->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Summary Card -->
@if($sales->count() > 0)
<div class="row">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="mb-1">Total Transaksi</h6>
                <h3 class="mb-0">{{ $sales->total() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="mb-1">Total Penjualan (Halaman Ini)</h6>
                <h3 class="mb-0">Rp {{ number_format($sales->sum('total_amount'), 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="mb-1">Rata-rata per Transaksi</h6>
                <h3 class="mb-0">Rp {{ number_format($sales->avg('total_amount'), 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
