<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get()
            ->filter(fn($item) => $item->product !== null);

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('buyer.cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->status !== 'active') {
            return redirect()->back()->with('error', 'This product is no longer available.');
        }

        if ($product->user->is_suspended) {
            return redirect()->back()->with('error', 'This product is no longer available.');
        }

        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Sorry, this product is out of stock.');
        }

        $existingQty = CartItem::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->value('quantity') ?? 0;

        $newQty = $existingQty + $request->quantity;

        if ($newQty > $product->stock) {
            return redirect()->back()->with('error', 'Not enough stock. Only ' . ($product->stock - $existingQty) . ' more available.');
        }

        $cartItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            CartItem::create([
                'user_id'    => auth()->id(),
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]);
        }

        return redirect()->route('buyer.cart.index')->with('success', 'Item added to cart!');
    }

    public function destroy(Request $request, $id)
    {
        $cartItem = CartItem::find($id);

        if (!$cartItem) {
            return redirect()->route('buyer.cart.index')->with('error', 'Item not found.');
        }

        $cartItem->delete();
        return redirect()->route('buyer.cart.index')->with('success', 'Item removed from cart!');
    }
}
