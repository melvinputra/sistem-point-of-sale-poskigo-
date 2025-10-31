@extends('layouts.pelanggan')

@section('title', 'Top-Up Saldo - POSKigo')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-plus-circle me-2"></i> Top-Up Saldo</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Form Request Top-Up</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pelanggan.wallet.topup.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Jumlah Top-Up <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" 
                                       value="{{ old('amount') }}" min="10000" step="1000" required>
                            </div>
                            @error('amount')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimal top-up: Rp 10.000</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>
                                    Transfer Bank
                                </option>
                                <option value="e-wallet" {{ old('payment_method') == 'e-wallet' ? 'selected' : '' }}>
                                    E-Wallet (GoPay, OVO, Dana)
                                </option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>
                                    Tunai (Bayar di toko)
                                </option>
                            </select>
                            @error('payment_method')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bukti Pembayaran (Opsional)</label>
                            <input type="file" name="payment_proof" class="form-control @error('payment_proof') is-invalid @enderror" accept="image/*">
                            @error('payment_proof')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Upload screenshot/foto bukti pembayaran (Max: 2MB)</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Informasi:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Request top-up akan diverifikasi oleh admin dalam 1x24 jam</li>
                                <li>Pastikan Anda sudah melakukan pembayaran sebelum mengisi form ini</li>
                                <li>Upload bukti pembayaran akan mempercepat proses verifikasi</li>
                            </ul>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Request
                            </button>
                            <a href="{{ route('pelanggan.wallet.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-university me-2"></i> Rekening Tujuan</h5>
                </div>
                <div class="card-body">
                    <h6 class="mb-3">Transfer Bank:</h6>
                    <p class="mb-2"><strong>Bank BCA</strong></p>
                    <p class="mb-2">No. Rekening: <strong>1234567890</strong></p>
                    <p class="mb-4">a.n. <strong>POSKigo Store</strong></p>

                    <hr>

                    <h6 class="mb-3">E-Wallet:</h6>
                    <p class="mb-2"><i class="fas fa-mobile-alt me-2"></i> <strong>GoPay:</strong> 08123456789</p>
                    <p class="mb-2"><i class="fas fa-mobile-alt me-2"></i> <strong>OVO:</strong> 08123456789</p>
                    <p class="mb-2"><i class="fas fa-mobile-alt me-2"></i> <strong>Dana:</strong> 08123456789</p>

                    <hr>

                    <h6 class="mb-3">Pembayaran Tunai:</h6>
                    <p class="mb-0 small text-muted">Datang langsung ke toko POSKigo untuk melakukan pembayaran tunai</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
