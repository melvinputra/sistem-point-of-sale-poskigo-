@extends('layouts.pelanggan')

@section('title', 'KiWallet - POSKigo')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-wallet me-2"></i> KiWallet - Dompet Digital</h2>

    <!-- Saldo Card -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-white" style="background: linear-gradient(135deg, #1e88e5 0%, #ff6f00 100%);">
                <div class="card-body p-4">
                    <h5 class="card-title"><i class="fas fa-wallet me-2"></i> Saldo Anda</h5>
                    <h1 class="display-4 mb-3">Rp {{ number_format($wallet->balance, 0, ',', '.') }}</h1>
                    <a href="{{ route('pelanggan.wallet.topup') }}" class="btn btn-light">
                        <i class="fas fa-plus-circle me-2"></i> Top-Up Saldo
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-info-circle me-2"></i> Informasi</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Saldo dapat digunakan untuk belanja</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Top-up minimal Rp 10.000</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Proses verifikasi 1x24 jam</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i> Saldo tidak memiliki masa berlaku</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- History Top-Up -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-history me-2"></i> Riwayat Top-Up</h5>
        </div>
        <div class="card-body">
            @if(!empty($topupHistory) && count($topupHistory) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Metode Pembayaran</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topupHistory as $history)
                            <tr>
                                <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                <td><strong>Rp {{ number_format($history->amount, 0, ',', '.') }}</strong></td>
                                <td>
                                    @if($history->payment_method == 'transfer')
                                        <i class="fas fa-university me-1"></i> Transfer Bank
                                    @elseif($history->payment_method == 'cash')
                                        <i class="fas fa-money-bill me-1"></i> Tunai
                                    @else
                                        <i class="fas fa-mobile-alt me-1"></i> E-Wallet
                                    @endif
                                </td>
                                <td>
                                    @if($history->status == 'pending')
                                        <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Pending</span>
                                    @elseif($history->status == 'approved')
                                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Disetujui</span>
                                    @else
                                        <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    @if($history->status == 'approved')
                                        <small class="text-muted">{{ $history->approved_at ? $history->approved_at->format('d/m/Y H:i') : '-' }}</small>
                                    @elseif($history->status == 'rejected')
                                        <small class="text-danger">{{ $history->admin_notes }}</small>
                                    @else
                                        <small class="text-muted">Menunggu verifikasi admin</small>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $topupHistory->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada riwayat top-up</h5>
                    <p class="text-muted">Mulai top-up saldo untuk mulai berbelanja</p>
                    <a href="{{ route('pelanggan.wallet.topup') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i> Top-Up Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
