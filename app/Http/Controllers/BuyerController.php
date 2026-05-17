<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BuyerController extends Controller
{
    public function dashboard()
    {
        $user      = auth()->user();
        $orders    = $user->buyerOrders()->latest()->take(5)->get();
        $addresses = $user->addresses()->get();

        return view('buyer.dashboard', compact('user', 'orders', 'addresses'));
    }

    public function editProfile()
    {
        $user      = auth()->user();
        $addresses = $user->addresses()->latest()->get();

        return view('buyer.profile', compact('user', 'addresses'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')
                ->store('profile-photos', 'public');
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function requestDeletion()
    {
        $user = auth()->user();

        if ($user->hasRequestedDeletion()) {
            return back()->with('info', 'Your deletion request is already pending.');
        }

        $user->update(['delete_requested_at' => now()]);

        return back()->with('success', 'Your account will be automatically deleted after 7 days. You can cancel within this period.');
    }

    public function cancelDeletion()
    {
        auth()->user()->update(['delete_requested_at' => null]);

        return back()->with('success', 'Account deletion has been canceled.');
    }
}