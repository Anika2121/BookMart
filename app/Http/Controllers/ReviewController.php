<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $bookId)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Check if buyer has purchased this book
        $hasPurchased = Order::where('buyer_id', auth()->id())
            ->where('book_id', $bookId)
            ->where('status', 'delivered')
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Only verified buyers who received the book can review!');
        }

        // Check if already reviewed
        $alreadyReviewed = Review::where('user_id', auth()->id())
            ->where('book_id', $bookId)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'You have already reviewed this book!');
        }

        Review::create([
            'book_id' => $bookId,
            'user_id' => auth()->id(),
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        // Update book score after new review
        $book = Book::find($bookId);
        if ($book) {
            $book->updateScore();
        }

        return back()->with('success', 'Review submitted successfully! ⭐');
    }
}