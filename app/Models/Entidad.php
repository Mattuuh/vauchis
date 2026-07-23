<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    protected $table = 'entidades';
    protected $primaryKey = 'ent_id';

    public $timestamps = false;

    protected $fillable = [
        'tr_id',
        'tipo_ent_id',
        'tipo_resp_id',
        'tipo_doc_id',
        'ent_documento',
        'ent_nombre_fantasia',
        'ent_nombre',
        'ent_razon_social',
        'ent_logo_url',
        'ent_portada_url',
        'ent_domicilio_fiscal',
        'ent_instagram',
        'ent_tiktok',
        'ent_estado',
        'ent_estado2',
        'ent_fecha_alta',
        'ent_usu_alta',
        'ent_fecha_mod',
        'ent_usu_mod',
        'ent_fecha_baja',
        'ent_usu_baja',
        'mp_user_id',
        'mp_access_token',
        'mp_refresh_token',
        'mp_public_key'
    ];

    protected $casts = [
        'ent_fecha_alta' => 'datetime',
    ];

    public function tipo_entidad()
    {
        return $this->belongsTo(TipoEntidad::class, 'tipo_ent_id', 'tipo_ent_id');
    }

    public function tipo_responsabilidad()
    {
        return $this->belongsTo(TipoResponsabilidad::class, 'tipo_resp_id', 'tipo_resp_id');
    }

    public function domicilios()
    {
        return $this->hasMany(EntidadDomicilio::class, 'ent_id', 'ent_id')->where('ed_estado', 1);
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class, 'ent_id', 'ent_id');
    }

    public function vouchersActivos()
    {
        return $this->hasMany(Voucher::class, 'ent_id', 'ent_id')
            ->where('vou_estado', 1);
    }

    public function organizacion()
    {
        return $this->belongsTo(Organizacion::class, 'org_id');
    }
    
    public function imagenes()
    {
        return $this->hasMany(EntidadImagen::class, 'ent_id', 'ent_id')->where('ef_estado', 1);
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(EntidadImagen::class, 'ent_id')->where('ef_principal', 1)->where('tipo_archivo_id',2);
    }

    public function logoPrincipal()
    {
        return $this->hasOne(EntidadImagen::class, 'ent_id')->where('ef_principal', 1)->where('tipo_archivo_id',1);
    }

    public function rubros()
    {
        return $this->belongsToMany(
            Rubro::class,
            'entidades_rubros',
            'ent_id',     // FK de la entidad en la tabla pivote
            'rub_id'      // FK del rubro en la tabla pivote
        )->where('er_principal', 1);
    }

    public function subrubros()
    {
        return $this->belongsToMany(
            Subrubro::class,
            'entidades_subrubros',
            'ent_id',
            'sub_id'
        )->withPivot('rub_id');
    }
}
