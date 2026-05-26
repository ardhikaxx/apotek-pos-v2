<?php

namespace App\Http\Controllers\Apoteker;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(10);
        return view('apoteker.products.index', compact('products'));
    }

    public function expired()
    {
        // Cari obat yang kadaluarsa (sudah lewat hari ini)
        $products = Product::with('category')
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '<', today())
            ->get();
        return view('apoteker.products.expired', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('apoteker.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'required|string|max:150',
            'unit'           => 'required|string|max:30',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'expiry_date'    => 'nullable|date',
        ]);

        Product::create($request->all());

        return redirect()->route('apoteker.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        return view('apoteker.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('apoteker.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name'           => 'required|string|max:150',
            'unit'           => 'required|string|max:30',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'expiry_date'    => 'nullable|date',
        ]);

        $product->update($request->all());

        return redirect()->route('apoteker.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('apoteker.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function addStock(Request $request, Product $product)
    {
        $request->validate(['qty' => 'required|integer|min:1']);
        $product->increment('stock', $request->qty);
        return back()->with('success', 'Stok berhasil ditambahkan.');
    }
}
