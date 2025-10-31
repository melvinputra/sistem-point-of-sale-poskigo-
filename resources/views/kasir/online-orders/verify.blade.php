@extends('layouts.kasir')

@section('title', 'Verifikasi Kode Pickup - POSKigo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-qrcode me-2"></i> Verifikasi Kode Pickup</h2>
    <a href="{{ route('kasir.online-orders') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
</div>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="fas fa-search fa-4x text-primary mb-3"></i>
                    <h4>Masukkan Kode Pickup Pelanggan</h4>
                    <p class="text-muted">Pelanggan akan menunjukkan kode pickup dari HP mereka</p>
                </div>

                <form action="{{ route('kasir.online-orders.search') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="pickup_code" class="form-label fw-bold">Kode Pickup</label>
                        <input type="text" 
                               class="form-control form-control-lg text-center @error('pickup_code') is-invalid @enderror" 
                               id="pickup_code" 
                               name="pickup_code" 
                               placeholder="PKG-20251030-001"
                               style="font-size: 1.5rem; letter-spacing: 2px; font-family: 'Courier New', monospace;"
                               value="{{ old('pickup_code') }}"
                               autofocus
                               required>
                        @error('pickup_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Format: PKG-YYYYMMDD-XXX</small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search me-2"></i> Cari Pesanan
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="alert alert-info mb-0">
                    <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i> Panduan:</h6>
                    <ol class="mb-0 ps-3">
                        <li>Minta pelanggan menunjukkan kode pickup di HP mereka</li>
                        <li>Ketik kode pickup dengan benar</li>
                        <li>Klik "Cari Pesanan" untuk melihat detail</li>
                        <li>Verifikasi identitas pelanggan (nama & nomor HP)</li>
                        <li>Serahkan barang dan tandai selesai</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('pickup_code').addEventListener('input', function(e) {
    // Auto uppercase
    this.value = this.value.toUpperCase();
});
</script>
@endsection
