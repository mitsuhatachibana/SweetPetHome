<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        if ($carts->isEmpty()) return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');

        $total = $carts->sum(fn($c) => $c->product->price * $c->quantity);

        // ✅ Tambah Cash / Tunai di awal (biar jadi default pertama)
        $paymentMethods = [
            'Cash / Tunai',
            'GoPay',
            'OVO',
            'DANA',
            'ShopeePay',
            'PayLater',
            'Transfer Bank',
            'BCA',
            'Mandiri',
            'BSI',
            'BRI',
            'BNI',
            'BTN',
            'SeaBank',
            'HSBC',
        ];

        return view('user.checkout', compact('carts', 'total', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
            'address'        => 'required',
            'phone'          => 'required',
        ]);

        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        if ($carts->isEmpty()) return back()->with('error', 'Keranjang kosong.');

        $orderId = DB::transaction(function () use ($carts, $request) {
            $total = $carts->sum(fn($c) => $c->product->price * $c->quantity);

            $order = Order::create([
                'order_code'     => 'SPH-' . strtoupper(uniqid()),
                'user_id'        => Auth::id(),
                'total'          => $total,
                'payment_method' => $request->payment_method,
                'status'         => 'pending',
                'address'        => $request->address,
                'phone'          => $request->phone,
            ]);

            foreach ($carts as $c) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $c->product_id,
                    'quantity'   => $c->quantity,
                    'price'      => $c->product->price,
                ]);
                $c->product->increment('sold', $c->quantity);
                $c->product->decrement('stock', $c->quantity);
            }
            Cart::where('user_id', Auth::id())->delete();

            return $order->id;
        });

        return redirect()->route('receipt', $orderId);
    }

    public function receipt(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $order->load('items.product', 'user');
        return view('user.receipt', compact('order'));
    }
}
