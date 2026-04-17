<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaVoucher extends Model
{
    protected $table = 'categorias_vouchers';
    protected $primaryKey = 'cv_id';

    public $timestamps = false;

    protected $fillable = [
        'cv_nombre',
        'cv_estado',
        'cv_fecha_alta',
        'cv_usu_alta',
        'cv_fecha_mod',
        'cv_usu_mod',
        'cv_fecha_baja',
        'cv_usu_baja',
    ];

    protected $casts = [
        'cv_fecha_alta' => 'datetime',
    ];
}
