<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BibliotecaFondo extends Model
{
    protected $table = 'plantillas_fondos_files';

    protected $primaryKey = 'pf_id';

    public $timestamps = false;

    protected $fillable = [
        'pf_img_nombre_legible',
        'pf_img_name',
        'pf_img_path',
        'pf_img_format',
        'pf_img_size',
        'pf_img_ancho',
        'pf_img_alto',
        'pf_estado',
        'pf_fecha_alta',
        'pf_usu_alta',
        'pf_fecha_mod',
        'pf_usu_mod',
        'pf_fecha_baja',
        'pf_usu_baja',
    ];

    // Relación inversa (opcional)
    public function plantillas()
    {
        return $this->hasMany(VoucherPlantilla::class, 'pf_id');
    }

    // Helper útil para mostrar la imagen
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->ruta);
    }
}
