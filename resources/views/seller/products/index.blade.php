<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">My Products</h2>
            <a href="{{ route('seller.products.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Add Product
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full bg-white shadow rounded">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-3">Image</th>
                    <th class="p-3">Title</th>
                    <th class="p-3">Category</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Stock</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="border-t">
                    <td class="p-3">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}"
                                 class="w-16 h-16 object-cover rounded">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-400">No image</div>
                        @endif
                    </td>
                    <td class="p-3">{{ $product->title }}</td>
                    <td class="p-3">{{ $product->category->name }}</td>
                    <td class="p-3">₱{{ number_format($product->price, 2) }}</td>
                    <td class="p-3">{{ $product->stock }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs
                            {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </td>
                    <td class="p-3 space-x-2">
                        <a href="{{ route('seller.products.edit', $product) }}"
                           class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('seller.products.destroy', $product) }}"
                              method="POST" class="inline"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-6 text-center text-gray-400">No products yet. Add your first one!</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</x-app-layout>