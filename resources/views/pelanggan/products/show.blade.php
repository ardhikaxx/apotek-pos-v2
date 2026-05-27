@extends('layouts.pelanggan')
@section('title', 'Detail Obat')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
            <div class="row g-0">
                <div class="col-md-5 bg-light d-flex align-items-center justify-content-center p-3 p-md-5">
                    <div class="text-center">
                        <div class="bg-white rounded-circle shadow-sm d-inline-flex align-items-center justify-content-center mb-4" style="width: 150px; height: 150px;">
                            <i class="fa fa-pills fa-5x" style="color: #10b981;"></i>
                        </div>
                        <h5 class="text-muted fw-bold small text-uppercase" style="letter-spacing: 0.1em;">{{ $product->category->name }}</h5>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card-body p-3 p-md-5">
                        <nav aria-label="breadcrumb" class="mb-4">
                            <ol class="breadcrumb flex-wrap">
                                <li class="breadcrumb-item"><a href="{{ route('pelanggan.products.index') }}" class="text-decoration-none text-emerald" style="color: #10b981;">Katalog</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                            </ol>
                        </nav>
                        
                        <h1 class="fw-bold text-dark mb-3">{{ $product->name }}</h1>
                        
                        <div class="d-flex align-items-center flex-wrap gap-3 mb-4">
                            <div class="fs-2 fw-bold text-emerald" style="color: #10b981;">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</div>
                            <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 {{ $product->stock > 0 ? 'text-success' : 'text-danger' }} px-3 py-2 rounded-pill fw-bold">
                                {{ $product->stock > 0 ? 'Stok Tersedia' : 'Stok Habis' }}
                            </span>
                        </div>
                        
                        <hr class="my-4 opacity-25">
                        
                        <div class="row g-3 g-md-4 mb-4">
                            <div class="col-6">
                                <label class="small text-muted fw-bold text-uppercase d-block mb-1">Satuan Produk</label>
                                <div class="fw-bold text-dark">{{ $product->unit }}</div>
                            </div>
                            <div class="col-6">
                                <label class="small text-muted fw-bold text-uppercase d-block mb-1">Masa Berlaku</label>
                                <div class="fw-bold text-dark">{{ $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('d F Y') : '-' }}</div>
                            </div>
                            <div class="col-6">
                                <label class="small text-muted fw-bold text-uppercase d-block mb-1">Jumlah Stok</label>
                                <div class="fw-bold text-dark">{{ $product->stock }} {{ $product->unit }}</div>
                            </div>
                            <div class="col-6">
                                <label class="small text-muted fw-bold text-uppercase d-block mb-1">ID Produk</label>
                                <div class="fw-bold text-dark">#PRD-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                        
                        <div class="alert bg-soft-emerald border-0 rounded-4 p-4 mb-5" style="background-color: #ecfdf5;">
                            <div class="d-flex gap-3">
                                <i class="fa fa-info-circle text-emerald fs-4" style="color: #10b981;"></i>
                                <div class="text-dark small">
                                    <strong>Informasi Pembelian:</strong> Silakan kunjungi apotek kami untuk melakukan pembelian atau hubungi kontak kami untuk pemesanan lebih lanjut.
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex">
                            <a href="{{ route('pelanggan.products.index') }}" class="btn btn-light px-4 py-3 fw-bold text-secondary border shadow-sm" style="border-radius: 14px;">
                                <i class="fa fa-arrow-left me-2"></i> Kembali ke Katalog
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-5">
            <h5 class="fw-bold mb-4">Produk Lainnya</h5>
            <div class="row g-3 g-md-4">
                @forelse($relatedProducts as $related)
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; overflow: hidden;">
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 120px;">
                            <i class="fa fa-pills fa-2x text-emerald opacity-25" style="color: #10b981;"></i>
                        </div>
                        <div class="card-body p-3 d-flex flex-column">
                            <small class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.65rem;">{{ $related->category->name }}</small>
                            <h6 class="fw-bold text-dark mb-2 text-truncate" title="{{ $related->name }}">{{ $related->name }}</h6>
                            <div class="mt-auto">
                                <div class="fw-bold text-emerald small mb-2" style="color: #10b981;">Rp {{ number_format($related->selling_price, 0, ',', '.') }}</div>
                                <a href="{{ route('pelanggan.products.show', $related) }}" class="btn btn-sm btn-light w-100 fw-bold text-secondary" style="border-radius: 8px; font-size: 0.75rem;">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-muted small">Tidak ada produk terkait lainnya.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
