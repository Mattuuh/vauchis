<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherPlantilla extends Model
{
    protected $table = 'voucher_plantillas';
    protected $primaryKey = 'vpl_id';
    public $timestamps = false;

    protected $fillable = [
        'pf_id',
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
        'vpl_fecha_alta' => 'datetime',
    ];

    public function emisiones()
    {
        return $this->hasMany(VoucherEmision::class, 'vpl_id', 'vpl_id');
    }

    public function vouchers()
    {
        return $this->belongsToMany(
            Voucher::class,
            'vouchers_plantillas',
            'vpl_id',
            'vou_id'
        )
        ->withPivot([
            'vp_id',
            'vp_principal',
            'vp_estado',
            'vp_fecha_alta',
            'vp_usu_alta',
        ]);
    }

    public function imagen()
    {
        return $this->belongsTo(BibliotecaFondo::class, 'pf_id');
    }
}