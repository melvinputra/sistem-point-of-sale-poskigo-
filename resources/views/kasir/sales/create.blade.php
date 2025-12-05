@extends('layouts.kasir')

@section('title', 'Transaksi Baru - POSKigo')

@section('content')
<style>
    .page-header-modern {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-header-modern h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .breadcrumb-modern {
        background: transparent;
        padding: 0;
        margin: 0.5rem 0 0 0;
        font-size: 0.9rem;
    }

    .breadcrumb-modern a {
        color: #6a6a6a;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb-modern a:hover {
        color: #9FE869;
    }

    .card-modern {
        background: #ffffff;
        border: 2px solid #f0f0f0;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .card-modern-header {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .form-label-modern {
        font-weight: 600;
        color: #2a2a2a;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-control-modern,
    .form-select-modern {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.7rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus,
    .form-select-modern:focus {
        border-color: #C4FF57;
        box-shadow: 0 0 0 3px rgba(196, 255, 87, 0.1);
    }

    .btn-modern-primary {
        background: linear-gradient(135deg, #C4FF57 0%, #9FE869 100%);
        color: #1a1a1a;
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-modern-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(196, 255, 87, 0.4);
        color: #1a1a1a;
    }

    .btn-modern-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-modern-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-modern-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-modern-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(239, 68, 68, 0.4);
        color: white;
    }

    .btn-modern-secondary {
        background: #6b7280;
        color: white;
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-modern-secondary:hover {
        background: #4b5563;
        color: white;
    }

    .item-row-modern {
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 15px;
        padding: 1.2rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .item-row-modern:hover {
        border-color: #C4FF57;
        box-shadow: 0 5px 15px rgba(196, 255, 87, 0.15);
    }

    .summary-card {
        background: linear-gradient(135deg, rgba(196, 255, 87, 0.1) 0%, rgba(159, 232, 105, 0.05) 100%);
        border: 2px solid #C4FF57;
        border-radius: 20px;
        padding: 2rem;
        position: sticky;
        top: 100px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding-bottom: 0.8rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .summary-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .summary-total {
        font-size: 1.5rem;
        font-weight: 800;
        color: #5a8e2a;
    }

    .image-preview-modern {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid #e5e7eb;
    }

    .image-preview-modern img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .promo-badge {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }

    .section-divider {
        margin: 2rem 0;
        border: none;
        border-top: 2px dashed #e5e7eb;
    }
</style>

<div class="page-header-modern">
    <div>
        <h1>
            <i class="fas fa-cash-register"></i>
            Transaksi Baru
        </h1>
        <nav class="breadcrumb-modern">
            <a href="{{ route('kasir.dashboard') }}">Dashboard</a>
            <span class="mx-2">/</span>
            <span>Transaksi Baru</span>
        </nav>
    </div>
</div>

<div class="card-modern">
    <div class="card-modern-header">
        <i class="fas fa-shopping-cart"></i>
        Form Transaksi Penjualan
    </div>

    <form action="{{ route('kasir.sales.store') }}" method="POST" id="saleForm">
        @csrf

        <div class="row mb-4">
            <div class="col-md-6">
                <label class="form-label-modern">
                    <i class="fas fa-user me-1"></i> Pelanggan (Opsional)
                </label>
                <select name="customer_id" class="form-select form-select-modern">
                    <option value="">-- Pelanggan Umum --</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label-modern">
                    <i class="fas fa-tag me-1"></i> Kode Promo (Opsional)
                </label>
                <div class="input-group">
                    <input type="text" name="promotion_code" id="promoCode" class="form-control form-control-modern" placeholder="Masukkan kode promo">
                    <button type="button" class="btn btn-modern-success" id="checkPromo">
                        <i class="fas fa-check"></i> Cek Promo
                    </button>
                </div>
                <small class="text-muted" id="promoInfo"></small>
            </div>
        </div>

        <hr class="section-divider">

        <h5 class="mb-3" style="font-weight: 700; color: #1a1a1a;">
            <i class="fas fa-boxes me-2"></i> Daftar Barang
        </h5>
        
        <div id="itemsContainer">
        <div id="itemsContainer">
            <div class="item-row-modern">
                <div class="row align-items-center">
                    <div class="col-md-1">
                        <label class="form-label-modern">Foto</label>
                        <div class="item-image-preview image-preview-modern">
                            <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-modern">Pilih Barang</label>
                        <select name="items[0][item_id]" class="form-select form-select-modern item-select" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-stock="{{ $item->stock }}" data-image="{{ $item->image ? asset('storage/' . $item->image) : '' }}">
                                    {{ $item->name }} - Stok: {{ $item->stock }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label-modern">Harga</label>
                        <input type="text" class="form-control form-control-modern item-price" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label-modern">Jumlah</label>
                        <input type="number" name="items[0][quantity]" class="form-control form-control-modern item-quantity" min="1" value="1" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label-modern">Subtotal</label>
                        <input type="text" class="form-control form-control-modern item-subtotal" readonly>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label-modern">&nbsp;</label>
                        <button type="button" class="btn btn-modern-danger w-100 remove-item" disabled>
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-modern-success mb-4" id="addItem">
            <i class="fas fa-plus me-1"></i> Tambah Barang
        </button>

        <hr class="section-divider">

        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-modern">
                            <i class="fas fa-percentage me-1"></i> Pajak (%)
                        </label>
                        <input type="number" name="tax_rate" id="taxRate" class="form-control form-control-modern" min="0" max="100" value="0" step="0.01">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label-modern">
                            <i class="fas fa-money-bill-wave me-1"></i> Uang Dibayar <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="cash_paid" id="cashPaid" class="form-control form-control-modern" min="0" step="1000" required placeholder="Masukkan jumlah uang">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card">
                    <h6 style="font-weight: 700; margin-bottom: 1.5rem; color: #1a1a1a;">
                        <i class="fas fa-calculator me-2"></i> Ringkasan
                    </h6>
                    <div class="summary-row">
                        <span style="color: #6a6a6a;">Subtotal:</span>
                        <strong id="subtotalDisplay">Rp 0</strong>
                    </div>
                    <div class="summary-row">
                        <span style="color: #6a6a6a;">Diskon:</span>
                        <strong class="text-success" id="discountDisplay">Rp 0</strong>
                    </div>
                    <div class="summary-row">
                        <span style="color: #6a6a6a;">Pajak:</span>
                        <strong id="taxDisplay">Rp 0</strong>
                    </div>
                    <div class="summary-row" style="margin-top: 1rem; padding-top: 1rem; border-top: 2px solid rgba(0,0,0,0.1);">
                        <span style="font-size: 1.2rem; font-weight: 700;">Total:</span>
                        <span class="summary-total" id="grandTotal">Rp 0</span>
                    </div>
                    <div class="summary-row" style="background: rgba(16, 185, 129, 0.1); padding: 1rem; border-radius: 10px; margin-top: 1rem;">
                        <strong style="color: #059669;">Kembalian:</strong>
                        <strong style="color: #059669; font-size: 1.2rem;" id="changeDisplay">Rp 0</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-3 mt-4">
            <button type="submit" class="btn btn-modern-primary btn-lg">
                <i class="fas fa-check-circle me-2"></i> Proses Transaksi
            </button>
            <a href="{{ route('kasir.dashboard') }}" class="btn btn-modern-secondary btn-lg">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </form>
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
    const newRow = document.querySelector('.item-row-modern').cloneNode(true);
    
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
    newRow.querySelector('.item-image-preview').innerHTML = `<div class="bg-light d-flex align-items-center justify-content-center h-100"><i class="fas fa-image text-muted"></i></div>`;
    
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
            imagePreview.innerHTML = `<img src="${imageUrl}" alt="Item" style="width: 100%; height: 100%; object-fit: cover;">`;
        } else {
            imagePreview.innerHTML = `<div class="bg-light d-flex align-items-center justify-content-center h-100"><i class="fas fa-image text-muted"></i></div>`;
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
document.querySelectorAll('.item-row-modern').forEach(row => {
    attachRowEvents(row);
});
</script>
@endpush
