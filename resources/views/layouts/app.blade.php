<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'StudentMarket') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #F7F6F2;
            color: #1A1A1A;
            min-height: 100vh;
            display: flex;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 220px;
            background: #0E0E10;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: fixed;
            top: 0; left: 0;
            height: 100vh;
            z-index: 100;
            transition: width 0.3s ease;
        }
        .sidebar.collapsed { width: 60px; }

        .sidebar-top {
            padding: 20px 16px 14px;
            border-bottom: 0.5px solid rgba(255,255,255,0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo-wrap { display: flex; align-items: center; gap: 10px; overflow: hidden; }
        .logo-icon {
            width: 30px; height: 30px;
            background: #E8FF5A;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .logo-icon i { font-size: 16px; color: #0E0E10; }
        .logo-text {
            font-family: 'Syne', sans-serif;
            font-size: 14px; font-weight: 700;
            color: #fff;
            letter-spacing: -0.3px;
            white-space: nowrap;
            transition: opacity 0.2s;
        }
        .sidebar.collapsed .logo-text { opacity: 0; width: 0; overflow: hidden; }

        .toggle-btn {
            width: 26px; height: 26px;
            border-radius: 6px;
            background: rgba(255,255,255,0.05);
            border: 0.5px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            color: rgba(255,255,255,0.4);
            font-size: 12px;
            flex-shrink: 0;
            transition: background 0.15s;
        }
        .toggle-btn:hover { background: rgba(255,255,255,0.1); color: #fff; }

        .sidebar-nav { flex: 1; padding: 12px 8px; overflow-y: auto; overflow-x: hidden; }
        .sidebar-nav::-webkit-scrollbar { width: 0; }

        .nav-section-label {
            font-size: 10px; font-weight: 500;
            color: rgba(255,255,255,0.25);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 8px 10px 4px;
            white-space: nowrap;
            transition: opacity 0.2s;
        }
        .sidebar.collapsed .nav-section-label { opacity: 0; }

        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            margin-bottom: 2px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s;
            white-space: nowrap;
            overflow: hidden;
        }
        .nav-item:hover { background: rgba(255,255,255,0.05); }
        .nav-item.active { background: #E8FF5A; }
        .nav-item i { font-size: 17px; color: rgba(255,255,255,0.4); flex-shrink: 0; }
        .nav-item.active i { color: #0E0E10; }
        .nav-label { font-size: 13px; color: rgba(255,255,255,0.55); transition: opacity 0.2s; }
        .nav-item.active .nav-label { color: #0E0E10; font-weight: 500; }
        .sidebar.collapsed .nav-label { opacity: 0; width: 0; }

        .nav-divider { height: 0.5px; background: rgba(255,255,255,0.06); margin: 8px 10px; }

        .sidebar-footer {
            padding: 12px 8px;
            border-top: 0.5px solid rgba(255,255,255,0.06);
        }
        .user-pill {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            overflow: hidden;
        }
        .user-avatar {
            width: 28px; height: 28px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 600;
            color: white;
            flex-shrink: 0;
        }
        .user-info { overflow: hidden; transition: opacity 0.2s; }
        .sidebar.collapsed .user-info { opacity: 0; width: 0; }
        .user-name { font-size: 12px; font-weight: 500; color: rgba(255,255,255,0.8); white-space: nowrap; }
        .user-role { font-size: 10px; color: rgba(255,255,255,0.35); }

        /* ── Main ── */
        .main-wrapper {
            margin-left: 220px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        .main-wrapper.expanded { margin-left: 60px; }

        /* ── Topbar ── */
        .topbar {
            height: 52px;
            background: #fff;
            border-bottom: 0.5px solid #E8E6DF;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px;
            position: sticky; top: 0; z-index: 50;
            flex-shrink: 0;
        }
        .breadcrumb { font-size: 13px; color: #9E9B93; }
        .breadcrumb span { color: #1A1A1A; font-weight: 500; }
        .topbar-right { display: flex; align-items: center; gap: 8px; }
        .topbar-icon-btn {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: #F7F6F2;
            border: 0.5px solid #E8E6DF;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s;
        }
        .topbar-icon-btn:hover { background: #EDECEA; }
        .topbar-icon-btn i { font-size: 16px; color: #6B6860; }
        .logout-btn {
            display: flex; align-items: center; gap: 6px;
            padding: 6px 14px;
            border-radius: 8px;
            background: #FEF2F2;
            border: 0.5px solid #FECACA;
            color: #DC2626;
            font-size: 12px; font-weight: 500;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: background 0.15s;
        }
        .logout-btn:hover { background: #FEE2E2; }
        .logout-btn i { font-size: 15px; }

        /* ── Page content ── */
        .page-content { flex: 1; padding: 28px 28px; background: #F7F6F2; }

        /* ── Global reusable components ── */
        .page-header { margin-bottom: 24px; }
        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 24px; font-weight: 700;
            color: #1A1A1A;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }
        .page-subtitle { font-size: 13px; color: #9E9B93; }
        .glow-text { color: #1A1A1A; }

        .card {
            background: #fff;
            border-radius: 12px;
            border: 0.5px solid #E8E6DF;
            padding: 20px;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .card:hover { border-color: #C4C1B8; }
        .card-link { text-decoration: none; display: block; }

        .glass { background: #fff; border-radius: 12px; border: 0.5px solid #E8E6DF; padding: 20px; }
        .glass-card { background: #fff; border-radius: 12px; border: 0.5px solid #E8E6DF; padding: 20px; transition: border-color 0.15s; text-decoration: none; display: block; }
        .glass-card:hover { border-color: #C4C1B8; }

        .btn-primary {
            background: #0E0E10;
            color: #E8FF5A;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500; font-size: 13px;
            border: none; cursor: pointer;
            transition: opacity 0.15s;
            display: inline-block; text-decoration: none;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-primary:hover { opacity: 0.85; }
        .btn-danger {
            background: #FEF2F2; color: #DC2626;
            border: 0.5px solid #FECACA;
            padding: 8px 16px; border-radius: 8px;
            font-weight: 500; font-size: 12px; cursor: pointer;
            transition: background 0.15s;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-danger:hover { background: #FEE2E2; }
        .btn-outline {
            background: transparent; color: #6B6860;
            border: 0.5px solid #E8E6DF;
            padding: 8px 16px; border-radius: 8px;
            font-size: 12px; cursor: pointer;
            transition: border-color 0.15s;
            text-decoration: none; display: inline-block;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-outline:hover { border-color: #C4C1B8; color: #1A1A1A; }

        .input-dark {
            background: #F7F6F2;
            border: 0.5px solid #E8E6DF;
            border-radius: 8px;
            color: #1A1A1A;
            padding: 10px 14px;
            width: 100%; font-size: 13px;
            transition: border-color 0.15s;
            outline: none;
            font-family: 'DM Sans', sans-serif;
        }
        .input-dark:focus { border-color: #0E0E10; background: #fff; }
        .input-dark::placeholder { color: #C4C1B8; }
        select.input-dark option { background: #fff; }

        .badge-success { background: #F0FDF4; color: #16A34A; border: 0.5px solid #BBF7D0; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 500; }
        .badge-warning { background: #FFFBEB; color: #D97706; border: 0.5px solid #FDE68A; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 500; }
        .badge-danger  { background: #FEF2F2; color: #DC2626; border: 0.5px solid #FECACA; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 500; }
        .badge-info    { background: #EFF6FF; color: #2563EB; border: 0.5px solid #BFDBFE; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 500; }

        .alert-success { background: #F0FDF4; border: 0.5px solid #BBF7D0; color: #16A34A; padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }
        .alert-error   { background: #FEF2F2; border: 0.5px solid #FECACA; color: #DC2626; padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E8E6DF; border-radius: 2px; }
        #review-modal { display: none; }
        #review-modal:not(.hidden) { display: flex; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-top">
            <div class="logo-wrap">
                <div class="logo-icon"><i class="ti ti-bolt"></i></div>
                <span class="logo-text">StudentMarket</span>
            </div>
            <div class="toggle-btn" id="toggleBtn" onclick="toggleSidebar()">
                <i class="ti ti-chevron-left" id="toggleIcon"></i>
            </div>
        </div>

        <nav class="sidebar-nav">

            <div class="nav-section-label">Main</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="ti ti-layout-dashboard"></i>
                <span class="nav-label">Dashboard</span>
            </a>

          @if(auth()->user()->role === 'buyer')
            <div class="nav-section-label" style="margin-top:8px">Shopping</div>
            <a href="{{ route('buyer.products.index') }}" class="nav-item {{ request()->routeIs('buyer.products.*') ? 'active' : '' }}">
                <i class="ti ti-shopping-bag"></i>
                <span class="nav-label">Browse Products</span>
            </a>
            <a href="{{ route('buyer.cart.index') }}" class="nav-item {{ request()->routeIs('buyer.cart.*') ? 'active' : '' }}">
                <i class="ti ti-shopping-cart"></i>
                <span class="nav-label">My Cart</span>
            </a>
            <a href="{{ route('buyer.orders.index') }}" class="nav-item {{ request()->routeIs('buyer.orders.*') ? 'active' : '' }}">
                <i class="ti ti-package"></i>
                <span class="nav-label">My Orders</span>
            </a>
            <a href="{{ route('messages.index') }}" class="nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}" style="position:relative;">
                <i class="ti ti-message-2"></i>
                <span class="nav-label">Messages</span>
                @php $unreadMsgs = App\Models\Message::where('receiver_id', auth()->id())->where('is_read', false)->count(); @endphp
                @if($unreadMsgs > 0)
                <span style="position:absolute;top:6px;left:28px;background:#E8FF5A;color:#0E0E10;font-size:9px;font-weight:700;width:14px;height:14px;border-radius:50%;display:flex;align-items:center;justify-content:center;">{{ $unreadMsgs }}</span>
                @endif
            </a>
            @endif

            @if(auth()->user()->role === 'seller')
            <div class="nav-divider"></div>
            <div class="nav-section-label">Seller Tools</div>
            <a href="{{ route('seller.products.index') }}" class="nav-item {{ request()->routeIs('seller.products.index') ? 'active' : '' }}">
                <i class="ti ti-notes"></i>
                <span class="nav-label">My Listings</span>
            </a>

            <a href="{{ route('seller.sales.index') }}" class="nav-item {{ request()->routeIs('seller.sales.*') ? 'active' : '' }}">
    <i class="ti ti-chart-arrows"></i>
    <span class="nav-label">My Sales</span>
</a>
            <a href="{{ route('messages.index') }}" class="nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}" style="position:relative;">
                <i class="ti ti-message-2"></i>
                <span class="nav-label">Messages</span>
                @php $unreadMsgs = App\Models\Message::where('receiver_id', auth()->id())->where('is_read', false)->count(); @endphp
                @if($unreadMsgs > 0)
                <span style="position:absolute;top:6px;left:28px;background:#E8FF5A;color:#0E0E10;font-size:9px;font-weight:700;width:14px;height:14px;border-radius:50%;display:flex;align-items:center;justify-content:center;">{{ $unreadMsgs }}</span>
                @endif
            </a>

            <a href="{{ route('seller.products.create') }}" class="nav-item {{ request()->routeIs('seller.products.create') ? 'active' : '' }}">
                <i class="ti ti-plus"></i>
                <span class="nav-label">Add Product</span>
            </a>
            @endif

            @if(auth()->user()->role === 'admin')
            <div class="nav-section-label" style="margin-top:8px">Admin Panel</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="ti ti-chart-bar"></i>
                <span class="nav-label">Overview</span>
            </a>
            <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="ti ti-users"></i>
                <span class="nav-label">Manage Users</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="nav-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                <i class="ti ti-clipboard-list"></i>
                <span class="nav-label">Manage Orders</span>
            </a>
            @endif

            <div class="nav-divider"></div>
            <div class="nav-section-label">Account</div>
            <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="ti ti-user"></i>
                <span class="nav-label">Profile</span>
            </a>

        </nav>

        <div class="sidebar-footer">
            <div class="user-pill">
                @php
                    $role = auth()->user()->role;
                    $avatarBg = ['buyer' => '#059669', 'seller' => '#2563EB', 'admin' => '#DC2626'];
                @endphp
                <div class="user-avatar" style="background: {{ $avatarBg[$role] ?? '#7C3AED' }}">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ ucfirst($role) }}</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper" id="mainWrapper">

        <!-- TOPBAR -->
        <div class="topbar">
            <div class="breadcrumb">
                StudentMarket / <span>{{ request()->segment(1) ? ucfirst(request()->segment(1)) : 'Dashboard' }}</span>
            </div>
            <div class="topbar-right">
                @if(auth()->user()->role !== 'admin')
                <a href="{{ route('buyer.cart.index') }}" class="topbar-icon-btn" title="Cart" style="position:relative;">
                    <i class="ti ti-shopping-cart"></i>
                    @php $cartCount = auth()->check() ? \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity') : 0; @endphp
                    @if($cartCount > 0)
                    <span style="position:absolute;top:-4px;right:-4px;background:#E8FF5A;color:#0E0E10;font-size:10px;font-weight:700;width:16px;height:16px;border-radius:50%;display:flex;align-items:center;justify-content:center;line-height:1;">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                    @endif
                </a>
                @endif
                <div style="position:relative;" id="notif-wrapper">
                    <button onclick="toggleNotifications()" class="topbar-icon-btn" title="Notifications" style="position:relative;">
                        <i class="ti ti-bell"></i>
                        <span id="notif-badge" style="display:none;position:absolute;top:-4px;right:-4px;background:#E8FF5A;color:#0E0E10;font-size:10px;font-weight:700;width:16px;height:16px;border-radius:50%;align-items:center;justify-content:center;line-height:1;"></span>
                    </button>
                    <div id="notif-dropdown" style="display:none;position:absolute;top:48px;right:0;width:320px;background:white;border:0.5px solid #e5e7eb;border-radius:16px;box-shadow:0 8px 32px rgba(0,0,0,0.12);z-index:9999;overflow:hidden;">
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 16px;border-bottom:1px solid #f1f5f9;">
                            <span style="font-size:13px;font-weight:600;color:#0f172a;">Notifications</span>
                            <button onclick="markAllRead()" style="font-size:11px;color:#94a3b8;background:none;border:none;cursor:pointer;">Mark all read</button>
                        </div>
                        <div id="notif-list" style="max-height:320px;overflow-y:auto;">
                            <p style="padding:20px;text-align:center;font-size:13px;color:#94a3b8;">Loading...</p>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="ti ti-logout"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- PAGE CONTENT -->
        <div class="page-content">
            {{ $slot }}
        </div>

    </div>

    <script>
        let collapsed = localStorage.getItem('sidebarCollapsed') === 'true';

        function applyState() {
            const sidebar = document.getElementById('sidebar');
            const wrapper = document.getElementById('mainWrapper');
            const icon    = document.getElementById('toggleIcon');
            if (collapsed) {
                sidebar.classList.add('collapsed');
                wrapper.classList.add('expanded');
                icon.className = 'ti ti-chevron-right';
            } else {
                sidebar.classList.remove('collapsed');
                wrapper.classList.remove('expanded');
                icon.className = 'ti ti-chevron-left';
            }
        }

        function toggleSidebar() {
            collapsed = !collapsed;
            localStorage.setItem('sidebarCollapsed', collapsed);
            applyState();
        }

        applyState();
    </script>

{{-- Global Toast --}}
    @if(session('success') || session('error'))
    <div id="toast" style="position:fixed;top:24px;right:24px;z-index:9999;padding:14px 20px;border-radius:12px;font-size:13px;font-weight:500;display:flex;align-items:center;gap:10px;box-shadow:0 4px 24px rgba(0,0,0,0.12);animation:toastIn 0.3s ease;max-width:360px;{{ session('success') ? 'background:#f0fdf4;color:#16a34a;border:0.5px solid #bbf7d0;' : 'background:#fef2f2;color:#dc2626;border:0.5px solid #fecaca;' }}">
        <span style="font-size:18px;">{{ session('success') ? '✅' : '❌' }}</span>
        <span>{{ session('success') ?? session('error') }}</span>
        <span onclick="document.getElementById('toast').remove()" style="margin-left:8px;cursor:pointer;opacity:0.5;font-size:16px;">✕</span>
    </div>
    <style>@keyframes toastIn { from { transform:translateY(20px);opacity:0; } to { transform:translateY(0);opacity:1; } }</style>
    <script>setTimeout(() => { const t = document.getElementById('toast'); if(t){ t.style.transition='opacity 0.3s';t.style.opacity='0';setTimeout(()=>t.remove(),300); } }, 4000);</script>
    @endif

    
{{-- Global Toast --}}
    @if(session('success') || session('error'))
    <div id="toast" style="position:fixed;top:24px;right:24px;z-index:9999;padding:14px 20px;border-radius:12px;font-size:13px;font-weight:500;display:flex;align-items:center;gap:10px;box-shadow:0 4px 24px rgba(0,0,0,0.12);animation:toastIn 0.3s ease;max-width:360px;{{ session('success') ? 'background:#f0fdf4;color:#16a34a;border:0.5px solid #bbf7d0;' : 'background:#fef2f2;color:#dc2626;border:0.5px solid #fecaca;' }}">
        <span style="font-size:18px;">{{ session('success') ? '✅' : '❌' }}</span>
        <span>{{ session('success') ?? session('error') }}</span>
        <span onclick="document.getElementById('toast').remove()" style="margin-left:8px;cursor:pointer;opacity:0.5;font-size:16px;">✕</span>
    </div>
    <style>@keyframes toastIn { from { transform:translateY(20px);opacity:0; } to { transform:translateY(0);opacity:1; } }</style>
    <script>setTimeout(() => { const t = document.getElementById('toast'); if(t){ t.style.transition='opacity 0.3s';t.style.opacity='0';setTimeout(()=>t.remove(),300); } }, 4000);</script>
    @endif



</html><script>
function toggleNotifications() {
    var d = document.getElementById("notif-dropdown");
    if (d.style.display === "none" || d.style.display === "") {
        d.style.display = "block";
        loadNotifications();
    } else {
        d.style.display = "none";
    }
}
function loadNotifications() {
    fetch("/notifications")
        .then(function(r){ return r.json(); })
        .then(function(data){
            var list = document.getElementById("notif-list");
            var badge = document.getElementById("notif-badge");
            if (!list || !badge) return;
            var unread = data.filter(function(n){ return !n.is_read; }).length;
            if (unread > 0) {
                badge.style.display = "flex";
                badge.textContent = unread > 9 ? "9+" : unread;
            } else {
                badge.style.display = "none";
            }
            if (data.length === 0) {
                list.innerHTML = "<p style='padding:20px;text-align:center;font-size:13px;color:#94a3b8'>No notifications yet.</p>";
                return;
            }
            var html = "";
            data.forEach(function(n) {
                var bg = n.is_read ? "#ffffff" : "#f0fdf4";
                html += "<div data-id='" + n.id + "' data-link='" + (n.link || '') + "' class='notif-item' style='padding:12px 16px;border-bottom:1px solid #f8fafc;cursor:pointer;background:" + bg + "'>";
                html += "<p style='font-size:13px;font-weight:600;color:#0f172a;margin:0 0 2px'>" + n.title + "</p>";
                html += "<p style='font-size:12px;color:#64748b;margin:0'>" + n.message + "</p>";
                html += "</div>";
            });
            list.innerHTML = html;
        });
}
function readNotif(id, link) {
    var token = document.querySelector("meta[name=csrf-token]").content;
    fetch("/notifications/" + id + "/read", {
        method: "POST",
        headers: { "X-CSRF-TOKEN": token, "Content-Type": "application/json" }
    }).then(function(){
        if (link) window.location.href = link;
        else loadNotifications();
    });
}
function markAllRead() {
    var token = document.querySelector("meta[name=csrf-token]").content;
    fetch("/notifications/read-all", {
        method: "POST",
        headers: { "X-CSRF-TOKEN": token, "Content-Type": "application/json" }
    }).then(function(){ loadNotifications(); });
}
document.addEventListener("click", function(e) {
    var wrapper = document.getElementById("notif-wrapper");
    var dropdown = document.getElementById("notif-dropdown");
    if (wrapper && dropdown && !wrapper.contains(e.target)) {
        dropdown.style.display = "none";
    }
});
document.addEventListener("click", function(e) {
    var item = e.target.closest(".notif-item");
    if (item) {
        var id = item.getAttribute("data-id");
        var link = item.getAttribute("data-link");
        readNotif(id, link);
    }
});
window.addEventListener("load", function(){ loadNotifications(); });
</script>
</body>
</html>

<!-- Chatbot -->
<div id="chat-bubble" onclick="toggleChat()" style="position:fixed;bottom:24px;right:24px;width:52px;height:52px;background:#E8FF5A;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 4px 20px rgba(0,0,0,0.2);z-index:9999;transition:transform 0.2s;">
    <i class="ti ti-message-chatbot" style="font-size:22px;color:#0E0E10;"></i>
</div>

<div id="chat-window" style="display:none;position:fixed;bottom:88px;right:24px;width:320px;background:white;border-radius:20px;box-shadow:0 8px 40px rgba(0,0,0,0.15);z-index:9999;overflow:hidden;flex-direction:column;">
    <div style="background:#0E0E10;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;">
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:32px;height:32px;background:#E8FF5A;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                <i class="ti ti-robot" style="font-size:16px;color:#0E0E10;"></i>
            </div>
            <div>
                <p style="font-size:13px;font-weight:600;color:white;margin:0;">StudentMarket Bot</p>
                <p style="font-size:11px;color:rgba(255,255,255,0.4);margin:0;">Always here to help</p>
            </div>
        </div>
        <button onclick="toggleChat()" style="background:none;border:none;color:rgba(255,255,255,0.5);cursor:pointer;font-size:18px;">✕</button>
    </div>

    <div id="chat-messages" style="height:280px;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:10px;background:#f8fafc;">
        <div class="bot-msg">👋 Hi! I'm the StudentMarket assistant. Ask me anything about how to use the marketplace!</div>
        <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:4px;">
            <button class="chat-chip" onclick="askBot('How do I place an order?')">How do I order?</button>
            <button class="chat-chip" onclick="askBot('What payment methods are available?')">Payment methods</button>
            <button class="chat-chip" onclick="askBot('How do I add a product?')">Add a product</button>
            <button class="chat-chip" onclick="askBot('How do I track my order?')">Track order</button>
            <button class="chat-chip" onclick="askBot('How do I cancel an order?')">Cancel order</button>
            <button class="chat-chip" onclick="askBot('How do I contact the seller?')">Contact seller</button>
        </div>
    </div>

    <div style="padding:12px;border-top:1px solid #e5e7eb;display:flex;gap:8px;background:white;">
        <input id="chat-input" type="text" placeholder="Type a question..."
            onkeydown="if(event.key==='Enter') sendChat()"
            style="flex:1;border:1px solid #e5e7eb;border-radius:10px;padding:8px 12px;font-size:13px;outline:none;">
        <button onclick="sendChat()" style="background:#E8FF5A;border:none;border-radius:10px;padding:8px 12px;cursor:pointer;font-weight:600;font-size:13px;">→</button>
    </div>
</div>

<style>
.bot-msg {
    background:white;
    border:1px solid #e5e7eb;
    border-radius:12px 12px 12px 2px;
    padding:10px 14px;
    font-size:13px;
    color:#0f172a;
    max-width:85%;
    line-height:1.5;
}
.user-msg {
    background:#0E0E10;
    color:white;
    border-radius:12px 12px 2px 12px;
    padding:10px 14px;
    font-size:13px;
    max-width:85%;
    align-self:flex-end;
    line-height:1.5;
}
.chat-chip {
    background:#f1f5f9;
    border:1px solid #e2e8f0;
    border-radius:20px;
    padding:5px 12px;
    font-size:11px;
    cursor:pointer;
    color:#475569;
    transition:background 0.15s;
}
.chat-chip:hover { background:#E8FF5A; color:#0E0E10; border-color:#E8FF5A; }
</style>

<script>
function toggleChat() {
    var w = document.getElementById("chat-window");
    w.style.display = w.style.display === "none" || w.style.display === "" ? "flex" : "none";
}

function askBot(question) {
    addMessage(question, "user");
    setTimeout(function(){ addMessage(getBotReply(question), "bot"); }, 400);
}

function sendChat() {
    var input = document.getElementById("chat-input");
    var text = input.value.trim();
    if (!text) return;
    input.value = "";
    addMessage(text, "user");
    setTimeout(function(){ addMessage(getBotReply(text), "bot"); }, 400);
}

function addMessage(text, type) {
    var msgs = document.getElementById("chat-messages");
    var div = document.createElement("div");
    div.className = type === "bot" ? "bot-msg" : "user-msg";
    div.textContent = text;
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
}

function getBotReply(msg) {
    var m = msg.toLowerCase().trim();

    if (m === "hi" || m === "hello" || m === "hey" || m === "hi!" || m === "hello!")
        return "Hi there! 👋 I am the StudentMarket assistant. How can I help you today?";

    if (m.includes("thank"))
        return "You are welcome! 😊 Let me know if you have other questions.";

    if ((m.includes("contact") || m.includes("message") || m.includes("chat")) && m.includes("seller"))
        return "You can message a seller! Go to My Orders, find the order, and click Message Seller. Check your Messages inbox in the sidebar too. 💬";

    if ((m.includes("place") && m.includes("order")) || (m.includes("how") && (m.includes("buy") || m.includes("purchase") || m.includes("order a product"))) || m.includes("add to cart"))
        return "To place an order: Browse products → click a product → set quantity → Add to Cart → Proceed to Checkout → enter address → choose payment → confirm. Done! 🎉";

    if (m.includes("gcash") || m.includes("cod") || m.includes("cash on delivery") || (m.includes("payment") && (m.includes("method") || m.includes("how") || m.includes("what"))) || (m.includes("how") && m.includes("pay")))
        return "We support two payment methods: 💛 GCash - pay and enter your reference number. 💵 Cash on Delivery (COD) - pay cash when your order arrives. Both available at checkout!";

    if ((m.includes("track") || m.includes("where") || m.includes("status")) && (m.includes("order") || m.includes("package")))
        return "To track your order: go to My Orders in the sidebar. Each order shows its status - Pending, Processing, Shipped, or Delivered. The seller updates it as your order progresses.";

    if (m.includes("cancel") && m.includes("order"))
        return "To cancel: go to My Orders and click Cancel Order on a Pending order. You can only cancel Pending orders - once Processing or Shipped, cancellation is no longer available.";

    if (m.includes("cart") || (m.includes("add") && m.includes("item")))
        return "To manage your cart: click the cart icon in the top bar. You can remove items or proceed to checkout. The badge shows how many items you have.";

    if ((m.includes("add") && m.includes("product")) || (m.includes("how") && m.includes("sell")) || m.includes("list a product"))
        return "To add a product: log in as Seller → go to My Listings → click Add Product → fill in title, description, price, stock → upload image → Save. Your product goes live immediately!";

    if (m.includes("register") || m.includes("sign up") || m.includes("create account"))
        return "To register: click Sign Up on the homepage → enter name, email, password → choose Buyer or Seller role → submit. You are in! 🎓";

    if (m.includes("refund") || m.includes("return") || m.includes("money back"))
        return "For refunds: cancel your Pending order from My Orders. For delivered orders, message the seller through Messages or contact your school admin.";

    if (m.includes("stock") || m.includes("out of stock") || (m.includes("available") && m.includes("product")))
        return "Stock is shown on each product page. If Out of Stock you cannot add it to cart. Sellers update stock regularly so check back soon!";

    if (m.includes("message") || m.includes("inbox"))
        return "You can message sellers about your orders! Go to My Orders → click Message Seller. Your full inbox is in the Messages section of the sidebar. 💬";

    if (m.includes("checkout") || m.includes("check out"))
        return "To checkout: go to Cart → Proceed to Checkout → enter shipping address → choose GCash or COD → confirm. You will be redirected to My Orders after!";

    if (m.includes("ship") || m.includes("deliver") || m.includes("address"))
        return "Enter your shipping address at checkout. The seller updates your order to Shipped once dispatched. Track it under My Orders.";

    if (m.includes("hi") || m.includes("hello") || m.includes("hey"))
        return "Hi there! 👋 I am the StudentMarket assistant. Ask me anything about orders, payment, or selling!";

    return "I am not sure about that. Try asking about: placing an order, payment methods, tracking orders, messaging a seller, cancelling an order, or adding a product. 😊";
}
</script>
