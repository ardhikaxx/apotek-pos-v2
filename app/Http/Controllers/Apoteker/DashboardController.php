<?php

namespace App\Http\Controllers\Apoteker;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $todayTx    = Transaction::where('user_id', auth()->id())->whereDate('transaction_date', today())->count();
        $todayTotal = Transaction::where('user_id', auth()->id())->whereDate('transaction_date', today())->sum('total');
        $lowStock   = Product::where('stock', 0)->count();
        $recentTx   = Transaction::where('user_id', auth()->id())->latest()->take(5)->get();

        return view('apoteker.dashboard.index', compact('todayTx', 'todayTotal', 'lowStock', 'recentTx'));
    }
}
