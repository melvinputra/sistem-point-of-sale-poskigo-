@extends('layouts.kasir')

@section('title', 'Edit Pelanggan - POSKigo')

@section('content')
<h1 class="mt-4">Edit Pelanggan</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('kasir.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('kasir.customers.index') }}">Data Pelanggan</a></li>
    <li class="breadcrumb-item active">Edit Pelanggan</li>
</ol>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i> Form Edit Pelanggan
            </div>
            <div class="card-body">
                <form action="{{ route('kasir.customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $customer->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ old('phone', $customer->phone) }}" placeholder="Contoh: 081234567890">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                  rows="3">{{ old('address', $customer->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update
                        </button>
                        <a href="{{ route('kasir.customers.index') }}" class="btn btn-secondary">
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
                <i class="fas fa-info-circle me-1"></i> Info Pelanggan
            </div>
            <div class="card-body">
                <p class="mb-1"><small class="text-muted">ID Pelanggan:</small></p>
                <p class="mb-3"><strong>#{{ $customer->id }}</strong></p>
                
                <p class="mb-1"><small class="text-muted">Terdaftar Sejak:</small></p>
                <p class="mb-0"><strong>{{ $customer->created_at->format('d F Y') }}</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection
