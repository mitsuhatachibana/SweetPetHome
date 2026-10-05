<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'rating'  => 'required|numeric|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Bulatkan ke 1 desimal biar konsisten (4.73 → 4.7)
        $rating = round((float) $data['rating'], 1);

        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product->id],
            ['rating' => $rating, 'comment' => $data['comment'] ?? null]
        );

        return back()->with('success', 'Review berhasil ditambahkan!');
    }
}
