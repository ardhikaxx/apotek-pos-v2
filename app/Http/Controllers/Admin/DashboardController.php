<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts   = Product::count();
        $totalUsers      = User::count();
        $todayTotal      = Transaction::whereDate('transaction_date', today())->sum('total');
        $monthTotal      = Transaction::whereMonth('transaction_date', now()->month)
                            ->whereYear('transaction_date', now()->year)->sum('total');
        $lowStock        = Product::where('stock', 0)->count();
        $recentTx        = Transaction::with('user')->latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'totalProducts', 'totalUsers', 'todayTotal', 'monthTotal', 'lowStock', 'recentTx'
        ));
    }
}
