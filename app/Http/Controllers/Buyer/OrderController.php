<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('orderItems.product')
            ->latest()
            ->get();

        return view('buyer.orders.index', compact('orders'));
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->route('buyer.orders.index')
                ->with('error', 'Only pending orders can be cancelled.');
        }

        // Restore stock for each item
        foreach ($order->orderItems as $item) {
            $item->product->increment('stock', $item->quantity);
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('buyer.orders.index')
            ->with('success', 'Order cancelled successfully.');
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);

        if ($order->status !== 'pending') {
            return redirect()->route('buyer.orders.index')
                ->with('error', 'Only pending orders can be cancelled.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('buyer.orders.index')
            ->with('success', 'Order cancelled successfully!');
    }
}
