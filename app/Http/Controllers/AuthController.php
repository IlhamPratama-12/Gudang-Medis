<?php

// app/Http/Controllers/AuthController.php
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        if (!$this->authService->attemptLogin($request->validated())) {
            return back()->withErrors([
                'email' => 'Email atau password salah'
            ]);
        }

        session(['login_success' => true]);

        return redirect()->route('splash');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
