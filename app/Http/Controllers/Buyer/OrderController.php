<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
        ]);

        $cartItems = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('buyer.cart.index')
                ->with('error', 'Your cart is empty!');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        $order = Order::create([
            'user_id'          => auth()->id(),
            'order_number'     => 'ORD-' . strtoupper(Str::random(8)),
            'total_amount'     => $total,
            'status'           => 'pending',
            'shipping_address' => $request->shipping_address,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);
        }

        CartItem::where('user_id', auth()->id())->delete();

        return redirect()->route('buyer.orders.index')
            ->with('success', 'Order placed successfully!');
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
