<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizacionImagen extends Model
{
    protected $table = 'organizaciones_files';
    protected $primaryKey = 'of_id';

    public $timestamps = false;

    protected $fillable = [
        'org_id',
        'tipo_archivo_id',
        'of_img_nombre_legible',
        'of_img_name',
        'of_img_path',
        'of_img_format',
        'of_img_size',
        'of_principal',
        'of_estado',
        'of_estado2',
        'of_fecha_alta',
        'of_usu_alta',
        'of_fecha_mod',
        'of_usu_mod',
        'of_fecha_baja',
        'of_usu_baja',
    ];

    protected $casts = [
        'of_fecha_alta' => 'datetime',
        'of_fecha_mod' => 'datetime',
        'of_fecha_baja' => 'datetime',
    ];

    public function organizacion()
    {
        return $this->belongsTo(Organizacion::class, 'org_id');
    }
}
