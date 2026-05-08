<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfluencerImagen extends Model
{
    protected $table = 'influencers_files';
    protected $primaryKey = 'if_id';

    public $timestamps = false;

    protected $fillable = [
        'inf_id',
        'if_img_nombre_legible',
        'if_img_name',
        'if_img_path',
        'if_img_format',
        'if_img_size',
        'if_publico',
        'if_estado',
        'if_estado2',
        'if_fecha_alta',
        'if_usu_alta',
        'if_fecha_mod',
        'if_usu_mod',
        'if_fecha_baja',
        'if_usu_baja',
    ];

    protected $casts = [
        'if_fecha_alta' => 'datetime',
        'if_fecha_mod' => 'datetime',
        'if_fecha_baja' => 'datetime',
    ];

    public function influencer()
    {
        return $this->belongsTo(Influencer::class, 'inf_id');
    }
}
