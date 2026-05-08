<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    protected $table = 'etiquetas';
    protected $primaryKey = 'eti_id';

    public $timestamps = false;

    protected $fillable = [
        'eti_nombre',
        'eti_descripcion',
        'eti_fecha_ini',
        'eti_fecha_fin',
        'eti_publico',
        'eti_estado',
        'eti_fecha_alta',
        'eti_usu_alta',
        'eti_fecha_mod',
        'eti_usu_mod',
        'eti_fecha_baja',
        'eti_usu_baja',
    ];

    protected $casts = [
        'eti_fecha_ini' => 'datetime',
        'eti_fecha_fin' => 'datetime',
        'eti_fecha_alta' => 'datetime',
    ];
}
