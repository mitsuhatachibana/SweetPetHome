<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $r)
    {
        $query = Order::with('user', 'items.product');
        if ($r->filled('status')) $query->where('status', $r->status);
        $orders = $query->latest()->paginate(10)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $r, Order $order)
    {
        $r->validate(['status' => 'required|in:pending,shopped,delivered']);
        $order->update(['status' => $r->status]);
        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
