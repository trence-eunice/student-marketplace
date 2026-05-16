<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Order;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    

    public function index()
    {
        $user = auth()->user();
        $conversations = \App\Models\Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['order', 'sender', 'receiver'])
            ->get()
            ->groupBy(fn($m) => $m->order_id . '-' . $m->seller_id)
            ->map(fn($msgs) => $msgs->sortByDesc('created_at')->first())
            ->sortByDesc('created_at')
            ->values();
        return view('messages.index', compact('conversations'));
    }

    public function show(Order $order, $sellerId)
    {
        $user = auth()->user();

        $isBuyer = $order->user_id === $user->id;
        $isSeller = $order->orderItems()
            ->whereHas('product', fn($q) => $q->where('user_id', $user->id))
            ->exists();

        if (!$isBuyer && !$isSeller) abort(403);

        $seller = User::findOrFail($sellerId);

        $messages = Message::where('order_id', $order->id)
            ->where('seller_id', $sellerId)
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        // Mark as read
        Message::where('order_id', $order->id)
            ->where('seller_id', $sellerId)
            ->where('receiver_id', $user->id)
            ->update(['is_read' => true]);

        $otherUser = $isBuyer ? $seller : $order->user;

        return view('messages.show', compact('order', 'messages', 'otherUser', 'seller'));
    }

    public function store(Request $request, Order $order, $sellerId = null)
    {
        $user = auth()->user();

        $isBuyer = $order->user_id === $user->id;
        $isSeller = $order->orderItems()
            ->whereHas('product', fn($q) => $q->where('user_id', $user->id))
            ->exists();

        if (!$isBuyer && !$isSeller) abort(403);

        $request->validate(['body' => 'required|string|max:1000']);

        $sellerId = (int) $sellerId;
        $receiverId = $isBuyer ? $sellerId : $order->user_id;

        Message::create([
            'order_id'    => $order->id,
            'seller_id'   => $sellerId,
            'sender_id'   => $user->id,
            'receiver_id' => $receiverId,
            'body'        => $request->body,
        ]);

        Notification::create([
            'user_id' => $receiverId,
            'title'   => 'New Message',
            'message' => $user->name . ' sent you a message about order ' . $order->order_number,
            'link'    => '/messages/' . $order->id . '/' . $sellerId,
        ]);

        return redirect()->route('messages.show', [$order, $sellerId])->with('success', 'Message sent!');
    }

    public function fetch(Order $order, $sellerId)
    {
        $user = auth()->user();

        $isBuyer = $order->user_id === $user->id;
        $isSeller = $order->orderItems()
            ->whereHas('product', fn($q) => $q->where('user_id', $user->id))
            ->exists();

        if (!$isBuyer && !$isSeller) abort(403);

        $messages = Message::where('order_id', $order->id)
            ->where('seller_id', $sellerId)
            ->with('sender')
            ->orderBy('created_at')
            ->get()
            ->map(fn($m) => [
                'id'      => $m->id,
                'body'    => $m->body,
                'sender'  => $m->sender->name,
                'is_mine' => $m->sender_id === $user->id,
                'time'    => $m->created_at->format('h:i A'),
            ]);

        Message::where('order_id', $order->id)
            ->where('seller_id', $sellerId)
            ->where('receiver_id', $user->id)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }
}
