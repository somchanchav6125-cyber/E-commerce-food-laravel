<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // ✅ Check user exists (must register first)
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'អ្នកត្រូវចុះឈ្មោះសិន មុនចូលប្រើ។'
            ])->withInput();
        }

        // ✅ Check password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'ពាក្យសម្ងាត់មិនត្រឹមត្រូវ'
            ])->withInput();
        }

        // ✅ Login user
        Auth::login($user);

        $request->session()->regenerate();

    return redirect()->intended('/home');
    }
}
