<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modalidad extends Model
{
    protected $table = 'modalidades';
    protected $primaryKey = 'mod_id';

    public $timestamps = false;

    protected $fillable = [
        'mod_nombre',
        'mod_codigo',
        'mod_descripcion',
        'mod_estado',
        'mod_fecha_alta',
        'mod_usu_alta',
        'mod_fecha_mod',
        'mod_usu_mod',
        'mod_fecha_baja',
        'mod_usu_baja',
    ];

    protected $casts = [
        'mod_fecha_alta' => 'datetime',
    ];

    public function campos()
    {
        return $this->hasMany(ModalidadCampo::class, 'mod_id', 'mod_id');
    }
}
