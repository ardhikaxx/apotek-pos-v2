@extends('layouts.app')
@section('title', 'Edit Obat')
@section('page-title', 'Perbarui Data Obat')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-2 rounded-3 me-3">
                        <i class="fa fa-edit text-warning"></i>
                    </div>
                    <h5 class="mb-0 fw-bold">Edit Informasi Obat</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('apoteker.products.update', $product) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap Obat</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Satuan</label>
                            <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit', $product->unit) }}" required>
                            @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Harga Beli</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0">Rp</span>
                                <input type="number" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror ps-2" value="{{ old('purchase_price', $product->purchase_price) }}" min="0" required>
                            </div>
                            @error('purchase_price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Harga Jual</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0">Rp</span>
                                <input type="number" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror ps-2" value="{{ old('selling_price', $product->selling_price) }}" min="0" required>
                            </div>
                            @error('selling_price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Stok Saat Ini</label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" min="0" required>
                            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Kadaluarsa</label>
                            <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" value="{{ old('expiry_date', $product->expiry_date) }}">
                            @error('expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2 mt-5 flex-wrap">
                        <button type="submit" class="btn btn-warning px-4 fw-bold text-dark border-0">
                            <i class="fa fa-save me-2"></i> Update Data Obat
                        </button>
                        <a href="{{ route('apoteker.products.index') }}" class="btn btn-light px-4 border text-secondary fw-semibold">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-light mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="fa fa-history me-2 text-primary"></i>Informasi Terakhir</h6>
                <div class="small text-muted mb-2">Ditambahkan pada:</div>
                <div class="fw-bold text-dark mb-3">{{ $product->created_at->format('d M Y, H:i') }}</div>
                
                <div class="small text-muted mb-2">Terakhir diupdate:</div>
                <div class="fw-bold text-dark">{{ $product->updated_at->format('d M Y, H:i') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
