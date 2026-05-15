<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $product->title }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded shadow p-6 mb-6">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" class="w-full h-64 object-cover rounded mb-6">
                @endif
                <h1 class="text-2xl font-bold mb-2">{{ $product->title }}</h1>
                <p class="text-gray-500 mb-2">Category: {{ $product->category->name }}</p>
                <p class="text-gray-500 mb-2">Condition: {{ ucfirst($product->condition) }}</p>
                <p class="text-gray-500 mb-4">Stock: {{ $product->stock }}</p>

                <div class="flex items-center gap-2 mb-4">
                    @php $avg = round($product->averageRating(), 1); @endphp
                    <div class="flex text-yellow-400 text-xl">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $avg ? '★' : '☆' }}
                        @endfor
                    </div>
                    <span class="text-gray-500 text-sm">({{ $product->reviews->count() }} reviews)</span>
                </div>

                <p class="text-green-600 text-2xl font-semibold mb-4">₱{{ number_format($product->price, 2) }}</p>
                <p class="text-gray-700 mb-6">{{ $product->description }}</p>

                <form method="POST" action="{{ route('buyer.cart.store') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="flex items-center gap-4">
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                            class="border rounded px-3 py-2 w-24">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Add to Cart</button>
                    </div>
                </form>

                <a href="{{ route('buyer.products.index') }}" class="mt-4 inline-block text-blue-600">← Back to Products</a>
            </div>

            <!-- Reviews Section -->
            <div class="bg-white rounded shadow p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Customer Reviews</h2>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
                @endif

                @forelse($product->reviews()->with('user')->latest()->get() as $review)
                <div class="border-b py-4">
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-medium">{{ $review->user->name }}</span>
                        <span class="text-gray-400 text-sm">{{ $review->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="text-yellow-400 text-lg mb-1">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $review->rating ? '★' : '☆' }}
                        @endfor
                    </div>
                    <p class="text-gray-700">{{ $review->comment }}</p>
                </div>
                @empty
                <p class="text-gray-500">No reviews yet. Be the first to review!</p>
                @endforelse
            </div>

            <!-- Review Form -->
            <div class="bg-white rounded shadow p-6">
                <h2 class="text-xl font-bold mb-4">Leave a Review</h2>
                <form method="POST" action="{{ route('buyer.products.review', $product) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                        <select name="rating" class="border rounded px-4 py-2 w-full" required>
                            <option value="">Select rating</option>
                            <option value="5">★★★★★ Excellent</option>
                            <option value="4">★★★★☆ Good</option>
                            <option value="3">★★★☆☆ Average</option>
                            <option value="2">★★☆☆☆ Poor</option>
                            <option value="1">★☆☆☆☆ Terrible</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Comment</label>
                        <textarea name="comment" rows="3" placeholder="Share your experience..."
                            class="border rounded w-full px-4 py-2"></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Submit Review</button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
