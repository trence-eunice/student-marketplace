<x-guest-layout>
    <h1 class="guest-title">Welcome back</h1>
    <p class="guest-subtitle">Log in to your StudentMarket account.</p>

    @if(session('status'))
        <div class="status-flash">{{ session('status') }}</div>
    @endif

    @if(session('error'))
        <div class="error-flash">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="margin-bottom:16px;">
            <label class="guest-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="guest-input" placeholder="you@school.edu" required autofocus autocomplete="username">
            @error('email')
                <p class="guest-error">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom:20px;">
            <label class="guest-label">Password</label>
            <input type="password" name="password"
                class="guest-input" placeholder="••••••••" required autocomplete="current-password">
            @error('password')
                <p class="guest-error">{{ $message }}</p>
            @enderror
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                <input type="checkbox" name="remember" class="checkbox-custom">
                <span style="font-size:13px;color:rgba(255,255,255,0.4);">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="guest-link">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="guest-btn">Log in →</button>

        <hr class="guest-divider">

        <p style="text-align:center;font-size:13px;color:rgba(255,255,255,0.4);">
            Don't have an account?
            <a href="{{ route('register') }}" class="guest-link" style="color:#E8FF5A;font-weight:500;">Sign up</a>
        </p>
    </form>
</x-guest-layout>
