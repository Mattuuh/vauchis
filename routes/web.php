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
// Route::get('/entidades/listado', [EntidadController::class, 'listado'])->name('entidades.listado');
// Route::resource('entidades', EntidadController::class);
// Route::post('/entidades/{id}/delete', [EntidadController::class, 'delete'])->name('entidades.delete');


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


use App\Http\Controllers\VoucherCompraController;
Route::post('/vouchers/{voucher}/pagar', [VoucherCompraController::class, 'pagar'])->name('vouchers.pagar');

// opcional
Route::delete('/vouchers/banner/{id}', [VoucherController::class, 'destroyBanner'])->name('vouchers.banner.destroy');


use App\Http\Controllers\TipoEntidadController;
use App\Http\Controllers\OrganizacionController;
use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\RubroController;
use App\Http\Controllers\ModalidadController;
use App\Http\Controllers\ResaltadorController;
use App\Http\Controllers\EtiquetaController;


// use App\Http\Controllers\VoucherEmisionController;

// Route::resource('voucher_emisiones', VoucherEmisionController::class);
// Route::get('/voucher_emisiones/{id}', [VoucherEmisionController::class, 'show'])->name('voucher_emisiones.show');
// Route::get('/voucher_emisiones/{id}/pdf', [VoucherEmisionController::class, 'pdf'])->name('voucher_emisiones.pdf');


use App\Http\Controllers\VoucherPlantillaController;
use App\Http\Controllers\BibliotecaFondoController;


use App\Http\Controllers\CheckoutController;
Route::post('/checkout/voucher/{voucher}/{modalidadCampo}', [CheckoutController::class, 'crearPreferencia'])->name('checkout.voucher');
Route::post('/webhooks/mercadopago', [CheckoutController::class, 'webhook'])->name('mercadopago.webhook');
Route::get('/mercadopago/pago_success', [CheckoutController::class, 'success'])->name('mercadopago.success');
Route::get('/mercadopago/pago_failure', [CheckoutController::class, 'failure'])->name('mercadopago.failure');
Route::get('/mercadopago/pago_pending', [CheckoutController::class, 'pending'])->name('mercadopago.pending');


use App\Http\Controllers\MercadoPagoOAuthController;
Route::get('/mercadopago/conectar/{entidad}', [MercadoPagoOAuthController::class, 'redirect'])->name('mp.conectar');
Route::get('/mercadopago/callback', [MercadoPagoOAuthController::class, 'callback'])->name('mp.callback');


use App\Http\Controllers\CategoriaController;

Route::get('/categorias/{id}', [CategoriaController::class, 'mostrarCategoria'])->name('categorias');
Route::get('/categorias/{categoria}/rubros/{rubro}/entidades',[CategoriaController::class, 'entidadesPorRubro'])->name('categorias.rubros.entidades');
Route::get('/categorias/{categoria}/rubros/{rubro}/subrubros/{subrubro}/entidades',[CategoriaController::class, 'entidadesPorSubrubro'])->name('categorias.entidades.subrubro');


Route::get('/entidad/{id}', [VoucherController::class, 'vouchersPorEntidad'])->name('vouchers.entidad');
Route::get('/buscar', [VoucherController::class, 'buscar_voucher'])->name('vouchers.buscar');
Route::get('/vouchers/{voucher}/{modalidadCampo}/comprar', [VoucherController::class, 'precompra'])->name('vouchers.comprar');


Route::middleware(['administrador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/entidades/listado', [EntidadController::class, 'listado'])->name('entidades.listado');
        Route::resource('entidades', EntidadController::class);
        Route::post('/entidades/{id}/delete', [EntidadController::class, 'delete'])->name('entidades.delete');

        Route::get('/rubros/listado', [RubroController::class, 'listado'])->name('rubros.listado');
        Route::resource('rubros', RubroController::class);
        Route::post('/rubros/{id}/delete', [RubroController::class, 'delete'])->name('rubros.delete');

        Route::get('/tipos-entidad/listado', [TipoEntidadController::class, 'listado'])->name('tipos-entidad.listado');
        Route::resource('tipos-entidad', TipoEntidadController::class);
        Route::post('/tipos-entidad/{id}/delete', [TipoEntidadController::class, 'delete'])->name('tipos-entidad.delete');


        Route::get('/resaltadores/listado', [ResaltadorController::class, 'listado'])->name('resaltadores.listado');
        Route::resource('resaltadores', ResaltadorController::class);
        Route::post('/resaltadores/{id}/delete', [ResaltadorController::class, 'delete'])->name('resaltadores.delete');


        Route::get('/organizacion/listado', [OrganizacionController::class, 'listado'])->name('organizacion.listado');
        Route::resource('organizacion', OrganizacionController::class);
        Route::post('/organizacion/{id}/delete', [OrganizacionController::class, 'delete'])->name('organizacion.delete');


        Route::get('/influencers/listado', [InfluencerController::class, 'listado'])->name('influencers.listado');
        Route::resource('influencers', InfluencerController::class);
        Route::post('/influencers/{id}/delete', [InfluencerController::class, 'delete'])->name('influencers.delete');


        Route::get('/vouchers/listado', [VoucherController::class, 'listado'])->name('vouchers.listado');
        Route::resource('vouchers', VoucherController::class);
        Route::post('/vouchers/{id}/delete', [VoucherController::class, 'delete'])->name('vouchers.delete');
        Route::get('/vouchers/{voucher}/plantillas/{plantilla}/preview', [VoucherController::class, 'previewPlantilla'])->name('vouchers.plantillas.preview');
        Route::post('/vouchers/{voucher}/detalles/{detalle}/delete', [VoucherController::class, 'delete_voucher_detalle'])->name('vouchers.delete.detalle');
        Route::post('/vouchers/{id}/agregar-stock', [VoucherController::class, 'agregar_voucher_detalle'])->name('vouchers.update_detalle');


        Route::get('/modalidades/listado', [ModalidadController::class, 'listado'])->name('modalidades.listado');
        Route::resource('modalidades', ModalidadController::class);
        Route::post('/modalidades/{id}/delete', [ModalidadController::class, 'delete'])->name('modalidades.delete');

        Route::get('/etiquetas/listado', [EtiquetaController::class, 'listado'])->name('etiquetas.listado');
        Route::resource('etiquetas', EtiquetaController::class);
        Route::post('/etiquetas/{id}/delete', [EtiquetaController::class, 'delete'])->name('etiquetas.delete');

        Route::resource('voucher_plantillas', VoucherPlantillaController::class);
        Route::post('/voucher_plantillas/{id}/delete', [VoucherPlantillaController::class, 'delete'])->name('voucher_plantillas.delete');
        Route::get('/voucher_plantillas/{id}/builder', [VoucherPlantillaController::class, 'builder'])->name('voucher_plantillas.builder');
        Route::post('/voucher_plantillas/{id}/builder', [VoucherPlantillaController::class, 'saveBuilder'])->name('voucher_plantillas.builder.save');
        Route::get('/voucher_plantillas/{id}/preview', [VoucherPlantillaController::class, 'preview'])->name('voucher_plantillas.preview');

        Route::resource('biblioteca_fondos', BibliotecaFondoController::class);
        Route::post('/biblioteca_fondos/{id}/delete', [BibliotecaFondoController::class, 'delete'])->name('biblioteca_fondos.delete');

    });