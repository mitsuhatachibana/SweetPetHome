<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        return view('user.cart', compact('carts'));
    }

    public function add(Product $product)
    {
        $qty = request('quantity', 1);
        if ($product->stock < $qty) return back()->with('error', 'Stok tidak cukup!');

        $cart = Cart::where('user_id', Auth::id())->where('product_id', $product->id)->first();
        if ($cart) {
            $cart->increment('quantity', $qty);
        } else {
            Cart::create(['user_id' => Auth::id(), 'product_id' => $product->id, 'quantity' => $qty]);
        }
        return back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        abort_unless($cart->user_id === Auth::id(), 403);

        $data = $request->validate(['quantity' => 'required|integer|min:1']);
        $cart->update(['quantity' => $data['quantity']]);
        return back();
    }

    public function remove(Cart $cart)
    {
        abort_unless($cart->user_id === Auth::id(), 403);

        $cart->delete();
        return back()->with('success', 'Item dihapus.');
    }
}
