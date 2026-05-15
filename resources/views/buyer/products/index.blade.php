<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Browse Products</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="GET" class="bg-white rounded shadow p-4 mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search products..."
                        class="border rounded px-4 py-2 w-full">

                    <select name="category" class="border rounded px-4 py-2">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="condition" class="border rounded px-4 py-2">
                        <option value="">All Conditions</option>
                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Used</option>
                    </select>

                    <div class="flex gap-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}"
                            placeholder="Min ₱" min="0"
                            class="border rounded px-3 py-2 w-full">
                        <input type="number" name="max_price" value="{{ request('max_price') }}"
                            placeholder="Max ₱" min="0"
                            class="border rounded px-3 py-2 w-full">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full">Filter</button>
                        <a href="{{ route('buyer.products.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded w-full text-center">Reset</a>
                    </div>
                </div>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                <div class="bg-white rounded shadow p-4">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" class="w-full h-48 object-cover rounded mb-3">
                    @else
                        <div class="w-full h-48 bg-gray-100 rounded mb-3 flex items-center justify-center text-gray-400">No image</div>
                    @endif
                    <h3 class="font-bold text-lg">{{ $product->title }}</h3>
                    <p class="text-gray-500 text-sm">{{ $product->category->name }}</p>
                    <p class="text-gray-400 text-sm">{{ ucfirst($product->condition) }}</p>
                    <p class="text-green-600 font-semibold mt-1">₱{{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('buyer.products.show', $product) }}"
                        class="mt-3 block text-center bg-blue-600 text-white py-2 rounded">View</a>
                </div>
                @empty
                <p class="text-gray-500 col-span-3">No products found.</p>
                @endforelse
            </div>

            <div class="mt-6">{{ $products->links() }}</div>
        </div>
    </div>
</x-app-layout>
