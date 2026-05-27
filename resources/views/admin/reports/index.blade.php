@extends('layouts.app')
@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-6 d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary px-4 border-0" style="background-color: #10b981;">
                            <i class="fa fa-filter me-2"></i> Tampilkan Laporan
                        </button>
                        <a href="{{ route('admin.reports.pdf', request()->query()) }}" class="btn btn-light border px-4 fw-semibold text-secondary" target="_blank">
                            <i class="fa fa-file-pdf me-2 text-danger"></i> Export PDF
                        </a>
                        <a href="{{ route('admin.reports') }}" class="btn btn-light border px-3" title="Reset">
                            <i class="fa fa-sync-alt"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-md-4">
        <div class="card border-0 shadow-sm bg-emerald" style="background-color: #10b981;">
            <div class="card-body p-4 text-white">
                <div class="small opacity-75 mb-1">Total Pendapatan</div>
                <div class="fs-3 fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 text-dark">
                <div class="small text-muted mb-1">Total Transaksi</div>
                <div class="fs-3 fw-bold">{{ number_format($transactions->total()) }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Data Transaksi</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Invoice</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Tanggal & Waktu</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $tx)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}</td>
                        <td class="fw-bold text-dark">{{ $tx->invoice_number }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.7rem;">
                                    <i class="fa fa-user text-muted"></i>
                                </div>
                                <span class="small">{{ $tx->user->name }}</span>
                            </div>
                        </td>
                        <td><span class="fw-bold text-emerald" style="color: #059669;">Rp {{ number_format($tx->total, 0, ',', '.') }}</span></td>
                        <td class="text-muted small">{{ $tx->transaction_date->format('d/m/Y H:i') }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.transactions.show', $tx) }}" class="btn btn-sm btn-light border-0">
                                <i class="fa fa-eye text-muted"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fa fa-file-invoice-dollar fa-3x mb-3 opacity-25"></i>
                            <p class="text-muted mb-0">Tidak ada data transaksi ditemukan untuk periode ini</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($transactions->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
