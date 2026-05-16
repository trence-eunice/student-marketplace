<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StudentMarket — Buy & Sell on Campus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: #0E0E10;
            color: #fff;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* NAV */
        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 48px;
            border-bottom: 0.5px solid rgba(255,255,255,0.06);
            position: sticky; top: 0;
            background: #0E0E10;
            z-index: 100;
        }
        .logo {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .logo-icon {
            width: 32px; height: 32px;
            background: #E8FF5A;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-icon i { font-size: 16px; color: #0E0E10; }
        .logo-text {
            font-family: 'Syne', sans-serif;
            font-size: 16px; font-weight: 700;
            color: #fff;
        }
        .nav-links { display: flex; align-items: center; gap: 12px; }
        .btn-nav-outline {
            padding: 8px 20px;
            border-radius: 8px;
            border: 0.5px solid rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.7);
            font-size: 13px; font-weight: 500;
            text-decoration: none;
            transition: all 0.15s;
        }
        .btn-nav-outline:hover { border-color: rgba(255,255,255,0.4); color: #fff; }
        .btn-nav-primary {
            padding: 8px 20px;
            border-radius: 8px;
            background: #E8FF5A;
            color: #0E0E10;
            font-size: 13px; font-weight: 600;
            text-decoration: none;
            transition: opacity 0.15s;
        }
        .btn-nav-primary:hover { opacity: 0.85; }

        /* HERO */
        .hero {
            max-width: 900px;
            margin: 0 auto;
            padding: 100px 48px 80px;
            text-align: center;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(232,255,90,0.1);
            border: 0.5px solid rgba(232,255,90,0.3);
            color: #E8FF5A;
            font-size: 12px; font-weight: 500;
            padding: 6px 14px;
            border-radius: 100px;
            margin-bottom: 32px;
        }
        .hero h1 {
            font-family: 'Syne', sans-serif;
            font-size: 48px; font-weight: 800;
            line-height: 1.1;
            letter-spacing: -1px;
            color: #fff;
            margin-bottom: 20px;
        }
        .hero h1 span { color: #E8FF5A; }
        .hero p {
            font-size: 18px;
            color: rgba(255,255,255,0.5);
            line-height: 1.6;
            max-width: 560px;
            margin: 0 auto 40px;
        }
        .hero-buttons {
            display: flex; align-items: center; justify-content: center; gap: 12px;
        }
        .btn-hero-primary {
            padding: 14px 32px;
            border-radius: 10px;
            background: #E8FF5A;
            color: #0E0E10;
            font-size: 15px; font-weight: 600;
            text-decoration: none;
            transition: opacity 0.15s;
        }
        .btn-hero-primary:hover { opacity: 0.85; }
        .btn-hero-outline {
            padding: 14px 32px;
            border-radius: 10px;
            border: 0.5px solid rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.7);
            font-size: 15px; font-weight: 500;
            text-decoration: none;
            transition: all 0.15s;
        }
        .btn-hero-outline:hover { border-color: rgba(255,255,255,0.4); color: #fff; }

        /* FEATURES */
        .features {
            max-width: 1100px;
            margin: 0 auto;
            padding: 80px 48px;
        }
        .section-label {
            font-size: 12px; font-weight: 600;
            color: #E8FF5A;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 16px;
            text-align: center;
        }
        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: 36px; font-weight: 700;
            text-align: center;
            color: #fff;
            margin-bottom: 60px;
            letter-spacing: -1px;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .feature-card {
            background: rgba(255,255,255,0.03);
            border: 0.5px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 28px;
            transition: border-color 0.15s;
        }
        .feature-card:hover { border-color: rgba(255,255,255,0.15); }
        .feature-icon {
            width: 44px; height: 44px;
            background: rgba(232,255,90,0.1);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 16px;
        }
        .feature-icon i { font-size: 20px; color: #E8FF5A; }
        .feature-card h3 {
            font-family: 'Syne', sans-serif;
            font-size: 16px; font-weight: 600;
            color: #fff;
            margin-bottom: 8px;
        }
        .feature-card p {
            font-size: 13px;
            color: rgba(255,255,255,0.45);
            line-height: 1.6;
        }

        /* ROLES */
        .roles {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 48px 80px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .role-card {
            border-radius: 16px;
            padding: 32px;
            text-decoration: none;
        }
        .role-card.buyer { background: #1A2A1A; border: 0.5px solid #2D4A2D; }
        .role-card.seller { background: #1A1A2A; border: 0.5px solid #2D2D4A; }
        .role-card.admin { background: #2A1A1A; border: 0.5px solid #4A2D2D; }
        .role-emoji { font-size: 32px; margin-bottom: 16px; }
        .role-card h3 {
            font-family: 'Syne', sans-serif;
            font-size: 18px; font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
        }
        .role-card p { font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.6; margin-bottom: 20px; }
        .role-link {
            font-size: 13px; font-weight: 600;
            text-decoration: none;
            display: inline-flex; align-items: center; gap: 4px;
        }
        .role-card.buyer .role-link { color: #4ade80; }
        .role-card.seller .role-link { color: #60a5fa; }
        .role-card.admin .role-link { color: #f87171; }

        /* FOOTER */
        footer {
            border-top: 0.5px solid rgba(255,255,255,0.06);
            padding: 32px 48px;
            display: flex; align-items: center; justify-content: space-between;
        }
        footer p { font-size: 12px; color: rgba(255,255,255,0.3); }
    </style>
</head>
<body>

    <nav>
        <a href="/" class="logo">
            <div class="logo-icon"><i class="ti ti-bolt"></i></div>
            <span class="logo-text">StudentMarket</span>
        </a>
        <div class="nav-links">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-nav-primary">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-nav-outline">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-nav-primary">Get Started</a>
                @endif
            @endauth
        </div>
    </nav>

    <section class="hero">
        <div class="hero-badge">
            <i class="ti ti-bolt" style="font-size:12px;"></i>
            Built for students, by students
        </div>
        <h1>The marketplace for<br><span>campus essentials</span></h1>
        <p>Buy and sell textbooks, supplies, gadgets and more — all within your school community.</p>
        <div class="hero-buttons">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-hero-primary">Go to Dashboard →</a>
            @else
                <a href="{{ route('register') }}" class="btn-hero-primary">Start Selling Today →</a>
                <a href="{{ route('login') }}" class="btn-hero-outline">Browse Products</a>
            @endauth
        </div>
    </section>

    <section class="features">
        <p class="section-label">Why StudentMarket</p>
        <h2 class="section-title">Everything you need in one place</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="ti ti-shopping-bag"></i></div>
                <h3>Easy Browsing</h3>
                <p>Filter by category, condition, and price to find exactly what you need on campus.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="ti ti-shield-check"></i></div>
                <h3>Safe Payments</h3>
                <p>Pay via GCash or Cash on Delivery — no hidden fees, no surprises.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="ti ti-truck-delivery"></i></div>
                <h3>Order Tracking</h3>
                <p>Track every order from placement to delivery with real-time status updates.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="ti ti-star"></i></div>
                <h3>Verified Reviews</h3>
                <p>Leave and read honest reviews from fellow students before buying.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="ti ti-chart-bar"></i></div>
                <h3>Seller Dashboard</h3>
                <p>Track your listings, sales, and earnings all in one clean dashboard.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="ti ti-users"></i></div>
                <h3>Community First</h3>
                <p>A trusted marketplace built exclusively for your school community.</p>
            </div>
        </div>
    </section>

    <div class="roles">
        <div class="role-card buyer">
            <div class="role-emoji">🛍️</div>
            <h3>For Buyers</h3>
            <p>Browse hundreds of student listings. Add to cart, checkout, and track your orders with ease.</p>
            <a href="{{ route('register') }}" class="role-link">Start Shopping →</a>
        </div>
        <div class="role-card seller">
            <div class="role-emoji">📦</div>
            <h3>For Sellers</h3>
            <p>List your items in minutes. Manage inventory, track sales, and grow your earnings.</p>
            <a href="{{ route('register') }}" class="role-link">Start Selling →</a>
        </div>
        <div class="role-card admin">
            <div class="role-emoji">⚙️</div>
            <h3>For Admins</h3>
            <p>Monitor the platform, manage users and orders, and keep the marketplace running smoothly.</p>
            <a href="{{ route('login') }}" class="role-link">Admin Login →</a>
        </div>
    </div>

    <footer style="border-top:0.5px solid rgba(255,255,255,0.06);padding:32px 48px;display:flex;justify-content:center;align-items:center;">
        <p style="font-size:12px;color:rgba(255,255,255,0.3);">© {{ date('Y') }} StudentMarket. Built for school finals. 🎓</p>
    </footer>

</body>
</html>
