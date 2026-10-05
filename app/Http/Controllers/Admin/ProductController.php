<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }
    public function create()
    {
        return view('admin.products.create', ['categories' => Category::all()]);
    }
    public function store(Request $r)
    {
        $data = $r->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'brand' => 'nullable',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'is_best_seller' => 'nullable|boolean',
        ]);
        if ($r->hasFile('image')) {
            $data['image'] = $r->file('image')->store('products', 'public');
        }
        $data['is_best_seller'] = $r->boolean('is_best_seller');
        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Produk ditambahkan.');
    }
    public function edit(Product $product)
    {
        return view('admin.products.edit', ['product' => $product, 'categories' => Category::all()]);
    }
    public function update(Request $r, Product $product)
    {
        $data = $r->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'brand' => 'nullable',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($r->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $r->file('image')->store('products', 'public');
        }
        $data['is_best_seller'] = $r->boolean('is_best_seller');
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Produk diperbarui.');
    }
    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();
        return back()->with('success', 'Produk dihapus.');
    }
}
