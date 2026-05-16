<?php
$file = 'resources/views/layouts/app.blade.php';
$content = file_get_contents($file);

// Add Messages link after My Orders (buyer)
$content = str_replace(
    '<a href="{{ route(\'buyer.orders.index\') }}" class="nav-item {{ request()->routeIs(\'buyer.orders.*\') ? \'active\' : \'\' }}">
                <i class="ti ti-package"></i>
                <span class="nav-label">My Orders</span>
            </a>',
    '<a href="{{ route(\'buyer.orders.index\') }}" class="nav-item {{ request()->routeIs(\'buyer.orders.*\') ? \'active\' : \'\' }}">
                <i class="ti ti-package"></i>
                <span class="nav-label">My Orders</span>
            </a>
            <a href="{{ route(\'messages.index\') }}" class="nav-item {{ request()->routeIs(\'messages.*\') ? \'active\' : \'\' }}" style="position:relative;">
                <i class="ti ti-message-2"></i>
                <span class="nav-label">Messages</span>
                @php $unreadMsgs = App\Models\Message::where(\'receiver_id\', auth()->id())->where(\'is_read\', false)->count(); @endphp
                @if($unreadMsgs > 0)
                <span style="position:absolute;top:6px;left:28px;background:#E8FF5A;color:#0E0E10;font-size:9px;font-weight:700;width:14px;height:14px;border-radius:50%;display:flex;align-items:center;justify-content:center;">{{ $unreadMsgs }}</span>
                @endif
            </a>',
    $content
);

// Add Messages link after My Sales (seller)
$content = str_replace(
    '<a href="{{ route(\'seller.sales.index\') }}" class="nav-item {{ request()->routeIs(\'seller.sales.*\') ? \'active\' : \'\' }}">
    <i class="ti ti-chart-arrows"></i>
    <span class="nav-label">My Sales</span>
</a>',
    '<a href="{{ route(\'seller.sales.index\') }}" class="nav-item {{ request()->routeIs(\'seller.sales.*\') ? \'active\' : \'\' }}">
    <i class="ti ti-chart-arrows"></i>
    <span class="nav-label">My Sales</span>
</a>
            <a href="{{ route(\'messages.index\') }}" class="nav-item {{ request()->routeIs(\'messages.*\') ? \'active\' : \'\' }}" style="position:relative;">
                <i class="ti ti-message-2"></i>
                <span class="nav-label">Messages</span>
                @php $unreadMsgs = App\Models\Message::where(\'receiver_id\', auth()->id())->where(\'is_read\', false)->count(); @endphp
                @if($unreadMsgs > 0)
                <span style="position:absolute;top:6px;left:28px;background:#E8FF5A;color:#0E0E10;font-size:9px;font-weight:700;width:14px;height:14px;border-radius:50%;display:flex;align-items:center;justify-content:center;">{{ $unreadMsgs }}</span>
                @endif
            </a>',
    $content
);

file_put_contents($file, $content);
echo "Done!\n";
