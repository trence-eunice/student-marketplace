<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Browse Products</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Page Title --}}
            <div class="mb-6">
                <h1 class="page-title">Browse Products</h1>
                <p class="page-subtitle">Find what you need from fellow students.</p>
            </div>

            {{-- Filters --}}
            <form method="GET" class="card p-4 mb-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search products..."
                        class="input-dark rounded px-4 py-2 w-full">

                    <select name="category" class="input-dark rounded px-4 py-2">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="condition" class="input-dark rounded px-4 py-2">
                        <option value="">All Conditions</option>
                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Used</option>
                    </select>

                    <div class="flex gap-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}"
                            placeholder="Min ₱" min="0"
                            class="input-dark rounded px-3 py-2 w-full">
                        <input type="number" name="max_price" value="{{ request('max_price') }}"
                            placeholder="Max ₱" min="0"
                            class="input-dark rounded px-3 py-2 w-full">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary px-4 py-2 rounded w-full">Filter</button>
                        <a href="{{ route('buyer.products.index') }}" class="btn-outline px-4 py-2 rounded w-full text-center">Reset</a>
                    </div>
                </div>
            </form>

            {{-- Product Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                <div class="glass-card rounded-xl overflow-hidden flex flex-col">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400 text-sm">No image</div>
                    @endif
                    <div class="p-4 flex flex-col flex-1">
                        <div class="flex items-start justify-between gap-2 mb-1">
                            <h3 class="font-bold text-base leading-tight">{{ $product->title }}</h3>
                            @if($product->stock <= 3 && $product->stock > 0)
                                <span class="badge-warning text-xs whitespace-nowrap">Only {{ $product->stock }} left</span>
                            @elseif($product->stock == 0)
                                <span class="badge-danger text-xs whitespace-nowrap">Out of stock</span>
                            @endif
                        </div>
                        <p class="text-sm" style="color: var(--muted)">{{ $product->category->name }} · {{ ucfirst($product->condition) }}</p>
                        <p class="font-bold mt-2 mb-4" style="color: var(--accent)">₱{{ number_format($product->price, 2) }}</p>
                        <a href="{{ route('buyer.products.show', $product) }}"
                            class="btn-primary mt-auto block text-center py-2 rounded-lg text-sm font-semibold">
                            View Product
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 col-span-3">No products found.</p>
                @endforelse
            </div>

            <div class="mt-8">{{ $products->links() }}</div>
        </div>
    </div>
</x-app-layout>
