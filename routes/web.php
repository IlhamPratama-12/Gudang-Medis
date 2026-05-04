<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserApprovalController;

use App\Http\Controllers\Petugas\AlatMedisController;
use App\Http\Controllers\Petugas\StokMasukController;
use App\Http\Controllers\Petugas\StokKeluarController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login.form'));

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/register', [RegisterController::class, 'form'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');
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
| DASHBOARD (AUTO REDIRECT BY ROLE)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', function () {

    $user = Auth::user();

    if ($user->status !== 'approved') {
        Auth::logout();

        return redirect()->route('login.form')
            ->withErrors(['email' => 'Akun kamu masih menunggu persetujuan admin']);
    }

    return match ($user->role) {
        'admin'     => view('dashboard.admin.index'),
        'manajemen' => view('dashboard.manajemen.index'),
        'petugas'   => view('dashboard.petugas.index'),
        default     => abort(403),
    };

})->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/approval', [UserApprovalController::class, 'index'])
        ->name('approval.index');

    Route::post('/approval/{id}', [UserApprovalController::class, 'approve'])
        ->name('approval.approve');
});

/*
|--------------------------------------------------------------------------
| PETUGAS + ADMIN (OPERASIONAL GUDANG)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {

    // ALAT MEDIS
    Route::get('/petugas-gudang', [AlatMedisController::class, 'index'])
        ->name('petugas.gudang');

    Route::get('/alat-medis/create', [AlatMedisController::class, 'create'])
        ->name('alat.create');

    Route::post('/alat-medis', [AlatMedisController::class, 'store'])
        ->name('alat.store');

    Route::get('/alat-medis/{id}/edit', [AlatMedisController::class, 'edit'])
        ->name('alat.edit');

    Route::put('/alat-medis/{id}', [AlatMedisController::class, 'update'])
        ->name('alat.update');

    Route::delete('/alat-medis/{id}', [AlatMedisController::class, 'destroy'])
        ->name('alat.destroy');

    // STOK MASUK
    Route::get('/stok-masuk', [StokMasukController::class, 'index'])
        ->name('stok.masuk');

    Route::get('/stok-masuk/create', [StokMasukController::class, 'create'])
        ->name('stok.masuk.create');

    Route::post('/stok-masuk', [StokMasukController::class, 'store'])
        ->name('stok.masuk.store');

        Route::get('/stok-keluar', [StokKeluarController::class, 'index'])
        ->name('stok.keluar');

    Route::get('/stok-keluar/create', [StokKeluarController::class, 'create'])
        ->name('stok.keluar.create');

    Route::post('/stok-keluar', [StokKeluarController::class, 'store'])
        ->name('stok.keluar.store');
});

/*
|--------------------------------------------------------------------------
| MANAJEMEN (UNTUK LAPORAN + FORECASTING)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:manajemen'])->group(function () {

    Route::get('/manajemen/dashboard', function () {
        return view('dashboard.manajemen.index');
    })->name('manajemen.dashboard');

    Route::get('/laporan/stok', function () {
        return view('dashboard.manajemen.laporan_stok');
    })->name('laporan.stok');

    Route::get('/forecasting', function () {
        return view('dashboard.manajemen.forecasting');
    })->name('forecasting.index');
});

Route::middleware('auth')->get('/splash', function () {

        if (!session('login_success')) {
            return redirect()->route('dashboard');
        }

        session()->forget('login_success');

        $user = Auth::user();

        return view('splash', [
            'role' => $user->role
        ]);

    })->name('splash');