@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                        <i class="fa fa-receipt text-primary"></i>
                    </div>
                    <h5 class="mb-0 fw-bold">{{ $transaction->invoice_number }}</h5>
                </div>
                <a href="{{ route('apoteker.pos.pdf', $transaction) }}" class="btn btn-light border px-3 fw-bold text-secondary" target="_blank" style="border-radius: 10px;">
                    <i class="fa fa-print me-2 text-primary"></i> CETAK STRUK
                </a>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="text-uppercase small text-muted">
                                <th class="border-0">Item Obat</th>
                                <th class="border-0">Qty</th>
                                <th class="border-0">Harga Satuan</th>
                                <th class="border-0 text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->items as $item)
                            <tr>
                                <td class="py-3">
                                    <div class="fw-bold text-dark">{{ $item->product->name }}</div>
                                    <small class="text-muted">{{ $item->product->category->name }}</small>
                                </td>
                                <td><span class="badge bg-light text-dark fw-medium border">{{ $item->qty }} {{ $item->product->unit }}</span></td>
                                <td class="text-muted small">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td class="text-end fw-bold text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light bg-opacity-50 p-4 border-0">
                <div class="row justify-content-end">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Belanja</span>
                            <span class="fw-bold text-dark fs-5">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Nominal Bayar</span>
                            <span class="text-dark">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between pt-2 border-top">
                            <span class="text-muted fw-bold">Kembalian</span>
                            <span class="fw-bold text-emerald fs-5" style="color: #10b981;">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('apoteker.pos') }}" class="btn btn-light border px-4 py-2 fw-semibold text-secondary" style="border-radius: 12px;">
            <i class="fa fa-arrow-left me-2"></i> Kembali ke Kasir
        </a>
    </div>
    
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark">Informasi Tambahan</h6>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-1">Kasir</label>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-soft-emerald d-flex align-items-center justify-content-center fw-bold text-emerald" style="width: 40px; height: 40px; background-color: #ecfdf5; color: #10b981;">
                            {{ substr($transaction->user->name, 0, 1) }}
                        </div>
                        <div class="fw-bold text-dark">{{ $transaction->user->name }}</div>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-1">Pelanggan</label>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa fa-user-circle text-muted fs-4"></i>
                        <span class="fw-medium">{{ $transaction->customer->name ?? 'Umum (Walk-in Customer)' }}</span>
                    </div>
                </div>
                <div>
                    <label class="form-label small fw-bold text-muted text-uppercase mb-1">Waktu Transaksi</label>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa fa-calendar-alt text-muted"></i>
                        <span class="text-dark small">{{ $transaction->transaction_date->format('d F Y, H:i') }} WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
