<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="page-title">Admin Dashboard</h1>
                <p class="page-subtitle">Overview of the StudentMarket platform.</p>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="card rounded-xl p-6 text-center">
                    <div class="text-4xl font-bold mb-1" style="color: var(--accent)">{{ $totalUsers }}</div>
                    <div class="text-sm font-medium" style="color: var(--muted)">Total Users</div>
                </div>
                <div class="card rounded-xl p-6 text-center">
                    <div class="text-4xl font-bold mb-1" style="color: var(--accent)">{{ $totalProducts }}</div>
                    <div class="text-sm font-medium" style="color: var(--muted)">Total Products</div>
                </div>
                <div class="card rounded-xl p-6 text-center">
                    <div class="text-4xl font-bold mb-1" style="color: var(--accent)">{{ $totalOrders }}</div>
                    <div class="text-sm font-medium" style="color: var(--muted)">Total Orders</div>
                </div>
            </div>

            {{-- Recent Orders + Products --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

                <div class="card rounded-xl p-6">
                    <h3 class="font-bold text-base mb-4">Recent Orders</h3>
                    @forelse($recentOrders as $order)
                    <div class="border-b py-3" style="border-color: var(--border)">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-sm">{{ $order->order_number }}</span>
                            <span class="text-xs px-2 py-1 rounded-full font-semibold
                                @if($order->status === 'pending') badge-warning
                                @elseif($order->status === 'cancelled') badge-danger
                                @elseif($order->status === 'processing') badge-info
                                @else badge-success
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="text-xs mt-0.5" style="color: var(--muted)">
                            {{ $order->user->name }} — ₱{{ number_format($order->total_amount, 2) }}
                        </div>
                    </div>
                    @empty
                    <p class="text-sm" style="color: var(--muted)">No orders yet.</p>
                    @endforelse
                    <a href="{{ route('admin.orders') }}" class="mt-4 inline-block text-sm font-semibold hover:underline" style="color: var(--accent)">
                        View all orders →
                    </a>
                </div>

                <div class="card rounded-xl p-6">
                    <h3 class="font-bold text-base mb-4">Recent Products</h3>
                    @forelse($recentProducts as $product)
                    <div class="border-b py-3" style="border-color: var(--border)">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-sm">{{ $product->title }}</span>
                            <span class="font-bold text-sm" style="color: var(--accent)">₱{{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="text-xs mt-0.5" style="color: var(--muted)">
                            by {{ $product->user->name }} — {{ $product->category->name }}
                        </div>
                    </div>
                    @empty
                    <p class="text-sm" style="color: var(--muted)">No products yet.</p>
                    @endforelse
                </div>

            </div>

            {{-- Quick Actions --}}
            <div class="flex gap-4">
                <a href="{{ route('admin.users') }}" class="btn-primary px-6 py-2 rounded-lg font-semibold">
                    Manage Users
                </a>
                <a href="{{ route('admin.orders') }}" class="btn-outline px-6 py-2 rounded-lg font-semibold">
                    Manage Orders
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
