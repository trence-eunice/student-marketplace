<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-gray-500 mt-1">What would you like to do today?</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <a href="{{ route('buyer.products.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
                    <div class="text-4xl mb-3">🛍️</div>
                    <h3 class="text-xl font-bold text-gray-800">Browse Products</h3>
                    <p class="text-gray-500 mt-1">Find and buy products from other students.</p>
                </a>

                <a href="{{ route('buyer.cart.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
                    <div class="text-4xl mb-3">🛒</div>
                    <h3 class="text-xl font-bold text-gray-800">My Cart</h3>
                    <p class="text-gray-500 mt-1">View items in your cart and checkout.</p>
                </a>

                <a href="{{ route('buyer.orders.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
                    <div class="text-4xl mb-3">📦</div>
                    <h3 class="text-xl font-bold text-gray-800">My Orders</h3>
                    <p class="text-gray-500 mt-1">Track your orders and purchase history.</p>
                </a>

                @if(auth()->user()->role === 'seller' || auth()->user()->role === 'admin')
                <a href="{{ route('seller.products.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
                    <div class="text-4xl mb-3">📝</div>
                    <h3 class="text-xl font-bold text-gray-800">My Listings</h3>
                    <p class="text-gray-500 mt-1">Manage your products for sale.</p>
                </a>

                <a href="{{ route('seller.products.create') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
                    <div class="text-4xl mb-3">➕</div>
                    <h3 class="text-xl font-bold text-gray-800">Add Product</h3>
                    <p class="text-gray-500 mt-1">List a new product on the marketplace.</p>
                </a>
                @endif

                <a href="{{ route('profile.edit') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
                    <div class="text-4xl mb-3">👤</div>
                    <h3 class="text-xl font-bold text-gray-800">My Profile</h3>
                    <p class="text-gray-500 mt-1">Update your account information.</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
