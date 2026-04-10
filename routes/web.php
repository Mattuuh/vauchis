<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// routes/web.php
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');


use App\Http\Controllers\ComercioController;

Route::get('/comercios/create', [ComercioController::class, 'create'])->name('comercios.create');
Route::post('/comercios', [ComercioController::class, 'store'])->name('comercios.store');


Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::get('/register', function () { return view('auth.register');})->name('register');


use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Usuario;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
    ]);

    $status = Password::sendResetLink([
        'usu_email1' => $request->email,
    ]);

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => ['required'],
        'email' => ['required', 'email'],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    $status = Password::reset(
        [
            'usu_email1' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
            'token' => $request->token,
        ],
        function (Usuario $user, string $password) {
            $user->forceFill([
                'usu_clave' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->name('password.update');


use App\Http\Controllers\VoucherController;

Route::get('/vouchers/create', [VoucherController::class, 'create'])->name('vouchers.create');
Route::post('/vouchers', [VoucherController::class, 'store'])->name('vouchers.store');


use App\Http\Controllers\CommerceController;

Route::get('/commercios', [CommerceController::class, 'index'])->name('commerces.index');


use App\Http\Controllers\TipoEntidadController;

Route::get('/tipos-entidad', [TipoEntidadController::class, 'index'])->name('tipos-entidad.index');
Route::get('/tipos-entidad/create', [TipoEntidadController::class, 'create'])->name('tipos-entidad.create');
Route::post('/tipos-entidad', [TipoEntidadController::class, 'store'])->name('tipos-entidad.store');


use App\Http\Controllers\OrganizacionController;

Route::get('/organizacion', [OrganizacionController::class, 'index'])->name('organizacion.index');
Route::get('/organizacion/create', [OrganizacionController::class, 'create'])->name('organizacion.create');
Route::post('/organizacion', [OrganizacionController::class, 'store'])->name('organizacion.store');


use App\Http\Controllers\InfluencerController;

Route::get('/influencers', [InfluencerController::class, 'index'])->name('influencers.index');
Route::get('/influencers/create', [InfluencerController::class, 'create'])->name('influencers.create');
Route::post('/influencers', [InfluencerController::class, 'store'])->name('influencers.store');