@extends('layouts.pelanggan')

@section('title', 'Keranjang Belanja - POSKigo')

@section('content')
<h2 class="mb-4">Keranjang Belanja</h2>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-shopping-cart me-2"></i> Item di Keranjang</span>
                @if(count($cartItems) > 0)
                <form action="{{ route('pelanggan.cart.clear') }}" method="POST" onsubmit="return confirm('Kosongkan semua item di keranjang?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash me-1"></i> Kosongkan Keranjang
                    </button>
                </form>
                @endif
            </div>
            <div class="card-body">
                @if(count($cartItems) > 0)
                    @foreach($cartItems as $cartItem)
                    <div class="row mb-3 pb-3 border-bottom align-items-center">
                        <div class="col-md-2 text-center">
                            <i class="fas fa-box fa-3x text-primary"></i>
                        </div>
                        <div class="col-md-4">
                            <h6 class="mb-1">{{ $cartItem['item']->name }}</h6>
                            <p class="text-muted mb-0 small">{{ $cartItem['item']->category->name }}</p>
                            <p class="text-primary mb-0"><strong>Rp {{ number_format($cartItem['item']->price, 0, ',', '.') }}</strong></p>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-group-sm">
                                <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity({{ $cartItem['item']->id }}, -1)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" class="form-control text-center" value="{{ $cartItem['quantity'] }}" 
                                       min="1" max="{{ $cartItem['item']->stock }}" id="qty-{{ $cartItem['item']->id }}" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity({{ $cartItem['item']->id }}, 1)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <small class="text-muted">Stok: {{ $cartItem['item']->stock }}</small>
                        </div>
                        <div class="col-md-2">
                            <strong class="text-success">Rp {{ number_format($cartItem['subtotal'], 0, ',', '.') }}</strong>
                        </div>
                        <div class="col-md-1 text-end">
                            <form action="{{ route('pelanggan.cart.remove', $cartItem['item']->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus item ini dari keranjang?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Keranjang Kosong</h5>
                        <p class="text-muted">Belum ada item di keranjang Anda</p>
                        <a href="{{ route('pelanggan.shop') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag me-2"></i> Mulai Belanja
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @if(count($cartItems) > 0)
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-receipt me-2"></i> Ringkasan Belanja</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pelanggan.checkout') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Kode Promo (Opsional)</label>
                        <input type="text" name="promotion_code" class="form-control" placeholder="Masukkan kode promo">
                        <small class="text-muted">Gunakan kode promo jika ada</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="cash">Cash</option>
                            <option value="wallet">KiWallet</option>
                        </select>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Pajak (10%)</span>
                        <strong>Rp {{ number_format($subtotal * 0.1, 0, ',', '.') }}</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <h5>Total</h5>
                        <h5 class="text-primary">Rp {{ number_format($subtotal + ($subtotal * 0.1), 0, ',', '.') }}</h5>
                    </div>

                    <button type="submit" class="btn btn-success w-100 btn-lg">
                        <i class="fas fa-check-circle me-2"></i> Checkout Sekarang
                    </button>
                </form>

                <div class="mt-3">
                    <a href="{{ route('pelanggan.shop') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-arrow-left me-2"></i> Lanjut Belanja
                    </a>
                </div>

                <div class="mt-3 p-3 bg-light rounded">
                    <h6 class="mb-2"><i class="fas fa-tags me-1"></i> Promo Tersedia:</h6>
                    @forelse($promotions as $promo)
                        <div class="mb-2">
                            <span class="badge bg-warning text-dark">{{ $promo->code }}</span>
                            <small class="d-block text-muted">{{ $promo->description }}</small>
                        </div>
                    @empty
                        <small class="text-muted">Tidak ada promo saat ini</small>
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
