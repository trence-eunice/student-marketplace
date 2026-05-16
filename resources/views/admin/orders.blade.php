<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Orders</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="page-title">Manage Orders</h1>
                    <p class="page-subtitle">View all platform orders.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn-outline px-4 py-2 rounded-lg text-sm font-semibold">
                    ← Dashboard
                </a>
            </div>

            
            

            <div class="card rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr style="background: var(--border)">
                            <th class="text-left px-4 py-3">Order #</th>
                            <th class="text-left px-4 py-3">Buyer</th>
                            <th class="text-left px-4 py-3">Total</th>
                            <th class="text-left px-4 py-3">Status</th>
                            <th class="text-left px-4 py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr class="border-b transition hover:bg-gray-50" style="border-color: var(--border)">
                            <td class="px-4 py-3 font-semibold">{{ $order->order_number }}</td>
                            <td class="px-4 py-3" style="color: var(--muted)">{{ $order->user->name }}</td>
                            <td class="px-4 py-3 font-bold" style="color: var(--accent)">₱{{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs px-2 py-1 rounded-full font-semibold
                                    @if($order->status === 'pending') badge-warning
                                    @elseif($order->status === 'cancelled') badge-danger
                                    @elseif($order->status === 'processing') badge-info
                                    @elseif($order->status === 'shipped') badge-info
                                    @else badge-success
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm" style="color: var(--muted)">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center" style="color: var(--muted)">No orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $orders->links() }}</div>
            </div>

        </div>
    </div>
</x-app-layout>
