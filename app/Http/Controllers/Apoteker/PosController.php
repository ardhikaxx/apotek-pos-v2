<?php

namespace App\Http\Controllers\Apoteker;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PosController extends Controller
{
    public function index()
    {
        $customers = User::whereHas('role', fn($q) => $q->where('name', 'pelanggan'))->get();
        return view('apoteker.pos.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:users,id',
            'items'       => 'required|array|min:1',
            'items.*.id'  => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['id']);

                if (!$product->is_active) {
                    throw new \Exception("Produk {$product->name} tidak aktif.");
                }
                if ($product->stock < $item['qty']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi.");
                }

                $subtotal = $product->selling_price * $item['qty'];
                $total += $subtotal;

                $itemsData[] = [
                    'product_id' => $product->id,
                    'qty'        => $item['qty'],
                    'unit_price' => $product->selling_price,
                    'subtotal'   => $subtotal,
                ];

                $product->decrement('stock', $item['qty']);
            }

            if ($request->paid_amount < $total) {
                throw new \Exception("Nominal bayar kurang.");
            }

            $invoice = 'INV-' . now()->format('Ymd') . '-' . str_pad(
                Transaction::whereDate('created_at', '=', today())->count() + 1, 4, '0', STR_PAD_LEFT
            );

            $transaction = Transaction::create([
                'user_id'          => auth()->id(),
                'customer_id'      => $request->customer_id,
                'invoice_number'   => $invoice,
                'total'            => $total,
                'paid_amount'      => $request->paid_amount,
                'change_amount'    => $request->paid_amount - $total,
                'transaction_date' => now(),
            ]);

            foreach ($itemsData as $item) {
                $transaction->items()->create($item);
            }

            session(['last_transaction_id' => $transaction->id]);
        });

        return response()->json(['success' => true, 'transaction_id' => session('last_transaction_id')]);
    }

    public function searchProduct(Request $request)
    {
        $products = Product::where('is_active', '=', true)
            ->where('stock', '>', 0)
            ->where('name', 'like', '%' . $request->q . '%')
            ->with('category')
            ->get(['id','name','selling_price','stock','unit']);

        return response()->json($products);
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('items.product', 'user', 'customer');
        return view('apoteker.pos.show', compact('transaction'));
    }

    public function printPdf(Transaction $transaction)
    {
        $transaction->load('items.product', 'user', 'customer');
        $pdf = Pdf::loadView('apoteker.pos.pdf', compact('transaction'))->setPaper([0, 0, 226.77, 600], 'portrait');
        return $pdf->stream('struk-' . $transaction->invoice_number . '.pdf');
    }
}
