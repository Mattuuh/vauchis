<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipos_documentos';
    protected $primaryKey = 'tipo_doc_id';

    public $timestamps = false;

    protected $fillable = [
        'tipo_doc_nombre',
        'tipo_doc_estado',
    ];
}
