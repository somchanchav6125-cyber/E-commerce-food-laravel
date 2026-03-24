<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    // Show login page
    public function create()
    {
        return view('auth.login');
    }

    // Login
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'អ្នកត្រូវចុះឈ្មោះសិន មុនចូលប្រើ។'
            ])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'ពាក្យសម្ងាត់មិនត្រឹមត្រូវ'
            ])->withInput();
        }

        Auth::login($user);

        $request->session()->regenerate();

        // គ្រប់គ្នាត្រឡប់ទៅ Home ដូចគ្នា
        return redirect()->route('home');
    }

    // Logout
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
