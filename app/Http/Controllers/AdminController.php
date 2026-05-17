<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers    = User::count();
        $totalBooks    = Book::count();
        $totalOrders   = Order::count();
        $totalRevenue  = Order::where('status', 'delivered')->sum('price');
        $pendingOrders = Order::where('status', 'pending')->count();

        $monthlyOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(price) as revenue')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $recentOrders = Order::with(['book', 'buyer', 'book.user'])
            ->latest()
            ->take(8)
            ->get();

        $recentUsers = User::latest()
            ->take(6)
            ->get();

        $deletionRequests = User::whereNotNull('delete_requested_at')
            ->latest('delete_requested_at')
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalBooks',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'monthlyOrders',
            'recentOrders',
            'recentUsers',
            'deletionRequests'
        ));
    }

    // Users Management
    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function banUser(User $user)
    {
        $user->update(['role' => 'banned']);
        return redirect()->back()->with('success', 'User banned successfully!');
    }

    public function unbanUser(User $user)
    {
        $user->update(['role' => 'buyer']);
        return redirect()->back()->with('success', 'User unbanned successfully!');
    }

    // Books Management
    public function books()
    {
        $books = Book::with(['seller', 'category'])->latest()->paginate(20);
        return view('admin.books', compact('books'));
    }

    public function approveBook(Book $book)
    {
        $book->update(['status' => 'available']);
        return redirect()->back()->with('success', 'Book approved!');
    }

    public function rejectBook(Book $book)
    {
        $book->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Book rejected!');
    }

    // Orders Management
    public function orders()
    {
        $orders = Order::with(['book', 'buyer'])->latest()->paginate(20);
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Order status updated!');
    }

    // Categories Management
    public function categories()
    {
        $categories = Category::latest()->get();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->back()->with('success', 'Category created!');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->back()->with('success', 'Category updated!');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted!');
    }
}