<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirect user to Google
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function callback()
    {
        // If user is already authenticated, redirect to home
        if (Auth::check()) {
            return redirect('/');
        }

        try {
            // 👉 Get user from Google
            $googleUser = Socialite::driver('google')->user();

            // 🔍 Check user by google_id
            $user = User::where('google_id', $googleUser->getId())->first();

            // 🔍 If not found → check by email
            if (!$user) {
                $user = User::where('email', $googleUser->getEmail())->first();

                if ($user) {
                    // 🔗 Link Google account
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                }
            }

            // 🆕 If still no user → create new account (AUTO REGISTER)
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName() ?? 'Google User',
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt(uniqid()), // random password
                ]);
            }

            // 🔄 Update avatar if empty
            if (!$user->avatar && $googleUser->getAvatar()) {
                $user->update([
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }

            // 🔐 Login user
            Auth::login($user, true);

            // Regenerate session to prevent fixation attacks
            session()->regenerate();

            // ✅ Redirect to HOME directly using header to avoid any middleware redirect
            return redirect()->away('/');

        } catch (Exception $e) {
            Log::error('Google Login Error: ' . $e->getMessage());
            return redirect()->route('home')
                ->with('error', 'Google login failed: ' . $e->getMessage());
        }
    }
}
