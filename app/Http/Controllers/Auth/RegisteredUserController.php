<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
        ], [
            'name.required' => 'សូមបញ្ចូលឈ្មោះរបស់អ្នក',
            'email.required' => 'សូមបញ្ចូល email',
            'email.email' => 'Email មិនត្រឹមត្រូវ',
            'email.unique' => 'Email នេះមានប្រើប្រាស់រួចហើយ',
            'password.required' => 'សូមបញ្ចូលពាក្យសម្ងាត់',
            'password.min' => 'ពាក្យសម្ងាត់ត្រូវមានយ៉ាងតិច ៨ តួអក្សរ',
            'password.confirmed' => 'ពាក្យសម្ងាត់មិនដូចគ្នា',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'ការចុះឈ្មោះជោគជ័យ! សូម login ដើម្បីចូលប្រើប្រាស់។');
    }
}
