<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user         = Auth::user();
        $selectedRole = $request->input('role', 'buyer');

        // Role mismatch — logout immediately
        if ($selectedRole !== $user->role) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $messages = [
                'buyer'  => 'This account is not a Buyer account. Please select the correct role.',
                'seller' => 'This account is not a Seller account. Please select the correct role.',
                'admin'  => 'This account is not an Admin account. Please select the correct role.',
            ];

            return back()
                ->withInput($request->only('email', 'role'))
                ->withErrors(['email' => $messages[$selectedRole] ?? 'Role mismatch. Please select the correct role.']);
        }

        // Redirect by role
        return match($user->role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'seller' => redirect()->route('seller.dashboard'),
            default  => redirect()->route('buyer.dashboard'),
        };
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}