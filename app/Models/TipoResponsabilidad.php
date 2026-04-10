<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoResponsabilidad extends Model
{
    protected $table = 'tipos_responsables';
    protected $primaryKey = 'tipo_resp_id';

    public $timestamps = false;

    protected $fillable = [
        'tipo_resp_codigo',
        'tipo_resp_nombre',
        'tipo_resp_nombre_codigo',
        'tipo_resp_estado',
    ];
}
