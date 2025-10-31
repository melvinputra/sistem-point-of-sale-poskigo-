@extends('layouts.pelanggan')

@section('title', 'Belanja - POSKigo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Belanja Online</h2>
    <a href="{{ route('pelanggan.cart.index') }}" class="btn btn-primary">
        <i class="fas fa-shopping-cart me-2"></i> Keranjang
        @if(Session::has('cart') && count(Session::get('cart')) > 0)
            <span class="badge bg-danger">{{ count(Session::get('cart')) }}</span>
        @endif
    </a>
</div>

<div class="row">
    @forelse($items as $item)
    <div class="col-md-3 mb-4">
        <div class="card h-100">
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->name }}" 
                     style="height: 200px; object-fit: cover;">
            @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    <i class="fas fa-box fa-4x text-secondary"></i>
                </div>
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $item->name }}</h5>
                <p class="text-muted small">{{ $item->category->name }}</p>
                <p class="card-text">{{ Str::limit($item->description, 60) }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="text-primary mb-0">Rp {{ number_format($item->price, 0, ',', '.') }}</h5>
                    <span class="badge bg-{{ $item->stock > 10 ? 'success' : ($item->stock > 0 ? 'warning' : 'danger') }}">
                        Stok: {{ $item->stock }}
                    </span>
                </div>
            </div>
            <div class="card-footer">
                @if($item->stock > 0)
                    <form action="{{ route('pelanggan.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text">Qty</span>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $item->stock }}">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-sm">
                            <i class="fas fa-shopping-cart me-1"></i> Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <button class="btn btn-secondary w-100 btn-sm" disabled>
                        <i class="fas fa-times me-1"></i> Stok Habis
                    </button>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i> Tidak ada produk tersedia
        </div>
    </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $items->links() }}
</div>
@endsection
