@extends('layouts.pelanggan')
@section('title', 'Katalog Obat')
@section('page-title', 'Katalog Obat')

@section('content')
<div class="row mb-4">
    <div class="col-md-6 offset-md-3">
        <form action="{{ route('pelanggan.products.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Cari obat yang Anda butuhkan..." value="{{ request('search') }}">
            <button class="btn btn-info text-white px-4 d-flex align-items-center gap-2">
                <i class="fa fa-search"></i>
                <span>Cari</span>
            </button>
        </form>
    </div>
</div>

<div class="row mb-4">
    @foreach($products as $product)
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center d-flex flex-column">
                <div class="mb-3">
                    <i class="fa fa-pills fa-4x text-info opacity-50"></i>
                </div>
                <h6 class="fw-bold mb-1">{{ $product->name }}</h6>
                <small class="text-muted mb-2 d-block">{{ $product->category->name }}</small>
                <div class="mt-auto">
                    <p class="text-info fw-bold fs-5 mb-2">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                    <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} mb-3">
                        {{ $product->stock > 0 ? 'Stok Tersedia' : 'Stok Habis' }}
                    </span>
                    <a href="{{ route('pelanggan.products.show', $product) }}" class="btn btn-outline-info btn-sm w-100 fw-semibold">
                        Detail Obat
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($products->hasPages())
<div class="d-flex justify-content-center">
    {{ $products->links() }}
</div>
@endif
@endsection
