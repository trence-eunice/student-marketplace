<x-app-layout>
    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="page-title">Messages</h1>
                <p class="page-subtitle">Your conversations about orders.</p>
            </div>

            @forelse($conversations as $msg)
            @php
                $user = auth()->user();
                $isBuyer = $msg->order->user_id === $user->id;
                $otherUser = $isBuyer
                    ? App\Models\User::find($msg->seller_id)
                    : $msg->order->user;
                $unread = App\Models\Message::where('order_id', $msg->order_id)
                    ->where('seller_id', $msg->seller_id)
                    ->where('receiver_id', $user->id)
                    ->where('is_read', false)
                    ->count();
            @endphp
            <a href="{{ route('messages.show', [$msg->order_id, $msg->seller_id]) }}" style="text-decoration:none;">
                <div class="card rounded-xl p-4 mb-3 flex items-center gap-4" style="{{ $unread > 0 ? 'border:1px solid #E8FF5A;' : '' }}">
                    <div style="width:44px;height:44px;background:#E8FF5A;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#0E0E10;font-size:16px;flex-shrink:0;">
                        {{ strtoupper(substr($otherUser->name ?? '?', 0, 1)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <p style="font-size:14px;font-weight:600;margin:0;">{{ $otherUser->name ?? 'Unknown' }}</p>
                            <p style="font-size:11px;color:var(--muted);margin:0;">{{ $msg->created_at->diffForHumans() }}</p>
                        </div>
                        <p style="font-size:12px;color:var(--muted);margin:2px 0 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            Order {{ $msg->order->order_number }} · {{ $msg->body }}
                        </p>
                    </div>
                    @if($unread > 0)
                    <span style="background:#E8FF5A;color:#0E0E10;font-size:10px;font-weight:700;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">{{ $unread }}</span>
                    @endif
                </div>
            </a>
            @empty
            <div class="card p-10 text-center">
                <p class="text-lg font-semibold mb-2">No messages yet</p>
                <p class="text-sm" style="color: var(--muted)">Messages about your orders will appear here.</p>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
