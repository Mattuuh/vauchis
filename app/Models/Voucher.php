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
        'vou_fecha_alta' => 'datetime',
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
        return $this->belongsTo(Entidad_domicilio::class, 'ed_id', 'ed_id');
    }
}
