<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MercadoPagoOAuthController extends Controller
{
    public function redirect(Entidad $entidad)
    {
        $baseUrl = config('app.url');
        session(['mp_entidad_id' => $entidad->ent_id]);

        $params = http_build_query([
            'client_id' => config('services.mercadopago.client_id'),
            'response_type' => 'code',
            'platform_id' => 'mp',
            // 'redirect_uri' => route('mp.callback'),
            'redirect_uri' => $baseUrl . '/mercadopago/callback',
            'state' => $entidad->ent_id,
        ]);
        // dd($params);die;

        return redirect('https://auth.mercadopago.com.ar/authorization?' . $params);
    }

    public function callback(Request $request)
    {
        $baseUrl = config('app.url');
        $entidadId = $request->state;

        // dd([
        //     'code' => $request->code,
        //     'entidadId' => $request->state,
        //     'redirect_uri' => $baseUrl . '/mercadopago/callback',
        //     'client_id' => config('services.mercadopago.client_id'),
        // ]);

        if (!$request->has('code') || !$entidadId) {
            abort(400, 'No se pudo vincular Mercado Pago.');
        }

        $response = Http::asForm()->post('https://api.mercadopago.com/oauth/token', [
            'client_secret' => config('services.mercadopago.client_secret'),
            'client_id' => config('services.mercadopago.client_id'),
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            // 'redirect_uri' => route('mp.callback'),
            'redirect_uri' => $baseUrl . '/mercadopago/callback',
        ]);

        if (!$response->successful()) {
            dd($response->json());
        }

        $data = $response->json();

        Entidad::where('ent_id', $entidadId)->update([
            'mp_user_id' => $data['user_id'] ?? null,
            'mp_access_token' => $data['access_token'],
            'mp_refresh_token' => $data['refresh_token'],
            'mp_public_key' => $data['public_key'] ?? null,
            // 'mp_token_expires_in' => $data['expires_in'] ?? null,
            // 'mp_connected_at' => now(),
        ]);

        session()->forget('mp_entidad_id');

        return redirect()
            ->route('entidades.edit', $entidadId)
            ->with('success', 'Mercado Pago conectado correctamente.');
    }
}
