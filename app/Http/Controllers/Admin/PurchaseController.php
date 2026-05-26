<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'user'])->latest()->get();
        return view('admin.purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::where('is_active', true)->get();
        return view('admin.purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'   => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'items'         => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'items.*.purchase_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;
            foreach ($request->items as $item) {
                $total += $item['quantity'] * $item['purchase_price'];
            }

            $purchase = Purchase::create([
                'supplier_id'   => $request->supplier_id,
                'user_id'       => auth()->id(),
                'purchase_date' => $request->purchase_date,
                'total'         => $total,
            ]);

            foreach ($request->items as $item) {
                PurchaseItem::create([
                    'purchase_id'    => $purchase->id,
                    'product_id'     => $item['product_id'],
                    'quantity'       => $item['quantity'],
                    'purchase_price' => $item['purchase_price'],
                    'subtotal'       => $item['quantity'] * $item['purchase_price'],
                ]);

                // Update product stock and purchase price
                $product = Product::find($item['product_id']);
                $product->increment('stock', $item['quantity']);
                $product->update(['purchase_price' => $item['purchase_price']]);
            }
        });

        return redirect()->route('admin.purchases.index')->with('success', 'Pembelian berhasil dicatat dan stok telah diperbarui.');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'user', 'items.product']);
        return view('admin.purchases.show', compact('purchase'));
    }
}
