<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntidadLogo extends Model
{
    protected $table = 'entidades_logos';
    protected $primaryKey = 'ef_id';

    public $timestamps = false;

    protected $fillable = [
        'ent_id',
        'ef_id',
        'el_principal',
        'el_estado',
        'el_fecha_alta',
        'el_usu_alta',
        'el_fecha_mod',
        'el_usu_mod',
        'el_fecha_baja',
        'el_usu_baja',
    ];

    protected $casts = [
        'el_fecha_alta' => 'datetime',
    ];

    public function imagen()
    {
        return $this->belongsTo(
            EntidadImagen::class,
            'el_id', // FK en entidad_logos
            'ef_id'     // PK en entidad_imagenes
        );
    }
}
