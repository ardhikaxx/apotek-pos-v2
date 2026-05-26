@extends('layouts.app')
@section('title', 'Laporan Hari Ini')
@section('page-title', 'Laporan Penjualan Hari Ini')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-emerald h-100" style="background-color: #10b981;">
            <div class="card-body p-4 text-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="small opacity-75 fw-bold text-uppercase">Total Pendapatan Hari Ini</div>
                    <i class="fa fa-wallet opacity-50"></i>
                </div>
                <div class="fs-2 fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</div>
                <div class="small mt-2 opacity-75">
                    <i class="fa fa-info-circle me-1"></i> Data diperbarui secara otomatis per transaksi
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 d-flex align-items-end justify-content-md-end">
        <a href="{{ route('apoteker.reports.pdf') }}" class="btn btn-light border px-4 py-2 fw-bold text-secondary shadow-sm" target="_blank" style="border-radius: 12px;">
            <i class="fa fa-file-pdf me-2 text-danger"></i> EXPORT LAPORAN (PDF)
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                <i class="fa fa-list-ul text-primary"></i>
            </div>
            <h5 class="mb-0 fw-bold">Rincian Transaksi Anda</h5>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Invoice</th>
                        <th>Total Belanja</th>
                        <th>Pembayaran</th>
                        <th>Kembalian</th>
                        <th>Waktu</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $tx)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                        <td class="fw-bold text-dark">{{ $tx->invoice_number }}</td>
                        <td><span class="fw-bold text-emerald" style="color: #059669;">Rp {{ number_format($tx->total, 0, ',', '.') }}</span></td>
                        <td class="text-muted small">Rp {{ number_format($tx->paid_amount, 0, ',', '.') }}</td>
                        <td class="text-muted small">Rp {{ number_format($tx->change_amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-light text-dark border fw-medium">
                                <i class="fa fa-clock me-1 text-muted"></i> {{ $tx->transaction_date->format('H:i') }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('apoteker.pos.show', $tx) }}" class="btn btn-sm btn-light border-0">
                                <i class="fa fa-eye text-muted"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fa fa-file-invoice fa-3x mb-3 opacity-25"></i>
                            <p class="text-muted mb-0">Belum ada transaksi yang tercatat untuk hari ini</p>
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
