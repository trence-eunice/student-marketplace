<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Checkout</h2>
    </x-slot>
    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <h1 class="page-title">Checkout</h1>
                <p class="page-subtitle">Almost there — enter your shipping details.</p>
            </div>

            {{-- Progress Steps --}}
            <div class="flex items-center gap-2 mb-8 text-sm font-semibold">
                <span class="px-3 py-1 rounded-full" style="background: var(--accent); color: var(--bg)">1. Shipping</span>
                <span style="color: var(--muted)">→</span>
                <span class="px-3 py-1 rounded-full" style="background: var(--border); color: var(--muted)">2. Payment</span>
                <span style="color: var(--muted)">→</span>
                <span class="px-3 py-1 rounded-full" style="background: var(--border); color: var(--muted)">3. Done</span>
            </div>

            

            {{-- Order Summary --}}
            <div class="card rounded-xl p-6 mb-6">
                <h3 class="font-bold text-base mb-4">Order Summary</h3>
                <table class="w-full text-sm mb-4">
                    <thead>
                        <tr style="background: var(--border)">
                            <th class="text-left px-3 py-2 rounded-l">Product</th>
                            <th class="text-left px-3 py-2">Qty</th>
                            <th class="text-left px-3 py-2 rounded-r">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                        <tr class="border-b" style="border-color: var(--border)">
                            <td class="px-3 py-2">{{ $item->product->title }}</td>
                            <td class="px-3 py-2">{{ $item->quantity }}</td>
                            <td class="px-3 py-2">₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="text-right font-bold text-base">
                    Total: <span style="color: var(--accent)">₱{{ number_format($total, 2) }}</span>
                </p>
            </div>

            {{-- Shipping Form --}}
            <div class="card rounded-xl p-6">
                <h3 class="font-bold text-base mb-4">Shipping Address</h3>
                <form method="POST" action="{{ route('buyer.checkout.store') }}">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-sm font-medium mb-1">Full Shipping Address</label>
                        <textarea name="shipping_address" rows="3" required
                            class="input-dark w-full rounded-lg px-3 py-2"
                            placeholder="House No., Street, Barangay, City, Province">{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn-primary w-full py-2.5 rounded-lg font-semibold">
                        Proceed to Payment →
                    </button>
                    <a href="{{ route('buyer.cart.index') }}"
                        class="block text-center text-sm mt-3 hover:underline" style="color: var(--muted)">
                        ← Back to Cart
                    </a>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
