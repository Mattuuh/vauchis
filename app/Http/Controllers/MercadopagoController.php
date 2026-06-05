<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MercadopagoController extends Controller
{
    public function nuevo_mercadopago_response($vec) {
        // 
    }
    public function insertar_orden_pago(array $vec) {

        $ins = "INSERT INTO ordenes_pagos ( ";
        $ins.= "op_id, ";
        $ins.= "sucursal_id, ";
        $ins.= "pasla_id, ";

        $ins.= "cliente_id, ";
        $ins.= "op_cliente_denominacion, ";
        $ins.= "op_cliente_domicilio, ";
        $ins.= "tipo_resp_id, ";
        $ins.= "tipo_doc_id, ";
        $ins.= "op_cliente_documento, ";

        $ins.= "op_fecha, ";

        $ins.= "op_neto_0, ";
        $ins.= "op_iva_0, ";
        $ins.= "op_total_0, ";
        $ins.= "op_neto_105, ";
        $ins.= "op_iva_105, ";
        $ins.= "op_total_105, ";
        $ins.= "op_neto_21, ";
        $ins.= "op_iva_21, ";
        $ins.= "op_total_21, ";
        $ins.= "op_neto_27, ";
        $ins.= "op_iva_27, ";
        $ins.= "op_total_27, ";
        $ins.= "op_neto_gravado, ";
        $ins.= "op_iva, ";
        $ins.= "op_neto_no_gravado, ";
        $ins.= "op_neto_exento, ";
        $ins.= "op_total_original, ";
        $ins.= "op_total_desc, ";
        $ins.= "op_total_conceptos, ";
        $ins.= "op_total, ";
        $ins.= "boucher_id, ";

        $ins.= "op_desc_m, ";
        $ins.= "op_desc_p, ";
        $ins.= "op_desc_m_voucher, ";
        $ins.= "op_desc_p_voucher, ";
        $ins.= "op_rec_m, ";
        $ins.= "op_rec_p, ";

        $ins.= "op_observaciones, ";
        $ins.= "op_fecha_alta, ";
        $ins.= "op_usu_alta, ";
        $ins.= "op_estado, ";
        $ins.= "op_estado2, ";
        $ins.= "op_fecha_baja, ";
        $ins.= "op_usu_baja ";

        $ins.= ") VALUES ( ";

        $ins.= "NULL, ";
        $ins.= "'1', ";
        $ins.= "'$vec[pasla_id]', ";

        $ins.= $vec['cliente_id'] != '' && $vec['cliente_id'] > 0 ? "'".$vec['cliente_id']."', " : "NULL, ";
        $ins.= "'".strtoupper($vec['denominacion'])."', ";
        $ins.= "'".strtoupper($vec['domicilio'])."', ";
        $ins.= "'1', ";
        $ins.= "'1', ";
        $ins.= "'".$vec['documento']."', ";

        $ins.= "'".$vec['fecha_referencia']."', ";

        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'".$vec['comp_total_conceptos']."', "; // Comp_Total_Conceptos
        $ins.= "'".$vec['comp_total']."', "; // Comp_Total
        $ins.= "'0.00', ";

        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'0.00', ";
        $ins.= "'".$vec['comp_recargo']."', ";
        $ins.= "'0.00', ";

        $ins.= "'OBSERVACION', ";
        $ins.= "'".$vec['fecha_referencia']."', ";
        $ins.= $_SESSION['sid_usuario_id'].", ";
        $ins.= "'1', ";
        $ins.= "'PE', ";
        $ins.= "NULL, ";
        $ins.= "NULL ";
        $ins.= ") ";

        // $qins = $conn->query($ins) or die(mostrar_error_consulta($conn). 'Error: insertar expediente. SQL: '.$ins);
        // $op_id = $conn->insert_id;

        // return $op_id;
    }

    /**
     * MATIAS [CHANGE]: 2024-07-18
     * Genera el detalle del comprobante cabecera
     * @param array{op_id:int,tipo_cuota_id:int,cuota_id:int,cuota_mes:int,cuota_label_mes:int,cuota_anio:int,monto_total:float} $vec  
     * Vector con los datos usados para generar el detalle del comprobante.
     * - op_id: id del comprabante cabecera.
     * - tipo_cuota_id: id del tipo de cuota.
     * - cuota_id: id de la cuota cobrada.
     * - cuota_mes: numero del mes del cobro.
     * - cuota_label_mes: nombre del mes del cobro.
     * - cuota_anio: anio del cobro.
     * - monto_total: monto total del item
     * @return string Linea cabecera del archivo.
     */
    public function insertar_orden_pago_detalle(array $vec) {

        $json_data = isset($vec['cuota_json_aux']) ? $vec['cuota_json_aux'] : '';

        $insdet ="INSERT INTO ordenes_pagos_detalles ( ";
        $insdet.= "op_det_id, ";			
        $insdet.= "op_id, ";

        $insdet.= "ent_id, ";
        $insdet.= "vou_id, ";
        $insdet.= "vd_id, ";

        $insdet.= "op_det_pucosto_neto, ";
        $insdet.= "op_det_pucosto_iva, ";
        $insdet.= "op_det_pucosto_bruto, ";
        $insdet.= "op_det_puventa_neto, ";
        $insdet.= "op_det_puventa_iva, ";
        $insdet.= "op_det_puventa_total, ";

        $insdet.= "op_det_desc, ";
        $insdet.= "op_det_mto_con_desc, ";

        $insdet.= "op_det_pu_neto, ";
        $insdet.= "op_det_pu_iva, ";
        $insdet.= "op_det_pu_total, ";

        $insdet.= "op_det_desc_porc_voucher, ";
        $insdet.= "op_det_desc_mto_voucher, ";

        $insdet.= "op_det_neto, ";
        $insdet.= "op_det_iva, ";

        $insdet.= "op_det_subtotal, ";

        $insdet.= "rel_comp_id, ";
        $insdet.= "rel_comp_det_id, ";

        $insdet.= "op_det_cuota_json ";

        $insdet.= ") VALUES ( ";

        $insdet.= "NULL, ";
        $insdet.= "'".$vec['op_id']."', ";

        $insdet.= "'".$vec['ent_id']."', ";
        $insdet.= "'".$vec['vou_id']."', ";
        $insdet.= "'".$vec['vd_id']."', ";

        $insdet.= "'0', ";
        $insdet.= "'0', ";
        $insdet.= "'0', ";
        $insdet.= "'0', ";
        $insdet.= "'0', ";
        $insdet.= "'0', ";

        $insdet.= "'0', ";
        $insdet.= "NULL, ";

        $insdet.= "'0', ";
        $insdet.= "'0', ";
        $insdet.= "'0', ";

        $insdet.= "NULL, ";
        $insdet.= "NULL, ";        

        $insdet.= "NULL, ";
        $insdet.= "NULL, ";

        $insdet.= "'".$vec['monto_total']."', ";

        $insdet.= "NULL, ";
        $insdet.= "NULL, ";
        
        $insdet.= "'".$json_data."' )";

        // $qinsdet = $conn->query($insdet) or die(mostrar_error_consulta($conn). 'Error: insertar expediente. SQL: '.$insdet);
        // $opdet_id = $conn->insert_id;
        
        // return $opdet_id;
    }
}
