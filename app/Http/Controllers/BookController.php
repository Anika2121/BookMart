<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['category', 'user', 'reviews'])
            ->where('status', 'available');

        // ── Search ────────────────────────────────────
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title',     'like', '%' . $request->search . '%')
                  ->orWhere('author',    'like', '%' . $request->search . '%')
                  ->orWhere('isbn',      'like', '%' . $request->search . '%')
                  ->orWhere('publisher', 'like', '%' . $request->search . '%');
            });
        }

        // ── Filters ───────────────────────────────────
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->condition) {
            $query->where('condition', $request->condition);
        }

        if ($request->language) {
            $query->where('language', $request->language);
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // ── Smart Sort ────────────────────────────────
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')
                      ->orderByDesc('reviews_avg_rating');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'best_sellers':
                $query->orderByDesc('order_count');
                break;
            case 'most_viewed':
                $query->orderByDesc('view_count');
                break;
            default:
                // Smart ranking — featured first, then by score
                $query->orderByDesc('is_featured')
                      ->orderByDesc('score')
                      ->orderByDesc('created_at');
        }

        // ── Rating Filter ─────────────────────────────
        if ($request->min_rating) {
            $query->withAvg('reviews', 'rating')
                  ->having('reviews_avg_rating', '>=', $request->min_rating);
        }

        $books      = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        $totalBooks = Book::where('status', 'available')->count();
        $languages  = Book::where('status', 'available')
                          ->distinct()
                          ->pluck('language')
                          ->filter()
                          ->values();

        // ── Featured Books ────────────────────────────
        $featuredBooks = Book::with(['category', 'user', 'reviews'])
            ->where('status', 'available')
            ->where('is_featured', true)
            ->orderByDesc('score')
            ->take(4)
            ->get();

        // ── Best Sellers ──────────────────────────────
        $bestSellers = Book::with(['category', 'user', 'reviews'])
            ->where('status', 'available')
            ->where('order_count', '>', 0)
            ->orderByDesc('order_count')
            ->take(6)
            ->get();

        // ── New Arrivals ──────────────────────────────
        $newArrivals = Book::with(['category', 'user', 'reviews'])
            ->where('status', 'available')
            ->latest()
            ->take(6)
            ->get();

        // ── Top Rated ─────────────────────────────────
        $topRated = Book::with(['category', 'user', 'reviews'])
            ->where('status', 'available')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->take(6)
            ->get();

        // ── Compare List ──────────────────────────────
        $compareList = session()->get('compare', []);

        return view('books.index', compact(
            'books', 'categories', 'totalBooks', 'languages',
            'compareList', 'featuredBooks', 'bestSellers',
            'newArrivals', 'topRated'
        ));
    }

    public function show(Book $book)
    {
        $book->load(['category', 'user', 'reviews.user']);

        // ── View Count Increment ──────────────────────
        $book->increment('view_count');
        $book->updateScore();

        // ── Recently Viewed ───────────────────────────
        $recentlyViewed = session()->get('recently_viewed', []);

        if (!in_array($book->id, $recentlyViewed)) {
            array_unshift($recentlyViewed, $book->id);
            $recentlyViewed = array_slice($recentlyViewed, 0, 6);
            session()->put('recently_viewed', $recentlyViewed);
        }

        // ── Recommended (same category) ───────────────
        $recommended = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->where('status', 'available')
            ->with(['category', 'reviews'])
            ->orderByDesc('score')
            ->take(4)
            ->get();

        // ── Recently Viewed Books ─────────────────────
        $recentBooks = Book::whereIn('id', array_diff($recentlyViewed, [$book->id]))
            ->where('status', 'available')
            ->with(['category', 'reviews'])
            ->take(5)
            ->get();

        // ── Wishlist check ────────────────────────────
        $isWishlisted = auth()->check()
            ? $book->isWishlistedBy(auth()->id())
            : false;

        // ── Compare List ──────────────────────────────
        $compareList = session()->get('compare', []);

        return view('books.show', compact(
            'book', 'recommended', 'recentBooks', 'isWishlisted', 'compareList'
        ));
    }

    // ── Compare ───────────────────────────────────────
    public function addToCompare(Book $book)
    {
        $compare = session()->get('compare', []);

        if (count($compare) >= 3) {
            return back()->with('error', 'Maximum 3 books can be compared.');
        }

        if (!in_array($book->id, $compare)) {
            $compare[] = $book->id;
            session()->put('compare', $compare);
        }

        return back()->with('success', '"' . $book->title . '" added to compare list.');
    }

    public function removeFromCompare(Book $book)
    {
        $compare = session()->get('compare', []);
        $compare = array_values(array_filter($compare, fn($id) => $id !== $book->id));
        session()->put('compare', $compare);

        return back()->with('success', 'Removed from compare list.');
    }

    public function compare()
    {
        $compareIds = session()->get('compare', []);

        if (count($compareIds) < 2) {
            return redirect()->route('books.index')
                ->with('error', 'Select at least 2 books to compare.');
        }

        $books = Book::whereIn('id', $compareIds)
            ->with(['category', 'reviews'])
            ->get();

        return view('books.compare', compact('books'));
    }

    // ── Seller: Create ────────────────────────────────
    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'isbn'           => 'nullable|string|max:20',
            'publisher'      => 'nullable|string|max:255',
            'language'       => 'nullable|string|max:50',
            'pages'          => 'nullable|integer|min:1',
            'published_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'sample_pages'   => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'condition'      => 'required|in:New,Like New,Good,Fair,Poor',
            'category_id'    => 'required|exists:categories,id',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
        }

        $book = Book::create([
            'title'          => $request->title,
            'author'         => $request->author,
            'isbn'           => $request->isbn,
            'publisher'      => $request->publisher,
            'language'       => $request->language ?? 'Bangla',
            'pages'          => $request->pages,
            'published_year' => $request->published_year,
            'sample_pages'   => $request->sample_pages,
            'price'          => $request->price,
            'condition'      => $request->condition,
            'category_id'    => $request->category_id,
            'description'    => $request->description,
            'image'          => $imagePath,
            'user_id'        => auth()->id(),
            'status'         => 'available',
        ]);

        // Calculate initial score
        $book->updateScore();

        return redirect()->route('seller.dashboard')
            ->with('success', 'Book listed successfully!');
    }

    // ── Seller: Edit ──────────────────────────────────
    public function edit(Book $book)
    {
        if ($book->user_id !== auth()->id()) {
            abort(403, 'This book does not belong to you.');
        }
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        if ($book->user_id !== auth()->id()) {
            abort(403, 'This book does not belong to you.');
        }

        $request->validate([
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'isbn'           => 'nullable|string|max:20',
            'publisher'      => 'nullable|string|max:255',
            'language'       => 'nullable|string|max:50',
            'pages'          => 'nullable|integer|min:1',
            'published_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'sample_pages'   => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'condition'      => 'required|in:New,Like New,Good,Fair,Poor',
            'category_id'    => 'required|exists:categories,id',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $book->image = $request->file('image')->store('books', 'public');
        }

        $oldPrice = (float) $book->price;

        $book->update([
            'title'          => $request->title,
            'author'         => $request->author,
            'isbn'           => $request->isbn,
            'publisher'      => $request->publisher,
            'language'       => $request->language ?? 'Bangla',
            'pages'          => $request->pages,
            'published_year' => $request->published_year,
            'sample_pages'   => $request->sample_pages,
            'price'          => $request->price,
            'condition'      => $request->condition,
            'category_id'    => $request->category_id,
            'description'    => $request->description,
            'image'          => $book->image,
        ]);

        $book->refresh();
        $book->notifyPriceDrop($oldPrice);
        $book->updateScore();

        return redirect()->route('seller.dashboard')
            ->with('success', 'Book updated successfully!');
    }

    // ── Seller: Destroy ───────────────────────────────
    public function destroy(Book $book)
    {
        if ($book->user_id !== auth()->id()) {
            abort(403, 'This book does not belong to you.');
        }

        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return redirect()->route('seller.dashboard')
            ->with('success', 'Book deleted successfully!');
    }
}