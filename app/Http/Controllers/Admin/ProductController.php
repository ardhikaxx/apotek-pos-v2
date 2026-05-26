<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function expired()
    {
        $products = Product::with('category')
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '<', today())
            ->get();
        return view('admin.products.expired', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
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

        Product::create($request->only(['category_id','name','unit','purchase_price','selling_price','stock', 'expiry_date']) + ['is_active' => true]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
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

        $product->update($request->only(['category_id','name','unit','purchase_price','selling_price','stock', 'expiry_date']) + ['is_active' => $request->boolean('is_active')]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function addStock(Request $request, Product $product)
    {
        $request->validate(['qty' => 'required|integer|min:1']);
        $product->increment('stock', $request->qty);
        return back()->with('success', 'Stok berhasil ditambahkan.');
    }
}
