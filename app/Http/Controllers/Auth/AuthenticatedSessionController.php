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
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Display mock Google account chooser view.
     */
    public function googlePage(): View
    {
        return view('auth.google-mock');
    }

    /**
     * Authenticate user with selected mock Google account.
     */
    public function googleLogin(Request $request): RedirectResponse
    {
        $email = $request->input('email');

        if ($email === 'new') {
            $randomId = rand(100, 999);
            $user = \App\Models\User::create([
                'name' => 'Google User ' . $randomId,
                'email' => 'googleuser' . $randomId . '@gmail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'donatur',
                'status' => 'aktif'
            ]);
        } else {
            $user = \App\Models\User::where('email', $email)->first();
            if (!$user) {
                return redirect()->route('login')->withErrors(['email' => 'Akun tidak ditemukan.']);
            }
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Berhasil masuk menggunakan Google sebagai ' . $user->name . '!');
    }
}
