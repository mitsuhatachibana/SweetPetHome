<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Kalau admin yang login, langsung arahkan ke dashboard admin
        if (Auth::check()) {
            $user = Auth::user();

            if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
        }

        $query = Product::with('category')->withAvg('reviews', 'rating');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        $sort = $request->get('sort');
        if ($sort === 'best_seller') $query->where('is_best_seller', true)->orderByDesc('sold');
        elseif ($sort === 'low')    $query->orderBy('price');
        elseif ($sort === 'high')   $query->orderByDesc('price');
        else                        $query->latest();

        $products    = $query->paginate(10)->withQueryString();
        $categories  = Category::all();
        $bestSellers = Product::where('is_best_seller', true)->take(4)->get();

        return view('user.home', compact('products', 'categories', 'bestSellers'));
    }

    public function about()
    {
        return view('user.about');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'reviews.user']);
        $rating  = $product->reviews()->avg('rating') ?? 0;
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('user.product-detail', compact('product', 'rating', 'related'));
    }
}
