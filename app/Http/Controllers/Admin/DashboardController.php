<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $recentOrders = Order::with(['user', 'orderItems'])->latest()->take(5)->get();
        $recentProducts = Product::with(['user', 'category'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalProducts', 'totalOrders', 'recentOrders', 'recentProducts'
        ));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function orders()
    {
        $orders = Order::with(['user', 'orderItems.product'])->latest()->paginate(10);
        return view('admin.orders', compact('orders'));
    }
}
