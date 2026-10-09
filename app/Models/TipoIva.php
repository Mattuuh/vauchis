<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoIva extends Model
{
    protected $table = 'tipos_iva';
    protected $primaryKey = 'tipo_iva_id';

    public $timestamps = false;

    protected $fillable = [
        'tipo_iva_descripcion',
        'tipo_iva_valor',
        'tipo_iva_estado',
        'tipo_iva_fecha_alta',
        'tipo_iva_usu_alta',
        'tipo_iva_fecha_mod',
        'tipo_iva_usu_mod',
        'tipo_iva_fecha_baja',
        'tipo_iva_usu_baja',
    ];

    protected $casts = [
        'tipo_iva_fecha_alta' => 'datetime',
        'tipo_iva_fecha_mod' => 'datetime',
        'tipo_iva_fecha_baja' => 'datetime',
    ];

}
