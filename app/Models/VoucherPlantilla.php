<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherPlantilla extends Model
{
    protected $table = 'voucher_plantillas';
    protected $primaryKey = 'vpl_id';
    public $timestamps = false;

    protected $fillable = [
        'vpl_nombre',
        'vpl_descripcion',
        'vpl_ancho',
        'vpl_alto',
        'vpl_fondo_path',
        'vpl_config_json',
        'vpl_preview_path',
        'vpl_estado',
        'vpl_fecha_alta',
        'vpl_fecha_mod',
        'vpl_usu_alta',
        'vpl_usu_mod',
    ];

    protected $casts = [
        'vpl_config_json' => 'array',
    ];

    public function emisiones()
    {
        return $this->hasMany(VoucherEmision::class, 'vpl_id', 'vpl_id');
    }
}