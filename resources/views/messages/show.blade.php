<x-app-layout>
    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center gap-3">
                <a href="{{ url()->previous() }}" style="color:var(--muted);font-size:13px;">← Back</a>
            </div>

            <div class="card rounded-xl overflow-hidden">
                <!-- Header -->
                <div style="background:#0E0E10;padding:16px 20px;display:flex;align-items:center;gap:12px;">
                    <div style="width:36px;height:36px;background:#E8FF5A;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:#0E0E10;font-size:14px;">
                        {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                    </div>
                    <div>
                        <p style="font-size:14px;font-weight:600;color:white;margin:0;">{{ $otherUser->name }}</p>
                        <p style="font-size:11px;color:rgba(255,255,255,0.4);margin:0;">Order {{ $order->order_number }}</p>
                    </div>
                </div>

                <!-- Messages -->
                <div id="msg-list" style="height:400px;overflow-y:auto;padding:20px;display:flex;flex-direction:column;gap:12px;background:#f8fafc;">
                    @foreach($messages as $msg)
                        @if($msg->sender_id === auth()->id())
                            <div style="align-self:flex-end;background:#0E0E10;color:white;border-radius:16px 16px 2px 16px;padding:10px 16px;max-width:75%;font-size:13px;line-height:1.5;">
                                {{ $msg->body }}
                                <p style="font-size:10px;color:rgba(255,255,255,0.4);margin:4px 0 0;text-align:right;">{{ $msg->created_at->format('h:i A') }}</p>
                            </div>
                        @else
                            <div style="align-self:flex-start;background:white;border:1px solid #e5e7eb;border-radius:16px 16px 16px 2px;padding:10px 16px;max-width:75%;font-size:13px;line-height:1.5;color:#0f172a;">
                                {{ $msg->body }}
                                <p style="font-size:10px;color:#94a3b8;margin:4px 0 0;">{{ $msg->created_at->format('h:i A') }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Input -->
                <form method="POST" action="{{ route('messages.store', [$order->id, $seller->id]) }}" style="padding:16px;border-top:1px solid #e5e7eb;display:flex;gap:10px;background:white;">
                    @csrf
                    <input type="text" name="body" placeholder="Type a message..." required
                        style="flex:1;border:1px solid #e5e7eb;border-radius:10px;padding:10px 14px;font-size:13px;outline:none;">
                    <button type="submit" style="background:#E8FF5A;border:none;border-radius:10px;padding:10px 20px;font-weight:600;font-size:13px;cursor:pointer;">Send</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Scroll to bottom on load
        var list = document.getElementById("msg-list");
        list.scrollTop = list.scrollHeight;
    </script>
</x-app-layout>
