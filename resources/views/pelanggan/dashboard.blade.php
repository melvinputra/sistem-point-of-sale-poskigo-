@extends('layouts.pelanggan')

@section('title', 'Dashboard - POSKigo')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Selamat Datang, {{ auth()->user()->name }}!</h2>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body text-center p-4">
                <i class="fas fa-wallet fa-3x text-warning mb-3"></i>
                <h5 class="card-title">KiWallet</h5>
                <p class="card-text text-muted">Kelola saldo dompet digital Anda</p>
                <a href="{{ route('pelanggan.wallet.index') }}" class="btn btn-warning text-white">
                    <i class="fas fa-arrow-right me-2"></i> Buka Wallet
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body text-center p-4">
                <i class="fas fa-shopping-cart fa-3x text-primary mb-3"></i>
                <h5 class="card-title">Belanja Online</h5>
                <p class="card-text text-muted">Lihat produk dan lakukan pembelian online</p>
                <a href="{{ route('pelanggan.shop') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-right me-2"></i> Mulai Belanja
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body text-center p-4">
                <i class="fas fa-history fa-3x text-success mb-3"></i>
                <h5 class="card-title">Riwayat Transaksi</h5>
                <p class="card-text text-muted">Lihat semua transaksi pembelian Anda</p>
                <a href="{{ route('pelanggan.transactions') }}" class="btn btn-success">
                    <i class="fas fa-arrow-right me-2"></i> Lihat Riwayat
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i> Transaksi Terbaru</h5>
    </div>
    <div class="card-body">
        @if(!empty($recentTransactions) && count($recentTransactions) > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Barang</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $transaction)
                        <tr>
                            <td><a href="{{ route('pelanggan.transactions') }}">#{{ $transaction->id }}</a></td>
                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <small>
                                    @foreach($transaction->saleItems as $item)
                                        {{ $item->item->name }} ({{ $item->quantity }}x)
                                        @if(!$loop->last), @endif
                                    @endforeach
                                </small>
                            </td>
                            <td><strong>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong></td>
                            <td>
                                <span class="badge bg-success">Selesai</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada transaksi</p>
                <a href="{{ route('pelanggan.shop') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-cart me-2"></i> Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
