<?php
// app/Services/AuthService.php
namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function attemptLogin(array $credentials): bool
    {
        // 🔥 kunci utama di sini
        $credentials['status'] = 'approved';

        if (!Auth::attempt($credentials)) {
            return false;
        }

        request()->session()->regenerate();
        return true;
    }

    public function redirectByRole()
    {
        // 🔥 cukup satu pintu
        return route('dashboard');
    }
}
