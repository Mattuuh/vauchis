<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColeccionFile extends Model
{
    protected $table = 'colecciones_files';
    protected $primaryKey = 'cf_id';

    public $timestamps = false;

    protected $fillable = [
        'colecc_id',
        'tipo_archivo_id',
        'cf_img_nombre_legible',
        'cf_img_name',
        'cf_img_path',
        'cf_img_format',
        'cf_img_size',
        'cf_principal',
        'cf_estado',
        'cf_estado2',
        'cf_fecha_alta',
        'cf_usu_alta',
        'cf_fecha_mod',
        'cf_usu_mod',
        'cf_fecha_baja',
        'cf_usu_baja',
    ];

    protected $casts = [
        'cf_fecha_alta' => 'datetime',
        'cf_fecha_mod' => 'datetime',
        'cf_fecha_baja' => 'datetime',
    ];

    public function coleccion()
    {
        return $this->belongsTo(Coleccion::class, 'colecc_id');
    }
}
