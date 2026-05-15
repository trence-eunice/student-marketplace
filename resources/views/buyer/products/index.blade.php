<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Browse Products</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="GET" class="mb-6 flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="border rounded px-4 py-2 w-full">
                <select name="category" class="border rounded px-4 py-2">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
            </form>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                <div class="bg-white rounded shadow p-4">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" class="w-full h-48 object-cover rounded mb-3">
                    @endif
                    <h3 class="font-bold text-lg">{{ $product->title }}</h3>
                    <p class="text-gray-500 text-sm">{{ $product->category->name }}</p>
                    <p class="text-green-600 font-semibold mt-1">₱{{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('buyer.products.show', $product) }}" class="mt-3 block text-center bg-blue-600 text-white py-2 rounded">View</a>
                </div>
                @empty
                <p class="text-gray-500">No products found.</p>
                @endforelse
            </div>
            <div class="mt-6">{{ $products->links() }}</div>
        </div>
    </div>
</x-app-layout>
