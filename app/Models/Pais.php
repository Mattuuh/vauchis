<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises';
    protected $primaryKey = 'pais_id';

    public $timestamps = false;

    protected $fillable = [
        'pais_nombre',
        'pais_estado',
    ];
}
