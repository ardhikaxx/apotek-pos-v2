<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('user');

        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        $transactions = $query->latest()->paginate(15)->withQueryString();
        $total        = $query->sum('total');

        return view('admin.reports.index', compact('transactions', 'total'));
    }

    public function exportPdf(Request $request)
    {
        $query = Transaction::with('user', 'items.product');

        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        $transactions = $query->latest()->get();
        $total        = $transactions->sum('total');
        $start        = $request->start_date ?? '-';
        $end          = $request->end_date ?? '-';

        $pdf = Pdf::loadView('admin.reports.pdf', compact('transactions', 'total', 'start', 'end'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-penjualan.pdf');
    }
}
