<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoArchivo extends Model
{
    protected $table = 'tipos_archivos';
    protected $primaryKey = 'tipo_archivo_id';

    public $timestamps = false;

    protected $fillable = [
        'tipo_archivo_nombre',
        'tipo_archivo_observacion',
        'tipo_archivo_fecha_alta',
        'tipo_archivo_usu_alta',
        'tipo_archivo_fecha_mod',
        'tipo_archivo_usu_mod',
        'tipo_archivo_fecha_baja',
        'tipo_archivo_usu_baja',
    ];

    protected $casts = [
        'tipo_archivo_fecha_alta' => 'datetime',
        'tipo_archivo_fecha_mod' => 'datetime',
        'tipo_archivo_fecha_baja' => 'datetime',
    ];
}
