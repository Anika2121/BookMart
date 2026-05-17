<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect(string $provider)
    {
        abort_unless(in_array($provider, ['google', 'facebook']), 404);
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        abort_unless(in_array($provider, ['google', 'facebook']), 404);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Social login failed. Please try again.');
        }

        $field = $provider . '_id';

        $user = User::where($field, $socialUser->getId())
            ->orWhere('email', $socialUser->getEmail())
            ->first();

        if ($user) {
            // Banned check
            if ($user->is_banned) {
                return redirect()->route('login')
                    ->with('error', 'Your account has been banned.');
            }
            $user->update([$field => $socialUser->getId()]);
        } else {
            $user = User::create([
                'name'     => $socialUser->getName(),
                'email'    => $socialUser->getEmail(),
                'password' => bcrypt(\Str::random(32)),
                'role'     => 'buyer',
                $field     => $socialUser->getId(),
                'photo'    => $socialUser->getAvatar(),
            ]);
        }

        Auth::login($user, true);

        return redirect()->route('books.index')
            ->with('success', 'Welcome, ' . $user->name . '! 📚');
    }
}