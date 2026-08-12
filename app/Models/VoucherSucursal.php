<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherSucursal extends Model
{
    protected $table = 'vouchers_sucursales';
    protected $primaryKey = 'vou_suc_id';

    public $timestamps = false;

    protected $fillable = [
        'vou_id',
        'ed_id',
        'vou_suc_notas',
        'vou_suc_estado',
        'vou_suc_estado2',
        'vou_suc_fecha_alta',
        'vou_suc_usu_alta',
        'vou_suc_fecha_mod',
        'vou_suc_usu_mod',
        'vou_suc_fecha_baja',
        'vou_suc_usu_baja',
    ];

    protected $casts = [
        'vou_suc_fecha_alta' => 'datetime',
        'vou_suc_fecha_mod' => 'datetime',
        'vou_suc_fecha_baja' => 'datetime',
    ];
}
