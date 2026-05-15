<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Orders</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
            @endif

            @forelse($orders as $order)
            <div class="bg-white rounded shadow p-4 mb-4">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-bold text-lg">Order #{{ $order->order_number }}</h3>
                    <span class="px-3 py-1 rounded-full text-sm
                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                          ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' :
                           'bg-green-100 text-green-700') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <p class="text-gray-500 mb-2">Shipping: {{ $order->shipping_address }}</p>
                <p class="text-green-600 font-semibold mb-3">Total: ₱{{ number_format($order->total_amount, 2) }}</p>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="text-left px-3 py-2">Product</th>
                            <th class="text-left px-3 py-2">Qty</th>
                            <th class="text-left px-3 py-2">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr class="border-b">
                            <td class="px-3 py-2">{{ $item->product->title }}</td>
                            <td class="px-3 py-2">{{ $item->quantity }}</td>
                            <td class="px-3 py-2">₱{{ number_format($item->price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($order->status === 'pending')
                <form method="POST" action="{{ route('buyer.orders.cancel', $order) }}" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded"
                        onclick="return confirm('Are you sure you want to cancel this order?')">
                        Cancel Order
                    </button>
                </form>
                @endif

            </div>
            @empty
            <p class="text-gray-500">You have no orders yet.</p>
            @endforelse

        </div>
    </div>
</x-app-layout>
