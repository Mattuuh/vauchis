<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenPago extends Model
{
    protected $table = 'ordenes_pagos';
    protected $primaryKey = 'op_id';

    public $timestamps = false;

    protected $fillable = [
        'sucursal_id',
        'caja_id',
        'pasla_id',
        'ent_id',
        'vou_id',
        'cliente_id',
        'op_cliente_denominacion',
        'op_cliente_domicilio',
        'tipo_resp_id',
        'tipo_doc_id',
        'op_cliente_documento',
        'op_fecha',
        'tipo_comp_id',
        'ptovta_id',
        'op_numero',
        'op_neto_0',
        'op_iva_0',
        'op_total_0',
        'op_neto_105',
        'op_iva_105',
        'op_total_105',
        'op_neto_21',
        'op_iva_21',
        'op_total_21',
        'op_neto_27',
        'op_iva_27',
        'op_total_27',
        'op_neto_gravado',
        'op_iva',
        'op_neto_no_gravado',
        'op_neto_exento',
        'op_total_original',
        'op_total_desc',
        'op_total',
        'op_total_conceptos',
        'boucher_id',
        'op_desc_m',
        'op_desc_p',
        'op_desc_m_voucher',
        'op_desc_p_voucher',
        'op_rec_m',
        'op_rec_p',
        'op_observaciones',
        'op_observaciones_internas',
        'op_estado',
        'op_estado2',
        'op_estado3',
        'op_ref_id_pago',
        'op_fecha_pago',
        'op_ref_pago',
        'op_fecha_alta',
        'op_usu_alta',
        'op_fecha_mod',
        'op_usu_mod',
        'op_fecha_baja',
        'op_usu_baja',
    ];

    protected $casts = [
        'op_fecha_alta' => 'datetime',
        'op_fecha_mod' => 'datetime',
        'op_fecha_baja' => 'datetime',
    ];
}
