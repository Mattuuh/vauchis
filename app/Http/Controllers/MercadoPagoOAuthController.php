<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Models\MercadopagoResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MercadoPagoOAuthController extends Controller
{
    // public function redirect(Entidad $entidad)
    // {
    //     $baseUrl = config('app.url');
    //     session(['mp_entidad_id' => $entidad->ent_id]);
    //     // dd($baseUrl . '/mercadopago/callback');

    //     $params = http_build_query([
    //         'client_id' => config('services.mercadopago.client_id'),
    //         'response_type' => 'code',
    //         'platform_id' => 'mp',
    //         'redirect_uri' => $baseUrl . '/mercadopago/callback',
    //         'state' => $entidad->ent_id,
    //     ]);
    //     // dd($params);die;

    //     $vec_resp['get']='GET: '.var_export($_GET,true);
    //     $vec_resp['post']='POST: '.var_export($_POST,true);
    //     $vec_resp['pmc_exec']=$_SERVER['PHP_SELF'];
    //     $vec_resp['data']=$_REQUEST;
    //     MercadopagoResponse::create([
    //         'op_id' => 0,    
    //         'cliente_id' => 0,
    //         'preference_data' => json_encode($entidad, JSON_PRETTY_PRINT),
    //         'mpl_get' => 'GET: '.json_encode($params, JSON_PRETTY_PRINT),
    //         'mpl_post' => 'POST: '.json_encode($params, JSON_PRETTY_PRINT),
    //         'collection_id' => 0,
    //         'external_reference' => 0,
    //         'merchant_order_id' => 0,
    //         'collection_status' => 0,
    //         'payment_type' => 0,
    //         'mpl_json' => 0,
    //         'mpl_exec' => '',
    //         'merchant_order_info' => 0,
    //         'payment_info' => 0,
    //         'mpl_usu_alta' => 0,
    //         'mpl_fecha_alta' => now(),
    //     ]);

    //     return redirect('https://auth.mercadopago.com.ar/authorization?' . $params);
    // }

    public function redirect(Entidad $entidad)
    {
        $redirectUri = 'https://vauchis.com/mercadopago/callback';
        // $redirectUri = 'https://www.vauchis.com/mercadopago/callback';

        $state = Str::random(40);
        $verifier = Str::random(64);

        $challenge = rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '=');

        session([
            'mp_entidad_id' => $entidad->ent_id,
            'mp_oauth_state' => $state,
            'mp_code_verifier' => $verifier,
        ]);

        $params = http_build_query([
            'client_id' => config('services.mercadopago.client_id'),
            'response_type' => 'code',
            'platform_id' => 'mp',
            'redirect_uri' => $redirectUri,
            'state' => $state,
            'code_challenge' => $challenge,
            'code_challenge_method' => 'S256',
        ]);

        $vec_resp['get']='GET: '.var_export($_GET,true);
        $vec_resp['post']='POST: '.var_export($_POST,true);
        $vec_resp['pmc_exec']=$_SERVER['PHP_SELF'];
        $vec_resp['data']=$_REQUEST;
        MercadopagoResponse::create([
            'op_id' => 0,    
            'cliente_id' => 0,
            'preference_data' => json_encode($entidad, JSON_PRETTY_PRINT),
            'mpl_get' => 'GET: '.json_encode($params, JSON_PRETTY_PRINT),
            'mpl_post' => 'POST: '.json_encode($params, JSON_PRETTY_PRINT),
            'collection_id' => 0,
            'external_reference' => 0,
            'merchant_order_id' => 0,
            'collection_status' => 0,
            'payment_type' => 0,
            'mpl_json' => 0,
            'mpl_exec' => '',
            'merchant_order_info' => 0,
            'payment_info' => 0,
            'mpl_usu_alta' => 0,
            'mpl_fecha_alta' => now(),
        ]);

        return redirect()->away(
            'https://auth.mercadopago.com/authorization?' . $params
        );
    }

    public function callback(Request $request)
    {
        $baseUrl = rtrim(config('app.url'), '/');

        $redirectUri = $baseUrl . '/mercadopago/callback';

        // Recuperar información almacenada al iniciar OAuth
        $entidadId = session('mp_entidad_id');
        $state = session('mp_oauth_state');
        $codeVerifier = session('mp_code_verifier');
        $datosRegistro = [
            'has_code' => $request->filled('code'),
            'has_state' => $request->filled('state'),
            'error' => $request->input('error'),
            'error_description' => $request->input('error_description'),
        ];

        MercadopagoResponse::create([
            'op_id' => 0,
            'cliente_id' => 0,
            'preference_data' => json_encode($datosRegistro),
            'mpl_get' => json_encode($datosRegistro),
            'mpl_post' => '{}',
            'collection_id' => 0,
            'external_reference' => 0,
            'merchant_order_id' => 0,
            'collection_status' => 0,
            'payment_type' => 0,
            'mpl_json' => 0,
            'mpl_exec' => $request->path(),
            'merchant_order_info' => 0,
            'payment_info' => 0,
            'mpl_usu_alta' => 0,
            'mpl_fecha_alta' => now(),
        ]);

        if ($request->filled('error')) {

            Log::warning('Mercado Pago OAuth rechazado', [
                'entidad_id' => $entidadId,
                'error' => $request->input('error'),
                'description' => $request->input('error_description'),
            ]);

            return redirect()
                ->route('admin.entidades.edit', $entidadId)
                ->with('error', 'Mercado Pago rechazó la autorización.');
        }

        if (
            !$entidadId ||
            !$state ||
            !$codeVerifier ||
            !$request->filled('code') ||
            !$request->filled('state') ||
            !hash_equals($state, $request->input('state'))
        ) {

            Log::warning('Mercado Pago OAuth: validación incorrecta', [
                'entidad_id' => $entidadId,
                'has_code' => $request->filled('code'),
                'has_state' => $request->filled('state'),
                'has_verifier' => !empty($codeVerifier),
            ]);

            abort(400, 'No se pudo validar la autorización de Mercado Pago.');
        }

        try {
            $response = Http::asForm()
                ->timeout(20)
                ->post(
                    'https://api.mercadopago.com/oauth/token',
                    [
                        'client_secret' => config('services.mercadopago.client_secret'),
                        'client_id' => config('services.mercadopago.client_id'),
                        'grant_type' => 'authorization_code',
                        'code' => $request->input('code'),
                        'redirect_uri' => $redirectUri,
                        'code_verifier' => $codeVerifier,
                    ]
                );

            if (!$response->successful()) {

                Log::error('Error al obtener tokens OAuth', [
                    'entidad_id' => $entidadId,
                    'status' => $response->status(),
                    'error' => $response->json('error'),
                    'message' => $response->json('message'),
                ]);

                return redirect()
                    ->route('admin.entidades.edit', $entidadId)
                    ->with('error', 'No se pudo completar la vinculación con Mercado Pago.');
            }

            $data = $response->json();

            if (
                empty($data['access_token']) ||
                empty($data['refresh_token']) ||
                empty($data['user_id'])
            ) {
                throw new \RuntimeException('Mercado Pago no devolvió las credenciales esperadas.');
            }

            Entidad::where('ent_id', $entidadId)->update([
                'mp_user_id' => $data['user_id'],
                // 'mp_access_token' => Crypt::encryptString($data['access_token']),
                // 'mp_refresh_token' => Crypt::encryptString($data['refresh_token']),
                'mp_access_token' => $data['access_token'],
                'mp_refresh_token' => $data['refresh_token'],
                'mp_public_key' => $data['public_key'] ?? null,
                // 'mp_token_expires_in' => $data['expires_in'] ?? null,
                // 'mp_connected_at' => now(),
            ]);

            session()->forget([
                'mp_entidad_id',
                'mp_oauth_state',
                'mp_code_verifier',
            ]);

            return redirect()
                ->route('admin.entidades.edit', $entidadId)
                ->with('success', 'Mercado Pago conectado correctamente.');

        } catch (\Throwable $e) {

            Log::error('Excepción OAuth Mercado Pago', [
                'entidad_id' => $entidadId,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.entidades.edit', $entidadId)
                ->with('error', 'Ocurrió un error al vincular Mercado Pago.');
        }
    }
}
