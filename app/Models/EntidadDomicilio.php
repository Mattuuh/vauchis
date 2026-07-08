<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntidadDomicilio extends Model
{
    protected $table = 'entidades_domicilios';
    protected $primaryKey = 'ed_id';

    public $timestamps = false;

    protected $fillable = [
        'ent_id',
        'ed_nombre_fantasia',
        'ed_nombre',
        'pais_id',
        'provincia_id',
        'ed_ciudad',
        'ed_codigo_postal',
        'ed_barrio',
        'ed_direccion',
        'ed_email1',
        'ed_email2',
        'ed_telefono1',
        'ed_telefono2',
        'ed_latitud',
        'ed_longitud',
        'ed_descripcion_publica',
        'ed_descripcion_interna',
        'ed_estado',
        'ed_estado2',
        'ed_fecha_alta',
        'ed_usu_alta',
        'ed_fecha_mod',
        'ed_usu_mod',
        'ed_fecha_baja',
        'ed_usu_baja',
    ];

    public function organizacion()
    {
        return $this->belongsTo(Organizacion::class, 'org_id', 'org_id');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'ent_id', 'ent_id');
    }
}
