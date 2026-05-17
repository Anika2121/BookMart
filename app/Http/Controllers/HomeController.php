<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $featuredBooks = Cache::remember('home_featured', 600, fn() =>
            Book::with(['category:id,name', 'user:id,name'])
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->where('status', 'available')
                ->where('is_featured', true)
                ->orderByDesc('score')
                ->take(4)
                ->get()
        );

        if ($featuredBooks->isEmpty()) {
            $featuredBooks = Cache::remember('home_featured_fallback', 600, fn() =>
                Book::with(['category:id,name', 'user:id,name'])
                    ->withAvg('reviews', 'rating')
                    ->withCount('reviews')
                    ->where('status', 'available')
                    ->orderByDesc('score')
                    ->take(4)
                    ->get()
            );
        }

        $bestSellers = Cache::remember('home_best_sellers', 600, fn() =>
            Book::with(['category:id,name'])
                ->withAvg('reviews', 'rating')
                ->where('status', 'available')
                ->orderByDesc('order_count')
                ->orderByDesc('score')
                ->take(6)
                ->get()
        );

        $topRatedBooks = Cache::remember('home_top_rated', 600, fn() =>
            Book::with(['category:id,name'])
                ->withAvg('reviews', 'rating')
                ->withCount('reviews')
                ->where('status', 'available')
                ->orderByDesc('reviews_avg_rating')
                ->take(4)
                ->get()
                ->map(function ($book) {
                    $book->avg_rating   = round($book->reviews_avg_rating ?? 0, 1);
                    $book->review_count = $book->reviews_count ?? 0;
                    return $book;
                })
        );

        $latestBooks = Cache::remember('home_latest', 300, fn() =>
            Book::with(['category:id,name'])
                ->withAvg('reviews', 'rating')
                ->where('status', 'available')
                ->latest()
                ->take(8)
                ->get()
                ->map(function ($book) {
                    $book->avg_rating   = round($book->reviews_avg_rating ?? 0, 1);
                    $book->review_count = $book->reviews_count ?? 0;
                    return $book;
                })
        );

        $mostViewed = Cache::remember('home_most_viewed', 600, fn() =>
            Book::with(['category:id,name'])
                ->withAvg('reviews', 'rating')
                ->where('status', 'available')
                ->orderByDesc('view_count')
                ->take(6)
                ->get()
        );

        $categories = Cache::remember('home_categories', 3600, fn() =>
            Category::withCount('books')->get()
        );

        $totalBooks = Cache::remember('total_books', 300, fn() =>
            Book::where('status', 'available')->count()
        );

        $totalSold = Cache::remember('total_sold', 300, fn() =>
            Book::where('status', 'sold')->count()
        );

        return view('home', compact(
            'featuredBooks', 'bestSellers', 'topRatedBooks',
            'latestBooks', 'mostViewed', 'categories',
            'totalBooks', 'totalSold'
        ));
    }
}