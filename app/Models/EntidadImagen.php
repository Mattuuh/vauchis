<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntidadImagen extends Model
{
    protected $table = 'entidades_files';
    protected $primaryKey = 'ef_id';

    public $timestamps = false;

    protected $fillable = [
        'ent_id',
        'ef_img_nombre_legible',
        'ef_img_name',
        'ef_img_path',
        'ef_img_format',
        'ef_img_size',
        'ef_principal',
        'ef_estado',
        'ef_estado2',
        'ef_fecha_alta',
        'ef_usu_alta',
        'ef_fecha_mod',
        'ef_usu_mod',
        'ef_fecha_baja',
        'ef_usu_baja',
    ];

    protected $casts = [
        'ef_fecha_alta' => 'datetime',
    ];

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'ent_id');
    }
}
