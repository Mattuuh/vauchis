<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subrubro extends Model
{
    protected $table = 'subrubros';
    protected $primaryKey = 'sub_id';

    public $timestamps = false;

    protected $fillable = [
        'rub_id',
        'sub_codigo',
        'sub_orden',
        'sub_nombre',
        'sub_estado',
        'sub_estado2',
        'sub_fecha_alta',
        'sub_usu_alta',
        'sub_fecha_mod',
        'sub_usu_mod',
        'sub_fecha_baja',
        'sub_usu_baja',
    ];

    protected $casts = [
        'sub_fecha_alta' => 'datetime',
        'sub_fecha_mod' => 'datetime',
        'sub_fecha_baja' => 'datetime',
    ];

    public function rubro()
    {
        return $this->belongsTo(Rubro::class, 'rub_id', 'rub_id');
    }

    public function entidades()
    {
        return $this->belongsToMany(
            Entidad::class,
            'entidades_subrubros',
            'sub_id',
            'ent_id'
        )->withPivot('rub_id');
    }
}
