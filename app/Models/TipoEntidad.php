<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEntidad extends Model
{
    protected $table = 'tipos_entidades';
    protected $primaryKey = 'tipo_ent_id';

    public $timestamps = false;

    protected $fillable = [
        'tipo_ent_nombre',
        'tipo_ent_observacion',
        'tipo_ent_fecha_alta',
        'tipo_ent_usu_alta',
    ];

    protected $casts = [
        'tipo_ent_fecha_alta' => 'datetime',
    ];
}