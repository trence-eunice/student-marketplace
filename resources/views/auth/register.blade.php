<x-guest-layout>
    <h1 class="guest-title">Create account</h1>
    <p class="guest-subtitle">Join StudentMarket and start buying or selling.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="margin-bottom:16px;">
            <label class="guest-label">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="guest-input" placeholder="Juan Dela Cruz" required autofocus autocomplete="name">
            @error('name')
                <p class="guest-error">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom:16px;">
            <label class="guest-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="guest-input" placeholder="you@school.edu" required autocomplete="username">
            @error('email')
                <p class="guest-error">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom:16px;">
            <label class="guest-label">Register as</label>
            <select name="role" class="guest-input">
                <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : '' }}>🛍️ Buyer — I want to shop</option>
                <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>📦 Seller — I want to sell</option>
            </select>
            @error('role')
                <p class="guest-error">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom:16px;">
            <label class="guest-label">Password</label>
            <input type="password" name="password"
                class="guest-input" placeholder="••••••••" required autocomplete="new-password">
            @error('password')
                <p class="guest-error">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom:24px;">
            <label class="guest-label">Confirm Password</label>
            <input type="password" name="password_confirmation"
                class="guest-input" placeholder="••••••••" required autocomplete="new-password">
            @error('password_confirmation')
                <p class="guest-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="guest-btn">Create Account →</button>

        <hr class="guest-divider">

        <p style="text-align:center;font-size:13px;color:rgba(255,255,255,0.4);">
            Already have an account?
            <a href="{{ route('login') }}" class="guest-link" style="color:#E8FF5A;font-weight:500;">Log in</a>
        </p>
    </form>
</x-guest-layout>
