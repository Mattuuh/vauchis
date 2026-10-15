<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Models\MercadopagoResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
        $data_js=$request->getContent();
        $data_mp=json_decode($data_js, true);
        $vec_resp['preference_data']=$request->getContent();
        $vec_resp['get']='GET: '.var_export($_GET,true);
        $vec_resp['post']='POST: '.var_export($_POST,true);
        $vec_resp['pmc_exec']=$_SERVER['PHP_SELF'];
        $vec_resp['data']=$_REQUEST;
        MercadopagoResponse::create([
            'op_id' => 0,    
            'cliente_id' => 0,
            'preference_data' => $request->getContent(),
            'mpl_get' => 'GET: '.json_encode($request->query(), JSON_PRETTY_PRINT),
            'mpl_post' => 'POST: '.json_encode($request->post(), JSON_PRETTY_PRINT),
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
            ->route('admin.entidades.edit', $entidadId)
            ->with('success', 'Mercado Pago conectado correctamente.');
    }
}
