<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizacion extends Model
{
    protected $table = 'organizaciones';
    protected $primaryKey = 'org_id';

    public $timestamps = false;

    protected $fillable = [
        'tipo_doc_id',
        'org_documento',
        'org_nombre_fantasia',
        'org_nombre',
        'org_razon_social',
        'pais_id',
        'provincia_id',
        'org_ciudad',
        'org_codigo_postal',
        'org_barrio',
        'org_direccion',
        'org_email1',
        'org_email2',
        'org_telefono1',
        'org_telefono2',
        'org_latitud',
        'org_longitud',
        'org_descripcion_publica',
        'org_descripcion_interna',
        'org_img_nombre_legible',
        'org_img_name',
        'org_img_path',
        'org_img_format',
        'org_img_size',
        'org_color_fondo',
        'org_publico',
        'org_estado',
        'org_estado2',
        'org_fecha_alta',
        'org_usu_alta',
        'org_fecha_mod',
        'org_usu_mod',
        'org_fecha_baja',
        'org_usu_baja',
    ];

    protected $casts = [
        'org_fecha_alta' => 'datetime',
    ];

    public function domicilios()
    {
        return $this->hasMany(EntidadDomicilio::class, 'org_id', 'org_id');
    }

    public function imagenes()
    {
        return $this->hasMany(OrganizacionImagen::class, 'org_id', 'org_id')->where('of_estado', 1);
    }

    public function imagenPrincipal()
    {
        return $this->hasOne(OrganizacionImagen::class, 'org_id')->where('of_principal', 1)->where('tipo_archivo_id',2);
    }

    public function logoPrincipal()
    {
        return $this->hasOne(OrganizacionImagen::class, 'org_id')->where('of_principal', 1)->where('tipo_archivo_id',1);
    }
}
