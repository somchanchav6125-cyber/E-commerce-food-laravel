<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // ទទួលយកអ៊ីមែល និងពាក្យសម្ងាត់ណាក៏បាន
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // យកអ្នកប្រើណាម្នាក់ (ឧ. អ្នកប្រើទី ១)
        $user = User::first();

        // បើគ្មានអ្នកប្រើទេ បង្កើតថ្មី (ឬត្រឡប់កំហុស)
        if (!$user) {
            return back()->withErrors([
                'email' => 'No user found. Please run seeder first.',
            ]);
        }

        // ចូលប្រើជាមួយអ្នកប្រើនេះ
        Auth::login($user, $request->filled('remember'));

        // បញ្ជូនទៅកាន់ទំព័រដើម
        return redirect()->intended('/dashboard');
    }
}
