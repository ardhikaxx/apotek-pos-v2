@extends('layouts.app')
@section('title', 'Daftar Transaksi')
@section('page-title', 'Daftar Transaksi')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold"><i class="fa fa-list me-2 text-info"></i>Riwayat Transaksi</span>
        <a href="{{ route('admin.transactions.create') }}" class="btn btn-info btn-sm text-white">
            <i class="fa fa-plus me-1"></i> Transaksi Baru
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Invoice</th><th>Kasir</th><th>Pelanggan</th><th>Total</th><th>Bayar</th><th>Kembali</th><th>Tanggal</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tx->invoice_number }}</td>
                    <td>{{ $tx->user->name }}</td>
                    <td>{{ $tx->customer->name ?? 'Umum' }}</td>
                    <td>Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($tx->paid_amount, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($tx->change_amount, 0, ',', '.') }}</td>
                    <td>{{ $tx->transaction_date->format('d/m/Y H:i') }}</td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('admin.transactions.show', $tx) }}" class="btn btn-sm btn-outline-info"><i class="fa fa-eye"></i></a>
                        <a href="{{ route('admin.transactions.pdf', $tx) }}" class="btn btn-sm btn-outline-secondary" target="_blank"><i class="fa fa-print"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-3">Belum ada transaksi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
    <div class="card-footer bg-white">{{ $transactions->links() }}</div>
    @endif
</div>
@endsection
