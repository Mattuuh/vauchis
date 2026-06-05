<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherDetalle extends Model
{
    protected $table = 'vouchers_detalles';
    protected $primaryKey = 'vd_id';

    public $timestamps = false;

    protected $fillable = [
        'vou_id',
        'ent_id',
        'cli_id',
        'vd_codigo_interno',
        'vd_codigo',
        'vd_secuencia',
        'vd_variante_nombre',
        'vd_variante_descripcion',
        'vd_monto_total',
        'vd_estado',
        'vd_estado2',
        'vd_estado3',
        'vd_fecha_alta',
        'vd_usu_alta',
        'vd_fecha_mod',
        'vd_usu_mod',
        'vd_fecha_baja',
        'vd_usu_baja',
    ];
}
