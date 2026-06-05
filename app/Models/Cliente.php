<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'cliente_id';

    public $timestamps = false;

    protected $fillable = [
        'tipo_doc_id',
        'cliente_documento',
        'cliente_apellido',
        'cliente_nombre',
        'cliente_email1',
        'cliente_email2',
        'cliente_celular1',
        'cliente_celular2',
        'cliente_telefono1',
        'cliente_telefono2',
        'pais_id',
        'provincia_id',
        'ciudad_id',
        'cliente_email_verificado',
        'cliente_celular_verificado',
        'cliente_acepta_marketing',
        'cliente_notas',
        'cliente_estado',
        'cliente_estado2',
        'cliente_fecha_alta',
        'cliente_usu_alta',
        'cliente_fecha_mod',
        'cliente_usu_mod',
        'cliente_fecha_baja',
        'cliente_usu_baja',
    ];

    protected $casts = [
        'cliente_fecha_alta' => 'datetime',
        'cliente_fecha_mod' => 'datetime',
        'cliente_fecha_baja' => 'datetime',
    ];
}
