@extends('layouts.app')
@section('title', 'Laporan Hari Ini')
@section('page-title', 'Laporan Penjualan Hari Ini')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="alert alert-info py-2 mb-0">
        <i class="fa fa-chart-bar me-2"></i>Total Hari Ini: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
    </div>
    <a href="{{ route('apoteker.reports.pdf') }}" class="btn btn-outline-secondary" target="_blank">
        <i class="fa fa-file-pdf me-1"></i>Export PDF
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Invoice</th><th>Total</th><th>Bayar</th><th>Kembali</th><th>Waktu</th></tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tx->invoice_number }}</td>
                    <td>Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($tx->paid_amount, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($tx->change_amount, 0, ',', '.') }}</td>
                    <td>{{ $tx->transaction_date->format('H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-3">Belum ada transaksi hari ini</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
    <div class="card-footer bg-white">{{ $transactions->links() }}</div>
    @endif
</div>
@endsection
