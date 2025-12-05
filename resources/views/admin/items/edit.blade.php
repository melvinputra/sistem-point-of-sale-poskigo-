@extends('layouts.admin')

@section('title', 'Edit Barang - POSKigo')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="page-header-modern">
        <div>
            <h1 class="page-title-modern">
                <i class="fas fa-edit me-2"></i>
                Edit Barang
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb-modern">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.items.index') }}">Data Barang</a></li>
                    <li class="breadcrumb-item active">Edit Barang</li>
                </ol>
            </nav>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary btn-modern">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card card-modern shadow-sm">
                <div class="card-header-modern">
                    <div class="d-flex align-items-center">
                        <div class="icon-wrapper-modern bg-gradient-primary me-3">
                            <i class="fas fa-box"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Form Edit Barang</h5>
                            <small class="text-muted">Perbarui informasi barang: <strong>{{ $item->name }}</strong></small>
                        </div>
                    </div>
                </div>
                <div class="card-body card-body-modern">
                    <form action="{{ route('admin.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label-modern">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-modern @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $item->name) }}" placeholder="Masukkan nama barang" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label-modern">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select form-control-modern @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label-modern">Harga <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text input-group-modern">Rp</span>
                                        <input type="number" name="price" class="form-control form-control-modern @error('price') is-invalid @enderror" 
                                               value="{{ old('price', $item->price) }}" placeholder="0" min="0" required>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label-modern">Stok <span class="text-danger">*</span></label>
                                    <input type="number" name="stock" class="form-control form-control-modern @error('stock') is-invalid @enderror" 
                                           value="{{ old('stock', $item->stock) }}" placeholder="0" min="0" required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-modern">Deskripsi</label>
                            <textarea name="description" class="form-control form-control-modern @error('description') is-invalid @enderror" 
                                      rows="4" placeholder="Masukkan deskripsi barang (opsional)">{{ old('description', $item->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label-modern">Gambar Barang</label>
                            
                            @if($item->image)
                                <div class="mb-3" id="currentImageContainer">
                                    <div class="current-image-wrapper">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" 
                                             class="img-thumbnail rounded-modern" style="max-width: 300px; max-height: 300px;" id="currentImage">
                                        <div class="mt-2">
                                            <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Gambar saat ini</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="upload-area-modern">
                                <input type="file" name="image" id="imageInput" class="form-control form-control-modern @error('image') is-invalid @enderror" 
                                       accept="image/*" onchange="previewImage(event)">
                                <div class="upload-placeholder" id="uploadPlaceholder">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                    <p class="mb-1 text-muted">Klik untuk upload gambar baru</p>
                                    <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                                    <small class="d-block text-muted mt-1">Kosongkan jika tidak ingin mengubah gambar</small>
                                </div>
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mt-3" id="imagePreviewContainer" style="display: none;">
                                <div class="position-relative d-inline-block">
                                    <img id="imagePreview" src="" alt="Preview" class="img-thumbnail rounded-modern" style="max-width: 300px; max-height: 300px;">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle" onclick="removeImage()" style="width: 30px; height: 30px; padding: 0;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="mt-2">
                                    <small class="text-success"><i class="fas fa-check-circle me-1"></i>Gambar baru dipilih</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 justify-content-end mt-5">
                            <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary btn-modern px-4">
                                <i class="fas fa-times me-2"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-gradient-primary btn-modern px-4">
                                <i class="fas fa-save me-2"></i>
                                Update Barang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-header-modern {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid #f0f0f0;
}

.page-title-modern {
    font-size: 1.75rem;
    font-weight: 800;
    color: #2a2a2a;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.page-title-modern i {
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.breadcrumb-modern {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.breadcrumb-modern .breadcrumb-item {
    color: #6c757d;
}

.breadcrumb-modern .breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    padding-right: 0.5rem;
    color: #adb5bd;
}

.breadcrumb-modern .breadcrumb-item a {
    color: #6c757d;
    text-decoration: none;
    transition: all 0.3s ease;
}

.breadcrumb-modern .breadcrumb-item a:hover {
    color: var(--dark-green);
}

.breadcrumb-modern .breadcrumb-item.active {
    color: var(--dark-green);
    font-weight: 600;
}

.page-header-actions {
    display: flex;
    gap: 0.75rem;
}

.card-modern {
    border: none;
    border-radius: 20px;
    overflow: hidden;
}

.card-header-modern {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border-bottom: 2px solid #f0f0f0;
    padding: 1.5rem 2rem;
}

.icon-wrapper-modern {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #2a2a2a;
}

.bg-gradient-primary {
    background: var(--gradient-primary);
}

.card-body-modern {
    padding: 2rem;
}

.form-label-modern {
    font-weight: 600;
    color: #2a2a2a;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.form-control-modern {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.form-control-modern:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 0.2rem rgba(196, 255, 87, 0.15);
}

.input-group-modern {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-right: none;
    border-radius: 12px 0 0 12px;
    font-weight: 600;
    color: #2a2a2a;
}

.input-group .form-control-modern {
    border-left: none;
    border-radius: 0 12px 12px 0;
}

.current-image-wrapper {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    display: inline-block;
}

.upload-area-modern {
    position: relative;
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-area-modern:hover {
    border-color: var(--primary-green);
    background: rgba(196, 255, 87, 0.05);
}

.upload-area-modern input[type="file"] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.upload-placeholder {
    pointer-events: none;
}

.rounded-modern {
    border-radius: 12px;
}

.btn-modern {
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid;
}

.btn-gradient-primary {
    background: var(--gradient-primary);
    border-color: transparent;
    color: #2a2a2a;
}

.btn-gradient-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(196, 255, 87, 0.3);
    color: #1a1a1a;
}

.btn-outline-secondary {
    border-color: #dee2e6;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background: #f8f9fa;
    border-color: #adb5bd;
    color: #495057;
}
</style>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');
    const container = document.getElementById('imagePreviewContainer');
    const placeholder = document.getElementById('uploadPlaceholder');
    const currentImageContainer = document.getElementById('currentImageContainer');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
            placeholder.style.display = 'none';
            if (currentImageContainer) {
                currentImageContainer.style.opacity = '0.5';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    const input = document.getElementById('imageInput');
    const preview = document.getElementById('imagePreview');
    const container = document.getElementById('imagePreviewContainer');
    const placeholder = document.getElementById('uploadPlaceholder');
    const currentImageContainer = document.getElementById('currentImageContainer');
    
    input.value = '';
    preview.src = '';
    container.style.display = 'none';
    placeholder.style.display = 'block';
    if (currentImageContainer) {
        currentImageContainer.style.opacity = '1';
    }
}
</script>
@endsection
