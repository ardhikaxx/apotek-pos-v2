@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('content')
<div class="card border-0 shadow-sm" style="max-width:640px">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold"><i class="fa fa-receipt me-2 text-info"></i>{{ $transaction->invoice_number }}</span>
        <a href="{{ route('admin.transactions.pdf', $transaction) }}" class="btn btn-sm btn-outline-secondary" target="_blank">
            <i class="fa fa-print me-1"></i>Cetak PDF
        </a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-6"><small class="text-muted">Kasir</small><div>{{ $transaction->user->name }}</div></div>
            <div class="col-6"><small class="text-muted">Pelanggan</small><div>{{ $transaction->customer->name ?? 'Umum' }}</div></div>
            <div class="col-6 mt-2"><small class="text-muted">Tanggal</small><div>{{ $transaction->transaction_date->format('d/m/Y H:i') }}</div></div>
        </div>
        <table class="table table-sm table-striped">
            <thead class="table-light">
                <tr><th>Produk</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr>
            </thead>
            <tbody>
                @foreach($transaction->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->qty }} {{ $item->product->unit }}</td>
                    <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="fw-bold"><td colspan="3">Total</td><td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td></tr>
                <tr><td colspan="3">Bayar</td><td>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</td></tr>
                <tr class="text-success"><td colspan="3">Kembali</td><td>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</td></tr>
            </tfoot>
        </table>
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>
@endsection
