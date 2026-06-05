<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{

    protected $table = 'accesos_web';
    protected $primaryKey = 'acc_web_id';

    public $timestamps = false;

    protected $fillable = [
        'acc_web_id',
        'usu_web_id',
        'usu_web_nick',
        'acc_web_sesion_id',
        'acc_web_login_fecha',
        'acc_web_logout_fecha',
        'acc_web_ip',
        'acc_web_observacion',
        'acc_web_browser',
        'acc_web_fecha_alta',
    ];

    protected $casts = [
        'acc_web_login_fecha' => 'datetime',
        'acc_web_logout_fecha' => 'datetime',
        'acc_web_fecha_alta' => 'datetime',
    ];
}
