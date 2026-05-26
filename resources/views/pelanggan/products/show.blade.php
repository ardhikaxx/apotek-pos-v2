@extends('layouts.pelanggan')
@section('title', 'Detail Obat')
@section('page-title', 'Detail Obat')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <i class="fa fa-pills fa-5x text-info opacity-25 mb-3"></i>
                    <h4 class="fw-bold">{{ $product->name }}</h4>
                    <span class="badge bg-info">{{ $product->category->name }}</span>
                </div>
                <hr>
                <table class="table table-borderless">
                    <tr>
                        <td class="text-muted" style="width: 40%">Satuan</td>
                        <td class="fw-semibold">: {{ $product->unit }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Harga</td>
                        <td class="fw-bold text-info fs-5">: Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Ketersediaan</td>
                        <td>: 
                            @if($product->stock > 0)
                                <span class="text-success fw-bold">Tersedia ({{ $product->stock }} {{ $product->unit }})</span>
                            @else
                                <span class="text-danger fw-bold">Stok Habis</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kadaluarsa</td>
                        <td>: {{ $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('d F Y') : '-' }}</td>
                    </tr>
                </table>
                <hr>
                <div class="text-center">
                    <a href="{{ route('pelanggan.products.index') }}" class="btn btn-light px-4">Kembali ke Katalog</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
