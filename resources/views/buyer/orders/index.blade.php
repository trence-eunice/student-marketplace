<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Orders</h2>
    </x-slot>
    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <h1 class="page-title">My Orders</h1>
                <p class="page-subtitle">Track and manage your purchases.</p>
            </div>

            @forelse($orders as $order)
            <div class="card rounded-xl p-5 mb-5">

                {{-- Header --}}
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="font-bold text-base">{{ $order->order_number }}</h3>
                        <p class="text-xs mt-0.5" style="color: var(--muted)">
                            Placed on {{ $order->created_at->format('M d, Y h:i A') }}
                        </p>
                        <p class="text-xs mt-0.5" style="color: var(--muted)">
                            Shipping: {{ $order->shipping_address }}
                        </p>
                    </div>
                    <span class="text-xs px-3 py-1 rounded-full font-semibold
                        @if($order->status === 'pending') badge-warning
                        @elseif($order->status === 'cancelled') badge-danger
                        @elseif($order->status === 'processing') badge-info
                        @else badge-success
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                {{-- Items grouped by seller --}}
                @php
                    $grouped = $order->orderItems->groupBy(fn($item) => $item->product->user_id ?? 0);
                @endphp

                @foreach($grouped as $sellerId => $items)
                @php $seller = $items->first()->product->user; @endphp
                <div class="mb-4" style="border:1px solid var(--border);border-radius:10px;overflow:hidden;">
                    <div style="background:var(--border);padding:8px 12px;display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:12px;font-weight:600;">Seller: {{ $seller->name ?? 'Unknown' }}</span>
                        <a href="{{ route('messages.show', [$order->id, $sellerId]) }}"
                            style="font-size:11px;background:#E8FF5A;color:#0E0E10;padding:4px 10px;border-radius:6px;text-decoration:none;font-weight:600;">
                            💬 Message Seller
                        </a>
                    </div>
                    <table class="w-full text-sm">
                        <thead>
                            <tr style="background: var(--border)">
                                <th class="text-left px-3 py-2">Product</th>
                                <th class="text-left px-3 py-2">Qty</th>
                                <th class="text-left px-3 py-2">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr class="border-b" style="border-color: var(--border)">
                                <td class="px-3 py-2">{{ $item->product->title ?? '[Deleted]' }}</td>
                                <td class="px-3 py-2">{{ $item->quantity }}</td>
                                <td class="px-3 py-2">₱{{ number_format($item->price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach

                {{-- Footer --}}
                <div class="flex justify-between items-center mt-2">
                    <p class="font-bold text-base" style="color: var(--accent)">
                        Total: ₱{{ number_format($order->total_amount, 2) }}
                    </p>
                    @if($order->status === 'pending')
                    <form method="POST" action="{{ route('buyer.orders.cancel', $order) }}"
                          onsubmit="return confirm('Cancel this order? Stock will be restored.')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-danger px-4 py-1.5 rounded-lg text-sm font-semibold">
                            Cancel Order
                        </button>
                    </form>
                    @endif
                </div>

            </div>
            @empty
            <div class="card p-10 text-center">
                <p class="text-lg font-semibold mb-2">No orders yet</p>
                <p class="text-sm mb-4" style="color: var(--muted)">Start shopping to see your orders here.</p>
                <a href="{{ route('buyer.products.index') }}" class="btn-primary px-6 py-2 rounded-lg font-semibold">Browse Products</a>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
