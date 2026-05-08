<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    protected $table = 'influencers';
    protected $primaryKey = 'inf_id';

    public $timestamps = false;

    protected $fillable = [
        'tipo_doc_id',
        'inf_documento',
        'inf_nombre',
        'inf_apellido',
        'inf_nombre_fantasia',
        'pais_id',
        'provincia_id',
        'inf_ciudad',
        'inf_instagram',
        'inf_facebook',
        'inf_whatsapp',
        'inf_tiktok',
        'inf_x',
        'inf_email1',
        'inf_email2',
        // 'inf_telefono1',
        // 'inf_telefono2',
        'inf_descripcion_publica',
        'inf_descripcion_interna',
        'inf_estado',
        'inf_estado2',
        'inf_fecha_alta',
        'inf_usu_alta',
        'inf_fecha_mod',
        'inf_usu_mod',
        'inf_fecha_baja',
        'inf_usu_baja',
    ];

    protected $casts = [
        'inf_fecha_alta' => 'datetime',
    ];

    public function imagenes()
    {
        return $this->hasMany(InfluencerImagen::class, 'inf_id', 'inf_id')
            ->where('if_estado', 1);
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(InfluencerImagen::class, 'inf_id')->where('if_principal', 1);
    }
}
