<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherModalidadValor extends Model
{
    protected $table = 'vouchers_modalidad_valores';
    protected $primaryKey = 'vmv_id';

    public $timestamps = false;

    protected $fillable = [
        'vou_id',
        'mca_id',
        'vmv_valor',
        'vmv_monto_minimo',
        'vmv_monto_maximo',
        'vmv_monto_fijo',
        'vmv_estado',
        'vmv_fecha_alta',
        'vmv_usu_alta',
        'vmv_fecha_mod',
        'vmv_usu_mod',
        'vmv_fecha_baja',
        'vmv_usu_baja',
    ];

    protected $casts = [
        'vmv_fecha_inicio' => 'datetime',
        'vmv_fecha_fin' => 'datetime',
        'vmv_fecha_alta' => 'datetime',
        'vmv_fecha_mod' => 'datetime',
        'vmv_fecha_baja' => 'datetime',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class,'vou_id','vou_id');
    }

    public function campo()
    {
        return $this->belongsTo(ModalidadCampo::class,'mca_id','mca_id');
    }
}
