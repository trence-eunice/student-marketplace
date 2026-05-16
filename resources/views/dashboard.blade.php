<x-app-layout>
    <div class="content-z">

        {{-- BUYER DASHBOARD --}}
        @if(auth()->user()->role === 'buyer')

        <div style="margin-bottom:32px;">
            <h1 style="font-size:24px;font-weight:700;color:#0f172a;margin:0 0 4px;">Welcome back, {{ auth()->user()->name }} 👋</h1>
            <p style="font-size:14px;color:#64748b;margin:0;">Browse products, manage your cart and track your orders.</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
            <a href="{{ route('buyer.products.index') }}" style="background:white;border-radius:16px;padding:24px;text-decoration:none;border:1px solid #f1f5f9;display:block;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'" onmouseout="this.style.boxShadow='none'">
                <div style="width:48px;height:48px;border-radius:12px;background:#eff6ff;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:16px;">🛍️</div>
                <div style="font-size:15px;font-weight:600;color:#0f172a;margin-bottom:4px;">Browse Products</div>
                <div style="font-size:13px;color:#94a3b8;">Find items from students</div>
                <div style="margin-top:16px;font-size:13px;color:#3b82f6;font-weight:500;">Explore →</div>
            </a>
            <a href="{{ route('buyer.cart.index') }}" style="background:white;border-radius:16px;padding:24px;text-decoration:none;border:1px solid #f1f5f9;display:block;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'" onmouseout="this.style.boxShadow='none'">
                <div style="width:48px;height:48px;border-radius:12px;background:#faf5ff;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:16px;">🛒</div>
                <div style="font-size:15px;font-weight:600;color:#0f172a;margin-bottom:4px;">My Cart</div>
                <div style="font-size:13px;color:#94a3b8;">View & checkout items</div>
                <div style="margin-top:16px;font-size:13px;color:#8b5cf6;font-weight:500;">View Cart →</div>
            </a>
            <a href="{{ route('buyer.orders.index') }}" style="background:white;border-radius:16px;padding:24px;text-decoration:none;border:1px solid #f1f5f9;display:block;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'" onmouseout="this.style.boxShadow='none'">
                <div style="width:48px;height:48px;border-radius:12px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:16px;">📦</div>
                <div style="font-size:15px;font-weight:600;color:#0f172a;margin-bottom:4px;">My Orders</div>
                <div style="font-size:13px;color:#94a3b8;">Track your purchases</div>
                <div style="margin-top:16px;font-size:13px;color:#22c55e;font-weight:500;">Track Orders →</div>
            </a>
        </div>

        {{-- SELLER DASHBOARD --}}
        @elseif(auth()->user()->role === 'seller')

        <div style="margin-bottom:32px;">
            <h1 style="font-size:24px;font-weight:700;color:#0f172a;margin:0 0 4px;">Welcome back, {{ auth()->user()->name }} 👋</h1>
            <p style="font-size:14px;color:#64748b;margin:0;">Manage your listings and track your sales.</p>
        </div>

        @php
            $myProducts    = \App\Models\Product::where('user_id', auth()->id())->count();
            $soldItems     = \App\Models\OrderItem::whereHas('product', fn($q) => $q->where('user_id', auth()->id()))
                                ->whereHas('order', fn($q) => $q->whereNotIn('status', ['cancelled']))
                                ->get();
            $totalEarnings = $soldItems->sum(fn($i) => $i->price * $i->quantity);
            $totalSold     = $soldItems->sum('quantity');
            $recentSales   = \App\Models\OrderItem::whereHas('product', fn($q) => $q->where('user_id', auth()->id()))
                                ->whereHas('order', fn($q) => $q->whereNotIn('status', ['cancelled']))
                                ->with(['product', 'order.user'])
                                ->latest()
                                ->take(5)
                                ->get();
        @endphp

        {{-- Stats Row --}}
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">
            <div style="background:white;border-radius:16px;padding:24px;border:1px solid #f1f5f9;">
                <div style="font-size:12px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:8px;">My Products</div>
                <div style="font-size:36px;font-weight:700;color:#6366f1;line-height:1;">{{ $myProducts }}</div>
                <div style="font-size:13px;color:#94a3b8;margin-top:6px;">Total listings</div>
            </div>
            <div style="background:white;border-radius:16px;padding:24px;border:1px solid #f1f5f9;">
                <div style="font-size:12px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:8px;">Items Sold</div>
                <div style="font-size:36px;font-weight:700;color:#3b82f6;line-height:1;">{{ $totalSold }}</div>
                <div style="font-size:13px;color:#94a3b8;margin-top:6px;">Total units sold</div>
            </div>
            <div style="background:white;border-radius:16px;padding:24px;border:1px solid #f1f5f9;">
                <div style="font-size:12px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:8px;">Total Earnings</div>
                <div style="font-size:28px;font-weight:700;color:#22c55e;line-height:1;">₱{{ number_format($totalEarnings, 2) }}</div>
                <div style="font-size:13px;color:#94a3b8;margin-top:6px;">Excluding cancelled</div>
            </div>
            <a href="{{ route('seller.products.create') }}" style="background:#0f172a;border-radius:16px;padding:24px;text-decoration:none;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:10px;border:1px solid #0f172a;" onmouseover="this.style.background='#1e293b'" onmouseout="this.style.background='#0f172a'">
                <div style="font-size:28px;">➕</div>
                <div style="font-size:14px;font-weight:600;color:white;">Add New Product</div>
            </a>
        </div>

        {{-- Recent Sales --}}
        @if($recentSales->count())
        <div style="background:white;border-radius:16px;padding:24px;border:1px solid #f1f5f9;margin-bottom:24px;">
            <div style="font-size:15px;font-weight:600;color:#0f172a;margin-bottom:16px;">Recent Sales</div>
            <table style="width:100%;font-size:13px;border-collapse:collapse;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="text-align:left;padding:8px 12px;color:#64748b;font-weight:500;">Product</th>
                        <th style="text-align:left;padding:8px 12px;color:#64748b;font-weight:500;">Buyer</th>
                        <th style="text-align:left;padding:8px 12px;color:#64748b;font-weight:500;">Qty</th>
                        <th style="text-align:left;padding:8px 12px;color:#64748b;font-weight:500;">Earned</th>
                        <th style="text-align:left;padding:8px 12px;color:#64748b;font-weight:500;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentSales as $sale)
                    <tr style="border-top:1px solid #f1f5f9;">
                        <td style="padding:10px 12px;font-weight:500;">{{ $sale->product->title }}</td>
                        <td style="padding:10px 12px;color:#64748b;">{{ $sale->order->user->name }}</td>
                        <td style="padding:10px 12px;">{{ $sale->quantity }}</td>
                        <td style="padding:10px 12px;font-weight:600;color:#22c55e;">₱{{ number_format($sale->price * $sale->quantity, 2) }}</td>
                        <td style="padding:10px 12px;">
                            <span style="font-size:11px;padding:3px 10px;border-radius:6px;font-weight:500;
                                @if($sale->order->status === 'pending') background:#fffbeb;color:#d97706;
                                @elseif($sale->order->status === 'delivered') background:#f0fdf4;color:#16a34a;
                                @else background:#eff6ff;color:#2563eb;
                                @endif">
                                {{ ucfirst($sale->order->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- Action Cards --}}
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;">
            <a href="{{ route('seller.products.index') }}" style="background:white;border-radius:16px;padding:24px;text-decoration:none;border:1px solid #f1f5f9;display:block;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'" onmouseout="this.style.boxShadow='none'">
                <div style="width:48px;height:48px;border-radius:12px;background:#fff7ed;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:16px;">📝</div>
                <div style="font-size:15px;font-weight:600;color:#0f172a;margin-bottom:4px;">My Listings</div>
                <div style="font-size:13px;color:#94a3b8;">Manage your products</div>
                <div style="margin-top:16px;font-size:13px;color:#f97316;font-weight:500;">Manage →</div>
            </a>
            <a href="{{ route('seller.products.create') }}" style="background:white;border-radius:16px;padding:24px;text-decoration:none;border:1px solid #f1f5f9;display:block;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'" onmouseout="this.style.boxShadow='none'">
                <div style="width:48px;height:48px;border-radius:12px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:16px;">➕</div>
                <div style="font-size:15px;font-weight:600;color:#0f172a;margin-bottom:4px;">Add Product</div>
                <div style="font-size:13px;color:#94a3b8;">List a new item for sale</div>
                <div style="margin-top:16px;font-size:13px;color:#22c55e;font-weight:500;">Add Now →</div>
            </a>
        </div>

        {{-- ADMIN DASHBOARD --}}
        @elseif(auth()->user()->role === 'admin')

        <div style="margin-bottom:32px;">
            <h1 style="font-size:24px;font-weight:700;color:#0f172a;margin:0 0 4px;">Admin Overview ⚙️</h1>
            <p style="font-size:14px;color:#64748b;margin:0;">Monitor and manage the entire StudentMarket platform.</p>
        </div>

        @php
            $totalUsers    = \App\Models\User::count();
            $totalProducts = \App\Models\Product::count();
            $totalOrders   = \App\Models\Order::count();
            $pendingOrders = \App\Models\Order::where('status','pending')->count();
        @endphp

        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">
            <div style="background:white;border-radius:16px;padding:24px;border:1px solid #f1f5f9;">
                <div style="font-size:12px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:8px;">Total Users</div>
                <div style="font-size:36px;font-weight:700;color:#6366f1;line-height:1;">{{ $totalUsers }}</div>
            </div>
            <div style="background:white;border-radius:16px;padding:24px;border:1px solid #f1f5f9;">
                <div style="font-size:12px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:8px;">Total Products</div>
                <div style="font-size:36px;font-weight:700;color:#3b82f6;line-height:1;">{{ $totalProducts }}</div>
            </div>
            <div style="background:white;border-radius:16px;padding:24px;border:1px solid #f1f5f9;">
                <div style="font-size:12px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:8px;">Total Orders</div>
                <div style="font-size:36px;font-weight:700;color:#22c55e;line-height:1;">{{ $totalOrders }}</div>
            </div>
            <div style="background:white;border-radius:16px;padding:24px;border:1px solid #f1f5f9;">
                <div style="font-size:12px;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:8px;">Pending Orders</div>
                <div style="font-size:36px;font-weight:700;color:#eab308;line-height:1;">{{ $pendingOrders }}</div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
            <a href="{{ route('admin.users') }}" style="background:white;border-radius:16px;padding:24px;text-decoration:none;border:1px solid #f1f5f9;display:block;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'" onmouseout="this.style.boxShadow='none'">
                <div style="width:48px;height:48px;border-radius:12px;background:#faf5ff;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:16px;">👥</div>
                <div style="font-size:15px;font-weight:600;color:#0f172a;margin-bottom:4px;">Manage Users</div>
                <div style="font-size:13px;color:#94a3b8;">View all registered accounts</div>
                <div style="margin-top:16px;font-size:13px;color:#8b5cf6;font-weight:500;">View Users →</div>
            </a>
            <a href="{{ route('admin.orders') }}" style="background:white;border-radius:16px;padding:24px;text-decoration:none;border:1px solid #f1f5f9;display:block;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'" onmouseout="this.style.boxShadow='none'">
                <div style="width:48px;height:48px;border-radius:12px;background:#fefce8;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:16px;">🗂️</div>
                <div style="font-size:15px;font-weight:600;color:#0f172a;margin-bottom:4px;">Manage Orders</div>
                <div style="font-size:13px;color:#94a3b8;">View all platform orders</div>
                <div style="margin-top:16px;font-size:13px;color:#eab308;font-weight:500;">View Orders →</div>
            </a>
            <a href="{{ route('admin.dashboard') }}" style="background:white;border-radius:16px;padding:24px;text-decoration:none;border:1px solid #f1f5f9;display:block;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'" onmouseout="this.style.boxShadow='none'">
                <div style="width:48px;height:48px;border-radius:12px;background:#fff1f2;display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:16px;">📊</div>
                <div style="font-size:15px;font-weight:600;color:#0f172a;margin-bottom:4px;">Full Overview</div>
                <div style="font-size:13px;color:#94a3b8;">Detailed system stats</div>
                <div style="margin-top:16px;font-size:13px;color:#ef4444;font-weight:500;">View Stats →</div>
            </a>
        </div>

        @endif
    </div>
</x-app-layout>
