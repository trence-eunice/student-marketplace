<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers    = User::count();
        $totalProducts = Product::count();
        $totalOrders   = Order::count();
        $recentOrders  = Order::with(['user', 'orderItems'])->latest()->take(5)->get();
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


    public function toggleUserStatus(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.users')
                ->with('error', 'Cannot suspend an admin account.');
        }

        $user->update(['is_suspended' => !$user->is_suspended]);

        $action = $user->is_suspended ? 'suspended' : 'reactivated';

        return redirect()->route('admin.users')
            ->with('success', $user->name . ' has been ' . $action . '.');
    }
}
