<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    protected $table = 'rubros';
    protected $primaryKey = 'rub_id';

    public $timestamps = false;

    protected $fillable = [
        'cv_id',
        'rub_codigo',
        'rub_codigo_alternativo1',
        'rub_codigo_alternativo2',
        'rub_nombre',
        'rub_descripcion',
        'rub_descripcion_corta',
        'rub_estado',
        'rub_estado2',
        'rub_fecha_alta',
        'rub_usu_alta',
        'rub_fecha_mod',
        'rub_usu_mod',
        'rub_fecha_baja',
        'rub_usu_baja',
    ];

    protected $casts = [
        'rub_fecha_alta' => 'datetime',
    ];

    public function subrubros()
    {
        return $this->hasMany(Subrubro::class, 'rub_id', 'rub_id')->where('sub_estado', 1)->orderBy('sub_nombre');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'cv_id', 'cv_id');
    }

    public function entidades()
    {
        return $this->belongsToMany(
            Entidad::class,
            'entidades_rubros',
            'rub_id',     // FK del rubro en la tabla pivote
            'ent_id'      // FK de la entidad en la tabla pivote
        )->where('er_estado', 1);
    }
}
