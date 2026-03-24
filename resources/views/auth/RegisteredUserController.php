<?php
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

// ក្នុង method store()
// ក្នុង method store()
$request->validate([
    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    'password' => ['required', 'confirmed'], // លែងតម្រូវ min:8
]);

$user = User::create([
    'name' => explode('@', $request->email)[0], // យកផ្នែកខាងមុខ @ ធ្វើជាឈ្មោះ
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role' => 'user',
]);
