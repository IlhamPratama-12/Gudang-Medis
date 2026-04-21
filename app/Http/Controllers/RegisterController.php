<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function form()
    {
        return view('auth.regist');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'nip'   => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'role'  => 'required',
        ]);

        User::create([
            'name'   => $request->name,
            'nip'    => $request->nip,
            'email'  => $request->email,
            'role'   => $request->role,
            'status' => 'pending', // 🔥 penting
            'password' => bcrypt(config('app.default_password')),
        ]);

        return redirect()->route('login.form')
            ->with('success', 'Akun berhasil didaftarkan, tunggu approval admin');
    }
}