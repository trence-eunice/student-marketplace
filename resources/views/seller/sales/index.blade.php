<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">My Sales</h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="mb-6">
            <h1 class="page-title">My Sales</h1>
            <p class="page-subtitle">Orders containing your products. Update status as you process them.</p>
        </div>

        

        @forelse($orders as $order)
        <div class="card rounded-xl p-5 mb-5">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="font-bold text-base">{{ $order->order_number }}</h3>
                    <p class="text-xs mt-0.5" style="color: var(--muted)">
                        Buyer: {{ $order->user->name }} · {{ $order->created_at->format('M d, Y h:i A') }}
                    </p>
                    <p class="text-xs mt-0.5" style="color: var(--muted)">
                        Shipping: {{ $order->shipping_address }}
                    </p>
                </div>
                <span class="text-xs px-2 py-1 rounded-full font-semibold
                    @if($order->status === 'pending') badge-warning
                    @elseif($order->status === 'cancelled') badge-danger
                    @elseif($order->status === 'processing') badge-info
                    @elseif($order->status === 'shipped') badge-info
                    @else badge-success
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            {{-- Items --}}
            <table class="w-full text-sm mb-4">
                <thead>
                    <tr style="background: var(--border)">
                        <th class="text-left px-3 py-2 rounded-l">Product</th>
                        <th class="text-left px-3 py-2">Qty</th>
                        <th class="text-left px-3 py-2 rounded-r">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    @if($item->product && $item->product->user_id === auth()->id())
                    <tr class="border-b" style="border-color: var(--border)">
                        <td class="px-3 py-2">{{ $item->product->title ?? '[Deleted product]' }}</td>
                        <td class="px-3 py-2">{{ $item->quantity }}</td>
                        <td class="px-3 py-2 font-bold" style="color: var(--accent)">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>

            {{-- Update Status --}}
            @if($order->status !== 'cancelled')
            <div class="flex justify-between items-center">
                <p class="text-sm font-bold">
                    Total: <span style="color: var(--accent)">₱{{ number_format($order->total_amount, 2) }}</span>
                </p>
                <a href="{{ route('messages.show', [$order->id, auth()->id()]) }}" class="btn-primary px-4 py-1.5 rounded-lg text-sm font-semibold" style="text-decoration:none;margin-bottom:8px;display:inline-block;">💬 Message Buyer</a>
                <form method="POST" action="{{ route('seller.sales.status', $order) }}">
                    @csrf
                    @method('PATCH')
                    <div class="flex items-center gap-2">
                        <select name="status" class="input-dark rounded-lg px-2 py-1 text-xs" style="width:130px">
                            <option value="pending"    {{ $order->status === 'pending'    ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped"    {{ $order->status === 'shipped'    ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered"  {{ $order->status === 'delivered'  ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled"  {{ $order->status === 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn-primary px-3 py-1 rounded-lg text-xs font-semibold">
                            Update
                        </button>
                    </div>
                </form>
            </div>
            @else
            <p class="text-sm font-bold">
                Total: <span style="color: var(--accent)">₱{{ number_format($order->total_amount, 2) }}</span>
            </p>
            @endif
        </div>
        @empty
        <div class="card p-10 text-center">
            <p class="text-lg font-semibold mb-2">No sales yet</p>
            <p class="text-sm" style="color: var(--muted)">When buyers purchase your products, orders will appear here.</p>
        </div>
        @endforelse

        <div class="mt-4">{{ $orders->links() }}</div>
    </div>
</x-app-layout>
