<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewHelpfulVote;
use Illuminate\Http\Request;

class ReviewHelpfulController extends Controller
{
    public function toggle(Review $review)
    {
        $userId = auth()->id();

        $existing = ReviewHelpfulVote::where('review_id', $review->id)
            ->where('user_id', $userId)
            ->first();

        if ($existing) {
            $existing->delete();
            $review->decrement('helpful_count');
            $message = 'Vote removed.';
        } else {
            ReviewHelpfulVote::create([
                'review_id' => $review->id,
                'user_id'   => $userId,
            ]);
            $review->increment('helpful_count');
            $message = 'Marked as helpful!';
        }

        return back()->with('success', $message);
    }
}