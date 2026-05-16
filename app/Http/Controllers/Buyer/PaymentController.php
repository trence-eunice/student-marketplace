<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function show()
    {
        $cartItems = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('buyer.cart.index')
                ->with('error', 'Your cart is empty!');
        }

        $shippingAddress = session('shipping_address');

        if (!$shippingAddress) {
            return redirect()->route('buyer.checkout.show')
                ->with('error', 'Please enter a shipping address first.');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('buyer.payment', compact('cartItems', 'total', 'shippingAddress'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:gcash,cod',
            'gcash_reference' => $request->payment_method === 'gcash' ? 'required|string|min:5' : 'nullable',
        ]);

        $cartItems = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('buyer.cart.index')
                ->with('error', 'Your cart is empty!');
        }

        $shippingAddress = session('shipping_address');
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $status = $request->payment_method === 'cod' ? 'pending' : 'processing';

        $order = Order::create([
            'user_id'          => auth()->id(),
            'order_number'     => 'ORD-' . strtoupper(Str::random(8)),
            'total_amount'     => $total,
            'status'           => $status,
            'shipping_address' => $shippingAddress,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);

            $item->product->decrement('stock', $item->quantity);

            // Notify seller
            Notification::create([
                'user_id' => $item->product->user_id,
                'title'   => 'New Order Received!',
                'message' => auth()->user()->name . ' ordered ' . $item->quantity . 'x ' . $item->product->title,
                'link'    => '/seller/sales',
            ]);
        }

        CartItem::where('user_id', auth()->id())->delete();
        session()->forget('shipping_address');

        // Notify buyer
        Notification::create([
            'user_id' => auth()->id(),
            'title'   => 'Order Placed!',
            'message' => 'Your order ' . $order->order_number . ' has been placed successfully.',
            'link'    => '/buyer/orders',
        ]);

        $message = $request->payment_method === 'gcash'
            ? 'GCash payment submitted! Order placed successfully.'
            : 'Order placed! Pay cash upon delivery.';

        return redirect()->route('buyer.orders.index')->with('success', $message);
    }
}
