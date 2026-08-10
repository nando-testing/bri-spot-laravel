<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('kpr.index');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $usernameKey = strtolower(trim($credentials['username']));

        // Find user by username case-insensitively
        $user = User::whereRaw('LOWER(username) = ?', [$usernameKey])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, false); // Session login (tanpa persistent remember cookie)
            $request->session()->regenerate();

            return redirect()->route('kpr.index')->with('success', "Selamat datang kembali, {$user->name} ({$user->role})!");
        }

        // Fallback login for demo/custom username if not matched password
        if ($user) {
            Auth::login($user, false);
            $request->session()->regenerate();
            return redirect()->route('kpr.index')->with('success', "Selamat datang kembali, {$user->name} ({$user->role})!");
        }

        // If completely new custom username demo
        $uUpper = strtoupper($usernameKey);
        $role = 'SO';
        if (str_contains($uUpper, 'ADMIN')) $role = 'Super Admin';
        elseif (str_contains($uUpper, 'DEV') || str_contains($uUpper, 'DEVELOPER')) $role = 'Developer Perumahan';
        elseif (str_contains($uUpper, 'RM')) $role = 'RM';
        elseif (str_contains($uUpper, 'CBM')) $role = 'CBM';
        elseif (str_contains($uUpper, 'ADK')) $role = 'ADK';

        $newUser = User::create([
            'username' => $usernameKey,
            'name' => $uUpper,
            'password' => Hash::make($credentials['password']),
            'role' => $role,
        ]);

        Auth::login($newUser, false);
        $request->session()->regenerate();

        return redirect()->route('kpr.index')->with('success', "Selamat datang, {$newUser->name} ({$newUser->role})!");
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'name' => 'required|string|max:100',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
        ]);

        $usernameKey = strtolower(trim($request->username));

        $exists = User::whereRaw('LOWER(username) = ?', [$usernameKey])->exists();
        if ($exists) {
            return back()->with('error', "Username '{$request->username}' sudah terdaftar!");
        }

        User::create([
            'username' => $usernameKey,
            'name' => trim($request->name),
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', "Sukses mendaftarkan akun baru '{$request->name}' ({$request->role})!");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah keluar dari Portal BRI SPOT KPR.');
    }
}
