<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Edit Product</h2>
    </x-slot>

    <div class="py-10 max-w-3xl mx-auto sm:px-6 lg:px-8">

        <div class="mb-6">
            <h1 class="page-title">Edit Product</h1>
            <p class="page-subtitle">Update the details for {{ $product->title }}.</p>
        </div>

        @if($errors->any())
            <div class="alert-error px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card rounded-xl p-6">
            <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label class="block text-sm font-medium mb-1">Title</label>
                    <input type="text" name="title" value="{{ old('title', $product->title) }}"
                           class="input-dark w-full rounded-lg px-3 py-2">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" rows="4"
                              class="input-dark w-full rounded-lg px-3 py-2">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-medium mb-1">Price (₱)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0"
                               class="input-dark w-full rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                               class="input-dark w-full rounded-lg px-3 py-2">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-medium mb-1">Category</label>
                        <select name="category_id" class="input-dark w-full rounded-lg px-3 py-2">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Condition</label>
                        <select name="condition" class="input-dark w-full rounded-lg px-3 py-2">
                            <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>New</option>
                            <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Used</option>
                        </select>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select name="status" class="input-dark w-full rounded-lg px-3 py-2">
                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- Image Upload with Preview --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-1">Product Image</label>
                    <div class="border-2 border-dashed rounded-xl p-4 text-center cursor-pointer transition hover:border-gray-400"
                         style="border-color: var(--border)"
                         onclick="document.getElementById('image-input').click()">
                        <img id="image-preview"
                             src="{{ $product->image ? Storage::url($product->image) : '' }}"
                             alt=""
                             class="{{ $product->image ? '' : 'hidden' }} w-full max-h-48 object-cover rounded-lg mb-3 mx-auto">
                        <p id="upload-label" class="text-sm" style="color: var(--muted)">
                            {{ $product->image ? 'Click to change image' : 'Click to upload an image' }}
                        </p>
                        <input type="file" id="image-input" name="image" accept="image/*" class="hidden"
                               onchange="previewImage(event)">
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="btn-primary px-6 py-2 rounded-lg font-semibold">
                        Update Product
                    </button>
                    <a href="{{ route('seller.products.index') }}" class="btn-outline px-6 py-2 rounded-lg font-semibold">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('image-preview');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                document.getElementById('upload-label').textContent = file.name;
            };
            reader.readAsDataURL(file);
        }
    </script>
</x-app-layout>
