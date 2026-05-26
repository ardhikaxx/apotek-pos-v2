<?php

namespace App\Http\Controllers\Apoteker;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')
            ->whereDate('transaction_date', today())
            ->latest()
            ->paginate(15);

        $total = Transaction::whereDate('transaction_date', today())->sum('total');

        return view('apoteker.reports.index', compact('transactions', 'total'));
    }

    public function exportPdf()
    {
        $transactions = Transaction::with('user', 'items.product')
            ->whereDate('transaction_date', today())
            ->latest()
            ->get();

        $total = $transactions->sum('total');
        $date  = today()->format('d/m/Y');

        $pdf = Pdf::loadView('apoteker.reports.pdf', compact('transactions', 'total', 'date'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-hari-ini.pdf');
    }
}
