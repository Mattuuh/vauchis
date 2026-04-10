<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subrubro extends Model
{
    protected $table = 'subrubros';
    protected $primaryKey = 'sub_id';

    public $timestamps = false;

    protected $fillable = [
        'rub_id',
        'sub_codigo',
        'sub_nombre',
        'sub_estado',
        'sub_estado2',
    ];
}
