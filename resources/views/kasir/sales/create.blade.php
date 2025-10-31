@extends('layouts.kasir')

@section('title', 'Transaksi Baru - POSKigo')

@section('content')
<h1 class="mt-4">Transaksi Penjualan Baru</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('kasir.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Transaksi Baru</li>
</ol>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-cash-register me-1"></i> Form Transaksi
            </div>
            <div class="card-body">
                <form action="{{ route('kasir.sales.store') }}" method="POST" id="saleForm">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Pelanggan (Opsional)</label>
                            <select name="customer_id" class="form-select">
                                <option value="">-- Umum --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kode Promo (Opsional)</label>
                            <div class="input-group">
                                <input type="text" name="promotion_code" id="promoCode" class="form-control" placeholder="Masukkan kode promo">
                                <button type="button" class="btn btn-outline-success" id="checkPromo">
                                    <i class="fas fa-check"></i> Cek
                                </button>
                            </div>
                            <small class="text-muted" id="promoInfo"></small>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3">Barang yang dibeli</h5>
                    
                    <div id="itemsContainer">
                        <div class="row mb-3 item-row">
                            <div class="col-md-1">
                                <label class="form-label">Foto</label>
                                <div class="item-image-preview">
                                    <div class="bg-light border rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Barang</label>
                                <select name="items[0][item_id]" class="form-select item-select" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-stock="{{ $item->stock }}" data-image="{{ $item->image ? asset('storage/' . $item->image) : '' }}">
                                            {{ $item->name }} - Stok: {{ $item->stock }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Harga</label>
                                <input type="text" class="form-control item-price" readonly>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="items[0][quantity]" class="form-control item-quantity" min="1" value="1" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Subtotal</label>
                                <input type="text" class="form-control item-subtotal" readonly>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-sm w-100 remove-item" disabled>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success mb-3" id="addItem">
                        <i class="fas fa-plus me-1"></i> Tambah Barang
                    </button>

                    <hr>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pajak (%)</label>
                                    <input type="number" name="tax_rate" id="taxRate" class="form-control" min="0" max="100" value="0" step="0.01">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Uang Dibayar <span class="text-danger">*</span></label>
                                    <input type="number" name="cash_paid" id="cashPaid" class="form-control" min="0" step="1000" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <strong id="subtotalDisplay">Rp 0</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Diskon:</span>
                                        <strong class="text-success" id="discountDisplay">Rp 0</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Pajak:</span>
                                        <strong id="taxDisplay">Rp 0</strong>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5>Total:</h5>
                                        <h5 class="text-primary" id="grandTotal">Rp 0</h5>
                                    </div>
                                    <div class="d-flex justify-content-between text-success">
                                        <strong>Kembalian:</strong>
                                        <strong id="changeDisplay">Rp 0</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-check me-1"></i> Proses Transaksi
                        </button>
                        <a href="{{ route('kasir.dashboard') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let itemCount = 1;
let promoDiscount = 0;
let promoType = '';
let promoValue = 0;

function formatRupiah(angka) {
    return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function calculateSubtotal(row) {
    const priceInput = row.querySelector('.item-price');
    const quantityInput = row.querySelector('.item-quantity');
    const subtotalInput = row.querySelector('.item-subtotal');
    
    // Ambil harga dari data attribute select option
    const select = row.querySelector('.item-select');
    const selectedOption = select.options[select.selectedIndex];
    const price = parseFloat(selectedOption.dataset.price) || 0;
    
    const quantity = parseInt(quantityInput.value) || 0;
    const subtotal = price * quantity;
    
    subtotalInput.value = formatRupiah(subtotal);
    
    calculateGrandTotal();
}

function calculateGrandTotal() {
    let subtotal = 0;
    document.querySelectorAll('.item-subtotal').forEach(input => {
        const value = parseFloat(input.value.replace(/[^0-9]/g, '')) || 0;
        subtotal += value;
    });
    
    // Hitung diskon
    let discount = 0;
    if (promoType === 'percentage') {
        discount = (subtotal * promoValue) / 100;
    } else if (promoType === 'fixed') {
        discount = promoValue;
    }
    
    // Hitung pajak
    const taxRate = parseFloat(document.getElementById('taxRate').value) || 0;
    const afterDiscount = subtotal - discount;
    const tax = (afterDiscount * taxRate) / 100;
    
    // Total
    const grandTotal = afterDiscount + tax;
    
    // Kembalian
    const cashPaid = parseFloat(document.getElementById('cashPaid').value) || 0;
    const change = cashPaid - grandTotal;
    
    // Update display
    document.getElementById('subtotalDisplay').textContent = formatRupiah(subtotal);
    document.getElementById('discountDisplay').textContent = formatRupiah(discount);
    document.getElementById('taxDisplay').textContent = formatRupiah(tax);
    document.getElementById('grandTotal').textContent = formatRupiah(grandTotal);
    document.getElementById('changeDisplay').textContent = formatRupiah(change > 0 ? change : 0);
    
    // Validasi uang dibayar
    if (cashPaid > 0 && change < 0) {
        document.getElementById('changeDisplay').textContent = 'Kurang!';
        document.getElementById('changeDisplay').classList.add('text-danger');
        document.getElementById('changeDisplay').classList.remove('text-success');
    } else {
        document.getElementById('changeDisplay').classList.add('text-success');
        document.getElementById('changeDisplay').classList.remove('text-danger');
    }
}

// Event listeners untuk pajak dan uang dibayar
document.getElementById('taxRate').addEventListener('input', calculateGrandTotal);
document.getElementById('cashPaid').addEventListener('input', calculateGrandTotal);

// Cek promo
document.getElementById('checkPromo').addEventListener('click', function() {
    const promoCode = document.getElementById('promoCode').value;
    if (!promoCode) {
        toastr.warning('Masukkan kode promo terlebih dahulu');
        return;
    }
    
    // Simulasi cek promo (seharusnya AJAX ke server)
    const promos = @json($promotions);
    const promo = promos.find(p => p.code === promoCode);
    
    if (promo) {
        promoType = promo.type;
        promoValue = promo.discount_value;
        
        let discountText = promo.type === 'percentage' 
            ? promo.discount_value + '%' 
            : 'Rp ' + formatRupiah(promo.discount_value);
        
        document.getElementById('promoInfo').textContent = '✓ Promo valid! Diskon: ' + discountText;
        document.getElementById('promoInfo').classList.add('text-success');
        toastr.success('Kode promo berhasil diterapkan!');
        calculateGrandTotal();
    } else {
        promoType = '';
        promoValue = 0;
        promoDiscount = 0;
        document.getElementById('promoInfo').textContent = '✗ Kode promo tidak valid';
        document.getElementById('promoInfo').classList.remove('text-success');
        document.getElementById('promoInfo').classList.add('text-danger');
        toastr.error('Kode promo tidak ditemukan');
        calculateGrandTotal();
    }
});

document.getElementById('addItem').addEventListener('click', function() {
    const container = document.getElementById('itemsContainer');
    const newRow = document.querySelector('.item-row').cloneNode(true);
    
    // Update name attributes
    newRow.querySelectorAll('[name]').forEach(input => {
        const name = input.getAttribute('name');
        input.setAttribute('name', name.replace(/\[\d+\]/, '[' + itemCount + ']'));
    });
    
    // Reset values
    newRow.querySelector('.item-select').value = '';
    newRow.querySelector('.item-price').value = '';
    newRow.querySelector('.item-quantity').value = '1';
    newRow.querySelector('.item-subtotal').value = '';
    newRow.querySelector('.remove-item').disabled = false;
    
    // Reset image preview
    newRow.querySelector('.item-image-preview').innerHTML = `<div class="bg-light border rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fas fa-image text-muted"></i></div>`;
    
    container.appendChild(newRow);
    itemCount++;
    
    attachRowEvents(newRow);
});

function attachRowEvents(row) {
    const select = row.querySelector('.item-select');
    const priceInput = row.querySelector('.item-price');
    const quantityInput = row.querySelector('.item-quantity');
    const removeBtn = row.querySelector('.remove-item');
    const imagePreview = row.querySelector('.item-image-preview');
    
    select.addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        const price = option.dataset.price || 0;
        const imageUrl = option.dataset.image || '';
        
        priceInput.value = formatRupiah(price);
        
        // Update image preview
        if (imageUrl) {
            imagePreview.innerHTML = `<img src="${imageUrl}" alt="Item" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">`;
        } else {
            imagePreview.innerHTML = `<div class="bg-light border rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="fas fa-image text-muted"></i></div>`;
        }
        
        calculateSubtotal(row);
    });
    
    quantityInput.addEventListener('input', function() {
        calculateSubtotal(row);
    });
    
    removeBtn.addEventListener('click', function() {
        row.remove();
        calculateGrandTotal();
    });
}

// Attach events to initial row
document.querySelectorAll('.item-row').forEach(row => {
    attachRowEvents(row);
});
</script>
@endpush
