<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendAccountMail;

class UserApprovalController extends Controller
{
    public function index()
    {
        $users = User::where('status', 'pending')->get();
        return view(' dashboard.admin.approval', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);

        $password = Str::random(8);

        $user->update([
            'password' => bcrypt($password),
            'status'   => 'approved'
        ]);

        Mail::to($user->email)->send(
            new SendAccountMail($user, $password)
        );

        return back()->with('success', 'User berhasil diapprove & email dikirim');
    }
}