@extends('layouts.app')
@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')

@section('content')
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-info text-white"><i class="fa fa-filter me-1"></i>Filter</button>
                <a href="{{ route('admin.reports.pdf', request()->query()) }}" class="btn btn-outline-secondary" target="_blank">
                    <i class="fa fa-file-pdf me-1"></i>PDF
                </a>
            </div>
        </form>
    </div>
</div>

<div class="alert alert-info py-2">
    <i class="fa fa-chart-bar me-2"></i>Total Penjualan: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Invoice</th><th>Kasir</th><th>Total</th><th>Tanggal</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tx->invoice_number }}</td>
                    <td>{{ $tx->user->name }}</td>
                    <td>Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                    <td>{{ $tx->transaction_date->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.transactions.show', $tx) }}" class="btn btn-sm btn-outline-info"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-3">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
    <div class="card-footer bg-white">{{ $transactions->links() }}</div>
    @endif
</div>
@endsection
