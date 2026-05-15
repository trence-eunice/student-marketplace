<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Cart</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif
            @forelse($cartItems as $item)
            <div class="bg-white rounded shadow p-4 mb-4 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-lg">{{ $item->product->title }}</h3>
                    <p class="text-gray-500">₱{{ number_format($item->product->price, 2) }} x {{ $item->quantity }}</p>
                    <p class="text-green-600 font-semibold">Subtotal: ₱{{ number_format($item->product->price * $item->quantity, 2) }}</p>
                </div>
                <form method="POST" action="{{ route('buyer.cart.destroy', $item) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Remove</button>
                </form>
            </div>
            @empty
            <p class="text-gray-500">Your cart is empty.</p>
            @endforelse
            @if($cartItems->count())
            <div class="bg-white rounded shadow p-4 mt-6">
                <p class="text-xl font-bold">Total: ₱{{ number_format($total, 2) }}</p>
                <form method="POST" action="{{ route('buyer.orders.store') }}" class="mt-4">
                    @csrf
                    <textarea name="shipping_address" placeholder="Enter your shipping address" class="border rounded w-full px-4 py-2 mb-4" rows="3" required></textarea>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Place Order</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
