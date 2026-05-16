<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
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

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('buyer.checkout', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
        ]);

        session(['shipping_address' => $request->shipping_address]);

        return redirect()->route('buyer.payment.show');
    }
}
