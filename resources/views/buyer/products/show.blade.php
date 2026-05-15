<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $product->title }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded shadow p-6">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" class="w-full h-64 object-cover rounded mb-6">
                @endif
                <h1 class="text-2xl font-bold mb-2">{{ $product->title }}</h1>
                <p class="text-gray-500 mb-2">Category: {{ $product->category->name }}</p>
                <p class="text-gray-500 mb-2">Condition: {{ ucfirst($product->condition) }}</p>
                <p class="text-gray-500 mb-4">Stock: {{ $product->stock }}</p>
                <p class="text-green-600 text-2xl font-semibold mb-4">₱{{ number_format($product->price, 2) }}</p>
                <p class="text-gray-700 mb-6">{{ $product->description }}</p>
                <form method="POST" action="{{ route('buyer.cart.store') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="flex items-center gap-4">
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="border rounded px-3 py-2 w-24">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Add to Cart</button>
                    </div>
                </form>
                <a href="{{ route('buyer.products.index') }}" class="mt-4 inline-block text-blue-600">← Back to Products</a>
            </div>
        </div>
    </div>
</x-app-layout>
