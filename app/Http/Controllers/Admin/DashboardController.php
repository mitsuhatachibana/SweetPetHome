<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue  = Order::where('status', '!=', 'pending')->sum('total');
        $totalProducts = Product::count();
        $recentUsers   = User::where('role', 'user')->latest()->take(5)->get();
        $recentOrders  = Order::with('user')->latest()->take(5)->get();
        return view('admin.dashboard', compact('totalRevenue', 'totalProducts', 'recentUsers', 'recentOrders'));
    }
}
