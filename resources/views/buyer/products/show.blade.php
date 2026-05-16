<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $product->title }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Product Card --}}
            <div class="card rounded-xl overflow-hidden mb-6">
                @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" class="w-full h-72 object-cover">
                @else
                    <div class="w-full h-72 bg-gray-100 flex items-center justify-center text-gray-400">No image</div>
                @endif
                <div class="p-6">
                    <div class="flex items-start justify-between gap-4 mb-2">
                        <h1 class="page-title">{{ $product->title }}</h1>
                        @if($product->stock <= 3 && $product->stock > 0)
                            <span class="badge-warning text-xs">Only {{ $product->stock }} left</span>
                        @elseif($product->stock == 0)
                            <span class="badge-danger text-xs">Out of stock</span>
                        @else
                            <span class="badge-success text-xs">In stock</span>
                        @endif
                    </div>

                    <p class="text-sm mb-1" style="color: var(--muted)">{{ $product->category->name }} · {{ ucfirst($product->condition) }}</p>

                    {{-- Star Rating --}}
                    <div class="flex items-center gap-2 my-3">
                        @php $avg = round($product->averageRating(), 1); @endphp
                        <div class="flex text-yellow-400 text-lg">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $avg ? '★' : '☆' }}
                            @endfor
                        </div>
                        <span class="text-sm" style="color: var(--muted)">({{ $product->reviews->count() }} reviews)</span>
                    </div>

                    <p class="text-3xl font-bold mb-4" style="color: var(--accent)">₱{{ number_format($product->price, 2) }}</p>
                    <p class="text-sm mb-6" style="color: var(--text)">{{ $product->description }}</p>

                    @if($product->stock > 0)
                    <form method="POST" action="{{ route('buyer.cart.store') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center gap-4">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                class="input-dark rounded px-3 py-2 w-24">
                            <button type="submit" class="btn-primary px-8 py-2 rounded-lg font-semibold">
                                Add to Cart
                            </button>
                        </div>
                    </form>
                    @else
                        <p class="badge-danger inline-block px-4 py-2 rounded-lg font-semibold">Out of Stock</p>
                    @endif

                    <div class="flex items-center gap-4 mt-4">
                        <a href="{{ route('buyer.products.index') }}" class="text-sm hover:underline" style="color: var(--muted)">← Back to Products</a>
                        <button onclick="document.getElementById('review-modal').classList.remove('hidden')"
                            class="btn-outline px-4 py-2 rounded-lg text-sm font-semibold">
                            ✍️ Leave a Review
                        </button>
                    </div>
                </div>
            </div>

            {{-- Reviews --}}
            <div class="card p-6 mb-6">
                <h2 class="page-title mb-4">Customer Reviews</h2>

                @forelse($product->reviews()->with('user')->latest()->get() as $review)
                <div class="border-b py-4" style="border-color: var(--border)">
                    <div class="flex justify-between items-center mb-1">
                        <span class="font-semibold text-sm">{{ $review->user->name }}</span>
                        <span class="text-xs" style="color: var(--muted)">{{ $review->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="text-yellow-400 text-base mb-1">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $review->rating ? '★' : '☆' }}
                        @endfor
                    </div>
                    <p class="text-sm" style="color: var(--text)">{{ $review->comment }}</p>
                </div>
                @empty
                <p class="text-sm" style="color: var(--muted)">No reviews yet. Be the first to review!</p>
                @endforelse
            </div>

        </div>
    </div>

    {{-- Review Modal --}}
    <div id="review-modal"
        class="{{ $errors->any() || session('review_error') ? '' : 'hidden' }}"
        style="position:fixed;inset:0;z-index:1000;align-items:center;justify-content:center;background:rgba(0,0,0,0.5);">
        <div class="card rounded-xl p-6" style="width:100%;max-width:480px;margin:16px;">
            <div class="flex justify-between items-center mb-4">
                <h2 class="page-title" style="font-size:18px;">Leave a Review</h2>
                <button onclick="document.getElementById('review-modal').classList.add('hidden')"
                    style="font-size:20px;cursor:pointer;color:var(--muted);">✕</button>
            </div>

            @if($errors->any() || session('review_error'))
                <div class="alert-error px-4 py-3 rounded mb-4 text-sm">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                    @if(session('review_error'))
                        <p>{{ session('review_error') }}</p>
                    @endif
                </div>
            @endif

            <form method="POST" action="{{ route('buyer.products.review', $product) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Rating</label>
                    <div class="flex gap-2" id="star-container">
                        @for($i = 1; $i <= 5; $i++)
                        <span onclick="setRating({{ $i }})"
                            style="font-size:28px;cursor:pointer;color:#d1d5db;"
                            id="star-{{ $i }}">★</span>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-input" required>
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium mb-1">Comment</label>
                    <textarea name="comment" rows="3" placeholder="Share your experience..."
                        class="input-dark rounded-lg w-full px-4 py-2"></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn-primary px-6 py-2 rounded-lg font-semibold flex-1">
                        Submit Review
                    </button>
                    <button type="button"
                        onclick="document.getElementById('review-modal').classList.add('hidden')"
                        class="btn-outline px-6 py-2 rounded-lg font-semibold">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function setRating(value) {
            document.getElementById('rating-input').value = value;
            for (let i = 1; i <= 5; i++) {
                const star = document.getElementById('star-' + i);
                star.style.color = i <= value ? '#facc15' : '#d1d5db';
            }
        }

        // Close modal on backdrop click
        document.getElementById('review-modal').addEventListener('click', function(e) {
            if (e.target === this) this.classList.add('hidden');
        });
    </script>
</x-app-layout>
