<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-4xl font-bold text-blue-600">{{ $totalUsers }}</div>
                    <div class="text-gray-500 mt-1">Total Users</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-4xl font-bold text-green-600">{{ $totalProducts }}</div>
                    <div class="text-gray-500 mt-1">Total Products</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-4xl font-bold text-purple-600">{{ $totalOrders }}</div>
                    <div class="text-gray-500 mt-1">Total Orders</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-lg mb-4">Recent Orders</h3>
                    @forelse($recentOrders as $order)
                    <div class="border-b py-2">
                        <div class="flex justify-between">
                            <span class="font-medium">{{ $order->order_number }}</span>
                            <span class="text-sm px-2 py-1 rounded {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">{{ ucfirst($order->status) }}</span>
                        </div>
                        <div class="text-sm text-gray-500">{{ $order->user->name }} — ₱{{ number_format($order->total_amount, 2) }}</div>
                    </div>
                    @empty
                    <p class="text-gray-500">No orders yet.</p>
                    @endforelse
                    <a href="{{ route('admin.orders') }}" class="mt-4 inline-block text-blue-600 text-sm">View all orders →</a>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-lg mb-4">Recent Products</h3>
                    @forelse($recentProducts as $product)
                    <div class="border-b py-2">
                        <div class="flex justify-between">
                            <span class="font-medium">{{ $product->title }}</span>
                            <span class="text-green-600 font-semibold">₱{{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="text-sm text-gray-500">by {{ $product->user->name }} — {{ $product->category->name }}</div>
                    </div>
                    @empty
                    <p class="text-gray-500">No products yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <a href="{{ route('admin.users') }}" class="bg-blue-600 text-white px-6 py-2 rounded">Manage Users</a>
                <a href="{{ route('admin.orders') }}" class="bg-purple-600 text-white px-6 py-2 rounded">Manage Orders</a>
            </div>

        </div>
    </div>
</x-app-layout>
