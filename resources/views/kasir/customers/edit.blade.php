@extends('layouts.kasir')

@section('title', 'Edit Pelanggan - POSKigo')

@section('content')
<style>
    .page-header-modern {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 16px rgba(196, 255, 87, 0.15);
    }
    
    .page-header-modern h1 {
        color: #1a1a1a;
        font-weight: 700;
        font-size: 1.75rem;
        margin: 0;
    }
    
    .breadcrumb-modern {
        background: rgba(255, 255, 255, 0.9);
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        margin: 1rem 0 0;
    }
    
    .breadcrumb-modern .breadcrumb-item + .breadcrumb-item::before {
        color: #5a8e2a;
    }
    
    .breadcrumb-modern a {
        color: #5a8e2a;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s;
    }
    
    .breadcrumb-modern a:hover {
        color: #C4FF57;
    }
    
    .card-modern {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .card-modern:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }
    
    .form-label-modern {
        font-weight: 600;
        color: #2a2a2a;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-label-modern i {
        color: #5a8e2a;
        font-size: 0.9rem;
    }
    
    .form-control-modern {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }
    
    .form-control-modern:focus {
        border-color: #C4FF57;
        box-shadow: 0 0 0 0.2rem rgba(196, 255, 87, 0.15);
        outline: none;
    }
    
    .form-control-modern.is-invalid {
        border-color: #dc3545;
    }
    
    .form-control-modern.is-invalid:focus {
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
    }
    
    .btn-modern-primary {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border: none;
        color: #1a1a1a;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(196, 255, 87, 0.3);
    }
    
    .btn-modern-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(196, 255, 87, 0.4);
        color: #1a1a1a;
    }
    
    .btn-modern-secondary {
        background: #f8f9fa;
        border: 2px solid #dee2e6;
        color: #495057;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-modern-secondary:hover {
        background: #e9ecef;
        border-color: #ced4da;
        color: #495057;
    }
    
    .info-badge {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        color: #1a1a1a;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .info-item {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.1) 0%, rgba(159, 232, 105, 0.1) 100%);
    }
    
    .info-item-label {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .info-item-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
    }
    
    .required-text {
        color: #dc3545;
        font-weight: 700;
    }

    .customer-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 auto 1rem;
        box-shadow: 0 4px 12px rgba(196, 255, 87, 0.3);
    }
</style>

<div class="page-header-modern">
    <h1>
        <i class="fas fa-user-edit me-2"></i>
        Edit Data Pelanggan
    </h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-modern mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('kasir.dashboard') }}">
                    <i class="fas fa-home me-1"></i>Dashboard
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('kasir.customers.index') }}">Data Pelanggan</a>
            </li>
            <li class="breadcrumb-item active">Edit Pelanggan</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card-modern">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                    <div class="info-badge">
                        <i class="fas fa-edit"></i>
                        Form Edit Pelanggan
                    </div>
                </div>

                <form action="{{ route('kasir.customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label-modern">
                            <i class="fas fa-user"></i>
                            Nama Lengkap 
                            <span class="required-text">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               class="form-control form-control-modern @error('name') is-invalid @enderror" 
                               value="{{ old('name', $customer->name) }}" 
                               placeholder="Masukkan nama lengkap pelanggan"
                               required>
                        @error('name')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label-modern">
                            <i class="fas fa-phone"></i>
                            No. Telepon
                        </label>
                        <input type="text" 
                               name="phone" 
                               class="form-control form-control-modern @error('phone') is-invalid @enderror" 
                               value="{{ old('phone', $customer->phone) }}" 
                               placeholder="Contoh: 081234567890">
                        @error('phone')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Format nomor telepon Indonesia (opsional)
                        </small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-modern">
                            <i class="fas fa-map-marker-alt"></i>
                            Alamat
                        </label>
                        <textarea name="address" 
                                  class="form-control form-control-modern @error('address') is-invalid @enderror" 
                                  rows="4"
                                  placeholder="Masukkan alamat lengkap pelanggan">{{ old('address', $customer->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex gap-3 pt-3 border-top">
                        <button type="submit" class="btn btn-modern-primary">
                            <i class="fas fa-save me-2"></i> Update Data
                        </button>
                        <a href="{{ route('kasir.customers.index') }}" class="btn btn-modern-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-modern">
            <div class="card-body p-4 text-center">
                <div class="customer-avatar">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
                <h5 class="fw-bold mb-1">{{ $customer->name }}</h5>
                <p class="text-muted small mb-3">Pelanggan Terdaftar</p>
            </div>
        </div>

        <div class="card-modern mt-3">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-info-circle me-2" style="color: #5a8e2a;"></i>
                    Informasi Pelanggan
                </h6>
                
                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-hashtag"></i>
                        ID Pelanggan
                    </div>
                    <div class="info-item-value">
                        #{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-item-label">
                        <i class="fas fa-calendar-alt"></i>
                        Terdaftar Sejak
                    </div>
                    <div class="info-item-value">
                        {{ $customer->created_at->format('d M Y') }}
                    </div>
                </div>

                <div class="info-item mb-0">
                    <div class="info-item-label">
                        <i class="fas fa-clock"></i>
                        Terakhir Diperbarui
                    </div>
                    <div class="info-item-value">
                        {{ $customer->updated_at->format('d M Y H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
