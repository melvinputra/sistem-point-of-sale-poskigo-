@extends('layouts.pelanggan')

@section('title', 'Belanja - POSKigo')

@section('content')
<style>
    .page-header-shop {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 16px rgba(196, 255, 87, 0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .page-header-shop h1 {
        color: #1a1a1a;
        font-weight: 700;
        font-size: 1.75rem;
        margin: 0;
    }
    
    .btn-cart-modern {
        background: white;
        color: #1a1a1a;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        position: relative;
    }
    
    .btn-cart-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        color: #1a1a1a;
    }
    
    .cart-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #f44336;
        color: white;
        font-size: 0.7rem;
        font-weight: 700;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(244, 67, 54, 0.4);
    }
    
    .product-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }
    
    .product-image-container {
        width: 100%;
        height: 280px;
        overflow: hidden;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 1rem;
        transition: all 0.3s ease;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.08);
    }
    
    .product-image-placeholder {
        width: 100%;
        height: 280px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
    }
    
    .product-card-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .product-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
        min-height: 2.6rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.3;
    }
    
    .product-category {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.2) 0%, rgba(159, 232, 105, 0.2) 100%);
        color: #5a8e2a;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 0.75rem;
    }
    
    .product-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-price {
        color: #5a8e2a;
        font-weight: 800;
        font-size: 1.5rem;
        margin: 0;
    }
    
    .stock-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    
    .stock-high {
        background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
        color: white;
    }
    
    .stock-medium {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: #1a1a1a;
    }
    
    .stock-low {
        background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
        color: white;
    }
    
    .product-card-footer {
        padding: 1.5rem;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }
    
    .quantity-input-group {
        margin-bottom: 1rem;
    }
    
    .quantity-input {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-weight: 600;
        text-align: center;
    }
    
    .quantity-input:focus {
        border-color: #C4FF57;
        box-shadow: 0 0 0 0.2rem rgba(196, 255, 87, 0.15);
    }
    
    .btn-add-cart {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border: none;
        color: #1a1a1a;
        padding: 0.75rem;
        border-radius: 10px;
        font-weight: 700;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(196, 255, 87, 0.3);
    }
    
    .btn-add-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(196, 255, 87, 0.4);
        color: #1a1a1a;
    }
    
    .btn-out-stock {
        background: #dee2e6;
        border: none;
        color: #6c757d;
        padding: 0.75rem;
        border-radius: 10px;
        font-weight: 700;
        width: 100%;
    }
    
    .empty-state {
        background: white;
        border-radius: 20px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .empty-state-icon {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1.5rem;
    }
</style>

<div class="page-header-shop">
    <h1>
        <i class="fas fa-shopping-bag me-2"></i>
        Belanja Online
    </h1>
    <a href="{{ route('pelanggan.cart.index') }}" class="btn btn-cart-modern">
        <i class="fas fa-shopping-cart me-2"></i> Keranjang
        @if(Session::has('cart') && count(Session::get('cart')) > 0)
            <span class="cart-badge">{{ count(Session::get('cart')) }}</span>
        @endif
    </a>
</div>

<div class="row g-4">
    @forelse($items as $item)
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="product-card">
            <div class="product-image-container">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" class="product-image" alt="{{ $item->name }}">
                @else
                    <div class="product-image-placeholder">
                        <i class="fas fa-box fa-4x"></i>
                    </div>
                @endif
            </div>
            
            <div class="product-card-body">
                <span class="product-category">
                    <i class="fas fa-tag me-1"></i>{{ $item->category->name }}
                </span>
                <h5 class="product-title">{{ $item->name }}</h5>
                <p class="product-description">{{ Str::limit($item->description, 60) }}</p>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="product-price">Rp {{ number_format($item->price, 0, ',', '.') }}</h4>
                    <span class="stock-badge {{ $item->stock > 10 ? 'stock-high' : ($item->stock > 0 ? 'stock-medium' : 'stock-low') }}">
                        <i class="fas fa-box me-1"></i>{{ $item->stock }}
                    </span>
                </div>
            </div>
            
            <div class="product-card-footer">
                @if($item->stock > 0)
                    <form action="{{ route('pelanggan.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <div class="quantity-input-group">
                            <label class="form-label small text-muted mb-1">
                                <i class="fas fa-sort-numeric-up me-1"></i>Jumlah
                            </label>
                            <input type="number" 
                                   name="quantity" 
                                   class="form-control quantity-input" 
                                   value="1" 
                                   min="1" 
                                   max="{{ $item->stock }}">
                        </div>
                        <button type="submit" class="btn btn-add-cart">
                            <i class="fas fa-shopping-cart me-2"></i> Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <button class="btn btn-out-stock" disabled>
                        <i class="fas fa-times-circle me-2"></i> Stok Habis
                    </button>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-box-open"></i>
            </div>
            <h5 class="text-muted mb-2">Tidak ada produk tersedia</h5>
            <p class="text-muted">Silakan cek kembali nanti untuk produk baru</p>
        </div>
    </div>
    @endforelse
</div>

@if($items->hasPages())
<div class="mt-4">
    {{ $items->links() }}
</div>
@endif
@endsection
