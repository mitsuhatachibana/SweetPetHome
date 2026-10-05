<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', ['categories' => Category::latest()->paginate(10)]);
    }
    public function create()
    {
        return view('admin.categories.create');
    }
    public function store(Request $r)
    {
        $r->validate(['name' => 'required', 'type' => 'nullable']);
        Category::create([...$r->only('name', 'type'), 'slug' => Str::slug($r->name)]);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori ditambahkan.');
    }
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }
    public function update(Request $r, Category $category)
    {
        $r->validate(['name' => 'required', 'type' => 'nullable']);
        $category->update([...$r->only('name', 'type'), 'slug' => Str::slug($r->name)]);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori diperbarui.');
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori dihapus.');
    }
}
