<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    protected $table = 'entidades';
    protected $primaryKey = 'ent_id';

    public $timestamps = false;

    protected $fillable = [
        'tr_id',
        'tipo_ent_id',
        'tipo_resp_id',
        'tipo_doc_id',
        'ent_documento',
        'ent_nombre_fantasia',
        'ent_nombre',
        'ent_razon_social',
        'ent_logo_url',
        'ent_portada_url',
        'ent_estado',
        'ent_estado2',
        'ent_fecha_alta',
        'ent_usu_alta',
        'ent_fecha_mod',
        'ent_usu_mod',
        'ent_fecha_baja',
        'ent_usu_baja',
    ];

    protected $casts = [
        'ent_fecha_alta' => 'datetime',
    ];

    public function tipo_entidad()
    {
        return $this->belongsTo(TipoEntidad::class, 'tipo_ent_id', 'tipo_ent_id');
    }

    public function tipo_responsabilidad()
    {
        return $this->belongsTo(TipoResponsabilidad::class, 'tipo_resp_id', 'tipo_resp_id');
    }
}
