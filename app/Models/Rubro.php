<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    protected $table = 'rubros';
    protected $primaryKey = 'rub_id';

    public $timestamps = false;

    protected $fillable = [
        'rub_codigo',
        'rub_codigo_alternativo1',
        'rub_codigo_alternativo2',
        'rub_nombre',
        'rub_descripcion',
        'rub_descripcion_corta',
        'rub_estado',
        'rub_estado2',
        'rub_fecha_alta',
        'rub_usu_alta',
        'rub_fecha_mod',
        'rub_usu_mod',
        'rub_fecha_baja',
        'rub_usu_baja',
    ];

    protected $casts = [
        'rub_fecha_alta' => 'datetime',
    ];
}
