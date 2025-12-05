@extends('layouts.admin')

@section('title', 'Tambah Promo - POSKigo Admin')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .page-header h1 {
        color: #1a1a1a;
        font-weight: 700;
        margin: 0;
        font-size: 1.8rem;
    }

    .breadcrumb-modern {
        background: transparent;
        padding: 0;
        margin: 0.5rem 0 0 0;
    }

    .breadcrumb-modern .breadcrumb-item {
        color: #5a8e2a;
        font-weight: 500;
    }

    .breadcrumb-modern .breadcrumb-item a {
        color: #1a1a1a;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .breadcrumb-modern .breadcrumb-item a:hover {
        color: #5a8e2a;
    }

    .breadcrumb-modern .breadcrumb-item.active {
        color: #5a8e2a;
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

    .card-header-modern h5 {
        color: #1a1a1a;
        font-weight: 700;
        margin: 0;
        font-size: 1.1rem;
    }

    .card-body-modern {
        padding: 2rem;
    }

    .form-label-modern {
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control-modern,
    .form-select-modern {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus,
    .form-select-modern:focus {
        border-color: #C4FF57;
        box-shadow: 0 0 0 0.2rem rgba(196, 255, 87, 0.25);
    }

    .form-text-modern {
        color: #6c757d;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    .btn-modern-primary {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border: none;
        color: #1a1a1a;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .btn-modern-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(196, 255, 87, 0.4);
        color: #1a1a1a;
    }

    .btn-modern-secondary {
        background: white;
        border: 2px solid #e5e7eb;
        color: #6c757d;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .btn-modern-secondary:hover {
        border-color: #C4FF57;
        color: #1a1a1a;
        background: rgba(196, 255, 87, 0.1);
    }

    .info-card {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.1) 0%, rgba(159, 232, 105, 0.05) 100%);
        border: 2px solid rgba(196, 255, 87, 0.3);
        border-radius: 20px;
        padding: 1.5rem;
    }

    .info-card h6 {
        color: #1a1a1a;
        font-weight: 700;
        margin-bottom: 0.75rem;
        font-size: 1rem;
    }

    .info-card ul {
        padding-left: 1.2rem;
        margin-bottom: 0;
    }

    .info-card ul li {
        margin-bottom: 0.5rem;
        color: #495057;
        line-height: 1.6;
    }

    .form-check-modern .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid #e5e7eb;
        border-radius: 6px;
    }

    .form-check-modern .form-check-input:checked {
        background-color: #C4FF57;
        border-color: #C4FF57;
    }

    .form-check-modern .form-check-label {
        font-weight: 500;
        color: #1a1a1a;
        margin-left: 0.5rem;
    }

    .required-mark {
        color: #ef4444;
        font-weight: 700;
    }

    .invalid-feedback {
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .input-group-modern {
        margin-bottom: 1.5rem;
    }
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="d-flex align-items-center">
        <i class="fas fa-tag me-3" style="font-size: 2rem; color: #5a8e2a;"></i>
        <div>
            <h1>Tambah Promo Baru</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-modern">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.promotions.index') }}">Promo</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card card-modern">
            <div class="card-header card-header-modern">
                <h5><i class="fas fa-plus-circle me-2"></i>Form Promo Baru</h5>
            </div>
            <div class="card-body card-body-modern">
                <form action="{{ route('admin.promotions.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group-modern">
                                <label class="form-label-modern">
                                    Judul Promo <span class="required-mark">*</span>
                                </label>
                                <input type="text" 
                                       name="title" 
                                       class="form-control form-control-modern @error('title') is-invalid @enderror" 
                                       value="{{ old('title') }}" 
                                       placeholder="Contoh: Diskon Akhir Tahun" 
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group-modern">
                                <label class="form-label-modern">
                                    Kode Promo <span class="required-mark">*</span>
                                </label>
                                <input type="text" 
                                       name="code" 
                                       class="form-control form-control-modern @error('code') is-invalid @enderror" 
                                       value="{{ old('code') }}" 
                                       placeholder="Contoh: DISKON2025" 
                                       required>
                                <small class="form-text-modern">
                                    <i class="fas fa-info-circle me-1"></i>Kode akan otomatis diubah ke UPPERCASE
                                </small>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group-modern">
                                <label class="form-label-modern">
                                    Tipe Diskon <span class="required-mark">*</span>
                                </label>
                                <select name="type" 
                                        class="form-select form-select-modern @error('type') is-invalid @enderror" 
                                        required>
                                    <option value="">-- Pilih Tipe Diskon --</option>
                                    <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>
                                        <i class="fas fa-percent"></i> Persentase (%)
                                    </option>
                                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>
                                        <i class="fas fa-money-bill"></i> Nominal (Rp)
                                    </option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group-modern">
                                <label class="form-label-modern">
                                    Nilai Diskon <span class="required-mark">*</span>
                                </label>
                                <input type="number" 
                                       name="discount_value" 
                                       class="form-control form-control-modern @error('discount_value') is-invalid @enderror" 
                                       value="{{ old('discount_value') }}" 
                                       step="0.01" 
                                       min="0" 
                                       placeholder="Contoh: 20 atau 50000" 
                                       required>
                                <small class="form-text-modern">
                                    <i class="fas fa-calculator me-1"></i>Jika %, isi 1-100. Jika nominal, isi jumlah rupiah
                                </small>
                                @error('discount_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-shopping-cart me-1"></i>Minimal Pembelian
                                </label>
                                <input type="number" 
                                       name="min_purchase" 
                                       class="form-control form-control-modern @error('min_purchase') is-invalid @enderror" 
                                       value="{{ old('min_purchase', 0) }}" 
                                       step="1000" 
                                       min="0" 
                                       placeholder="0 = tidak ada minimal">
                                <small class="form-text-modern">
                                    <i class="fas fa-info-circle me-1"></i>Kosongkan atau isi 0 untuk tanpa minimal
                                </small>
                                @error('min_purchase')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-users me-1"></i>Maksimal Penggunaan
                                </label>
                                <input type="number" 
                                       name="max_usage" 
                                       class="form-control form-control-modern @error('max_usage') is-invalid @enderror" 
                                       value="{{ old('max_usage') }}" 
                                       min="1" 
                                       placeholder="Kosongkan = unlimited">
                                <small class="form-text-modern">
                                    <i class="fas fa-infinity me-1"></i>Kosongkan untuk penggunaan tanpa batas
                                </small>
                                @error('max_usage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-calendar-alt me-1"></i>Berlaku Dari <span class="required-mark">*</span>
                                </label>
                                <input type="date" 
                                       name="valid_from" 
                                       class="form-control form-control-modern @error('valid_from') is-invalid @enderror" 
                                       value="{{ old('valid_from') }}" 
                                       required>
                                @error('valid_from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group-modern">
                                <label class="form-label-modern">
                                    <i class="fas fa-calendar-times me-1"></i>Berlaku Sampai <span class="required-mark">*</span>
                                </label>
                                <input type="date" 
                                       name="valid_until" 
                                       class="form-control form-control-modern @error('valid_until') is-invalid @enderror" 
                                       value="{{ old('valid_until') }}" 
                                       required>
                                @error('valid_until')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-check-modern">
                            <input type="checkbox" 
                                   name="is_active" 
                                   class="form-check-input" 
                                   id="isActive" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isActive">
                                <i class="fas fa-toggle-on me-1"></i>Aktifkan promo ini sekarang
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-modern-primary">
                            <i class="fas fa-save me-2"></i> Simpan Promo
                        </button>
                        <a href="{{ route('admin.promotions.index') }}" class="btn btn-modern-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="info-card">
            <h6><i class="fas fa-info-circle me-2"></i>Panduan Promo</h6>
            
            <div class="mb-3">
                <strong style="color: #1a1a1a; display: block; margin-bottom: 0.5rem;">
                    <i class="fas fa-tag me-1"></i>Tipe Diskon:
                </strong>
                <ul class="mb-0" style="font-size: 0.9rem;">
                    <li><strong>Persentase (%):</strong> Diskon berdasarkan persen dari total belanja<br>
                        <small class="text-muted">Contoh: 20% dari Rp 100.000 = Rp 20.000</small>
                    </li>
                    <li><strong>Nominal (Rp):</strong> Potongan harga tetap<br>
                        <small class="text-muted">Contoh: Diskon Rp 50.000 dari total belanja</small>
                    </li>
                </ul>
            </div>

            <div>
                <strong style="color: #1a1a1a; display: block; margin-bottom: 0.5rem;">
                    <i class="fas fa-lightbulb me-1"></i>Tips & Trik:
                </strong>
                <ul class="mb-0" style="font-size: 0.9rem;">
                    <li>Gunakan kode promo yang mudah diingat dan menarik</li>
                    <li>Set minimal pembelian untuk promo dengan diskon besar</li>
                    <li>Batasi penggunaan agar tidak terlalu boncos</li>
                    <li>Pastikan tanggal berlaku sudah benar</li>
                    <li>Nonaktifkan promo yang sudah expired</li>
                </ul>
            </div>
        </div>

        <div class="info-card mt-3" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.05) 100%); border-color: rgba(239, 68, 68, 0.3);">
            <h6><i class="fas fa-exclamation-triangle me-2"></i>Perhatian</h6>
            <ul class="mb-0" style="font-size: 0.9rem;">
                <li>Pastikan nilai diskon tidak melebihi 100% untuk tipe persentase</li>
                <li>Periksa kembali tanggal berlaku agar tidak bentrok</li>
                <li>Kode promo tidak bisa diubah setelah disimpan</li>
            </ul>
        </div>
    </div>
</div>
@endsection
