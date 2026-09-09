<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coleccion extends Model
{
    protected $table = 'colecciones';
    protected $primaryKey = 'colecc_id';

    public $timestamps = false;

    protected $fillable = [
        'colecc_nombre_interno',
        'colecc_nombre',
        'colecc_descripcion',
        'colecc_fecha_ini',
        'colecc_fecha_fin',
        'colecc_publico',
        'colecc_estado',
        'colecc_estado2',
        'colecc_color',
        'colecc_color_fondo',
        'colecc_fecha_alta',
        'colecc_usu_alta',
        'colecc_fecha_mod',
        'colecc_usu_mod',
        'colecc_fecha_baja',
        'colecc_usu_baja ',
    ];

    protected $casts = [
        'colecc_fecha_ini' => 'datetime',
        'colecc_fecha_fin' => 'datetime',
        'colecc_fecha_alta' => 'datetime',
    ];

    public function imagenes()
    {
        return $this->hasMany(ColeccionFile::class, 'colecc_id', 'colecc_id')->where('cf_estado', 1);
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(ColeccionFile::class, 'colecc_id')->where('cf_principal', 1)->where('tipo_archivo_id',2);
    }

    public function logoPrincipal()
    {
        return $this->hasOne(ColeccionFile::class, 'colecc_id')->where('cf_principal', 1)->where('tipo_archivo_id',1);
    }
}
