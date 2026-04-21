<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserApprovalController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login.form'));

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN & REGISTER)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // LOGIN
    Route::get('/login', [AuthController::class, 'loginForm'])
        ->name('login.form');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login');

    // REGISTER
    Route::get('/register', [RegisterController::class, 'form'])
        ->name('register.form');

    Route::post('/register', [RegisterController::class, 'store'])
        ->name('register');
});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD (SINGLE ENTRY + STATUS CHECK)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', function () {

    $user = Auth::user();

    // 🔥 CEK STATUS APPROVAL
    if ($user->status !== 'approved') {

        Auth::logout();

        return redirect()->route('login.form')
            ->withErrors([
                'email' => 'Akun kamu masih menunggu persetujuan admin'
            ]);
    }

    // 🔥 REDIRECT BERDASARKAN ROLE
    return match ($user->role) {
        'admin'     => view('dashboard.admin.index'),
        'manajemen' => view('dashboard.manajemen.index'),
        'petugas'   => view('dashboard.petugas.index'),
        default     => abort(403),
    };

})->name('dashboard');

/*
|--------------------------------------------------------------------------
| APPROVAL (ADMIN ONLY)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin'])->group(function () {

    // HALAMAN LIST USER PENDING
    Route::get('/approval', [UserApprovalController::class, 'index'])
        ->name('approval.index');

    // APPROVE USER
    Route::post('/approval/{id}', [UserApprovalController::class, 'approve'])
        ->name('approval.approve');

});