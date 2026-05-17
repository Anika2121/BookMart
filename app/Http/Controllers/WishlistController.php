<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with(['book.category', 'book.reviews'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request, $bookId)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('book_id', $bookId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Removed from wishlist');
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'book_id' => $bookId,
        ]);

        return back()->with('success', 'Added to wishlist! ❤️');
    }
}