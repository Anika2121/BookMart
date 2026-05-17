<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    public function dashboard()
    {
        $books = Book::where('user_id', auth()->id())
            ->with('reviews')
            ->latest()
            ->get();

        $totalEarnings = Order::whereHas('book', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->where('status', 'delivered')
            ->sum('price');

        $totalSales = Order::whereHas('book', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->where('status', 'delivered')
            ->count();

        $recentOrders = Order::with(['book', 'buyer'])
            ->whereHas('book', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->latest()
            ->take(5)
            ->get();

        $pendingOrdersCount = Order::whereHas('book', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->where('status', 'pending')
            ->count();

        // Monthly earnings for chart (last 6 months)
        $monthlyEarnings = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $earning = Order::whereHas('book', function($q) {
                    $q->where('user_id', auth()->id());
                })
                ->where('status', 'delivered')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('price');
            $monthlyEarnings[] = [
                'month' => $month->format('M'),
                'earning' => (float) $earning,
            ];
        }

        return view('seller.dashboard', compact(
            'books', 'totalEarnings', 'totalSales',
            'recentOrders', 'pendingOrdersCount', 'monthlyEarnings'
        ));
    }

    public function toggleAvailability(Book $book)
    {
        if ($book->user_id != auth()->id()) abort(403);
        $book->update([
            'status' => $book->status === 'available' ? 'sold' : 'available'
        ]);
        return redirect()->back()->with('success', 'Book status updated!');
    }

    public function profile()
    {
        $user = auth()->user();
        $totalBooks    = Book::where('user_id', $user->id)->count();
        $totalSales    = Order::whereHas('book', fn($q) => $q->where('user_id', $user->id))->where('status','delivered')->count();
        $totalEarnings = Order::whereHas('book', fn($q) => $q->where('user_id', $user->id))->where('status','delivered')->sum('price');
        $avgRating     = Book::where('user_id', $user->id)->withAvg('reviews','rating')->get()->avg('reviews_avg_rating');
        return view('seller.profile', compact('user','totalBooks','totalSales','totalEarnings','avgRating'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name'   => 'required|string|max:255',
            'phone'  => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name'  => $request->name,
            'phone' => $request->phone,
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::delete($user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);
        return back()->with('success', 'Profile updated successfully! ✅');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        auth()->user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password updated successfully! ✅');
    }
}