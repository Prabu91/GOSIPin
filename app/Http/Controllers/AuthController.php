<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 2)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));

            return back()->withErrors([
                'npp' => "Terlalu banyak percobaan login. Silakan coba lagi dalam $seconds detik."
            ])->withInput();
        }

        $credentials = $request->only('npp', 'password');
        $user = User::where('npp', $credentials['npp'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            RateLimiter::clear($this->throttleKey($request));
            return redirect()->intended('/dashboard')->with('success', 'Login Berhasil!');
        }

        RateLimiter::hit($this->throttleKey($request), 180); 

        return back()->withErrors([
            'npp' => 'NPP atau password salah!'
        ])->withInput();
    }

    private function throttleKey(Request $request)
{
    return Str::lower($request->input('npp')) . '|' . $request->ip();
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logout Berhasil!');
    }
}
