<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    protected $table = 'etiquetas';
    protected $primaryKey = 'eti_id';

    public $timestamps = false;

    protected $fillable = [
        'eti_nombre',
        'eti_descripcion',
        'eti_fecha_ini',
        'eti_fecha_fin',
        'eti_publico',
        'eti_estado',
    ];
}
