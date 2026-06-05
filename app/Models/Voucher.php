<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';
    protected $primaryKey = 'vou_id';

    public $timestamps = false;

    protected $fillable = [
        'ent_id',
        'tv_id',
        'cv_id',
        'inf_id',
        'mod_id',
        'vou_nombre',
        'vou_monto_fijo',
        'vou_porcentaje_comision',
        'vou_estado',
        'vou_estado2',
        'vou_fecha_alta',
        'vou_usu_alta',
        'vou_fecha_mod',
        'vou_usu_mod',
        'vou_fecha_baja',
        'vou_usu_baja',
    ];

    protected $casts = [
        'vou_fecha_inicio' => 'datetime',
        'vou_fecha_fin' => 'datetime',
        'vou_fecha_alta' => 'datetime',
        'vou_fecha_mod' => 'datetime',
        'vou_fecha_baja' => 'datetime',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaVoucher::class, 'cv_id', 'cv_id');
    }

    public function modalidad()
    {
        return $this->belongsTo(Modalidad::class, 'mod_id', 'mod_id');
    }

    public function influencer()
    {
        return $this->belongsTo(Influencer::class, 'inf_id', 'inf_id');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'ent_id', 'ent_id');
    }

    public function entidad_domicilio()
    {
        return $this->belongsTo(EntidadDomicilio::class, 'ed_id', 'ed_id');
    }

    public function plantillas()
    {
        return $this->belongsToMany(
            VoucherPlantilla::class,
            'vouchers_plantillas',
            'vou_id',
            'vpl_id'
        )
        ->withPivot([
            'vp_id',
            'vp_principal',
            'vp_estado',
            'vp_fecha_alta',
            'vp_usu_alta',
        ])
        ->wherePivot('vp_estado', 1);
    }

    public function plantillaPrincipal()
    {
        return $this->belongsToMany(
            VoucherPlantilla::class,
            'vouchers_plantillas',
            'vou_id',
            'vpl_id'
        )
        ->withPivot([
            'vp_id',
            'vp_principal',
            'vp_estado',
        ])
        ->wherePivot('vp_estado', 1)
        ->wherePivot('vp_principal', 1);
    }

    public function imagenes()
    {
        return $this->hasMany(VoucherFile::class, 'vou_id', 'vou_id')->where('tipo_archivo_id',1);
    }
}
