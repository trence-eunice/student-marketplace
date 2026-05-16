<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('status', 'active')
            ->whereHas('user', fn($q) => $q->where('is_suspended', false))
            ->where('stock', '>', 0)
            ->with('category');

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->condition) {
            $query->where('condition', $request->condition);
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('buyer.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        // Block access to inactive or suspended seller's products
        if ($product->status !== 'active' || $product->user->is_suspended) {
            return redirect()->route('buyer.products.index')
                ->with('error', 'This product is no longer available.');
        }

        return view('buyer.products.show', compact('product'));
    }
}
