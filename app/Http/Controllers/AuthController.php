<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt(['usu_email1' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()
            ->withErrors([
                'email' => 'Las credenciales ingresadas no son correctas.',
            ])
            ->onlyInput('email');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tipo_doc_id' => ['nullable', 'string', 'max:20'],
            'usu_documento' => ['nullable', 'string', 'max:20'],
            'usu_apellido' => ['required', 'string', 'max:200'],
            'usu_nombre' => ['required', 'string', 'max:200'],
            'usu_nick' => ['required', 'string', 'max:200', Rule::unique('usuarios', 'usu_nick')],
            'usu_clave' => ['required', 'string', 'min:8', 'confirmed'],
            'usu_codigo_autorizacion' => ['nullable', 'string', 'max:50'],
            'usu_caux' => ['nullable', 'string', 'max:50'],
            'usu_email1' => ['required', 'email', 'max:200', Rule::unique('usuarios', 'usu_email1')],
            'usu_email2' => ['nullable', 'email', 'max:200'],
            'usu_celular1' => ['nullable', 'string', 'max:50'],
            'usu_celular2' => ['nullable', 'string', 'max:50'],
            'usu_telefono1' => ['nullable', 'string', 'max:50'],
            'usu_telefono2' => ['nullable', 'string', 'max:50'],
            'pais_id' => ['required', 'integer'],
            'provincia_id' => ['required', 'integer'],
            'ciudad_id' => ['required', 'integer'],
        ], [
            'usu_apellido.required' => 'El apellido es obligatorio.',
            'usu_nombre.required' => 'El nombre es obligatorio.',
            'usu_nick.required' => 'El usuario es obligatorio.',
            'usu_nick.unique' => 'Ese nombre de usuario ya está en uso.',
            'usu_clave.required' => 'La contraseña es obligatoria.',
            'usu_clave.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'usu_clave.confirmed' => 'La confirmación de la contraseña no coincide.',
            'usu_email1.required' => 'El email principal es obligatorio.',
            'usu_email1.email' => 'El email principal no tiene un formato válido.',
            'usu_email1.unique' => 'Ese email ya está registrado.',
            'pais_id.required' => 'El país es obligatorio.',
            'provincia_id.required' => 'La provincia es obligatoria.',
            'ciudad_id.required' => 'La ciudad es obligatoria.',
        ]);

        $usuario = Usuario::create([
            'tipo_doc_id' => $validated['tipo_doc_id'] ?? null,
            'usu_documento' => $validated['usu_documento'] ?? null,
            'usu_apellido' => $validated['usu_apellido'],
            'usu_nombre' => $validated['usu_nombre'],
            'usu_nick' => $validated['usu_nick'],
            'usu_clave' => Hash::make($validated['usu_clave']),
            'usu_codigo_autorizacion' => $validated['usu_codigo_autorizacion'] ?? null,
            'usu_caux' => $validated['usu_caux'] ?? null,
            'usu_email1' => $validated['usu_email1'],
            'usu_email2' => $validated['usu_email2'] ?? null,
            'usu_celular1' => $validated['usu_celular1'] ?? null,
            'usu_celular2' => $validated['usu_celular2'] ?? null,
            'usu_telefono1' => $validated['usu_telefono1'] ?? null,
            'usu_telefono2' => $validated['usu_telefono2'] ?? null,
            'pais_id' => $validated['pais_id'],
            'provincia_id' => $validated['provincia_id'],
            'ciudad_id' => $validated['ciudad_id'],
        ]);

        Auth::login($usuario);

        return redirect('/')->with('success', 'Tu cuenta fue creada correctamente.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}