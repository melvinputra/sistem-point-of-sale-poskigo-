@extends('layouts.pelanggan')

@section('title', 'Keranjang Belanja - POSKigo')

@section('content')
<style>
    .page-header-modern {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 16px rgba(196, 255, 87, 0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .page-header-modern h1 {
        color: #1a1a1a;
        font-weight: 700;
        font-size: 1.75rem;
        margin: 0;
    }
    
    .btn-clear-cart {
        background: white;
        color: #f44336;
        border: 2px solid #f44336;
        padding: 0.5rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-clear-cart:hover {
        background: #f44336;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(244, 67, 54, 0.3);
    }
    
    .cart-items-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }
    
    .cart-item {
        padding: 1.5rem;
        border-bottom: 2px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .cart-item:last-child {
        border-bottom: none;
    }
    
    .cart-item:hover {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.03) 0%, rgba(159, 232, 105, 0.03) 100%);
    }
    
    .item-image-container {
        width: 100px;
        height: 100px;
        border-radius: 15px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .item-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 0.5rem;
    }
    
    .item-image-placeholder {
        font-size: 3rem;
        color: #dee2e6;
    }
    
    .item-info h6 {
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }
    
    .item-category {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.2) 0%, rgba(159, 232, 105, 0.2) 100%);
        color: #5a8e2a;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 0.5rem;
    }
    
    .item-price {
        color: #5a8e2a;
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .quantity-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #f8f9fa;
        border-radius: 12px;
        padding: 0.5rem;
        width: fit-content;
    }
    
    .quantity-btn {
        background: white;
        border: 2px solid #dee2e6;
        color: #495057;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .quantity-btn:hover {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        border-color: #C4FF57;
        color: #1a1a1a;
    }
    
    .quantity-input {
        width: 60px;
        text-align: center;
        border: none;
        background: white;
        font-weight: 700;
        font-size: 1.1rem;
        color: #1a1a1a;
        border-radius: 8px;
        padding: 0.5rem;
    }
    
    .stock-info {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 0.5rem;
    }
    
    .item-subtotal {
        font-weight: 800;
        font-size: 1.25rem;
        color: #5a8e2a;
    }
    
    .btn-remove-item {
        background: #fee;
        color: #f44336;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .btn-remove-item:hover {
        background: #f44336;
        color: white;
        transform: scale(1.1);
    }
    
    .summary-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        position: sticky;
        top: 20px;
    }
    
    .summary-header {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        padding: 1.5rem;
        border-radius: 20px 20px 0 0;
    }
    
    .summary-header h5 {
        color: #1a1a1a;
        font-weight: 700;
        margin: 0;
    }
    
    .form-label-modern {
        font-weight: 600;
        color: #2a2a2a;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-control-modern, .form-select-modern {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }
    
    .form-control-modern:focus, .form-select-modern:focus {
        border-color: #C4FF57;
        box-shadow: 0 0 0 0.2rem rgba(196, 255, 87, 0.15);
        outline: none;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .summary-total {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.2) 0%, rgba(159, 232, 105, 0.2) 100%);
        border-radius: 12px;
        padding: 1.25rem;
        margin: 1rem 0;
    }
    
    .summary-total .summary-row {
        border: none;
        font-weight: 800;
        font-size: 1.5rem;
        color: #1a1a1a;
    }
    
    .btn-checkout {
        background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
        border: none;
        color: white;
        padding: 1rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    }
    
    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
        color: white;
    }
    
    .btn-continue-shopping {
        background: white;
        border: 2px solid #dee2e6;
        color: #495057;
        padding: 0.75rem;
        border-radius: 12px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
    }
    
    .btn-continue-shopping:hover {
        background: #f8f9fa;
        border-color: #C4FF57;
        color: #1a1a1a;
    }
    
    .promo-section {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 152, 0, 0.1) 100%);
        border: 2px solid #ffc107;
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1.5rem;
    }
    
    .promo-title {
        font-weight: 700;
        color: #ff9800;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .promo-badge {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        color: #1a1a1a;
        padding: 0.35rem 0.75rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-block;
        margin-bottom: 0.5rem;
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

<div class="page-header-modern">
    <h1>
        <i class="fas fa-shopping-cart me-2"></i>
        Keranjang Belanja
    </h1>
    @if(count($cartItems) > 0)
    <form action="{{ route('pelanggan.cart.clear') }}" method="POST" onsubmit="return confirm('Kosongkan semua item di keranjang?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-clear-cart">
            <i class="fas fa-trash me-2"></i> Kosongkan Keranjang
        </button>
    </form>
    @endif
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="cart-items-card">
            @if(count($cartItems) > 0)
                @foreach($cartItems as $cartItem)
                <div class="cart-item">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="item-image-container">
                                @if($cartItem['item']->image)
                                    <img src="{{ asset('storage/' . $cartItem['item']->image) }}" 
                                         class="item-image" 
                                         alt="{{ $cartItem['item']->name }}">
                                @else
                                    <i class="fas fa-box item-image-placeholder"></i>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="item-info">
                                <span class="item-category">
                                    <i class="fas fa-tag me-1"></i>{{ $cartItem['item']->category->name }}
                                </span>
                                <h6>{{ $cartItem['item']->name }}</h6>
                                <div class="item-price">
                                    Rp {{ number_format($cartItem['item']->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="quantity-control">
                                <button class="quantity-btn" type="button" onclick="updateQuantity({{ $cartItem['item']->id }}, -1)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" class="quantity-input" value="{{ $cartItem['quantity'] }}" 
                                       min="1" max="{{ $cartItem['item']->stock }}" id="qty-{{ $cartItem['item']->id }}" readonly>
                                <button class="quantity-btn" type="button" onclick="updateQuantity({{ $cartItem['item']->id }}, 1)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="stock-info">
                                <i class="fas fa-box me-1"></i>Stok: {{ $cartItem['item']->stock }}
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <div class="item-subtotal">
                                Rp {{ number_format($cartItem['subtotal'], 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-md-1 text-end">
                            <form action="{{ route('pelanggan.cart.remove', $cartItem['item']->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-remove-item" onclick="return confirm('Hapus item ini dari keranjang?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h5 class="text-muted mb-2">Keranjang Kosong</h5>
                    <p class="text-muted mb-4">Belum ada item di keranjang Anda</p>
                    <a href="{{ route('pelanggan.shop') }}" class="btn btn-modern-primary">
                        <i class="fas fa-shopping-bag me-2"></i> Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-4">
        @if(count($cartItems) > 0)
        <div class="summary-card">
            <div class="summary-header">
                <h5>
                    <i class="fas fa-receipt me-2"></i> Ringkasan Belanja
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('pelanggan.checkout') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label-modern">
                            <i class="fas fa-tag"></i>
                            Kode Promo (Opsional)
                        </label>
                        <input type="text" 
                               id="promoCodeInput"
                               name="promotion_code" 
                               class="form-control form-control-modern" 
                               placeholder="Masukkan kode promo"
                               style="text-transform: uppercase;">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>Dapatkan diskon dengan kode promo
                        </small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-modern">
                            <i class="fas fa-credit-card"></i>
                            Metode Pembayaran
                        </label>
                        <select name="payment_method" class="form-select form-select-modern" required>
                            <option value="cash">💵 Cash</option>
                            <option value="wallet">💳 KiWallet</option>
                        </select>
                    </div>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                    </div>
                    <div class="summary-row">
                        <span><i class="fas fa-percentage me-1"></i>Pajak (10%)</span>
                        <strong>Rp {{ number_format($subtotal * 0.1, 0, ',', '.') }}</strong>
                    </div>
                    
                    <div class="summary-total">
                        <div class="summary-row">
                            <span>TOTAL</span>
                            <span>Rp {{ number_format($subtotal + ($subtotal * 0.1), 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-checkout">
                        <i class="fas fa-check-circle me-2"></i> Checkout Sekarang
                    </button>
                </form>

                <div class="mt-3">
                    <a href="{{ route('pelanggan.shop') }}" class="btn btn-continue-shopping">
                        <i class="fas fa-arrow-left me-2"></i> Lanjut Belanja
                    </a>
                </div>

                <div class="promo-section">
                    <div class="promo-title">
                        <i class="fas fa-tags"></i> Promo Tersedia
                    </div>
                    @forelse($promotions as $promo)
                        <div class="mb-2 p-2" style="background: rgba(196, 255, 87, 0.1); border-left: 3px solid #C4FF57; border-radius: 8px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="promo-badge">{{ $promo->code }}</span>
                                    <div>
                                        <small style="color: #1a1a1a; font-weight: 500;">{{ $promo->title }}</small>
                                    </div>
                                    <div>
                                        <small class="text-muted">
                                            @if($promo->type === 'percentage')
                                                Diskon {{ number_format($promo->discount_value, 0) }}%
                                            @else
                                                Diskon Rp {{ number_format($promo->discount_value, 0, ',', '.') }}
                                            @endif
                                            @if($promo->min_purchase > 0)
                                                | Min. Rp {{ number_format($promo->min_purchase, 0, ',', '.') }}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-success" 
                                        onclick="document.getElementById('promoCodeInput').value = '{{ $promo->code }}'">
                                    <i class="fas fa-check"></i> Pakai
                                </button>
                            </div>
                        </div>
                    @empty
                        <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Tidak ada promo saat ini</small>
                    @endforelse
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function updateQuantity(itemId, change) {
    const qtyInput = document.getElementById('qty-' + itemId);
    let currentQty = parseInt(qtyInput.value);
    let newQty = currentQty + change;
    
    if (newQty < 1) {
        if (confirm('Hapus item ini dari keranjang?')) {
            window.location.href = '{{ url("/pelanggan/cart/remove") }}/' + itemId;
        }
        return;
    }
    
    const maxStock = parseInt(qtyInput.max);
    if (newQty > maxStock) {
        alert('Stok tidak mencukupi! Maksimal: ' + maxStock);
        return;
    }
    
    // Update via AJAX
    fetch('{{ route("pelanggan.cart.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            item_id: itemId,
            quantity: newQty
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat update keranjang');
    });
}
</script>
@endsection
