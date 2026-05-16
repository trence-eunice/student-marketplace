<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Payment</h2>
    </x-slot>
    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <h1 class="page-title">Payment</h1>
                <p class="page-subtitle">Choose how you want to pay.</p>
            </div>

            {{-- Progress Steps --}}
            <div class="flex items-center gap-2 mb-8 text-sm font-semibold">
                <span class="px-3 py-1 rounded-full" style="background: var(--border); color: var(--muted)">1. Shipping</span>
                <span style="color: var(--muted)">→</span>
                <span class="px-3 py-1 rounded-full" style="background: var(--accent); color: var(--bg)">2. Payment</span>
                <span style="color: var(--muted)">→</span>
                <span class="px-3 py-1 rounded-full" style="background: var(--border); color: var(--muted)">3. Done</span>
            </div>

            

            {{-- Order Summary --}}
            <div class="card rounded-xl p-6 mb-6">
                <h3 class="font-bold text-base mb-1">Order Summary</h3>
                <p class="text-xs mb-4" style="color: var(--muted)">Shipping to: {{ $shippingAddress }}</p>
                <table class="w-full text-sm mb-4">
                    <thead>
                        <tr style="background: var(--border)">
                            <th class="text-left px-3 py-2 rounded-l">Product</th>
                            <th class="text-left px-3 py-2">Qty</th>
                            <th class="text-left px-3 py-2 rounded-r">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                        <tr class="border-b" style="border-color: var(--border)">
                            <td class="px-3 py-2">{{ $item->product->title }}</td>
                            <td class="px-3 py-2">{{ $item->quantity }}</td>
                            <td class="px-3 py-2">₱{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="text-right font-bold text-base">
                    Total: <span style="color: var(--accent)">₱{{ number_format($total, 2) }}</span>
                </p>
            </div>

            {{-- Payment Method --}}
            <div class="card rounded-xl p-6">
                <h3 class="font-bold text-base mb-5">Select Payment Method</h3>
                <form method="POST" action="{{ route('buyer.payment.store') }}">
                    @csrf

                    {{-- GCash --}}
                    <div id="label-gcash"
                        class="border-2 rounded-xl p-4 mb-4 cursor-pointer transition-all"
                        style="border-color: var(--border)"
                        onclick="selectMethod('gcash')">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="gcash" id="gcash">
                            <div>
                                <p class="font-bold text-blue-500">💙 GCash</p>
                                <p class="text-xs mt-0.5" style="color: var(--muted)">Send payment via GCash. Reference number required.</p>
                            </div>
                        </div>
                        <div id="gcash-fields" class="mt-4 hidden">
                            <p class="text-sm font-medium mb-1">Send to GCash Number:</p>
                            <p class="text-blue-500 font-bold text-lg mb-3">09XX-XXX-XXXX</p>
                            <label class="block text-sm font-medium mb-1">GCash Reference Number</label>
                            <input type="text" name="gcash_reference" maxlength="13"
                                class="input-dark w-full rounded-lg px-3 py-2"
                                placeholder="e.g. 1234567890123">
                            @error('gcash_reference')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Cash on Delivery --}}
                    <div id="label-cod"
                        class="border-2 rounded-xl p-4 mb-6 cursor-pointer transition-all"
                        style="border-color: var(--border)"
                        onclick="selectMethod('cod')">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="payment_method" value="cod" id="cod">
                            <div>
                                <p class="font-bold text-green-500">💵 Cash on Delivery</p>
                                <p class="text-xs mt-0.5" style="color: var(--muted)">Pay in cash when your order arrives.</p>
                            </div>
                        </div>
                    </div>

                    @error('payment_method')
                        <p class="text-red-500 text-xs mb-3">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="btn-primary w-full py-2.5 rounded-lg font-semibold">
                        Place Order — ₱{{ number_format($total, 2) }} →
                    </button>
                    <a href="{{ route('buyer.checkout.show') }}"
                        class="block text-center text-sm mt-3 hover:underline" style="color: var(--muted)">
                        ← Back to Checkout
                    </a>
                </form>
            </div>

        </div>
    </div>

    <script>
        function selectMethod(method) {
            document.getElementById('gcash-fields').classList.add('hidden');
            document.getElementById('label-gcash').style.borderColor = 'var(--border)';
            document.getElementById('label-cod').style.borderColor = 'var(--border)';

            if (method === 'gcash') {
                document.getElementById('gcash').checked = true;
                document.getElementById('gcash-fields').classList.remove('hidden');
                document.getElementById('label-gcash').style.borderColor = '#3b82f6';
            } else {
                document.getElementById('cod').checked = true;
                document.getElementById('label-cod').style.borderColor = '#22c55e';
            }
        }
    </script>
</x-app-layout>
