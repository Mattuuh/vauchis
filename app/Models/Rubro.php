<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    protected $table = 'rubros';
    protected $primaryKey = 'rub_id';

    public $timestamps = false;

    protected $fillable = [
        'rub_codigo',
        'rub_codigo_alternativo1',
        'rub_codigo_alternativo2',
        'rub_nombre',
        'rub_descripcion',
        'rub_descripcion_corta',
        'rub_estado',
        'rub_estado2',
    ];
}
