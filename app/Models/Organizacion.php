<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizacion extends Model
{
    protected $table = 'organizaciones';
    protected $primaryKey = 'org_id';

    public $timestamps = false;

    protected $fillable = [
        'tipo_doc_id',
        'org_documento',
        'org_nombre_fantasia',
        'org_nombre',
        'org_razon_social',
        'pais_id',
        'provincia_id',
        'org_ciudad',
        'org_codigo_postal',
        'org_barrio',
        'org_direccion',
        'org_email1',
        'org_email2',
        'org_telefono1',
        'org_telefono2',
        'org_latitud',
        'org_longitud',
        'org_descripcion_publica',
        'org_descripcion_interna',
        'org_estado',
        'org_estado2',
        'org_fecha_alta',
        'org_usu_alta',
        'org_fecha_mod',
        'org_usu_mod',
        'org_fecha_baja',
        'org_usu_baja',
    ];

    protected $casts = [
        'org_fecha_alta' => 'datetime',
    ];
}
