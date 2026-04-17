<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModalidadCampo extends Model
{
    protected $table = 'modalidades_campos';
    protected $primaryKey = 'mca_id';

    public $timestamps = false;

    protected $fillable = [
        'mod_id', 
        'mca_nombre', 
        'mca_codigo', 
        'mca_tipo',
        'mca_label',
        'mca_placeholder',
        'mca_requerido',
        'mca_orden',
        'mca_opciones',
        'mca_ayuda',
        'mca_estado',
        'mca_fecha_alta',
        'mca_usu_alta',
        'mca_fecha_mod',
        'mca_usu_mod',
        'mca_fecha_baja',
        'mca_usu_baja',
    ];

    protected $casts = [
        'mca_fecha_alta' => 'datetime',
    ];
}
