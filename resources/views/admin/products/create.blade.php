@extends('layouts.app')
@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk Baru')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex align-items-center">
                    <div class="bg-soft-emerald p-2 rounded-3 me-3" style="background-color: #ecfdf5;">
                        <i class="fa fa-pills text-emerald" style="color: #10b981;"></i>
                    </div>
                    <h5 class="mb-0 fw-bold">Informasi Produk</h5>
                </div>
            </div>
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger border-0 py-2 small mb-4" style="background-color: #fef2f2; color: #991b1b; border-radius: 10px;">
                        <i class="fa fa-exclamation-circle me-1"></i>{{ $errors->first() }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('admin.products.store') }}">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label">Nama Lengkap Produk</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Paracetamol 500mg" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Satuan</label>
                            <input type="text" name="unit" class="form-control" value="{{ old('unit') }}" placeholder="tablet, strip, botol..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga Beli (Modal)</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0">Rp</span>
                                <input type="number" name="purchase_price" class="form-control ps-2" placeholder="0" value="{{ old('purchase_price') }}" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Harga Jual</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0">Rp</span>
                                <input type="number" name="selling_price" class="form-control ps-2" placeholder="0" value="{{ old('selling_price') }}" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stok Awal</label>
                            <div class="input-group">
                                <input type="number" name="stock" class="form-control border-end-0" value="{{ old('stock', 0) }}" min="0" required>
                                <span class="input-group-text bg-white">Unit</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Kadaluarsa</label>
                            <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2 mt-5 flex-wrap">
                        <button type="submit" class="btn btn-primary px-4 border-0" style="background-color: #10b981;">
                            <i class="fa fa-save me-2"></i> Simpan Produk
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light px-4 border text-secondary fw-semibold">
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
                <h6 class="fw-bold mb-3"><i class="fa fa-lightbulb me-2"></i>Tips Menambah Produk</h6>
                <ul class="small mb-0 ps-3">
                    <li class="mb-2">Gunakan nama yang jelas dan spesifik beserta dosisnya.</li>
                    <li class="mb-2">Pastikan harga jual lebih tinggi dari harga beli untuk margin keuntungan.</li>
                    <li class="mb-2">Cek kembali tanggal kadaluarsa agar tidak salah input.</li>
                    <li>Pilih kategori yang sesuai agar laporan inventaris lebih akurat.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
