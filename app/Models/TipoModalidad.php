<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoModalidad extends Model
{
    protected $table = 'tipos_modalidades';
    protected $primaryKey = 'tipo_mod_id';

    public $timestamps = false;

    protected $fillable = [
        'tipo_mod_nombre',
        'tipo_mod_descripcion',
        'tipo_mod_condiciones',
        'tipo_mod_estado',
        'tipo_mod_estado2',
        'tipo_mod_fecha_alta',
        'tipo_mod_usu_alta',
        'tipo_mod_fecha_mod',
        'tipo_mod_usu_mod',
        'tipo_mod_fecha_baja',
        'tipo_mod_usu_baja',
    ];

    protected $casts = [
        'tipo_mod_fecha_alta' => 'datetime',
        'tipo_mod_fecha_mod' => 'datetime',
        'tipo_mod_fecha_baja' => 'datetime',
    ];
}
