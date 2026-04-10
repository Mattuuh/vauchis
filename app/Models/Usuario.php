<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';

    protected $fillable = [
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