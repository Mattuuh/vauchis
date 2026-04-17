<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entidad_domicilio extends Model
{
    protected $table = 'entidades_domicilios';
    protected $primaryKey = 'ed_id';

    public $timestamps = false;

    protected $fillable = [
        'ent_id',
        'ent_nombre_fantasia',
        'ent_nombre',
        'pais_id',
        'provincia_id',
        'ent_ciudad',
        'ent_codigo_postal',
        'ent_barrio',
        'ent_direccion',
        'ent_email1',
        'ent_email2',
        'ent_telefono1',
        'ent_telefono2',
        'ent_latitud',
        'ent_longitud',
        'ent_descripcion_publica',
        'ent_descripcion_interna',
        'ent_estado',
        'ent_estado2',
        'ent_fecha_alta',
        'ent_usu_alta',
        'ent_fecha_mod',
        'ent_usu_mod',
        'ent_fecha_baja',
        'ent_usu_baja',
    ];
}
