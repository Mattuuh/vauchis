<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\MercadopagoResponse;
use App\Models\OrdenPago;
use App\Models\PagoMercadopago;
use App\Models\Voucher;
use Illuminate\Http\Request;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{

    public function crearPreferencia(Request $request, int $id)
    {
        // if (true) {
        //     return redirect()->route('mercadopago.success');
        // }

        if (!session()->has('auth')) {
            session(['url.intended' => url()->previous()]);

            return redirect()->route('login')->with('warning', 'Debés iniciar sesión para continuar con el pago.');
        }

        // $usuario = Auth::id();
        $usuario = 1;
        $cliente = Cliente::findOrFail(1);
        $voucher = Voucher::with('entidad')->findOrFail($id);
        $entidad = $voucher->entidad;
        $cantidad = $request->cantidad;
        $monto_total = $voucher->vou_monto_fijo * $cantidad;
        // $monto_total = 10;

        // $comprobante_numero
        $op = OrdenPago::create([
            'sucursal_id' => 0,
            'caja_id' => 1,
            'pasla_id' => null,
            'ent_id' => $entidad->ent_id,
            'vou_id' => $voucher->vou_id,
            'cliente_id' => $cliente->cliente_id,
            'op_cliente_denominacion' => $cliente->cliente_apellido.' '.$cliente->cliente_nombre,
            'op_cliente_domicilio' => $cliente->cliente_domicilio,
            'tipo_doc_id' => $cliente->tipo_doc_id,
            'op_cliente_documento' => $cliente->cliente_documento,
            'op_fecha' => now(),
            'ptovta_id' => 0,
            'tipo_comp_id' => 1,
            // 'op_numero' => $comprobante_numero->comp_numero,
            'op_numero' => 1,
            'op_total_original' => $voucher->vou_monto_fijo,
            'op_total' => $monto_total,
            'op_observaciones' => null,
            'op_observaciones_internas' => null,
            'op_estado' => 1,
            'op_estado2' => 'PE',
            'op_fecha_alta' => now(),
            'op_usu_alta' => 0,
        ]);


        // $vendedorAccessToken = $entidad->mp_access_token;
        $vendedorAccessToken = config('services.mercadopago.access_token');

        MercadoPagoConfig::setAccessToken($vendedorAccessToken);

        $fecha_ini_expiracion=date('Y-m-d\TH:i:s.000P', time());
        $fecha_fin_expiracion=date('Y-m-d\TH:i:s.000P', strtotime('+8 minutes'));

        $precio = round($monto_total, 2);
        $porcentaje_comision = $voucher->vou_porcentaje_comision / 100; // porcentaje de comision provisto desde el voucher
        $comisionMarketplace = round($precio * $porcentaje_comision, 2); // ejemplo 10%

        $client = new PreferenceClient();

        try {
            $baseUrl = config('app.url');

            $preference = $client->create([
                'items' => [
                    [
                        'id' => $voucher->vou_id,
                        'title' => $voucher->vou_nombre,
                        'quantity' => 1,
                        'currency_id' => 'ARS',
                        'unit_price' => $precio,
                    ]
                ],
                // 'marketplace_fee' => $comisionMarketplace,
                'external_reference' => 'PAGOVOUCHER_'. $op->op_id .'_'. $voucher->vou_id .'_'. $entidad->ent_id .'_'. $cliente->cli_id,
                // 'external_reference' => 'TEST_' . time(),
                'notification_url' => $baseUrl . '/webhooks/mercadopago',
                'back_urls' => [
                    'success' => $baseUrl . '/mercadopago/pago_success',
                    'failure' => $baseUrl . '/mercadopago/pago_failure',
                    'pending' => $baseUrl . '/mercadopago/pago_pending',
                ],
                'auto_return' => 'approved',
                // 'payment_methods' => array (
                //     'excluded_payment_types' => array(
                //         array(
                //             'id' => 'ticket',
                //         )
                //     ),
                // ),
                // 'expires' => true,
                // 'expiration_date_from' => $fecha_ini_expiracion,
                // 'expiration_date_to' => $fecha_fin_expiracion
            ]);

            $mp_id = DB::table('mercadopago_response_log')->insertGetId([
                'preference_data' => json_encode($preference, JSON_PRETTY_PRINT),
                // 'eti_estado' => 1,
                'mpl_fecha_alta' => now(),
                'mpl_usu_alta' => 1,
            ]);

            // dd($preference);

            
        } catch (MPApiException $e) {
            dd([
                'message' => $e->getMessage(),
                'status' => $e->getApiResponse()->getStatusCode(),
                'content' => $e->getApiResponse()->getContent(),
            ]);
        }

        // dd(json_encode($preference, JSON_PRETTY_PRINT));
        return redirect($preference->init_point);
        // return redirect($preference->sandbox_init_point);
    }

    public function webhook(Request $request)
    {
        $method=strtoupper($_SERVER['REQUEST_METHOD']);
        switch ($method) {
            case 'POST':
                //$_GET=$_POST;
                $strbn='CALLBACK IPN: INICIO '.$method;
                break;
            default:
                $strbn='CALLBACK IPN: INICIO '.$method;
                break;
        }

        $data_js=$request->getContent();
        $data_mp=json_decode($data_js, true);
// return http_response_code(200);
        $vec_resp['preference_data']=$request->getContent();
        $vec_resp['get']='GET: '.var_export($_GET,true);
        $vec_resp['post']='POST: '.var_export($_POST,true);
        $vec_resp['pmc_resp_obs']=$strbn;
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
            'mpl_obs' => $strbn,
            'mpl_exec' => $request->path(),
            'merchant_order_info' => 0,
            'payment_info' => 0,
            'mpl_usu_alta' => 0,
            'mpl_fecha_alta' => now(),
        ]);

        // $mp = new MP(MP_CLIENT_ID, MP_CLIENT_SECRET);
        // // $mp = new MP(MP_ACCESS_TOKEN);

        $mp_ambiente = config('services.mercadopago.ambiente');
        // if($mp_ambiente=='SANDBOX'){
        //     $mp->sandbox_mode(TRUE);
        // }

        // if (isset($_REQUEST['topic']) && $_REQUEST['topic']=='merchant_order'){
        //     if(!ctype_digit($_REQUEST['id'])){
        //         http_response_code(400);
        //         return;
        //     }
        // }

        // //////////////////////////////////////////////////////////////
        // //Notificación de pago y referencia a la compra asociada
        // if($_REQUEST['topic']=='payment'){

        //     $payment_info=$mp->get('/collections/notifications/'.$_REQUEST['id']);
        //     $merchant_order_info=$mp->get('/merchant_orders/'.$payment_info['response']['collection']['merchant_order_id']);

        //     $external_reference=$payment_info['response']['collection']['external_reference']; //$merchant_order_info['response']['collection']['external_reference'];
        //     $merchant_order_id=$payment_info['response']['collection']['merchant_order_id'];
        //     $collection_id=$payment_info['response']['collection']['id'];
        //     $payment_type=$payment_info['response']['collection']['payment_type'];
        //     $payment_id=$_REQUEST['id'];
        // }
        // //////////////////////////////////////////////////////////////
        // //Notificación de compra/transacción realizada
        // elseif($_REQUEST['topic']=='merchant_order'){
        //     $merchant_order_info=$mp->get('/merchant_orders/'.$_REQUEST['id']);

        //     $external_reference=$merchant_order_info['response']['external_reference'];
        //     $merchant_order_id=$_REQUEST['id'];
        //     $payment_id=0;
        // }

        
        $notificationType = $request->input('topic')
            ?? $request->input('topic');

        $payment_id = $request->input('id')
            ?? $request->input('id');

        // Log::info('Webhook Mercado Pago recibido', [
        //     'payload' => $request->all(),
        //     'query'   => $request->query(),
        //     'type'    => $notificationType,
        //     'id'      => $payment_id,
        // ]);

        if ($notificationType !== 'payment' || !$payment_id) {
            return response()->json([
                'message' => 'Notificación ignorada',
            ], 200);
        }

        /*
         * Acá necesitás el access_token correcto.
         *
         * En tu caso, al utilizar Split/OAuth, normalmente debe ser
         * el access_token del comercio al que pertenece el pago.
         */
        $accessToken = config('services.mercadopago.access_token');

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->get("https://api.mercadopago.com/v1/payments/{$payment_id}");

        if ($response->failed()) {
            // Log::error('No se pudo consultar el pago en Mercado Pago', [
            //     'payment_id' => $payment_id,
            //     'status'     => $response->status(),
            //     'response'   => $response->json(),
            // ]);

            /*
             * Un código distinto de 200 hace que Mercado Pago pueda
             * volver a intentar enviar la notificación.
             */
            return response()->json([
                'message' => 'No se pudo consultar el pago',
            ], 500);
        }

        $payment = $response->json();

        $external_reference = $payment['external_reference'] ?? null;
        $merchant_order_id   = data_get($payment, 'order.id');
        $collection_id      = $payment['id'] ?? null;
        $payment_type       = $payment['payment_type_id'] ?? null;
        $payment_method     = $payment['payment_method_id'] ?? null;
        $status            = $payment['status'] ?? null;
        $status_detail      = $payment['status_detail'] ?? null;
        $transaction_amount = $payment['transaction_amount'] ?? null;

        $payment_info = Http::withToken($accessToken)
            ->get("https://api.mercadopago.com/v1/payments/{$payment_id}")
            ->throw()
            ->json();

        if ($merchant_order_id) {
            $merchantOrderResponse = Http::withToken($accessToken)
                ->get(
                    "https://api.mercadopago.com/merchant_orders/{$merchant_order_id}"
                );

            $merchant_order_info = $merchantOrderResponse->json();
        }


        //////////////////////////////////////////////////////////////////////////////
        //composición $external_reference
        //PAGOSOLVEDG_99->[prefijo]_[id solicitud]
        //////////////////////////////////////////////////////////////////////////////

        $vec_ext=explode('_',$external_reference);

        if($vec_ext[0]!='PAGOVOUCHER'){
            http_response_code(400);
            return;
        }

        $f_op_id=$vec_ext[1];
        $f_vou_id=$vec_ext[2];
        $f_ent_id=$vec_ext[3];
        $f_cli_id=$vec_ext[4];

        //////////////////////////////////////////////////////////////////////////////
        //2022-05-12 chacho: se procesa solamente cuando llega orden de compra, no 'payment'
        if($_REQUEST['topic']=='merchant_order'){

            $dt_pagomp=PagoMercadopago::findOrFail($f_op_id);

            $concepto_pago_id=$dt_pagomp['concepto_pago_id'];

            if ($dt_pagomp['merchant_order_id']==$merchant_order_id && $dt_pagomp['pmp_estado_transaccion']=='PAGADO') {
                http_response_code(200);
                return;
            }
        }

        if ($_REQUEST['topic']=='payment') {
            $est_tran_lab='PAYMENT REGISTRO REFERENCIA';

            $vec_resp=[];
            $vec_resp['preference_data']=var_export($_REQUEST,true);
            $vec_resp['get']='GET: '.var_export($_GET,true);
            $vec_resp['post']='POST: '.var_export($_POST,true);
            $vec_resp['pmc_resp_obs']='CALLBACK IPN: '.$est_tran_lab;
            $vec_resp['pmc_exec']=$_SERVER['PHP_SELF'];
            $vec_resp['merchant_order_info']=var_export($merchant_order_info,true);
            $vec_resp['payment_info']=var_export($payment_info,true);
            $vec_resp['data']=$_REQUEST;
            // nuevo_mercadopago_response($vec_resp);

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
                'mpl_obs' => 'CALLBACK IPN: '.$est_tran_lab,
                'mpl_exec' => $request->path(),
                'merchant_order_info' => var_export($merchant_order_info,true),
                'payment_info' => var_export($payment_info,true),
                'mpl_usu_alta' => 0,
                'mpl_fecha_alta' => now(),
            ]);
        }

        //2022-05-12 chacho: se procesa solamente cuando llega orden de compra, no 'payment'
        if($merchant_order_info['status']==200 && $_REQUEST['topic']=='merchant_order'){

            // Si el monto de la transacción del pago es igual (o mayor) que el monto de merchant_order, puede liberar sus artículos
            $transaction_amount=0;
            $estado_transaccion="NULL";
            $estado_envio="NULL";

            foreach($merchant_order_info['response']['payments'] as  $payment){
                if($payment['status'] == 'approved'){
                    $transaction_amount+= $payment['transaction_amount'];
                }
            }

            ////////////////////////////////////////////////////////
            //orden pagada
            if($transaction_amount>=$merchant_order_info['response']['total_amount']){
                ////////////////////////////////////////////////////////
                //Verificar si la orden comercial incluye envío
                if(count($merchant_order_info['response']['shipments'])>0){
                    if($merchant_order_info['response']['shipments'][0]['status'] == 'ready_to_ship'){
                        $estado_transaccion="'PAGADO'";
                        $estado_envio="'LIBERADO - ENVIAR'";
                    }
                }
                else{
                    $estado_transaccion="'PAGADO'";
                    $estado_envio="'LIBERADO - SIN ENVIO'";
                }
            }
            ////////////////////////////////////////////////////////
            //orden no pagada
            else{
                $estado_transaccion="'NO PAGADO'";
                $estado_envio="'NO LIBERADO'";
            }

            $fecha_update=date('Y-m-d H:i:s');

            //////////////////////////////////////////////////////////////////////////////
            //Inserción de string con parámetros de cada una de los response MP
            $est_tran_lab=($estado_transaccion=="'PAGADO'")?'PAGADO':'NO PAGADO';

            $vec_resp=[];
            $vec_resp['preference_data']=var_export($_REQUEST,true);
            $vec_resp['ent_id']=$f_ent_id;
            $vec_resp['vou_id']=$f_vou_id;
            $vec_resp['cli_id']=$f_cli_id;
            $vec_resp['get']='GET: '.var_export($_GET,true);
            $vec_resp['post']='POST: '.var_export($_POST,true);
            $vec_resp['pmc_resp_obs']='CALLBACK IPN: PROCESAMIENTO '.$est_tran_lab;
            $vec_resp['pmc_exec']=$_SERVER['PHP_SELF'];
            $vec_resp['merchant_order_info']=var_export($merchant_order_info,true);
            $vec_resp['payment_info']=var_export($payment_info,true);
            $vec_resp['data']=$_REQUEST;
            // nuevo_mercadopago_response($vec_resp);

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
                'mpl_obs' => 'CALLBACK IPN: PROCESAMIENTO '.$est_tran_lab,
                'mpl_exec' => $request->path(),
                'merchant_order_info' => var_export($merchant_order_info,true),
                'payment_info' => var_export($payment_info,true),
                'mpl_usu_alta' => 0,
                'mpl_fecha_alta' => now(),
            ]);
            //////////////////////////////////////////////////////////////////////////////


            //////////////////////////////////////////////////////////////////////////////
            //INICIO UPDATE ENTRADA MERCADO PAGO
            $pmp_observaciones='mp_callback_sc IPN: impacto de pago en BD  ['.$mp_ambiente.']';

            $upmp="UPDATE pagos_mercadopago SET ";
            if ($payment_id!=0) {
                $upmp.="payment_id=".$payment_id.", ";
            }
            $upmp.="merchant_order_id='".$merchant_order_id."',
                transaction_amount='".$transaction_amount."',
                pmp_estado_envio=".$estado_envio.",
                pmp_estado_transaccion=".$estado_transaccion.", ";
            $upmp.=(isset($collection_id))?"collection_id='".$collection_id."', ":"";
            $upmp.=(isset($payment_type))?"payment_type='".$payment_type."', ":"";

            $upmp.="pmp_observaciones=CONCAT(pmp_observaciones,' | [".date('d/m/Y H:i:s')." - ".strtoupper($_SESSION['sid_usuario_nick'])."]: ".$pmp_observaciones."'),
                pmp_fecha_mod='".$fecha_update."'
                WHERE op_id='".$f_op_id."'
                AND pmp_id='".$dt_pagomp['pmp_id']."' ";
            //FIN UPDATE ENTRADA MERCADO PAGO
            //////////////////////////////////////////////////////////////////////////////

            if ($estado_transaccion=="'PAGADO'") {
                ////////////////////////////////////////////////////////////////////////
                //Update estado solicitud con referencia a pago
                ////////////////////////////////////////////////////////////////////////

                $op=OrdenPago::findOrFail($f_op_id);

                if ($op['op_estado2']=='PE') {
                    // $upins="UPDATE solicitudes_certificaciones SET
                    //     solc_estado3='PA',
                    //     solc_mp_pago_anticipo='1',
                    //     solc_mp_pago_fecha=NOW(),
                    //     solc_mp_pago_referencia=' | [".date('d/m/Y H:i:s')." - MERCADOPAGO]: Pago MP: ".$dt_pagomp['pmp_id']." - Monto: $ ".$transaction_amount." - Notificado: ".$fecha_update."',
                    //     ref_pago_id='".$dt_pagomp['pmp_id']."'
                    //     WHERE solc_id='".$v_solc_id."' ";

                    // $descripcion_pmp_lab="PAGO DE VOUCHER [Voucher ID: ".$f_vou_id."][MP] -  $ ".$transaction_amount;

                    // $cliente=Cliente::findOrFail($f_cli_id);

                    // $vec_recibo['ref_pago_id']=$dt_pagomp['pmp_id'];
                    // $vec_recibo['forma_pago_id']=6;
                    // $vec_recibo['solc_numero']=$voucher['solc_numero'];
                    // $vec_recibo['tipo_comp_id']=21;
                    // $vec_recibo['concepto_pago_id']=$concepto_pago_id;
                    // $vec_recibo['recibo_nombre']=$cliente['usu_web_nombre'];
                    // $vec_recibo['recibo_domicilio']='';
                    // $vec_recibo['usuario_id']=$voucher['solc_usuario_alta'];
                    // $vec_recibo['recibo_detalle_label']=$descripcion_pmp_lab;
                    // $vec_recibo['monto_pago']=$transaction_amount;
                    // $vec_recibo['recibo_nota']=" | [".date('d/m/Y H:i:s')." - MERCADOPAGO]: Pago MP: ".$dt_pagomp['pmp_id']." - Monto: $ ".$transaction_amount." - Notificado: ".$fecha_update;
                    // $retorno=insertar_recibo_pago_electronico_sc($voucher['solc_id'],$vec_recibo);

                    // $recibo_id=$retorno['recibo_id'];

                    // $op->update([
                    //     'op_estado2' => 'PA',
                    //     'comp_id' => $recibo_id,
                    //     'op_fecha_mod' => now(),
                    //     'op_usu_mod' => $_SESSION['sid_usuario_id']
                    // ]);

                }
            }
        }

        return response()->json(['ok' => true]);
    }

    
    public function success(Request $request)
    {
        return view('mercadopago.pago_success', [
            'paymentId' => $request->payment_id,
            'status' => $request->status,
        ]);
    }

    public function failure(Request $request)
    {
        return view('mercadopago.pago_failure', [
            'paymentId' => $request->payment_id,
            'status' => $request->status,
        ]);
    }

    public function pending(Request $request)
    {
        return view('mercadopago.pago_pending', [
            'paymentId' => $request->payment_id,
            'status' => $request->status,
        ]);
    }
}
