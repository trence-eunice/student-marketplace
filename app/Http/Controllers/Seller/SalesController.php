<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Notification;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $orderIds = OrderItem::whereHas('product', fn($q) => $q->where('user_id', auth()->id()))
            ->pluck('order_id')
            ->unique();

        $orders = Order::whereIn('id', $orderIds)
            ->with(['orderItems.product', 'user'])
            ->latest()
            ->paginate(10);

        return view('seller.sales.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $hasSellerProduct = $order->orderItems()
            ->whereHas('product', fn($q) => $q->where('user_id', auth()->id()))
            ->exists();

        if (!$hasSellerProduct) abort(403);

        $order->update(['status' => $request->status]);

        // Notify buyer
        Notification::create([
            'user_id' => $order->user_id,
            'title'   => 'Order Status Updated',
            'message' => 'Your order ' . $order->order_number . ' is now ' . ucfirst($request->status) . '.',
            'link'    => '/buyer/orders',
        ]);

        return redirect()->route('seller.sales.index')
            ->with('success', 'Order #' . $order->order_number . ' updated to ' . ucfirst($request->status) . '.');
    }
}
