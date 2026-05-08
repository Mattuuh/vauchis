<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// routes/web.php
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');


use App\Http\Controllers\EntidadController;

// Route::get('/comercios', [EntidadController::class, 'index'])->name('entidades.index');
// Route::get('/comercios/create', [EntidadController::class, 'create'])->name('entidades.create');
// Route::post('/comercios', [EntidadController::class, 'store'])->name('entidades.store');
Route::resource('entidades', EntidadController::class);
Route::post('/entidades/{id}/delete', [EntidadController::class, 'delete'])->name('entidades.delete');


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

// Route::get('/vouchers/create', [VoucherController::class, 'create'])->name('vouchers.create');
// Route::post('/vouchers', [VoucherController::class, 'store'])->name('vouchers.store');
Route::resource('vouchers', VoucherController::class);
Route::post('/vouchers/{id}/delete', [VoucherController::class, 'delete'])->name('vouchers.delete');
Route::get('/vouchers/{voucher}/plantillas/{plantilla}/preview', [VoucherController::class, 'previewPlantilla'])->name('vouchers.plantillas.preview');

// opcional
Route::delete('/vouchers/banner/{id}', [VoucherController::class, 'destroyBanner'])->name('vouchers.banner.destroy');


use App\Http\Controllers\TipoEntidadController;

// Route::get('/tipos-entidad', [TipoEntidadController::class, 'index'])->name('tipos-entidad.index');
// Route::get('/tipos-entidad/create', [TipoEntidadController::class, 'create'])->name('tipos-entidad.create');
// Route::post('/tipos-entidad', [TipoEntidadController::class, 'store'])->name('tipos-entidad.store');
Route::resource('tipos-entidad', TipoEntidadController::class);
Route::post('/tipos-entidad/{id}/delete', [TipoEntidadController::class, 'delete'])->name('tipos-entidad.delete');


use App\Http\Controllers\OrganizacionController;

// Route::get('/organizacion', [OrganizacionController::class, 'index'])->name('organizacion.index');
// Route::get('/organizacion/create', [OrganizacionController::class, 'create'])->name('organizacion.create');
// Route::post('/organizacion', [OrganizacionController::class, 'store'])->name('organizacion.store');
Route::resource('organizacion', OrganizacionController::class);
Route::post('/organizacion/{id}/delete', [OrganizacionController::class, 'delete'])->name('organizacion.delete');


use App\Http\Controllers\InfluencerController;

// Route::get('/influencers', [InfluencerController::class, 'index'])->name('influencers.index');
// Route::get('/influencers/create', [InfluencerController::class, 'create'])->name('influencers.create');
// Route::post('/influencers', [InfluencerController::class, 'store'])->name('influencers.store');
// Route::get('/influencers/{id}/edit', [InfluencerController::class, 'edit'])->name('influencers.edit');
// Route::put('/influencers/{id}', [InfluencerController::class, 'update'])->name('influencers.update');
Route::resource('influencers', InfluencerController::class);
Route::post('/influencers/{id}/delete', [InfluencerController::class, 'delete'])->name('influencers.delete');


use App\Http\Controllers\RubroController;

// Route::get('/rubros', [RubroController::class, 'index'])->name('rubros.index');
// Route::get('/rubros/create', [RubroController::class, 'create'])->name('rubros.create');
// Route::post('/rubros', [RubroController::class, 'store'])->name('rubros.store');
// Route::get('/rubros/{id}/edit', [RubroController::class, 'edit'])->name('rubros.edit');
// Route::put('/rubros/{id}', [RubroController::class, 'update'])->name('rubros.update');
Route::resource('rubros', RubroController::class);
Route::post('/rubros/{id}/delete', [RubroController::class, 'delete'])->name('rubros.delete');


use App\Http\Controllers\ModalidadController;

Route::resource('modalidades', ModalidadController::class);
Route::post('/modalidades/{id}/delete', [ModalidadController::class, 'delete'])->name('modalidades.delete');


use App\Http\Controllers\VoucherEmisionController;

Route::resource('voucher_emisiones', VoucherEmisionController::class);
Route::get('/voucher_emisiones/{id}', [VoucherEmisionController::class, 'show'])->name('voucher_emisiones.show');
Route::get('/voucher_emisiones/{id}/pdf', [VoucherEmisionController::class, 'pdf'])->name('voucher_emisiones.pdf');


use App\Http\Controllers\VoucherPlantillaController;

Route::resource('voucher_plantillas', VoucherPlantillaController::class);
Route::post('/voucher_plantillas/{id}/delete', [VoucherPlantillaController::class, 'delete'])->name('voucher_plantillas.delete');
Route::get('/voucher_plantillas/{id}/builder', [VoucherPlantillaController::class, 'builder'])->name('voucher_plantillas.builder');
Route::post('/voucher_plantillas/{id}/builder', [VoucherPlantillaController::class, 'saveBuilder'])->name('voucher_plantillas.builder.save');
Route::get('/voucher_plantillas/{id}/preview', [VoucherPlantillaController::class, 'preview'])->name('voucher_plantillas.preview');


use App\Http\Controllers\EtiquetaController;

Route::resource('etiquetas', EtiquetaController::class);
Route::post('/etiquetas/{id}/delete', [EtiquetaController::class, 'delete'])->name('etiquetas.delete');


use App\Http\Controllers\BibliotecaFondoController;

Route::resource('biblioteca_fondos', BibliotecaFondoController::class);
Route::post('/biblioteca_fondos/{id}/delete', [BibliotecaFondoController::class, 'delete'])->name('biblioteca_fondos.delete');