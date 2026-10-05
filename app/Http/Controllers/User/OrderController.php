<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', User::current()->id)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('user.orders', compact('orders'));
    }
}
