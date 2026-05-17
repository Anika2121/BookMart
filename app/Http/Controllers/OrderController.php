<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Mail\OrderPlacedMail;
use App\Mail\OrderShippedMail;
use App\Mail\OrderConfirmedBuyer;
use App\Mail\OrderConfirmedSeller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        $total = array_sum(array_column($cart, 'subtotal'));
        return view('orders.checkout', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|min:10',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        foreach ($cart as $item) {
            $book = Book::find($item['id']);
            if ($book && $book->status == 'available') {
                $order = Order::create([
                    'buyer_id'         => auth()->id(),
                    'book_id'          => $book->id,
                    'price'            => $book->price,
                    'status'           => 'pending',
                    'shipping_address' => $request->shipping_address,
                ]);
                $book->update(['status' => 'sold']);

                try {
    Mail::to(auth()->user()->email)->send(new OrderConfirmedBuyer($order));
    Mail::to($order->book->user->email)->send(new OrderConfirmedSeller($order));
} catch (\Exception $e) {
    // Order will still be created even if mail fails
}
            }
        }

        session()->forget('cart');
        return redirect()->route('orders.my')->with('success', 'Order placed successfully! 🎉');
    }

    public function myOrders()
    {
        $orders = Order::with(['book.user'])
            ->where('buyer_id', auth()->id())
            ->latest()
            ->get();
        return view('orders.my', compact('orders'));
    }

    public function receivedOrders()
    {
        $orders = Order::with(['book', 'buyer'])
            ->whereHas('book', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->latest()
            ->get();
        return view('orders.received', compact('orders'));
    }

    // ── Buyer: Cancel (only when pending) ──────────────────
    public function cancelOrder(Order $order)
    {
        // Ownership check
        if ($order->buyer_id !== auth()->id()) {
            abort(403, 'This order does not belong to you.');
        }

        // Can only cancel when pending
        if ($order->status !== 'pending') {
            return back()->with('error', 'This order can no longer be cancelled. The seller has already processed it.');
        }

        // Make book available again
        $order->book->update(['status' => 'available']);
        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order has been successfully cancelled.');
    }

    // ── Seller: Status Update ────────────────────────────
    public function updateStatus(Request $request, Order $order)
    {
        // Seller ownership check
        if ($order->book->user_id !== auth()->id()) {
            abort(403, 'This order does not belong to you.');
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

// Auto update book status
if ($request->status === 'delivered') {
    $order->book->update(['status' => 'sold']);
} elseif ($request->status === 'cancelled') {
    $order->book->update(['status' => 'available']);
}

        try {
            if ($request->status === 'shipped') {
                Mail::to($order->buyer->email)->send(new OrderShippedMail($order));
            }
        } catch (\Exception $e) {
            // Status will still be updated even if mail fails
        }

        return back()->with('success', 'Order status updated! ✅');
    }
}