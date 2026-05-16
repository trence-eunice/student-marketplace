<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">My Products</h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="page-title">My Listings</h1>
                <p class="page-subtitle">Manage your products for sale.</p>
            </div>
            <a href="{{ route('seller.products.create') }}" class="btn-primary px-5 py-2 rounded-lg font-semibold">
                + Add Product
            </a>
        </div>

        

        <div class="card rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr style="background: var(--border)">
                        <th class="text-left px-4 py-3">Image</th>
                        <th class="text-left px-4 py-3">Title</th>
                        <th class="text-left px-4 py-3">Category</th>
                        <th class="text-left px-4 py-3">Price</th>
                        <th class="text-left px-4 py-3">Stock</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="border-b transition hover:bg-gray-50" style="border-color: var(--border)">
                        <td class="px-4 py-3">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" class="w-14 h-14 object-cover rounded-lg">
                            @else
                                <div class="w-14 h-14 rounded-lg flex items-center justify-center text-xs" style="background: var(--border); color: var(--muted)">No img</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-semibold">{{ $product->title }}</td>
                        <td class="px-4 py-3" style="color: var(--muted)">{{ $product->category->name }}</td>
                        <td class="px-4 py-3 font-bold" style="color: var(--accent)">₱{{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-3">
                            @if($product->stock == 0)
                                <span class="badge-danger text-xs">Out of stock</span>
                            @elseif($product->stock <= 3)
                                <span class="badge-warning text-xs">{{ $product->stock }} left</span>
                            @else
                                <span>{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-1 rounded-full font-semibold
                                {{ $product->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('seller.products.edit', $product) }}"
                                   class="btn-outline px-3 py-1 rounded-lg text-xs font-semibold">Edit</a>
                                <form action="{{ route('seller.products.destroy', $product) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger px-3 py-1 rounded-lg text-xs font-semibold">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center" style="color: var(--muted)">
                            No products yet.
                            <a href="{{ route('seller.products.create') }}" class="underline font-semibold">Add your first one!</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $products->links() }}</div>
    </div>
</x-app-layout>
