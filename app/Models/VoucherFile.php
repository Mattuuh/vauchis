<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherFile extends Model
{
    protected $table = 'vouchers_files';
    protected $primaryKey = 'vf_id';

    public $timestamps = false;

    protected $fillable = [
        'vou_id',
        'tipo_archivo_id',
        'vf_img_nombre_legible',
        'vf_img_name',
        'vf_img_path',
        'vf_img_format',
        'vf_img_size',
        'vf_estado',
        'vf_estado2',
        'vf_fecha_alta',
        'vf_usu_alta',
        'vf_fecha_mod',
        'vf_usu_mod',
        'vf_fecha_baja',
        'vf_usu_baja',
    ];

    protected $casts = [
        'vf_fecha_alta' => 'datetime',
        'vf_fecha_mod' => 'datetime',
        'vf_fecha_baja' => 'datetime',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'vou_id');
    }
}
