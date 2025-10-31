@extends('layouts.admin')

@section('title', 'Edit Promo - POSKigo Admin')

@section('content')
<h1 class="mt-4">Edit Promo</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.promotions.index') }}">Promo</a></li>
    <li class="breadcrumb-item active">Edit</li>
</ol>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i> Form Edit Promo
            </div>
            <div class="card-body">
                <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Judul Promo <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $promotion->title) }}" placeholder="Contoh: Diskon Akhir Tahun" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kode Promo <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                                   value="{{ old('code') }}" placeholder="Contoh: DISKON2025" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kode akan otomatis diubah ke UPPERCASE</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tipe Diskon <span class="text-danger">*</span></label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                                <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nilai Diskon <span class="text-danger">*</span></label>
                            <input type="number" name="discount_value" class="form-control @error('discount_value') is-invalid @enderror" 
                                   value="{{ old('discount_value') }}" step="0.01" min="0" placeholder="Contoh: 20 atau 50000" required>
                            @error('discount_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Jika %, isi angka 1-100. Jika nominal, isi jumlah rupiah</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Minimal Pembelian</label>
                            <input type="number" name="min_purchase" class="form-control @error('min_purchase') is-invalid @enderror" 
                                   value="{{ old('min_purchase', 0) }}" step="1000" min="0" placeholder="0 = tidak ada minimal">
                            @error('min_purchase')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Maksimal Penggunaan</label>
                            <input type="number" name="max_usage" class="form-control @error('max_usage') is-invalid @enderror" 
                                   value="{{ old('max_usage') }}" min="1" placeholder="Kosongkan = unlimited">
                            @error('max_usage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Berlaku Dari <span class="text-danger">*</span></label>
                            <input type="date" name="valid_from" class="form-control @error('valid_from') is-invalid @enderror" 
                                   value="{{ old('valid_from') }}" required>
                            @error('valid_from')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Berlaku Sampai <span class="text-danger">*</span></label>
                            <input type="date" name="valid_until" class="form-control @error('valid_until') is-invalid @enderror" 
                                   value="{{ old('valid_until') }}" required>
                            @error('valid_until')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="isActive" 
                                   {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="isActive">
                                Aktifkan promo ini sekarang
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Promo
                        </button>
                        <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-header">
                <i class="fas fa-info-circle me-1"></i> Panduan
            </div>
            <div class="card-body">
                <h6>Tipe Diskon:</h6>
                <ul class="small">
                    <li><strong>Persentase (%):</strong> Diskon berdasarkan persen dari total belanja. Contoh: 20% dari Rp 100.000 = Rp 20.000</li>
                    <li><strong>Nominal (Rp):</strong> Potongan harga tetap. Contoh: Diskon Rp 50.000 dari total belanja</li>
                </ul>

                <h6 class="mt-3">Tips:</h6>
                <ul class="small mb-0">
                    <li>Gunakan kode promo yang mudah diingat</li>
                    <li>Set minimal pembelian untuk promo besar</li>
                    <li>Batasi penggunaan agar tidak boncos</li>
                    <li>Nonaktifkan promo yang sudah expired</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
