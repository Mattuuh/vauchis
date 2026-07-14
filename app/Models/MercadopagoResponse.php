<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MercadopagoResponse extends Model
{
    protected $table = 'mercadopago_response_log';
    protected $primaryKey = 'mpl_id';

    public $timestamps = false;

    protected $fillable = [
        'ent_id',
        'vou_id',
        'cliente_id',
        'preference_data',
        'mpl_get',
        'mpl_post',
        'collection_id',
        'external_reference',
        'merchant_order_id',
        'collection_status',
        'payment_type',
        'mpl_json',
        'mpl_obs',
        'mpl_exec',
        'mpl_usu_alta',
        'mpl_fecha_alta',
        'mpl_fecha_mod',
        'mpl_usu_mod',
        'mpl_fecha_baja',
        'mpl_usu_baja'
    ];

    protected $casts = [
        'mpl_fecha_alta' => 'datetime',
        'mpl_fecha_mod' => 'datetime',
        'mpl_fecha_baja' => 'datetime',
    ];
}
