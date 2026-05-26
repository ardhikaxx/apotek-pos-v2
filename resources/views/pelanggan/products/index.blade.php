@extends('layouts.pelanggan')
@section('title', 'Katalog Obat')

@push('styles')
<style>
    .search-container {
        max-width: 700px;
        margin: -30px auto 40px;
        position: relative;
        z-index: 10;
    }
    .search-input-group {
        background: #fff;
        border-radius: 16px;
        padding: 8px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        display: flex;
        gap: 8px;
    }
    .search-input-group input {
        border: none;
        padding: 12px 20px;
        flex-grow: 1;
        outline: none;
        font-size: 1rem;
        border-radius: 12px;
    }
    .search-input-group button {
        background-color: #10b981;
        color: white;
        border: none;
        padding: 12px 28px;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.2s;
    }
    .search-input-group button:hover {
        background-color: #059669;
        transform: translateY(-1px);
    }
    
    .product-card {
        border: none;
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #fff;
        overflow: hidden;
    }
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .product-img-placeholder {
        height: 180px;
        background-color: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #10b981;
        position: relative;
    }
    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
    .badge-stock { background-color: #ecfdf5; color: #059669; }
    .badge-out { background-color: #fef2f2; color: #dc2626; }
    
    .price-text {
        color: #10b981;
        font-weight: 800;
        font-size: 1.25rem;
    }
    .btn-detail {
        background-color: #f1f5f9;
        color: #475569;
        border: none;
        font-weight: 700;
        border-radius: 12px;
        padding: 10px;
        transition: all 0.2s;
    }
    .btn-detail:hover {
        background-color: #10b981;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="search-container">
    <form action="{{ route('pelanggan.products.index') }}" method="GET">
        <div class="search-input-group">
            <input type="text" name="search" placeholder="Cari obat, vitamin, atau alat kesehatan..." value="{{ request('search') }}">
            <button type="submit" class="d-none d-md-block">Cari Sekarang</button>
            <button type="submit" class="d-md-none"><i class="fa fa-search"></i></button>
        </div>
    </form>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Semua Produk</h4>
    <div class="text-muted small">Menampilkan {{ $products->count() }} produk</div>
</div>

<div class="row g-4 mb-5">
    @foreach($products as $product)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="product-card shadow-sm h-100 d-flex flex-column">
            <div class="product-img-placeholder">
                <i class="fa fa-pills fa-4x opacity-25"></i>
                <span class="product-badge {{ $product->stock > 0 ? 'badge-stock' : 'badge-out' }}">
                    {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
                </span>
            </div>
            <div class="card-body p-4 d-flex flex-column">
                <div class="mb-1 text-muted small text-uppercase fw-bold" style="letter-spacing: 0.05em;">{{ $product->category->name }}</div>
                <h5 class="fw-bold text-dark mb-3 text-truncate-2" style="height: 3rem; line-height: 1.5; overflow: hidden;">{{ $product->name }}</h5>
                
                <div class="mt-auto">
                    <div class="price-text mb-3">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</div>
                    <a href="{{ route('pelanggan.products.show', $product) }}" class="btn btn-detail w-100 text-center text-decoration-none">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($products->hasPages())
<div class="d-flex justify-content-center mb-5">
    {{ $products->links() }}
</div>
@endif
@endsection
