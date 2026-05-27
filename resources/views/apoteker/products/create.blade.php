@extends('layouts.app')
@section('title', 'Tambah Obat')
@section('page-title', 'Tambah Produk Baru')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex align-items-center">
                    <div class="bg-soft-emerald p-2 rounded-3 me-3" style="background-color: #ecfdf5;">
                        <i class="fa fa-plus-circle text-emerald" style="color: #10b981;"></i>
                    </div>
                    <h5 class="mb-0 fw-bold">Form Tambah Obat</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('apoteker.products.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap Obat</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Amoxicillin 500mg" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Satuan</label>
                            <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit') }}" placeholder="Contoh: Tablet, Botol, Strip" required>
                            @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Harga Beli</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0">Rp</span>
                                <input type="number" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror ps-2" placeholder="0" value="{{ old('purchase_price') }}" min="0" required>
                            </div>
                            @error('purchase_price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Harga Jual</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0">Rp</span>
                                <input type="number" name="selling_price" class="form-control @error('selling_price') is-invalid @enderror ps-2" placeholder="0" value="{{ old('selling_price') }}" min="0" required>
                            </div>
                            @error('selling_price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Stok Awal</label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', 0) }}" min="0" required>
                            @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Kadaluarsa</label>
                            <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" value="{{ old('expiry_date') }}">
                            @error('expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2 mt-5 flex-wrap">
                        <button type="submit" class="btn btn-primary px-4 border-0" style="background-color: #10b981;">
                            <i class="fa fa-save me-2"></i> Simpan Obat
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
        <div class="card border-0 shadow-sm bg-soft-emerald mb-4" style="background-color: #ecfdf5;">
            <div class="card-body p-4 text-emerald" style="color: #065f46;">
                <h6 class="fw-bold mb-3"><i class="fa fa-info-circle me-2"></i>Petunjuk Pengisian</h6>
                <ul class="small mb-0 ps-3">
                    <li class="mb-2">Pastikan nama obat ditulis dengan dosis yang benar.</li>
                    <li class="mb-2">Harga beli digunakan untuk perhitungan laba rugi sistem.</li>
                    <li class="mb-2">Stok awal akan langsung tersedia untuk dijual di kasir.</li>
                    <li>Expired date sangat penting untuk notifikasi keamanan obat.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
