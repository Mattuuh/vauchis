<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'usu_id';

    public $timestamps = false;

    protected $fillable = [
        'tu_id',
        'tipo_doc_id',
        'usu_documento',
        'usu_apellido',
        'usu_nombre',
        'usu_nick',
        'usu_clave',
        'usu_codigo_autorizacion',
        'usu_caux',
        'usu_email1',
        'usu_email2',
        'usu_celular1',
        'usu_celular2',
        'usu_telefono1',
        'usu_telefono2',
        'pais_id',
        'provincia_id',
        'ciudad_id',
        'usu_estado',
        'usu_fecha_alta',
        'usu_usu_alta',
        'usu_fecha_mod',
        'usu_usu_mod',
        'usu_fecha_baja',
        'usu_usu_baja',
    ];

    protected $casts = [
        'usu_fecha_alta' => 'datetime',
        'usu_fecha_mod' => 'datetime',
        'usu_fecha_baja' => 'datetime',
    ];

    protected $hidden = [
        'usu_clave',
        'remember_token',
    ];

    public function getAuthPassword(): string
    {
        return $this->usu_clave;
    }
}