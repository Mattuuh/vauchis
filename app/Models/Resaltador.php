<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resaltador extends Model
{
    protected $table = 'resaltadores';
    protected $primaryKey = 'resal_id';

    public $timestamps = false;

    protected $fillable = [
        'resal_nombre',
        'resal_descripcion',
        'resal_fecha_ini',
        'resal_fecha_fin',
        'resal_publico',
        'resal_estado',
        'resal_estado2',
        'resal_color',
        'resal_img_nombre_legible',
        'resal_img_name',
        'resal_img_path',
        'resal_img_format',
        'resal_img_size',
        'resal_fecha_alta',
        'resal_usu_alta',
        'resal_fecha_mod',
        'resal_usu_mod',
        'resal_fecha_baja',
        'resal_usu_baja ',
    ];

    protected $casts = [
        'resal_fecha_ini' => 'datetime',
        'resal_fecha_fin' => 'datetime',
        'resal_fecha_alta' => 'datetime',
    ];
}
