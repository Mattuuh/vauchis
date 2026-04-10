<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'provincias';
    protected $primaryKey = 'provincia_id';

    public $timestamps = false;

    protected $fillable = [
        'pais_is',
        'provincia_nombre',
        'provincia_estado',
    ];
}
