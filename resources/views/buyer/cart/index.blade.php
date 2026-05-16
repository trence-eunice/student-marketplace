<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Cart</h2>
    </x-slot>
    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="page-title">My Cart</h1>
                <p class="page-subtitle">Review your items before checkout.</p>
            </div>

            @forelse($cartItems as $item)
            <div class="card rounded-xl p-4 mb-4 flex justify-between items-center gap-4">
                <div class="flex items-center gap-4">
                    @if($item->product->image)
                        <img src="{{ Storage::url($item->product->image) }}" class="w-16 h-16 object-cover rounded-lg">
                    @else
                        <div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-xs">No img</div>
                    @endif
                    <div>
                        <p class="font-semibold text-sm">{{ $item->product->title }}</p>
                        <p class="text-xs mt-0.5" style="color: var(--muted)">
                            ₱{{ number_format($item->product->price, 2) }} × {{ $item->quantity }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <p class="font-bold" style="color: var(--accent)">
                        ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                    </p>
                    <form action="{{ route('buyer.cart.destroy', $item) }}" method="POST" style="display:inline;">
                        @csrf
                        
                        <button type="submit" class="btn-danger px-3 py-1.5 rounded-lg text-xs font-semibold"
                            onclick="this.form.submit(); return false;">Remove</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="card p-10 text-center">
                <p class="text-lg font-semibold mb-2">Your cart is empty</p>
                <p class="text-sm mb-4" style="color: var(--muted)">Browse products and add something!</p>
                <a href="{{ route('buyer.products.index') }}" class="btn-primary px-6 py-2 rounded-lg font-semibold">Browse Products</a>
            </div>
            @endforelse

            @if($cartItems->count())
            <div class="card rounded-xl p-6 mt-4">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-sm" style="color: var(--muted)">{{ $cartItems->count() }} item(s)</p>
                    <p class="text-xl font-bold">Total: <span style="color: var(--accent)">₱{{ number_format($total, 2) }}</span></p>
                </div>
                <a href="{{ route('buyer.checkout.show') }}" class="btn-primary w-full py-2.5 rounded-lg font-semibold text-center block">
                    Proceed to Checkout →
                </a>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
